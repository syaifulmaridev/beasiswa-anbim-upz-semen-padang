<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Program Beasiswa Generasi Qur'ani - UPZ Semen Padang">
    <title>Beasiswa UPZ Semen Padang | Generasi Qur'ani</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            900: '#022c22',
                            800: '#064e3b',
                            700: '#065f46',
                        },
                        gold: {
                            400: '#facc15',
                            500: '#eab308',
                            600: '#ca8a04',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.6s ease-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'pulse-glow': 'pulseGlow 2s infinite',
                        'float': 'float 3s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        pulseGlow: {
                            '0%, 100%': { boxShadow: '0 0 20px rgba(250, 204, 21, 0.4)' },
                            '50%': { boxShadow: '0 0 35px rgba(250, 204, 21, 0.7)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body { 
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #064e3b;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #047857;
        }

        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .glass-dark {
            background: rgba(2, 44, 34, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        /* Premium Button Glow */
        .btn-glow {
            position: relative;
            overflow: hidden;
        }
        .btn-glow::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.5s;
        }
        .btn-glow:hover::before {
            left: 100%;
        }

        /* Active Link Indicator */
        .nav-link {
            position: relative;
            padding-bottom: 4px;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0; left: 50%;
            width: 0; height: 2px;
            background: #facc15;
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }
        .nav-link.active::after,
        .nav-link:hover::after {
            width: 70%;
        }

        /* Timeline Connector */
        .timeline-connector {
            position: absolute;
            top: 28px;
            left: 50%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #facc15, transparent);
            z-index: 0;
        }
        @media (max-width: 768px) {
            .timeline-connector {
                top: 0; left: 28px;
                width: 2px; height: 100%;
            }
        }

        /* FAQ Accordion */
        [x-cloak] { display: none !important; }
        .faq-icon {
            transition: transform 0.3s ease;
        }
        [x-data] .open .faq-icon {
            transform: rotate(45deg);
        }

        /* Decorative Blur Shapes */
        .blur-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            z-index: 0;
            pointer-events: none;
        }

        /* Counter Animation */
        .counter {
            font-variant-numeric: tabular-nums;
        }

        /* Trust Badge */
        .trust-badge {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(250, 204, 21, 0.3);
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased" x-data="{ 
    scrolled: false, 
    activeSection: 'beranda',
    faqOpen: null,
    counters: { recipients: 0, alumni: 0, funds: 0 },
    init() {
        window.addEventListener('scroll', () => {
            this.scrolled = window.scrollY > 50;
            
            // Section tracking
            const sections = ['beranda', 'alur', 'informasi', 'faq'];
            for (let section of sections) {
                const el = document.getElementById(section);
                if (el) {
                    const rect = el.getBoundingClientRect();
                    if (rect.top <= 150 && rect.bottom >= 150) {
                        this.activeSection = section;
                        break;
                    }
                }
            }
        });
        
        // Counter animation on viewport
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        const statsSection = document.getElementById('informasi');
        if (statsSection) observer.observe(statsSection);
    },
    animateCounters() {
        this.animateCounter('recipients', 120, 2000);
        this.animateCounter('alumni', 50, 2000);
        this.animateCounter('funds', 1000, 2000, 'M+');
    },
    animateCounter(key, target, duration, suffix = '+') {
        let start = 0;
        const increment = target / (duration / 16);
        const step = () => {
            start += increment;
            if (start < target) {
                this.counters[key] = Math.floor(start);
                requestAnimationFrame(step);
            } else {
                this.counters[key] = target;
            }
        };
        step();
    }
}">

<!-- Floating WhatsApp Button -->
<a href="https://wa.me/6283827769062" 
   target="_blank"
   class="fixed bottom-6 right-6 z-50 bg-green-500 hover:bg-green-600 
          w-14 h-14 rounded-full flex items-center justify-center 
          shadow-lg hover:scale-110 transition-all duration-300">

    <i class="fab fa-whatsapp text-white text-2xl"></i>

</a>
<!-- ================= NAVBAR ================= -->
<header 
    x-bind:class="scrolled ? 'glass shadow-lg py-3' : 'py-5'"
    class="fixed w-full z-50 transition-all duration-500"
    x-data="{ mobileMenu: false }"
>
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center"
         x-bind:class="scrolled ? 'text-primary-800' : 'text-white'">
        
        <!-- Logo -->
        <a href="#beranda" class="flex items-center gap-3 group">
            <div class="relative">
                <img src="{{ asset('images/upz-logo.png') }}" 
                     class="w-10 h-10 object-contain transition-transform group-hover:scale-105"
                     alt="UPZ Semen Padang">
                <div class="absolute inset-0 rounded-full bg-gold-400 opacity-0 group-hover:opacity-20 transition-opacity blur-lg"></div>
            </div>
            <div>
                <span class="font-extrabold tracking-tight text-lg block">UPZ</span>
                <span class="text-xs text-gold-400 font-semibold tracking-wider">SEMEN PADANG</span>
            </div>
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center gap-8 font-medium text-sm">
            <a href="#beranda" 
               x-bind:class="activeSection === 'beranda' ? 'active' : ''"
               class="nav-link hover:text-gold-400 transition-colors">
                Beranda
            </a>
            <a href="#alur" 
               x-bind:class="activeSection === 'alur' ? 'active' : ''"
               class="nav-link hover:text-gold-400 transition-colors">
                Alur Pendaftaran
            </a>
            <a href="#informasi" 
               x-bind:class="activeSection === 'informasi' ? 'active' : ''"
               class="nav-link hover:text-gold-400 transition-colors">
                Statistik
            </a>
            <a href="#faq" 
               x-bind:class="activeSection === 'faq' ? 'active' : ''"
               class="nav-link hover:text-gold-400 transition-colors">
                FAQ
            </a>
        </nav>

        <!-- CTA Buttons -->
        <div class="hidden md:flex items-center gap-4">

    @guest
        <a href="{{ route('login') }}" 
           class="text-sm font-semibold hover:text-gold-400 transition-colors px-4 py-2">
            Login
        </a>
        <a href="{{ route('register') }}" 
           class="btn-glow bg-gold-400 hover:bg-gold-500 text-primary-900 font-bold px-6 py-2.5 rounded-full text-sm shadow-lg hover:shadow-gold-400/50 transition-all duration-300 transform hover:-translate-y-0.5">
            Daftar Sekarang
        </a>
    @endguest

  @auth
<div class="flex flex-col items-center relative group">

    <!-- Avatar -->
    <div class="w-10 h-10 rounded-full bg-gold-400 text-primary-900 
                flex items-center justify-center font-bold cursor-pointer
                shadow-lg hover:scale-105 transition-transform">
        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
    </div>

    <!-- Tulisan kecil -->
    <span class="text-[10px] text-gold-400 font-semibold mt-1 tracking-wider">
        Sedang Login
    </span>

    <!-- Dropdown -->
    <div class="absolute right-0 top-14 w-44 bg-white rounded-xl shadow-xl 
                opacity-0 invisible group-hover:opacity-100 group-hover:visible
                transition-all duration-200 overflow-hidden z-50">
        
        <a href="{{ route('user.dashboard') }}" 
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            Dashboard
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                Logout
            </button>
        </form>
    </div>

</div>
@endauth

</div>

        <!-- Mobile Menu Button -->
        <button @click="mobileMenu = !mobileMenu" 
                class="md:hidden p-2 rounded-lg hover:bg-white/10 transition"
                x-bind:class="scrolled ? 'text-primary-800' : 'text-white'">
            <i class="fas" x-bind:class="mobileMenu ? 'fa-times' : 'fa-bars'" class="text-xl"></i>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenu" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="md:hidden glass-dark border-t border-white/10"
         x-cloak>
        <div class="px-6 py-4 space-y-3">
            <a href="#beranda" @click="mobileMenu = false" class="block py-3 text-white/90 hover:text-gold-400 font-medium border-b border-white/10">Beranda</a>
            <a href="#alur" @click="mobileMenu = false" class="block py-3 text-white/90 hover:text-gold-400 font-medium border-b border-white/10">Alur Pendaftaran</a>
            <a href="#informasi" @click="mobileMenu = false" class="block py-3 text-white/90 hover:text-gold-400 font-medium border-b border-white/10">Statistik</a>
            <a href="#informasi_sistem" @click="mobileMenu = false" class="block py-3 text-white/90 hover:text-gold-400 font-medium border-b border-white/10">Informasi Sistem</a>
            <a href="#faq" @click="mobileMenu = false" class="block py-3 text-white/90 hover:text-gold-400 font-medium border-b border-white/10">FAQ</a>
            <div class="pt-4 flex gap-3">

    @guest
        <a href="{{ route('login') }}" 
           class="flex-1 text-center py-2.5 rounded-lg border border-white/30 text-white font-medium hover:bg-white/10 transition">
            Login
        </a>
        <a href="{{ route('register') }}" 
           class="flex-1 text-center py-2.5 rounded-lg bg-gold-400 text-primary-900 font-bold hover:bg-gold-500 transition">
            Daftar
        </a>
    @endguest

    @auth
        <a href="{{ route('user.dashboard') }}" 
           class="flex-1 text-center py-2.5 rounded-lg bg-gold-400 text-primary-900 font-bold">
            Dashboard
        </a>

        <form method="POST" action="{{ route('logout') }}" class="flex-1">
            @csrf
            <button type="submit"
                class="w-full py-2.5 rounded-lg border border-white/30 text-white font-medium hover:bg-white/10 transition">
                Logout
            </button>
        </form>
    @endauth

</div>
        </div>
    </div>
</header>

<!-- ================= HERO SECTION ================= -->
<section id="beranda" class="relative min-h-screen flex items-center pt-24 overflow-hidden">
    <!-- Background Gradient -->
    <div class="absolute inset-0 bg-gradient-to-br from-primary-900 via-primary-800 to-primary-700"></div>
    
    <!-- Decorative Blur Shapes -->
    <div class="blur-shape w-96 h-96 bg-gold-400 top-20 -right-20"></div>
    <div class="blur-shape w-80 h-80 bg-primary-500 bottom-20 -left-20"></div>
    <div class="blur-shape w-64 h-64 bg-gold-500 top-1/2 left-1/4"></div>
    
    <!-- Pattern Overlay -->
    <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(#facc15 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="relative max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center py-12 lg:py-0">
        
        <!-- Content -->
        <div class="text-white animate-slide-up" style="animation-delay: 0.2s">
            <!-- Trust Badge -->
            <div class="trust-badge inline-flex items-center gap-2 px-4 py-2 rounded-full mb-8 animate-fade-in">
                <i class="fas fa-shield-check text-gold-400"></i>
                <span class="text-sm font-medium">Transparan & Terpercaya</span>
            </div>
            
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                Program Beasiswa 
                <span class="block text-gold-400 mt-2">Generasi Qur'ani</span>
            </h1>
            
            <p class="text-gray-200 text-lg mb-10 max-w-xl leading-relaxed">
                Sistem beasiswa berbasis digital yang transparan, profesional, 
                dan berorientasi pada pembinaan karakter serta prestasi akademik.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 mb-12">
                <a href="{{ route('register') }}" 
                   class="btn-glow inline-flex items-center justify-center gap-2 bg-gold-400 hover:bg-gold-500 text-primary-900 font-bold px-8 py-4 rounded-full shadow-xl hover:shadow-gold-400/50 transition-all duration-300 transform hover:-translate-y-1">
                    Mulai Pendaftaran
                    <i class="fas fa-arrow-right"></i>
                </a>
                <a href="https://heyzine.com/flip-book/e905873c0a.html" 
                   class="inline-flex items-center justify-center gap-2 border-2 border-white/30 hover:border-gold-400 px-8 py-4 rounded-full font-semibold hover:bg-white/10 transition-all duration-300">
                    Manual Book
                    <i class="fas fa-book-open text-xs"></i>
                </a>
                <a href="{{ route('informasi.sistem') }}" 
                    class="inline-flex items-center justify-center gap-2 bg-white/10 border-2 border-white/20 hover:bg-gold-400 hover:text-primary-900 hover:border-gold-400 px-8 py-4 rounded-full font-semibold transition-all duration-300 transform hover:-translate-y-1">
                        Tentang Website
                        <i class="fas fa-info-circle text-xs"></i>
                </a>
                </div>
        </div>

        <!-- Hero Image/Illustration -->
        <div class="hidden lg:block relative animate-float">
            <div class="relative z-10">
                <img src="{{ asset('images/hero-anak.png') }}" 
                     alt="Siswa Berprestasi" 
                     class="drop-shadow-2xl max-w-md mx-auto">
            </div>
            <!-- Decorative Elements -->
            <div class="absolute -top-8 -right-8 w-32 h-32 border-2 border-gold-400/30 rounded-full animate-pulse"></div>
            <div class="absolute -bottom-4 -left-4 w-24 h-24 border-2 border-gold-400/20 rounded-full"></div>
        </div>

    </div>

    <!-- Scroll Indicator -->
    <a href="#alur" class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
        <div class="w-8 h-12 rounded-full border-2 border-white/40 flex items-start justify-center p-2">
            <div class="w-1.5 h-3 bg-white/60 rounded-full animate-pulse"></div>
        </div>
    </a>
</section>

<!-- ================= ALUR PENDAFTARAN ================= -->
<section id="alur" class="py-24 bg-white relative">
    <div class="max-w-6xl mx-auto px-6">
        <!-- Section Header -->
        <div class="text-center mb-20">
            <h2 class="text-3xl md:text-4xl font-extrabold text-primary-900 mb-4">
                Alur Pendaftaran
            </h2>
            <div class="w-20 h-1 bg-gradient-to-r from-transparent via-gold-400 to-transparent mx-auto rounded-full"></div>
            <p class="text-gray-600 mt-6 max-w-2xl mx-auto">
                Empat langkah sederhana untuk bergabung dalam program beasiswa kami
            </p>
        </div>

        <!-- Timeline -->
        <div class="relative max-w-5xl mx-auto">
            <!-- Connector Line -->
            <div class="timeline-connector hidden md:block"></div>
            
            <div class="grid md:grid-cols-4 gap-8 relative z-10">
                @php
                    $steps = [
                        ['icon' => 'fa-user-plus', 'title' => 'Daftar Akun', 'desc' => 'Buat akun dan lengkapi profil'],
                        ['icon' => 'fa-file-upload', 'title' => 'Upload Berkas', 'desc' => 'Unggah dokumen persyaratan'],
                        ['icon' => 'fa-clipboard-check', 'title' => 'Verifikasi Data', 'desc' => 'Tim kami memvalidasi data'],
                        ['icon' => 'fa-bell', 'title' => 'Pengumuman', 'desc' => 'Pantau hasil seleksi di dashboard']
                    ];
                @endphp

                @foreach($steps as $index => $step)
                <div class="group relative" x-data="{ hovered: false }"
                     @mouseenter="hovered = true" @mouseleave="hovered = false">
                    
                    <!-- Card -->
                    <div class="bg-white p-8 rounded-3xl shadow-lg border border-gray-100 
                                hover:shadow-2xl hover:border-gold-400/30 hover:-translate-y-1 
                                transition-all duration-300 text-center h-full">
                        
                        <!-- Step Number Badge -->
                        <div class="relative inline-flex mb-6">
                            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-gold-400 to-gold-500 
                                        flex items-center justify-center shadow-lg shadow-gold-400/30
                                        group-hover:scale-110 transition-transform duration-300">
                                <i class="fas {{ $step['icon'] }} text-primary-900 text-xl"></i>
                            </div>
                            <div class="absolute -top-1 -right-1 w-6 h-6 bg-primary-800 rounded-full 
                                        flex items-center justify-center text-xs font-bold text-gold-400 border-2 border-white">
                                {{ $index + 1 }}
                            </div>
                        </div>
                        
                        <h3 class="font-bold text-primary-900 text-lg mb-3 group-hover:text-gold-600 transition-colors">
                            {{ $step['title'] }}
                        </h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            {{ $step['desc'] }}
                        </p>
                    </div>

                    <!-- Mobile Connector -->
                    @if(!$loop->last)
                    <div class="md:hidden absolute left-8 top-20 w-0.5 h-12 bg-gradient-to-b from-gold-400 to-transparent"></div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center mt-16">
            <a href="{{ route('register') }}" 
               class="inline-flex items-center gap-2 text-primary-800 font-semibold hover:text-gold-600 transition-colors group">
                Siap Mendaftar?
                <span class="group-hover:translate-x-1 transition-transform">
                    <i class="fas fa-arrow-right"></i>
                </span>
            </a>
        </div>
    </div>
</section>

<!-- ================= INFORMASI STATISTIK ================= -->
<section id="informasi" class="py-24 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-gold-400/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-primary-800/5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

    <div class="relative max-w-6xl mx-auto px-6">
        <!-- Section Header -->
        <div class="text-center mb-20">
            <h2 class="text-3xl md:text-4xl font-extrabold text-primary-900 mb-4">
                Informasi Statistik
            </h2>
            <div class="w-20 h-1 bg-gradient-to-r from-transparent via-gold-400 to-transparent mx-auto rounded-full"></div>
            <p class="text-gray-600 mt-6 max-w-2xl mx-auto">
                Capaian program beasiswa yang telah memberikan manfaat bagi generasi penerus
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <!-- Card 1 -->
            <div class="group bg-white p-10 rounded-3xl shadow-lg border border-gray-100 
                        hover:shadow-2xl hover:border-gold-400/30 transition-all duration-300 
                        transform hover:-translate-y-1 text-center">
                <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-primary-100 to-primary-50 
                            flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-users text-primary-800 text-2xl"></i>
                </div>
                <div class="counter text-5xl font-extrabold text-gold-500 mb-3">
                    {{ $penerima }}+
                </div>
                <p class="text-primary-800 font-semibold text-lg">Penerima Beasiswa</p>
            </div>

            <!-- Card 2 -->
            <div class="group bg-white p-10 rounded-3xl shadow-lg border border-gray-100 
                        hover:shadow-2xl hover:border-gold-400/30 transition-all duration-300 
                        transform hover:-translate-y-1 text-center">
                <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-primary-100 to-primary-50 
                            flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-graduation-cap text-primary-800 text-2xl"></i>
                </div>
                <div class="counter text-5xl font-extrabold text-gold-500 mb-3">
                {{ $alumni }}+
            </div>
                <p class="text-primary-800 font-semibold text-lg">Alumni</p>
                
            </div>

            <!-- Card 3 -->
            <div class="group bg-white p-10 rounded-3xl shadow-lg border border-gray-100 
                        hover:shadow-2xl hover:border-gold-400/30 transition-all duration-300 
                        transform hover:-translate-y-1 text-center">
                <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-primary-100 to-primary-50 
                            flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-hand-holding-heart text-primary-800 text-2xl"></i>
                </div>
                <div class="counter text-5xl font-extrabold text-gold-500 mb-3">
                {{ $sudahCair }}+
            </div>
            <p class="text-primary-800 font-semibold text-lg">Dana Diterima</p>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-20 text-center">
            <div class="inline-flex flex-wrap justify-center gap-4 text-sm text-gray-600">
                <span class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-gold-400"></i>
                    Sistem Digital Terintegrasi
                </span>
                <span class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-gold-400"></i>
                    Monitoring Berkala
                </span>
                <span class="flex items-center gap-2">
                    <i class="fas fa-check-circle text-gold-400"></i>
                    Pembinaan Karakter
                </span>
            </div>
        </div>
    </div>
</section>


<!-- ================= FAQ ================= -->
<section id="faq" class="py-24 bg-white">
    <div class="max-w-4xl mx-auto px-6">
        <!-- Section Header -->
        <div class="text-center mb-20">
            <h2 class="text-3xl md:text-4xl font-extrabold text-primary-900 mb-4">
                Pertanyaan Umum
            </h2>
            <div class="w-20 h-1 bg-gradient-to-r from-transparent via-gold-400 to-transparent mx-auto rounded-full"></div>
            <p class="text-gray-600 mt-6 max-w-2xl mx-auto">
                Temukan jawaban untuk pertanyaan yang sering diajukan seputar program beasiswa
            </p>
        </div>

        <!-- Accordion -->
        <div class="space-y-4" x-data="{ open: null }">
            @php
                $faqs = [
                    [
                        'q' => 'Siapa saja yang dapat mendaftar program beasiswa ini?',
                        'a' => 'Program ini terbuka untuk siswa/siswi yang memenuhi kriteria ekonomi, memiliki komitmen kuat dalam pembinaan karakter Islami, dan menunjukkan potensi akademik yang baik. Persyaratan lengkap dapat dilihat pada halaman pendaftaran.'
                    ],
                    [
                        'q' => 'Bagaimana proses seleksi dilakukan?',
                        'a' => 'Seleksi dilakukan secara transparan melalui sistem digital dengan tahapan: verifikasi administrasi, penilaian berkas, wawancara online, dan pengumuman hasil. Seluruh proses dapat dipantau melalui dashboard akun peserta.'
                    ],
                    [
                        'q' => 'Apa saja manfaat yang diterima penerima beasiswa?',
                        'a' => 'Penerima beasiswa mendapatkan bantuan biaya pendidikan, program pembinaan karakter & leadership, mentoring rutin, akses jaringan alumni, serta kesempatan pengembangan diri melalui berbagai kegiatan positif.'
                    ],
                    [
                        'q' => 'Apakah ada ikatan dinas setelah lulus?',
                        'a' => 'Tidak ada ikatan dinas. Namun, kami mengharapkan alumni untuk berkontribusi positif di masyarakat dan menjadi bagian dari jaringan Generasi Qur\'ani yang membawa manfaat luas.'
                    ]
                ];
            @endphp

            @foreach($faqs as $index => $faq)
            <div class="border border-gray-200 rounded-2xl overflow-hidden hover:border-gold-400/40 transition-colors"
                 x-data="{ isOpen: false }"
                 @click.away="isOpen = false">
                
                <button @click="isOpen = !isOpen" 
                        class="w-full px-6 py-5 text-left flex items-center justify-between gap-4 
                               hover:bg-primary-50/50 transition-colors group">
                    <span class="font-semibold text-primary-900 group-hover:text-gold-600 transition-colors pr-4">
                        {{ $faq['q'] }}
                    </span>
                    <span class="faq-icon flex-shrink-0 w-8 h-8 rounded-full bg-primary-100 
                                 flex items-center justify-center text-gold-500 group-hover:bg-gold-400 group-hover:text-primary-900 
                                 transition-all duration-300"
                          :class="{ 'rotate-45': isOpen }">
                        <i class="fas fa-plus text-sm"></i>
                    </span>
                </button>
                
                <div x-show="isOpen" 
                    x-collapse
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 max-h-0"
                    x-transition:enter-end="opacity-100 max-h-96"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 max-h-96"
                    x-transition:leave-end="opacity-0 max-h-0"
                    class="px-6 pb-5">
                    <p class="text-gray-600 leading-relaxed pl-1 border-l-2 border-gold-400/30">
                        {{ $faq['a'] }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Contact CTA -->
        <div class="mt-16 text-center p-8 bg-gradient-to-r from-primary-50 to-gold-50 rounded-3xl border border-primary-100">
            <p class="text-gray-700 mb-4">Masih ada pertanyaan?</p>
            <a href="mailto:beasiswa@upzsemenpadang.com" 
            class="inline-flex items-center gap-2 text-primary-800 font-semibold hover:text-gold-600 transition-colors">
                <i class="fas fa-envelope"></i>
                beasiswa@upzsemenpadang.com
            </a>
        </div>
    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="bg-primary-900 text-white relative overflow-hidden">
    <!-- Gradient Divider -->
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-gold-400 to-transparent"></div>
    
    <!-- Decorative Blur -->
    <div class="absolute bottom-0 right-0 w-80 h-80 bg-gold-400/10 rounded-full blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-6 py-16">
        <div class="grid md:grid-cols-4 gap-12">
            
            <!-- Brand -->
            <div class="md:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <img src="{{ asset('images/upz-logo.png') }}" class="w-10 h-10" alt="Logo">
                    <div>
                        <span class="font-extrabold text-lg block">UPZ Semen Padang</span>
                        <span class="text-xs text-gold-400 font-medium">Unit Pengumpul Zakat</span>
                    </div>
                </div>
                <p class="text-gray-300 mb-6 max-w-md leading-relaxed">
                    Mengelola program beasiswa berbasis digital yang transparan dan profesional, 
                    berorientasi pada pembinaan karakter Qur'ani dan prestasi akademik.
                </p>
                
                <!-- Social Links -->
                <div class="flex gap-3">
                    <a href="https://www.instagram.com/semenpadangupz?igsh=YmFyOHVoMHNvaW1v" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-gold-400 
                                        flex items-center justify-center transition-all duration-300 
                                        hover:text-primary-900 group">
                        <i class="fab fa-instagram group-hover:scale-110 transition-transform"></i>
                    </a>
                    <a href="https://www.facebook.com/share/18BtK3sbWE/?mibextid=wwXIfr" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-gold-400 
                                        flex items-center justify-center transition-all duration-300 
                                        hover:text-primary-900 group">
                        <i class="fab fa-facebook-f group-hover:scale-110 transition-transform"></i>
                    </a>
                    <a href="https://youtube.com/@upzsemenpadang6713?si=x8OOTwOQ6UBKZ-77" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-gold-400 
                                        flex items-center justify-center transition-all duration-300 
                                        hover:text-primary-900 group">
                        <i class="fab fa-youtube group-hover:scale-110 transition-transform"></i>
                    </a>
                    <a href="https://wa.me/6283827769062" class="w-10 h-10 rounded-xl bg-white/10 hover:bg-gold-400 
                                        flex items-center justify-center transition-all duration-300 
                                        hover:text-primary-900 group">
                        <i class="fab fa-whatsapp group-hover:scale-110 transition-transform"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="font-bold text-lg mb-5 text-gold-400">Navigasi</h4>
                <ul class="space-y-3">
                    <li><a href="#beranda" class="text-gray-300 hover:text-gold-400 transition-colors">Beranda</a></li>
                    <li><a href="#alur" class="text-gray-300 hover:text-gold-400 transition-colors">Alur Pendaftaran</a></li>
                    <li><a href="#informasi" class="text-gray-300 hover:text-gold-400 transition-colors">Statistik</a></li>
                    <li><a href="#faq" class="text-gray-300 hover:text-gold-400 transition-colors">FAQ</a></li>
                    <li><a href="{{ route('login') }}" class="text-gray-300 hover:text-gold-400 transition-colors">Login</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="font-bold text-lg mb-5 text-gold-400">Kontak</h4>
                <ul class="space-y-4 text-gray-300">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt mt-1 text-gold-400"></i>
                        <span>Padang, Sumatera Barat<br>Indonesia</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-envelope text-gold-400"></i>
                        <a href="mailto:info@upzsemenpadang.com" class="hover:text-gold-400 transition">info@upzsemenpadang.com</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fas fa-phone text-gold-400"></i>
                        <span>+62 751 XXX XXX</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="mt-16 pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-sm text-gray-400">
                © {{ date('Y') }} UPZ Semen Padang. All Rights Reserved.
            </p>
            <div class="flex gap-6 text-sm text-gray-400">
                <a href="#" class="hover:text-gold-400 transition">Kebijakan Privasi</a>
                <a href="#" class="hover:text-gold-400 transition">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-gold-400 transition">Aksesibilitas</a>
            </div>
        </div>
    </div>
</footer>

<!-- ================= BACK TO TOP ================= -->
<button x-data="{ visible: false }"
        @scroll.window="visible = window.scrollY > 400"
        x-show="visible"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-8 right-8 z-40 w-12 h-12 rounded-full bg-gold-400 hover:bg-gold-500 
            text-primary-900 shadow-lg hover:shadow-gold-400/50 flex items-center justify-center 
            transition-all duration-300 transform hover:-translate-y-1"
        x-cloak>
    <i class="fas fa-arrow-up"></i>
</button>

<!-- ================= INIT SCRIPTS ================= -->
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // ✅ Smooth scroll hanya untuk anchor internal saja
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {

                const href = this.getAttribute('href');

                // HANYA kalau benar-benar anchor internal (#section)
                if (href.length > 1) {
                    const target = document.querySelector(href);

                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });

    });
</script>

</body>
</html>