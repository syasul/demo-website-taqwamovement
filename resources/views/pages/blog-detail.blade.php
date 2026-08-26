<x-layouts.app>
    @section('title', $post->title . ' - Taqwa Movement')
    @section('meta_description', strip_tags($post->excerpt))

    <!-- Breadcrumb section -->
    <div class="bg-brand-blush-lt/10 border-b border-brand-blush-lt/15 py-4 shrink-0">
        <div class="max-w-7xl mx-auto px-6 flex items-center gap-2 text-caption text-brand-ink/50" aria-label="Breadcrumb">
            <a href="/" class="hover:text-brand-primary transition-colors">Home</a>
            <span>&bull;</span>
            <a href="/blog" class="hover:text-brand-primary transition-colors">Blog</a>
            <span>&bull;</span>
            <span class="text-brand-primary font-medium truncate">{{ $post->title }}</span>
        </div>
    </div>

    <!-- Article Header -->
    <header class="py-16 md:py-24 bg-brand-white relative overflow-hidden" aria-labelledby="article-title">
        <div class="max-w-3xl mx-auto px-6 text-center space-y-6 relative z-10">
            <!-- Category Pill -->
            <a 
                href="/blog/kategori/{{ $post->category->slug }}" 
                class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-brand-primary/10 text-brand-primary font-sans text-caption font-semibold uppercase tracking-wider hover:bg-brand-primary/20 transition-colors"
                id="article-category-link"
            >
                {{ $post->category->name }}
            </a>
            
            <h1 id="article-title" class="font-serif text-h1 text-brand-primary leading-tight font-bold tracking-tight">
                {{ $post->title }}
            </h1>

            <!-- Author & Metadata -->
            <div class="flex items-center justify-center gap-3 text-caption text-brand-ink/65 pt-2">
                <div class="w-8 h-8 rounded-full bg-brand-blush-lt/40 flex items-center justify-center font-bold text-brand-primary text-xs uppercase shrink-0">
                    {{ substr($post->author_name, 0, 1) }}
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="font-semibold text-brand-primary">{{ $post->author_name }}</span>
                    <span>&bull;</span>
                    <span>{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                    <span>&bull;</span>
                    @php
                        // Estimate reading time: 200 words per minute
                        $wordCount = str_word_count(strip_tags($post->content));
                        $readingTime = max(1, ceil($wordCount / 200));
                    @endphp
                    <span>{{ $readingTime }} Menit Baca</span>
                    <span>&bull;</span>
                    <span>Dilihat {{ $post->views_count }} Kali</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Article Content -->
    <article class="pb-20 md:pb-32 bg-brand-white" aria-label="Jurnal detail content">
        <div class="max-w-3xl mx-auto px-6">
            
            <!-- Safe Rich Text Content -->
            <div class="prose prose-lg max-w-none text-body text-brand-ink/85 leading-relaxed space-y-6">
                {!! $post->content !!}
            </div>

            <!-- Social Share & Action Bar -->
            <div class="mt-16 pt-8 border-t border-brand-blush-lt/25 flex flex-col sm:flex-row items-center justify-between gap-6" x-data="{
                shareUrl: '{{ url()->current() }}',
                shareTitle: '{{ $post->title }}',
                copied: false,
                shareWeb() {
                    if (navigator.share) {
                        navigator.share({
                            title: this.shareTitle,
                            url: this.shareUrl
                        }).catch(console.error);
                    } else {
                        this.copyToClipboard();
                    }
                },
                copyToClipboard() {
                    navigator.clipboard.writeText(this.shareUrl);
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2000);
                }
            }">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-caption font-semibold text-brand-ink/50">Bagikan:</span>
                    <!-- WhatsApp Share -->
                    <a 
                        href="https://api.whatsapp.com/send?text={{ rawurlencode($post->title . ' - ' . url()->current()) }}" 
                        target="_blank" 
                        rel="noopener" 
                        class="px-4 py-2 rounded-full border border-brand-blush-lt/20 text-caption font-medium hover:bg-brand-primary/5 hover:border-brand-primary text-brand-primary transition-all duration-300 flex items-center gap-1.5"
                    >
                        WhatsApp
                    </a>
                    <!-- Copy Link -->
                    <button 
                        @click="copyToClipboard()"
                        type="button" 
                        class="px-4 py-2 rounded-full border border-brand-blush-lt/20 text-caption font-medium hover:bg-brand-primary/5 hover:border-brand-primary text-brand-primary transition-all duration-300 flex items-center gap-1.5 focus:outline-none"
                    >
                        <span x-text="copied ? 'Link Tersalin!' : 'Salin Link'"></span>
                    </button>
                    <!-- Web Share API Button (Mobile) -->
                    <button 
                        @click="shareWeb()"
                        type="button" 
                        class="px-4 py-2 rounded-full border border-brand-blush-lt/20 text-caption font-medium hover:bg-brand-primary/5 hover:border-brand-primary text-brand-primary transition-all duration-300 flex items-center gap-1.5 focus:outline-none"
                    >
                        Share
                    </button>
                </div>

                <a 
                    href="/blog" 
                    class="inline-flex items-center gap-1 text-caption font-semibold text-brand-primary hover:text-brand-secondary transition-colors"
                >
                    Kembali ke Blog
                </a>
            </div>

        </div>
    </article>

    <!-- Related Articles Section -->
    @if($relatedPosts->isNotEmpty())
        <section class="py-20 bg-slate-50 border-t border-slate-200" aria-labelledby="related-heading">
            <div class="max-w-7xl mx-auto px-6 space-y-12">
                <div class="text-center md:text-left space-y-2">
                    <span class="text-caption font-semibold uppercase tracking-wider text-brand-secondary block">Lanjutkan Membaca</span>
                    <h2 id="related-heading" class="font-serif text-h2 text-brand-primary font-bold">Jurnal Terkait</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedPosts as $related)
                        <article class="bg-brand-white border border-brand-blush-lt/20 rounded-2xl shadow-brand-soft overflow-hidden flex flex-col justify-between group hover:shadow-[0_12px_35px_rgba(80,46,136,0.06)] hover:-translate-y-1 transition-all duration-300">
                            <div>
                                <!-- Thumbnail -->
                                <div class="aspect-[4/3] bg-brand-blush-lt/20 relative overflow-hidden shrink-0 border-b border-brand-blush-lt/10">
                                    <div class="absolute inset-0 bg-brand-blush-lt/10"></div>
                                    <span class="absolute top-4 left-4 bg-brand-primary/95 text-brand-white text-xs font-bold px-3 py-1 rounded-full backdrop-blur-sm border border-brand-primary/10">
                                        {{ $related->category->name }}
                                    </span>
                                </div>

                                <!-- Body -->
                                <div class="p-6 space-y-3">
                                    <span class="text-xs text-brand-ink/50 block font-medium">{{ $related->published_at ? $related->published_at->format('d M Y') : $related->created_at->format('d M Y') }}</span>
                                    <h3 class="font-serif font-bold text-brand-primary text-body-lg group-hover:text-brand-secondary transition-colors duration-200">
                                        <a href="/blog/{{ $related->slug }}">{{ $related->title }}</a>
                                    </h3>
                                    <p class="text-caption text-brand-ink/75 leading-relaxed line-clamp-3">
                                        {{ $related->excerpt }}
                                    </p>
                                </div>
                            </div>

                            <!-- Footer link -->
                            <div class="px-6 pb-6 pt-4 border-t border-brand-blush-lt/10 flex items-center justify-between text-caption font-semibold text-brand-primary">
                                <span>Baca Artikel</span>
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- BlogPosting JSON-LD Schema -->
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@type": "BlogPosting",
      "headline": "{{ $post->title }}",
      "image": "{{ $post->thumbnail_media_id ? asset('storage/media/' . $post->thumbnail_media_id) : asset('/images/default-blog.jpg') }}",
      "datePublished": "{{ $post->published_at ? $post->published_at->toIso8601String() : $post->created_at->toIso8601String() }}",
      "dateModified": "{{ $post->updated_at->toIso8601String() }}",
      "author": {
        "@type": "Organization",
        "name": "{{ $post->author_name }}"
      },
      "description": "{{ strip_tags($post->excerpt) }}"
    }
    </script>
</x-layouts.app>
