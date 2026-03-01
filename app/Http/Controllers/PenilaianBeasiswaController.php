<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenilaianBeasiswa;
use App\Models\User;

class PenilaianBeasiswaController extends Controller
{
    // ===============================
    // SIMPAN PENILAIAN
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Hitung total skor (semua field skor 1-4)
        $total = array_sum([
            $request->penghasilan,
            $request->pekerjaan,
            $request->kepemilikan_rumah,
            $request->status_orangtua,
            $request->tanggungan,
            $request->jenjang,
            $request->prestasi,
            $request->kendala,
            $request->quran,
            $request->hafalan,
            $request->shalat,
            $request->keaktifan,
        ]);

        // Tentukan kategori otomatis
        if ($total > 30) {
            $kategori = 'Sangat Layak';
        } elseif ($total >= 25) {
            $kategori = 'Layak';
        } elseif ($total >= 20) {
            $kategori = 'Dipertimbangkan';
        } else {
            $kategori = 'Belum Layak';
        }

        PenilaianBeasiswa::create([
            'user_id' => $request->user_id,
            'skor_total' => $total,
            'kategori' => $kategori,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Penilaian berhasil disimpan');
    }

    // ===============================
    // LIST DATA UNTUK ADMIN
    // ===============================
    public function index()
    {
        $data = PenilaianBeasiswa::with('user')->latest()->get();
        return view('admin.validasi_beasiswa.index', compact('data'));
    }

    // ===============================
    // UPDATE STATUS (DITERIMA / DITOLAK)
    // ===============================
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diterima,ditolak'
        ]);

        $data = PenilaianBeasiswa::findOrFail($id);
        $data->status = $request->status;
        $data->save();

        return back()->with('success', 'Status berhasil diperbarui');
    }
}
