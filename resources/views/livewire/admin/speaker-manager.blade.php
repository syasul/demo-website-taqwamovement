<div>
    <!-- Page Actions Header -->
    <div class="mb-6 flex justify-between items-center">
        <p class="text-caption text-brand-ink/60">Kelola informasi profil, biografi, dan foto dari para pembicara event.</p>
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

    <!-- Speakers Card Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($speakers as $speaker)
            <div class="bg-brand-white border border-slate-200 p-6 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] flex flex-col justify-between items-start gap-4">
                <div class="flex items-start gap-4 w-full">
                    <!-- Photo preview circle -->
                    <div class="w-16 h-16 rounded-full bg-brand-blush flex items-center justify-center font-serif text-body-lg font-bold text-brand-primary overflow-hidden shrink-0 border border-brand-accent">
                        @if($speaker->hasMedia('photo'))
                            <img src="{{ $speaker->getFirstMediaUrl('photo', 'thumb') }}" alt="{{ $speaker->name }}" class="w-full h-full object-cover"/>
                        @else
                            {{ substr($speaker->name, 0, 1) }}
                        @endif
                    </div>
                    <div class="space-y-1 flex-grow overflow-hidden">
                        <h4 class="font-serif font-bold text-brand-primary text-body-lg truncate">{{ $speaker->name }}</h4>
                        <span class="text-xs text-brand-ink/50 block font-medium truncate">{{ $speaker->role_title }}</span>
                        @if($speaker->instagram_url)
                            <a href="{{ $speaker->instagram_url }}" target="_blank" rel="noopener" class="text-xs text-brand-secondary hover:underline truncate block">
                                {{ parse_url($speaker->instagram_url, PHP_URL_PATH) }}
                            </a>
                        @endif
                    </div>
                </div>

                <p class="text-caption text-brand-ink/75 leading-relaxed line-clamp-3 w-full border-t border-slate-100 pt-3">
                    {{ $speaker->bio ?? 'Belum ada biografi.' }}
                </p>

                <!-- Actions footer -->
                <div class="w-full flex justify-end gap-2 border-t border-slate-100 pt-3 mt-1">
                    <button 
                        wire:click="edit({{ $speaker->id }})" 
                        type="button" 
                        class="px-3 py-1.5 rounded-lg text-brand-primary hover:bg-brand-primary/5 font-semibold text-xs"
                    >
                        Edit
                    </button>
                    <button 
                        wire:click="confirmDelete({{ $speaker->id }})" 
                        type="button" 
                        class="px-3 py-1.5 rounded-lg text-red-600 hover:bg-red-50 font-semibold text-xs"
                    >
                        Hapus
                    </button>
                </div>
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
</div>
