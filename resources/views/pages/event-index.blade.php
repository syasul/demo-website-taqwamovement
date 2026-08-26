<x-layouts.app>
    @section('title', 'Daftar Event Spiritual Growth - Taqwa Movement')
    @section('meta_description', 'Jelajahi berbagai event dan program spiritual growth dari Taqwa Movement untuk membantu Anda menemukan kedamaian batin.')

    <!-- Breadcrumb section -->
    <div class="bg-brand-blush-lt/10 border-b border-brand-blush-lt/15 py-4 shrink-0">
        <div class="max-w-7xl mx-auto px-6 flex items-center gap-2 text-caption text-brand-ink/50" aria-label="Breadcrumb">
            <a href="/" class="hover:text-brand-primary transition-colors">Home</a>
            <span>&bull;</span>
            <span class="text-brand-primary font-medium">Event</span>
        </div>
    </div>

    <!-- Event Hero Header -->
    <section class="py-24 md:py-32 bg-brand-navy text-brand-white relative overflow-hidden" aria-labelledby="event-hero-title">
        <!-- Radial glow backdrops -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_30%,rgba(202,128,220,0.15),transparent_50%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_80%_70%,rgba(117,88,177,0.18),transparent_50%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(80,46,136,0.25),transparent_60%)]"></div>
        
        <!-- Subtle geometric matrix grid pattern -->
        <div class="absolute inset-0 opacity-[0.03] bg-[linear-gradient(to_right,#808080_1px,transparent_1px),linear-gradient(to_bottom,#808080_1px,transparent_1px)] bg-[size:32px_32px]"></div>

        <div class="max-w-5xl mx-auto px-6 text-center space-y-6 relative z-10">
            <h1 id="event-hero-title" class="font-serif text-h1 text-brand-gold leading-tight font-bold tracking-tight">
                Ruang Bertumbuh Bersama
            </h1>
            <p class="text-body text-brand-white/80 max-w-xl mx-auto leading-relaxed">
                Temukan ketenangan batin, arah hidup, dan ekosistem pemuda Muslim yang suportif melalui berbagai program event kami.
            </p>
        </div>
    </section>

    <!-- Events List Catalog Section -->
    <section class="py-16 md:py-24 bg-transparent border-t border-brand-blush-lt/10 relative z-10" aria-label="Event Catalog">
        <div class="max-w-7xl mx-auto px-6 space-y-16">
            
            @php
                // Separate events into upcoming (latest/active) and others
                $upcomingEvent = $events->firstWhere('date', '>=', now()->startOfDay());
                $otherEvents = $events->filter(fn($e) => !$upcomingEvent || $e->id !== $upcomingEvent->id);
            @endphp

            <!-- Featured Active Event -->
            @if($upcomingEvent)
                <div class="space-y-6">
                    <h2 class="font-serif text-h3 text-brand-primary font-bold">Event Terdekat</h2>
                    <div class="w-12 h-1 bg-brand-accent rounded-full"></div>
                    
                    <x-ui.glass-card class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch rounded-3xl shadow-[0_20px_50px_rgba(80,46,136,0.06)] border border-white/60">
                        <!-- Poster Column -->
                        <div class="lg:col-span-4 aspect-[3/4] relative rounded-2xl overflow-hidden shadow-glow border border-white/30">
                            <img 
                                src="{{ asset('images/events/level-up-your-iman-portrait.jpg') }}" 
                                alt="{{ $upcomingEvent->title }} Poster" 
                                class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                            />
                        </div>
                        
                        <!-- Details Column -->
                        <div class="lg:col-span-8 flex flex-col justify-between space-y-6 py-2">
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <span class="bg-brand-primary/10 text-brand-primary font-sans text-caption font-semibold px-3 py-1 rounded-full">
                                        {{ $upcomingEvent->phase->title ?? 'Fase 1' }}
                                    </span>
                                    <span class="text-caption text-brand-ink/60 font-medium">
                                        {{ $upcomingEvent->date->format('d F Y') }}
                                    </span>
                                </div>
                                
                                <h3 class="font-serif text-h2 text-brand-primary font-bold leading-tight">
                                    {{ $upcomingEvent->title }}
                                </h3>
                                
                                <p class="text-body text-brand-ink/80 italic font-medium">
                                    "{{ $upcomingEvent->tagline }}"
                                </p>
                                
                                <p class="text-body text-brand-ink/70 leading-relaxed line-clamp-3">
                                    {{ $upcomingEvent->description }}
                                </p>
                            </div>

                            <div class="pt-6 border-t border-brand-blush-lt/15 grid grid-cols-1 sm:grid-cols-3 gap-6 text-caption text-brand-ink/70">
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span>{{ $upcomingEvent->location }}</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>Sunday, 09.00 - 15.30 WIB</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-5 h-5 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    <span>{{ $upcomingEvent->speakers->pluck('name')->join(', ') }}</span>
                                </div>
                            </div>

                             <div class="pt-4 flex flex-col sm:flex-row gap-4">
                                <x-ui.glass-button 
                                    variant="light"
                                    href="/event/{{ $upcomingEvent->slug }}" 
                                    class="w-full sm:w-auto text-center"
                                >
                                    Detail Event
                                </x-ui.glass-button>
                                @if($upcomingEvent->ticket_url)
                                    <x-ui.glass-button 
                                        variant="accent"
                                        href="/event/{{ $upcomingEvent->slug }}/booking" 
                                        class="w-full sm:w-auto text-center font-bold"
                                    >
                                        Daftar Tiket
                                    </x-ui.glass-button>
                                @endif
                            </div>
                        </div>
                    </x-ui.glass-card>
                </div>
            @endif

            <!-- Event Catalog Grid -->
            <div class="space-y-6">
                <h2 class="font-serif text-h3 text-brand-primary font-bold">Semua Event</h2>
                <div class="w-12 h-1 bg-brand-accent rounded-full"></div>

                @if($events->isEmpty())
                    <x-ui.glass-card class="text-center py-16 space-y-4">
                        <svg class="w-12 h-12 mx-auto text-brand-ink/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p class="text-body text-brand-ink/50 font-medium">Belum ada program event yang terdaftar.</p>
                    </x-ui.glass-card>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($events as $event)
                            @php
                                $isUpcoming = $event->date->isFuture() || $event->date->isToday();
                            @endphp
                            <x-ui.glass-card class="flex flex-col justify-between hover:shadow-[0_20px_50px_rgba(80,46,136,0.12)] hover:-translate-y-1.5 transition-all duration-300 h-full rounded-[2rem] border border-white/60">
                                <div class="space-y-4">
                                    <!-- Banner Image with hover zoom effect and floating glass badges -->
                                    <div class="aspect-video relative rounded-2xl overflow-hidden shadow-sm">
                                        <img 
                                            src="{{ asset('images/events/level-up-your-iman-landscape.jpg') }}" 
                                            alt="{{ $event->title }} Banner" 
                                            class="w-full h-full object-cover transition-all duration-700 hover:scale-105"
                                        />
                                        <!-- Left floating status badge -->
                                        <div class="absolute top-3 left-3">
                                            @if($isUpcoming)
                                                <span class="bg-emerald-500 text-brand-white text-[10px] px-2.5 py-1 rounded-full font-bold uppercase tracking-wider shadow-sm">Mendatang</span>
                                            @else
                                                <span class="bg-brand-ink/75 text-brand-white text-[10px] px-2.5 py-1 rounded-full font-semibold uppercase tracking-wider backdrop-blur-sm">Selesai</span>
                                            @endif
                                        </div>
                                        <!-- Right floating glass category badge -->
                                        <div class="absolute top-3 right-3">
                                            <span class="bg-brand-white/80 backdrop-blur-md text-brand-primary text-[10px] px-3 py-1 rounded-full font-bold shadow-sm uppercase tracking-wider border border-white/50">
                                                {{ $event->phase->title ?? 'Program' }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Content block -->
                                    <div class="space-y-3 mt-4">
                                        <!-- Meta Bar (Date & Location Icons) -->
                                        <div class="flex items-center justify-between text-caption text-brand-ink/50 font-medium">
                                            <div class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-brand-primary/65" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span>{{ $event->date->format('d M Y') }}</span>
                                            </div>
                                            <div class="flex items-center gap-1.5 max-w-[130px] sm:max-w-[150px] truncate">
                                                <svg class="w-4 h-4 text-brand-primary/65 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                <span class="truncate">{{ $event->location }}</span>
                                            </div>
                                        </div>

                                        <h3 class="font-serif text-body-lg font-bold text-brand-primary leading-snug tracking-tight hover:text-brand-secondary transition-colors duration-200 line-clamp-1">
                                            {{ $event->title }}
                                        </h3>
                                        <p class="text-caption text-brand-ink/65 line-clamp-2 leading-relaxed min-h-[40px]">
                                            {{ $event->tagline }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Footer speaker block & button -->
                                <div class="pt-4 border-t border-brand-blush-lt/15 mt-5 flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-3 overflow-hidden">
                                        <div class="w-8 h-8 rounded-full bg-brand-white overflow-hidden border border-white/30 shrink-0 shadow-sm flex items-center justify-center">
                                            @if($event->speakers->first() && $event->speakers->first()->hasMedia('photo'))
                                                <img src="{{ $event->speakers->first()->getFirstMediaUrl('photo', 'thumb') }}" alt="Speaker" class="w-full h-full object-cover"/>
                                            @else
                                                <span class="text-[10px] font-bold text-brand-primary">TM</span>
                                            @endif
                                        </div>
                                        <div class="flex flex-col overflow-hidden">
                                            <span class="text-[9px] text-brand-ink/40 font-medium uppercase tracking-wider">Pembicara</span>
                                            <span class="text-xs font-bold text-brand-primary truncate max-w-[120px]">
                                                {{ $event->speakers->first()->name ?? 'Taqwa Speaker' }}
                                            </span>
                                        </div>
                                    </div>
                                    <x-ui.glass-button 
                                        variant="light"
                                        href="/event/{{ $event->slug }}" 
                                        class="text-xs shrink-0 py-2 px-5 font-bold shadow-brand-soft"
                                    >
                                        Detail
                                    </x-ui.glass-button>
                                </div>
                            </x-ui.glass-card>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </section>
</x-layouts.app>
