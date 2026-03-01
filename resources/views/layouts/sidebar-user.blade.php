<!-- LOGO -->
<div class="h-[88px] flex items-center px-6 border-b border-white/10">
    <img src="{{ asset('images/upz-logo.png') }}"
         class="w-10 h-10 bg-white rounded-lg p-1">

    <div class="ml-3">
        <h1 class="font-bold text-yellow-300 text-lg leading-tight">
            UPZ Semen Padang
        </h1>
        <p class="text-xs text-white/60">
            User Panel
        </p>
    </div>
</div>

<!-- MENU USER -->
<nav class="flex-1 px-5 py-8 space-y-3 text-sm font-medium">

    <!-- Dashboard -->
    <a href="{{ route('user.dashboard') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg
       {{ request()->routeIs('user.dashboard') ? 'bg-[#2c6b5e]' : 'hover:bg-[#2c6b5e]' }}">
        <i class="fa-solid fa-house w-5"></i>
        <span>Dashboard</span>
    </a>

    <!-- Pendaftaran -->
    <a href="{{ route('user.pendaftaran') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg
       {{ request()->routeIs('user.pendaftaran*') ? 'bg-[#2c6b5e]' : 'hover:bg-[#2c6b5e]' }}">
        <i class="fa-solid fa-paper-plane w-5"></i>
        <span>Pendaftaran</span>
    </a>

    <!-- Setor Hafalan -->
    <a href="{{ route('user.pembinaan') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg
       {{ request()->routeIs('user.pembinaan') ? 'bg-[#2c6b5e]' : 'hover:bg-[#2c6b5e]' }}">
        <i class="fa-solid fa-book-quran w-5"></i>
        <span>Setor Hafalan</span>
    </a>

    <!-- Status -->
    <a href="{{ route('user.status') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg
       {{ request()->routeIs('user.status') ? 'bg-[#2c6b5e]' : 'hover:bg-[#2c6b5e]' }}">
        <i class="fa-solid fa-chart-line w-5"></i>
        <span>Status</span>
    </a>

    <!-- Alumni (BARU) -->
    <a href="{{ route('user.alumni') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg
       {{ request()->routeIs('user.alumni*') ? 'bg-[#2c6b5e]' : 'hover:bg-[#2c6b5e]' }}">
        <i class="fa-solid fa-user-graduate w-5"></i>
        <span>Alumni</span>
    </a>

    <hr class="border-white/10 my-4">

    <!-- Logout -->
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit"
            class="w-full text-left flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-500">
            <i class="fa-solid fa-right-from-bracket w-5"></i>
            <span>Logout</span>
        </button>
    </form>

</nav>