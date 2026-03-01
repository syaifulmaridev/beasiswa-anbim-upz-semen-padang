@extends('layouts.app-user')

@section('title','Tracking Status')

@section('content')

@php
$pendaftaran = $pendaftaran ?? null;

/*
|--------------------------------------------------------------------------
| PENENTUAN STEP AKTIF
|--------------------------------------------------------------------------
|
| 1 = Pending
| 2 = Verifikasi
| 3 = Survey
| 4 = Penetapan
| 5 = Surat Pernyataan
| 6 = Diterima
|
*/
$currentStep = 1;

if ($pendaftaran) {

    switch ($pendaftaran->status_berkas) {

        case 'pending':
            $currentStep = 1;
            break;

        case 'verifikasi':
            $currentStep = 2;
            break;

        case 'survey':
            $currentStep = 3;
            break;

        case 'penetapan':
            if ($pendaftaran->surat_pernyataan == 1) {
                // LANGSUNG NAIK KE STEP 6
                $currentStep = 6;
            } else {
                $currentStep = 4;
            }
            break;

        case 'diterima':
            $currentStep = 6;
            break;

        case 'ditolak':
            $currentStep = 1;
            break;
    }

}

$steps = [
    1 => 'Pendaftaran Dikirim',
    2 => 'Berkas Diverifikasi',
    3 => 'Survey Lapangan',
    4 => 'Penetapan Penerima',
    5 => 'Surat Pernyataan Online',
    6 => 'Beasiswa Disetujui',
];
@endphp


<div class="max-w-3xl mx-auto">
<div class="bg-white rounded-2xl p-10 shadow-sm border border-slate-200">

<h2 class="text-2xl font-bold text-slate-800 mb-10">
    Tracking Proses Beasiswa
</h2>

<div class="relative">
<div class="absolute left-5 top-0 bottom-0 w-1 bg-slate-200"></div>

<div class="space-y-12">

@foreach($steps as $number => $label)

@php
$isDone = $number < $currentStep;
$isActive = $number == $currentStep;

/* 
Kalau sudah diterima,
maka step 6 juga dianggap selesai (hijau)
*/
if ($pendaftaran?->status_berkas === 'diterima' && $number == 6) {
    $isDone = true;
    $isActive = false;
}
@endphp

<div class="relative flex items-start gap-6">

    {{-- BULATAN --}}
    <div class="relative z-10">
        @if($isDone)
            <div class="w-10 h-10 bg-emerald-600 rounded-full flex items-center justify-center text-white shadow-lg">
                ✓
            </div>
        @elseif($isActive)
            <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center text-white shadow-lg animate-pulse">
                {{ $number }}
            </div>
        @else
            <div class="w-10 h-10 bg-slate-300 rounded-full flex items-center justify-center text-white">
                {{ $number }}
            </div>
        @endif
    </div>

    {{-- KONTEN --}}
    <div class="flex-1">

        <h3 class="font-semibold
            @if($isDone) text-emerald-600
            @elseif($isActive) text-yellow-500
            @else text-slate-400
            @endif">
            {{ $label }}
        </h3>

       <p class="text-sm mt-1 text-slate-600">
    @if($number == 6 && $pendaftaran?->status_berkas === 'diterima')
        🎉 Beasiswa Anda telah disetujui.
    @elseif($isDone)
        Tahap ini telah selesai diproses.
    @elseif($isActive)
        Sedang dalam proses...
    @else
        Menunggu tahap sebelumnya selesai.
    @endif
</p>

        {{-- TOMBOL ISI SURAT --}}
        @if(
            $number == 4 &&
            $pendaftaran?->status_berkas === 'penetapan' &&
            $pendaftaran?->surat_pernyataan == 0
        )
            <div class="mt-4">
                <a href="{{ route('user.pernyataan.form') }}"
                   class="inline-block bg-emerald-600 text-white px-6 py-2 rounded-lg hover:bg-emerald-700 transition shadow">
                   Lanjut Isi Surat Pernyataan →
                </a>
            </div>
        @endif

        {{-- INFO SUDAH TTD --}}
        @if($number == 5 && $pendaftaran?->surat_pernyataan == 1)
            <div class="mt-3 text-emerald-600 text-sm font-semibold">
                ✔ Surat pernyataan telah dikirim
            </div>
        @endif

    </div>
</div>

@endforeach


{{-- JIKA DITOLAK --}}
@if($pendaftaran?->status_berkas === 'ditolak')

<div class="relative flex items-start gap-6">

    <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center text-white shadow-lg">
        !
    </div>

    <div>
        <h3 class="font-semibold text-red-600">
            Pengajuan Ditolak
        </h3>

        <p class="text-sm text-slate-500 mt-1">
            Silakan hubungi admin untuk informasi lebih lanjut.
        </p>
    </div>

</div>

@endif

</div>
</div>
</div>
</div>

@endsection