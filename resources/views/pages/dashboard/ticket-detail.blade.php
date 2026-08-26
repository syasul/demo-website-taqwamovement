<x-layouts.app>
    @section('title', 'Detail E-Ticket - Taqwa Movement')

    <section class="py-20 md:py-32 bg-mesh-glow text-brand-white relative overflow-hidden min-h-[85vh]">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <!-- Sidebar Menu (Glass Navigation) -->
                <div class="lg:col-span-3">
                    <x-ui.glass-card dark="true" class="space-y-2 p-6 border border-brand-white/10">
                        <h3 class="text-caption font-semibold uppercase tracking-wider text-brand-accent mb-4">Dashboard</h3>
                        
                        <a 
                            href="{{ route('dashboard.my-tickets') }}" 
                            class="flex items-center gap-3 px-4 py-3 rounded-full text-caption font-semibold bg-brand-gold text-brand-navy shadow-glow transition-all duration-300"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            <span>Tiket Saya</span>
                        </a>

                        <a 
                            href="{{ route('dashboard.transactions') }}" 
                            class="flex items-center gap-3 px-4 py-3 rounded-full text-caption font-semibold text-brand-white/80 hover:bg-brand-white/10 hover:text-brand-white transition-all duration-300"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            <span>Riwayat Transaksi</span>
                        </a>

                        <a 
                            href="{{ route('profile.edit') }}" 
                            class="flex items-center gap-3 px-4 py-3 rounded-full text-caption font-semibold text-brand-white/80 hover:bg-brand-white/10 hover:text-brand-white transition-all duration-300"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span>Edit Profil</span>
                        </a>
                    </x-ui.glass-card>
                </div>

                <!-- Main Content Area -->
                <div class="lg:col-span-9 space-y-8">
                    
                    <!-- Back control and action bar -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-brand-white/10 pb-4">
                        <div>
                            <a href="{{ route('dashboard.my-tickets') }}" class="text-caption text-brand-accent hover:text-brand-gold flex items-center gap-2 mb-2 transition-colors">
                                &larr; Kembali ke Daftar Tiket
                            </a>
                            <h1 class="font-serif text-h1 text-brand-gold font-bold">Detail E-Ticket</h1>
                        </div>
                        <x-ui.glass-button 
                            variant="light"
                            href="{{ route('dashboard.ticket.pdf', $order->order_number) }}"
                            class="w-full sm:w-auto text-brand-white"
                        >
                            Unduh PDF Tiket
                        </x-ui.glass-button>
                    </div>

                    <!-- Event Summary Card -->
                    <x-ui.glass-card dark="true" class="border border-brand-white/10 p-6 flex flex-col md:flex-row justify-between gap-6">
                        <div class="space-y-3">
                            <span class="text-caption text-brand-accent/80 font-bold uppercase tracking-wider text-xs block">Event Terdaftar</span>
                            <h2 class="font-serif text-h2 text-brand-white font-bold leading-tight">{{ $event->title }}</h2>
                            <p class="text-caption text-brand-white/70">{{ $event->location }}</p>
                        </div>
                        <div class="flex md:flex-col justify-between items-end border-t md:border-t-0 md:border-l border-brand-white/10 pt-4 md:pt-0 md:pl-6 shrink-0 text-caption text-brand-white/70">
                            <div>
                                <span class="block text-xs text-brand-white/50">TANGGAL EVENT</span>
                                <span class="font-bold text-brand-gold text-right">{{ $event->date->format('l, d F Y') }}</span>
                            </div>
                            <div class="mt-2 text-right">
                                <span class="block text-xs text-brand-white/50">WAKTU SESI</span>
                                <span class="font-semibold text-brand-white">09.00 - 15.30 WIB</span>
                            </div>
                        </div>
                    </x-ui.glass-card>

                    <!-- Attendee E-Tickets Grid -->
                    <div class="space-y-6">
                        <h3 class="font-serif text-body-lg font-bold text-brand-white border-b border-brand-white/5 pb-2">Peserta Terdaftar (QR Code Check-in)</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach ($items as $item)
                                <x-ui.glass-card dark="true" class="border border-brand-accent/20 bg-brand-navy/60 p-6 text-center space-y-4 flex flex-col justify-between">
                                    <div class="space-y-4">
                                        <div class="border-b border-brand-white/5 pb-3">
                                            <h4 class="font-serif font-bold text-brand-white text-body-lg">{{ $item->attendee_name }}</h4>
                                            <p class="text-caption text-brand-white/60 text-xs">{{ $item->attendee_email }}</p>
                                        </div>

                                        <div class="w-36 h-36 bg-white p-2 rounded-xl mx-auto flex items-center justify-center border border-brand-accent/30 shadow-glow">
                                            @if ($item->eTicket)
                                                {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(128)->margin(0)->generate($item->eTicket->qr_payload) !!}
                                            @endif
                                        </div>

                                        <div class="space-y-1">
                                            <span class="block text-xs text-brand-white/40">KODE TIKET</span>
                                            <span class="font-mono text-brand-gold font-bold tracking-wider text-sm">{{ $item->eTicket->ticket_code ?? 'PENDING' }}</span>
                                        </div>
                                    </div>

                                    <div class="pt-4 border-t border-brand-white/5">
                                        @if($item->eTicket && $item->eTicket->is_checked_in)
                                            <span class="bg-emerald-500/20 text-emerald-300 text-xs font-semibold px-4 py-1.5 rounded-full border border-emerald-500/30 flex items-center justify-center gap-1.5 max-w-[200px] mx-auto uppercase">
                                                ✓ Checked In
                                            </span>
                                        @else
                                            <span class="bg-brand-white/10 text-brand-white/60 text-xs font-semibold px-4 py-1.5 rounded-full border border-brand-white/10 flex items-center justify-center gap-1.5 max-w-[200px] mx-auto uppercase">
                                                Belum Check-In
                                            </span>
                                        @endif
                                    </div>
                                </x-ui.glass-card>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
</x-layouts.app>
