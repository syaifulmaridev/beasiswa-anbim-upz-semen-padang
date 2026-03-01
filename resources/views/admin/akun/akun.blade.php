@extends('layouts.app')

@section('title','Kelola Akun')

@section('content')

<div class="max-w-6xl mx-auto space-y-6 pb-10">

    {{-- HEADER SECTION --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-2">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">
                Kelola <span class="text-emerald-600">Akun</span>
            </h1>
            <p class="text-slate-500 font-medium mt-1">Manajemen akses dan hak istimewa pengguna sistem.</p>
        </div>
        
        <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-2xl border border-slate-100 shadow-sm">
            <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>
            <span class="text-xs font-bold text-slate-600 uppercase tracking-wider">Total: {{ $users->total() }} User</span>
        </div>
    </div>

    <x-table.main title="Daftar Pengguna">

        {{-- 🔎 SEARCH & FILTER --}}
        <x-slot name="action">
            <form method="GET" class="flex flex-wrap items-center gap-3">

                {{-- Search --}}
                <div class="relative">
                    <input type="text" 
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari nama / NIK..."
                           class="pl-10 pr-4 py-2.5 text-sm bg-slate-50 border-none rounded-xl focus:ring-4 focus:ring-emerald-500/10 outline-none w-64 font-medium transition">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                {{-- Filter Role --}}
                <select name="role"
                        class="px-4 py-2.5 text-sm bg-slate-50 border-none rounded-xl focus:ring-4 focus:ring-emerald-500/10 outline-none font-bold text-slate-600 appearance-none">
                    <option value="">Semua Role</option>
                    @foreach(['admin','manager','surveyor','keuangan','monev','user'] as $r)
                        <option value="{{ $r }}" {{ request('role') == $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                    @endforeach
                </select>

                <button type="submit"
                        class="px-6 py-2.5 bg-slate-800 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-slate-700 transition shadow-lg shadow-slate-200">
                    Filter
                </button>

                <a href="{{ route('admin.akun') }}"
                   class="px-4 py-2.5 bg-slate-100 text-slate-500 text-xs font-black uppercase tracking-widest rounded-xl hover:bg-slate-200 transition">
                    Reset
                </a>

                {{-- 🔥 TOMBOL TAMBAH AKUN --}}
        <a href="{{ route('admin.akun.create') }}"
           class="px-5 py-2.5 bg-emerald-600 text-white text-xs font-black uppercase tracking-widest rounded-xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">
            + Tambah Akun
        </a>
            </form>
        </x-slot>

        {{-- HEADER --}}
        <x-table.header>
            <th class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Nama</th>
            <th class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-[0.2em]">NIK</th>
            <th class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Role</th>
            <th class="px-6 py-4 text-left text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
            <th class="px-6 py-4 text-right text-xs font-black text-slate-400 uppercase tracking-[0.2em]">Aksi</th>
        </x-table.header>

        {{-- BODY --}}
        <tbody class="divide-y divide-slate-50">

            @forelse($users as $user)

            @php
                $role = $user->role_name;
                $roleClasses = [
                    'admin' => 'bg-rose-50 text-rose-600 border-rose-100',
                    'manager' => 'bg-fuchsia-50 text-fuchsia-600 border-fuchsia-100',
                    'surveyor' => 'bg-amber-50 text-amber-600 border-amber-100',
                    'keuangan' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                    'monev' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                    'user' => 'bg-blue-50 text-blue-600 border-blue-100',
                ];
                $currentRoleClass = $roleClasses[$role] ?? 'bg-slate-50 text-slate-600 border-slate-100';
            @endphp

            <x-table.row class="hover:bg-slate-50/50 transition">

                {{-- Nama --}}
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-black text-slate-500 border border-slate-200">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <span class="font-bold text-slate-700">{{ $user->name }}</span>
                    </div>
                </td>

                {{-- NIK --}}
                <td class="px-6 py-4 text-sm font-medium text-slate-500 tracking-wider">
                    {{ $user->nik }}
                </td>

                {{-- ROLE --}}
                <td class="px-6 py-4">
                    <span class="px-3 py-1.5 text-[10px] font-black uppercase tracking-widest border rounded-lg {{ $currentRoleClass }}">
                        {{ $role ?? 'user' }}
                    </span>
                </td>

                {{-- STATUS --}}
                <td class="px-6 py-4">
                    @if($user->status == 'approved')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-emerald-600 bg-emerald-50 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Approved
                        </span>
                    @elseif($user->status == 'pending')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-amber-600 bg-amber-50 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                            Pending
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-rose-600 bg-rose-50 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                            Rejected
                        </span>
                    @endif
                </td>

                {{-- AKSI --}}
                <td class="px-6 py-4 text-right">
                    <form action="{{ route('admin.akun.delete',$user->id) }}"
                          method="POST"
                          class="inline-block">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus permanen akun ini?')"
                                class="p-2 text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition group">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </td>

            </x-table.row>

            @empty
                <tr>
                    <td colspan="5" class="text-center py-20">
                        <div class="flex flex-col items-center opacity-30">
                            <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <p class="font-black text-sm uppercase tracking-[0.2em]">Data tidak ditemukan</p>
                        </div>
                    </td>
                </tr>
            @endforelse

        </tbody>

    </x-table.main>

    {{-- PAGINATION --}}
    <div class="mt-8 flex justify-center">
        <div class="bg-white px-4 py-2 rounded-[2rem] shadow-sm border border-slate-100">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>

</div>

@endsection