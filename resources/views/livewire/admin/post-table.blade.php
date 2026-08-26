<div x-data="{ selected: [], singleDeleteUrl: '' }">
    <!-- Table Filters Header -->
    <div class="bg-brand-white border border-slate-200 p-5 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] mb-6 flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto flex-grow items-center">
            <!-- Bulk Delete Action -->
            <button 
                x-show="selected.length > 0"
                @click="$dispatch('open-modal', 'bulk-delete-confirm-modal')"
                type="button" 
                class="inline-flex items-center justify-center px-4 py-2.5 rounded-full text-brand-white bg-red-600 hover:bg-red-700 font-medium tracking-wide text-caption shadow-brand-soft focus:outline-none shrink-0"
                style="display: none;"
            >
                Hapus Terpilih (<span x-text="selected.length"></span>)
            </button>

            <!-- Search bar -->
            <div class="relative w-full md:w-72">
                <input 
                    wire:model.live.debounce.300ms="search" 
                    type="text" 
                    placeholder="Cari judul artikel..." 
                    class="w-full pl-10 pr-4 py-2 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-caption bg-brand-white"
                />
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
            </div>

            <!-- Category selector -->
            <select wire:model.live="categoryFilter" class="px-4 py-2 rounded-lg border border-slate-200 text-caption bg-brand-white focus:border-brand-primary">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>

            <!-- Status selector -->
            <select wire:model.live="statusFilter" class="px-4 py-2 rounded-lg border border-slate-200 text-caption bg-brand-white focus:border-brand-primary">
                <option value="">Semua Status</option>
                <option value="draft">Draft</option>
                <option value="published">Diterbitkan</option>
            </select>
        </div>

        <a href="{{ route('admin.posts.create') }}" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2.5 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium tracking-wide text-caption shadow-brand-soft shrink-0">
            + Tulis Artikel
        </a>
    </div>

    <!-- Data Table Card -->
    <div class="bg-brand-white border border-slate-200 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" aria-label="Articles list">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-brand-ink/50 uppercase tracking-wider">
                        <th class="px-6 py-4 w-12 text-center">
                            <input 
                                type="checkbox" 
                                @change="let check = $el.checked; selected = check ? [@foreach($posts as $post)'{{ $post->id }}',@endforeach] : []"
                                :checked="selected.length === {{ count($posts) }} && {{ count($posts) }} > 0"
                                class="rounded text-brand-primary focus:ring-brand-accent w-4 h-4 border-slate-200 cursor-pointer"
                            />
                        </th>
                        <th class="px-6 py-4">Judul Artikel</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Penulis</th>
                        <th class="px-6 py-4 text-center">Tanggal Rilis</th>
                        <th class="px-6 py-4 text-center">Views</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 w-20 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-body text-brand-ink/80">
                    @forelse($posts as $post)
                        <tr class="hover:bg-slate-50/50 transition-colors" :class="selected.includes('{{ $post->id }}') ? 'bg-brand-primary/[0.01]' : ''">
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <input 
                                    type="checkbox" 
                                    value="{{ $post->id }}" 
                                    x-model="selected"
                                    class="rounded text-brand-primary focus:ring-brand-accent w-4 h-4 border-slate-200 cursor-pointer"
                                />
                            </td>
                            <td class="px-6 py-4 font-semibold text-brand-primary">
                                {{ $post->title }}
                            </td>
                            <td class="px-6 py-4 text-caption text-brand-ink/65 whitespace-nowrap">
                                {{ $post->category->name ?? 'Uncategorized' }}
                            </td>
                            <td class="px-6 py-4 text-caption text-brand-ink/65 whitespace-nowrap">
                                {{ $post->author_name }}
                            </td>
                            <td class="px-6 py-4 text-center text-caption text-brand-ink/65 whitespace-nowrap">
                                {{ $post->published_at ? $post->published_at->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-slate-700 whitespace-nowrap">
                                {{ $post->views_count }}
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                @if($post->status->value === 'published')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border bg-emerald-50 text-emerald-700 border-emerald-200">Diterbitkan</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border bg-slate-100 text-slate-700 border-slate-200">Draft</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                    <button 
                                        @click="open = !open" 
                                        @click.away="open = false" 
                                        type="button" 
                                        class="p-2 hover:bg-slate-100 rounded-full transition-colors text-brand-ink/50 hover:text-brand-ink focus:outline-none"
                                    >
                                        <svg class="w-4 h-4 mx-auto" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                    </button>
                                    <div 
                                        x-show="open" 
                                        x-transition 
                                        class="absolute right-0 mt-1 w-32 rounded-xl bg-white border border-slate-200 shadow-lg py-1 z-30 text-left text-caption font-semibold"
                                        style="display: none;"
                                    >
                                        <a href="{{ route('admin.posts.edit', $post->id) }}" class="block px-4 py-2 text-brand-primary hover:bg-slate-50 transition-colors">
                                            Edit
                                        </a>
                                        <button 
                                            @click="singleDeleteUrl = '{{ route('admin.posts.destroy', $post->id) }}'; $dispatch('open-modal', 'single-delete-confirm-modal')"
                                            type="button" 
                                            class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition-colors"
                                        >
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-caption text-brand-ink/50 italic">
                                Belum ada artikel yang diterbitkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
            <div class="p-6 border-t border-slate-100 bg-slate-50/50">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
    <!-- Bulk Delete Confirmation Modal -->
    <x-ui.modal id="bulk-delete-confirm-modal" title="Konfirmasi Hapus Terpilih">
        <div class="space-y-6">
            <p class="text-body text-brand-ink/75">
                Apakah Anda yakin ingin menghapus <span class="font-bold text-red-600" x-text="selected.length"></span> artikel terpilih? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button 
                    @click="$dispatch('close-modal', 'bulk-delete-confirm-modal')" 
                    type="button" 
                    class="px-5 py-2.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-caption font-medium transition-all"
                >
                    Batal
                </button>
                <button 
                    @click="$wire.deleteSelected(selected).then(() => { selected = []; $dispatch('close-modal', 'bulk-delete-confirm-modal'); })"
                    type="button" 
                    class="px-5 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-brand-white text-caption font-semibold transition-all shadow-md"
                >
                    Hapus Permanen
                </button>
            </div>
        </div>
    </x-ui.modal>

    <!-- Single Delete Confirmation Modal -->
    <x-ui.modal id="single-delete-confirm-modal" title="Konfirmasi Hapus Artikel">
        <form method="POST" :action="singleDeleteUrl">
            @csrf
            @method('DELETE')
            <div class="space-y-6">
                <p class="text-body text-brand-ink/75">
                    Apakah Anda yakin ingin menghapus artikel ini? Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button 
                        @click="$dispatch('close-modal', 'single-delete-confirm-modal')" 
                        type="button" 
                        class="px-5 py-2.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-caption font-medium transition-all"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-brand-white text-caption font-semibold transition-all shadow-md"
                    >
                        Hapus Permanen
                    </button>
                </div>
            </div>
        </form>
    </x-ui.modal>
</div>
