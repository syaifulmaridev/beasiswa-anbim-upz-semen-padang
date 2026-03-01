@extends('layouts.app')

@section('title','Detail Pendaftaran')

@section('content')

<div class="max-w-6xl mx-auto p-8 space-y-10">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Detail Pendaftaran
            </h1>
            <p class="text-sm text-slate-500">
                Informasi lengkap dan validasi berkas
            </p>
        </div>

        <div class="flex items-center gap-4">

            <a href="{{ route('admin.pendaftaran.index') }}"
               class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-2xl text-sm font-medium transition">
                ← Kembali
            </a>

            {{-- STATUS BADGE --}}
            @if($pendaftaran->status_berkas == 'pending')
                <span class="px-4 py-2 rounded-full text-xs bg-yellow-100 text-yellow-700 font-semibold">
                    ⏳ Pending
                </span>
            @elseif($pendaftaran->status_berkas == 'diterima')
                <span class="px-4 py-2 rounded-full text-xs bg-green-100 text-green-700 font-semibold">
                    ✅ Diterima
                </span>
            @elseif($pendaftaran->status_berkas == 'ditolak')
                <span class="px-4 py-2 rounded-full text-xs bg-red-100 text-red-700 font-semibold">
                    ❌ Ditolak
                </span>
            @endif

        </div>
    </div>


    {{-- ================= DATA + DOKUMEN ================= --}}
    <div class="grid md:grid-cols-2 gap-8">

       {{-- DATA PENDAFTARAN --}}
<div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">

    <h3 class="text-lg font-bold text-slate-800">
        Data Pendaftaran
    </h3>
    <div class="h-[2px] bg-slate-200 my-6"></div>

    <div class="grid md:grid-cols-2 gap-8 text-sm">

        {{-- Nama Lengkap --}}
        <div>
            <p class="text-slate-400">Nama Lengkap</p>
            <p class="font-semibold text-slate-800">
                {{ $pendaftaran->nama_lengkap }}
            </p>
        </div>

        {{-- Tempat Lahir --}}
        <div>
            <p class="text-slate-400">Tempat Lahir</p>
            <p class="font-semibold text-slate-800">
                {{ $pendaftaran->tempat_lahir }}
            </p>
        </div>

        {{-- Tanggal Lahir --}}
        <div>
            <p class="text-slate-400">Tanggal Lahir</p>
            <p class="font-semibold text-slate-800">
                {{ \Carbon\Carbon::parse($pendaftaran->tanggal_lahir)->format('d M Y') }}
            </p>
        </div>

        {{-- Jenis Kelamin --}}
        <div>
            <p class="text-slate-400">Jenis Kelamin</p>
            <p class="font-semibold text-slate-800">
                {{ $pendaftaran->jenis_kelamin }}
            </p>
        </div>

        {{-- NIM / NISN --}}
        <div>
            <p class="text-slate-400">NIM / NISN</p>
            <p class="font-semibold text-slate-800">
                {{ $pendaftaran->nim_nisn }}
            </p>
        </div>

        {{-- No HP --}}
        <div>
            <p class="text-slate-400">No HP</p>
            <p class="font-semibold text-slate-800">
                {{ $pendaftaran->no_hp }}
            </p>
        </div>

    </div>

    {{-- Alamat --}}
    <div class="mt-8 text-sm">
        <p class="text-slate-400">Alamat Lengkap</p>
        <p class="font-semibold text-slate-800">
            {{ $pendaftaran->alamat }}
        </p>
    </div>

</div>

        {{-- DOKUMEN --}}
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">

            <h3 class="text-lg font-bold text-slate-800">
                Dokumen Pendukung
            </h3>
            <div class="h-[2px] bg-slate-200 my-6"></div>

            <div class="grid grid-cols-2 gap-4 text-sm">

                @php
                    $docs = [
                        'KTP' => $pendaftaran->ktp,
                        'KK' => $pendaftaran->kk,
                        'Surat Tidak Mampu' => $pendaftaran->surat_tidak_mampu,
                        'Surat Aktif Kuliah' => $pendaftaran->surat_aktif,
                        'Rapor / KHS' => $pendaftaran->rapor_khs,
                        'Surat Berakhlak Baik' => $pendaftaran->surat_berakhlak ?? null,
                        'Surat Ibadah Masjid' => $pendaftaran->surat_ibadah ?? null,
                    ];
                @endphp

                @foreach($docs as $label => $file)
                    @if($file)
                        <a href="{{ asset('storage/'.$file) }}"
                           target="_blank"
                           class="p-4 rounded-2xl border border-slate-200 bg-slate-50 hover:bg-slate-100 transition flex justify-between items-center">
                            <span class="text-slate-700">{{ $label }}</span>
                            <span class="text-emerald-600 text-xs font-semibold">Lihat</span>
                        </a>
                    @endif
                @endforeach

            </div>
        </div>

    </div>


    {{-- ================= VALIDASI ================= --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">

        <h3 class="text-lg font-bold text-slate-800">
            Validasi Berkas
        </h3>
        <div class="h-[2px] bg-slate-200 my-6"></div>

        <form method="POST"
              action="{{ route('admin.pendaftaran.updateStatus', $pendaftaran->id) }}"
              class="space-y-6">

            @csrf

            <div>
                <label class="text-sm font-semibold text-slate-600">
                    Status Berkas
                </label>

                <select name="status_berkas"
                        id="statusSelect"
                        class="w-full mt-2 border border-slate-300 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-emerald-600 focus:outline-none">

                    <option value="pending" {{ $pendaftaran->status_berkas == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="diterima" {{ $pendaftaran->status_berkas == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ $pendaftaran->status_berkas == 'ditolak' ? 'selected' : '' }}>Ditolak</option>

                </select>
            </div>

            <div id="alasanBox"
                 class="{{ $pendaftaran->status_berkas == 'ditolak' ? '' : 'hidden' }}">

                <label class="text-sm font-semibold text-slate-600">
                    Alasan Ditolak
                </label>

                <textarea name="alasan_ditolak"
                          class="w-full mt-2 border border-slate-300 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-red-400 focus:outline-none"
                          rows="3"
                          placeholder="Masukkan alasan penolakan...">{{ $pendaftaran->alasan_ditolak }}</textarea>
            </div>

            <div class="flex justify-end">
                <button class="px-8 py-3 bg-emerald-700 hover:bg-emerald-800 text-white rounded-2xl font-semibold transition shadow-sm">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>

</div>

<script>
document.getElementById('statusSelect').addEventListener('change', function() {
    let alasanBox = document.getElementById('alasanBox');
    if(this.value === 'ditolak'){
        alasanBox.classList.remove('hidden');
    } else {
        alasanBox.classList.add('hidden');
    }
});
</script>

@endsection