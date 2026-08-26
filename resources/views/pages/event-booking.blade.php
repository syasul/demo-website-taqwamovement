<x-layouts.app>
    @section('title', 'Pendaftaran Tiket - ' . $event->title . ' - Taqwa Movement')
    @section('meta_description', 'Registrasi pendaftaran tiket event ' . $event->title)

    <!-- Breadcrumb section -->
    <div class="bg-brand-blush-lt/10 border-b border-brand-blush-lt/15 py-4 shrink-0">
        <div class="max-w-7xl mx-auto px-6 flex items-center gap-2 text-caption text-brand-ink/50" aria-label="Breadcrumb">
            <a href="/" class="hover:text-brand-primary transition-colors">Home</a>
            <span>&bull;</span>
            <a href="/event/{{ $event->slug }}" class="hover:text-brand-primary transition-colors">Event</a>
            <span>&bull;</span>
            <span class="text-brand-primary font-medium truncate">Pendaftaran Tiket</span>
        </div>
    </div>

    <!-- Booking Header Section -->
    <section class="py-12 bg-brand-navy text-brand-white relative overflow-hidden" aria-labelledby="booking-hero-title">
        <div class="max-w-5xl mx-auto px-6 text-center space-y-6 relative z-10">
            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-brand-primary/20 text-brand-accent font-sans text-caption font-semibold uppercase tracking-wider border border-brand-accent/20">
                Pilih Tiket & Registrasi
            </span>
            <h1 id="booking-hero-title" class="font-serif text-h2 text-brand-gold leading-tight font-bold tracking-tight">
                {{ $event->title }}
            </h1>
            <p class="text-body text-brand-white/80 max-w-xl mx-auto leading-relaxed">
                Silakan pilih kuota tiket dan lengkapi rincian informasi data diri Anda untuk mengamankan tempat di program spiritual growth ini.
            </p>

            <!-- Stepper Progress Tracker -->
            <div class="max-w-xl mx-auto pt-6">
                <div class="flex items-center justify-between relative">
                    <!-- Progress line background -->
                    <div class="absolute left-4 right-4 top-4 -translate-y-1/2 h-0.5 bg-brand-white/10 z-0"></div>

                    <!-- Step 1: Active -->
                    <div class="flex flex-col items-center gap-2 relative z-10">
                        <div class="w-8 h-8 rounded-full bg-brand-accent text-brand-navy font-bold flex items-center justify-center text-xs shadow-[0_0_15px_rgba(202,128,220,0.5)]">
                            1
                        </div>
                        <span class="text-xs font-semibold text-brand-accent">Registrasi</span>
                    </div>

                    <!-- Step 2: Uncompleted -->
                    <div class="flex flex-col items-center gap-2 relative z-10">
                        <div class="w-8 h-8 rounded-full bg-brand-navy border border-brand-white/20 text-brand-white/60 font-semibold flex items-center justify-center text-xs">
                            2
                        </div>
                        <span class="text-xs text-brand-white/60 font-medium">Pembayaran</span>
                    </div>

                    <!-- Step 3: Uncompleted -->
                    <div class="flex flex-col items-center gap-2 relative z-10">
                        <div class="w-8 h-8 rounded-full bg-brand-navy border border-brand-white/20 text-brand-white/60 font-semibold flex items-center justify-center text-xs">
                            3
                        </div>
                        <span class="text-xs text-brand-white/60 font-medium">E-Tiket</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Registration Form Section -->
    <section class="py-16 md:py-24 bg-brand-white border-t border-brand-blush-lt/10" aria-label="Registration Form Container">
        <div class="max-w-7xl mx-auto px-6">
            @livewire('public.event-booking', ['event' => $event])
        </div>
    </section>
</x-layouts.app>
