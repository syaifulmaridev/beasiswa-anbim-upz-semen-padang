@extends('layouts.app-user')

@section('title','Surat Pernyataan Online')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-2xl p-10 shadow-sm border border-slate-200">

        <h2 class="text-2xl font-bold text-slate-800 mb-8 text-center">
            Surat Pernyataan Penerima Beasiswa
        </h2>

        <div class="space-y-4 text-sm text-slate-700 leading-relaxed">

            <p class="text-center font-semibold">
                MEMORANDUM OF UNDERSTANDING (MoU)
            </p>

            <p>
                Pada hari ini, {{ now()->translatedFormat('d F Y') }},
                saya yang bertanda tangan di bawah ini:
            </p>

            <div class="bg-slate-50 p-4 rounded-xl border">
                <p><strong>Nama :</strong> {{ auth()->user()->nama_lengkap ?? '-' }}</p>
                <p><strong>Tempat/Tgl Lahir :</strong> {{ $pendaftaran->tempat_lahir ?? '-' }}, {{ optional($pendaftaran->tanggal_lahir)->format('d-m-Y') }}</p>
                <p><strong>Alamat :</strong> {{ $pendaftaran->alamat ?? '-' }}</p>
                <p><strong>Perguruan Tinggi :</strong> {{ auth()->user()->kampus ?? '-' }}</p>
            </div>

            <p>
                Dengan ini menyatakan bahwa saya bersedia:
            </p>

            <ul class="list-disc pl-6 space-y-2">
                <li>Menggunakan bantuan beasiswa sesuai dengan peruntukannya.</li>
                <li>Mematuhi seluruh ketentuan Program Beasiswa.</li>
                <li>Menjaga perilaku dan berkelakuan baik.</li>
                <li>Tidak merokok selama mengikuti Program Beasiswa.</li>
                <li>Menjaga pergaulan sesuai norma agama dan kesusilaan.</li>
                <li>Tidak memberikan data yang tidak benar.</li>
            </ul>

            <p>
                Apabila saya melanggar ketentuan di atas, saya bersedia menerima sanksi
                sesuai aturan yang berlaku dari pihak UPZ BAZNAS Semen Padang.
            </p>

            <p>
                Surat pernyataan ini dibuat dalam keadaan sadar dan tanpa paksaan
                dari pihak manapun.
            </p>

        </div>

        {{-- FORM PERSETUJUAN --}}
        <form action="{{ route('user.pernyataan.kirim') }}" method="POST" class="mt-10">
            @csrf

            <div class="flex items-start gap-3">
                <input type="checkbox" name="setuju" required
                       class="mt-1 w-5 h-5 text-emerald-600 border-gray-300 rounded">
                <label class="text-sm text-slate-700">
                    Saya menyetujui dan menyatakan bahwa seluruh isi pernyataan di atas adalah benar.
                </label>
            </div>

            <button type="submit"
                class="mt-6 w-full bg-emerald-600 text-white py-3 rounded-xl font-semibold hover:bg-emerald-700 transition">
                Setujui & Kirim Pernyataan
            </button>
        </form>

    </div>

</div>

@endsection