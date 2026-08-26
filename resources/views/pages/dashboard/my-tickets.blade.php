<x-layouts.app>
    @section('title', 'Tiket Saya - Taqwa Movement')

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
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
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
                        <h1 class="font-serif text-h1 text-brand-gold font-bold">Tiket Saya</h1>
                        <p class="text-caption text-brand-white/70">Berikut adalah daftar tiket event aktif Anda yang sudah terbayar.</p>
                    </div>

                    @if($orders->isEmpty())
                        <x-ui.glass-card dark="true" class="p-12 text-center border border-brand-white/10 space-y-4">
                            <span class="text-4xl block text-brand-accent">🎫</span>
                            <h3 class="font-serif text-body-lg font-bold text-brand-white">Belum Ada Tiket</h3>
                            <p class="text-caption text-brand-white/70 max-w-sm mx-auto">Anda belum memiliki tiket aktif. Jelajahi event kami untuk bergabung dalam perjalanan spiritual growth selanjutnya.</p>
                            <x-ui.glass-button 
                                variant="light"
                                href="/"
                                class="mt-4"
                            >
                                Cari Event
                            </x-ui.glass-button>
                        </x-ui.glass-card>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($orders as $order)
                                <x-ui.glass-card dark="true" class="flex flex-col justify-between border border-brand-white/10 hover:border-brand-accent/30 transition-all duration-300 p-6">
                                    <div class="space-y-4">
                                        <div class="flex justify-between items-center">
                                            <span class="bg-emerald-500/20 text-emerald-300 text-xs px-2.5 py-0.5 rounded-full border border-emerald-500/30 uppercase font-bold tracking-wide">Terbayar</span>
                                            <span class="text-caption text-brand-white/50 text-xs">{{ $order->order_number }}</span>
                                        </div>
                                        <div>
                                            <h3 class="font-serif text-body-lg font-bold text-brand-white mb-1">{{ $order->event->title }}</h3>
                                            <p class="text-caption text-brand-gold text-xs font-semibold">{{ $order->event->date->format('l, d F Y') }}</p>
                                        </div>
                                        
                                        <div class="pt-3 border-t border-brand-white/5 space-y-1.5 text-xs text-brand-white/70">
                                            <div class="flex justify-between">
                                                <span>Total Tiket:</span>
                                                <span class="font-semibold text-brand-white">{{ $order->items->count() }} Peserta</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Lokasi:</span>
                                                <span class="font-semibold text-brand-white truncate max-w-[70%]">{{ Str::limit($order->event->location, 25) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 mt-6">
                                        <x-ui.glass-button 
                                            variant="light"
                                            href="{{ route('dashboard.ticket.show', $order->order_number) }}"
                                            class="w-full text-xs text-brand-white"
                                        >
                                            Detail QR
                                        </x-ui.glass-button>
                                        
                                        <x-ui.glass-button 
                                            variant="light"
                                            href="{{ route('dashboard.ticket.pdf', $order->order_number) }}"
                                            class="w-full text-xs text-brand-white"
                                        >
                                            Unduh PDF
                                        </x-ui.glass-button>
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
