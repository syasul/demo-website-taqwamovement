<x-layouts.app>
    @section('title', 'Riwayat Transaksi - Taqwa Movement')

    <section class="py-20 md:py-32 bg-mesh-glow text-brand-white relative overflow-hidden min-h-[85vh]">
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <!-- Sidebar Menu (Glass Navigation) -->
                <div class="lg:col-span-3">
                    <x-ui.glass-card dark="true" class="space-y-2 p-6 border border-brand-white/10">
                        <h3 class="text-caption font-semibold uppercase tracking-wider text-brand-accent mb-4">Dashboard</h3>
                        
                        <a 
                            href="{{ route('dashboard.my-tickets') }}" 
                            class="flex items-center gap-3 px-4 py-3 rounded-full text-caption font-semibold text-brand-white/80 hover:bg-brand-white/10 hover:text-brand-white transition-all duration-300"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            <span>Tiket Saya</span>
                        </a>

                        <a 
                            href="{{ route('dashboard.transactions') }}" 
                            class="flex items-center gap-3 px-4 py-3 rounded-full text-caption font-semibold bg-brand-gold text-brand-navy shadow-glow transition-all duration-300"
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
                <div class="lg:col-span-9 space-y-6">
                    <div class="border-b border-brand-white/10 pb-4">
                        <h1 class="font-serif text-h1 text-brand-gold font-bold">Riwayat Transaksi</h1>
                        <p class="text-caption text-brand-white/70">Berikut adalah daftar lengkap log pesanan tiket dan status pembayaran Anda.</p>
                    </div>

                    @if($orders->isEmpty())
                        <x-ui.glass-card dark="true" class="p-12 text-center border border-brand-white/10 space-y-4">
                            <span class="text-4xl block text-brand-accent">🧾</span>
                            <h3 class="font-serif text-body-lg font-bold text-brand-white">Belum Ada Transaksi</h3>
                            <p class="text-caption text-brand-white/70 max-w-sm mx-auto">Anda belum memiliki riwayat pembelian tiket di platform kami.</p>
                        </x-ui.glass-card>
                    @else
                        <div class="space-y-4">
                            @foreach($orders as $order)
                                <x-ui.glass-card dark="true" class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 border border-brand-white/10 p-6">
                                    <div class="space-y-2 flex-grow">
                                        <div class="flex flex-wrap items-center gap-3">
                                            <span class="font-mono text-brand-gold text-xs font-semibold">{{ $order->order_number }}</span>
                                            <span class="text-brand-white/40 text-xs">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
                                            
                                            <!-- Status Badge -->
                                            @if($order->status === 'paid')
                                                <span class="bg-emerald-500/20 text-emerald-300 text-[10px] font-bold px-2 py-0.5 rounded-full border border-emerald-500/30 uppercase tracking-wide">Terbayar</span>
                                            @elseif($order->status === 'pending')
                                                <span class="bg-amber-500/20 text-amber-300 text-[10px] font-bold px-2 py-0.5 rounded-full border border-amber-500/30 uppercase tracking-wide animate-pulse">Menunggu Pembayaran</span>
                                            @elseif($order->status === 'expired')
                                                <span class="bg-brand-white/10 text-brand-white/40 text-[10px] font-bold px-2 py-0.5 rounded-full border border-brand-white/20 uppercase tracking-wide">Kedaluwarsa</span>
                                            @else
                                                <span class="bg-rose-500/20 text-rose-300 text-[10px] font-bold px-2 py-0.5 rounded-full border border-rose-500/30 uppercase tracking-wide">Batal</span>
                                            @endif
                                        </div>
                                        <h3 class="font-serif font-bold text-brand-white text-body-lg">{{ $order->event->title }}</h3>
                                    </div>
                                    <div class="flex items-center justify-between sm:justify-end gap-6 shrink-0 border-t sm:border-t-0 pt-4 sm:pt-0 border-brand-white/10 w-full sm:w-auto">
                                        <div class="text-left sm:text-right">
                                            <span class="block text-[10px] text-brand-white/40 uppercase font-medium">TOTAL NOMINAL</span>
                                            <span class="font-bold text-brand-accent text-body-lg">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                                        </div>
                                        
                                        @if($order->status === 'pending')
                                            <x-ui.glass-button 
                                                variant="accent"
                                                href="{{ route('checkout.status', $order->order_number) }}"
                                                class="text-xs"
                                            >
                                                Bayar
                                            </x-ui.glass-button>
                                        @elseif($order->status === 'paid')
                                            <x-ui.glass-button 
                                                variant="light"
                                                href="{{ route('dashboard.ticket.show', $order->order_number) }}"
                                                class="text-xs text-brand-white"
                                            >
                                                Lihat Tiket
                                            </x-ui.glass-button>
                                        @else
                                            <span class="text-caption text-brand-white/40 font-semibold px-4 py-2 border border-dashed border-brand-white/10 rounded-full text-xs">Selesai</span>
                                        @endif
                                    </div>
                                </x-ui.glass-card>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>
</x-layouts.app>
