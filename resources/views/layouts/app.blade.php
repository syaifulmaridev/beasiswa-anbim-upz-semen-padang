<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body x-data="{ sidebarOpen: false }" class="bg-gray-100 overflow-hidden">

<div class="flex h-screen">

    <!-- ================= SIDEBAR ================= -->
    <aside 
        class="fixed md:relative inset-y-0 left-0
               w-72
               bg-gradient-to-b from-[#1f4a44] to-[#17423c]
               text-white shadow-xl flex flex-col
               transform -translate-x-full md:translate-x-0
               transition-transform duration-300 ease-in-out
               z-50"
        :class="sidebarOpen ? 'translate-x-0' : ''">

        @include('layouts.sidebar')

    </aside>

    <!-- ================= OVERLAY (MOBILE) ================= -->
    <div 
        x-show="sidebarOpen"
        x-transition.opacity
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/40 z-40 md:hidden">
    </div>

    <!-- ================= RIGHT SIDE ================= -->
    <div class="flex-1 flex flex-col overflow-hidden relative">

        <!-- ================= HEADER ================= -->
        <header 
            x-data="{ scrolled: false }"
            x-init="
                const main = document.getElementById('main-content');
                main.addEventListener('scroll', () => {
                    scrolled = main.scrollTop > 10;
                });
            "
            :class="scrolled 
                ? 'bg-[#1f4a44]/60 backdrop-blur-xl shadow-lg' 
                : 'bg-[#1f4a44]'"
            class="absolute top-0 left-0 right-0 z-50 text-white transition-all duration-300">

            <div class="h-[88px] flex items-center justify-between px-8">

                <!-- HAMBURGER -->
                <button 
                    @click="sidebarOpen = true"
                    class="md:hidden text-2xl text-white">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <div class="hidden md:block"></div>

                <!-- PROFILE -->
                <div x-data="{ open: false }" class="relative">


                        @php
    $nama = Auth::user()->name ?? 'Admin';
@endphp

<div class="flex items-center gap-3 bg-white/10 px-5 py-2 rounded-xl">

    <div class="w-9 h-9 bg-white text-[#1f4a44] rounded-full flex items-center justify-center font-bold">
        {{ strtoupper(substr($nama, 0, 1)) }}
    </div>

    <span class="text-sm font-medium">
        {{ $nama }}
    </span>

</div>

                        
                    </button>

                </div>

            </div>

            <div class="h-[4px] bg-yellow-400"></div>
        </header>

        <!-- ================= CONTENT ================= -->
        <main 
            id="main-content"
            class="flex-1 overflow-y-auto pt-[100px] p-10">

            @yield('content')

        </main>

    </div>

</div>

<script src="//unpkg.com/alpinejs" defer></script>

</body>
</html>