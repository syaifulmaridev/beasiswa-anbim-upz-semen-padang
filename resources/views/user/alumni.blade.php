@extends('layouts.app-user')

@section('title','Data Alumni')

@section('content')

<div class="max-w-5xl mx-auto pb-20 space-y-16">

    {{-- ================= FORM INPUT AREA ================= --}}
    <div class="relative">
        {{-- Dekoratif Background --}}
        <div class="absolute -top-6 -left-6 w-24 h-24 bg-emerald-50 rounded-full blur-3xl opacity-70"></div>
        
        <div class="bg-white p-8 md:p-12 rounded-[2.5rem] shadow-sm border border-slate-100 relative overflow-hidden">
            
            <div class="flex items-center gap-4 mb-10">
                <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight">Tambah Data Alumni</h2>
                    <p class="text-slate-400 text-sm font-medium uppercase tracking-widest mt-0.5">Update Informasi Terkini Anda</p>
                </div>
            </div>

            {{-- ALERT SUCCESS --}}
            @if(session('success'))
                <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl mb-8 animate-fade-in">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="text-sm font-black">{{ session('success') }}</span>
                </div>
            @endif

            {{-- ALERT ERROR --}}
            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-100 text-rose-700 px-6 py-4 rounded-2xl mb-8">
                    <div class="flex items-center gap-2 mb-2 font-black text-sm uppercase">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        Ada Kendala Input:
                    </div>
                    <ul class="list-disc pl-8 space-y-1 text-xs font-bold">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.alumni.store') }}" 
      method="POST" 
      enctype="multipart/form-data"
      class="space-y-8">
                @csrf

                <div class="grid md:grid-cols-2 gap-8">
                    {{-- Nama (Readonly) --}}
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                        <input type="text"
                               value="{{ auth()->user()->nama_lengkap ?? auth()->user()->name }}"
                               class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-4 text-sm font-bold text-slate-500 cursor-not-allowed"
                               readonly>
                    </div>

                    {{-- NIK (Readonly) --}}
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">NIK</label>
                        <input type="text"
                               value="{{ auth()->user()->nik }}"
                               class="w-full bg-slate-50 border-2 border-slate-50 rounded-2xl px-5 py-4 text-sm font-bold text-slate-500 cursor-not-allowed"
                               readonly>
                    </div>

                    {{-- Tahun Kelulusan --}}
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic">Tahun Kelulusan <span class="text-rose-500">*</span></label>
                        <input type="number"
                               name="tahun_kelulusan"
                               min="2000"
                               max="{{ date('Y') }}"
                               required
                               value="{{ old('tahun_kelulusan') }}"
                               class="w-full bg-white border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-black text-slate-700 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition outline-none shadow-sm">
                    </div>

                    {{-- Kegiatan --}}
                    <div class="space-y-2">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic">Kegiatan Selanjutnya <span class="text-rose-500">*</span></label>
                        <select name="kegiatan_selanjutnya"
                                id="kegiatan"
                                required
                                class="w-full bg-white border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-black text-slate-700 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition outline-none shadow-sm appearance-none">
                            <option value="">Pilih Kegiatan</option>
                            @foreach(['Belum Bekerja','Melanjutkan Pendidikan','Bekerja','Berwirausaha'] as $item)
                                <option value="{{ $item }}" {{ old('kegiatan_selanjutnya') == $item ? 'selected' : '' }}>
                                    {{ $item }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Data Tambahan Alumni --}}
<div class="grid md:grid-cols-2 gap-8">

    {{-- Jurusan --}}
    <div class="space-y-2">
        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic">
            Jurusan <span class="text-rose-500">*</span>
        </label>
        <input type="text"
               name="jurusan"
               required
               value="{{ old('jurusan') }}"
               class="w-full bg-white border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-black text-slate-700 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition outline-none shadow-sm">
    </div>

    {{-- Instansi Asal --}}
    <div class="space-y-2">
        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic">
            Instansi Asal <span class="text-rose-500">*</span>
        </label>
        <input type="text"
               name="instansi_asal"
               required
               value="{{ old('instansi_asal') }}"
               class="w-full bg-white border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-black text-slate-700 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition outline-none shadow-sm">
    </div>

    {{-- Email --}}
    <div class="space-y-2">
        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic">
            Email Aktif <span class="text-rose-500">*</span>
        </label>
        <input type="email"
               name="email"
               required
               value="{{ old('email') }}"
               class="w-full bg-white border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-black text-slate-700 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition outline-none shadow-sm">
    </div>

    {{-- No HP --}}
    <div class="space-y-2">
        <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic">
            No HP <span class="text-rose-500">*</span>
        </label>
        <input type="text"
               name="hp"
               required
               value="{{ old('hp') }}"
               class="w-full bg-white border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-black text-slate-700 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition outline-none shadow-sm">
    </div>

</div>

{{-- Alamat --}}
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic">Alamat Domisili Saat Ini <span class="text-rose-500">*</span></label>
                    <textarea name="alamat"
                              required
                              rows="3"
                              placeholder="Contoh: Jl. Merdeka No. 123, Jakarta Selatan"
                              class="w-full bg-white border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition outline-none shadow-sm">{{ old('alamat') }}</textarea>
                </div>

{{-- Upload Ijazah --}}
<div class="space-y-2">
    <label class="text-[11px] font-black text-slate-500 uppercase tracking-widest ml-1 italic">
        Upload Foto Ijazah <span class="text-rose-500">*</span>
    </label>
    <input type="file"
           name="foto_ijazah"
           required
           class="w-full bg-white border-2 border-slate-100 rounded-2xl px-5 py-4 text-sm font-black text-slate-700 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition outline-none shadow-sm">
</div>
                {{-- Field Dinamis --}}
                <div id="fieldTambahan" class="hidden animate-fade-in">
                    <div class="space-y-2">
                        <label id="labelTambahan" class="text-[11px] font-black text-emerald-600 uppercase tracking-widest ml-1 italic"></label>
                        <input type="text"
                               name="tempat_kegiatan"
                               id="inputTambahan"
                               value="{{ old('tempat_kegiatan') }}"
                               class="w-full bg-white border-2 border-emerald-100 rounded-2xl px-5 py-4 text-sm font-black text-slate-700 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition outline-none shadow-sm">
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit"
                            class="w-full bg-slate-800 hover:bg-emerald-600 text-white font-black text-xs uppercase tracking-[0.3em] py-5 rounded-2xl transition-all duration-300 shadow-xl shadow-slate-200 flex items-center justify-center gap-3 active:scale-[0.98]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Data Alumni
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= RIWAYAT AREA ================= --}}
    <div class="space-y-8">
        <div class="flex items-center gap-4">
            <h3 class="text-2xl font-black text-slate-800 tracking-tight">Riwayat Data</h3>
            <div class="h-[2px] flex-1 bg-slate-100"></div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Nama</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">NIK</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Jurusan</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Instansi Asal</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Email</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">HP</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Tahun</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Kegiatan</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Tempat</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Alamat</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Ijazah</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-50">
    @forelse($alumni as $item)
    <tr class="hover:bg-slate-50/30 transition">

        <td class="px-8 py-6 text-sm font-bold text-slate-700">
            {{ $item->nama }}
        </td>

        <td class="px-8 py-6 text-xs font-bold text-slate-500">
            {{ $item->nik }}
        </td>

        <td class="px-8 py-6 text-xs font-bold text-slate-500">
            {{ $item->jurusan ?? '-' }}
        </td>

        <td class="px-8 py-6 text-xs font-bold text-slate-500">
            {{ $item->instansi_asal ?? '-' }}
        </td>

        <td class="px-8 py-6 text-xs font-bold text-slate-500">
            {{ $item->email ?? '-' }}
        </td>

        <td class="px-8 py-6 text-xs font-bold text-slate-500">
            {{ $item->hp ?? '-' }}
        </td>

        <td class="px-8 py-6">
            <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-700 rounded-lg font-black text-xs border border-emerald-100">
                {{ $item->tahun_kelulusan }}
            </span>
        </td>

        <td class="px-8 py-6 text-sm font-black text-slate-700">
            {{ $item->kegiatan_selanjutnya }}
        </td>

        <td class="px-8 py-6 text-xs font-bold text-slate-500">
            {{ $item->tempat_kegiatan ?? '-' }}
        </td>

        <td class="px-8 py-6 text-xs font-bold text-slate-500">
            {{ $item->alamat }}
        </td>

        <td class="px-8 py-6 text-xs font-bold text-slate-500">
            @if($item->foto_ijazah)
                <a href="{{ asset('storage/'.$item->foto_ijazah) }}" 
                   target="_blank"
                   class="text-emerald-600 hover:underline">
                    Lihat
                </a>
            @else
                -
            @endif
        </td>

    </tr>

    @empty
    <tr>
        <td colspan="11" class="py-20 text-center text-slate-400 font-bold">
            Data Kosong
        </td>
    </tr>
    @endforelse
</tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fade-in 0.4s ease-out forwards; }
</style>

<script>
    const kegiatan = document.getElementById('kegiatan');
    const field = document.getElementById('fieldTambahan');
    const label = document.getElementById('labelTambahan');
    const input = document.getElementById('inputTambahan');

    function updateField() {
        if (!kegiatan) return;

        const value = kegiatan.value;

        if (value === 'Bekerja') {
            field.classList.remove('hidden');
            label.innerText = 'Nama Perusahaan / Instansi *';
            input.required = true;
        } else if (value === 'Melanjutkan Pendidikan') {
            field.classList.remove('hidden');
            label.innerText = 'Nama Kampus / Institusi *';
            input.required = true;
        } else if (value === 'Berwirausaha') {
            field.classList.remove('hidden');
            label.innerText = 'Nama Usaha *';
            input.required = true;
        } else {
            field.classList.add('hidden');
            input.required = false;
            input.value = '';
        }
    }

    if (kegiatan) {
        kegiatan.addEventListener('change', updateField);
        window.addEventListener('load', updateField);
    }
</script>

@endsection