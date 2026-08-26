<x-layouts.app>
    @section('title', 'Design System Preview - Taqwa Movement')

    <section class="relative bg-mesh-glow py-24 md:py-36 min-h-screen text-brand-white">
        <div class="max-w-7xl mx-auto px-6 relative z-10 space-y-16">
            
            <!-- Page Title -->
            <div class="space-y-4">
                <span class="text-xs text-brand-accent uppercase font-bold tracking-wider">Styleguide</span>
                <h1 class="font-serif text-h1 text-brand-gold font-bold">Glassmorphism Design System</h1>
                <p class="text-brand-white/70 max-w-2xl text-body-lg">
                    Preview token warna resmi baru, komponen kartu kaca translucent, tombol pendar (glow), input kaca, dan modular overlays.
                </p>
            </div>

            <!-- Color Palette grid -->
            <div class="space-y-6">
                <h2 class="font-serif text-h2 text-brand-gold">1. Color Palette Tokens</h2>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <div class="p-6 rounded-2xl bg-brand-navy border border-brand-white/10 flex flex-col justify-end h-28">
                        <span class="font-semibold block text-caption">brand.navy</span>
                        <span class="text-xs text-brand-white/50">#0A0F1D</span>
                    </div>
                    <div class="p-6 rounded-2xl bg-brand-gold text-brand-navy flex flex-col justify-end h-28">
                        <span class="font-semibold block text-caption">brand.gold</span>
                        <span class="text-xs text-brand-navy/60">#C5A880</span>
                    </div>
                    <div class="p-6 rounded-2xl bg-brand-cream text-brand-navy flex flex-col justify-end h-28">
                        <span class="font-semibold block text-caption">brand.cream</span>
                        <span class="text-xs text-brand-navy/60">#F9F6F0</span>
                    </div>
                    <div class="p-6 rounded-2xl bg-brand-primary flex flex-col justify-end h-28">
                        <span class="font-semibold block text-caption">brand.primary</span>
                        <span class="text-xs text-brand-white/50">#502E88</span>
                    </div>
                    <div class="p-6 rounded-2xl bg-brand-accent flex flex-col justify-end h-28">
                        <span class="font-semibold block text-caption">brand.accent</span>
                        <span class="text-xs text-brand-white/50">#CA80DC</span>
                    </div>
                </div>
            </div>

            <!-- Glass Cards Section -->
            <div class="space-y-6">
                <h2 class="font-serif text-h2 text-brand-gold">2. Glass Cards (`<x-ui.glass-card>`)</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <x-ui.glass-card>
                        <h3 class="font-serif text-h3 text-brand-accent mb-2">Light Glass Card</h3>
                        <p class="text-brand-white/80 text-caption leading-relaxed">
                            Kartu standar yang memantulkan warna mesh gradient di belakang secara halus.
                        </p>
                    </x-ui.glass-card>

                    <x-ui.glass-card dark="true">
                        <h3 class="font-serif text-h3 text-brand-gold mb-2">Dark Glass Card</h3>
                        <p class="text-brand-white/75 text-caption leading-relaxed">
                            Dilengkapi overlay gelap (opacity 65%) untuk mengutamakan keterbacaan teks kontras tinggi (AA-compliant).
                        </p>
                    </x-ui.glass-card>

                    <x-ui.glass-card hover="true">
                        <h3 class="font-serif text-h3 text-brand-accent mb-2">Hover Glass Card</h3>
                        <p class="text-brand-white/80 text-caption leading-relaxed">
                            Menambahkan efek transisi bergeser ke atas (-4px) dengan glow shadow pendar keemasan pada saat hover.
                        </p>
                    </x-ui.glass-card>
                </div>
            </div>

            <!-- Glass Buttons Section -->
            <div class="space-y-6">
                <h2 class="font-serif text-h2 text-brand-gold">3. Glass Buttons (`<x-ui.glass-button>`)</h2>
                <div class="flex flex-wrap gap-4 items-center">
                    <x-ui.glass-button variant="light">Light Variant</x-ui.glass-button>
                    <x-ui.glass-button variant="dark">Dark Variant</x-ui.glass-button>
                    <x-ui.glass-button variant="glow">Glow Variant</x-ui.glass-button>
                    <x-ui.glass-button variant="accent">Accent Variant</x-ui.glass-button>
                </div>
            </div>

            <!-- Glass Inputs Section -->
            <div class="space-y-6 max-w-md">
                <h2 class="font-serif text-h2 text-brand-gold">4. Glass Inputs</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-caption text-brand-white/70 mb-2 font-medium">Text Field</label>
                        <input type="text" placeholder="Masukkan nama..." class="glass-input w-full px-5 py-3 rounded-full text-caption" />
                    </div>
                </div>
            </div>

            <!-- Glass Modals Trigger Section -->
            <div class="space-y-6" x-data="{}">
                <h2 class="font-serif text-h2 text-brand-gold">5. Glass Modals (`<x-ui.glass-modal>`)</h2>
                <x-ui.glass-button variant="accent" @click="$dispatch('open-modal', 'demo-modal')">
                    Buka Demo Modal
                </x-ui.glass-button>

                <x-ui.glass-modal id="demo-modal" title="Pesan Kedamaian Batin">
                    <p class="text-brand-white/80 leading-relaxed mb-6">
                        Ini adalah modal dengan transisi pudar glassmorphism yang tenang. Sesuai dengan filosofi Taqwa Movement untuk memberikan ruang aman bagi jiwa.
                    </p>
                    <div class="flex justify-end">
                        <x-ui.glass-button variant="light" @click="$dispatch('close-modal', 'demo-modal')">
                            Tutup
                        </x-ui.glass-button>
                    </div>
                </x-ui.glass-modal>
            </div>

        </div>
    </section>
</x-layouts.app>
