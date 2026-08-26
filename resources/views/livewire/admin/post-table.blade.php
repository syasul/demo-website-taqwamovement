<div>
    <!-- Table Filters Header -->
    <div class="bg-brand-white border border-slate-200 p-5 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] mb-6 flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto flex-grow">
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

        <a href="{{ route('admin.posts.create') }}" class="w-full md:w-auto inline-flex items-center justify-center px-4 py-2.5 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium tracking-wide text-caption shadow-brand-soft">
            + Tulis Artikel
        </a>
    </div>

    <!-- Data Table Card -->
    <div class="bg-brand-white border border-slate-200 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" aria-label="Articles list">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-brand-ink/50 uppercase tracking-wider">
                        <th class="px-6 py-4">Judul Artikel</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Penulis</th>
                        <th class="px-6 py-4 text-center">Tanggal Rilis</th>
                        <th class="px-6 py-4 text-center">Views</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 w-36 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-body text-brand-ink/80">
                    @forelse($posts as $post)
                        <tr class="hover:bg-slate-50/50 transition-colors">
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
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="p-1.5 text-brand-primary hover:bg-brand-primary/5 rounded-lg font-semibold text-caption transition-colors">Edit</a>
                                    
                                    <form method="POST" action="{{ route('admin.posts.destroy', $post->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg font-semibold text-caption transition-colors">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-caption text-brand-ink/50 italic">
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
</div>
