<x-layouts.admin>
    @section('page_title', 'Kelola Kode Promo / Diskon')

    <div x-data="{ selected: [], singleDeleteUrl: '' }">
        <!-- Top Action Header -->
        <div class="mb-6 flex justify-between items-center flex-wrap gap-4">
            <p class="text-caption text-brand-ink/60">Kelola kupon diskon, persentase potongan harga, dan batas kuota promo.</p>
            <div class="flex items-center gap-3">
                <!-- Bulk Delete Action -->
                <!-- Bulk Delete Action -->
                <button 
                    x-show="selected.length > 0"
                    @click="$dispatch('open-modal', 'bulk-delete-confirm-modal')"
                    type="button" 
                    class="inline-flex items-center justify-center px-4 py-2.5 rounded-full text-brand-white bg-red-600 hover:bg-red-700 font-medium tracking-wide text-caption shadow-brand-soft hover:-translate-y-0.5 transition-all duration-300 focus:outline-none shrink-0"
                    style="display: none;"
                >
                    Hapus Terpilih (<span x-text="selected.length"></span>)
                </button>

                <a 
                    href="{{ route('admin.promo-codes.create') }}" 
                    class="inline-flex items-center justify-center px-4 py-2.5 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium tracking-wide text-caption shadow-brand-soft hover:-translate-y-0.5 transition-all duration-300"
                >
                    + Tambah Kode Promo
                </a>
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="bg-brand-white border border-slate-200 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse" aria-label="Promo codes list">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-brand-ink/50 uppercase tracking-wider">
                            <th class="px-6 py-4 w-12 text-center">
                                <input 
                                    type="checkbox" 
                                    @change="let check = $el.checked; selected = check ? [@foreach($promoCodes as $code)'{{ $code->id }}',@endforeach] : []"
                                    :checked="selected.length === {{ count($promoCodes) }} && {{ count($promoCodes) }} > 0"
                                    class="rounded text-brand-primary focus:ring-brand-accent w-4 h-4 border-slate-200 cursor-pointer"
                                />
                            </th>
                            <th class="px-6 py-4">Kode Promo</th>
                            <th class="px-6 py-4">Jenis Potongan</th>
                            <th class="px-6 py-4 text-center">Nilai Diskon</th>
                            <th class="px-6 py-4 text-center">Batas Penggunaan</th>
                            <th class="px-6 py-4 text-center">Masa Berlaku</th>
                            <th class="px-6 py-4 w-20 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-body text-brand-ink/80">
                        @forelse($promoCodes as $code)
                            <tr class="hover:bg-slate-50/50 transition-colors" :class="selected.includes('{{ $code->id }}') ? 'bg-brand-primary/[0.01]' : ''">
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <input 
                                        type="checkbox" 
                                        value="{{ $code->id }}" 
                                        x-model="selected"
                                        class="rounded text-brand-primary focus:ring-brand-accent w-4 h-4 border-slate-200 cursor-pointer"
                                    />
                                </td>
                                <td class="px-6 py-4 font-mono font-bold text-brand-primary whitespace-nowrap">
                                    {{ $code->code }}
                                </td>
                                <td class="px-6 py-4 text-caption text-brand-ink/65 font-medium whitespace-nowrap">
                                    {{ $code->discount_type === 'percentage' ? 'Persentase (%)' : 'Potongan Tetap (Rp)' }}
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-brand-primary whitespace-nowrap">
                                    {{ $code->discount_type === 'percentage' ? $code->discount_value . '%' : 'Rp ' . number_format($code->discount_value, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center text-caption whitespace-nowrap font-medium">
                                    {{ $code->quota }} ({{ $code->used_count }} Terpakai)
                                </td>
                                <td class="px-6 py-4 text-center text-caption text-brand-ink/65 whitespace-nowrap">
                                    {{ $code->valid_from->format('d M') }} s/d {{ $code->valid_until->format('d M Y') }}
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
                                            <a href="{{ route('admin.promo-codes.edit', $code->id) }}" class="block px-4 py-2 text-brand-primary hover:bg-slate-50 transition-colors">
                                                Edit
                                            </a>
                                            <button 
                                                @click="singleDeleteUrl = '{{ route('admin.promo-codes.destroy', $code->id) }}'; $dispatch('open-modal', 'single-delete-confirm-modal')"
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
                                <td colspan="7" class="px-6 py-12 text-center text-caption text-brand-ink/50 italic">
                                    Belum ada kode promo ditambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($promoCodes->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50">
                    {{ $promoCodes->links() }}
                </div>
            @endif
        </div>
        <!-- Bulk Delete Confirmation Modal -->
        <x-ui.modal id="bulk-delete-confirm-modal" title="Konfirmasi Hapus Terpilih">
            <form method="POST" action="{{ route('admin.promo-codes.bulk-destroy') }}">
                @csrf
                @method('DELETE')
                <template x-for="id in selected" :key="id">
                    <input type="hidden" name="ids[]" :value="id">
                </template>

                <div class="space-y-6">
                    <p class="text-body text-brand-ink/75">
                        Apakah Anda yakin ingin menghapus <span class="font-bold text-red-600" x-text="selected.length"></span> kode promo terpilih? Tindakan ini tidak dapat dibatalkan.
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
                            type="submit" 
                            class="px-5 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-brand-white text-caption font-semibold transition-all shadow-md"
                        >
                            Hapus Permanen
                        </button>
                    </div>
                </div>
            </form>
        </x-ui.modal>

        <!-- Single Delete Confirmation Modal -->
        <x-ui.modal id="single-delete-confirm-modal" title="Konfirmasi Hapus Kode Promo">
            <form method="POST" :action="singleDeleteUrl">
                @csrf
                @method('DELETE')
                <div class="space-y-6">
                    <p class="text-body text-brand-ink/75">
                        Apakah Anda yakin ingin menghapus kode promo ini? Tindakan ini tidak dapat dibatalkan.
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
</x-layouts.admin>
