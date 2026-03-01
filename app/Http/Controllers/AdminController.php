<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LogAktivitas;
use App\Models\Pendaftaran;
use App\Models\UserNotification;
use App\Models\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | AKUN
    |--------------------------------------------------------------------------
    */

    public function akun(Request $request)
    {
        $search = $request->search;
        $role   = $request->role;

        $users = User::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%");
                });
            })
            ->when($role, function ($query) use ($role) {
                $query->where('role', $role);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.akun.akun', compact('users'));
    }

    public function storeAkun(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'nik'      => 'required|string|unique:users,nik',
            'password' => 'required|min:8',
            'role'     => 'required|string'
        ]);

        User::create([
            'name'     => $request->name,
            'nik'      => $request->nik,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'status'   => 'approved'
        ]);

 return redirect()->route('admin.akun')
        ->with('success', 'Akun berhasil ditambahkan');
}
    public function deleteAkun($id)
    {
        if (auth()->id() == $id) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri');
        }

        User::findOrFail($id)->delete();

        return back()->with('success', 'Akun berhasil dihapus');
    }

    public function createAkun()
{
    return view('admin.akun.create-akun');
}



    /*
    |--------------------------------------------------------------------------
    | VALIDASI USER
    |--------------------------------------------------------------------------
    */

    public function validasi()
    {
        $users = User::where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.validasi', compact('users'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'approved']);

        LogAktivitas::create([
            'user_id'   => Auth::id(),
            'aksi'      => 'Approve User',
            'deskripsi' => 'Menyetujui akun: ' . $user->name
        ]);

        return back()->with('success', 'User berhasil disetujui');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'rejected']);

        LogAktivitas::create([
            'user_id'   => Auth::id(),
            'aksi'      => 'Reject User',
            'deskripsi' => 'Menolak akun: ' . $user->name
        ]);

        return back()->with('success', 'User berhasil ditolak');
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS PENDAFTARAN
    |--------------------------------------------------------------------------
    */

    public function updateStatusPendaftaran($id, $status)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        $allowedStatus = [
            'pending',
            'verifikasi',
            'survey',
            'penetapan',
            'diterima',
            'ditolak'
        ];

        if (!in_array($status, $allowedStatus)) {
            return back()->with('error', 'Status tidak valid');
        }

        $pendaftaran->status_berkas = $status;

        // Timestamp otomatis sesuai status
        $pendaftaran->{$status . '_at'} = now();

        $pendaftaran->save();

        UserNotification::create([
            'user_id' => $pendaftaran->user_id,
            'title'   => 'Update Status Beasiswa',
            'message' => 'Status Anda sekarang: ' . strtoupper($status),
            'is_read' => false
        ]);

        LogAktivitas::create([
            'user_id'   => Auth::id(),
            'aksi'      => 'Update Status Beasiswa',
            'deskripsi' => 'Mengubah status user ID '
                . $pendaftaran->user_id .
                ' menjadi ' . $status
        ]);

        return back()->with('success', 'Status berhasil diperbarui');
    }


    /*
    |--------------------------------------------------------------------------
    | PENGATURAN PERIODE SETORAN
    |--------------------------------------------------------------------------
    */

    public function pengaturan()
    {
        $setting = Setting::first();

        if (!$setting) {
            $setting = Setting::create([
                'setoran_mulai'   => now(),
                'setoran_selesai' => now()->addDays(7),
            ]);
        }

        return view('admin.pengaturan', compact('setting'));
    }

    public function updatePengaturan(Request $request)
    {
        $request->validate([
            'setoran_mulai'   => 'required|date',
            'setoran_selesai' => 'required|date|after_or_equal:setoran_mulai',
        ]);

        $setting = Setting::first();

        if (!$setting) {
            $setting = new Setting();
        }

        $setting->setoran_mulai   = $request->setoran_mulai;
        $setting->setoran_selesai = $request->setoran_selesai;
        $setting->save();

        LogAktivitas::create([
            'user_id'   => Auth::id(),
            'aksi'      => 'Update Pengaturan Setoran',
            'deskripsi' => 'Mengubah periode setoran menjadi '
                . $request->setoran_mulai . ' - ' . $request->setoran_selesai
        ]);

        return back()->with('success','Pengaturan berhasil diperbarui.');
    }


    /*
    |--------------------------------------------------------------------------
    | REMINDER WHATSAPP (N8N)
    |--------------------------------------------------------------------------
    */
public function kirimReminder()
{
    $setting = Setting::first();

    if (!$setting || !now()->between($setting->setoran_mulai, $setting->setoran_selesai)) {
        return back()->with('error', 'Periode setoran tidak aktif.');
    }

    $webhookUrl = env('N8N_WEBHOOK_URL');

    if (!$webhookUrl) {
        return back()->with('error', 'Webhook URL belum diset di .env');
    }

    $pendaftarans = Pendaftaran::where('status_berkas', 'diterima')
        ->whereNotNull('no_hp')
        ->get();

    if ($pendaftarans->isEmpty()) {
        return back()->with('error', 'Tidak ada data penerima.');
    }

    $berhasil = 0;
    $gagal = [];

    foreach ($pendaftarans as $pendaftaran) {

        // Normalisasi nomor
        $number = preg_replace('/[^0-9]/', '', $pendaftaran->no_hp);

        if (substr($number, 0, 1) == '0') {
            $number = '62' . substr($number, 1);
        }

        try {

            $response = Http::timeout(20)
                ->acceptJson()
                ->post($webhookUrl, [
                    'number'  => $number,
                    'message' => "Assalamu'alaikum, jangan lupa setor hafalan ya 😊"
                ]);

            if ($response->successful()) {
                $berhasil++;
            } else {
                $gagal[] = $number;
                Log::error('Gagal kirim WA', [
                    'number' => $number,
                    'status' => $response->status(),
                    'body'   => $response->body()
                ]);
            }

            // 🔥 Delay 1 detik supaya tidak spam device
            sleep(1);

        } catch (\Exception $e) {

            $gagal[] = $number;

            Log::error('Exception kirim WA', [
                'number' => $number,
                'error'  => $e->getMessage()
            ]);
        }
    }

    if (count($gagal) > 0) {
        return back()->with(
            'warning',
            "Berhasil: {$berhasil} | Gagal: " . implode(', ', $gagal)
        );
    }

    return back()->with('success', "Reminder berhasil dikirim ke {$berhasil} penerima.");
}

    /*
    |--------------------------------------------------------------------------
    | EDIT PROFIL
    |--------------------------------------------------------------------------
    */

    public function editProfile()
    {
        return view('admin.profile.edit');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'password' => 'nullable|min:8|confirmed'
        ]);

        $user = Auth::user();
        $user->name = $request->name;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        LogAktivitas::create([
            'user_id'   => Auth::id(),
            'aksi'      => 'Update Profil',
            'deskripsi' => 'Mengubah profil sendiri'
        ]);

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}