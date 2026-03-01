@extends('layouts.app-user')

@section('title', 'Dashboard Overview')

@section('content')
<div class="min-h-screen bg-[#F8FAFC] p-4 md:p-8 space-y-8">

    <div class="relative overflow-hidden bg-emerald-900 rounded-[2rem] p-8 md:p-12 shadow-2xl shadow-emerald-900/20">
        <div class="absolute top-[-10%] right-[-5%] w-64 h-64 bg-emerald-700/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[-20%] left-[10%] w-40 h-40 bg-yellow-500/10 rounded-full blur-2xl"></div>

        <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-10">
            <div class="flex-1 text-center lg:text-left">
                <div class="inline-flex items-center px-3 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[10px] font-bold tracking-[0.2em] text-yellow-400 mb-6 uppercase">
                    <span class="relative flex h-2 w-2 mr-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-yellow-400"></span>
                    </span>
                    Status: User Aktif
                </div>

                <h2 class="text-3xl md:text-5xl font-extrabold text-white leading-tight">
                    Selamat Datang, <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-yellow-500">
                        {{ Auth::user()->nama_lengkap ?? 'User' }}
                    </span>
                </h2>

                <p class="text-emerald-100/80 mt-4 text-sm md:text-lg max-w-xl leading-relaxed">
                    Pantau perkembangan hafalan, kehadiran, dan administrasi beasiswa Anda dalam satu panel kendali.
                </p>

                @if(!empty($tanggalMulai) && !empty($tanggalSelesai))
                <div class="mt-8 inline-flex flex-wrap items-center gap-3 bg-black/20 backdrop-blur-sm p-2 px-4 rounded-2xl border border-white/5 text-sm">

                    <span class="text-emerald-300">📅 Periode:</span>

                    <span class="text-white font-medium italic">
                        {{ $tanggalMulai->format('d M Y') }}
                        —
                        {{ $tanggalSelesai->format('d M Y') }}
                    </span>

                    <span class="px-2 py-0.5 {{ $periodeAktif ? 'bg-emerald-500' : 'bg-rose-500' }} text-white text-[10px] rounded-md font-bold uppercase tracking-tighter">
                        {{ $periodeAktif ? 'Aktif' : 'Non-Aktif' }}
                    </span>

                </div>
            @endif
            </div>

            <div class="hidden lg:block relative">
                <div class="absolute inset-0 bg-yellow-400 rounded-full blur-[80px] opacity-20"></div>
                <img src="{{ asset('images/dsuser.png') }}" class="w-64 relative z-10 drop-shadow-2xl transform hover:scale-105 transition duration-500">
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 group hover:border-emerald-200 transition-all duration-300">
            <div class="flex items-center justify-between mb-6">
                <h4 class="text-xs font-black uppercase tracking-widest text-slate-400">Statistik Kehadiran</h4>
                <div class="p-2 bg-slate-50 rounded-lg group-hover:bg-emerald-50 transition-colors">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col">
                    <span class="text-[10px] text-slate-400 font-bold uppercase">Hadir</span>
                    <span class="text-xl font-bold text-emerald-600">{{ $hadir ?? 0 }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] text-slate-400 font-bold uppercase">Alpa</span>
                    <span class="text-xl font-bold text-rose-500">{{ $alpa ?? 0 }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] text-slate-400 font-bold uppercase">Izin/Sakit</span>
                    <span class="text-xl font-bold text-amber-500">{{ ($izin ?? 0) + ($sakit ?? 0) }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 group hover:border-emerald-200 transition-all duration-300">
            <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6">Total Hafalan</h4>
            <div class="flex items-baseline gap-2">
                <span class="text-5xl font-black text-slate-800 tracking-tight group-hover:text-emerald-700 transition-colors">{{ $totalHafalan ?? 0 }}</span>
                <span class="text-sm font-bold text-slate-400">Setoran</span>
            </div>
            <div class="mt-4 h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-emerald-500 rounded-full" style="width: 70%"></div>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 group hover:border-emerald-200 transition-all duration-300">
            <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6">Pencairan</h4>
            <div class="flex items-baseline gap-2">
                <span class="text-5xl font-black text-slate-800 tracking-tight group-hover:text-amber-600 transition-colors">{{ $jumlahPenerimaan ?? 0 }}</span>
                <span class="text-sm font-bold text-slate-400">Kali</span>
            </div>
            <p class="mt-4 text-xs text-slate-500 font-medium">Riwayat penerimaan beasiswa</p>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
            <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Setoran Bulan Ini</h4>
            @if($setoranBulanIni)
                <div class="flex flex-col items-center justify-center py-2 bg-emerald-50 rounded-2xl border border-emerald-100">
                    <span class="text-2xl mb-1">✅</span>
                    <span class="text-xs font-bold text-emerald-700">SUDAH SETOR</span>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-2 bg-rose-50 rounded-2xl border border-rose-100">
                    <span class="text-2xl mb-1">❌</span>
                    <span class="text-xs font-bold text-rose-700">BELUM SETOR</span>
                </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Progres Hafalan</h3>
                    <p class="text-xs text-slate-400 font-medium">Visualisasi aktivitas setoran Anda</p>
                </div>
                <select class="text-xs font-bold bg-slate-50 border-none rounded-lg focus:ring-emerald-500">
                    <option>6 Bulan Terakhir</option>
                </select>
            </div>
            <div class="h-[350px]">
                <canvas id="hafalanChart"></canvas>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100">
                <h3 class="font-black text-xs uppercase tracking-[0.2em] text-slate-400 mb-5">Pembimbing Anda</h3>
                <div class="flex items-center gap-4 p-3 rounded-2xl bg-slate-50">
                    <div class="w-14 h-14 bg-gradient-to-tr from-emerald-800 to-emerald-600 rounded-2xl flex items-center justify-center text-yellow-300 font-bold text-xl shadow-lg shadow-emerald-900/20">
                        D
                    </div>
                    <div>
                        <p class="font-bold text-slate-800">Ustazah Dewi Sartika</p>
                        <p class="text-[11px] font-bold text-emerald-600 uppercase tracking-tighter">Pembina Tahfizh</p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 rounded-[2rem] p-8 text-white relative overflow-hidden shadow-xl">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
                </div>
                <h3 class="text-lg font-bold mb-6 relative z-10">Informasi Terbaru</h3>
                <div class="space-y-6 relative z-10">
                    <div class="border-l-2 border-yellow-500 pl-4">
                        <p class="text-yellow-400 text-[10px] font-black uppercase tracking-widest mb-1">Finansial</p>
                        <p class="text-slate-300 text-sm leading-relaxed">Beasiswa termin II sedang proses verifikasi data.</p>
                    </div>
                    <div class="border-l-2 border-emerald-500 pl-4">
                        <p class="text-emerald-400 text-[10px] font-black uppercase tracking-widest mb-1">Akademik</p>
                        <p class="text-slate-300 text-sm leading-relaxed">Batas setor hafalan bulan ini: <span class="text-white font-bold">28 Februari</span>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('hafalanChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Setoran',
                data: @json($dataChart),
                borderColor: '#10b981',
                borderWidth: 4,
                backgroundColor: (context) => {
                    const bg = context.chart.ctx.createLinearGradient(0, 0, 0, 400);
                    bg.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
                    bg.addColorStop(1, 'rgba(16, 185, 129, 0)');
                    return bg;
                },
                fill: true,
                tension: 0.4,
                pointRadius: 0,
                pointHitRadius: 20,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#facc15',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { drawBorder: false, color: '#f1f5f9' },
                    ticks: { stepSize: 1, color: '#94a3b8', font: { weight: 'bold' } }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#94a3b8', font: { weight: 'bold' } }
                }
            }
        }
    });
</script>
@endsection