<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;

class AdminLogController extends Controller
{
    public function index()
    {
        $logs = LogAktivitas::with('user')
            ->latest()
            ->paginate(10); // pakai pagination biar ringan

        return view('admin.log.index', compact('logs'));
    }
}
