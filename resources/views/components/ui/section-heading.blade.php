@props([
    'eyebrow' => null,
    'title',
    'subtitle' => null,
    'align' => 'center'
])

@php
    $alignClasses = [
        'left' => 'text-left items-start',
        'center' => 'text-center items-center',
        'right' => 'text-right items-end',
    ];

    $classes = 'flex flex-col space-y-4 max-w-3xl ' . ($align === 'center' ? 'mx-auto' : '') . ' ' . $alignClasses[$align];
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if ($eyebrow)
        <span class="text-caption font-semibold uppercase tracking-wider text-brand-secondary block">
            {{ $eyebrow }}
        </span>
    @endif

    <h2 class="font-serif text-h1 text-brand-primary font-bold tracking-tight">
        {{ $title }}
    </h2>

    @if ($align === 'center')
        <div class="w-16 h-1 bg-brand-accent rounded-full"></div>
    @endif

    @if ($subtitle)
        <p class="text-body text-brand-ink/70 max-w-2xl">
            {{ $subtitle }}
        </p>
    @endif
</div>
