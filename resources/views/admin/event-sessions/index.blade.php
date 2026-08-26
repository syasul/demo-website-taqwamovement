<x-layouts.admin>
    @section('page_title', 'Kelola Sesi Program Event')

    <!-- Top Action Header -->
    <div class="mb-6 flex justify-between items-center flex-wrap gap-4">
        <p class="text-caption text-brand-ink/60">Kelola rincian judul sesi, deskripsi materi, waktu mulai/selesai, serta urutan agenda acara.</p>
        <a 
            href="{{ route('admin.event-sessions.create') }}" 
            class="inline-flex items-center justify-center px-4 py-2.5 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium tracking-wide text-caption shadow-brand-soft hover:-translate-y-0.5 transition-all duration-300"
        >
            + Tambah Sesi
        </a>
    </div>

    <!-- Data Table Card -->
    <div class="bg-brand-white border border-slate-200 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" aria-label="Event sessions list">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-brand-ink/50 uppercase tracking-wider">
                        <th class="px-6 py-4">Event</th>
                        <th class="px-6 py-4">No. Sesi</th>
                        <th class="px-6 py-4">Judul Sesi</th>
                        <th class="px-6 py-4 text-center">Waktu</th>
                        <th class="px-6 py-4 text-center">Urutan</th>
                        <th class="px-6 py-4 w-36 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-body text-brand-ink/80">
                    @forelse($eventSessions as $session)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-caption text-brand-ink/65 font-medium whitespace-nowrap">
                                {{ Str::limit($session->event->title ?? '-', 25) }}
                            </td>
                            <td class="px-6 py-4 font-mono font-bold text-brand-primary text-center">
                                0{{ $session->session_number }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-brand-primary">
                                {{ $session->title }}
                            </td>
                            <td class="px-6 py-4 text-center text-caption text-brand-ink/65 whitespace-nowrap">
                                {{ $session->start_time }} - {{ $session->end_time }} WIB
                            </td>
                            <td class="px-6 py-4 text-center text-caption whitespace-nowrap font-medium">
                                Ke-{{ $session->order }}
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.event-sessions.edit', $session->id) }}" class="p-1.5 text-brand-primary hover:bg-brand-primary/5 rounded-lg font-semibold text-caption transition-colors">Edit</a>
                                    
                                    <form method="POST" action="{{ route('admin.event-sessions.destroy', $session->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sesi ini?');">
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
                                Belum ada sesi program ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($eventSessions->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50">
                {{ $eventSessions->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
