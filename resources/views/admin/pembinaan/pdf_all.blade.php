<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pembinaan</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
            margin: 40px;
        }

        .kop-wrapper {
            display: table;
            width: 100%;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .kop-logo {
            display: table-cell;
            width: 15%;
            vertical-align: middle;
        }

        .kop-logo img {
            width: 90px;
        }

        .kop-text {
            display: table-cell;
            text-align: center;
            vertical-align: middle;
        }

        .kop-text h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .kop-text h2 {
            margin: 3px 0;
            font-size: 16px;
            font-weight: bold;
        }

        .kop-text p {
            margin: 2px 0;
            font-size: 12px;
        }

        .judul {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 15px;
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #f0f0f0;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .summary {
            margin-bottom: 10px;
        }

        .ttd {
            margin-top: 40px;
            text-align: right;
        }
    </style>
</head>
<body>

@php
    $logoPath = public_path('logo-upz.png');
@endphp

<!-- KOP SURAT -->
<div class="kop-wrapper">
    <div class="kop-logo">
        <img src="{{ $logoPath }}">
    </div>

    <div class="kop-text">
        <h1>UNIT PENGUMPUL ZAKAT</h1>
        <h2>BAZNAS SEMEN PADANG</h2>
        <p>Komplek PT. Semen Padang L-150 No.18 Indarung, Lubuk Kilangan, Padang</p>
        <p>Telp. 0751-202499</p>
    </div>
</div>

<div class="judul">
    LAPORAN PEMBINAAN ANBIMM
</div>

<p>Bulan: {{ $bulanInput ?? '-' }}</p>

@php
    $sudahCair = 0;
    $belumCair = 0;

    foreach($users as $user){
        foreach($user->pembinaans as $item){
            if($item->status_pencairan == 'sudah'){
                $sudahCair++;
            } else {
                $belumCair++;
            }
        }
    }
@endphp

<div class="summary">
    <strong>Sudah Dicairkan:</strong> {{ $sudahCair }} <br>
    <strong>Belum Dicairkan:</strong> {{ $belumCair }}
</div>

<table>
    <thead>
        <tr>
            <th width="15%">Tanggal</th>
            <th width="30%">Nama</th>
            <th width="35%">Hafalan</th>
            <th width="20%">Status Uang</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
            @foreach($user->pembinaans as $item)
                <tr>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal_setor)->format('d-m-Y') }}
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $item->hafalan }}</td>
                    <td class="text-center">
                        {{ $item->status_pencairan == 'sudah'
                            ? 'Sudah Dicairkan'
                            : 'Belum Dicairkan' }}
                    </td>
                </tr>
            @endforeach
        @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada data</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="ttd">
    Padang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br><br><br><br>
    <strong>UPZ BAZNAS Semen Padang</strong>
</div>

</body>
</html>