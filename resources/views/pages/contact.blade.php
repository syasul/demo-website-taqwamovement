<x-layouts.app>
    @section('title', 'Hubungi Kami - Taqwa Movement')
    @section('meta_description', 'Ada pertanyaan mengenai event, kemitraan, atau kendala pendaftaran? Hubungi tim admin Taqwa Movement.')

    <!-- Hero Header Section -->
    <section class="py-20 bg-transparent relative overflow-hidden" aria-labelledby="contact-heading">
        <div class="max-w-5xl mx-auto px-6 text-center space-y-6 relative z-10">
            <h1 id="contact-heading" class="font-serif text-hero text-brand-primary leading-tight font-bold tracking-tight">
                Mari Bertumbuh Bersama
            </h1>
            <p class="text-body-lg text-brand-ink/75 max-w-2xl mx-auto leading-relaxed">
                Punya pertanyaan mengenai pendaftaran event, kendala teknis, atau rencana kolaborasi? Hubungi kami, tim admin kami siap membantumu.
            </p>
        </div>
    </section>

    <!-- Main Contact & Details Grid -->
    <section class="pb-24 bg-transparent" aria-label="Informasi kontak">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
            
            <!-- Left Column: Contact info details -->
            <div class="lg:col-span-5 space-y-8">
                <div class="space-y-4">
                    <h2 class="font-serif text-h2 text-brand-primary font-bold">Informasi Kontak</h2>
                    <p class="text-body text-brand-ink/70">Hubungi kami melalui saluran berikut atau isi formulir kontak yang tersedia.</p>
                </div>

                <ul class="space-y-6">
                    <li class="flex items-start gap-4">
                        <span class="p-3 bg-brand-primary/10 text-brand-primary rounded-xl shrink-0 mt-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </span>
                        <div>
                            <span class="text-xs text-brand-ink/50 block font-medium uppercase tracking-wider">Kantor Pusat</span>
                            <span class="text-body font-semibold text-brand-primary leading-relaxed block">{{ \App\Models\Setting::get('address', 'Kec. Lowokwaru, Kota Malang, Jawa Timur') }}</span>
                        </div>
                    </li>
                    <li class="flex items-start gap-4">
                        <span class="p-3 bg-brand-primary/10 text-brand-primary rounded-xl shrink-0 mt-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </span>
                        <div>
                            <span class="text-xs text-brand-ink/50 block font-medium uppercase tracking-wider">Email Admin</span>
                            <a href="mailto:{{ \App\Models\Setting::get('email', 'admin@taqwamovement.id') }}" class="text-body font-semibold text-brand-primary hover:text-brand-secondary transition-colors">{{ \App\Models\Setting::get('email', 'admin@taqwamovement.id') }}</a>
                        </div>
                    </li>
                    <li class="flex items-start gap-4">
                        <span class="p-3 bg-brand-primary/10 text-brand-primary rounded-xl shrink-0 mt-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </span>
                        <div>
                            <span class="text-xs text-brand-ink/50 block font-medium uppercase tracking-wider">WhatsApp Hotline</span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('phone', '+62 812-3456-7890')) }}" target="_blank" rel="noopener" class="text-body font-semibold text-brand-primary hover:text-brand-secondary transition-colors">{{ \App\Models\Setting::get('phone', '+62 812-3456-7890') }}</a>
                        </div>
                    </li>
                </ul>

                <!-- Map Frame Placeholder or Link -->
                <div class="rounded-3xl border border-slate-200 overflow-hidden shadow-brand-soft h-64 bg-slate-50 relative flex items-center justify-center">
                    <div class="absolute inset-0 bg-brand-blush-lt/15 opacity-60"></div>
                    <div class="text-center space-y-2 z-10 p-6">
                        <span class="text-xs text-brand-primary font-bold uppercase tracking-wider">Google Maps</span>
                        <h4 class="font-serif font-bold text-brand-primary text-body-lg">Taqwa Center Malang</h4>
                        <a 
                            href="{{ \App\Models\Setting::get('map_link', 'https://maps.google.com') }}" 
                            target="_blank" 
                            rel="noopener"
                            class="inline-flex items-center gap-1.5 px-6 py-2 rounded-full bg-brand-primary text-brand-white text-caption font-semibold shadow-md hover:bg-brand-secondary transition-all"
                        >
                            Petunjuk Arah
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column: Interactive Livewire Contact Form -->
            <div class="lg:col-span-7">
                @livewire('public.contact-form')
            </div>

        </div>
    </section>
</x-layouts.app>
