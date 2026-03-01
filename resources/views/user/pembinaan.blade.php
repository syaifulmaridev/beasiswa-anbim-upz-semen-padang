@extends('user.layout')

@section('title','Pembinaan Saya')

@section('content')

<div class="max-w-5xl mx-auto pb-10">
    
    {{-- HEADER SECTION --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">
                Riwayat <span class="text-emerald-600">Pembinaan</span>
            </h1>
            <p class="text-slate-500 font-medium mt-1">Pantau progres setoran hafalan dan catatan dari pembimbing.</p>
        </div>

        {{-- RINGKASAN SINGKAT --}}
        <div class="flex items-center gap-3 px-5 py-3 bg-white rounded-2xl border border-slate-100 shadow-sm">
            <div class="p-2 bg-emerald-50 rounded-xl">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Setoran</p>
                <p class="text-lg font-black text-slate-700 leading-none">{{ $data->count() }} Kali</p>
            </div>
        </div>
    </div>

    {{-- TABEL / LIST SECTION --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-6 py-5 text-left text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Tanggal</th>
                        <th class="px-6 py-5 text-left text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Detail Hafalan</th>
                        <th class="px-6 py-5 text-left text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                        <th class="px-6 py-5 text-left text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Kehadiran</th>
                        <th class="px-6 py-5 text-left text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Catatan Pembimbing</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($data as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        {{-- TANGGAL --}}
                        <td class="px-6 py-6">
                            <div class="flex flex-col">
                                <span class="font-black text-slate-700">{{ \Carbon\Carbon::parse($item->tanggal_setor)->translatedFormat('d F Y') }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">{{ \Carbon\Carbon::parse($item->tanggal_setor)->diffForHumans() }}</span>
                            </div>
                        </td>

                        {{-- HAFALAN --}}
                        <td class="px-6 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 group-hover:bg-emerald-100 group-hover:text-emerald-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <span class="font-bold text-slate-600">{{ $item->hafalan }}</span>
                            </div>
                        </td>

                        

{{-- STATUS --}}
<td class="px-6 py-6">
    @php
        $status = strtolower($item->status ?? '');
        $pencairan = strtolower($item->status_pencairan ?? '');
    @endphp

    @if($status == 'lancar' || $status == 'verified')
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg 
            bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase 
            tracking-widest border border-emerald-100">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
            Lancar
        </span>

    @elseif($status == 'mengulang' || $status == 'pending')
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg 
            bg-amber-50 text-amber-600 text-[10px] font-black uppercase 
            tracking-widest border border-amber-100">
            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
            Mengulang
        </span>

    @elseif($pencairan == 'sudah')
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg 
            bg-blue-50 text-blue-600 text-[10px] font-black uppercase 
            tracking-widest border border-blue-100">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
            Cair Dana
        </span>

    @elseif($pencairan == 'belum')
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg 
            bg-slate-50 text-slate-500 text-[10px] font-black uppercase 
            tracking-widest border border-slate-100">
            Belum Cair
        </span>

    @else
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg 
            bg-slate-50 text-slate-500 text-[10px] font-black uppercase 
            tracking-widest border border-slate-100">
            {{ ucfirst($item->status) }}
        </span>
    @endif
</td>


{{-- KEHADIRAN --}}
<td class="px-6 py-6">
    @php
        $hadir = strtolower($item->hadir_status ?? '');
    @endphp

    @if($hadir == 'hadir')
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg 
            bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase 
            tracking-widest border border-emerald-100">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
            Hadir
        </span>

    @elseif($hadir == 'tidak hadir')
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg 
            bg-red-50 text-red-600 text-[10px] font-black uppercase 
            tracking-widest border border-red-100">
            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
            Tidak Hadir
        </span>

    @else
        <span class="text-slate-400 text-xs">-</span>
    @endif
</td>

{{-- CATATAN --}}
<td class="px-6 py-6">
    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 
                min-w-[220px] max-w-[320px] 
                group-hover:bg-white group-hover:shadow-sm 
                transition-all duration-300">
        <p class="text-xs text-slate-500 font-medium italic leading-relaxed break-words">
            "{{ $item->keterangan_hafalan ?: 'Tidak ada catatan khusus.' }}"
        </p>
    </div>
</td>>     
</tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20">
                            <div class="flex flex-col items-center justify-center opacity-30 text-slate-400">
                                <svg class="w-20 h-20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <p class="text-sm font-black uppercase tracking-[0.3em]">Belum Ada Riwayat</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    @if($data instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="mt-8">
        {{ $data->links() }}
    </div>
    @endif

</div>

@endsection