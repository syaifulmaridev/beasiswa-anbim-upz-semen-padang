@extends('layouts.app')

@section('title','Validasi Beasiswa')

@section('content')

<div class="p-10 space-y-6">

    <h2 class="text-2xl font-bold text-[#1f4a44]">
        Validasi Beasiswa
    </h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="p-4">Nama</th>
                    <th class="p-4">Total Skor</th>
                    <th class="p-4">Kategori</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>

                @forelse($data as $item)
                <tr class="border-t">

                    <!-- Nama -->
                    <td class="p-4">
                        {{ $item->user->name ?? '-' }}
                    </td>

                    <!-- Skor -->
                    <td class="p-4 font-semibold">
                        {{ $item->skor_total }}
                    </td>

                    <!-- Kategori -->
                    <td class="p-4">
                        @if($item->kategori == 'Sangat Layak')
                            <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs">
                                Sangat Layak
                            </span>
                        @elseif($item->kategori == 'Layak')
                            <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs">
                                Layak
                            </span>
                        @elseif($item->kategori == 'Dipertimbangkan')
                            <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs">
                                Dipertimbangkan
                            </span>
                        @else
                            <span class="bg-red-600 text-white px-3 py-1 rounded-full text-xs">
                                Belum Layak
                            </span>
                        @endif
                    </td>

                    <!-- Status -->
                    <td class="p-4">
                        @if($item->status == 'diterima')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                Diterima
                            </span>
                        @elseif($item->status == 'ditolak')
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                Ditolak
                            </span>
                        @else
                            <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs">
                                Pending
                            </span>
                        @endif
                    </td>

                    <!-- Aksi -->
                    <td class="p-4">
                        <div class="flex gap-2 justify-center">

                            <form action="{{ route('admin.validasi.beasiswa.updateStatus',$item->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="diterima">
                                <button class="bg-green-600 text-white px-3 py-1 rounded text-xs">
                                    Terima
                                </button>
                            </form>

                            <form action="{{ route('admin.validasi.beasiswa.updateStatus',$item->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="ditolak">
                                <button class="bg-red-600 text-white px-3 py-1 rounded text-xs">
                                    Tolak
                                </button>
                            </form>

                            <form action="{{ route('admin.validasi.beasiswa.updateStatus',$item->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="pending">
                                <button class="bg-gray-500 text-white px-3 py-1 rounded text-xs">
                                    Pending
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500">
                        Belum ada data penilaian beasiswa
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</div>

@endsection
