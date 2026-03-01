<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;

class AdminAlumniController extends Controller
{
    // ================= INDEX =================
    public function index()
    {
        $alumni = Alumni::latest()->get();
        return view('admin.alumni.index', compact('alumni'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'tahun_kelulusan'    => 'required',
            'kegiatan_selanjutnya'      => 'required',
            'jurusan'        => 'required',
            'instansi_asal'  => 'required',
            'email'          => 'required|email',
            'hp'             => 'required',
            'alamat'        => 'required',
            'tempat_kegiatan'  => 'required',
            'foto_ijazah'    => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Upload foto ijazah
        $pathFoto = null;
        if ($request->hasFile('foto_ijazah')) {
            $pathFoto = $request->file('foto_ijazah')->store('ijazah', 'public');
        }

        Alumni::create([
            'user_id'       => auth()->id(),
            'nama'          => auth()->user()->name,
            'nik'           => auth()->user()->nik,
            'tahun_kelulusan'   => $request->tahun_kelulusan,
            'kegiatan_selanjutnya'     => $request->kegiatan_selanjutnya,
            'jurusan'       => $request->jurusan,
            'instansi_asal' => $request->instansi_asal,
            'email'         => $request->email,
            'hp'            => $request->hp,
            'alamat'            => $request->alamat,
            'tempat_kegiatan'   => $request->tahun_lulus,
            'foto_ijazah'   => $pathFoto,
        ]);

        $user = auth()->user();

        $user->syncRoles(['alumni']);

        $user->update([
            'status_anbimm' => 'alumni'
        ]);

        return redirect()->back()->with('success','Data alumni berhasil disimpan.');
    }

    // ================= DESTROY =================
    public function destroy($id)
    {
        Alumni::findOrFail($id)->delete();
        return redirect()->back()->with('success','Data alumni berhasil dihapus.');
    }
}