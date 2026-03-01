<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UPZ Semen Padang</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* ✅ HANYA BAGIAN INI YANG DIUBAH */
       .glass-card {
    background: rgba(0, 0, 0, 0.4);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}

        .glass-card::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(74, 222, 128, 0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        .input-premium {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-premium:focus {
            background: rgba(255, 255, 255, 0.08) !important;
            border-color: rgba(74, 222, 128, 0.5);
            box-shadow: 0 0 20px rgba(74, 222, 128, 0.15);
            transform: translateY(-2px);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            box-shadow: 0 15px 30px -5px rgba(16, 185, 129, 0.6);
            transform: translateY(-3px);
            filter: brightness(1.1);
        }

        .vignette-overlay {
            background: radial-gradient(circle at center, transparent 0%, rgba(0,0,0,0.4) 40%, rgba(0,0,0,0.8) 100%);
        }

        .floating {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>

<body class="min-h-screen bg-[#0a0a0a] relative overflow-x-hidden flex items-center justify-center">

    <div class="fixed inset-0 z-0">
        <img src="{{ asset('images/bg-upz.jpeg') }}" class="w-full h-full object-cover opacity-60" alt="Background">
        <div class="absolute inset-0 vignette-overlay"></div>
    </div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <div class="hidden lg:block space-y-8 animate__animated animate__fadeIn">
                <div class="inline-flex items-center space-x-3 px-4 py-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-md">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                    <span class="text-white/80 text-xs font-semibold tracking-widest uppercase">Pemberdayaan Umat</span>
                </div>

                <div class="space-y-4">
                    <h1 class="text-6xl xl:text-7xl font-extrabold text-white leading-[1.1]">
                        Wujudkan <br>
                        Masa Depan <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-300">Madani.</span>
                    </h1>
                    <p class="text-white/60 text-xl leading-relaxed max-w-lg font-light">
                        Akses layanan pendidikan dan sosial dalam satu genggaman. Membangun generasi unggul melalui pengelolaan zakat yang transparan.
                    </p>
                </div>
            </div>

            <div class="w-full max-w-[440px] mx-auto animate__animated animate__zoomIn">
                <div class="glass-card rounded-[2.5rem] p-10 lg:p-12">
                    
                    <div class="flex flex-col items-center mb-10">
                        <div class="w-20 h-20 p-4 rounded-3xl bg-white/10 backdrop-blur-xl mb-6 flex items-center justify-center border border-white/10 floating">
                            <img src="{{ asset('images/upz-logo.png') }}" alt="Logo" class="w-full object-contain">
                        </div>
                        <h2 class="text-white font-extrabold text-3xl tracking-tight">Portal Masuk</h2>
                        <p class="text-white/40 text-sm mt-2 font-light">Masukkan kredensial Anda untuk melanjutkan</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-green-400 uppercase tracking-[0.2em] ml-1">Nomor Induk Kependudukan</label>
                            <input type="text" 
                                name="nik"
                                id="nikInput"
                                required
                                maxlength="16"
                                inputmode="numeric"
                                oninput="validateNIK(this)"
                                value="{{ old('nik') }}"
                                placeholder="Masukkan NIK Anda"
                                class="w-full px-5 py-3.5 rounded-2xl input-premium text-sm placeholder:text-white/20">

                        @error('nik')
                            <p class="text-red-400 text-xs mt-2 ml-2">{{ $message }}</p>
                        @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-bold text-green-400 uppercase tracking-[0.2em] ml-1">Kata Sandi</label>
                            <input type="password" 
                                name="password"
                                required
                                minlength="8"
                                oninput="validatePassword(this)"
                                placeholder="••••••••"
                                class="w-full px-5 py-3.5 rounded-2xl input-premium text-sm placeholder:text-white/20">
                        @error('password')
                            <p class="text-red-400 text-xs mt-2 ml-2">{{ $message }}</p>
                        @enderror
                        </div>

                        <button type="submit" class="w-full py-4.5 rounded-2xl font-bold text-white btn-gradient text-sm uppercase tracking-widest mt-4">
                            Masuk Ke Akun
                        </button>
                    </form>

                    <div class="mt-12 pt-8 border-t border-white/5 space-y-6">
                        <p class="text-center text-sm text-white/40">
                            Baru di sini? 
                            <a href="{{ route('register') }}" class="text-green-400 font-bold hover:text-green-300 transition-all underline-offset-8 hover:underline ml-1">Buat Akun</a>
                        </p>
                        
                        <div class="flex justify-center">
                            <a href="{{ route('landing') }}" class="group flex items-center space-x-2 text-[10px] text-white/30 hover:text-white transition-all uppercase tracking-[0.3em]">
                                <svg class="w-3 h-3 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                <span>Kembali ke Beranda</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

<script>
function validateNIK(input) {

    input.value = input.value.replace(/[^0-9]/g, '');

    if (input.value.length === 0) {
        input.setCustomValidity("NIK wajib diisi");
    } 
    else if (input.value.length < 16) {
        input.setCustomValidity("NIK harus 16 digit");
    } 
    else {
        input.setCustomValidity("");
    }
}

function validatePassword(input) {

    if (input.value.length === 0) {
        input.setCustomValidity("Password wajib diisi");
    }
    else if (input.value.length < 8) {
        input.setCustomValidity("Password minimal 8 karakter");
    } 
    else {
        input.setCustomValidity("");
    }
}
</script>
</body>
</html>
