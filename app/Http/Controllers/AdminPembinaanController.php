<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pembinaan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminPembinaanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD MONITORING
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $search = $request->search;

        $users = User::role('user')
    ->where('status_anbimm', 'aktif')
    ->withCount([
        'pembinaans',

        'pembinaans as hadir_count' => fn($q) =>
            $q->where('hadir_status', 'hadir'),

        'pembinaans as izin_count' => fn($q) =>
            $q->where('hadir_status', 'izin'),

        'pembinaans as sakit_count' => fn($q) =>
            $q->where('hadir_status', 'sakit'),

        'pembinaans as alpa_count' => fn($q) =>
            $q->where('hadir_status', 'alpa'),
    ])
    ->when($search, fn($query) =>
        $query->where('name','like',"%{$search}%")
    )
    ->latest()
    ->paginate(10);

        return view('admin.pembinaan.index', compact('users'));
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL USER
    |--------------------------------------------------------------------------
    */
    public function show(User $user, Request $request)
    {
        $query = $user->pembinaans();

        if ($request->bulan) {
            $query->whereMonth('tanggal_setor', date('m', strtotime($request->bulan)))
                  ->whereYear('tanggal_setor', date('Y', strtotime($request->bulan)));
        }

        $data = $query->latest()->paginate(10);

        $totalHafalan = $user->pembinaans()->count();
        $totalHadir   = $user->pembinaans()->where('hadir_status','hadir')->count();
        $totalIzin    = $user->pembinaans()->where('hadir_status','izin')->count();
        $totalSakit   = $user->pembinaans()->where('hadir_status','sakit')->count();
        $totalAlpa    = $user->pembinaans()->where('hadir_status','alpa')->count();

        return view('admin.pembinaan.detail', compact(
            'user',
            'data',
            'totalHafalan',
            'totalHadir',
            'totalIzin',
            'totalSakit',
            'totalAlpa'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE DATA
    |--------------------------------------------------------------------------
    */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'tanggal_setor'    => 'required|date',
            'hafalan'          => 'required|string|max:255',
            'hadir_status'     => 'required|in:hadir,izin,sakit,alpa',
            'status_pencairan' => 'required|in:belum,sudah',
            'keterangan_hafalan'          => 'nullable|string'
        ]);

        Pembinaan::create([
            'user_id'          => $user->id,
            'pembina_id'       => auth()->id(),
            'tanggal_setor'    => $request->tanggal_setor,
            'hafalan'          => $request->hafalan,
            'hadir_status'     => $request->hadir_status,
            'keterangan_hafalan' => $request->keterangan_hafalan,
            'status_pencairan' => $request->status_pencairan,
        ]);

        return back()->with('success','Data pembinaan berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS ANBIMM
    |--------------------------------------------------------------------------
    */
    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'status_anbimm' => 'required|in:aktif,non_aktif,alumni'
        ]);

        $user->update([
            'status_anbimm' => $request->status_anbimm
        ]);

        return back()->with('success','Status berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy(Pembinaan $pembinaan)
    {
        $pembinaan->delete();
        return back()->with('success','Data berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT PER USER
    |--------------------------------------------------------------------------
    */
    public function export(User $user, Request $request)
    {
        $bulanInput = $request->bulan ?? null;

        $query = $user->pembinaans();

        if ($bulanInput) {
            $query->whereMonth('tanggal_setor', date('m', strtotime($bulanInput)))
                  ->whereYear('tanggal_setor', date('Y', strtotime($bulanInput)));
        }

        $data = $query->orderBy('tanggal_setor','asc')->get();

        $totalHafalan = $data->count();
        $totalHadir   = $data->where('hadir_status','hadir')->count();
        $totalIzin    = $data->where('hadir_status','izin')->count();
        $totalSakit   = $data->where('hadir_status','sakit')->count();
        $totalAlpa    = $data->where('hadir_status','alpa')->count();

        $pdf = Pdf::loadView(
            'admin.pembinaan.pdf',
            compact(
                'user',
                'data',
                'totalHafalan',
                'totalHadir',
                'totalIzin',
                'totalSakit',
                'totalAlpa',
                'bulanInput'
            )
        );

        return $pdf->download('laporan-'.$user->name.'.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT SEMUA USER (UMUM / PER BULAN)
    |--------------------------------------------------------------------------
    */
    public function exportAll(Request $request)
    {
        $bulanInput = $request->bulan ?? now()->format('Y-m');

        $bulan = date('m', strtotime($bulanInput));
        $tahun = date('Y', strtotime($bulanInput));

        $users = User::role('user')
            ->with(['pembinaans' => function($query) use ($bulan, $tahun) {
                $query->whereMonth('tanggal_setor', $bulan)
                      ->whereYear('tanggal_setor', $tahun)
                      ->orderBy('tanggal_setor','asc');
            }])
            ->get();

        $pdf = Pdf::loadView(
            'admin.pembinaan.pdf_all',
            compact('users','bulanInput')
        );

        return $pdf->download('laporan-pembinaan-'.$bulanInput.'.pdf');
    }
}