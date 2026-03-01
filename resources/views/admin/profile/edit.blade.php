@extends('layouts.app')

@section('title','Edit Profil')

@section('content')

<div class="max-w-2xl mx-auto">

    <div class="bg-white p-8 rounded-2xl shadow">

        <h2 class="text-xl font-bold text-[#1f4a44] mb-6">
            Edit Profil
        </h2>

        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-700 p-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- NAMA -->
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2">
                    Nama
                </label>
                <input type="text"
                       name="name"
                       value="{{ old('name', Auth::user()->name) }}"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1f4a44]">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div class="mb-5">
                <label class="block text-sm font-semibold mb-2">
                    Password Baru (Opsional)
                </label>
                <input type="password"
                       name="password"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1f4a44]">
            </div>

            <!-- KONFIRM PASSWORD -->
            <div class="mb-6">
                <label class="block text-sm font-semibold mb-2">
                    Konfirmasi Password
                </label>
                <input type="password"
                       name="password_confirmation"
                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#1f4a44]">
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="bg-[#1f4a44] text-white px-6 py-2 rounded-lg hover:opacity-90">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
