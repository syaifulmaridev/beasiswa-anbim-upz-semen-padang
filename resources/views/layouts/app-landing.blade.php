<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description','Beasiswa UPZ Semen Padang')">
    <title>@yield('title','Beasiswa UPZ Semen Padang')</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Alpine -->
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
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

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

        .glass {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(20px);
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 text-gray-800">
{{-- ================= NAVBAR ================= --}}
<nav class="bg-primary-900 text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <a href="/" class="flex items-center gap-3">
            <img src="{{ asset('images/upz-logo.png') }}" class="h-10" alt="Logo">
            <h1 class="font-bold text-lg hidden sm:block">UPZ Semen Padang</h1>
        </a>

        <div class="hidden md:flex gap-8 text-sm font-medium items-center">
            <a href="/" class="hover:text-gold-400 transition">Beranda</a>
            <a href="#tentang" class="hover:text-gold-400 transition">Tentang</a>
<a href="#alur" class="hover:text-gold-400 transition">Alur</a>
<a href="#tim" class="hover:text-gold-400 transition">Tim Developer</a>
            <a href="{{ url('login') }}" class="bg-gold-500 hover:bg-gold-600 text-primary-900 px-6 py-2 rounded-full font-bold btn-glow transition shadow-lg">
                Login Portal
            </a>
        </div>
    </div>
</nav>
    {{-- ================= CONTENT ================= --}}
    @yield('content')

{{-- ================= FOOTER ================= --}}
<footer class="bg-primary-900 text-white mt-20">
    <div class="max-w-7xl mx-auto px-6 py-10 text-center text-sm">
        <p>© {{ date('Y') }} Beasiswa UPZ Semen Padang</p>
        <p class="text-gray-300 mt-2">All rights reserved.</p>
    </div>
</footer>

    @stack('scripts')
</body>
</html>