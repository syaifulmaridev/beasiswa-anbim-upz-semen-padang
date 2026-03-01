@extends('layouts.app')

@section('title','Validasi Pendaftaran')

@section('content')

<div class="min-h-screen bg-[#F8FAFC] p-4 md:p-8 space-y-8">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">
                Validasi <span class="text-emerald-600">Pendaftaran</span>
            </h1>
            <p class="text-sm text-slate-500 font-medium mt-1">Verifikasi berkas, pantau hasil survey, dan kelola kelayakan pendaftar secara real-time.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <div class="px-5 py-2.5 bg-white border border-slate-200 rounded-2xl shadow-sm flex items-center gap-3">
                <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                <span class="text-sm font-bold text-slate-700 tracking-tight">{{ now()->translatedFormat('d F Y') }}</span>
            </div>
        </div>
    </div>

    {{-- ================= STATISTIK CARDS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $stats = [
                ['label' => 'Total Pendaftar', 'count' => $pendaftaran->count(), 'color' => 'slate', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                ['label' => 'Berkas Diterima', 'count' => $pendaftaran->where('status_berkas','diterima')->count(), 'color' => 'emerald', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Sudah Survey', 'count' => $pendaftaran->whereNotNull('status_survey')->count(), 'color' => 'blue', 'icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7'],
                ['label' => 'Dana Cair', 'count' => $pendaftaran->where('status_pencairan','sudah_dicairkan')->count(), 'color' => 'amber', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ];
        @endphp

        @foreach($stats as $s)
        <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md transition-shadow cursor-default group">
            <div class="w-14 h-14 bg-{{ $s['color'] }}-50 text-{{ $s['color'] }}-600 rounded-3xl flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $s['icon'] }}"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">{{ $s['label'] }}</p>
                <p class="text-2xl font-black text-slate-800 tracking-tight">{{ $s['count'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ================= SEARCH & FILTER ================= --}}
    <div class="bg-white p-5 rounded-[2.5rem] shadow-sm border border-slate-100">
        <form method="GET" class="flex flex-wrap items-center gap-4">
            {{-- Cari Data --}}
            <div class="flex-1 min-w-[280px] relative group">
                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama atau NIK..."
                       class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-2 border-transparent rounded-2xl text-sm focus:bg-white focus:border-emerald-500/20 focus:ring-4 focus:ring-emerald-500/10 transition font-medium outline-none">
            </div>

            {{-- Filter Status Berkas --}}
            <div class="w-full md:w-48">
                <select name="status_berkas" class="w-full px-4 py-3.5 bg-slate-50 border-2 border-transparent rounded-2xl text-sm focus:bg-white focus:border-emerald-500/20 focus:ring-4 focus:ring-emerald-500/10 transition font-bold text-slate-600 appearance-none outline-none cursor-pointer">
                    <option value="">Status Berkas</option>
                    <option value="pending" {{ request('status_berkas')=='pending'?'selected':'' }}>⏳ Pending</option>
                    <option value="diterima" {{ request('status_berkas')=='diterima'?'selected':'' }}>✅ Diterima</option>
                    <option value="ditolak" {{ request('status_berkas')=='ditolak'?'selected':'' }}>❌ Ditolak</option>
                </select>
            </div>

            {{-- Filter Status Survey --}}
            <div class="w-full md:w-56">
                <select name="status_survey" class="w-full px-4 py-3.5 bg-slate-50 border-2 border-transparent rounded-2xl text-sm focus:bg-white focus:border-emerald-500/20 focus:ring-4 focus:ring-emerald-500/10 transition font-bold text-slate-600 appearance-none outline-none cursor-pointer">
                    <option value="">Hasil Survey</option>
                    <option value="Sangat Layak" {{ request('status_survey')=='Sangat Layak'?'selected':'' }}>💎 Sangat Layak</option>
<option value="Layak" {{ request('status_survey')=='Layak'?'selected':'' }}>👍 Layak</option>
<option value="Dipertimbangkan" {{ request('status_survey')=='Dipertimbangkan'?'selected':'' }}>⚖️ Dipertimbangkan</option>
<option value="Ditolak" {{ request('status_survey')=='Ditolak'?'selected':'' }}>❌ Ditolak</option>
                </select>
            </div>

            <div class="flex items-center gap-2 ml-auto">
                <button type="submit" class="px-8 py-3.5 bg-emerald-600 text-white rounded-2xl text-sm font-black hover:bg-emerald-700 hover:shadow-lg hover:shadow-emerald-200 transition-all active:scale-95">
                    Terapkan
                </button>
                <a href="{{ route('admin.pendaftaran.index') }}" class="p-3.5 bg-slate-100 text-slate-400 rounded-2xl hover:bg-slate-200 hover:text-slate-600 transition-all active:scale-95" title="Reset Filter">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </a>
            </div>
        </form>
    </div>

    {{-- ================= TABLE ================= --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                        <th class="px-8 py-6">Pendaftar</th>
                        <th class="px-8 py-6">Identitas</th>
                        <th class="px-8 py-6 text-center">Berkas</th>
                        <th class="px-8 py-6 text-center">Status Survey</th>
                        <th class="px-8 py-6 text-center">Tanggal</th>
                        <th class="px-8 py-6 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50">
                    @forelse($pendaftaran as $item)
                    <tr class="hover:bg-slate-50/80 transition-all group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-gradient-to-br from-slate-100 to-slate-200 rounded-xl flex items-center justify-center font-black text-slate-500 text-xs">
                                    {{ $loop->iteration }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-black text-slate-800 text-base group-hover:text-emerald-600 transition-colors">
                                        {{ $item->user->name }}
                                    </span>
                                    <span class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest">ID-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="px-8 py-5">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-xs font-bold text-slate-600">{{ $item->user->nik }}</span>
                                <span class="text-[11px] text-slate-400 font-medium">{{ $item->no_hp ?? 'No Phone' }}</span>
                            </div>
                        </td>

                        <td class="px-8 py-5 text-center">
                            @php
                                $berkasStyle = [
                                    'diterima' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'ditolak' => 'bg-rose-50 text-rose-600 border-rose-100',
                                ][$item->status_berkas] ?? 'bg-slate-100 text-slate-500 border-slate-200';
                                
                            @endphp
                            <span class="px-4 py-1.5 border rounded-full font-black text-[10px] uppercase tracking-tighter {{ $berkasStyle }}">
                                {{ $item->status_berkas }}
                            </span>
                        </td>

                        <td class="px-8 py-5 text-center">
                            @php
    $status = $item->status_survey;

    $surveyStyle = [
        'Sangat Layak' => 'text-emerald-700 font-black italic',
        'Layak' => 'text-emerald-600 font-bold',
        'Dipertimbangkan' => 'text-amber-600 font-bold',
        'Ditolak' => 'text-rose-600 font-bold',
    ][$status] ?? 'text-slate-300 font-medium';
@endphp

<span class="text-xs {{ $surveyStyle }}">
    {{ $status ?? 'Belum Survey' }}
</span>
                            <span class="text-xs {{ $surveyStyle }}">
                                {{ $status ? ucwords(str_replace('_', ' ', $status)) : 'Belum Survey' }}
                            </span>
                        </td>

                        <td class="px-8 py-5 text-center">
    @if($item->tanggal_siap_survey)
        <div class="inline-flex items-center justify-center px-3 py-1.5 
                    bg-blue-50 text-blue-600 rounded-xl 
                    font-black text-[10px] tracking-wide">
            {{ \Carbon\Carbon::parse($item->tanggal_siap_survey)->translatedFormat('d F Y') }}
        </div>
    @else
        <span class="text-slate-300 font-black text-[10px] tracking-widest uppercase">
            Belum Dijadwalkan
        </span>
    @endif
</td>

                        <td class="px-8 py-5 text-right space-x-2">

                        {{-- DETAIL --}}
                        <a href="{{ route('admin.pendaftaran.show', $item->id) }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-800 text-white rounded-xl text-xs font-bold hover:bg-emerald-600 transition-all shadow-md active:scale-95">
                            Detail
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>

                        {{-- SURVEY --}}
                        <a href="{{ route('admin.pendaftaran.survey', $item->id) }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-yellow-500 text-white rounded-xl text-xs font-bold hover:bg-yellow-600 transition-all shadow-md active:scale-95">
                            Survey
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M9 5h6M9 12h6M9 19h6"/>
                            </svg>
                        </a>

                    </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center max-w-xs mx-auto">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 4-8-4"></path></svg>
                                </div>
                                <h3 class="text-slate-800 font-black text-sm uppercase">Tidak Ada Data</h3>
                                <p class="text-slate-400 text-xs mt-1">Kami tidak menemukan data pendaftaran dengan kriteria filter yang Anda pilih.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection