<x-layouts.admin>
    @section('page_title', 'Kelola Tiket Event')

    <!-- Top Action Header -->
    <div class="mb-6 flex justify-between items-center flex-wrap gap-4">
        <p class="text-caption text-brand-ink/60">Kelola kuota, harga, dan jadwal penjualan tiket untuk tiap event.</p>
        <a 
            href="{{ route('admin.ticket-types.create') }}" 
            class="inline-flex items-center justify-center px-4 py-2.5 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium tracking-wide text-caption shadow-brand-soft hover:-translate-y-0.5 transition-all duration-300"
        >
            + Tambah Jenis Tiket
        </a>
    </div>

    <!-- Data Table Card -->
    <div class="bg-brand-white border border-slate-200 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" aria-label="Ticket types list">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-brand-ink/50 uppercase tracking-wider">
                        <th class="px-6 py-4">Event</th>
                        <th class="px-6 py-4">Jenis Tiket</th>
                        <th class="px-6 py-4 text-center">Harga</th>
                        <th class="px-6 py-4 text-center">Kuota (Terjual)</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 w-36 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-body text-brand-ink/80">
                    @forelse($ticketTypes as $type)
                        <tr class="hover:bg-slate-50/50 transition-colors">
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
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.ticket-types.edit', $type->id) }}" class="p-1.5 text-brand-primary hover:bg-brand-primary/5 rounded-lg font-semibold text-caption transition-colors">Edit</a>
                                    
                                    <form method="POST" action="{{ route('admin.ticket-types.destroy', $type->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jenis tiket ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg font-semibold text-caption transition-colors">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-caption text-brand-ink/50 italic">
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
</x-layouts.admin>
