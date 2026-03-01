@props(['status'])

@php
    $colors = [
        'menunggu' => 'bg-yellow-500',
        'disetujui' => 'bg-green-600',
        'ditolak' => 'bg-red-600',
    ];

    $icons = [
        'menunggu' => 'fa-clock',
        'disetujui' => 'fa-check',
        'ditolak' => 'fa-xmark',
    ];

    $bg = $colors[strtolower($status)] ?? 'bg-gray-500';
    $icon = $icons[strtolower($status)] ?? 'fa-circle';
@endphp

<span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold text-white {{ $bg }}">
    <i class="fa-solid {{ $icon }} text-[10px] text-white"></i>
    {{ ucfirst($status) }}
</span>
