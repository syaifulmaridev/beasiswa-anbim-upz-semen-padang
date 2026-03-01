@extends('layouts.app')

@section('title','Pengaturan Sistem')

@section('content')

<div class="max-w-2xl mx-auto pb-10">

    {{-- HEADER SECTION --}}
    <div class="mb-8 text-center md:text-left">
        <h1 class="text-3xl font-black text-slate-800 tracking-tight">
            Pengaturan <span class="text-emerald-600">Sistem</span>
        </h1>
        <p class="text-slate-500 font-medium mt-1">Konfigurasi parameter global dan periode operasional.</p>
    </div>

    {{-- CARD UTAMA --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        
        {{-- Sub-Header dengan Icon --}}
        <div class="px-8 py-6 bg-slate-50/50 border-b border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-slate-800 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-slate-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <h2 class="font-black text-slate-800 uppercase tracking-wider text-sm">Periode Setoran Hafalan</h2>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-0.5">Penetapan jadwal aktif pengisian</p>
            </div>
        </div>

        <div class="p-8">
            {{-- ALERT SUCCESS --}}
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl animate-fade-in">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span class="text-sm font-black">{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('admin.pengaturan.update') }}" method="POST" class="space-y-8">
                @csrf

                <div class="grid md:grid-cols-2 gap-8">
                    {{-- TANGGAL MULAI --}}
                    <div class="group">
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1 group-focus-within:text-emerald-600 transition-colors">
                            Tanggal Mulai
                        </label>
                        <div class="relative">
                            <input type="date"
                                   name="setoran_mulai"
                                   value="{{ old('setoran_mulai', $setting->setoran_mulai?->format('Y-m-d')) }}"
                                   class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-black text-slate-700 focus:ring-4 focus:ring-emerald-500/10 transition outline-none"
                                   required>
                        </div>
                        <p class="mt-2 text-[10px] text-slate-400 font-medium ml-1 italic">Sistem akan dibuka mulai tanggal ini.</p>
                    </div>

                    {{-- TANGGAL SELESAI --}}
                    <div class="group">
                        <label class="block text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1 group-focus-within:text-rose-600 transition-colors">
                            Tanggal Selesai
                        </label>
                        <div class="relative">
                            <input type="date"
                                   name="setoran_selesai"
                                   value="{{ old('setoran_selesai', $setting->setoran_selesai?->format('Y-m-d')) }}"
                                   class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-black text-slate-700 focus:ring-4 focus:ring-rose-500/10 transition outline-none"
                                   required>
                        </div>
                        <p class="mt-2 text-[10px] text-slate-400 font-medium ml-1 italic">Akses setoran ditutup setelah tanggal ini.</p>
                    </div>
                </div>

                {{-- INFO BOX --}}
                <div class="bg-amber-50 rounded-2xl p-5 border border-amber-100 flex gap-4">
                    <div class="text-amber-500 mt-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-xs text-amber-800 font-bold leading-relaxed">
                        Perhatian: Pastikan rentang tanggal sudah sesuai dengan SOP Perusahan. Perubahan ini akan langsung berdampak pada kemampuan User untuk menginput setoran hafalan di dashboard mereka.
                    </p>
                </div>

                <div class="pt-4">
                    <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-emerald-200 transition active:scale-[0.98] flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Konfigurasi Baru
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- FOOTER INFO --}}
    <p class="text-center text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-8">
        Terakhir diperbarui: {{ $setting->updated_at?->diffForHumans() ?? '-' }}
    </p>

</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.4s ease-out forwards;
    }
</style>

@endsection