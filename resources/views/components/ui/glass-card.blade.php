@props([
    'padding' => 'p-4 md:p-5',
    'dark' => false,
    'hover' => false
])

@php
    $baseClass = $dark ? 'glass-card-dark' : 'glass-card';
    $classes = "{$baseClass} rounded-[2rem] {$padding}";
    if ($hover) {
        $classes .= ' hover:shadow-glow hover:-translate-y-1.5 hover:border-brand-accent/30 transition-all duration-300 ease-out';
    }
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
