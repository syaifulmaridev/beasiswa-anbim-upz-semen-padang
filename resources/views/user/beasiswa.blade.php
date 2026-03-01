@extends('layouts.app-user')

@section('title','Status Beasiswa')

@section('content')

<h1 class="text-2xl font-bold mb-8">
    Status Beasiswa
</h1>

@if($pendaftaran)

@php
    $step = match($pendaftaran->status) {
        'pending' => 2,
        'diproses' => 2,
        'wawancara' => 3,
        'survey' => 4,
        'diterima', 'ditolak' => 5,
        default => 1
    };

    $steps = [
        1 => 'Pendaftaran',
        2 => 'Validasi Admin',
        3 => 'Wawancara',
        4 => 'Survey Lapangan',
        5 => 'Pengumuman'
    ];
@endphp