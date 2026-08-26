<div>
    <!-- Tab Headers Nav -->
    <div class="border-b border-slate-200 mb-8">
        <nav class="flex gap-6 -mb-px" aria-label="Tabs">
            <button 
                wire:click="setTab('editor')" 
                type="button"
                :class="'{{ $activeTab }}' === 'editor' ? 'border-brand-primary text-brand-primary' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                class="py-4 px-1 border-b-2 font-medium text-caption focus:outline-none transition-all"
            >
                Tulis Artikel
            </button>
            <button 
                wire:click="setTab('seo')" 
                type="button"
                :class="'{{ $activeTab }}' === 'seo' ? 'border-brand-primary text-brand-primary' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                class="py-4 px-1 border-b-2 font-medium text-caption focus:outline-none transition-all"
            >
                SEO & Metadata
            </button>
        </nav>
    </div>

    <!-- Form Content Container -->
    <form wire:submit.prevent="save" class="space-y-8">
        
        <!-- TAB 1: ARTICLE EDITOR -->
        <div x-show="'{{ $activeTab }}' === 'editor'" class="space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <!-- Title Field -->
                <div class="md:col-span-8 space-y-1">
                    <label for="post-title" class="text-caption font-semibold text-brand-ink/80 block">Judul Artikel</label>
                    <input 
                        id="post-title"
                        wire:model="title" 
                        type="text" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                        placeholder="e.g. Tawakal: Obat Anti-Overthinking Masa Depan"
                    />
                    @error('title') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Category Field -->
                <div class="md:col-span-4 space-y-1">
                    <label for="post-category" class="text-caption font-semibold text-brand-ink/80 block">Kategori</label>
                    <select 
                        id="post-category"
                        wire:model.defer="category_id" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body bg-brand-white"
                    >
                        <option value="">Pilih Kategori...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Slug Field (Editable Manual) -->
            <div class="space-y-1">
                <label for="post-slug" class="text-caption font-semibold text-brand-ink/80 block">Slug URL</label>
                <input 
                    id="post-slug"
                    wire:model.defer="slug" 
                    type="text" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body bg-slate-50"
                    placeholder="e.g. tawakal-obat-anti-overthinking-masa-depan"
                />
                @error('slug') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Content Area (HTML/Markdown Input) -->
            <div class="space-y-1">
                <label for="post-content" class="text-caption font-semibold text-brand-ink/80 block">Isi Konten Artikel (Rich HTML/Markdown)</label>
                <textarea 
                    id="post-content"
                    wire:model.defer="content" 
                    rows="12"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body font-mono text-xs"
                    placeholder="Masukkan tag <p>, <h3>, <blockquote> dll. untuk memformat tulisan..."
                ></textarea>
                @error('content') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Excerpt Area -->
            <div class="space-y-1">
                <label for="post-excerpt" class="text-caption font-semibold text-brand-ink/80 block">Ringkasan / Excerpt (Opsional)</label>
                <textarea 
                    id="post-excerpt"
                    wire:model.defer="excerpt" 
                    rows="3"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    placeholder="Biarkan kosong untuk otomatis menyadur 160 karakter pertama dari konten artikel..."
                ></textarea>
                @error('excerpt') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Author Field -->
                <div class="space-y-1">
                    <label for="post-author" class="text-caption font-semibold text-brand-ink/80 block">Nama Penulis</label>
                    <input 
                        id="post-author"
                        wire:model.defer="author_name" 
                        type="text" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    />
                    @error('author_name') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Status Field -->
                <div class="space-y-1">
                    <label for="post-status" class="text-caption font-semibold text-brand-ink/80 block">Status Publikasi</label>
                    <select 
                        id="post-status"
                        wire:model.defer="status" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body bg-brand-white"
                    >
                        <option value="draft">Draft</option>
                        <option value="published">Terbitkan</option>
                    </select>
                    @error('status') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Published At Date picker (Scheduling) -->
                <div class="space-y-1">
                    <label for="post-published-at" class="text-caption font-semibold text-brand-ink/80 block">Penjadwalan Rilis (Opsional)</label>
                    <input 
                        id="post-published-at"
                        wire:model.defer="published_at" 
                        type="datetime-local" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    />
                    @error('published_at') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

        </div>

        <!-- TAB 2: SEO METADATA -->
        <div x-show="'{{ $activeTab }}' === 'seo'" class="space-y-6">
            <h3 class="font-serif text-body-lg font-bold text-brand-primary border-b border-slate-100 pb-3">Optimasi Search Engine (SEO)</h3>
            
            <div class="space-y-6">
                <!-- Meta Title -->
                <div class="space-y-1">
                    <label for="seo-meta-title" class="text-caption font-semibold text-brand-ink/80 block">SEO Meta Title</label>
                    <input 
                        id="seo-meta-title"
                        wire:model.defer="meta_title" 
                        type="text" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                        placeholder="Biarkan kosong untuk menggunakan Judul Artikel"
                    />
                </div>

                <!-- Meta Description -->
                <div class="space-y-1">
                    <label for="seo-meta-description" class="text-caption font-semibold text-brand-ink/80 block">SEO Meta Description</label>
                    <textarea 
                        id="seo-meta-description"
                        wire:model.defer="meta_description" 
                        rows="4"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                        placeholder="Masukkan ringkasan singkat artikel untuk preview Google..."
                    ></textarea>
                </div>
            </div>
        </div>

        <!-- Sticky Actions Footer -->
        <div class="pt-6 border-t border-slate-200 flex justify-end gap-3">
            <a 
                href="/admin/posts" 
                class="px-6 py-3 rounded-full border border-slate-200 hover:bg-slate-50 text-caption font-semibold transition-all"
            >
                Batal
            </a>
            <button 
                type="submit" 
                class="px-8 py-3 rounded-full bg-brand-primary hover:bg-brand-secondary text-brand-white text-caption font-bold shadow-brand-soft hover:shadow-[0_12px_35px_rgba(80,46,136,0.15)] transition-all duration-300"
            >
                Simpan Artikel
            </button>
        </div>

    </form>
</div>
