<x-layouts.app>
    @section('title', 'Tentang Kami - Taqwa Movement')
    @section('meta_description', 'Taqwa Movement adalah Spiritual Growth Platform berbasis Event & Community Ecosystem untuk generasi muda Muslim.')

    <!-- Hero Section -->
    <section class="py-24 md:py-32 bg-brand-navy text-brand-white relative overflow-hidden">
        <!-- Radial glow backdrops -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_30%,rgba(202,128,220,0.15),transparent_50%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_80%_70%,rgba(117,88,177,0.18),transparent_50%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(80,46,136,0.25),transparent_60%)]"></div>
        
        <!-- Subtle geometric matrix grid pattern -->
        <div class="absolute inset-0 opacity-[0.03] bg-[linear-gradient(to_right,#808080_1px,transparent_1px),linear-gradient(to_bottom,#808080_1px,transparent_1px)] bg-[size:32px_32px]"></div>

        <div class="max-w-5xl mx-auto px-6 text-center space-y-6 relative z-10">
            <h1 class="font-serif text-hero text-brand-gold leading-tight font-bold tracking-tight">
                Elevating faith.<br>Empowering life.
            </h1>
            <p class="text-body-lg text-brand-white/80 max-w-2xl mx-auto leading-relaxed">
                Taqwa Movement hadir sebagai ruang aman bagi generasi muda Muslim untuk mengurai kebisingan dunia, merapikan hati, dan melangkah mantap menemukan ketenangan batin serta arah hidup sejati.
            </p>
        </div>
    </section>

    <!-- Vision & Mission Section -->
    <section class="py-20 bg-brand-white border-t border-brand-blush-lt/10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
                <!-- Vision Column -->
                <div class="space-y-6">
                    <h2 class="font-serif text-h2 text-brand-primary font-bold">Visi Kami</h2>
                    <div class="w-12 h-1 bg-brand-accent rounded-full"></div>
                    <p class="text-body text-brand-ink/80 leading-relaxed">
                        Membangun ekosistem spiritual berkelanjutan yang mendampingi pemuda Muslim dalam mentransformasi keresahan batin menjadi energi pertumbuhan diri berbasis iman, ilmu, dan karya nyata.
                    </p>
                </div>

                <!-- Mission Column -->
                <div class="space-y-6">
                    <h2 class="font-serif text-h2 text-brand-primary font-bold">Misi Kami</h2>
                    <div class="w-12 h-1 bg-brand-accent rounded-full"></div>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3 text-body text-brand-ink/80">
                            <span class="p-1 bg-emerald-50 text-emerald-600 rounded-full shrink-0 border border-emerald-100 mt-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </span>
                            <span>Menyediakan event spiritual growth terstruktur yang memadukan refleksi iman logis dan interaksi hangat.</span>
                        </li>
                        <li class="flex items-start gap-3 text-body text-brand-ink/80">
                            <span class="p-1 bg-emerald-50 text-emerald-600 rounded-full shrink-0 border border-emerald-100 mt-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </span>
                            <span>Membangun ekosistem mentoring sebaya (peer-group) yang suportif, reflektif, dan penuh penerimaan.</span>
                        </li>
                        <li class="flex items-start gap-3 text-body text-brand-ink/80">
                            <span class="p-1 bg-emerald-50 text-emerald-600 rounded-full shrink-0 border border-emerald-100 mt-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </span>
                            <span>Mendorong kolaborasi aksi kebaikan sosial berkelanjutan untuk kebermanfaatan umat yang lebih luas.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values Section -->
    <section class="py-20 bg-brand-white border-t border-brand-blush-lt/10">
        <div class="max-w-7xl mx-auto px-6 text-center space-y-12">
            <div class="space-y-4">
                <h2 class="font-serif text-h2 text-brand-primary font-bold">Pilar Kunci</h2>
                <p class="text-body text-brand-ink/60 max-w-lg mx-auto">Tiga langkah fundamental yang mengawal proses perubahan diri yang berkelanjutan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Value 1 -->
                <x-ui.glass-card class="space-y-4 p-8 border border-brand-primary/10 bg-brand-white/40">
                    <div class="w-12 h-12 rounded-2xl bg-brand-primary/10 text-brand-primary flex items-center justify-center mx-auto text-h3 font-serif font-bold">1</div>
                    <h3 class="font-serif text-body-lg font-bold text-brand-primary">Reflect (Tafakur)</h3>
                    <p class="text-caption text-brand-ink/75 leading-relaxed">Mengambil jeda dari hiruk-pikuk kehidupan untuk jujur mengenali diri sendiri, meresapi kesalahan, dan menyadari kehadiran Allah SWT.</p>
                </x-ui.glass-card>

                <!-- Value 2 -->
                <x-ui.glass-card class="space-y-4 p-8 border border-brand-primary/10 bg-brand-white/40">
                    <div class="w-12 h-12 rounded-2xl bg-brand-primary/10 text-brand-primary flex items-center justify-center mx-auto text-h3 font-serif font-bold">2</div>
                    <h3 class="font-serif text-body-lg font-bold text-brand-primary">Connect (Ta'aruf)</h3>
                    <p class="text-caption text-brand-ink/75 leading-relaxed">Membangun tali silaturahim dengan lingkaran teman yang positif dan memiliki frekuensi tumbuh yang sama demi saling menguatkan.</p>
                </x-ui.glass-card>

                <!-- Value 3 -->
                <x-ui.glass-card class="space-y-4 p-8 border border-brand-primary/10 bg-brand-white/40">
                    <div class="w-12 h-12 rounded-2xl bg-brand-primary/10 text-brand-primary flex items-center justify-center mx-auto text-h3 font-serif font-bold">3</div>
                    <h3 class="font-serif text-body-lg font-bold text-brand-primary">Grow (Tazkiyah)</h3>
                    <p class="text-caption text-brand-ink/75 leading-relaxed">Melakukan perbaikan kualitas ibadah, akhlak, dan kepribadian demi mencapai kedewasaan spiritual dan kebermanfaatan sosial.</p>
                </x-ui.glass-card>
            </div>
        </div>
    </section>

    <!-- Stepper Roadmap Section -->
    <section class="py-20 bg-brand-white border-t border-brand-blush-lt/10">
        <div class="max-w-4xl mx-auto px-6 space-y-16">
            <div class="text-center space-y-4">
                <h2 class="font-serif text-h2 text-brand-primary font-bold">Tahapan Perjalanan</h2>
                <p class="text-body text-brand-ink/60">Tiga fase program terintegrasi yang kami susun untuk mendukung spiritualitasmu.</p>
            </div>

            <!-- Vertical Stepper Roadmap -->
            <div class="relative space-y-12">
                <!-- Connective Center Line -->
                <div class="absolute left-6 top-4 bottom-4 w-0.5 bg-brand-primary/20"></div>

                <!-- Phase 1 -->
                <div class="relative flex gap-6 items-start">
                    <div class="w-12 h-12 rounded-full bg-brand-primary text-brand-white flex items-center justify-center font-serif text-body-lg font-bold shadow-brand-soft shrink-0 relative z-10">I</div>
                    <div class="space-y-2">
                        <h3 class="font-serif text-body-lg font-bold text-brand-primary">Fase 1: Spiritual Awakening</h3>
                        <p class="text-body text-brand-ink/80 leading-relaxed">Fase awal yang berfokus pada pengenalan diri, merapikan hati, membangun tawakal, dan mengurai kecemasan masa depan.</p>
                    </div>
                </div>

                <!-- Phase 2 -->
                <div class="relative flex gap-6 items-start">
                    <div class="w-12 h-12 rounded-full bg-brand-primary/10 text-brand-primary border border-brand-primary/20 flex items-center justify-center font-serif text-body-lg font-bold shrink-0 relative z-10">II</div>
                    <div class="space-y-2">
                        <h3 class="font-serif text-body-lg font-bold text-brand-primary">Fase 2: Purposeful Living</h3>
                        <p class="text-body text-brand-ink/80 leading-relaxed">Menerjemahkan ketenangan batin menjadi aksi nyata, menemukan arah kontribusi, dan menetapkan prioritas hidup Islami.</p>
                    </div>
                </div>

                <!-- Phase 3 -->
                <div class="relative flex gap-6 items-start">
                    <div class="w-12 h-12 rounded-full bg-brand-primary/10 text-brand-primary border border-brand-primary/20 flex items-center justify-center font-serif text-body-lg font-bold shrink-0 relative z-10">III</div>
                    <div class="space-y-2">
                        <h3 class="font-serif text-body-lg font-bold text-brand-primary">Fase 3: Faithful Ecosystem</h3>
                        <p class="text-body text-brand-ink/80 leading-relaxed">Membangun ekosistem berkelanjutan dan kolaborasi jangka panjang antar pemuda Muslim untuk perubahan sosial yang diridhai.</p>
                    </div>
                </div>
        </div>
    </section>

    <!-- Active Event Section -->
    @if(isset($activeEvent) && $activeEvent)
    <section class="py-20 bg-brand-navy text-brand-white border-t border-brand-blush-lt/10">
        <div class="max-w-5xl mx-auto px-6 space-y-12">
            <div class="text-center space-y-4">
                <span class="bg-brand-primary/30 text-brand-accent font-sans text-caption font-semibold px-4 py-1.5 rounded-full border border-brand-accent/20 uppercase tracking-wider">
                    Event Terdekat
                </span>
                <h2 class="font-serif text-h2 text-brand-gold font-bold">Ayo Bergabung Bersama Kami</h2>
                <p class="text-body text-brand-white/70 max-w-lg mx-auto">Mulailah langkah perubahan spiritualmu dengan mengikuti program event aktif kami.</p>
            </div>

            <!-- Event Card (Glassmorphic) -->
            <x-ui.glass-card class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch border border-brand-white/10 bg-brand-white/5 backdrop-blur-md text-brand-white p-8">
                <div class="lg:col-span-8 flex flex-col justify-between space-y-6">
                    <div>
                        <!-- Phase Badge & Event Title -->
                        <div class="flex items-center gap-3 mb-4">
                            <span class="bg-brand-accent/20 text-brand-accent font-sans text-caption font-semibold px-3 py-1 rounded-full border border-brand-accent/30">
                                {{ $activeEvent->phase->title ?? 'Fase 1' }}
                            </span>
                            <span class="text-caption text-brand-white/60">{{ $activeEvent->date->format('d M Y') }}</span>
                        </div>
                        <h3 class="font-serif text-h3 text-brand-gold font-bold mb-4">{{ $activeEvent->title }}</h3>
                        <p class="text-body text-brand-white/80 italic">"{{ $activeEvent->tagline }}"</p>
                    </div>

                    <!-- Technical Info Bar -->
                    <div class="pt-6 border-t border-brand-white/10 grid grid-cols-1 sm:grid-cols-3 gap-4 text-caption text-brand-white/70">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>{{ Str::limit($activeEvent->location, 25) }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ $activeEvent->sessions->count() }} Sesi Reflektif</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span>{{ $activeEvent->speakers->pluck('name')->join(', ') }}</span>
                        </div>
                    </div>
                </div>

                <!-- CTA Panel & Poster -->
                <div class="lg:col-span-4 bg-brand-white/5 border border-brand-white/10 p-6 rounded-2xl flex flex-col justify-between items-center text-center backdrop-blur-sm">
                    <div class="w-full space-y-4">
                        <div class="relative max-w-[150px] w-full mx-auto aspect-[3/4] rounded-xl overflow-hidden shadow-glow border border-brand-white/10">
                            <img src="{{ asset('images/events/level-up-your-iman-portrait.jpg') }}" alt="Level Up Your Iman Poster" class="w-full h-full object-cover" />
                        </div>
                        <div>
                            <h4 class="font-serif font-bold text-brand-gold text-body-lg">Bersama {{ $activeEvent->speakers->first()->name ?? 'Koh Dennis Lim' }}</h4>
                            <p class="text-caption text-brand-white/60">{{ $activeEvent->speakers->first()->role_title ?? 'Pembina Spiritual' }}</p>
                        </div>
                    </div>

                    <div class="w-full mt-6">
                        <x-ui.glass-button 
                            variant="light"
                            href="/event/{{ $activeEvent->slug }}" 
                            class="w-full"
                        >
                            Detail Event
                        </x-ui.glass-button>
                    </div>
                </div>
            </x-ui.glass-card>
        </div>
    </section>
    @endif
</x-layouts.app>
