@props([
    'variant' => 'light',
    'size' => 'md',
    'href' => null,
    'type' => 'button'
])

@php
    $baseStyles = 'inline-flex items-center justify-center font-medium tracking-wide rounded-full backdrop-blur-md transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-brand-accent/50';
    
    $variants = [
        'light' => 'bg-brand-white text-brand-primary border border-brand-primary/10 hover:bg-brand-primary/5 hover:border-brand-primary/20 shadow-sm hover:shadow hover:-translate-y-[1px]',
        'dark' => 'bg-brand-navy text-brand-white border border-transparent hover:bg-brand-ink hover:text-brand-white shadow-sm hover:shadow-md hover:-translate-y-[1px]',
        'glow' => 'bg-brand-gold text-brand-white border border-transparent hover:bg-brand-gold/90 shadow-sm hover:shadow-md hover:-translate-y-[1px]',
        'accent' => 'bg-gradient-to-r from-brand-primary via-brand-secondary to-brand-accent text-brand-white border border-transparent shadow-[0_4px_15px_rgba(80,46,136,0.2)] hover:shadow-[0_8px_25px_rgba(80,46,136,0.35)] hover:-translate-y-[2px] hover:brightness-105 active:scale-98 transition-all duration-300',
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
