<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - UPZ Semen Padang</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .glass-card {
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }


        .input-premium {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white !important;
            transition: all 0.3s ease;
        }

        .input-premium:focus {
            background: rgba(255, 255, 255, 0.1) !important;
            border-color: #4ade80;
            box-shadow: 0 0 15px rgba(74, 222, 128, 0.2);
            outline: none;
        }

        .vignette-overlay {
            background: radial-gradient(circle at center, transparent 0%, rgba(0,0,0,0.4) 40%, rgba(0,0,0,0.8) 100%);
        }
    </style>
</head>

<body class="min-h-screen bg-[#0a0a0a] relative overflow-x-hidden flex items-center">

    <div class="fixed inset-0 z-0">
        <img src="{{ asset('images/bg-upz.jpeg') }}" class="w-full h-full object-cover opacity-60" alt="Background">
        <div class="absolute inset-0 vignette-overlay"></div>
    </div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <div class="hidden lg:block space-y-8 animate__animated animate__fadeInLeft">
                <div class="inline-flex items-center space-x-3 px-4 py-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-md">
                    <span class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                    <span class="text-white/80 text-xs font-semibold tracking-widest uppercase">Pemberdayaan Umat</span>
                </div>

                <div class="space-y-4">
                    <h1 class="text-6xl font-extrabold text-white leading-tight">
                        Mulai Langkah <br>
                        Kebaikan <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-300">Sekarang.</span>
                    </h1>
                    <p class="text-white/60 text-lg leading-relaxed max-w-md font-light border-l-2 border-green-500/50 pl-6">
                        Bergabunglah dengan ekosistem UPZ BAZNAS Semen Padang untuk masa depan pendidikan yang lebih inklusif dan transparan.
                    </p>
                </div>
            </div>

            <div class="w-full max-w-[480px] mx-auto animate__animated animate__fadeInRight">
                <div class="glass-card rounded-[2.5rem] p-8 lg:p-10">
                    
                    <div class="flex flex-col items-center mb-8">
                        <img src="{{ asset('images/upz-logo.png') }}" alt="Logo" class="w-16 mb-4">
                        <h2 class="text-white font-bold text-2xl">Daftar Akun</h2>
                        <p class="text-white/40 text-sm mt-1">Lengkapi data diri Anda dengan benar</p>
                    </div>

                    <form method="POST" action="/register" class="space-y-4">
                        @csrf

                        <div class="space-y-1">
                            <label class="block text-[10px] font-bold text-green-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                            <input type="text" name="name" required
                                   placeholder="Masukkan Nama Lengkap"
                                   class="w-full px-5 py-3.5 rounded-2xl input-premium text-sm placeholder:text-white/20">
                            @error('name')
    <p class="text-red-400 text-xs mt-1 ml-1">{{ $message }}</p>
@enderror
                        </div>

                        <div class="space-y-1">
                            <label class="block text-[10px] font-bold text-green-400 uppercase tracking-widest ml-1">NIK (16 Digit)</label>
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
                            <p class="text-red-400 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1">
                            <label class="block text-[10px] font-bold text-green-400 uppercase tracking-widest ml-1">
                                Password
                            </label>

                            <input type="password" 
                                name="password"
                                required
                                minlength="8"
                                oninput="validatePassword(this)"
                                placeholder="••••••••"
                                class="w-full px-5 py-3.5 rounded-2xl input-premium text-sm placeholder:text-white/20">

                            @error('password')
                                <p class="text-red-400 text-xs mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                            <div class="space-y-1">
                                <label class="block text-[10px] font-bold text-green-400 uppercase tracking-widest ml-1">Konfirmasi</label>
                                <input type="password" 
                                    name="password_confirmation"
                                    id="passwordInput"
                                    required
                                    minlength="8"
                                    oninput="validatePassword(this)"
                                    placeholder="••••••••"
                                    class="w-full px-5 py-3.5 rounded-2xl input-premium text-sm placeholder:text-white/20">
                                @error('password')
                                    <p class="text-red-400 text-xs mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" 
                                class="w-full py-4 mt-4 rounded-2xl font-bold text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 transform hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 shadow-xl shadow-green-900/20 uppercase tracking-widest text-xs">
                            Buat Akun Sekarang
                        </button>
                    </form>

                    <div class="mt-8 pt-6 border-t border-white/5 text-center">
                        <p class="text-sm text-white/40">
                            Sudah punya akun? 
                            <a href="/login" class="text-green-400 font-bold hover:text-green-300 transition-colors ml-1">Login di sini</a>
                        </p>
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