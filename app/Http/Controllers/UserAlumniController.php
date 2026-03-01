<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumni;

class UserAlumniController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORM ALUMNI USER
    |--------------------------------------------------------------------------
    */
   public function index()
{
    $alumni = \App\Models\Alumni::where('user_id', auth()->id())
                ->latest()
                ->get(); // WAJIB get()

    return view('user.alumni', compact('alumni'));
}


    public function store(Request $request)
{
    $request->validate([
        'tahun_kelulusan' => 'required|digits:4',
        'kegiatan_selanjutnya' => 'required|string|max:255',
        'tempat_kegiatan' => 'nullable|string|max:255',
        'alamat' => 'required|string',
        'jurusan' => 'required|string|max:255',
        'instansi_asal' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'hp' => 'required|string|max:20',
        'foto_ijazah' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Upload foto ijazah
    $fotoPath = null;
    if ($request->hasFile('foto_ijazah')) {
        $fotoPath = $request->file(key: 'foto_ijazah')
                            ->store('ijazah', 'public');
    }

    Alumni::updateOrCreate(
        ['nik' => auth()->user()->nik],
        [
            'user_id' => auth()->id(),
            'nama' => auth()->user()->nama_lengkap ?? auth()->user()->name,
            'nik' => auth()->user()->nik,
            'tahun_kelulusan' => $request->tahun_kelulusan,
            'kegiatan_selanjutnya' => $request->kegiatan_selanjutnya,
            'jurusan' => $request->jurusan,
            'instansi_asal' => $request->instansi_asal,
            'email' => $request->email,
            'hp' => $request->hp,
            'alamat'        => $request ->alamat,
            'tempat_kegiatan' => $request->tempat_kegiatan,
            'foto_ijazah' => $fotoPath,
        ]
    );

    $user = auth()->user();
    $user->removeRole('user');
    $user->assignRole('alumni');

    $user->update([
        'status_anbimm' => 'alumni'
    ]);

    return back()->with('success', 'Data alumni berhasil disimpan.');
}
};