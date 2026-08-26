<div x-data="{ selected: [] }">
    <!-- Page Actions Header -->
    <div class="mb-6 flex justify-between items-center">
        <p class="text-caption text-brand-ink/60">Kelola kategori untuk artikel blog Taqwa Movement.</p>
        <div class="flex items-center gap-3">
            <button 
                x-show="selected.length > 0"
                @click="$dispatch('open-modal', 'bulk-delete-confirm-modal')"
                type="button" 
                class="inline-flex items-center justify-center px-4 py-2.5 rounded-full text-brand-white bg-red-600 hover:bg-red-700 font-medium tracking-wide text-caption shadow-brand-soft hover:-translate-y-0.5 transition-all duration-300 focus:outline-none"
                style="display: none;"
            >
                Hapus Terpilih (<span x-text="selected.length"></span>)
            </button>
            <button 
                @click="$dispatch('open-modal', 'category-modal')" 
                wire:click="resetFields"
                type="button" 
                class="inline-flex items-center justify-center px-4 py-2.5 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium tracking-wide text-caption shadow-brand-soft transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-brand-accent/50"
                id="btn-add-category"
            >
                + Tambah Kategori
            </button>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-brand-white border border-slate-200 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" aria-label="Categories list">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-brand-ink/50 uppercase tracking-wider">
                        <th class="px-6 py-4 w-12 text-center">
                            <input 
                                type="checkbox" 
                                @change="let check = $el.checked; selected = check ? [@foreach($categories as $category)'{{ $category->id }}',@endforeach] : []"
                                :checked="selected.length === {{ count($categories) }} && {{ count($categories) }} > 0"
                                class="rounded text-brand-primary focus:ring-brand-accent w-4 h-4 border-slate-200 cursor-pointer"
                            />
                        </th>
                        <th class="px-6 py-4">Nama Kategori</th>
                        <th class="px-6 py-4">Slug</th>
                        <th class="px-6 py-4 text-center">Jumlah Artikel</th>
                        <th class="px-6 py-4 w-20 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-body text-brand-ink/80">
                    @forelse($categories as $index => $category)
                        <tr class="hover:bg-slate-50/50 transition-colors" :class="selected.includes('{{ $category->id }}') ? 'bg-brand-primary/[0.01]' : ''">
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <input 
                                    type="checkbox" 
                                    value="{{ $category->id }}" 
                                    x-model="selected"
                                    class="rounded text-brand-primary focus:ring-brand-accent w-4 h-4 border-slate-200 cursor-pointer"
                                />
                            </td>
                            <td class="px-6 py-4 font-semibold text-brand-primary">
                                {{ $category->name }}
                            </td>
                            <td class="px-6 py-4 text-caption text-brand-ink/65">
                                {{ $category->slug }}
                            </td>
                            <td class="px-6 py-4 text-center text-caption font-bold text-brand-primary">
                                {{ $category->posts()->count() }}
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
                                        <button wire:click="edit({{ $category->id }})" type="button" class="w-full text-left px-4 py-2 text-brand-primary hover:bg-slate-50 transition-colors">
                                            Edit
                                        </button>
                                        <button wire:click="confirmDelete({{ $category->id }})" type="button" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition-colors">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-caption text-brand-ink/50">
                                Belum ada kategori blog. Klik + Tambah Kategori untuk memulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Category CRUD Modal -->
    <x-ui.modal id="category-modal" :title="$isEdit ? 'Ubah Kategori' : 'Tambah Kategori Baru'">
        <form wire:submit.prevent="save" class="space-y-6">
            <div class="space-y-1.5">
                <label for="form-name" class="text-caption font-semibold text-brand-ink/80 block">Nama Kategori</label>
                <input 
                    id="form-name"
                    type="text" 
                    wire:model.live="name" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    placeholder="Contoh: Spiritual, Parenting, Relationship"
                />
                @error('name') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-1.5">
                <label for="form-slug" class="text-caption font-semibold text-brand-ink/80 block">Slug URL</label>
                <input 
                    id="form-slug"
                    type="text" 
                    wire:model="slug" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-100 bg-slate-50 text-brand-ink/50 text-body"
                    disabled
                />
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button 
                    @click="$dispatch('close-modal', 'category-modal')" 
                    type="button" 
                    class="px-5 py-2.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-caption font-medium transition-all"
                >
                    Batal
                </button>
                <button 
                    type="submit" 
                    class="px-5 py-2.5 rounded-lg bg-brand-primary hover:bg-brand-secondary text-brand-white text-caption font-semibold transition-all shadow-brand-soft"
                >
                    Simpan
                </button>
            </div>
        </form>
    </x-ui.modal>

    <!-- Delete Confirmation Modal -->
    <x-ui.modal id="delete-confirm-modal" title="Konfirmasi Hapus Kategori">
        <div class="space-y-6">
            <p class="text-body text-brand-ink/75">
                Apakah Anda yakin ingin menghapus kategori blog ini? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button 
                    @click="$dispatch('close-modal', 'delete-confirm-modal')" 
                    type="button" 
                    class="px-5 py-2.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-caption font-medium transition-all"
                >
                    Batal
                </button>
                <button 
                    wire:click="delete"
                    type="button" 
                    class="px-5 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-brand-white text-caption font-semibold transition-all shadow-md"
                >
                    Hapus Permanen
                </button>
            </div>
        </div>
    </x-ui.modal>
    <!-- Bulk Delete Confirmation Modal -->
    <x-ui.modal id="bulk-delete-confirm-modal" title="Konfirmasi Hapus Terpilih">
        <div class="space-y-6">
            <p class="text-body text-brand-ink/75">
                Apakah Anda yakin ingin menghapus <span class="font-bold text-red-600" x-text="selected.length"></span> kategori terpilih? Tindakan ini tidak dapat dibatalkan.
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
</div>
