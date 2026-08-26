@props([
    'variant' => 'neutral'
])

@php
    $baseStyles = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border';
    
    $variants = [
        'neutral' => 'bg-slate-50 text-slate-700 border-slate-200',
        'primary' => 'bg-brand-primary/10 text-brand-primary border-brand-primary/20',
        'secondary' => 'bg-brand-secondary/10 text-brand-secondary border-brand-secondary/20',
        'accent' => 'bg-brand-accent/10 text-brand-primary border-brand-accent/20',
        'success' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'warning' => 'bg-amber-50 text-amber-700 border-amber-200',
        'danger' => 'bg-rose-50 text-rose-700 border-rose-200',
    ];

    $classes = $baseStyles . ' ' . $variants[$variant];
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
