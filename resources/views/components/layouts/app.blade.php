<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', \App\Models\Setting::get('seo.default_title', 'Taqwa Movement'))</title>
    <meta name="description" content="@yield('meta_description', \App\Models\Setting::get('seo.default_description', 'Spiritual Growth Platform'))">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', \App\Models\Setting::get('seo.default_title', 'Taqwa Movement'))">
    <meta property="og:description" content="@yield('meta_description', \App\Models\Setting::get('seo.default_description', 'Spiritual Growth Platform'))">
    <meta property="og:image" content="@yield('og_image', asset(\App\Models\Setting::get('seo.default_og_image', '/images/default-og.jpg')))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', \App\Models\Setting::get('seo.default_title', 'Taqwa Movement'))">
    <meta property="twitter:description" content="@yield('meta_description', \App\Models\Setting::get('seo.default_description', 'Spiritual Growth Platform'))">
    <meta property="twitter:image" content="@yield('og_image', asset(\App\Models\Setting::get('seo.default_og_image', '/images/default-og.jpg')))">

    <link rel="canonical" href="{{ url()->current() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
<body class="font-sans text-brand-ink bg-brand-cream antialiased min-h-screen flex flex-col selection:bg-brand-accent/30 selection:text-brand-primary overflow-x-hidden">
    <!-- Outer wrapper to prevent horizontal scrolling on mobile viewports -->
    <div 
        x-data="{ 
            isScrolled: false, 
            mobileMenuOpen: false 
        }"
        x-init="window.addEventListener('scroll', () => { isScrolled = window.scrollY > 20 })"
        class="flex-grow flex flex-col relative w-full min-h-screen"
    >
        <!-- Ambient Background Glow Blobs -->
        <div class="absolute top-[-10%] left-[-20%] w-[500px] h-[500px] rounded-full bg-brand-primary/5 filter blur-[120px] pointer-events-none z-0"></div>
        <div class="absolute top-[30%] right-[-10%] w-[600px] h-[600px] rounded-full bg-brand-accent/5 filter blur-[150px] pointer-events-none z-0"></div>
        <div class="absolute bottom-[10%] left-[10%] w-[500px] h-[500px] rounded-full bg-brand-blush/5 filter blur-[120px] pointer-events-none z-0"></div>

    <!-- Sticky Header & Navbar -->
    <header 
        :class="isScrolled ? 'top-4 px-4' : 'top-0'"
        class="fixed left-0 right-0 z-50 transition-all duration-300 ease-out max-w-7xl mx-auto"
        id="main-header"
    >
        <nav 
            :class="isScrolled ? 'bg-brand-white/75 backdrop-blur-lg border border-brand-white/40 shadow-brand-soft rounded-full px-4 sm:px-8 h-16 md:h-20' : 'bg-transparent h-20 md:h-24 px-4 sm:px-6 border-transparent'"
            class="w-full flex items-center justify-between transition-all duration-300 ease-out" 
            aria-label="Main Navigation"
        >
            <!-- Brand Logo -->
            <a href="/" class="flex items-center group focus:outline-none focus:ring-2 focus:ring-brand-accent rounded-lg" id="logo-link">
                <img src="{{ asset('images/logo-white-bg.png') }}" alt="Taqwa Movement Logo" :class="isScrolled ? 'h-7 md:h-8' : 'h-10 md:h-12'" class="w-auto object-contain transition-all duration-300 group-hover:scale-[1.02]" />
            </a>

            @php
                $activeEvent = \App\Models\Event::where('status', \App\Enums\EventStatus::PUBLISHED)->first();
            @endphp

            <!-- Desktop Menu Links -->
            <div class="hidden md:flex items-center gap-8">
                <a href="/" class="text-body font-medium transition-colors duration-300 hover:text-brand-primary {{ request()->routeIs('home') ? 'text-brand-primary font-semibold border-b-2 border-brand-primary' : 'text-brand-ink/75' }}" id="nav-home">Home</a>
                <a href="/about" class="text-body font-medium transition-colors duration-300 hover:text-brand-primary {{ request()->routeIs('about') ? 'text-brand-primary font-semibold border-b-2 border-brand-primary' : 'text-brand-ink/75' }}" id="nav-about">About Us</a>
                <a href="/event" class="text-body font-medium transition-colors duration-300 hover:text-brand-primary {{ request()->routeIs('event.*') ? 'text-brand-primary font-semibold border-b-2 border-brand-primary' : 'text-brand-ink/75' }}" id="nav-event">Event</a>
                <a href="/blog" class="text-body font-medium transition-colors duration-300 hover:text-brand-primary {{ request()->routeIs('blog.*') ? 'text-brand-primary font-semibold border-b-2 border-brand-primary' : 'text-brand-ink/75' }}" id="nav-blog">Blog</a>
                <a href="/kontak" class="text-body font-medium transition-colors duration-300 hover:text-brand-primary {{ request()->routeIs('contact.index') ? 'text-brand-primary font-semibold border-b-2 border-brand-primary' : 'text-brand-ink/75' }}" id="nav-contact">Kontak</a>
            </div>

            <!-- Desktop CTA Button -->
            <div class="hidden md:block">
                @if($activeEvent && $activeEvent->ticket_url)
                    <a 
                        href="{{ $activeEvent->ticket_url }}" 
                        target="_blank" 
                        rel="noopener"
                        class="inline-flex items-center justify-center px-6 py-3 rounded-full text-brand-white bg-gradient-to-r from-brand-primary via-brand-secondary to-brand-accent font-medium tracking-wide shadow-brand-soft hover:shadow-[0_12px_35px_rgba(80,46,136,0.25)] hover:scale-105 active:scale-95 transition-all duration-300 ease-out focus:ring-2 focus:ring-brand-accent focus:outline-none"
                        id="cta-ticket-desktop"
                    >
                        Ambil Tiket
                    </a>
                @else
                    <a 
                        href="/kontak" 
                        class="inline-flex items-center justify-center px-6 py-3 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium tracking-wide shadow-brand-soft transition-all duration-300 ease-out focus:ring-2 focus:ring-brand-accent focus:outline-none"
                        id="cta-contact-desktop"
                    >
                        Hubungi Kami
                    </a>
                @endif
            </div>

            <!-- Hamburger Button (Mobile) -->
            <button 
                @click="mobileMenuOpen = true" 
                class="block md:hidden text-brand-primary p-2 focus:outline-none focus:ring-2 focus:ring-brand-accent rounded-lg"
                aria-label="Open navigation menu"
                aria-expanded="false"
                :aria-expanded="mobileMenuOpen.toString()"
                id="hamburger-btn"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>


        </nav>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow pt-20 md:pt-24" id="main-content">
        {{ $slot }}
    </main>

    <!-- Footer Section -->
    <footer class="bg-brand-ink text-brand-white pt-20 pb-12 border-t border-brand-primary/10" aria-label="Site Footer" id="main-footer">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            <!-- Brand Info Column -->
            <div class="md:col-span-2">
                <a href="/" class="inline-flex items-center mb-6 group focus:outline-none" id="footer-logo-link">
                    <img src="{{ asset('images/logo-dark-bg.png') }}" alt="Taqwa Movement Logo" class="h-11 w-auto object-contain transition-transform duration-300 group-hover:scale-[1.02]" />
                </a>
                <p class="text-brand-blush-lt/80 text-body mb-8 max-w-sm leading-relaxed">
                    {{ \App\Models\Setting::get('footer.description', 'Taqwa Movement adalah Spiritual Growth Platform berbasis Event & Community Ecosystem untuk generasi muda.') }}
                </p>
                <!-- Social Media Icons -->
                <div class="flex gap-4">
                    @php
                        $socials = [
                            'instagram' => ['url' => \App\Models\Setting::get('social.instagram'), 'icon' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>'],
                            'facebook' => ['url' => \App\Models\Setting::get('social.facebook'), 'icon' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>'],
                            'linkedin' => ['url' => \App\Models\Setting::get('social.linkedin'), 'icon' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>'],
                            'x' => ['url' => \App\Models\Setting::get('social.x'), 'icon' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>'],
                        ];
                    @endphp
                    @foreach($socials as $name => $social)
                        @if($social['url'])
                            <a 
                                href="{{ $social['url'] }}" 
                                target="_blank" 
                                rel="noopener" 
                                class="w-10 h-10 rounded-full border border-brand-blush-lt/20 flex items-center justify-center text-brand-blush-lt hover:text-brand-accent hover:border-brand-accent hover:scale-105 transition-all duration-300"
                                aria-label="Follow us on {{ ucfirst($name) }}"
                            >
                                {!! $social['icon'] !!}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Quick Links Column -->
            <div>
                <h3 class="font-serif text-lg font-semibold text-brand-white mb-6">Quick Links</h3>
                <ul class="flex flex-col gap-4 text-brand-blush-lt/85">
                    <li><a href="/about" class="hover:text-brand-accent transition-colors duration-200">About Us</a></li>
                    <li><a href="/blog" class="hover:text-brand-accent transition-colors duration-200">Blog Refleksi</a></li>
                    <li><a href="/kontak" class="hover:text-brand-accent transition-colors duration-200">Contact Us</a></li>
                    <li><a href="#" class="hover:text-brand-accent transition-colors duration-200">Privacy Policy</a></li>
                </ul>
            </div>

            <!-- Contact Info Column -->
            <div>
                <h3 class="font-serif text-lg font-semibold text-brand-white mb-6">Contact Info</h3>
                <ul class="flex flex-col gap-4 text-brand-blush-lt/85">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-brand-accent shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span class="text-caption leading-relaxed">{{ \App\Models\Setting::get('contact.address', 'Jl. Tawangsari, Malang') }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-brand-accent shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span class="text-caption">{{ \App\Models\Setting::get('contact.email', 'info@taqwamovement.id') }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-brand-accent shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-caption">{{ \App\Models\Setting::get('contact.hours', '09.00 - 17.00 WIB') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Copyright Info -->
        <div class="max-w-7xl mx-auto px-6 pt-8 border-t border-brand-blush-lt/10 flex flex-col md:flex-row items-center justify-between gap-4 text-brand-blush-lt/60 text-caption">
            <p>&copy; {{ date('Y') }} Taqwa Movement. All rights reserved.</p>
            <p>Made with heart for Spiritual Growth.</p>
        </div>
    </footer>

    <!-- Mobile Drawer Menu Overlay -->
    <div 
        x-show="mobileMenuOpen" 
        x-transition:opacity
        class="fixed inset-0 bg-brand-ink/40 backdrop-blur-sm z-50 md:hidden"
        style="display: none;"
        @click="mobileMenuOpen = false"
    ></div>

    <!-- Mobile Drawer Menu Panel -->
    <div 
        x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed right-0 top-0 bottom-0 w-80 bg-brand-white shadow-2xl z-50 p-8 flex flex-col md:hidden"
        style="display: none;"
        id="mobile-drawer"
    >
        <div class="flex items-center justify-between mb-12">
            <span class="font-serif text-xl font-bold text-brand-primary">Navigation</span>
            <button 
                @click="mobileMenuOpen = false" 
                class="text-brand-primary p-2 focus:outline-none focus:ring-2 focus:ring-brand-accent rounded-lg"
                aria-label="Close navigation menu"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="flex flex-col gap-6 text-lg mb-auto">
            <a href="/" class="font-medium hover:text-brand-primary py-2 border-b border-brand-blush-lt/10 {{ request()->routeIs('home') ? 'text-brand-primary' : 'text-brand-ink/75' }}" @click="mobileMenuOpen = false">Home</a>
            <a href="/about" class="font-medium hover:text-brand-primary py-2 border-b border-brand-blush-lt/10 {{ request()->routeIs('about') ? 'text-brand-primary' : 'text-brand-ink/75' }}" @click="mobileMenuOpen = false">About Us</a>
            <a href="/event" class="font-medium hover:text-brand-primary py-2 border-b border-brand-blush-lt/10 {{ request()->routeIs('event.*') ? 'text-brand-primary' : 'text-brand-ink/75' }}" @click="mobileMenuOpen = false">Event</a>
            <a href="/blog" class="font-medium hover:text-brand-primary py-2 border-b border-brand-blush-lt/10 {{ request()->routeIs('blog.*') ? 'text-brand-primary' : 'text-brand-ink/75' }}" @click="mobileMenuOpen = false">Blog</a>
            <a href="/kontak" class="font-medium hover:text-brand-primary py-2 {{ request()->routeIs('contact.index') ? 'text-brand-primary' : 'text-brand-ink/75' }}" @click="mobileMenuOpen = false">Kontak</a>
        </div>

        <div class="mt-8 pt-8 border-t border-brand-blush-lt/20">
            @if($activeEvent && $activeEvent->ticket_url)
                <a 
                    href="{{ $activeEvent->ticket_url }}" 
                    target="_blank" 
                    rel="noopener"
                    class="w-full inline-flex items-center justify-center px-6 py-4 rounded-full text-brand-white bg-gradient-to-r from-brand-primary via-brand-secondary to-brand-accent font-medium tracking-wide shadow-brand-soft hover:shadow-[0_12px_35px_rgba(80,46,136,0.25)] hover:scale-105 active:scale-95 transition-all duration-300"
                    id="cta-ticket-mobile"
                >
                    Ambil Tiket
                </a>
            @else
                <a 
                    href="/kontak" 
                    class="w-full inline-flex items-center justify-center px-6 py-4 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium tracking-wide shadow-brand-soft transition-all duration-300"
                    id="cta-contact-mobile"
                >
                    Hubungi Kami
                </a>
            @endif
        </div>
    </div>

    @php
        $waPhone = \App\Models\Setting::get('contact.phone', '+62 812-3456-7890');
        $waCleanNumber = preg_replace('/[^0-9]/', '', $waPhone);
        if (str_starts_with($waCleanNumber, '0')) {
            $waCleanNumber = '62' . substr($waCleanNumber, 1);
        }
    @endphp

    <!-- Floating WhatsApp CTA -->
    <a 
        href="https://wa.me/{{ $waCleanNumber }}?text=Halo%20Taqwa%20Movement%2C%20saya%20ingin%20bertanya%20mengenai..." 
        target="_blank" 
        rel="noopener"
        class="fixed bottom-6 right-6 z-[99] flex items-center justify-center w-14 h-14 bg-[#25D366] hover:bg-[#128C7E] text-white rounded-full shadow-[0_10px_30px_rgba(37,211,102,0.3)] hover:scale-110 active:scale-95 transition-all duration-300 group"
        aria-label="Chat WhatsApp"
    >
        <!-- WhatsApp Icon -->
        <svg class="w-7 h-7 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.725 1.45 5.556 0 10.082-4.522 10.085-10.086.002-2.695-1.047-5.232-2.951-7.138C16.505 1.472 13.97 1.42 11.278 1.42c-5.56 0-10.088 4.523-10.091 10.087-.001 1.83.483 3.619 1.401 5.2l-.187.683-.873 3.193 3.256-.855.703-.174zM16.75 13.96c-.272-.137-1.614-.797-1.863-.888-.249-.09-.431-.137-.613.137-.182.273-.706.888-.865 1.07-.159.182-.318.205-.59.069-.272-.137-1.15-.424-2.19-1.353-.809-.722-1.355-1.614-1.514-1.886-.159-.272-.017-.42.119-.556.122-.122.272-.318.408-.477.136-.159.182-.272.272-.455.09-.182.046-.341-.023-.477-.069-.137-.613-1.477-.84-2.023-.222-.534-.443-.46-.613-.469-.159-.009-.341-.009-.523-.009-.182 0-.477.069-.727.341-.25.272-.955.933-.955 2.273 0 1.341.977 2.636 1.114 2.818.137.182 1.92 2.932 4.653 4.114.65.281 1.157.449 1.553.575.654.208 1.248.179 1.718.109.523-.078 1.614-.659 1.841-1.295.227-.636.227-1.182.159-1.295-.068-.113-.249-.182-.522-.318z"/>
        </svg>
        
        <!-- Tooltip -->
        <span class="absolute right-16 scale-0 group-hover:scale-100 bg-brand-ink text-brand-white text-caption font-semibold px-3 py-1.5 rounded-xl shadow-lg transition-all duration-300 origin-right select-none pointer-events-none whitespace-nowrap border border-white/10">
            Tanya Taqwa Movement
        </span>
    </a>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>
