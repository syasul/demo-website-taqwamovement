<div x-data="{ selected: [] }">
    <!-- Page Actions Header -->
    <div class="mb-6 flex justify-between items-center flex-wrap gap-4">
        <div class="flex items-center gap-3">
            <input 
                type="checkbox" 
                @change="let check = $el.checked; selected = check ? [@foreach($speakers as $speaker)'{{ $speaker->id }}',@endforeach] : []"
                :checked="selected.length === {{ count($speakers) }} && {{ count($speakers) }} > 0"
                class="rounded text-brand-primary focus:ring-brand-accent w-4 h-4 border-slate-200 cursor-pointer"
                id="select-all-speakers"
            />
            <label for="select-all-speakers" class="text-xs font-semibold text-brand-ink/60 cursor-pointer select-none">Pilih Semua</label>
        </div>
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
                @click="$dispatch('open-modal', 'speaker-modal')" 
                wire:click="resetFields"
                type="button" 
                class="inline-flex items-center justify-center px-4 py-2.5 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium tracking-wide text-caption shadow-brand-soft transition-all duration-300"
                id="btn-add-speaker"
            >
                + Tambah Pembicara
            </button>
        </div>
    </div>

    <!-- Speakers Card Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($speakers as $speaker)
            <div class="bg-brand-white border border-slate-200 p-6 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] flex flex-col justify-between items-start gap-4 relative" :class="selected.includes('{{ $speaker->id }}') ? 'bg-brand-primary/[0.01]' : ''">
                <div class="flex items-start gap-3.5 w-full relative pr-8">
                    <!-- Checkbox left -->
                    <div class="self-center pt-0.5">
                        <input 
                            type="checkbox" 
                            value="{{ $speaker->id }}" 
                            x-model="selected"
                            class="rounded text-brand-primary focus:ring-brand-accent w-4 h-4 border-slate-200 cursor-pointer"
                        />
                    </div>
                    <!-- Photo preview circle -->
                    <div class="w-12 h-12 rounded-full bg-brand-blush flex items-center justify-center font-serif text-body font-bold text-brand-primary overflow-hidden shrink-0 border border-brand-accent">
                        @if($speaker->hasMedia('photo'))
                            <img src="{{ $speaker->getFirstMediaUrl('photo', 'thumb') }}" alt="{{ $speaker->name }}" class="w-full h-full object-cover"/>
                        @else
                            {{ substr($speaker->name, 0, 1) }}
                        @endif
                    </div>
                    <div class="space-y-0.5 flex-grow overflow-hidden">
                        <h4 class="font-serif font-bold text-brand-primary text-body truncate">{{ $speaker->name }}</h4>
                        <span class="text-[11px] text-brand-ink/50 block font-medium truncate">{{ $speaker->role_title }}</span>
                        @if($speaker->instagram_url)
                            <a href="{{ $speaker->instagram_url }}" target="_blank" rel="noopener" class="text-xs text-brand-secondary hover:underline truncate block">
                                {{ parse_url($speaker->instagram_url, PHP_URL_PATH) }}
                            </a>
                        @endif
                    </div>

                    <!-- 3-dots actions dropdown absolute right -->
                    <div x-data="{ open: false }" class="absolute right-0 top-0 text-left">
                        <button 
                            @click="open = !open" 
                            @click.away="open = false" 
                            type="button" 
                            class="p-2 hover:bg-slate-100 rounded-full transition-colors text-brand-ink/50 hover:text-brand-ink focus:outline-none"
                        >
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                        </button>
                        <div 
                            x-show="open" 
                            x-transition 
                            class="absolute right-0 mt-1 w-28 rounded-xl bg-white border border-slate-200 shadow-lg py-1 z-30 text-left text-caption font-semibold"
                            style="display: none;"
                        >
                            <button wire:click="edit({{ $speaker->id }})" type="button" class="w-full text-left px-4 py-2 text-brand-primary hover:bg-slate-50 transition-colors">
                                Edit
                            </button>
                            <button wire:click="confirmDelete({{ $speaker->id }})" type="button" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition-colors">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>

                <p class="text-caption text-brand-ink/75 leading-relaxed line-clamp-3 w-full border-t border-slate-100 pt-3">
                    {{ $speaker->bio ?? 'Belum ada biografi.' }}
                </p>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-caption text-brand-ink/50 italic">
                Belum ada data pembicara.
            </div>
        @endforelse
    </div>

    <!-- Form Modal (Add / Edit) -->
    <x-ui.modal id="speaker-modal" :title="$isEdit ? 'Ubah Pembicara' : 'Tambah Pembicara'">
        <form wire:submit.prevent="save" class="space-y-6">
            
            <!-- Photo Upload field -->
            <div class="space-y-2">
                <span class="text-caption font-semibold text-brand-ink/80 block">Foto Profil</span>
                <div class="flex items-center gap-4">
                    <!-- Preview -->
                    <div class="w-16 h-16 rounded-full bg-brand-blush-lt/30 flex items-center justify-center font-serif font-bold text-brand-primary overflow-hidden shrink-0 border border-brand-blush-lt">
                        @if($photo)
                            <img src="{{ $photo->temporaryUrl() }}" alt="Preview" class="w-full h-full object-cover"/>
                        @elseif($isEdit && $photoUrl)
                            <img src="{{ $photoUrl }}" alt="Foto" class="w-full h-full object-cover"/>
                        @else
                            Photo
                        @endif
                    </div>
                    <!-- Upload Input -->
                    <div class="flex-grow">
                        <label for="speaker-photo-input" class="sr-only">Pilih file foto</label>
                        <input 
                            id="speaker-photo-input"
                            type="file" 
                            wire:model="photo" 
                            class="text-caption text-brand-ink/75"
                        />
                        <span class="text-xs text-brand-ink/40 block mt-1">PNG, JPG, JPEG. Maks 2MB.</span>
                        @error('photo') <span class="text-xs text-red-600 font-medium block mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Name Field -->
            <div class="space-y-1">
                <label for="speaker-name" class="text-caption font-semibold text-brand-ink/80 block">Nama Lengkap</label>
                <input 
                    id="speaker-name"
                    wire:model.defer="name" 
                    type="text" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    placeholder="e.g. Ust. Dennis Lim"
                />
                @error('name') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Role Title Field -->
            <div class="space-y-1">
                <label for="speaker-role" class="text-caption font-semibold text-brand-ink/80 block">Peran / Jabatan</label>
                <input 
                    id="speaker-role"
                    wire:model.defer="role_title" 
                    type="text" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    placeholder="e.g. Da'i & Pembina Spiritual"
                />
                @error('role_title') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Bio Field -->
            <div class="space-y-1">
                <label for="speaker-bio" class="text-caption font-semibold text-brand-ink/80 block">Biografi Pembicara</label>
                <textarea 
                    id="speaker-bio"
                    wire:model.defer="bio" 
                    rows="4"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    placeholder="Tuliskan biografi atau info ringkas mengenai pembicara..."
                ></textarea>
                @error('bio') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Instagram URL Field -->
            <div class="space-y-1">
                <label for="speaker-instagram" class="text-caption font-semibold text-brand-ink/80 block">Link Profil Instagram</label>
                <input 
                    id="speaker-instagram"
                    wire:model.defer="instagram_url" 
                    type="url" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    placeholder="https://instagram.com/username"
                />
                @error('instagram_url') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button 
                    @click="$dispatch('close-modal', 'speaker-modal')" 
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
    <x-ui.modal id="delete-confirm-modal" title="Konfirmasi Hapus Pembicara">
        <div class="space-y-6">
            <p class="text-body text-brand-ink/75">
                Apakah Anda yakin ingin menghapus data pembicara ini? Tindakan ini tidak dapat dibatalkan.
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
                    Hapus
                </button>
            </div>
        </div>
    </x-ui.modal>
    <!-- Bulk Delete Confirmation Modal -->
    <x-ui.modal id="bulk-delete-confirm-modal" title="Konfirmasi Hapus Terpilih">
        <div class="space-y-6">
            <p class="text-body text-brand-ink/75">
                Apakah Anda yakin ingin menghapus <span class="font-bold text-red-600" x-text="selected.length"></span> pembicara terpilih? Tindakan ini tidak dapat dibatalkan.
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
