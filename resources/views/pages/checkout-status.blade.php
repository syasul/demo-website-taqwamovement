<x-layouts.app>
    @section('title', 'Status Pembayaran - Taqwa Movement')

    <section class="min-h-[80vh] py-20 bg-brand-cream text-brand-ink flex items-center justify-center relative overflow-hidden">
        <div class="max-w-xl w-full mx-auto px-6 relative z-10">
            <x-ui.glass-card class="text-center space-y-8 p-10 border border-brand-accent/15 bg-brand-white/70 shadow-brand-soft relative overflow-hidden">
                
                <!-- Pending State Header -->
                <div id="status-pending" class="{{ $order->status === 'pending' ? '' : 'hidden' }} space-y-6">
                    <div class="relative w-20 h-20 mx-auto">
                        <div class="absolute inset-0 border-4 border-brand-primary/15 rounded-full"></div>
                        <div class="absolute inset-0 border-4 border-t-brand-primary rounded-full animate-spin"></div>
                    </div>
                    <div class="space-y-2">
                        <h1 class="font-serif text-h2 text-brand-primary font-bold">Menunggu Pembayaran</h1>
                        <p class="text-body text-brand-ink/70">Kami sedang menunggu konfirmasi pembayaran dari sistem payment gateway.</p>
                    </div>
                    <div class="p-4 bg-brand-cream/60 border border-brand-primary/10 rounded-2xl text-left space-y-2 text-caption">
                        <div class="flex justify-between">
                            <span class="text-brand-ink/60">No. Transaksi:</span>
                            <span class="font-semibold text-brand-primary font-mono">{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-brand-ink/60">Total Tagihan:</span>
                            <span class="font-bold text-brand-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Temporary Payment Screen (Mock Sandbox) -->
                    <div class="mt-6 border-t border-brand-primary/10 pt-6 text-left space-y-4">
                        <h3 class="font-serif text-body font-bold text-brand-primary">Metode Pembayaran Sementara</h3>
                        
                        <div x-data="{ activeTab: 'qris' }" class="space-y-4">
                            <!-- Tab Header -->
                            <div class="flex gap-2 p-1 bg-brand-cream/50 border border-brand-primary/10 rounded-xl">
                                <button 
                                    @click="activeTab = 'qris'"
                                    type="button"
                                    :class="activeTab === 'qris' ? 'bg-brand-primary text-brand-white shadow' : 'text-brand-ink/60 hover:text-brand-primary'"
                                    class="flex-1 py-2 px-3 text-xs font-semibold rounded-lg transition-all duration-300"
                                >
                                    QRIS (Scan)
                                </button>
                                <button 
                                    @click="activeTab = 'transfer'"
                                    type="button"
                                    :class="activeTab === 'transfer' ? 'bg-brand-primary text-brand-white shadow' : 'text-brand-ink/60 hover:text-brand-primary'"
                                    class="flex-1 py-2 px-3 text-xs font-semibold rounded-lg transition-all duration-300"
                                >
                                    Transfer Bank
                                </button>
                            </div>
                            
                            <!-- Tab QRIS -->
                            <div x-show="activeTab === 'qris'" class="space-y-3 flex flex-col items-center py-6 bg-brand-cream/50 border border-brand-primary/10 rounded-2xl">
                                <div class="w-36 h-36 bg-white p-2 rounded-xl flex items-center justify-center border border-brand-primary/10 shadow-md">
                                    <svg class="w-full h-full text-brand-ink" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M2 2h6v6H2V2zm1 1v4h4V3H3zm13-1h6v6h-6V2zm1 1v4h4V3h-4zM2 16h6v6H2v-6zm1 1v4h4v-4H3zm15 1h2v2h-2v-2zm2-2h2v2h-2v-2zm-2-2h2v2h-2v-2zm-2 2h2v2h-2v-2zm-2-2h2v2h-2v-2zm2 4h2v2h-2v-2zm-4 0h2v2h-2v-2zm-2-2h2v2h-2v-2zm6-6h2v2h-2v-2zm-2 2h2v2h-2v-2zm-2-2h2v2h-2v-2zm-2 2h2v2h-2v-2zm-2-2h2v2h-2v-2zm-2 2h2v2h-2v-2zm6-4h2v2h-2v-2zm-2-2h2v2H8V8zm-2 2h2v2H6v-2zM4 4h2v2H4V4zm14 0h2v2h-2V4zM4 18h2v2H4v-2z"/>
                                    </svg>
                                </div>
                                <span class="text-caption text-brand-ink/60 text-center px-4">Pindai kode QRIS simulasi ini menggunakan aplikasi E-Wallet pilihan Anda.</span>
                            </div>
                            
                            <!-- Tab Transfer Bank (with Accordion) -->
                            <div x-show="activeTab === 'transfer'" x-data="{ activeBank: null }" class="space-y-2.5" style="display: none;">
                                @php
                                    $banks = [
                                        'bca' => [
                                            'name' => 'Bank BCA',
                                            'number' => '8021234567',
                                            'holder' => 'Taqwa Movement Foundation'
                                        ],
                                        'mandiri' => [
                                            'name' => 'Bank Mandiri',
                                            'number' => '1370098765432',
                                            'holder' => 'Taqwa Movement Foundation'
                                        ],
                                        'bni' => [
                                            'name' => 'Bank BNI',
                                            'number' => '0213456789',
                                            'holder' => 'Taqwa Movement Foundation'
                                        ],
                                        'bri' => [
                                            'name' => 'Bank BRI',
                                            'number' => '002101234567890',
                                            'holder' => 'Taqwa Movement Foundation'
                                        ]
                                    ];
                                @endphp

                                @foreach($banks as $key => $bank)
                                    <div class="border border-brand-primary/10 rounded-xl overflow-hidden bg-brand-white/80 transition-all duration-300">
                                        <!-- Accordion Header -->
                                        <button 
                                            @click="activeBank = activeBank === '{{ $key }}' ? null : '{{ $key }}'"
                                            type="button"
                                            class="w-full flex items-center justify-between p-4 text-left focus:outline-none hover:bg-brand-primary/[0.02] transition-colors duration-200"
                                        >
                                            <span class="font-semibold text-brand-ink text-caption">{{ $bank['name'] }}</span>
                                            <svg 
                                                class="w-4 h-4 text-brand-ink/40 transition-transform duration-300"
                                                :class="activeBank === '{{ $key }}' ? 'transform rotate-180 text-brand-primary' : ''"
                                                fill="none" 
                                                stroke="currentColor" 
                                                viewBox="0 0 24 24"
                                            >
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        
                                        <!-- Accordion Body -->
                                        <div 
                                            x-show="activeBank === '{{ $key }}'"
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 max-h-0"
                                            x-transition:enter-end="opacity-100 max-h-40"
                                            class="px-4 pb-4 pt-1 border-t border-brand-primary/5 bg-brand-cream/[0.02] space-y-3"
                                            style="display: none;"
                                        >
                                            <div class="flex justify-between items-center text-caption">
                                                <span class="text-brand-ink/60">No. Rekening:</span>
                                                <div class="flex items-center gap-2">
                                                    <span class="font-bold text-brand-ink font-mono tracking-wide select-all">{{ $bank['number'] }}</span>
                                                    <button 
                                                        type="button"
                                                        @click="
                                                            navigator.clipboard.writeText('{{ $bank['number'] }}');
                                                            let original = $el.innerText;
                                                            $el.innerText = 'Tersalin';
                                                            setTimeout(() => $el.innerText = original, 2000);
                                                        "
                                                        class="text-[10px] bg-brand-primary/10 text-brand-primary px-2 py-0.5 rounded border border-brand-primary/15 font-bold hover:bg-brand-primary/20 transition-colors duration-200"
                                                    >
                                                        Salin
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="flex justify-between items-center text-[11px] text-brand-ink/50">
                                                <span>Nama Penerima:</span>
                                                <span class="font-semibold text-brand-ink">{{ $bank['holder'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Simulasi Form -->
                        <form action="{{ route('checkout.simulate-pay', $order->order_number) }}" method="POST" class="pt-2">
                            @csrf
                            <button 
                                type="submit"
                                class="w-full py-3.5 px-6 rounded-full text-brand-white bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600 font-semibold tracking-wide shadow-brand-soft hover:shadow-[0_12px_35px_rgba(16,185,129,0.35)] hover:scale-[1.02] active:scale-95 transition-all duration-300 flex items-center justify-center gap-2 text-caption"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Simulasi Bayar Sukses (Dev Mode)
                            </button>
                        </form>
                    </div>

                    <div class="space-y-3 pt-4">
                        @if($order->payment && isset($order->payment->raw_payload['snap_token']) && !str_starts_with($order->payment->raw_payload['snap_token'], 'mock-snap-token-'))
                            <x-ui.glass-button 
                                variant="accent"
                                onclick="payNow()"
                                class="w-full"
                            >
                                Bayar Sekarang (Midtrans)
                            </x-ui.glass-button>
                        @endif
                        <x-ui.glass-button 
                            variant="light"
                            href="/"
                            class="w-full text-brand-primary border border-brand-primary/10 hover:bg-brand-primary/5"
                        >
                            Kembali ke Home
                        </x-ui.glass-button>
                    </div>
                </div>

                <!-- Success State Header -->
                <div id="status-paid" class="{{ $order->status === 'paid' ? '' : 'hidden' }} space-y-6">
                    <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full border border-emerald-200 flex items-center justify-center mx-auto text-4xl shadow-md">
                        ✓
                    </div>
                    <div class="space-y-2">
                        <h1 class="font-serif text-h2 text-brand-primary font-bold">Alhamdulillah, Pembayaran Sukses!</h1>
                        <p class="text-body text-brand-ink/70">Pendaftaran Anda telah terkonfirmasi. E-Ticket resmi telah dikirim ke email Anda.</p>
                    </div>
                    <div class="p-4 bg-emerald-50/50 border border-emerald-200/50 rounded-2xl text-left space-y-2 text-caption">
                        <div class="flex justify-between text-brand-ink/70">
                            <span>Nama Peserta:</span>
                            <span class="font-semibold text-brand-ink">{{ $order->user?->name ?? $order->items->first()?->attendee_name ?? 'Guest' }}</span>
                        </div>
                        <div class="flex justify-between text-brand-ink/70">
                            <span>Event:</span>
                            <span class="font-semibold text-brand-ink text-right max-w-[70%] truncate">{{ $event->title }}</span>
                        </div>
                    </div>

                    <div class="space-y-3 pt-4">
                        @auth
                            <x-ui.glass-button 
                                variant="accent"
                                href="/dashboard/tiket-saya"
                                class="w-full"
                            >
                                Lihat Tiket Saya
                            </x-ui.glass-button>
                        @endauth
                        <x-ui.glass-button 
                            variant="light"
                            href="/"
                            class="w-full text-brand-primary border border-brand-primary/10 hover:bg-brand-primary/5"
                        >
                            Kembali ke Home
                        </x-ui.glass-button>
                    </div>
                </div>

                <!-- Failed / Expired State Header -->
                <div id="status-failed" class="{{ in_array($order->status, ['failed', 'expired', 'cancelled']) ? '' : 'hidden' }} space-y-6">
                    <div class="w-20 h-20 bg-rose-100 text-rose-600 rounded-full border border-rose-200 flex items-center justify-center mx-auto text-4xl">
                        ✕
                    </div>
                    <div class="space-y-2">
                        <h1 class="font-serif text-h2 text-rose-700 font-bold">Transaksi Kedaluwarsa / Batal</h1>
                        <p class="text-body text-brand-ink/70">Batas waktu pembayaran telah habis atau pesanan Anda dibatalkan.</p>
                    </div>

                    <div class="space-y-3 pt-4">
                        <x-ui.glass-button 
                            variant="accent"
                            href="{{ url('/event/'.$event->slug.'#ticket-section') }}"
                            class="w-full"
                        >
                            Daftar Ulang Event
                        </x-ui.glass-button>
                        <x-ui.glass-button 
                            variant="light"
                            href="/"
                            class="w-full text-brand-primary border border-brand-primary/10 hover:bg-brand-primary/5"
                        >
                            Kembali ke Home
                        </x-ui.glass-button>
                    </div>
                </div>

            </x-ui.glass-card>
        </div>
    </section>

    @push('scripts')
        @if($order->status === 'pending')
            <!-- Load Midtrans Snap client library -->
            <script 
                src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" 
                data-client-key="{{ config('services.midtrans.client_key') }}"
            ></script>

            <script>
                // Instantly trigger Midtrans Snap popup on load if it is a real Midtrans token
                window.onload = function() {
                    let snapToken = '{{ $order->payment?->raw_payload["snap_token"] ?? "" }}';
                    if (snapToken && !snapToken.startsWith('mock-snap-token-')) {
                        payNow();
                    }
                };

                function payNow() {
                    let snapToken = '{{ $order->payment?->raw_payload["snap_token"] ?? "" }}';
                    if (snapToken.startsWith('mock-snap-token-')) {
                        return;
                    }
                    if (typeof snap !== 'undefined') {
                        snap.pay(snapToken, {
                            onSuccess: function(result) {
                                checkStatusOnce();
                            },
                            onPending: function(result) {
                                checkStatusOnce();
                            },
                            onError: function(result) {
                                checkStatusOnce();
                            },
                            onClose: function() {
                                checkStatusOnce();
                            }
                        });
                    }
                }

                // AJAX Polling logic
                let pollingInterval = setInterval(checkStatusOnce, 3000);

                function checkStatusOnce() {
                    fetch('{{ route("checkout.status.json", $order->order_number) }}')
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'paid') {
                                clearInterval(pollingInterval);
                                document.getElementById('status-pending').classList.add('hidden');
                                document.getElementById('status-paid').classList.remove('hidden');
                            } else if (data.status === 'expired' || data.status === 'failed' || data.status === 'cancelled') {
                                clearInterval(pollingInterval);
                                document.getElementById('status-pending').classList.add('hidden');
                                document.getElementById('status-failed').classList.remove('hidden');
                            }
                        })
                        .catch(error => console.error('Polling error:', error));
                }
            </script>
        @endif
    @endpush
</x-layouts.app>
