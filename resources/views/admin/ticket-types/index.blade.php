<x-layouts.admin>
    @section('page_title', 'Kelola Tiket Event')

    <div x-data="{ selected: [] }">
        <!-- Top Action Header -->
        <div class="mb-6 flex justify-between items-center flex-wrap gap-4">
            <p class="text-caption text-brand-ink/60">Kelola kuota, harga, dan jadwal penjualan tiket untuk tiap event.</p>
            <div class="flex items-center gap-3">
                <!-- Bulk Delete Action -->
                <button 
                    x-show="selected.length > 0" 
                    @click="$dispatch('open-modal', 'bulk-delete-confirm-modal')"
                    type="button" 
                    class="inline-flex items-center justify-center px-4 py-2.5 rounded-full text-brand-white bg-red-600 hover:bg-red-700 font-medium tracking-wide text-caption shadow-brand-soft hover:-translate-y-0.5 transition-all duration-300 focus:outline-none"
                    style="display: none;"
                >
                    Hapus Terpilih (<span x-text="selected.length"></span>)
                </button>

                <a 
                    href="{{ route('admin.ticket-types.create') }}" 
                    class="inline-flex items-center justify-center px-4 py-2.5 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium tracking-wide text-caption shadow-brand-soft hover:-translate-y-0.5 transition-all duration-300"
                >
                    + Tambah Jenis Tiket
                </a>
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="bg-brand-white border border-slate-200 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse" aria-label="Ticket types list">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-brand-ink/50 uppercase tracking-wider">
                            <th class="px-6 py-4 w-12 text-center">
                                <input 
                                    type="checkbox" 
                                    @change="let check = $el.checked; selected = check ? [@foreach($ticketTypes as $type)'{{ $type->id }}',@endforeach] : []"
                                    :checked="selected.length === {{ count($ticketTypes) }} && {{ count($ticketTypes) }} > 0"
                                    class="rounded text-brand-primary focus:ring-brand-accent w-4 h-4 border-slate-200 cursor-pointer"
                                />
                            </th>
                            <th class="px-6 py-4">Event</th>
                            <th class="px-6 py-4">Jenis Tiket</th>
                            <th class="px-6 py-4 text-center">Harga</th>
                            <th class="px-6 py-4 text-center">Kuota (Terjual)</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 w-20 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-body text-brand-ink/80">
                        @forelse($ticketTypes as $type)
                            <tr class="hover:bg-slate-50/50 transition-colors" :class="selected.includes('{{ $type->id }}') ? 'bg-brand-primary/[0.01]' : ''">
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <input 
                                        type="checkbox" 
                                        value="{{ $type->id }}" 
                                        x-model="selected"
                                        class="rounded text-brand-primary focus:ring-brand-accent w-4 h-4 border-slate-200 cursor-pointer"
                                    />
                                </td>
                                <td class="px-6 py-4 text-caption text-brand-ink/65 font-medium whitespace-nowrap">
                                    {{ Str::limit($type->event->title ?? '-', 25) }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-brand-primary">
                                    {{ $type->name }}
                                </td>
                                <td class="px-6 py-4 text-center font-bold text-brand-primary whitespace-nowrap">
                                    Rp {{ number_format($type->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center text-caption whitespace-nowrap font-medium">
                                    {{ $type->quota }} ({{ $type->sold_count }})
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    @if($type->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border bg-emerald-50 text-emerald-700 border-emerald-200">Aktif</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border bg-slate-100 text-slate-700 border-slate-200">Non-Aktif</span>
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
                                            <a href="{{ route('admin.ticket-types.edit', $type->id) }}" class="block px-4 py-2 text-brand-primary hover:bg-slate-50 transition-colors">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.ticket-types.destroy', $type->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis tiket ini?');" class="block w-full">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition-colors">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-caption text-brand-ink/50 italic">
                                    Belum ada jenis tiket ditambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($ticketTypes->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50">
                    {{ $ticketTypes->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Bulk Delete Confirmation Modal -->
    <x-ui.modal id="bulk-delete-confirm-modal" title="Konfirmasi Hapus Terpilih">
        <form 
            method="POST" 
            action="{{ route('admin.ticket-types.bulk-destroy') }}" 
            class="space-y-6"
        >
            @csrf
            @method('DELETE')
            <template x-for="id in selected" :key="id">
                <input type="hidden" name="ids[]" :value="id">
            </template>

            <p class="text-body text-brand-ink/75">
                Apakah Anda yakin ingin menghapus <span class="font-bold text-red-600" x-text="selected.length"></span> jenis tiket terpilih? Tindakan ini tidak dapat dibatalkan.
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
        </form>
    </x-ui.modal>
</x-layouts.admin>
