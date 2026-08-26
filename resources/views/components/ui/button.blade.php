@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button'
])

@php
    $baseStyles = 'inline-flex items-center justify-center font-medium tracking-wide rounded-full transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-brand-accent/50';
    
    $variants = [
        'primary' => 'text-brand-white bg-brand-primary hover:bg-brand-secondary shadow-brand-soft hover:shadow-[0_12px_35px_rgba(80,46,136,0.15)]',
        'secondary' => 'text-brand-white bg-brand-secondary hover:bg-brand-primary shadow-brand-soft',
        'outline' => 'text-brand-primary border border-brand-primary/20 hover:bg-brand-primary/5',
        'ghost' => 'text-brand-primary hover:bg-brand-primary/5',
    ];

    $sizes = [
        'sm' => 'px-4 py-2 text-caption',
        'md' => 'px-6 py-3 text-body',
        'lg' => 'px-8 py-4 text-body-lg',
    ];

    $classes = $baseStyles . ' ' . $variants[$variant] . ' ' . $sizes[$size];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
