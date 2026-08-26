<div x-data="{ selected: [] }">
    <!-- Table Filters Header -->
    <div class="bg-brand-white border border-slate-200 p-5 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] mb-6 flex flex-col md:flex-row gap-4 items-center justify-between">
        <p class="text-caption text-brand-ink/60">Daftar pertanyaan dan saran yang dikirimkan oleh pengunjung melalui formulir kontak.</p>
        
        <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto items-center">
            <!-- Bulk Delete Action -->
            <button 
                x-show="selected.length > 0"
                @click="if(confirm('Apakah Anda yakin ingin menghapus ' + selected.length + ' pesan terpilih?')) { $wire.deleteSelected(selected).then(() => selected = []) }"
                type="button" 
                class="inline-flex items-center justify-center px-4 py-2.5 rounded-full text-brand-white bg-red-600 hover:bg-red-700 font-medium tracking-wide text-caption shadow-brand-soft focus:outline-none shrink-0"
                style="display: none;"
            >
                Hapus Terpilih (<span x-text="selected.length"></span>)
            </button>

            <!-- Search bar -->
            <div class="relative w-full md:w-72">
                <input 
                    wire:model.live.debounce.300ms="search" 
                    type="text" 
                    placeholder="Cari pengirim atau pesan..." 
                    class="w-full pl-10 pr-4 py-2 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-caption bg-brand-white"
                />
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
            </div>

            <!-- Status selector -->
            <select wire:model.live="statusFilter" class="px-4 py-2 rounded-lg border border-slate-200 text-caption bg-brand-white focus:border-brand-primary">
                <option value="">Semua Status</option>
                <option value="unread">Belum Dibaca</option>
                <option value="read">Sudah Dibaca</option>
            </select>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-brand-white border border-slate-200 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" aria-label="Inbox messages list">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-brand-ink/50 uppercase tracking-wider">
                        <th class="px-6 py-4 w-12 text-center">
                            <input 
                                type="checkbox" 
                                @change="let check = $el.checked; selected = check ? [@foreach($messages as $msg)'{{ $msg->id }}',@endforeach] : []"
                                :checked="selected.length === {{ count($messages) }} && {{ count($messages) }} > 0"
                                class="rounded text-brand-primary focus:ring-brand-accent w-4 h-4 border-slate-200 cursor-pointer"
                            />
                        </th>
                        <th class="px-6 py-4">Pengirim</th>
                        <th class="px-6 py-4">Isi Pesan</th>
                        <th class="px-6 py-4 text-center">Tanggal Masuk</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 w-20 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-body text-brand-ink/80">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-slate-50/50 transition-colors {{ $msg->status->value === 'unread' ? 'bg-brand-blush-lt/5 font-semibold text-brand-primary' : '' }}" :class="selected.includes('{{ $msg->id }}') ? 'bg-brand-primary/[0.01]' : ''">
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <input 
                                    type="checkbox" 
                                    value="{{ $msg->id }}" 
                                    x-model="selected"
                                    class="rounded text-brand-primary focus:ring-brand-accent w-4 h-4 border-slate-200 cursor-pointer"
                                />
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-0.5">
                                    <span class="block text-brand-primary">{{ $msg->name }}</span>
                                    <span class="block text-xs text-brand-ink/55 font-medium">{{ $msg->email }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-caption text-brand-ink/75 max-w-xs truncate">
                                {{ $msg->message }}
                            </td>
                            <td class="px-6 py-4 text-center text-caption text-brand-ink/65 whitespace-nowrap">
                                {{ $msg->created_at->format('d M Y, H:i') }} WIB
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                @if($msg->status->value === 'unread')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border bg-brand-primary/10 text-brand-primary border-brand-primary/20">Belum Dibaca</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border bg-slate-100 text-slate-500 border-slate-200">Dibaca</span>
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
                                        <button wire:click="showMessage({{ $msg->id }})" type="button" class="w-full text-left px-4 py-2 text-brand-primary hover:bg-slate-50 transition-colors">
                                            Buka
                                        </button>
                                        <button wire:click="toggleStatus({{ $msg->id }})" type="button" class="w-full text-left px-4 py-2 text-slate-600 hover:bg-slate-50 transition-colors">
                                            {{ $msg->status->value === 'unread' ? 'Dibaca' : 'Belum' }}
                                        </button>
                                        <button wire:click="delete({{ $msg->id }})" type="button" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition-colors border-t border-slate-100">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-caption text-brand-ink/50 italic">
                                Belum ada pesan masuk di inbox.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="p-6 border-t border-slate-100 bg-slate-50/50">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

    <!-- Message Detail Drawer/Modal -->
    @if($viewingMessage)
        <x-ui.modal id="inbox-detail-modal" title="Rincian Pesan Masuk">
            <div class="space-y-6">
                <!-- Metadata grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50 p-4 rounded-xl border border-slate-200 text-caption">
                    <div>
                        <span class="text-xs text-brand-ink/40 uppercase tracking-wider block">Pengirim</span>
                        <span class="font-bold text-brand-primary">{{ $viewingMessage->name }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-brand-ink/40 uppercase tracking-wider block">Kontak WhatsApp</span>
                        <span class="font-bold text-brand-primary">{{ $viewingMessage->phone ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-brand-ink/40 uppercase tracking-wider block">Alamat Email</span>
                        <a href="mailto:{{ $viewingMessage->email }}" class="font-bold text-brand-secondary hover:underline">{{ $viewingMessage->email }}</a>
                    </div>
                    <div>
                        <span class="text-xs text-brand-ink/40 uppercase tracking-wider block">IP Address & Tanggal</span>
                        <span class="font-medium text-brand-ink/75">{{ $viewingMessage->ip_address }} &bull; {{ $viewingMessage->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                </div>

                <!-- Message content -->
                <div class="space-y-2">
                    <span class="text-caption font-semibold text-brand-ink/80 block">Isi Pesan:</span>
                    <div class="bg-brand-white border border-slate-200 p-4 rounded-xl text-body text-brand-ink leading-relaxed white-space-pre-wrap">
                        {{ $viewingMessage->message }}
                    </div>
                </div>

                <!-- Footer actions -->
                <div class="flex justify-between items-center pt-4 border-t border-slate-100">
                    <button 
                        wire:click="delete({{ $viewingMessage->id }})" 
                        type="button" 
                        class="px-4 py-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 font-semibold text-caption transition-all"
                    >
                        Hapus Pesan
                    </button>
                    
                    <div class="flex gap-2">
                        <button 
                            wire:click="toggleStatus({{ $viewingMessage->id }})" 
                            type="button" 
                            class="px-4 py-2 rounded-lg border border-slate-200 hover:bg-slate-50 font-medium text-caption text-brand-ink/75 transition-all"
                        >
                            {{ $viewingMessage->status->value === 'unread' ? 'Tandai Dibaca' : 'Tandai Belum Dibaca' }}
                        </button>
                        <button 
                            @click="$dispatch('close-modal', 'inbox-detail-modal')" 
                            type="button" 
                            class="px-5 py-2.5 rounded-lg bg-brand-primary text-brand-white hover:bg-brand-secondary font-semibold text-caption transition-all shadow-brand-soft"
                        >
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </x-ui.modal>
    @endif
</div>
