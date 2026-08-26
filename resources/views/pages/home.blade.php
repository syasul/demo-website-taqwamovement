<x-layouts.app>
    <!-- Section 1: Hero Section -->
    <section class="relative bg-transparent py-24 md:py-36 overflow-hidden" aria-labelledby="hero-heading">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center relative z-10">
            <!-- Hero Text Content -->
            <div class="lg:col-span-7 text-center lg:text-left space-y-8">
                <h1 id="hero-heading" class="font-serif text-hero text-brand-ink leading-none font-bold tracking-tight">
                    Elevating faith.<br class="hidden md:inline"> 
                    <span class="text-brand-primary">Empowering life.</span>
                </h1>
                
                <p class="text-body-lg text-brand-ink/75 max-w-xl mx-auto lg:mx-0 leading-relaxed font-sans">
                    Ruang aman untuk mengurai bisingnya dunia. Temukan kembali kedamaian batin dan arah hidupmu melalui rangkaian spiritual growth event dan ekosistem komunitas kami.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    @if($activeEvent)
                        <a 
                            href="/event/{{ $activeEvent->slug }}" 
                            class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium tracking-wide shadow-brand-soft hover:shadow-[0_12px_35px_rgba(80,46,136,0.2)] hover:-translate-y-0.5 transition-all duration-300 focus:ring-2 focus:ring-brand-accent focus:outline-none"
                            id="hero-cta-primary"
                        >
                            Lihat Event Aktif
                        </a>
                    @else
                        <a 
                            href="/kontak" 
                            class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium tracking-wide shadow-brand-soft hover:-translate-y-0.5 transition-all duration-300 focus:ring-2 focus:ring-brand-accent focus:outline-none"
                            id="hero-cta-contact"
                        >
                            Hubungi Kami
                        </a>
                    @endif
                    <a 
                        href="/about" 
                        class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 rounded-full text-brand-primary border border-brand-primary/20 hover:bg-brand-primary/5 font-medium tracking-wide transition-all duration-300"
                        id="hero-cta-secondary"
                    >
                        Pelajari Visi Kami
                    </a>
                </div>
            </div>

            <!-- Hero Image Collage -->
            <div class="lg:col-span-5 relative flex justify-center items-center">
                <div class="relative w-full max-w-[320px] sm:max-w-[360px] aspect-[3/4] rounded-3xl overflow-hidden border-4 border-brand-white shadow-[0_20px_50px_rgba(80,46,136,0.15)] transition-all duration-500 hover:scale-[1.02] hover:shadow-[0_25px_60px_rgba(80,46,136,0.2)]">
                    <img 
                        src="{{ asset('images/events/level-up-your-iman-portrait.jpg') }}" 
                        alt="Taqwa Movement Event Poster" 
                        class="w-full h-full object-cover"
                    />
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 md:py-32 bg-transparent" aria-labelledby="intro-heading">
        <div class="max-w-4xl mx-auto px-6 text-center space-y-6">
            <span class="font-accent text-3xl text-brand-secondary block">Taqwa Movement &mdash; Spiritual Hub</span>
            <h2 id="intro-heading" class="font-serif text-h1 text-brand-primary font-bold tracking-tight">
                Ruang aman untuk mengurai bisingnya dunia.
            </h2>
            <div class="w-16 h-1 bg-brand-accent mx-auto rounded-full"></div>
            <p class="text-body-lg text-brand-ink/75 leading-relaxed font-sans max-w-2xl mx-auto">
                Di tengah derasnya tuntutan ekspektasi dan cepatnya arus kehidupan modern, batin kita seringkali menjadi lelah dan kehilangan arah. Kami hadir sebagai ekosistem bertumbuh yang mempertemukan refleksi iman logis dengan bimbingan praktis, membantumu meniti jalan pulang menuju kedamaian batin sejati.
            </p>
        </div>
    </section>

    <!-- Section 3: Event Highlight Section -->
    @if($activeEvent)
        <section class="py-20 md:py-32 bg-transparent" aria-labelledby="event-heading">
            <div class="max-w-7xl mx-auto px-6">
                <!-- Section Title -->
                <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                    <span class="text-caption font-semibold uppercase tracking-wider text-brand-secondary block">Kajian & Event Terdekat</span>
                    <h2 id="event-heading" class="font-serif text-h1 text-brand-primary font-bold tracking-tight">
                        Who Are You Becoming?
                    </h2>
                    <p class="text-body text-brand-ink/70">Daftarkan dirimu dalam event spiritual growth yang didesain secara tematis untuk merapikan hati.</p>
                </div>

                <!-- Event Box -->
                <x-ui.glass-card class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch border border-white/60 shadow-[0_20px_50px_rgba(80,46,136,0.08)]">
                    <!-- Session Details (Loop) -->
                    <div class="lg:col-span-8 order-2 lg:order-1 space-y-8 flex flex-col justify-between">
                        <div>
                            <!-- Phase Badge & Event Title -->
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-brand-primary/10 text-brand-primary font-sans text-caption font-semibold px-3 py-1 rounded-full">
                                    {{ $activeEvent->phase->title ?? 'Fase 1' }}
                                </span>
                                <span class="text-caption text-brand-ink/50">{{ $activeEvent->date->format('d M Y') }}</span>
                            </div>
                            <h3 class="font-serif text-h2 text-brand-primary font-bold mb-4">{{ $activeEvent->title }}</h3>
                            <p class="text-body text-brand-ink/75 mb-8 italic">"{{ $activeEvent->tagline }}"</p>

                            <!-- Sessions loop -->
                            <div class="space-y-6">
                                <h4 class="font-serif text-body-lg font-bold text-brand-ink border-b border-brand-blush-lt/20 pb-2">Rangkaian Sesi Acara:</h4>
                                @foreach($activeEvent->sessions as $session)
                                    <div class="flex gap-4 items-start">
                                        <div class="w-12 h-12 rounded-xl bg-brand-blush-lt/30 border border-brand-blush-lt flex items-center justify-center shrink-0">
                                            <span class="font-serif font-bold text-brand-primary">0{{ $session->session_number }}</span>
                                        </div>
                                        <div>
                                            <h5 class="font-sans font-semibold text-brand-primary">{{ $session->title }}</h5>
                                            <p class="text-caption text-brand-ink/75 leading-relaxed">{{ $session->description }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Technical Info Bar -->
                        <div class="pt-8 border-t border-brand-blush-lt/20 grid grid-cols-1 sm:grid-cols-3 gap-4 text-caption text-brand-ink/70">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-brand-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>{{ Str::limit($activeEvent->location, 25) }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-brand-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>{{ $activeEvent->sessions->count() }} Sesi Reflektif</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-brand-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span>{{ $activeEvent->speakers->pluck('name')->join(', ') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Panel & Poster -->
                    <div class="lg:col-span-4 order-1 lg:order-2 bg-brand-primary/10 border border-brand-primary/15 p-6 rounded-2xl flex flex-col justify-between items-center text-center backdrop-blur-sm">
                        <div class="w-full space-y-4">
                            <!-- Visual event flyer preview -->
                            <div class="relative max-w-[200px] w-full mx-auto aspect-[3/4] rounded-2xl overflow-hidden shadow-brand-soft border border-brand-primary/10">
                                <img src="{{ asset('images/events/level-up-your-iman-portrait.jpg') }}" alt="Level Up Your Iman Poster" class="w-full h-full object-cover" />
                            </div>
                            <div>
                                <h4 class="font-serif font-bold text-brand-primary text-body-lg">Bersama Koh Dennis Lim</h4>
                                <p class="text-caption text-brand-ink/65">{{ $activeEvent->speakers->first()->role_title ?? 'Pembina Spiritual' }}</p>
                            </div>
                        </div>

                        <div class="w-full space-y-3 mt-8">
                            <x-ui.glass-button 
                                variant="light"
                                :href="url('/event/'.$activeEvent->slug)" 
                                class="w-full"
                                id="event-cta-detail"
                            >
                                Pelajari Detail Acara
                            </x-ui.glass-button>
                            @if($activeEvent->ticket_url)
                                <x-ui.glass-button 
                                    variant="accent"
                                    :href="url('/event/'.$activeEvent->slug.'#ticket-section')" 
                                    class="w-full"
                                    id="event-cta-ticket"
                                >
                                    Pilih Tiket
                                </x-ui.glass-button>
                            @endif
                        </div>
                    </div>
                </x-ui.glass-card>
            </div>
        </section>
    @endif

    <!-- Section 4: Roadmap / Fase Berikutnya Section -->
    <section class="py-20 md:py-32 bg-mesh-glow text-brand-white relative overflow-hidden" aria-labelledby="roadmap-heading">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                <span class="text-caption font-semibold uppercase tracking-wider text-brand-accent block">Community Roadmap</span>
                <h2 id="roadmap-heading" class="font-serif text-h1 text-brand-gold font-bold tracking-tight">
                    Langkah Perjalanan Kita
                </h2>
                <p class="text-body text-brand-white/70">Struktur fase pengembangan spiritual growth Taqwa Movement secara berkelanjutan.</p>
            </div>

            <!-- Stepper Horizontal/Vertical Timeline Layout -->
            <div class="relative">
                <!-- Connective Timeline Line behind the stepper cards (hidden on mobile, visible on md) -->
                <div class="absolute top-1/2 left-0 w-full h-0.5 bg-brand-white/10 -translate-y-1/2 hidden md:block z-0"></div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
                    @foreach($phases as $index => $phase)
                        <x-ui.glass-card dark="true" hover="true" class="flex flex-col justify-between h-full relative p-8">
                            <!-- Numeric Stepper Node on Top -->
                            <div class="absolute -top-4 -left-4 w-10 h-10 rounded-full bg-brand-gold text-brand-navy flex items-center justify-center font-bold shadow-glow z-20">
                                {{ $index + 1 }}
                            </div>

                            <div class="mt-2">
                                <div class="flex items-center justify-between mb-6">
                                    <span class="font-serif text-h3 font-bold text-brand-gold">Fase 0{{ $index + 1 }}</span>
                                    @if($phase->status->value === 'active')
                                        <span class="bg-emerald-500/20 text-emerald-300 text-caption font-semibold px-3 py-1 rounded-full border border-emerald-500/30 uppercase tracking-wide">Aktif</span>
                                    @elseif($phase->status->value === 'completed')
                                        <span class="bg-brand-white/10 text-brand-white/60 text-caption font-semibold px-3 py-1 rounded-full border border-brand-white/25 uppercase tracking-wide">Selesai</span>
                                    @else
                                        <span class="bg-brand-accent/20 text-brand-accent text-caption font-semibold px-3 py-1 rounded-full border border-brand-accent/30 uppercase tracking-wide">Segera Hadir</span>
                                    @endif
                                </div>
                                <h3 class="font-serif text-body-lg font-bold text-brand-white mb-3">{{ $phase->title }}</h3>
                                <p class="text-caption text-brand-white/70 leading-relaxed">{{ $phase->description }}</p>
                            </div>

                            <!-- Progress indicator footer inside card -->
                            <div class="mt-8 pt-4 border-t border-brand-white/10">
                                <span class="text-caption text-brand-gold/80">{{ $phase->subtitle }}</span>
                            </div>
                        </x-ui.glass-card>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Section 5: Pengalaman Berbeda (Features & Testimonials) Section -->
    <section class="py-20 md:py-32 bg-transparent" aria-labelledby="experience-heading">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
                <span class="text-caption font-semibold uppercase tracking-wider text-brand-secondary block">Value & Testimoni</span>
                <h2 id="experience-heading" class="font-serif text-h1 text-brand-primary font-bold tracking-tight">
                    Pengalaman Tumbuh Berbeda
                </h2>
                <p class="text-body text-brand-ink/70">Apa yang membuat rangkaian acara dan interaksi di Taqwa Movement begitu istimewa.</p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
                @foreach($features as $feature)
                    <x-ui.glass-card hover="true" class="text-center space-y-4 border border-white/60 shadow-[0_20px_50px_rgba(80,46,136,0.06)] flex flex-col justify-between rounded-[2rem]">
                        <div class="w-14 h-14 bg-brand-primary/10 rounded-full flex items-center justify-center text-brand-primary mx-auto">
                            <!-- Render icons dynamically -->
                            @if($feature->icon === 'sparkles')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L11 3z"></path></svg>
                            @elseif($feature->icon === 'chat-bubble-left-right')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            @elseif($feature->icon === 'user-group')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @endif
                        </div>
                        <h3 class="font-serif text-body-lg font-bold text-brand-primary">{{ $feature->title }}</h3>
                        <p class="text-caption text-brand-ink/75 leading-relaxed">{{ $feature->description }}</p>
                    </x-ui.glass-card>
                @endforeach
            </div>

            <!-- Testimonials Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                @foreach($testimonials as $testi)
                    <x-ui.glass-card hover="true" class="border border-white/60 shadow-[0_20px_50px_rgba(80,46,136,0.06)] relative flex flex-col justify-between rounded-[2rem] space-y-6 overflow-hidden">
                        <span class="font-accent text-6xl text-brand-blush/30 absolute top-4 left-4 select-none">&ldquo;</span>
                        <p class="text-body text-brand-ink/80 leading-relaxed italic relative z-10">
                            {{ $testi->description }}
                        </p>
                        <div class="flex items-center gap-3 pt-4 border-t border-brand-blush-lt/10">
                            <div class="w-10 h-10 rounded-full bg-brand-blush-lt/30 border border-brand-blush-lt flex items-center justify-center font-bold text-brand-primary shrink-0">
                                {{ substr($testi->title, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-sans font-semibold text-brand-primary text-caption leading-none">{{ $testi->title }}</h4>
                                <span class="text-xs text-brand-ink/50">Peserta Alumni</span>
                            </div>
                        </div>
                    </x-ui.glass-card>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Section 6: Blog Preview Section -->
    <section class="py-20 md:py-32 bg-transparent" aria-labelledby="blog-heading">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row items-start md:items-end justify-between gap-6 mb-16">
                <div class="space-y-4 max-w-2xl">
                    <span class="text-caption font-semibold uppercase tracking-wider text-brand-secondary block">Refleksi Spiritual</span>
                    <h2 id="blog-heading" class="font-serif text-h1 text-brand-primary font-bold tracking-tight">
                        Artikel & Jurnal Pilihan
                    </h2>
                    <p class="text-body text-brand-ink/70">Tuangkan bisingnya pikiranmu melalui tulisan dan bacaan yang meneduhkan jiwa.</p>
                </div>
                <a 
                    href="/blog" 
                    class="inline-flex items-center gap-2 text-brand-primary hover:text-brand-secondary font-medium tracking-wide transition-colors"
                    id="blog-view-all"
                >
                    Lihat Semua Jurnal
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

            <!-- Blog Post Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                @foreach($latestPosts as $post)
                    <x-ui.glass-card hover="true" class="flex flex-col justify-between group hover:shadow-[0_20px_50px_rgba(80,46,136,0.12)] transition-all duration-300 border border-white/60 rounded-[2rem]">
                        <div>
                            <!-- Post Thumbnail Container -->
                            <div class="aspect-[16/10] relative overflow-hidden rounded-2xl shrink-0 shadow-sm">
                                @if($post->hasMedia('thumbnail'))
                                    <img src="{{ $post->getFirstMediaUrl('thumbnail', 'medium') }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                                @else
                                    <!-- Fallback dynamic gradient -->
                                    <div class="w-full h-full bg-gradient-to-br from-brand-primary/10 via-brand-secondary/5 to-brand-accent/10 flex items-center justify-center relative">
                                        <div class="absolute top-1/4 left-1/4 w-12 h-12 rounded-full bg-brand-accent/20 blur-md"></div>
                                        <div class="absolute bottom-1/4 right-1/4 w-16 h-16 rounded-full bg-brand-primary/10 blur-lg"></div>
                                        <span class="text-3xl filter opacity-30 select-none">✍️</span>
                                    </div>
                                @endif
                                <span class="absolute top-3 left-3 bg-brand-white/80 backdrop-blur-md text-brand-primary text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow-sm uppercase tracking-wider border border-white/50">
                                    {{ $post->category->name ?? 'Reflection' }}
                                </span>
                            </div>

                            <!-- Post Content -->
                            <div class="space-y-3 mt-4">
                                <span class="text-xs text-brand-ink/50 block font-medium">{{ $post->published_at->format('d M Y') }}</span>
                                <h3 class="font-serif font-bold text-brand-primary text-body-lg group-hover:text-brand-secondary transition-colors duration-200 line-clamp-2 min-h-[48px] leading-snug">
                                    <a href="/blog/{{ $post->slug }}">{{ $post->title }}</a>
                                </h3>
                                <p class="text-caption text-brand-ink/75 leading-relaxed line-clamp-3 min-h-[60px]">
                                    {{ $post->excerpt }}
                                </p>
                            </div>
                        </div>

                        <!-- Read Link -->
                        <div class="px-2 pb-2 pt-4 border-t border-brand-blush-lt/10 flex items-center justify-between text-caption font-semibold text-brand-primary mt-4">
                            <span>Baca Artikel</span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </x-ui.glass-card>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.app>
