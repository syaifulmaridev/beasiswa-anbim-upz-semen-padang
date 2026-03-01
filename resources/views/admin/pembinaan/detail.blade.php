@extends('layouts.app')

@section('title','Detail Pembinaan')

@section('content')

<div class="min-h-screen bg-[#F8FAFC] p-4 md:p-8 space-y-10">

    <div class="relative overflow-hidden bg-[#1f4a44] rounded-[2.5rem] p-8 md:p-10 text-white shadow-2xl">
        <div class="absolute top-[-20%] right-[-10%] w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-10">
            <div>
                <div class="inline-flex items-center gap-2 bg-white/10 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-4 border border-white/10">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                    Monitoring Profile
                </div>
                <h2 class="text-4xl font-black tracking-tight">
                    {{ $user->name }}
                </h2>
                <p class="text-emerald-100/70 mt-2 font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                    NIK: {{ $user->nik }}
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 w-full lg:w-auto">
                @php
                    $stats = [
                        ['label' => 'Total', 'val' => $totalHafalan, 'color' => 'text-white'],
                        ['label' => 'Hadir', 'val' => $totalHadir, 'color' => 'text-emerald-400'],
                        ['label' => 'Alpa', 'val' => $totalAlpa, 'color' => 'text-rose-400'],
                        ['label' => 'Izin/Sakit', 'val' => ($totalIzin + ($totalSakit ?? 0)), 'color' => 'text-amber-400'],
                    ];
                @endphp
                @foreach($stats as $stat)
                <div class="bg-white/10 backdrop-blur-md border border-white/10 p-5 rounded-[1.5rem] text-center">
                    <p class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-1">{{ $stat['label'] }}</p>
                    <p class="text-3xl font-black {{ $stat['color'] }}">{{ $stat['val'] ?? 0 }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-sm border border-slate-100">
        <div class="flex items-center gap-4 mb-10">
            <div class="w-12 h-12 bg-emerald-100 text-[#1f4a44] rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </div>
            <div>
                <h3 class="text-xl font-black text-slate-800">Input Setoran & Kehadiran</h3>
                <p class="text-sm text-slate-400 font-medium italic">Tambahkan catatan pembinaan terbaru di bawah ini.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.pembinaan.store',$user->id) }}" class="space-y-10">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="group">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal Setor</label>
                    <input type="date" name="tanggal_setor" required
                           class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 mt-2 focus:ring-4 focus:ring-emerald-500/10 transition-all font-semibold text-slate-700">
                </div>
                <div class="group">
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Nama Hafalan (Surah/Juz)</label>
                    <input type="text" name="hafalan" required placeholder="Misal: Surah Al-Baqarah 1-10"
                           class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 mt-2 focus:ring-4 focus:ring-emerald-500/10 transition-all font-semibold text-slate-700">
                </div>
            </div>

            <div class="group">
                <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Keterangan Hafalan</label>
                <textarea name="keterangan_hafalan" rows="3" placeholder="Berikan catatan detail mengenai kualitas hafalan santri..."
                          class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 mt-2 focus:ring-4 focus:ring-emerald-500/10 transition-all font-semibold text-slate-700"></textarea>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                <div>
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1 mb-4 block">Status Kehadiran</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach(['hadir', 'izin', 'sakit', 'alpa'] as $status)
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="hadir_status" value="{{ $status }}" class="peer hidden" {{ $status == 'hadir' ? 'checked' : '' }} onchange="toggleAlasan('{{ $status }}')">
                            <div class="py-3 text-center rounded-xl border-2 border-slate-100 font-bold text-sm text-slate-400 peer-checked:border-[#1f4a44] peer-checked:bg-emerald-50 peer-checked:text-[#1f4a44] transition-all group-hover:border-slate-200">
                                {{ ucfirst($status) }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1 mb-4 block">Pencairan Dana</label>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach(['belum' => 'Belum Cair', 'sudah' => 'Sudah Cair'] as $val => $label)
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="status_pencairan" value="{{ $val }}" class="peer hidden" {{ $val == 'belum' ? 'checked' : '' }}>
                            <div class="py-3 text-center rounded-xl border-2 border-slate-100 font-bold text-sm text-slate-400 peer-checked:border-[#1f4a44] peer-checked:bg-emerald-50 peer-checked:text-[#1f4a44] transition-all group-hover:border-slate-200">
                                {{ $label }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div id="alasanBox" class="hidden animate-fade-in">
                <label class="text-xs font-black text-rose-400 uppercase tracking-widest ml-1">Catatan Absensi / Alasan</label>
                <textarea name="catatan" rows="2" placeholder="Tulis alasan ketidakhadiran di sini..."
                          class="w-full bg-rose-50/50 border border-rose-100 rounded-2xl px-5 py-4 mt-2 focus:ring-4 focus:ring-rose-500/10 transition-all font-semibold text-slate-700"></textarea>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full md:w-auto px-12 py-4 bg-[#1f4a44] text-white rounded-2xl font-black shadow-xl shadow-emerald-900/20 hover:scale-[1.02] active:scale-95 transition-all">
                    Simpan Data Pembinaan
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50">
            <h3 class="text-xl font-black text-slate-800">Riwayat Setoran</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        <th class="px-8 py-5">Tanggal</th>
                        <th class="px-8 py-5">Detail Hafalan</th>
                        <th class="px-8 py-5 text-center">Kehadiran</th>
                        <th class="px-8 py-5 text-center">Status Dana</th>
                        <th class="px-8 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-600">
                    @forelse($data as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-5 font-bold text-slate-800">
                            {{ \Carbon\Carbon::parse($item->tanggal_setor)->format('d M Y') }}
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-700">{{ $item->hafalan }}</span>
                                <span class="text-xs text-slate-400 italic mt-0.5">{{ $item->keterangan_hafalan ?? 'Tanpa keterangan' }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            @php
                                $colors = [
                                    'hadir' => 'bg-emerald-50 text-emerald-600',
                                    'izin' => 'bg-amber-50 text-amber-600',
                                    'sakit' => 'bg-blue-50 text-blue-600',
                                    'alpa' => 'bg-rose-50 text-rose-600'
                                ];
                            @endphp
                            <span class="px-3 py-1.5 rounded-lg font-black text-[10px] uppercase {{ $colors[$item->hadir_status] ?? 'bg-slate-100' }}">
                                {{ $item->hadir_status }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-center">
                            @if($item->status_pencairan == 'sudah')
                                <span class="text-emerald-500 font-black text-[10px] uppercase">✅ Dicairkan</span>
                            @else
                                <span class="text-amber-500 font-black text-[10px] uppercase">⏳ Menunggu</span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-right">
                            <form method="POST" action="{{ route('admin.pembinaan.destroy',$item->id) }}" onsubmit="return confirm('Hapus riwayat ini?')">
                                @csrf @method('DELETE')
                                <button class="text-slate-300 hover:text-rose-600 transition-colors p-2 rounded-xl hover:bg-rose-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-slate-400 font-medium italic">Belum ada riwayat setoran untuk santri ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-8 bg-slate-50/50">
            {{ $data->links() }}
        </div>
    </div>
</div>

<script>
function toggleAlasan(status) {
    const box = document.getElementById('alasanBox');
    if(status === 'hadir') {
        box.classList.add('hidden');
    } else {
        box.classList.remove('hidden');
    }
}
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeIn 0.3s ease-out forwards; }
</style>

@endsection