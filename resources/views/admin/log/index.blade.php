@extends('layouts.app')

@section('title','Log Aktivitas')

@section('content')

<div class="p-8 space-y-6">

    <h1 class="text-2xl font-bold text-[#1f4a44]">
        Log Aktivitas Sistem
    </h1>

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full text-left">
            <thead class="bg-gray-100 text-sm uppercase text-gray-600">
                <tr>
                    <th class="p-4">Waktu</th>
                    <th class="p-4">User</th>
                    <th class="p-4">Aksi</th>
                    <th class="p-4">Deskripsi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($logs as $log)
                    <tr class="border-t hover:bg-gray-50">

                        {{-- WAKTU --}}
                        <td class="p-4">
                            <div class="font-medium">
                                {{ $log->created_at->format('d M Y H:i') }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $log->created_at->diffForHumans() }}
                            </div>
                        </td>

                        {{-- USER --}}
                        <td class="p-4">
                            {{ $log->user->name ?? 'System' }}
                        </td>

                        {{-- AKSI --}}
                        <td class="p-4">
                            @php
                                $color = 'bg-gray-200 text-gray-700';

                                if(str_contains($log->aksi, 'Tambah')) {
                                    $color = 'bg-green-100 text-green-700';
                                } elseif(str_contains($log->aksi, 'Update')) {
                                    $color = 'bg-yellow-100 text-yellow-700';
                                } elseif(str_contains($log->aksi, 'Hapus')) {
                                    $color = 'bg-red-100 text-red-700';
                                }
                            @endphp

                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                {{ $log->aksi }}
                            </span>
                        </td>

                        {{-- DESKRIPSI --}}
                        <td class="p-4 text-gray-600">
                            {{ $log->deskripsi }}
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-6 text-center text-gray-500">
                            Belum ada aktivitas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    {{-- PAGINATION --}}
    <div>
        {{ $logs->links() }}
    </div>

</div>

@endsection
