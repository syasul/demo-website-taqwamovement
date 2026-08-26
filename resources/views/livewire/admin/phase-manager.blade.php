<div>
    <!-- Page Actions Header -->
    <div class="mb-6 flex justify-between items-center">
        <p class="text-caption text-brand-ink/60">Kelola urutan dan deskripsi fase spiritual growth platform.</p>
        <button 
            @click="$dispatch('open-modal', 'phase-modal')" 
            wire:click="resetFields"
            type="button" 
            class="inline-flex items-center justify-center px-4 py-2.5 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium tracking-wide text-caption shadow-brand-soft transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-brand-accent/50"
            id="btn-add-phase"
        >
            + Tambah Fase
        </button>
    </div>

    <!-- Data Table Card -->
    <div class="bg-brand-white border border-slate-200 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" aria-label="Phases list">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-brand-ink/50 uppercase tracking-wider">
                        <th class="px-6 py-4 w-20 text-center">Urutan</th>
                        <th class="px-6 py-4">Judul Fase</th>
                        <th class="px-6 py-4">Subjudul</th>
                        <th class="px-6 py-4 w-36 text-center">Status</th>
                        <th class="px-6 py-4 w-48 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-body text-brand-ink/80">
                    @forelse($phases as $index => $phase)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-center font-bold text-brand-primary">
                                0{{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-brand-primary">
                                {{ $phase->title }}
                            </td>
                            <td class="px-6 py-4 text-caption text-brand-ink/65">
                                {{ $phase->subtitle }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($phase->status->value === 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border bg-emerald-50 text-emerald-700 border-emerald-200">Aktif</span>
                                @elseif($phase->status->value === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border bg-slate-100 text-slate-700 border-slate-200">Selesai</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border bg-brand-blush-lt/20 text-brand-secondary border-brand-blush-lt/30">Akan Datang</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Sort Buttons -->
                                    <button 
                                        wire:click="moveUp({{ $phase->id }})" 
                                        type="button" 
                                        class="p-1.5 text-brand-ink/50 hover:text-brand-primary hover:bg-slate-100 rounded-lg focus:outline-none disabled:opacity-30"
                                        {{ $loop->first ? 'disabled' : '' }}
                                        title="Pindahkan Ke Atas"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path></svg>
                                    </button>
                                    <button 
                                        wire:click="moveDown({{ $phase->id }})" 
                                        type="button" 
                                        class="p-1.5 text-brand-ink/50 hover:text-brand-primary hover:bg-slate-100 rounded-lg focus:outline-none disabled:opacity-30"
                                        {{ $loop->last ? 'disabled' : '' }}
                                        title="Pindahkan Ke Bawah"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>

                                    <!-- Edit Action -->
                                    <button 
                                        wire:click="edit({{ $phase->id }})" 
                                        type="button" 
                                        class="p-1.5 text-brand-primary hover:bg-brand-primary/5 rounded-lg focus:outline-none font-semibold text-caption"
                                        title="Edit Fase"
                                    >
                                        Edit
                                    </button>

                                    <!-- Delete Action -->
                                    <button 
                                        wire:click="confirmDelete({{ $phase->id }})" 
                                        type="button" 
                                        class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg focus:outline-none font-semibold text-caption"
                                        title="Hapus Fase"
                                    >
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-caption text-brand-ink/50 italic">
                                Belum ada data fase event.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create/Edit Form Modal (Using components/ui/modal) -->
    <x-ui.modal id="phase-modal" :title="$isEdit ? 'Ubah Fase Event' : 'Tambah Fase Event'">
        <form wire:submit.prevent="save" class="space-y-6">
            <!-- Title Field -->
            <div class="space-y-1">
                <label for="form-title" class="text-caption font-semibold text-brand-ink/80 block">Judul Fase</label>
                <input 
                    id="form-title"
                    wire:model.defer="title" 
                    type="text" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    placeholder="e.g. Fase 1: Spiritual Awakening"
                />
                @error('title') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Subtitle Field -->
            <div class="space-y-1">
                <label for="form-subtitle" class="text-caption font-semibold text-brand-ink/80 block">Subjudul</label>
                <input 
                    id="form-subtitle"
                    wire:model.defer="subtitle" 
                    type="text" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    placeholder="e.g. Menemukan kedamaian di tengah kekacauan"
                />
                @error('subtitle') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Description Field -->
            <div class="space-y-1">
                <label for="form-description" class="text-caption font-semibold text-brand-ink/80 block">Deskripsi</label>
                <textarea 
                    id="form-description"
                    wire:model.defer="description" 
                    rows="4"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    placeholder="Jelaskan fokus dan cakupan dari fase event ini..."
                ></textarea>
                @error('description') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Status Field -->
            <div class="space-y-1">
                <label for="form-status" class="text-caption font-semibold text-brand-ink/80 block">Status</label>
                <select 
                    id="form-status"
                    wire:model.defer="status" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                >
                    <option value="upcoming">Akan Datang</option>
                    <option value="active">Aktif</option>
                    <option value="completed">Selesai</option>
                </select>
                @error('status') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button 
                    @click="$dispatch('close-modal', 'phase-modal')" 
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
    <x-ui.modal id="delete-confirm-modal" title="Konfirmasi Hapus Fase">
        <div class="space-y-6">
            <p class="text-body text-brand-ink/75">
                Apakah Anda yakin ingin menghapus fase event ini? Tindakan ini akan menghapus semua event terkait di bawahnya dan tidak dapat dibatalkan.
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
</div>
