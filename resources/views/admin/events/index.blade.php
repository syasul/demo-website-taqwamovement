<x-layouts.admin>
    @section('page_title', 'Kelola Event')

    <!-- Top Action Header -->
    <div class="mb-6 flex justify-between items-center flex-wrap gap-4">
        <p class="text-caption text-brand-ink/60">Kelola detail program kajian, rundown sesi, pembicara, dan detail pembelian tiket.</p>
        <a 
            href="{{ route('admin.events.create') }}" 
            class="inline-flex items-center justify-center px-4 py-2.5 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium tracking-wide text-caption shadow-brand-soft hover:-translate-y-0.5 transition-all duration-300"
            id="admin-btn-add-event"
        >
            + Tambah Event
        </a>
    </div>

    <!-- Data Table Card -->
    <div class="bg-brand-white border border-slate-200 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" aria-label="Events list">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-brand-ink/50 uppercase tracking-wider">
                        <th class="px-6 py-4">Fase</th>
                        <th class="px-6 py-4">Nama Event</th>
                        <th class="px-6 py-4 text-center">Tanggal</th>
                        <th class="px-6 py-4">Lokasi</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 w-36 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-body text-brand-ink/80">
                    @forelse($events as $event)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-caption text-brand-ink/65 font-medium whitespace-nowrap">
                                {{ Str::limit($event->phase->title ?? '-', 25) }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-brand-primary">
                                {{ $event->title }}
                            </td>
                            <td class="px-6 py-4 text-center text-caption text-brand-ink/65 whitespace-nowrap">
                                {{ $event->date ? $event->date->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-caption text-brand-ink/65 max-w-xs truncate">
                                {{ $event->location }}
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                @if($event->status->value === 'published')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border bg-emerald-50 text-emerald-700 border-emerald-200">Diterbitkan</span>
                                @elseif($event->status->value === 'draft')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border bg-slate-100 text-slate-700 border-slate-200">Draft</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border bg-rose-50 text-rose-700 border-rose-200">Diarsipkan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.events.edit', $event->id) }}" class="p-1.5 text-brand-primary hover:bg-brand-primary/5 rounded-lg font-semibold text-caption transition-colors">Edit</a>
                                    
                                    <form method="POST" action="{{ route('admin.events.destroy', $event->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?');">
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
                                Belum ada data event. Silakan tambahkan program event pertama Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
