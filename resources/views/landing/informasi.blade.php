@extends('layouts.app-landing')

@section('title', 'Tentang Kami - UPZ Semen Padang')

@section('content')
<main class="min-h-screen">
    {{-- ================= HERO SECTION ================= --}}
    <section id="tentang" class="relative bg-primary-900 pt-20 pb-32 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <img src="https://www.transparenttextures.com/patterns/islamic-art.png" class="w-full h-full object-cover" alt="pattern">
        </div>
        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <span class="inline-block px-4 py-1 rounded-full bg-gold-500/20 text-gold-400 text-sm font-semibold mb-4 border border-gold-500/30">
                Informasi Sistem
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6">
                Tentang Pembuatan <span class="text-gold-400">Website</span>
            </h1>
            <p class="text-gray-300 max-w-2xl mx-auto text-lg">
                Sistem Informasi beasiswa Anak Binaan UPZ Baznas Semen Padang merupakan platform digital yang dikembangkan untuk mengelola proses pendataan, seleksi, pembinaan, serta monitoring penerima beasiswa secara sistematis. Sistem ini bertujuan meningkatkan transparansi, akuntabilitas, dan efektivitas dalam penyaluran zakat pendidikan, sehingga bantuan yang diberikan tepat sasaran dan berdampak berkelanjutan terhadap perkembangan akademik serta karakter anak binaan.
            </p>
        </div>
    </section>

    {{-- ================= TIMELINE SECTION ================= --}}
    <section id="alur" class="-mt-16 relative z-20 px-6">
        <div class="max-w-5xl mx-auto">
            <div class="glass rounded-3xl shadow-2xl p-8 md:p-12 border border-white/20">
                <div class="mb-12 text-center">
                    <h2 class="text-3xl font-bold text-primary-900 mb-4">Alur Pembuatan</h2>
                    <div class="h-1 w-20 bg-gold-500 mx-auto rounded-full"></div>
                </div>

               <div class="space-y-12">
    @php
        $steps = [
            [
                'icon' => 'fa-handshake',
                'title' => 'Inisiasi dan Perencanaan',
                'desc' => 'Kolaborasi dengan UPZ Semen Padang untuk benchmarking sistem digital Anak Binaan.',
                'image' => 'alur1.jpeg'
            ],
            [
                'icon' => 'fa-magnifying-glass',
                'title' => 'Analisis dan Desain Sistem',
                'desc' => 'Survey langsung bersama pelaksana harian untuk memetakan kebutuhan mustahiq (anak binaan) serta pembuatan visual uml.',
                'image' => 'alur2.jpeg'
            ],
            [
                'icon' => 'fa-bezier-curve',
                'title' => 'Pengembangan Sistem',
                'desc' => 'Pembuatan web baik dahbord admin,user, serta Beranda informsi.',
                'image' => 'alur4.jpeg'
            ],
            [
                'icon' => 'fa-code',
                'title' => 'Testing dan validasi',
                'desc' => 'Pengujian sistem Bersama dengan semua pegawai di upz semen padang.',
                'image' => 'alur3.jpeg'
            ],
            [
                'icon' => 'fa-rocket',
                'title' => 'Deployment & Dokumentasi',
                'desc' => 'Implementasi sistem ke server dan persiapan penggunaan oleh UPZ semen padang.',
                'image' => 'alur6.jpeg'
            ],
            [
                'icon' => 'fa-presentation-screen',
                'title' => 'Presentasi Akhir dan Penutupan',
                'desc' => 'Pemaparan hasil pengembangan sistem kepada pihak UPZ dan evaluasi akhir.',
                'image' => 'alur5.jpeg'
            ],
        ];
    @endphp

    @foreach($steps as $index => $step)
    <div class="flex flex-col md:flex-row gap-8 items-center {{ $index % 2 != 0 ? 'md:flex-row-reverse' : '' }}">
        
        <div class="w-full md:w-1/2 overflow-hidden rounded-2xl shadow-lg group">
            <img src="{{ asset('images/' . $step['image']) }}" 
                 alt="{{ $step['title'] }}" 
                 class="w-full h-64 object-cover transform group-hover:scale-105 transition duration-500">
        </div>

        <div class="w-full md:w-1/2 space-y-4">
            <div class="w-12 h-12 bg-primary-800 text-gold-400 rounded-xl flex items-center justify-center text-xl shadow-lg">
                <i class="fa-solid {{ $step['icon'] }}"></i>
            </div>

            <h3 class="text-2xl font-bold text-gray-800">
                {{ $step['title'] }}
            </h3>

            <p class="text-gray-600 leading-relaxed">
                {{ $step['desc'] }}
            </p>
        </div>

    </div>
    @endforeach
</div>
            </div>
        </div>
    </section>

    {{-- ================= DEVELOPER SECTION ================= --}}
    <section id="tim" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-extrabold text-primary-900 mb-4 text-center">Tim Pembuatan Website</h2>
            <p class="text-gray-600 mb-16">Mahasiswa Internship Program dari UIN Imam Bonjol Padang</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Card Template --}}
                @php
                    $devs = [
                        ['name' => 'Syaipul Marii', 'role' => 'Website Developer', 'images' => 'syaipul.png', 'ig' => 'sypulmr_'],
                        ['name' => 'Yus Yunus Rambe', 'role' => 'Website Developer', 'images' => 'yunus.jpeg', 'ig' => 'yunus_rayyy'],
                        ['name' => 'Rajib Hakim', 'role' => 'Website Developer', 'images' => 'hakim.jpeg', 'ig' => '_r.hakim'],
                    ];
                @endphp

                @foreach($devs as $dev)
                <div class="group relative bg-white rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 border border-gray-100">
                    <div class="h-80 overflow-hidden relative">
                        <img src="{{ asset('images/' . $dev['images']) }}" alt="{{ $dev['name'] }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-primary-900 via-transparent to-transparent opacity-0 group-hover:opacity-90 transition-opacity duration-300 flex items-end justify-center pb-8">
                            <div class="flex gap-4">
                                <a href="https://instagram.com/{{ $dev['ig'] }}" class="w-10 h-10 bg-gold-500 rounded-full flex items-center justify-center text-primary-900 hover:bg-white transition"><i class="fa-brands fa-instagram text-lg"></i></a>
                                <a href="#" class="w-10 h-10 bg-gold-500 rounded-full flex items-center justify-center text-primary-900 hover:bg-white transition"><i class="fa-brands fa-linkedin-in text-lg"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold text-primary-900">{{ $dev['name'] }}</h4>
                        <p class="text-gold-600 font-medium text-sm uppercase tracking-wider mt-1">{{ $dev['role'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</main>
@endsection