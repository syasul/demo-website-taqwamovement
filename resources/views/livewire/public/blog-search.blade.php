<div class="space-y-12">
    <!-- Filters & Search Bar Section -->
    <div class="glass-card p-4 md:py-3 md:px-6 rounded-[2rem] border border-white/60 shadow-[0_20px_50px_rgba(80,46,136,0.06)] grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
        
        <!-- Category Filter Pills -->
        <div class="md:col-span-8 flex flex-wrap items-center gap-2" aria-label="Categories filter">
            <button 
                wire:click="selectCategory('')" 
                type="button"
                class="px-4 py-1.5 rounded-full text-caption font-semibold transition-all duration-300 {{ empty($selectedCategory) ? 'bg-brand-primary text-brand-white shadow-brand-soft' : 'bg-white/50 text-brand-ink/75 border border-white/80 hover:bg-white/80 hover:border-brand-primary/20' }}"
            >
                Semua Jurnal
            </button>
            @foreach($categories as $category)
                <button 
                    wire:click="selectCategory('{{ $category->slug }}')" 
                    type="button"
                    class="px-4 py-1.5 rounded-full text-caption font-semibold transition-all duration-300 {{ $selectedCategory === $category->slug ? 'bg-brand-primary text-brand-white shadow-brand-soft' : 'bg-white/50 text-brand-ink/75 border border-white/80 hover:bg-white/80 hover:border-brand-primary/20' }}"
                >
                    {{ $category->name }}
                </button>
            @endforeach
        </div>

        <!-- Search Input Bar -->
        <div class="md:col-span-4 relative">
            <label for="blog-search-input" class="sr-only">Cari jurnal...</label>
            <input 
                id="blog-search-input"
                wire:model.live.debounce.300ms="search" 
                type="text" 
                placeholder="Cari jurnal..." 
                class="w-full pl-11 pr-4 py-2 rounded-full border border-white/80 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/50 text-body bg-white/50 focus:bg-white/90 text-brand-ink placeholder-brand-ink/40 transition-all duration-300 shadow-sm"
            />
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-brand-ink/40">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            @if(!empty($search))
                <button 
                    wire:click="$set('search', '')" 
                    type="button"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-brand-ink/40 hover:text-brand-primary p-0.5 rounded-full"
                    aria-label="Hapus pencarian"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            @endif
        </div>
    </div>

    <!-- Active Loading Indicator -->
    <div wire:loading.delay class="w-full text-center py-4 text-brand-ink/50 text-caption font-medium animate-pulse">
        Sedang memuat artikel...
    </div>

    <!-- Posts Grid Section -->
    <div 
        wire:loading.class="opacity-60 transition-opacity duration-300"
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8"
        id="blog-posts-grid"
    >
        @forelse($posts as $post)
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
                            {{ $post->category->name ?? 'Uncategorized' }}
                        </span>
                    </div>

                    <!-- Post Info Body -->
                    <div class="space-y-3 mt-4">
                        <span class="text-xs text-brand-ink/50 block font-medium">{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                        <h3 class="font-serif font-bold text-brand-primary text-body-lg group-hover:text-brand-secondary transition-colors duration-200 line-clamp-2 min-h-[48px] leading-snug">
                            <a href="/blog/{{ $post->slug }}">{{ $post->title }}</a>
                        </h3>
                        <p class="text-caption text-brand-ink/75 leading-relaxed line-clamp-3 min-h-[60px]">
                            {{ $post->excerpt }}
                        </p>
                    </div>
                </div>

                <!-- Footer Baca Artikel Link -->
                <div class="px-2 pb-2 pt-4 border-t border-brand-blush-lt/10 flex items-center justify-between text-caption font-semibold text-brand-primary mt-4">
                    <span>Baca Artikel</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </x-ui.glass-card>
        @empty
            <!-- Styled Empty State -->
            <div class="col-span-full py-16 text-center space-y-4">
                <span class="w-16 h-16 bg-brand-primary/5 text-brand-primary rounded-full flex items-center justify-center mx-auto border border-brand-blush-lt/20 text-h3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </span>
                <div class="space-y-1">
                    <h4 class="font-serif text-body-lg font-bold text-brand-primary">Jurnal Tidak Ditemukan</h4>
                    <p class="text-caption text-brand-ink/60">Tidak ada artikel yang cocok dengan pencarian atau kategori Anda saat ini.</p>
                </div>
                <button 
                    wire:click="$set('search', ''); wire:click='selectCategory(\'\')'" 
                    type="button"
                    class="inline-flex items-center gap-1.5 text-caption font-semibold text-brand-primary hover:text-brand-secondary transition-colors"
                >
                    Reset Filter Pencarian
                </button>
            </div>
        @endforelse
    </div>

    <!-- Custom Pagination Section -->
    @if($posts->hasPages())
        <div class="pt-8 border-t border-brand-blush-lt/15">
            {{ $posts->links() }}
        </div>
    @endif
</div>
