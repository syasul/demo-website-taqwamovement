<div>
    <!-- Page Actions Header -->
    <div class="mb-6 flex justify-between items-center">
        <p class="text-caption text-brand-ink/60">Kelola value proposition features (kolom fitur beranda) dan testimonial alumni peserta.</p>
        <button 
            @click="$dispatch('open-modal', 'testimonial-modal')" 
            wire:click="resetFields"
            type="button" 
            class="inline-flex items-center justify-center px-4 py-2.5 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium tracking-wide text-caption shadow-brand-soft transition-all duration-300"
            id="btn-add-testimonial"
        >
            + Tambah Baru
        </button>
    </div>

    <!-- Section 1: Features (Value Proposition) -->
    <div class="mb-12 space-y-4">
        <h3 class="font-serif text-body-lg font-bold text-brand-primary border-b border-slate-200 pb-2">Fitur / Value Propositions (Kolom Beranda)</h3>
        
        <div class="bg-brand-white border border-slate-200 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] overflow-hidden">
            <table class="w-full text-left border-collapse" aria-label="Features list">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-brand-ink/50 uppercase tracking-wider">
                        <th class="px-6 py-4 w-20 text-center">Urutan</th>
                        <th class="px-6 py-4 w-20 text-center">Icon</th>
                        <th class="px-6 py-4">Nama Fitur</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4 w-40 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-body text-brand-ink/80">
                    @php $fIndex = 1; @endphp
                    @forelse($testimonials->where('type', 'feature') as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-center font-bold text-brand-primary">
                                {{ $fIndex++ }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-brand-primary font-bold text-xs uppercase">
                                    {{ substr($item->icon, 0, 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-brand-primary">
                                {{ $item->title }}
                            </td>
                            <td class="px-6 py-4 text-caption text-brand-ink/65 leading-relaxed">
                                {{ $item->description }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="moveUp({{ $item->id }})" type="button" class="p-1 text-brand-ink/50 hover:text-brand-primary" title="Naik"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path></svg></button>
                                    <button wire:click="moveDown({{ $item->id }})" type="button" class="p-1 text-brand-ink/50 hover:text-brand-primary" title="Turun"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg></button>
                                    <button wire:click="edit({{ $item->id }})" type="button" class="text-brand-primary font-semibold text-caption pl-2">Edit</button>
                                    <button wire:click="confirmDelete({{ $item->id }})" type="button" class="text-red-600 font-semibold text-caption pl-1">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-caption text-brand-ink/50 italic">Belum ada kolom fitur beranda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section 2: Testimonials -->
    <div class="space-y-4">
        <h3 class="font-serif text-body-lg font-bold text-brand-primary border-b border-slate-200 pb-2">Testimonial Alumni Peserta</h3>
        
        <div class="bg-brand-white border border-slate-200 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] overflow-hidden">
            <table class="w-full text-left border-collapse" aria-label="Testimonials list">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-brand-ink/50 uppercase tracking-wider">
                        <th class="px-6 py-4 w-20 text-center">Urutan</th>
                        <th class="px-6 py-4">Nama Alumni</th>
                        <th class="px-6 py-4">Pesan Testimonial</th>
                        <th class="px-6 py-4 w-40 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-body text-brand-ink/80">
                    @php $tIndex = 1; @endphp
                    @forelse($testimonials->where('type', 'testimonial') as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-center font-bold text-brand-primary">
                                {{ $tIndex++ }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-brand-primary whitespace-nowrap">
                                {{ $item->title }}
                            </td>
                            <td class="px-6 py-4 text-caption text-brand-ink/65 italic leading-relaxed">
                                "{{ $item->description }}"
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="moveUp({{ $item->id }})" type="button" class="p-1 text-brand-ink/50 hover:text-brand-primary" title="Naik"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path></svg></button>
                                    <button wire:click="moveDown({{ $item->id }})" type="button" class="p-1 text-brand-ink/50 hover:text-brand-primary" title="Turun"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg></button>
                                    <button wire:click="edit({{ $item->id }})" type="button" class="text-brand-primary font-semibold text-caption pl-2">Edit</button>
                                    <button wire:click="confirmDelete({{ $item->id }})" type="button" class="text-red-600 font-semibold text-caption pl-1">Hapus</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-caption text-brand-ink/50 italic">Belum ada data testimonial alumni.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Form Modal (Add / Edit) -->
    <x-ui.modal id="testimonial-modal" :title="$isEdit ? 'Ubah Data' : 'Tambah Data'">
        <form wire:submit.prevent="save" class="space-y-6">
            
            <!-- Type Selector -->
            <div class="space-y-1">
                <label for="testimonial-type" class="text-caption font-semibold text-brand-ink/80 block">Tipe Konten</label>
                <select 
                    id="testimonial-type"
                    wire:model="type" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body bg-brand-white"
                >
                    <option value="feature">Fitur / Value Proposition (Beranda)</option>
                    <option value="testimonial">Testimonial Alumni Peserta</option>
                </select>
                @error('type') <span class="text-xs text-red-600 font-medium block mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Title Field (Fitur name or Alumni name) -->
            <div class="space-y-1">
                <label for="testimonial-title" class="text-caption font-semibold text-brand-ink/80 block">
                    {{ $type === 'feature' ? 'Nama Fitur' : 'Nama Alumni / Pengirim' }}
                </label>
                <input 
                    id="testimonial-title"
                    wire:model.defer="title" 
                    type="text" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    placeholder="{{ $type === 'feature' ? 'e.g. Reflective Session' : 'e.g. Sarah, 24 tahun' }}"
                />
                @error('title') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Icon Field (only for feature type) -->
            @if($type === 'feature')
                <div class="space-y-1">
                    <label for="testimonial-icon" class="text-caption font-semibold text-brand-ink/80 block">Ikon (Heroicon Stroke Name)</label>
                    <select 
                        id="testimonial-icon"
                        wire:model="icon" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body bg-brand-white"
                    >
                        <option value="sparkles">Sparkles (Fitur Khas)</option>
                        <option value="chat-bubble-left-right">Chat (Q&A / Tanya Jawab)</option>
                        <option value="user-group">Users (Komunitas)</option>
                        <option value="heart">Heart (Refleksi Hati)</option>
                    </select>
                    @error('icon') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>
            @endif

            <!-- Description Field -->
            <div class="space-y-1">
                <label for="testimonial-description" class="text-caption font-semibold text-brand-ink/80 block">Deskripsi / Isi Testimonial</label>
                <textarea 
                    id="testimonial-description"
                    wire:model.defer="description" 
                    rows="4"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    placeholder="Tulis penjelasan detail fitur atau pesan testimonial alumni..."
                ></textarea>
                @error('description') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button 
                    @click="$dispatch('close-modal', 'testimonial-modal')" 
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
    <x-ui.modal id="delete-confirm-modal" title="Konfirmasi Hapus Data">
        <div class="space-y-6">
            <p class="text-body text-brand-ink/75">
                Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
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
