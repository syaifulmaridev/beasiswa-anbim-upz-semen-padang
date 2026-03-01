<div class="bg-white rounded-2xl shadow-md overflow-hidden">

    <div class="px-6 py-4 border-b bg-gray-50 flex justify-between items-center">
        <h2 class="text-lg font-bold text-gray-700">
            {{ $title ?? 'Data Tabel' }}
        </h2>

        {{ $action ?? '' }}
    </div>

    <div class="p-6 overflow-x-auto">
        <table class="w-full text-sm min-w-[650px] border-separate border-spacing-y-3">
            {{ $slot }}
        </table>
    </div>

</div>
