<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\PenilaianBeasiswa;
use Spatie\Permission\Models\Role;

class AdminPendaftaranController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST DATA PENDAFTARAN
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
{
    $query = Pendaftaran::with('user');

    if ($request->search) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('nik', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->status_berkas) {
        $query->where('status_berkas', $request->status_berkas);
    }

    if ($request->status_survey) {
        $query->where('status_survey', $request->status_survey);
    }

    $pendaftaran = $query->latest()->get();

    return view('admin.pendaftaran.index', compact('pendaftaran'));
}

    /*
    |--------------------------------------------------------------------------
    | DETAIL PENDAFTARAN
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $pendaftaran = Pendaftaran::with('user')
            ->findOrFail($id);

        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS BERKAS
    |--------------------------------------------------------------------------
    */
    public function updateStatus(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        $request->validate([
            'status_berkas' => 'required|in:pending,diterima,ditolak',
            'alasan_ditolak' => 'nullable|string'
        ]);

        if ($request->status_berkas == 'ditolak' && empty($request->alasan_ditolak)) {
            return back()->with('error', 'Alasan penolakan wajib diisi.');
        }

        $pendaftaran->update([
            'status_berkas' => $request->status_berkas,
            'alasan_ditolak' => $request->status_berkas == 'ditolak'
                ? $request->alasan_ditolak
                : null
        ]);

        return back()->with('success', 'Status berkas berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | FORM SURVEY
    |--------------------------------------------------------------------------
    */
    public function survey($id)
    {
        $pendaftaran = Pendaftaran::with('user')
            ->findOrFail($id);

        if ($pendaftaran->status_berkas !== 'diterima') {
            return redirect()
                ->route('admin.pendaftaran.index')
                ->with('error', 'Berkas harus diterima terlebih dahulu.');
        }

        return view('admin.pendaftaran.survey', compact('pendaftaran'));
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN HASIL SURVEY
    |--------------------------------------------------------------------------
    */
    public function storeSurvey(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::with('user')->findOrFail($id);

        $request->validate([
            'skor_rumah' => 'required|numeric|min:1|max:5',
            'skor_kepemilikan' => 'required|numeric|min:1|max:5',
            'skor_dinding' => 'required|numeric|min:1|max:5',
            'skor_lantai' => 'required|numeric|min:1|max:5',
            'skor_atap' => 'required|numeric|min:1|max:5',
            'skor_dapur' => 'required|numeric|min:1|max:5',
            'skor_kursi' => 'required|numeric|min:1|max:5',
            'skor_baca_quran' => 'required|numeric|min:1|max:4',
            'skor_hafalan' => 'required|numeric|min:1|max:4',
            'skor_shalat' => 'required|numeric|min:1|max:4',
            'skor_ibadah' => 'required|numeric|min:1|max:4',
            'status_survey' => 'required|in:Sangat Layak,Layak,Dipertimbangkan,Ditolak',
        ]);

        /*
        |--------------------------------------------------------------------------
        | HITUNG TOTAL & REKOMENDASI SISTEM
        |--------------------------------------------------------------------------
        */
        $total =
            $request->skor_rumah +
            $request->skor_kepemilikan +
            $request->skor_dinding +
            $request->skor_lantai +
            $request->skor_atap +
            $request->skor_dapur +
            $request->skor_kursi +
            $request->skor_baca_quran +
            $request->skor_hafalan +
            $request->skor_shalat +
            $request->skor_ibadah;

        $nilaiAkhir = round(($total / 52) * 100);

        if ($nilaiAkhir >= 70) {
            $rekomendasiSistem = 'Sangat Layak';
        } elseif ($nilaiAkhir >= 55) {
            $rekomendasiSistem = 'Dipertimbangkan';
        } else {
            $rekomendasiSistem = 'Tidak Cocok';
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN PENILAIAN
        |--------------------------------------------------------------------------
        */
        PenilaianBeasiswa::create([
            'pendaftaran_id' => $pendaftaran->id,
            'skor_rumah' => $request->skor_rumah,
            'skor_kepemilikan' => $request->skor_kepemilikan,
            'skor_dinding' => $request->skor_dinding,
            'skor_lantai' => $request->skor_lantai,
            'skor_atap' => $request->skor_atap,
            'skor_dapur' => $request->skor_dapur,
            'skor_kursi' => $request->skor_kursi,
            'skor_baca_quran' => $request->skor_baca_quran,
            'skor_hafalan' => $request->skor_hafalan,
            'skor_shalat' => $request->skor_shalat,
            'skor_ibadah' => $request->skor_ibadah,
            'total_skor' => $total,
            'nilai_akhir' => $nilaiAkhir,
            'status_kelayakan' => $rekomendasiSistem
        ]);

        /*
        |--------------------------------------------------------------------------
        | UPDATE STATUS FINAL (KEPUTUSAN ADMIN)
        |--------------------------------------------------------------------------
        */
        $statusFinal = $request->status_survey;

        $pendaftaran->update([
            'status_survey' => $statusFinal,
            'status_berkas' => $statusFinal === 'Ditolak'
                ? 'ditolak'
                : 'penetapan'
        ]);

        /*
        |--------------------------------------------------------------------------
        | AUTO STATUS PEMBINAAN
        |--------------------------------------------------------------------------
        */
        $user = $pendaftaran->user;

        if (in_array($statusFinal, ['Sangat Layak', 'Layak'])) {

            if (!$user->hasRole('user')) {
                $user->assignRole('user');
            }

            $user->update([
                'status_anbimm' => 'aktif'
            ]);

        } else {

            $user->update([
                'status_anbimm' => 'non_aktif'
            ]);
        }

        return redirect()
            ->route('admin.pendaftaran.index')
            ->with('success', 'Survey berhasil disimpan & status pembinaan diperbarui.');
    }
}