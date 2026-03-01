<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LogAktivitas;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Alumni;


class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->month ?? now()->format('m');

        // ==============================
        // STATISTIK USER
        // ==============================
        $totalUser = User::where('status', 'approved')->count();
        $totalPending = User::where('status', 'pending')->count();
        $totalRejected = User::where('status', 'rejected')->count();

        $approvedThisMonth = User::where('status', 'approved')
            ->whereMonth('updated_at', $month)
            ->count();

        // ==============================
        // DATA GRAFIK PER BULAN
        // ==============================
        $monthlyData = collect(range(1, 12))->map(function ($i) {
            return User::where('status', 'approved')
                ->whereMonth('updated_at', $i)
                ->count();
        });

        // ==============================
        // AKTIVITAS TERBARU
        // ==============================
        $recentLogs = LogAktivitas::latest()->take(5)->get();

        /// ==============================
        // CEK PERIODE SETORAN DARI DATABASE
        // ==============================
        $setting = Setting::first();
        $periodeAktif = false;

        if ($setting && $setting->setoran_mulai && $setting->setoran_selesai) {

            $periodeAktif = now()->between(
                $setting->setoran_mulai,
                $setting->setoran_selesai
            );
        }

        return view('admin.dashboard', [
            'totalUser' => $totalUser,
            'totalPending' => $totalPending,
            'totalRejected' => $totalRejected,
            'approvedThisMonth' => $approvedThisMonth,
            'monthlyData' => $monthlyData,
            'recentLogs' => $recentLogs,
            'month' => $month,
            'periodeAktif' => $periodeAktif, // WAJIB ADA
        ]);
    }
}