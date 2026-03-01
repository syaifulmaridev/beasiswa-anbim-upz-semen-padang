@extends('layouts.app')

@section('title','Data Alumni')

@section('content')

<div class="min-h-screen bg-[#F8FAFC] p-4 md:p-8 space-y-6">

    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">
                Data <span class="text-[#1f4a44]">Alumni</span>
            </h1>
            <p class="text-sm text-slate-500 font-medium mt-1">Manajemen informasi lulusan dan pelacakan karir.</p>
        </div>

        <form method="GET" action="{{ route('admin.alumni.index') }}" class="relative group w-full lg:w-96">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-[#1f4a44] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Cari nama, NIK, atau instansi..." 
                   class="block w-full pl-10 pr-24 py-3 bg-white border border-slate-200 rounded-2xl leading-5 focus:outline-none focus:ring-2 focus:ring-[#1f4a44]/20 focus:border-[#1f4a44] sm:text-sm transition-all shadow-sm">
            <button type="submit" 
                    class="absolute inset-y-1.5 right-1.5 px-4 bg-[#1f4a44] text-white text-xs font-bold rounded-xl hover:bg-[#163d38] transition-colors shadow-lg shadow-emerald-900/10">
                Cari Data
            </button>
        </form>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-6 py-5 font-black text-slate-400 uppercase tracking-widest text-[10px]">Informasi Dasar</th>
                        <th class="px-6 py-5 font-black text-slate-400 uppercase tracking-widest text-[10px]">Kontak & Alamat</th>
                        <th class="px-6 py-5 font-black text-slate-400 uppercase tracking-widest text-[10px]">Jurusan</th>
                        <th class="px-6 py-5 font-black text-slate-400 uppercase tracking-widest text-[10px]">Instansi Asal</th>
                        <th class="px-6 py-5 font-black text-slate-400 uppercase tracking-widest text-[10px]">No Hp</th>
                        <th class="px-6 py-5 font-black text-slate-400 uppercase tracking-widest text-[10px]">Email</th>
                        <th class="px-6 py-5 font-black text-slate-400 uppercase tracking-widest text-[10px]">ijazah</th>
                        <th class="px-6 py-5 font-black text-slate-400 uppercase tracking-widest text-[10px]">Status Karir</th>
                        <th class="px-6 py-5 font-black text-slate-400 uppercase tracking-widest text-[10px]">Instansi/Tempat</th>
                        <th class="px-6 py-5 font-black text-slate-400 uppercase tracking-widest text-[10px] text-center">Lulus</th>
                        <th class="px-6 py-5 font-black text-slate-400 uppercase tracking-widest text-[10px] text-center">Aksi</th>
                    </tr>
                </thead>

             <tbody class="divide-y divide-slate-100">
@forelse($alumni as $item)
<tr class="hover:bg-slate-50/70 transition duration-200">

    {{-- 1 Nama & NIK --}}
    <td class="px-6 py-5">
        <div class="flex flex-col">
            <span class="font-semibold text-slate-800">
                {{ $item->nama }}
            </span>
            <span class="text-xs text-slate-400">
                NIK: {{ $item->nik }}
            </span>
        </div>
    </td>

    {{-- 2 Alamat --}}
    <td class="px-6 py-5 text-xs text-slate-500 max-w-[200px] truncate">
        {{ $item->alamat ?? '-' }}
    </td>

    {{-- 3 Jurusan --}}
    <td class="px-6 py-5">
        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-medium">
            {{ $item->jurusan ?? '-' }}
        </span>
    </td>

    {{-- 4 Instansi --}}
    <td class="px-6 py-5 text-xs text-slate-600">
        {{ $item->instansi_asal ?? '-' }}
    </td>

    {{-- 5 HP --}}
    <td class="px-6 py-5 text-xs text-slate-600">
        {{ $item->hp ?? '-' }}
    </td>

    {{-- 6 Email --}}
    <td class="px-6 py-5 text-xs text-slate-600">
        {{ $item->email ?? '-' }}
    </td>

    {{-- 7 Ijazah --}}
    <td class="px-6 py-5 text-center">
        @if($item->foto_ijazah)
            <a href="{{ asset('storage/'.$item->foto_ijazah) }}" 
               target="_blank"
               class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-semibold hover:bg-indigo-600 hover:text-white transition">
                Lihat
            </a>
        @else
            <span class="text-xs text-slate-300">-</span>
        @endif
    </td>

    {{-- 8 Status --}}
    <td class="px-6 py-5">
        @php
            $statusColor = match($item->kegiatan_selanjutnya) {
                'Bekerja' => 'emerald',
                'Melanjutkan Pendidikan' => 'blue',
                'Berwirausaha' => 'amber',
                default => 'slate'
            };
        @endphp

        <span class="inline-flex items-center gap-2 px-3 py-1.5 
            bg-{{ $statusColor }}-50 
            text-{{ $statusColor }}-600 
            rounded-xl text-xs font-semibold">

            <span class="w-2 h-2 bg-{{ $statusColor }}-500 rounded-full"></span>

            {{ $item->kegiatan_selanjutnya ?? 'Belum Diisi' }}
        </span>
    </td>

    {{-- 9 Tempat --}}
    <td class="px-6 py-5 text-xs text-slate-600">
        {{ $item->tempat_kegiatan ?? '-' }}
    </td>

    {{-- 10 Tahun --}}
    <td class="px-6 py-5 text-center">
        <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-bold">
            {{ $item->tahun_kelulusan }}
        </span>
    </td>

    {{-- 11 Aksi --}}
    <td class="px-6 py-5 text-center">
        <form action="{{ route('admin.alumni.destroy',$item->id) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menghapus data ini?')">
            @csrf
            @method('DELETE')

            <button class="w-9 h-9 flex items-center justify-center 
                bg-rose-50 text-rose-600 rounded-xl 
                hover:bg-rose-600 hover:text-white 
                transition duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 7h12M9 7V4h6v3m-8 4v6m4-6v6m4-6v6M4 7h16l-1 14H5L4 7z"/>
                </svg>
            </button>
        </form>
    </td>

</tr>

@empty
<tr>
    <td colspan="11" class="py-24 text-center">
        <div class="flex flex-col items-center space-y-3">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 9.172a4 4 0 015.656 0M12 14h.01M12 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-slate-500 font-semibold text-sm">Belum Ada Data Alumni</h3>
            <p class="text-slate-400 text-xs">Data akan muncul setelah alumni melakukan pengisian.</p>
        </div>
    </td>
</tr>
@endforelse
</tbody>
            </table>
        </div>
    </div>

    @if(method_exists($alumni, 'links'))
    <div class="mt-4">
        {{ $alumni->appends(['search' => request('search')])->links() }}
    </div>
    @endif

</div>

@endsection