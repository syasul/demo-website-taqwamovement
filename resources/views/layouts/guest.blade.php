<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Masuk ke Akun - Taqwa Movement</title>

        <!-- Fonts (DM Serif Display, Inter Tight, Alex Brush) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter+Tight:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Alex+Brush&display=swap" rel="stylesheet">

        <!-- Scripts and Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-brand-ink antialiased h-full">
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-8 px-4 sm:pt-0 bg-brand-cream overflow-hidden">
            <!-- Glowing decorative blobs -->
            <div class="absolute -top-40 -left-40 w-[500px] h-[500px] bg-brand-primary/10 rounded-full filter blur-3xl opacity-60"></div>
            <div class="absolute -bottom-40 -right-40 w-[500px] h-[500px] bg-brand-accent/15 rounded-full filter blur-3xl opacity-60"></div>

            <!-- Logo Area -->
            <div class="relative z-10">
                <a href="/">
                    <img src="{{ asset('images/logo-white-bg.png') }}" alt="Taqwa Movement Logo" class="h-12 sm:h-14 object-contain" />
                </a>
            </div>

            <!-- Main Auth Content Card -->
            <div class="relative z-10 w-full sm:max-w-md mt-8 p-8 sm:p-10 bg-brand-white/80 border border-brand-primary/10 shadow-[0_20px_50px_rgba(80,46,136,0.06)] rounded-3xl backdrop-blur-md">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
