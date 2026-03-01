<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Alumni;
use App\Models\User;

class LandingController extends Controller
{
public function index()
{
    $penerima = Pendaftaran::where('status_berkas', 'diterima')->count();

    $alumni = User::where('status_anbimm', 'aktif')->count();

    $sudahCair = Pendaftaran::where('status_pencairan', 'cair')->count();

    $belumCair = Pendaftaran::where('status_pencairan', 'belum_cair')->count();

    return view('landing.index', compact(
        'penerima',
        'alumni',
        'sudahCair',
        'belumCair'
    ));
}
    public function statistik()
    {
        $penerima = Pendaftaran::where('status_berkas', 'diterima')->count();
        $alumni = Alumni::where('status', 'aktif')->count();
        $totalDana = Pendaftaran::where('status_berkas', 'diterima')
                        ->sum('nominal_beasiswa');

        return view('landing.statistik', compact(
            'penerima',
            'alumni',
            'totalDana'
        ));
    }
}