<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Panel - Taqwa Movement</title>

    <!-- Fonts -->
    <!-- Fonts (DM Serif Display, Inter Tight, Alex Brush) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter+Tight:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Alex+Brush&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans text-brand-ink antialiased h-full flex" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop -->
    <div 
        x-show="sidebarOpen" 
        x-transition:opacity
        class="fixed inset-0 bg-brand-ink/40 backdrop-blur-sm z-40 lg:hidden"
        style="display: none;"
        @click="sidebarOpen = false"
    ></div>

    <!-- Sidebar Navigation -->
    <aside 
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 w-64 bg-brand-ink text-brand-white z-50 flex flex-col justify-between transition-transform duration-300 ease-out lg:translate-x-0 lg:static lg:h-full lg:z-auto shrink-0 border-r border-brand-primary/10"
        id="admin-sidebar"
    >
        <div>
            <!-- Sidebar Header / Logo -->
            <div class="h-20 flex items-center px-6 border-b border-brand-primary/20">
                <a href="/admin" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-dark-bg.png') }}" alt="Taqwa Movement Logo" class="h-8 w-auto object-contain" />
                    <span class="text-[10px] font-sans font-extrabold tracking-widest text-brand-accent bg-brand-primary/30 border border-brand-accent/20 px-2 py-0.5 rounded uppercase">
                        Admin
                    </span>
                </a>
            </div>

            <!-- Sidebar Links -->
            <nav class="p-4 flex flex-col gap-2 overflow-y-auto max-h-[calc(100vh-10rem)]" aria-label="Admin Navigation">
                <!-- Dashboard Link (Standalone) -->
                <a 
                    href="/admin" 
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-body font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-brand-primary text-brand-white shadow-brand-soft' : 'text-brand-blush-lt/80 hover:bg-brand-white/10 hover:text-brand-white' }}"
                    id="admin-nav-dashboard"
                >
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path></svg>
                    Dashboard
                </a>

                <!-- Group 1: Event & Tiket -->
                <div x-data="{ open: {{ request()->routeIs('admin.events.*', 'admin.phases.*', 'admin.event-sessions.*', 'admin.ticket-types.*', 'admin.promo-codes.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button 
                        @click="open = !open" 
                        type="button" 
                        class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-body font-medium transition-all duration-200 text-brand-blush-lt/80 hover:bg-brand-white/10 hover:text-brand-white focus:outline-none"
                    >
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Event & Tiket
                        </span>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-collapse class="pl-4 py-1 space-y-1" style="display: none;">
                        @can('manage-events')
                            <a href="/admin/events" class="flex items-center gap-3 pl-8 pr-4 py-2 rounded-lg text-xs font-medium transition-all duration-200 {{ request()->routeIs('admin.events.*') ? 'bg-brand-primary text-brand-white' : 'text-brand-blush-lt/70 hover:bg-brand-white/5 hover:text-brand-white' }}">
                                Kelola Event
                            </a>
                        @endcan
                        @can('manage-phases')
                            <a href="/admin/phases" class="flex items-center gap-3 pl-8 pr-4 py-2 rounded-lg text-xs font-medium transition-all duration-200 {{ request()->routeIs('admin.phases.*') ? 'bg-brand-primary text-brand-white' : 'text-brand-blush-lt/70 hover:bg-brand-white/5 hover:text-brand-white' }}">
                                Fase Event
                            </a>
                        @endcan
                        <a href="/admin/event-sessions" class="flex items-center gap-3 pl-8 pr-4 py-2 rounded-lg text-xs font-medium transition-all duration-200 {{ request()->routeIs('admin.event-sessions.*') ? 'bg-brand-primary text-brand-white' : 'text-brand-blush-lt/70 hover:bg-brand-white/5 hover:text-brand-white' }}">
                            Sesi Event
                        </a>
                        <a href="/admin/ticket-types" class="flex items-center gap-3 pl-8 pr-4 py-2 rounded-lg text-xs font-medium transition-all duration-200 {{ request()->routeIs('admin.ticket-types.*') ? 'bg-brand-primary text-brand-white' : 'text-brand-blush-lt/70 hover:bg-brand-white/5 hover:text-brand-white' }}">
                            Tipe Tiket
                        </a>
                        <a href="/admin/promo-codes" class="flex items-center gap-3 pl-8 pr-4 py-2 rounded-lg text-xs font-medium transition-all duration-200 {{ request()->routeIs('admin.promo-codes.*') ? 'bg-brand-primary text-brand-white' : 'text-brand-blush-lt/70 hover:bg-brand-white/5 hover:text-brand-white' }}">
                            Kode Promo
                        </a>
                    </div>
                </div>

                <!-- Group 2: Blog & Konten -->
                <div x-data="{ open: {{ request()->routeIs('admin.posts.*', 'admin.categories.*', 'admin.speakers.*', 'admin.testimonials.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button 
                        @click="open = !open" 
                        type="button" 
                        class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-body font-medium transition-all duration-200 text-brand-blush-lt/80 hover:bg-brand-white/10 hover:text-brand-white focus:outline-none"
                    >
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            Blog & Konten
                        </span>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-collapse class="pl-4 py-1 space-y-1" style="display: none;">
                        @can('manage-posts')
                            <a href="/admin/posts" class="flex items-center gap-3 pl-8 pr-4 py-2 rounded-lg text-xs font-medium transition-all duration-200 {{ request()->routeIs('admin.posts.*') ? 'bg-brand-primary text-brand-white' : 'text-brand-blush-lt/70 hover:bg-brand-white/5 hover:text-brand-white' }}">
                                Artikel Blog
                            </a>
                        @endcan
                        @can('manage-categories')
                            <a href="/admin/categories" class="flex items-center gap-3 pl-8 pr-4 py-2 rounded-lg text-xs font-medium transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-brand-primary text-brand-white' : 'text-brand-blush-lt/70 hover:bg-brand-white/5 hover:text-brand-white' }}">
                                Kategori Blog
                            </a>
                        @endcan
                        @can('manage-speakers')
                            <a href="/admin/speakers" class="flex items-center gap-3 pl-8 pr-4 py-2 rounded-lg text-xs font-medium transition-all duration-200 {{ request()->routeIs('admin.speakers.*') ? 'bg-brand-primary text-brand-white' : 'text-brand-blush-lt/70 hover:bg-brand-white/5 hover:text-brand-white' }}">
                                Kelola Pembicara
                            </a>
                        @endcan
                        @can('manage-testimonials')
                            <a href="/admin/testimonials" class="flex items-center gap-3 pl-8 pr-4 py-2 rounded-lg text-xs font-medium transition-all duration-200 {{ request()->routeIs('admin.testimonials.*') ? 'bg-brand-primary text-brand-white' : 'text-brand-blush-lt/70 hover:bg-brand-white/5 hover:text-brand-white' }}">
                                Testimoni Value
                            </a>
                        @endcan
                    </div>
                </div>

                <!-- Group 3: Transaksi & Laporan -->
                <div x-data="{ open: {{ request()->routeIs('admin.orders.*', 'admin.reports.*', 'admin.check-in') ? 'true' : 'false' }} }" class="space-y-1">
                    <button 
                        @click="open = !open" 
                        type="button" 
                        class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-body font-medium transition-all duration-200 text-brand-blush-lt/80 hover:bg-brand-white/10 hover:text-brand-white focus:outline-none"
                    >
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H5m5 0h.01M13 14h.01M17 14h.01M21 14h.01M5 20h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z"></path></svg>
                            Order & Laporan
                        </span>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-collapse class="pl-4 py-1 space-y-1" style="display: none;">
                        <a href="/admin/orders" class="flex items-center gap-3 pl-8 pr-4 py-2 rounded-lg text-xs font-medium transition-all duration-200 {{ request()->routeIs('admin.orders.*') ? 'bg-brand-primary text-brand-white' : 'text-brand-blush-lt/70 hover:bg-brand-white/5 hover:text-brand-white' }}">
                            Riwayat Order
                        </a>
                        <a href="/admin/reports" class="flex items-center gap-3 pl-8 pr-4 py-2 rounded-lg text-xs font-medium transition-all duration-200 {{ request()->routeIs('admin.reports.*') ? 'bg-brand-primary text-brand-white' : 'text-brand-blush-lt/70 hover:bg-brand-white/5 hover:text-brand-white' }}">
                            Laporan Penjualan
                        </a>
                        <a href="/admin/check-in" class="flex items-center gap-3 pl-8 pr-4 py-2 rounded-lg text-xs font-medium transition-all duration-200 {{ request()->routeIs('admin.check-in') ? 'bg-brand-primary text-brand-white' : 'text-brand-blush-lt/70 hover:bg-brand-white/5 hover:text-brand-white' }}">
                            QR Check-In
                        </a>
                    </div>
                </div>

                <!-- Group 4: Sistem & Audit -->
                <div x-data="{ open: {{ request()->routeIs('admin.settings.*', 'admin.users.*', 'admin.activity-log.*', 'admin.messages.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button 
                        @click="open = !open" 
                        type="button" 
                        class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg text-body font-medium transition-all duration-200 text-brand-blush-lt/80 hover:bg-brand-white/10 hover:text-brand-white focus:outline-none"
                    >
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Sistem & Config
                        </span>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-collapse class="pl-4 py-1 space-y-1" style="display: none;">
                        @can('manage-settings')
                            <a href="/admin/settings" class="flex items-center gap-3 pl-8 pr-4 py-2 rounded-lg text-xs font-medium transition-all duration-200 {{ request()->routeIs('admin.settings') ? 'bg-brand-primary text-brand-white' : 'text-brand-blush-lt/70 hover:bg-brand-white/5 hover:text-brand-white' }}">
                                Pengaturan
                            </a>
                        @endcan
                        @can('manage-users')
                            <a href="/admin/users" class="flex items-center gap-3 pl-8 pr-4 py-2 rounded-lg text-xs font-medium transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-brand-primary text-brand-white' : 'text-brand-blush-lt/70 hover:bg-brand-white/5 hover:text-brand-white' }}">
                                User Admin
                            </a>
                        @endcan
                        <a href="/admin/activity-log" class="flex items-center gap-3 pl-8 pr-4 py-2 rounded-lg text-xs font-medium transition-all duration-200 {{ request()->routeIs('admin.activity-log') ? 'bg-brand-primary text-brand-white' : 'text-brand-blush-lt/70 hover:bg-brand-white/5 hover:text-brand-white' }}">
                            Audit Activity
                        </a>
                        @can('view-messages')
                            @php
                                $unreadMsgs = \App\Models\ContactMessage::where('status', \App\Enums\ContactMessageStatus::UNREAD)->count();
                            @endphp
                            <a href="/admin/messages" class="flex items-center justify-between pl-8 pr-4 py-2 rounded-lg text-xs font-medium transition-all duration-200 {{ request()->routeIs('admin.messages') ? 'bg-brand-primary text-brand-white' : 'text-brand-blush-lt/70 hover:bg-brand-white/5 hover:text-brand-white' }}">
                                <span>Pesan Kontak</span>
                                @if($unreadMsgs > 0)
                                    <span class="bg-brand-accent text-brand-primary text-[10px] font-bold px-1.5 py-0.5 rounded-full shrink-0">{{ $unreadMsgs }}</span>
                                @endif
                            </a>
                        @endcan
                    </div>
                </div>
            </nav>
        </div>

        <!-- Sidebar Footer / User Session Info -->
        <div class="p-4 border-t border-brand-primary/20 bg-brand-primary/10 flex items-center justify-between">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-10 h-10 rounded-full bg-brand-accent/20 border border-brand-accent flex items-center justify-center font-bold text-brand-accent text-lg uppercase shrink-0">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="font-medium text-sm text-brand-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-brand-blush-lt/70 truncate capitalize">{{ auth()->user()->role }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Admin Container -->
    <div class="flex-grow flex flex-col min-w-0 h-full overflow-hidden">
        <!-- Topbar -->
        <header class="h-20 bg-brand-white border-b border-slate-200 flex items-center justify-between px-6 shrink-0 shadow-[0_1px_3px_rgba(0,0,0,0.02)]" id="admin-topbar">
            <div class="flex items-center gap-4">
                <!-- Hamburger Trigger (lg hidden) -->
                <button 
                    @click="sidebarOpen = true" 
                    class="p-2 text-brand-primary hover:bg-brand-blush-lt/10 rounded-lg lg:hidden focus:outline-none"
                    aria-label="Open sidebar menu"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <h1 class="font-serif text-lg md:text-xl font-semibold text-brand-ink">@yield('page_title', 'Dashboard')</h1>
            </div>

            <!-- Topbar Utilities -->
            <div class="flex items-center gap-4">
                <a href="/" target="_blank" class="text-caption text-brand-ink/60 hover:text-brand-primary flex items-center gap-1.5 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    Lihat Situs
                </a>

                <!-- User Dropdown Menu -->
                <div x-data="{ open: false }" class="relative">
                    <button 
                        @click="open = !open" 
                        @click.away="open = false" 
                        class="flex items-center gap-2 focus:outline-none hover:bg-slate-50 p-2 rounded-lg transition-colors border border-transparent hover:border-slate-200"
                        id="user-dropdown-btn"
                    >
                        <span class="text-body font-medium text-brand-ink/80 hidden md:block">{{ auth()->user()->name }}</span>
                        <svg class="w-5 h-5 text-brand-ink/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <!-- Dropdown Options -->
                    <div 
                        x-show="open" 
                        x-transition
                        class="absolute right-0 mt-2 w-48 bg-brand-white border border-slate-200 rounded-lg shadow-brand-soft py-1 z-50"
                        style="display: none;"
                        id="user-dropdown-menu"
                    >
                        <a href="/profile" class="block px-4 py-2 text-body text-brand-ink/80 hover:bg-slate-50">Profil Saya</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-body text-red-600 hover:bg-red-50 focus:outline-none">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Admin Content Area -->
        <main class="flex-grow p-6 overflow-y-auto" id="admin-main-content">
            <!-- Flash Alerts -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
