<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembinaan;
use App\Models\Pendaftaran;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD USER
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | DATA KEHADIRAN
        |--------------------------------------------------------------------------
        */
        $hadir = Pembinaan::where('user_id', $user->id)
            ->where('hadir_status', 'hadir')
            ->count();

        $alpa = Pembinaan::where('user_id', $user->id)
            ->where('hadir_status', 'alpa')
            ->count();

        $izin = Pembinaan::where('user_id', $user->id)
            ->where('hadir_status', 'izin')
            ->count();

        $sakit = Pembinaan::where('user_id', $user->id)
            ->where('hadir_status', 'sakit')
            ->count();

        $totalHafalan = Pembinaan::where('user_id', $user->id)->count();

        $jumlahPenerimaan = Pembinaan::where('user_id', $user->id)
            ->where('status_pencairan', 'sudah')
            ->count();

        $setoranBulanIni = Pembinaan::where('user_id', $user->id)
            ->whereMonth('tanggal_setor', now()->month)
            ->whereYear('tanggal_setor', now()->year)
            ->exists();

        /*
        |--------------------------------------------------------------------------
        | DATA GRAFIK
        |--------------------------------------------------------------------------
        */
        $chartData = Pembinaan::where('user_id', $user->id)
            ->select(
                DB::raw('MONTH(tanggal_setor) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        $labels = [];
        $dataChart = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->format('M');
            $dataChart[] = $chartData[$i] ?? 0;
        }

        /*
        |--------------------------------------------------------------------------
        | PERIODE SETORAN
        |--------------------------------------------------------------------------
        */
        $setting = Setting::first();

        $tanggalMulai = $setting?->setoran_mulai
            ? Carbon::parse($setting->setoran_mulai)
            : null;

        $tanggalSelesai = $setting?->setoran_selesai
            ? Carbon::parse($setting->setoran_selesai)
            : null;

        $periodeAktif = false;

        if ($tanggalMulai && $tanggalSelesai) {
            $periodeAktif = now()->between($tanggalMulai, $tanggalSelesai);
        }

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */
        return view('user.dashboard', compact(
            'hadir',
            'alpa',
            'izin',
            'sakit',
            'totalHafalan',
            'jumlahPenerimaan',
            'setoranBulanIni',
            'labels',
            'dataChart',
            'tanggalMulai',
            'tanggalSelesai',
            'periodeAktif'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | PEMBINAAN USER
    |--------------------------------------------------------------------------
    */
    public function pembinaan()
    {
        $data = Pembinaan::where('user_id', auth()->id())
            ->orderBy('tanggal_setor', 'desc')
            ->get();

        return view('user.pembinaan', compact('data'));
    }

    /*
    |--------------------------------------------------------------------------
    | PENDAFTARAN
    |--------------------------------------------------------------------------
    */
    public function pendaftaran()
    {
        $pendaftaran = $this->getUserPendaftaran();
        return view('user.pendaftaran', compact('pendaftaran'));
    }

    public function storePendaftaran(Request $request)
    {
        
        if ($this->getUserPendaftaran()) {
            return back()->with('error', 'Anda sudah pernah mendaftar.');
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir'=> 'required|date',
            'jenis_kelamin'=> 'required|string',
            'nim_nisn'     => 'required|string|max:50',
            'no_hp'        => 'required|string|max:20',
            'alamat'       => 'required|string',

            'ktp'               => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kk'                => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'surat_tidak_mampu' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'surat_aktif'       => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'rapor_khs'         => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'surat_berakhlak'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'surat_ibadah'      => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        Pendaftaran::create([
            'user_id'        => auth()->id(),
            'nama_lengkap'   => $request->nama_lengkap,
            'tempat_lahir'   => $request->tempat_lahir,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'nim_nisn'       => $request->nim_nisn,
            'no_hp'          => $request->no_hp,
            'alamat'         => $request->alamat,

            'ktp'               => $request->file('ktp')->store('pendaftaran','public'),
            'kk'                => $request->file('kk')->store('pendaftaran','public'),
            'surat_tidak_mampu' => $request->file('surat_tidak_mampu')->store('pendaftaran','public'),
            'surat_aktif'       => $request->file('surat_aktif')->store('pendaftaran','public'),
            'rapor_khs'         => $request->file('rapor_khs')->store('pendaftaran','public'),
            'surat_berakhlak'   => $request->file('surat_berakhlak')->store('pendaftaran','public'),
            'surat_ibadah'      => $request->file('surat_ibadah')->store('pendaftaran','public'),

            'status_berkas' => 'pending',
            'surat_pernyataan' => 0
        ]);

        return redirect()
            ->route('user.status')
            ->with('success', 'Pendaftaran berhasil dikirim.');
    }

    public function status()
    {
        $pendaftaran = Pendaftaran::where('user_id', auth()->id())->first();

        $currentStep = 1;

        if ($pendaftaran) {
            if ($pendaftaran->status_berkas == 'diverifikasi') {
                $currentStep = 2;
            }
            if ($pendaftaran->status_survey == 'selesai') {
                $currentStep = 3;
            }
            if ($pendaftaran->status_ditetapkan == 'ya') {
                $currentStep = 4;
            }
            if ($pendaftaran->surat_pernyataan == 1) {
                $currentStep = 5;
            }
            if ($pendaftaran->status_beasiswa == 'disetujui') {
                $currentStep = 6;
            }
        }

        return view('user.status', compact('pendaftaran','currentStep'));
    }

    /*
    |--------------------------------------------------------------------------
    | SURAT PERNYATAAN
    |--------------------------------------------------------------------------
    */
    public function formPernyataan()
    {
        $pendaftaran = $this->getUserPendaftaran();

        if (!$pendaftaran) {
            return redirect()
                ->route('user.pendaftaran')
                ->with('error', 'Silakan daftar terlebih dahulu.');
        }

        return view('user.pernyataan', compact('pendaftaran'));
    }

    public function kirimPernyataan(Request $request)
    {
        $request->validate([
            'isi_pernyataan' => 'required|string'
        ]);

        $pendaftaran = $this->getUserPendaftaran();

        if (!$pendaftaran) {
            return redirect()
                ->route('user.pendaftaran')
                ->with('error','Data pendaftaran tidak ditemukan.');
        }

        $pendaftaran->update([
            'surat_pernyataan' => 1,
            'tanggal_surat_pernyataan' => now(),
            'status_berkas' => 'diterima'
        ]);

        return redirect()
            ->route('user.status')
            ->with('success','Surat pernyataan berhasil dikirim.');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER
    |--------------------------------------------------------------------------
    */
    private function getUserPendaftaran()
    {
        return Pendaftaran::where('user_id', auth()->id())->first();
    }
}