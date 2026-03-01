@extends('layouts.app-user')

@section('title', 'Pendaftaran Beasiswa')

@section('content')

<div class="max-w-4xl mx-auto pb-20"
     x-data="formStep()"
     x-init="init()">

    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 mb-8 relative overflow-hidden">
        {{-- Ornamen Dekoratif --}}
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-emerald-50 rounded-full blur-3xl"></div>
        
        <div class="relative">
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">
                Formulir <span class="text-emerald-600">Pendaftaran</span>
            </h2>
            <p class="text-slate-500 font-medium mt-2">Program Zakat Pendidikan: Lengkapi data diri dan berkas pendukung.</p>
        </div>

        <div class="relative mt-12 flex justify-between items-center">
            {{-- Background Line --}}
            <div class="absolute top-1/2 left-0 w-full h-1 bg-slate-100 -translate-y-1/2 rounded-full"></div>
            {{-- Active Line --}}
            <div class="absolute top-1/2 left-0 h-1 bg-emerald-500 -translate-y-1/2 rounded-full transition-all duration-500"
                 :style="`width: ${((step - 1) / 2) * 100}%` "></div>

            <div class="relative flex flex-col items-center gap-3">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center transition-all duration-500 shadow-lg"
                     :class="step >= 1 ? 'bg-emerald-600 text-white rotate-12' : 'bg-white text-slate-300 border-2 border-slate-100'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-[0.2em]" :class="step >= 1 ? 'text-emerald-700' : 'text-slate-400'">Profil</span>
            </div>

            <div class="relative flex flex-col items-center gap-3">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center transition-all duration-500 shadow-lg"
                     :class="step >= 2 ? 'bg-emerald-600 text-white rotate-12' : 'bg-white text-slate-300 border-2 border-slate-100'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-[0.2em]" :class="step >= 2 ? 'text-emerald-700' : 'text-slate-400'">Berkas</span>
            </div>

            <div class="relative flex flex-col items-center gap-3">
                <div class="w-10 h-10 rounded-2xl flex items-center justify-center transition-all duration-500 shadow-lg"
                     :class="step >= 3 ? 'bg-emerald-600 text-white rotate-12' : 'bg-white text-slate-300 border-2 border-slate-100'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-[0.2em]" :class="step >= 3 ? 'text-emerald-700' : 'text-slate-400'">Selesai</span>
            </div>
        </div>
    </div>


    <form method="POST"
          action="{{ route('user.pendaftaran.store') }}"
          enctype="multipart/form-data"
          class="space-y-8">
        @csrf

        <div x-show="step === 1"
             x-transition:enter="transition ease-out duration-400"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">

            <div class="flex items-center gap-4 mb-8">
                <span class="bg-emerald-100 text-emerald-700 w-8 h-8 rounded-full flex items-center justify-center font-black text-sm">1</span>
                <h3 class="text-xl font-black text-slate-800 uppercase tracking-wider">Data Pribadi</h3>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Lengkap *</label>
                    <input type="text" name="nama_lengkap" x-model="form.nama_lengkap" 
                           class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-emerald-500/10 transition outline-none">
                </div>

                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Tempat Lahir *</label>
                    <input type="text" name="tempat_lahir" x-model="form.tempat_lahir" 
                           class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-emerald-500/10 transition outline-none">
                </div>

                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal Lahir *</label>
                    <input type="date" name="tanggal_lahir" x-model="form.tanggal_lahir" 
                           class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-emerald-500/10 transition outline-none">
                </div>

                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Jenis Kelamin *</label>
                    <select name="jenis_kelamin" x-model="form.jenis_kelamin" 
                            class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-emerald-500/10 transition outline-none appearance-none">
                        <option value="">Pilih</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">NIM / NISN *</label>
                    <input type="text" name="nim_nisn" x-model="form.nim_nisn" 
                           class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-emerald-500/10 transition outline-none">
                </div>

                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">No HP / WhatsApp *</label>
                    <input type="text" name="no_hp" x-model="form.no_hp" 
                           class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-emerald-500/10 transition outline-none">
                </div>
            </div>

            <div class="mt-8 space-y-2">
                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Alamat Domisili Lengkap *</label>
                <textarea name="alamat" x-model="form.alamat" rows="3" 
                          class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-emerald-500/10 transition outline-none"></textarea>
            </div>

            <div class="mt-10 flex justify-end">
                <button type="button" @click="nextStep()" 
                        class="bg-slate-800 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-emerald-600 transition shadow-xl shadow-slate-200 flex items-center gap-2">
                    Lanjut Berkas
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </div>

        <div x-show="step === 2"
             x-transition:enter="transition ease-out duration-400"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">

            <div class="flex items-center gap-4 mb-2">
                <span class="bg-emerald-100 text-emerald-700 w-8 h-8 rounded-full flex items-center justify-center font-black text-sm">2</span>
                <h3 class="text-xl font-black text-slate-800 uppercase tracking-wider">Unggah Berkas</h3>
            </div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-10 ml-12">Format: JPG, PNG, PDF (Maks 2MB)</p>

            <div class="grid md:grid-cols-2 gap-8">
                @php
                    $docs = [
                        'ktp' => 'KTP',
                        'kk' => 'Kartu Keluarga',
                        'surat_tidak_mampu' => 'SKTM',
                        'surat_aktif' => 'Ket. Aktif Kuliah',
                        'rapor_khs' => 'Rapor / KHS',
                        'surat_berakhlak' => 'Ket. Akhlak Baik'
                    ];
                @endphp

                @foreach($docs as $name => $label)
                <div class="space-y-3">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">{{ $label }} *</label>
                    <div class="relative group">
                        <input type="file" name="{{ $name }}" 
                               class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition border-2 border-dashed border-slate-100 rounded-2xl p-2 group-hover:border-emerald-200">
                    </div>
                </div>
                @endforeach

                <div class="md:col-span-2 space-y-3">
                    <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Surat Keterangan Aktif Ibadah di Masjid *</label>
                    <input type="file" name="surat_ibadah" 
                           class="w-full text-xs text-slate-500 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-emerald-50 file:text-emerald-700 border-2 border-dashed border-slate-100 rounded-2xl p-2">
                </div>
            </div>

            <div class="mt-12 flex justify-between items-center">
                <button type="button" @click="prevStep()" class="text-slate-400 font-black text-xs uppercase tracking-widest hover:text-slate-600 transition">
                    ← Kembali
                </button>
                <button type="button" @click="confirmStep()" 
                        class="bg-emerald-600 text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-emerald-700 transition shadow-xl shadow-emerald-100 flex items-center gap-2">
                    Lanjut Konfirmasi
                </button>
            </div>
        </div>

        <div x-show="step === 3"
             x-transition:enter="transition ease-out duration-400"
             x-transition:enter-start="opacity-0 translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="bg-slate-800 p-10 rounded-[2.5rem] shadow-2xl text-center">
            
            <div class="w-20 h-20 bg-emerald-500 rounded-[2rem] flex items-center justify-center text-white mx-auto mb-6 shadow-lg shadow-emerald-500/20 rotate-12">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>

            <h3 class="text-2xl font-black text-white uppercase tracking-widest mb-4">Hampir Selesai!</h3>
            <p class="text-slate-400 font-medium mb-10 max-w-md mx-auto">
                Silakan periksa kembali data Anda. Dengan mengklik tombol di bawah, Anda menyatakan bahwa data yang diisi adalah benar dan jujur.
            </p>

            <div class="flex flex-col gap-4">
                <button type="submit"
                        class="w-full bg-emerald-500 hover:bg-emerald-400 text-white py-5 rounded-2xl font-black text-sm uppercase tracking-[0.3em] transition shadow-xl shadow-emerald-500/20 active:scale-[0.98]">
                    Kirim Pendaftaran Sekarang
                </button>
                <button type="button" @click="step = 1" class="text-slate-500 font-black text-[10px] uppercase tracking-widest hover:text-white transition">
                    Periksa Ulang Data
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function formStep() {
    return {
        step: 1,
        form: {
            nama_lengkap: @json(auth()->user()->name),
            tempat_lahir: '',
            tanggal_lahir: '',
            jenis_kelamin: '',
            nim_nisn: '',
            no_hp: '',
            alamat: ''
        },
        init() {
            window.scrollTo({ top: 0, behavior: 'smooth' })
        },
        nextStep() {
            if (!this.form.nama_lengkap || !this.form.tempat_lahir || !this.form.tanggal_lahir || 
                !this.form.jenis_kelamin || !this.form.nim_nisn || !this.form.no_hp || !this.form.alamat) {
                alert('Mohon lengkapi seluruh kolom Data Pribadi sebelum melanjutkan.')
                return
            }
            this.step = 2
            window.scrollTo({ top: 0, behavior: 'smooth' })
        },
        prevStep() {
            this.step--
            window.scrollTo({ top: 0, behavior: 'smooth' })
        },
        confirmStep() {
            this.step = 3
            window.scrollTo({ top: 0, behavior: 'smooth' })
        }
    }
}
</script>

@endsection