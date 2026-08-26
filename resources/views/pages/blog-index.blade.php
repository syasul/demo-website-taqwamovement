<x-layouts.app>
    @section('title', 'Jurnal Refleksi - Taqwa Movement')
    @section('meta_description', 'Kumpulan tulisan, renungan batin, dan kajian spiritual growth terkurasi dari tim Taqwa Movement.')

    <!-- Hero Header Section -->
    <section class="py-20 bg-transparent relative overflow-hidden" aria-labelledby="blog-heading">
        <div class="max-w-5xl mx-auto px-6 text-center space-y-6 relative z-10">
            <h1 id="blog-heading" class="font-serif text-hero text-brand-primary leading-tight font-bold tracking-tight">
                Jurnal Refleksi
            </h1>
            <p class="text-body-lg text-brand-ink/75 max-w-2xl mx-auto leading-relaxed">
                Tulisan, renungan, dan catatan bimbingan untuk mendampingi langkahmu mengurai kebisingan batin dan menemukan kedamaian sejati.
            </p>
        </div>
    </section>

    <!-- Interactive Search Content -->
    <section class="pb-24 bg-transparent" aria-label="Daftar tulisan jurnal">
        <div class="max-w-7xl mx-auto px-6">
            @livewire('public.blog-search')
        </div>
    </section>
</x-layouts.app>
