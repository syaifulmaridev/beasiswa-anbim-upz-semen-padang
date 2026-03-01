@extends('layouts.app')

@section('title','Pembinaan Anbimm')

@section('content')

<div class="min-h-screen bg-[#F8FAFC] p-4 md:p-8 space-y-8">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">
                Monitoring <span class="text-[#1f4a44]">Pembinaan</span>
            </h1>
            <p class="text-sm text-slate-500 font-medium mt-1">Kelola kehadiran dan progres pencairan dana santri.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.pembinaan.exportAll', ['bulan' => request('bulan')]) }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-rose-600 text-white text-sm font-bold rounded-2xl hover:bg-rose-700 transition shadow-lg shadow-rose-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Export PDF
            </a>
        </div>
    </div>

    <div class="bg-white p-5 rounded-[2rem] shadow-sm border border-slate-100">
        <form method="GET" class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                <div class="relative w-full md:w-64">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama santri..."
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-[#1f4a44]/20 transition">
                </div>

                <input type="month" name="bulan" value="{{ request('bulan') }}"
                       class="px-4 py-2.5 bg-slate-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-[#1f4a44]/20 transition">

                <button type="submit" class="px-6 py-2.5 bg-[#1f4a44] text-white text-sm font-bold rounded-xl hover:bg-[#163d38] transition shadow-md shadow-emerald-900/10">
                    Terapkan Filter
                </button>

                @if(request('search') || request('bulan'))
                    <a href="{{ route('admin.pembinaan.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-500 text-sm font-bold rounded-xl hover:bg-slate-200 transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-5 font-black text-slate-400 uppercase tracking-widest text-[10px]">Identitas Santri</th>
                        <th class="px-6 py-5 font-black text-slate-400 uppercase tracking-widest text-[10px]">Status</th>
                        <th class="px-6 py-5 font-black text-slate-400 uppercase tracking-widest text-[10px] text-center">Rekap Absensi</th>
                        <th class="px-6 py-5 font-black text-slate-400 uppercase tracking-widest text-[10px] text-center">Status Dana</th>
                        <th class="px-6 py-5 font-black text-slate-400 uppercase tracking-widest text-[10px]">Kehadiran %</th>
                        <th class="px-6 py-5 font-black text-slate-400 uppercase tracking-widest text-[10px] text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50">
                @forelse($users as $user)
                    @php
                        $total = $user->pembinaans_count ?? 0;
                        $hadir = $user->hadir_count ?? 0;
                        $izin  = $user->izin_count ?? 0;
                        $sakit = $user->sakit_count ?? 0;
                        $alpa  = $user->alpa_count ?? 0;
                        $persen = $total > 0 ? round(($hadir / $total) * 100) : 0;
                    @endphp

                    <tr class="hover:bg-slate-50/80 transition-all group">
                        <td class="px-6 py-5">
                            <span class="font-bold text-slate-800 text-base group-hover:text-[#1f4a44] transition-colors">
                                {{ $user->name }}
                            </span>
                        </td>

                        <td class="px-6 py-5 text-center">
                            @if($user->status_anbimm == 'aktif')
                                <span class="px-3 py-1.5 bg-emerald-50 text-emerald-600 rounded-xl text-[11px] font-black uppercase tracking-tighter">Aktif</span>
                            @elseif($user->status_anbimm == 'non_aktif')
                                <span class="px-3 py-1.5 bg-rose-50 text-rose-600 rounded-xl text-[11px] font-black uppercase tracking-tighter">Non-Aktif</span>
                            @else
                                <span class="px-3 py-1.5 bg-slate-100 text-slate-500 rounded-xl text-[11px] font-black uppercase tracking-tighter">Alumni</span>
                            @endif
                        </td>

                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-3">
                                <div class="text-center px-2 py-1 bg-emerald-50 rounded-lg border border-emerald-100">
                                    <p class="text-[9px] font-bold text-emerald-500 uppercase">H</p>
                                    <p class="font-black text-emerald-700">{{ $hadir }}</p>
                                </div>
                                <div class="text-center px-2 py-1 bg-amber-50 rounded-lg border border-amber-100">
                                    <p class="text-[9px] font-bold text-amber-500 uppercase">I/S</p>
                                    <p class="font-black text-amber-700">{{ $izin + $sakit }}</p>
                                </div>
                                <div class="text-center px-2 py-1 bg-rose-50 rounded-lg border border-rose-100">
                                    <p class="text-[9px] font-bold text-rose-500 uppercase">A</p>
                                    <p class="font-black text-rose-700">{{ $alpa }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-5 text-center">
                            @if($user->status_pencairan == 'sudah')
                                <span class="inline-flex items-center gap-1.5 text-emerald-600 font-bold text-xs bg-emerald-50 px-3 py-1 rounded-full">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    Dicairkan
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-amber-600 font-bold text-xs bg-amber-50 px-3 py-1 rounded-full">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                                    Menunggu
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-5">
                            <div class="flex flex-col w-32">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-[10px] font-black text-slate-400">{{ $persen }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-500 {{ $persen >= 80 ? 'bg-emerald-500' : ($persen >= 50 ? 'bg-amber-500' : 'bg-rose-500') }}"
                                         style="width: {{ $persen }}%">
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-5 text-right">
                            <a href="{{ route('admin.pembinaan.show',$user->id) }}"
                               class="inline-flex items-center justify-center w-10 h-10 bg-slate-100 text-[#1f4a44] rounded-xl hover:bg-[#1f4a44] hover:text-white transition-all shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center">
                            <p class="text-slate-400 font-medium italic">Tidak ada data pembinaan ditemukan.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 px-4">
        {{ $users->appends(request()->all())->links() }}
    </div>
</div>

@endsection