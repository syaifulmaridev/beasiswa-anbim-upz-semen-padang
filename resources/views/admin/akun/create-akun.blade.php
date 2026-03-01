@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto mt-10">
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Tambah Akun</h2>
            <p class="text-gray-500 text-sm">Lengkapi formulir di bawah untuk menambahkan pengguna baru ke sistem.</p>
        </div>

        <form action="{{ route('admin.akun.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all" 
                    placeholder="Masukkan nama lengkap">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIK</label>
                <input type="text" name="nik" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all" 
                    placeholder="Masukkan nomor induk kependudukan">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all" 
                    placeholder="••••••••">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role / Hak Akses</label>
                <select name="role" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all bg-white">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                    <option value="alumni">Alumni</option>
                </select>
            </div>

            <div class="pt-2">
                <button type="submit" 
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    Simpan Akun Baru
                </button>
                <a href="{{ url()->previous() }}" class="block text-center mt-4 text-sm text-gray-500 hover:text-gray-700 transition-colors">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

@endsection