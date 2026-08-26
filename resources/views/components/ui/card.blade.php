@props([
    'padding' => 'p-6 md:p-8',
    'hover' => false
])

@php
    $classes = 'bg-brand-white border border-brand-blush-lt/30 rounded-2xl shadow-brand-soft overflow-hidden ' . $padding;
    if ($hover) {
        $classes .= ' hover:shadow-[0_12px_35px_rgba(80,46,136,0.06)] hover:-translate-y-1 transition-all duration-300';
    }
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
