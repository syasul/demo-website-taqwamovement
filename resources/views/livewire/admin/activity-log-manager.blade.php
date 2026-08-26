<div>
    <!-- Page Actions Header -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4">
        <div class="relative flex-grow max-w-md">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search" 
                class="w-full pl-10 pr-4 py-2.5 rounded-full border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-caption bg-brand-white"
                placeholder="Cari log berdasarkan aksi, user, email..."
            />
            <span class="absolute left-3.5 top-3.5 text-brand-ink/40">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
        </div>
        <button 
            wire:click="confirmClearLogs"
            type="button" 
            class="inline-flex items-center justify-center px-5 py-2.5 rounded-full text-brand-white bg-red-600 hover:bg-red-700 font-medium tracking-wide text-caption shadow-md transition-all duration-300 focus:outline-none shrink-0"
        >
            Bersihkan Log
        </button>
    </div>

    <!-- Data Table Card -->
    <div class="bg-brand-white border border-slate-200 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" aria-label="Activity logs list">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-brand-ink/50 uppercase tracking-wider">
                        <th class="px-6 py-4 w-44">Waktu</th>
                        <th class="px-6 py-4 w-52">User Admin</th>
                        <th class="px-6 py-4">Aktivitas Audit</th>
                        <th class="px-6 py-4 w-48 text-center">Model Terkait</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-body text-brand-ink/80">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-caption text-brand-ink/65">
                                {{ $log->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i:s') }} WIB
                            </td>
                            <td class="px-6 py-4 font-semibold text-brand-primary">
                                @if($log->causer)
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-brand-primary/10 text-brand-primary flex items-center justify-center font-bold text-[10px] uppercase shrink-0">
                                            {{ substr($log->causer->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="block leading-none text-sm">{{ $log->causer->name }}</span>
                                            <span class="text-[10px] text-brand-ink/50 block font-normal mt-0.5">{{ $log->causer->email }}</span>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-caption text-brand-ink/50 font-normal italic">Sistem/Guest</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-caption font-medium text-brand-primary">
                                {{ $log->description }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($log->subject_type)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider border bg-slate-100 text-slate-700 border-slate-200">
                                        {{ class_basename($log->subject_type) }}
                                    </span>
                                @else
                                    <span class="text-[10px] text-brand-ink/40 italic">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-caption text-brand-ink/50">
                                Tidak ada log audit aktivitas yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination Link -->
    <div class="mt-4">
        {{ $logs->links() }}
    </div>

    <!-- Clear Logs Confirmation Modal -->
    <x-ui.modal id="clear-logs-confirm-modal" title="Bersihkan Log Audit">
        <div class="space-y-6">
            <p class="text-body text-brand-ink/75">
                Apakah Anda yakin ingin menghapus semua log riwayat audit aktivitas? Tindakan ini akan menghapus database log secara permanen dan tidak dapat dibatalkan.
            </p>
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button 
                    @click="$dispatch('close-modal', 'clear-logs-confirm-modal')" 
                    type="button" 
                    class="px-5 py-2.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-caption font-medium transition-all"
                >
                    Batal
                </button>
                <button 
                    wire:click="clearLogs"
                    type="button" 
                    class="px-5 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-brand-white text-caption font-semibold transition-all shadow-md"
                >
                    Hapus Permanen
                </button>
            </div>
        </div>
    </x-ui.modal>
</div>
