<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Taqwa Movement') }}</title>

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-brand-ink antialiased h-full bg-brand-cream flex flex-col justify-center items-center p-6 selection:bg-brand-accent/30 selection:text-brand-primary">

    <div class="w-full max-w-md flex flex-col items-center">
        <!-- Logo -->
        <a href="/" class="flex items-center gap-2 mb-8 group focus:outline-none focus:ring-2 focus:ring-brand-accent rounded-lg">
            <svg class="w-10 h-10 text-brand-primary transition-transform duration-300 group-hover:scale-105" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="16" cy="16" r="14" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                <path d="M16 8V24M10 14.5L16 8L22 14.5" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round"/>
            </svg>
            <span class="font-serif text-2xl font-bold tracking-tight text-brand-primary">
                TAQWA<span class="text-brand-accent font-sans text-sm align-super font-semibold tracking-wider ml-1">MOVEMENT</span>
            </span>
        </a>

        <!-- Content Card -->
        <div class="w-full bg-brand-white border border-brand-blush-lt/35 p-8 md:p-10 rounded-2xl shadow-brand-soft overflow-hidden">
            {{ $slot }}
        </div>

        <div class="mt-8 text-caption text-brand-ink/50 flex gap-4">
            <a href="/" class="hover:text-brand-primary transition-colors duration-200">Back to home</a>
            <span>&bull;</span>
            <a href="/kontak" class="hover:text-brand-primary transition-colors duration-200">Need help?</a>
        </div>
    </div>

</body>
</html>
