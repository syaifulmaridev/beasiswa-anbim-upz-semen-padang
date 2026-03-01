@extends('layouts.app')

@section('title','Dashboard Admin')

@section('content')

<div class="min-h-screen bg-[#F8FAFC] p-4 md:p-8 space-y-8">

    {{-- ================= SUCCESS ALERT ================= --}}
    @if(session('success'))
        <div class="flex items-center p-4 mb-4 text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-100 animate-fade-in-down">
            <svg class="flex-shrink-0 w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
    @endif

    {{-- ================= WELCOME HEADER ================= --}}
    <div class="relative overflow-hidden bg-[#1f4a44] rounded-[2rem] p-8 text-white shadow-xl shadow-emerald-950/20">
        <div class="absolute top-[-20%] right-[-10%] w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight">
                    Assalamu'alaikum, <span class="text-emerald-300">{{ Auth::user()->name ?? 'Admin' }}</span> 👋
                </h1>
                <p class="text-emerald-100/70 mt-2 font-medium">
                    Pantau aktivitas santri dan kelola administrasi dalam satu jendela.
                </p>
            </div>
            
            {{-- FILTER BULAN --}}
            <form method="GET" class="w-full md:w-auto">
                <div class="relative">
                    <select name="month" onchange="this.form.submit()"
                            class="appearance-none bg-white/10 border border-white/20 text-white text-sm rounded-xl px-5 py-2.5 pr-10 focus:ring-emerald-500 focus:bg-emerald-800 transition-all cursor-pointer font-bold">
                        @for($i=1;$i<=12;$i++)
                            <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }} class="text-slate-800">
                                📅 {{ date('F', mktime(0,0,0,$i,1)) }}
                            </option>
                        @endfor
                    </select>
                </div>
            </form>
        </div>
    </div>

    {{-- ================= ERROR ALERT ================= --}}
@if(session('error'))
    <div class="flex items-center p-4 mb-4 text-red-800 rounded-2xl bg-red-50 border border-red-100 animate-fade-in-down">
        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9V5a1 1 0 112 0v4a1 1 0 11-2 0zm1 6a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                clip-rule="evenodd"></path>
        </svg>
        <span class="text-sm font-bold">{{ session('error') }}</span>
    </div>
@endif
    {{-- ================= NOTIFIKASI REMINDER ================= --}}
    @if($periodeAktif)
    <div class="group bg-amber-50 border border-amber-200 rounded-3xl p-6 transition-all hover:shadow-md">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-5">
                <div class="w-12 h-12 bg-amber-400 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-amber-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </div>
                <div>
                    <h2 class="font-black text-amber-900 uppercase tracking-tight">Periode Setoran Aktif</h2>
                    <p class="text-amber-800/70 text-sm italic">Berikan dorongan semangat kepada santri melalui reminder WhatsApp.</p>
                </div>
            </div>

            <form action="{{ route('admin.kirim.reminder') }}" method="POST" class="w-full lg:w-auto">
                @csrf
                <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold px-8 py-3 rounded-2xl transition-all shadow-lg shadow-emerald-700/20 active:scale-95">
                    🚀 Kirim Reminder Sekarang
                </button>
            </form>
        </div>
    </div>
    @endif

    {{-- ================= STATS GRID ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        @php
            $stats = [
                ['label' => 'User Aktif', 'val' => $totalUser, 'color' => 'text-slate-800', 'bg' => 'bg-slate-100', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ['label' => 'Menunggu Validasi', 'val' => $totalPending, 'color' => 'text-amber-600', 'bg' => 'bg-amber-100', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Disetujui (Bulan Ini)', 'val' => $approvedThisMonth, 'color' => 'text-emerald-600', 'bg' => 'bg-emerald-100', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Ditolak', 'val' => $totalRejected, 'color' => 'text-rose-600', 'bg' => 'bg-rose-100', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z']
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:border-emerald-200 transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 {{ $stat['bg'] }} {{ $stat['color'] }} rounded-2xl group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"></path></svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Monthly Stat</span>
            </div>
            <p class="text-slate-500 text-xs font-bold uppercase tracking-wide">{{ $stat['label'] }}</p>
            <h2 class="text-4xl font-black {{ $stat['color'] }} mt-1 counter" data-target="{{ $stat['val'] }}">0</h2>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- ================= CHART ================= --}}
        <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-xl font-black text-slate-800">Grafik Persetujuan</h2>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Data Tahunan</p>
                </div>
            </div>
            <div class="h-[350px]">
                <canvas id="userChart"></canvas>
            </div>
        </div>

        {{-- ================= LOGS ================= --}}
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-black text-slate-800">Aktivitas</h2>
                <a href="{{ route('admin.log') }}" class="text-[10px] font-black uppercase tracking-widest px-3 py-1 bg-slate-100 text-slate-600 rounded-full hover:bg-emerald-600 hover:text-white transition-all">
                    View All
                </a>
            </div>

            <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px before:h-full before:w-0.5 before:bg-gradient-to-b before:from-slate-100 before:via-slate-100 before:to-transparent">
                @forelse($recentLogs as $log)
                <div class="relative flex items-start gap-4">
                    <div class="absolute left-0 w-10 h-10 flex items-center justify-center">
                        <div class="w-3 h-3 bg-emerald-500 rounded-full ring-4 ring-white"></div>
                    </div>
                    <div class="ml-10">
                        <p class="text-sm font-bold text-slate-800 leading-tight">{{ $log->aksi }}</p>
                        <p class="text-xs text-slate-500 mt-1 line-clamp-1 italic">{{ $log->deskripsi }}</p>
                        <p class="text-[10px] text-emerald-600 font-bold mt-2 uppercase tracking-tighter">{{ $log->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-10">
                    <p class="text-slate-400 text-sm font-medium italic">Tidak ada aktivitas baru.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

{{-- ================= SCRIPTS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Counter Animation
    document.querySelectorAll('.counter').forEach(counter => {
        const update = () => {
            const target = +counter.getAttribute('data-target');
            const current = +counter.innerText;
            const increment = target / 40;
            if (current < target) {
                counter.innerText = Math.ceil(current + increment);
                setTimeout(update, 20);
            } else {
                counter.innerText = target;
            }
        };
        update();
    });

    // Chart Design
    const ctx = document.getElementById('userChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [{
                label: 'User Disetujui',
                data: @json($monthlyData),
                backgroundColor: '#1f4a44',
                hoverBackgroundColor: '#10b981',
                borderRadius: 12,
                borderSkipped: false,
                barThickness: 20
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { size: 14, weight: 'bold' },
                    cornerRadius: 12
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { drawBorder: false, color: '#f1f5f9' },
                    ticks: { color: '#94a3b8', font: { weight: 'bold' } }
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