<x-layouts.app>
    @section('title', 'Status Pembayaran - Taqwa Movement')

    <section class="min-h-[80vh] py-20 bg-mesh-glow text-brand-white flex items-center justify-center relative overflow-hidden">
        <div class="max-w-xl w-full mx-auto px-6 relative z-10">
            <x-ui.glass-card dark="true" class="text-center space-y-8 p-10 border border-brand-white/10 shadow-glow">
                
                <!-- Pending State Header -->
                <div id="status-pending" class="{{ $order->status === 'pending' ? '' : 'hidden' }} space-y-6">
                    <div class="relative w-20 h-20 mx-auto">
                        <div class="absolute inset-0 border-4 border-brand-accent/20 rounded-full"></div>
                        <div class="absolute inset-0 border-4 border-t-brand-accent rounded-full animate-spin"></div>
                    </div>
                    <div class="space-y-2">
                        <h1 class="font-serif text-h2 text-brand-gold font-bold">Menunggu Pembayaran</h1>
                        <p class="text-body text-brand-white/70">Kami sedang menunggu konfirmasi pembayaran dari sistem payment gateway.</p>
                    </div>
                    <div class="p-4 bg-brand-white/5 border border-brand-white/10 rounded-2xl text-left space-y-2 text-caption">
                        <div class="flex justify-between">
                            <span class="text-brand-white/55">No. Transaksi:</span>
                            <span class="font-semibold text-brand-gold">{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-brand-white/55">Total Tagihan:</span>
                            <span class="font-bold text-brand-accent">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="space-y-3 pt-4">
                        @if($order->payment && isset($order->payment->raw_payload['snap_token']))
                            <x-ui.glass-button 
                                variant="accent"
                                onclick="payNow()"
                                class="w-full"
                            >
                                Bayar Sekarang
                            </x-ui.glass-button>
                        @endif
                        <x-ui.glass-button 
                            variant="light"
                            href="/"
                            class="w-full text-brand-white"
                        >
                            Kembali ke Home
                        </x-ui.glass-button>
                    </div>
                </div>

                <!-- Success State Header -->
                <div id="status-paid" class="{{ $order->status === 'paid' ? '' : 'hidden' }} space-y-6">
                    <div class="w-20 h-20 bg-emerald-500/20 text-emerald-400 rounded-full border border-emerald-500/30 flex items-center justify-center mx-auto text-4xl shadow-glow">
                        ✓
                    </div>
                    <div class="space-y-2">
                        <h1 class="font-serif text-h2 text-brand-gold font-bold font-serif">Alhamdulillah, Pembayaran Sukses!</h1>
                        <p class="text-body text-brand-white/70">Pendaftaran Anda telah terkonfirmasi. E-Ticket resmi telah dikirim ke email Anda.</p>
                    </div>
                    <div class="p-4 bg-emerald-500/5 border border-emerald-500/10 rounded-2xl text-left space-y-2 text-caption">
                        <div class="flex justify-between text-brand-white/70">
                            <span>Nama Peserta:</span>
                            <span class="font-semibold text-brand-white">{{ auth()->user()->name }}</span>
                        </div>
                        <div class="flex justify-between text-brand-white/70">
                            <span>Event:</span>
                            <span class="font-semibold text-brand-white text-right max-w-[70%] truncate">{{ $event->title }}</span>
                        </div>
                    </div>

                    <div class="space-y-3 pt-4">
                        <!-- We will add the my-tickets route next in Phase 5! -->
                        <x-ui.glass-button 
                            variant="light"
                            href="/dashboard/tiket-saya"
                            class="w-full text-brand-primary"
                        >
                            Lihat Tiket Saya
                        </x-ui.glass-button>
                        <x-ui.glass-button 
                            variant="light"
                            href="/"
                            class="w-full text-brand-white"
                        >
                            Kembali ke Home
                        </x-ui.glass-button>
                    </div>
                </div>

                <!-- Failed / Expired State Header -->
                <div id="status-failed" class="{{ in_array($order->status, ['failed', 'expired', 'cancelled']) ? '' : 'hidden' }} space-y-6">
                    <div class="w-20 h-20 bg-rose-500/20 text-rose-400 rounded-full border border-rose-500/30 flex items-center justify-center mx-auto text-4xl">
                        ✕
                    </div>
                    <div class="space-y-2">
                        <h1 class="font-serif text-h2 text-rose-300 font-bold">Transaksi Kedaluwarsa / Batal</h1>
                        <p class="text-body text-brand-white/70">Batas waktu pembayaran telah habis atau pesanan Anda dibatalkan.</p>
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
                            class="w-full text-brand-white"
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
                // Instantly trigger Midtrans Snap popup on load
                window.onload = function() {
                    payNow();
                };

                function payNow() {
                    if (typeof snap !== 'undefined') {
                        snap.pay('{{ $order->payment?->raw_payload["snap_token"] ?? "" }}', {
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
