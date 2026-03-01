<!-- LOGO -->
<div class="h-[88px] flex items-center px-6 border-b border-white/10">
    <img src="{{ asset('images/upz-logo.png') }}"
         class="w-10 h-10 bg-white rounded-lg p-1">

    <div class="ml-3">
        <h1 class="font-bold text-yellow-300 text-lg leading-tight">
            UPZ 
        </h1>
        <p class="text-xs text-white/60">
            Semen Padang
        </p>
    </div>
</div>

<!-- MENU -->
<nav class="flex-1 px-5 py-8 space-y-3 text-sm font-medium">

    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg
       {{ request()->routeIs('admin.dashboard') ? 'bg-[#2c6b5e]' : 'hover:bg-[#2c6b5e]' }}">
        <i class="fa-solid fa-house w-5"></i>
        <span>Dashboard</span>
    </a>

   <a href="{{ route('admin.pendaftaran.index') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-lg
   {{ request()->routeIs('admin.pendaftaran.*') ? 'bg-[#2c6b5e]' : 'hover:bg-[#2c6b5e]' }}">
    <i class="fa-solid fa-circle-check w-5"></i>
    <span>Validasi Pendaftaran</span>
</a>
    <hr class="border-white/10 my-4">

   <a href="{{ route('admin.akun') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-lg
   {{ request()->routeIs('admin.akun*') ? 'bg-[#2c6b5e]' : 'hover:bg-[#2c6b5e]' }}">
    <i class="fa-solid fa-user-gear w-5"></i>
    <span>Kelola Akun</span>
</a>

    <a href="{{ route('admin.pembinaan.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg
       {{ request()->routeIs('admin.pembinaan') ? 'bg-[#2c6b5e]' : 'hover:bg-[#2c6b5e]' }}">
        <i class="fa-solid fa-hands-holding-child w-5"></i>
        <span>Pembinaan</span>
    </a>

    <a href="{{ route('admin.alumni.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg
       {{ request()->routeIs('admin.alumni') ? 'bg-[#2c6b5e]' : 'hover:bg-[#2c6b5e]' }}">
        <i class="fa-solid fa-user-graduate w-5"></i>
        <span>Alumni</span>
    </a>

    <a href="{{ route('admin.pengaturan') }}"
   class="flex items-center gap-3 px-4 py-3 rounded-lg
   {{ request()->routeIs('admin.pengaturan*') ? 'bg-[#2c6b5e]' : 'hover:bg-[#2c6b5e]' }}">
    <i class="fa-solid fa-gear w-5"></i>
    <span>Pengaturan</span>
</a>

    <a href="{{ route('admin.log') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg
       {{ request()->routeIs('admin.log') ? 'bg-[#2c6b5e]' : 'hover:bg-[#2c6b5e]' }}">
        <i class="fa-solid fa-clipboard-list w-5"></i>
        <span>Log Aktivitas</span>
    </a>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit"
            class="w-full text-left flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-red-500">
            <i class="fa-solid fa-right-from-bracket w-5"></i>
            <span>Logout</span>
        </button>
    </form>
</nav>
