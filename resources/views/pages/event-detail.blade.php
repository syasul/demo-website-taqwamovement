<x-layouts.app>
    @section('title', $event->title . ' - Taqwa Movement')
    @section('meta_description', Str::limit(strip_tags($event->description), 150))

    <!-- Breadcrumb section -->
    <div class="bg-brand-blush-lt/10 border-b border-brand-blush-lt/15 py-4 shrink-0">
        <div class="max-w-7xl mx-auto px-6 flex items-center gap-2 text-caption text-brand-ink/50" aria-label="Breadcrumb">
            <a href="/" class="hover:text-brand-primary transition-colors">Home</a>
            <span>&bull;</span>
            <span class="text-brand-ink/40">Event</span>
            <span>&bull;</span>
            <span class="text-brand-primary font-medium truncate">{{ $event->title }}</span>
        </div>
    </div>

    <!-- Event Hero Section -->
    <section class="py-20 bg-mesh-glow text-brand-white relative overflow-hidden" aria-labelledby="event-hero-title">
        <div class="max-w-5xl mx-auto px-6 text-center space-y-8 relative z-10">
            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-brand-primary/20 text-brand-accent font-sans text-caption font-semibold uppercase tracking-wider border border-brand-accent/20">
                {{ $event->phase->title ?? 'Spiritual Awakening' }}
            </span>
            <h1 id="event-hero-title" class="font-serif text-hero text-brand-gold leading-tight font-bold tracking-tight">
                {{ $event->title }}
            </h1>
            <p class="text-body-lg text-brand-white/80 max-w-2xl mx-auto leading-relaxed">
                {{ $event->tagline }}
            </p>

            <!-- Alpine Countdown Timer -->
            <div 
                x-data="countdown('{{ $event->date->format('Y-m-d H:i:s') }}')" 
                x-init="init()"
                class="max-w-lg mx-auto grid grid-cols-4 gap-4 p-4 rounded-3xl bg-brand-white/10 backdrop-blur-md border border-brand-white/15 shadow-glow text-brand-white"
            >
                <div class="text-center">
                    <span class="block text-2xl md:text-3xl font-serif font-bold text-brand-gold" x-text="days">00</span>
                    <span class="text-xs uppercase font-medium tracking-wider text-brand-white/60">Hari</span>
                </div>
                <div class="text-center border-l border-brand-white/10">
                    <span class="block text-2xl md:text-3xl font-serif font-bold" x-text="hours">00</span>
                    <span class="text-xs uppercase font-medium tracking-wider text-brand-white/60">Jam</span>
                </div>
                <div class="text-center border-l border-brand-white/10">
                    <span class="block text-2xl md:text-3xl font-serif font-bold" x-text="minutes">00</span>
                    <span class="text-xs uppercase font-medium tracking-wider text-brand-white/60">Menit</span>
                </div>
                <div class="text-center border-l border-brand-white/10">
                    <span class="block text-2xl md:text-3xl font-serif font-bold text-brand-accent animate-pulse" x-text="seconds">00</span>
                    <span class="text-xs uppercase font-medium tracking-wider text-brand-white/60">Detik</span>
                </div>
            </div>

            <div class="pt-4 flex flex-col sm:flex-row justify-center items-center gap-4">
                @if($event->ticket_url)
                    <x-ui.glass-button 
                        variant="accent"
                        href="{{ route('event.booking', $event->slug) }}" 
                        class="w-full sm:w-auto"
                        id="event-detail-cta-ticket"
                    >
                        Ambil Tiket Sekarang
                    </x-ui.glass-button>
                @endif
                <x-ui.glass-button 
                    variant="light"
                    href="#rundown" 
                    class="w-full sm:w-auto"
                    id="event-detail-cta-rundown"
                >
                    Lihat Rundown Acara
                </x-ui.glass-button>
            </div>
        </div>
    </section>

    <!-- Main Content Grid -->
    <section class="py-20 md:py-32 bg-brand-white border-t border-brand-blush-lt/10" aria-label="Event Details">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-16">
            
            <!-- Left Column: Main Info (Description, Rundown, Topics) -->
            <div class="lg:col-span-8 space-y-20">
                <!-- Description -->
                <div class="space-y-6">
                    <h2 class="font-serif text-h2 text-brand-primary font-bold">Tentang Event</h2>
                    <div class="w-12 h-1 bg-brand-accent rounded-full"></div>
                    
                    <!-- Event Landscape Banner -->
                    <div class="rounded-2xl overflow-hidden shadow-brand-soft border border-brand-primary/10 mb-6">
                        <img src="{{ asset('images/events/level-up-your-iman-landscape.jpg') }}" alt="Level Up Your Iman Banner" class="w-full h-auto object-cover" />
                    </div>

                    <div class="text-body text-brand-ink/80 leading-relaxed space-y-4 prose max-w-none">
                        {!! $event->description !!}
                    </div>
                </div>

                <!-- 3 Value Proposition Cards (Features) -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-4">
                    @foreach($features as $feature)
                        <div class="bg-brand-white p-6 rounded-2xl border border-brand-blush-lt/20 text-center space-y-3 shadow-[0_4px_20px_rgba(80,46,136,0.02)]">
                            <span class="w-10 h-10 rounded-full bg-brand-primary/10 text-brand-primary flex items-center justify-center mx-auto text-body-lg">
                                @if($feature->icon === 'sparkles')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L11 3z"></path></svg>
                                @elseif($feature->icon === 'chat-bubble-left-right')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                @elseif($feature->icon === 'user-group')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @endif
                            </span>
                            <h3 class="font-serif font-bold text-brand-primary text-body">{{ $feature->title }}</h3>
                            <p class="text-caption text-brand-ink/75 leading-relaxed">{{ $feature->description }}</p>
                        </div>
                    @endforeach
                </div>

                <!-- Rundown Accordion Section -->
                <div id="rundown" class="space-y-6 scroll-mt-28">
                    <h2 class="font-serif text-h2 text-brand-primary font-bold">Rundown & Alur Acara</h2>
                    <div class="w-12 h-1 bg-brand-accent rounded-full"></div>
                    <p class="text-body text-brand-ink/70">Klik untuk melihat detail rundown untuk masing-masing sesi utama.</p>
                    
                    <div class="space-y-4">
                        @foreach($event->sessions as $session)
                            <x-ui.accordion :title="'Sesi 0' . $session->session_number . ': ' . $session->title" :open="$loop->first">
                                <p class="text-body font-medium text-brand-primary mb-4">{{ $session->description }}</p>
                                
                                <div class="space-y-4">
                                    @php
                                        $agendaItems = $event->agendaItems->where('session_group', $session->session_number);
                                    @endphp
                                    @if($agendaItems->isEmpty())
                                        <p class="text-caption text-brand-ink/50 italic">Jadwal rundown belum di-update.</p>
                                    @else
                                        @foreach($agendaItems as $item)
                                            <div class="flex gap-4 items-start p-4 rounded-xl hover:bg-brand-blush-lt/10 transition-colors border border-transparent hover:border-brand-blush-lt/20">
                                                <span class="px-3 py-1 bg-brand-secondary/15 text-brand-primary text-caption font-semibold rounded-lg shrink-0">
                                                    {{ $item->duration_label }}
                                                </span>
                                                <div class="space-y-1">
                                                    <h4 class="font-sans font-semibold text-brand-primary leading-tight">{{ $item->title }}</h4>
                                                    <p class="text-caption text-brand-ink/65 font-medium leading-none">{{ $item->subtitle }}</p>
                                                    <p class="text-caption text-brand-ink/75 leading-relaxed pt-1">{{ $item->description }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </x-ui.accordion>
                        @endforeach
                    </div>
                </div>

                <!-- Focus Topics Section -->
                <div class="space-y-6">
                    <h2 class="font-serif text-h2 text-brand-primary font-bold">Apa yang Akan Kamu Pelajari</h2>
                    <div class="w-12 h-1 bg-brand-accent rounded-full"></div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($event->sessions as $session)
                            <div class="bg-slate-50 border border-slate-200 p-6 rounded-2xl space-y-4">
                                <h3 class="font-serif font-bold text-brand-primary text-body-lg">Fokus Sesi 0{{ $session->session_number }}:</h3>
                                <ul class="space-y-3">
                                    @foreach($session->topics as $topic)
                                        <li class="flex items-start gap-2.5 text-body text-brand-ink/80 leading-snug">
                                            <span class="w-5 h-5 rounded-full bg-brand-primary/10 text-brand-primary flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">{{ $loop->iteration }}</span>
                                            <span>{{ $topic->topic_text }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Speaker profiles -->
                <div class="space-y-6">
                    <h2 class="font-serif text-h2 text-brand-primary font-bold">Pembicara</h2>
                    <div class="w-12 h-1 bg-brand-accent rounded-full"></div>
                    
                    <div class="grid grid-cols-1 gap-6">
                        @foreach($event->speakers as $speaker)
                            <div class="bg-brand-white border border-brand-blush-lt/30 p-6 md:p-8 rounded-2xl shadow-brand-soft flex flex-col md:flex-row items-center md:items-start gap-6">
                                <!-- Photo circle -->
                                <div class="w-24 h-24 md:w-32 md:h-32 rounded-full bg-brand-blush flex items-center justify-center font-serif text-h1 font-bold text-brand-primary overflow-hidden shrink-0 border-2 border-brand-accent">
                                    <img src="{{ asset('images/events/level-up-your-iman-portrait.jpg') }}" alt="Koh Dennis Lim Profile" class="w-full h-full object-cover" />
                                </div>
                                <div class="space-y-3 text-center md:text-left flex-grow">
                                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-2">
                                        <div>
                                            <h3 class="font-serif text-h3 font-bold text-brand-primary leading-none">{{ $speaker->name }}</h3>
                                            <span class="text-caption text-brand-ink/50 font-medium">{{ $speaker->role_title }}</span>
                                        </div>
                                        @if($speaker->instagram_url)
                                            <a 
                                                href="{{ $speaker->instagram_url }}" 
                                                target="_blank" 
                                                rel="noopener"
                                                class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full border border-brand-primary/10 hover:bg-brand-primary/5 text-caption font-semibold text-brand-primary self-center md:self-start transition-all duration-300"
                                            >
                                                Instagram
                                            </a>
                                        @endif
                                    </div>
                                    <p class="text-body text-brand-ink/75 leading-relaxed">{{ $speaker->bio }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Ticketing & Registration Redirect Card -->
                @if($event->ticket_url)
                <x-ui.glass-card class="bg-brand-primary/5 border border-brand-primary/10 p-8 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="space-y-2 text-center sm:text-left">
                        <h3 class="font-serif text-h3 font-bold text-brand-primary">Amankan Tiket Anda Sekarang</h3>
                        <p class="text-caption text-brand-ink/75 leading-relaxed">Pendaftaran tiket dilakukan secara in-house dengan metode pembayaran online instan.</p>
                    </div>
                    <x-ui.glass-button 
                        variant="accent"
                        href="{{ route('event.booking', $event->slug) }}"
                        class="shrink-0 w-full sm:w-auto"
                        id="event-detail-go-booking"
                    >
                        Pilih Tiket & Daftar
                    </x-ui.glass-button>
                </x-ui.glass-card>
                @endif
            </div>

            <!-- Right Column: Sidebar (Technical Details & Audience Point) -->
            <div class="lg:col-span-4 space-y-8 lg:sticky lg:top-28 lg:self-start">
                <!-- Technical Details Sidebar Card -->
                <x-ui.glass-card class="space-y-6 bg-brand-white/40 border border-brand-primary/10 shadow-sm">
                    <h3 class="font-serif text-body-lg font-bold text-brand-primary border-b border-brand-blush-lt/20 pb-3">Detail Teknis</h3>
                    
                    <ul class="space-y-6">
                        <li class="flex items-start gap-4">
                            <span class="p-2.5 bg-brand-primary/10 text-brand-primary rounded-xl shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </span>
                            <div>
                                <span class="text-xs text-brand-ink/50 block font-medium uppercase tracking-wider">Tanggal</span>
                                <span class="text-body font-semibold text-brand-primary">{{ $event->date->format('l, d F Y') }}</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="p-2.5 bg-brand-primary/10 text-brand-primary rounded-xl shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            <div>
                                <span class="text-xs text-brand-ink/50 block font-medium uppercase tracking-wider">Waktu Sesi 1</span>
                                <span class="text-body font-semibold text-brand-primary">09.00 - 11.30 WIB</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="p-2.5 bg-brand-primary/10 text-brand-primary rounded-xl shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            <div>
                                <span class="text-xs text-brand-ink/50 block font-medium uppercase tracking-wider">Waktu Sesi 2</span>
                                <span class="text-body font-semibold text-brand-primary">13.00 - 15.30 WIB</span>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <span class="p-2.5 bg-brand-primary/10 text-brand-primary rounded-xl shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </span>
                            <div>
                                <span class="text-xs text-brand-ink/50 block font-medium uppercase tracking-wider">Lokasi</span>
                                <span class="text-body font-semibold text-brand-primary leading-tight block">{{ $event->location }}</span>
                            </div>
                        </li>
                    </ul>

                    @if($event->ticket_url)
                        <div class="pt-6 border-t border-brand-blush-lt/20">
                            <x-ui.glass-button 
                                variant="accent"
                                href="{{ route('event.booking', $event->slug) }}" 
                                class="w-full"
                                id="sidebar-cta-ticket"
                            >
                                Ambil Tiket Sekarang
                            </x-ui.glass-button>
                        </div>
                    @endif
                </x-ui.glass-card>

                <!-- Google Maps Card -->
                <x-ui.glass-card class="overflow-hidden !p-0 bg-brand-white/40 border border-brand-primary/10 shadow-sm">
                    <div class="p-6 pb-2">
                        <h4 class="font-serif text-body-lg font-bold text-brand-primary">Peta Lokasi</h4>
                        <p class="text-caption text-brand-ink/50 leading-normal">{{ $event->location }}</p>
                    </div>
                    <div class="h-48 w-full bg-slate-100 relative">
                        <iframe 
                            src="https://maps.google.com/maps?q={{ urlencode($event->location) }}&t=&z=13&ie=UTF8&iwloc=&output=embed" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Peta Lokasi Event"
                        ></iframe>
                    </div>
                </x-ui.glass-card>

                <!-- Audience points Checklist Card -->
                <x-ui.glass-card class="space-y-6 bg-brand-white/40 border border-brand-primary/10 shadow-sm">
                    <h3 class="font-serif text-body-lg font-bold text-brand-primary border-b border-brand-blush-lt/20 pb-3">Cocok Untuk Kamu Yang...</h3>
                    
                    <ul class="space-y-4">
                        @foreach($event->audiencePoints as $point)
                            <li class="flex items-start gap-3 text-caption text-brand-ink/75 leading-relaxed">
                                <span class="p-1 bg-emerald-50 text-emerald-600 rounded-full shrink-0 border border-emerald-100 mt-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                </span>
                                <span>{{ $point->text }}</span>
                            </li>
                        @endforeach
                    </ul>
                </x-ui.glass-card>
            </div>
        </div>
    </section>

    <!-- Schema.org Structured Data -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@type": "Event",
      "name": "{{ $event->title }}",
      "startDate": "{{ $event->date->toIso8601String() }}",
      "location": {
        "@type": "Place",
        "name": "{{ $event->location }}",
        "address": "{{ $event->location }}"
      },
      "description": "{{ strip_tags($event->description) }}",
      "offers": {
        "@type": "Offer",
        "url": "{{ $event->ticket_url }}",
        "price": "0",
        "priceCurrency": "IDR",
        "availability": "https://schema.org/InStock"
      },
      "performer": [
        @foreach($event->speakers as $index => $speaker)
          {
            "@type": "Person",
            "name": "{{ $speaker->name }}"
          }{{ $index < $event->speakers->count() - 1 ? ',' : '' }}
        @endforeach
      ]
    }
    </script>

    <script>
        function countdown(targetDateStr) {
            return {
                targetDate: new Date(targetDateStr).getTime(),
                days: '00',
                hours: '00',
                minutes: '00',
                seconds: '00',
                timer: null,
                init() {
                    this.update();
                    this.timer = setInterval(() => { this.update() }, 1000);
                },
                update() {
                    const now = new Date().getTime();
                    const distance = this.targetDate - now;

                    if (distance < 0) {
                        clearInterval(this.timer);
                        this.days = '00';
                        this.hours = '00';
                        this.minutes = '00';
                        this.seconds = '00';
                        return;
                    }

                    const daysVal = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hoursVal = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutesVal = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const secondsVal = Math.floor((distance % (1000 * 60)) / 1000);

                    this.days = String(daysVal).padStart(2, '0');
                    this.hours = String(hoursVal).padStart(2, '0');
                    this.minutes = String(minutesVal).padStart(2, '0');
                    this.seconds = String(secondsVal).padStart(2, '0');
                }
            }
        }
    </script>
</x-layouts.app>
