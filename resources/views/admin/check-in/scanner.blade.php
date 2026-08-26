<x-layouts.app>
    @section('title', 'Check-In Scanner - Taqwa Movement')

    <section class="py-20 bg-mesh-glow text-brand-white min-h-[85vh] flex items-center justify-center relative overflow-hidden">
        <div class="max-w-4xl w-full mx-auto px-6 relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
            
            <!-- Left: QR Video Scanner -->
            <div class="lg:col-span-7 flex flex-col justify-between space-y-4">
                <x-ui.glass-card dark="true" class="p-6 border border-brand-white/10 flex-grow flex flex-col justify-center">
                    <div class="text-center space-y-2 mb-6">
                        <h1 class="font-serif text-h2 text-brand-gold font-bold">QR Check-In Scanner</h1>
                        <p class="text-xs text-brand-white/60">Arahkan QR Code tiket peserta ke kamera di bawah ini</p>
                    </div>

                    <!-- Scanner Video Reader Container -->
                    <div class="relative max-w-sm mx-auto w-full aspect-square rounded-2xl overflow-hidden border-2 border-brand-accent/30 bg-black/40">
                        <div id="reader" class="w-full h-full"></div>
                    </div>
                </x-ui.glass-card>
            </div>

            <!-- Right: Results Panel -->
            <div class="lg:col-span-5">
                <x-ui.glass-card dark="true" class="p-6 border border-brand-white/10 h-full flex flex-col justify-between space-y-6">
                    <div class="space-y-4">
                        <h3 class="font-serif text-body-lg font-bold text-brand-white border-b border-brand-white/5 pb-2">Status Pemindaian</h3>
                        
                        <!-- Initial / Idle State -->
                        <div id="scan-idle" class="text-center py-12 space-y-3">
                            <span class="text-4xl block animate-pulse">📷</span>
                            <p class="text-caption text-brand-white/50 text-xs">Menunggu QR Code dipindai...</p>
                        </div>

                        <!-- Success Feedback Panel -->
                        <div id="scan-success" class="hidden p-6 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl text-center space-y-4 shadow-glow">
                            <div class="w-12 h-12 bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 rounded-full flex items-center justify-center text-xl font-bold mx-auto">
                                ✓
                            </div>
                            <div>
                                <h4 class="font-bold text-emerald-300 uppercase tracking-wide text-xs">Check-In Berhasil!</h4>
                                <h3 id="res-name" class="font-serif font-bold text-brand-white text-lg mt-2">Nama Peserta</h3>
                                <p id="res-email" class="text-xs text-brand-white/70">email@example.com</p>
                            </div>
                            <div class="text-xs border-t border-emerald-500/20 pt-3">
                                <span class="text-brand-white/40 block">KODE TIKET</span>
                                <span id="res-code" class="font-mono text-brand-gold font-bold tracking-wider">TQW-ABC-123</span>
                            </div>
                        </div>

                        <!-- Error Feedback Panel -->
                        <div id="scan-error" class="hidden p-6 bg-rose-500/10 border border-rose-500/30 rounded-2xl text-center space-y-3">
                            <div class="w-12 h-12 bg-rose-500/20 text-rose-400 border border-rose-500/30 rounded-full flex items-center justify-center text-xl font-bold mx-auto">
                                ✕
                            </div>
                            <div>
                                <h4 class="font-bold text-rose-300 uppercase tracking-wide text-xs">Registrasi Gagal</h4>
                                <p id="err-message" class="text-caption text-brand-white/80 mt-2 text-xs leading-relaxed">Pesan error detil.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Controls -->
                    <div class="pt-4 border-t border-brand-white/5">
                        <x-ui.glass-button 
                            variant="light"
                            onclick="resetScannerUI()"
                            class="w-full text-brand-white"
                        >
                            Reset Kamera & Pemindai
                        </x-ui.glass-button>
                    </div>
                </x-ui.glass-card>
            </div>

        </div>
    </section>

    @push('scripts')
        <!-- Load HTML5-QRCode scanner library from CDN -->
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

        <script>
            let html5QrcodeScanner = null;
            let lastScannedPayload = null;

            window.onload = function() {
                startScanner();
            };

            function startScanner() {
                html5QrcodeScanner = new Html5Qrcode("reader");
                
                const config = { 
                    fps: 10, 
                    qrbox: { width: 250, height: 250 } 
                };

                html5QrcodeScanner.start(
                    { facingMode: "environment" }, 
                    config, 
                    onScanSuccess,
                    onScanFailure
                ).catch(err => {
                    console.error("Unable to start scanner:", err);
                });
            }

            function onScanSuccess(decodedText, decodedResult) {
                if (decodedText === lastScannedPayload) {
                    return; // Avoid double requests for the same code while scanner is running
                }

                lastScannedPayload = decodedText;
                
                // Play notification sound
                playBeep();

                // Send code to server for validation
                fetch('{{ route("admin.check-in.scan") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ qr_payload: decodedText })
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('scan-idle').classList.add('hidden');
                    if (data.status === 'success') {
                        document.getElementById('scan-error').classList.add('hidden');
                        
                        document.getElementById('res-name').innerText = data.attendee_name;
                        document.getElementById('res-email').innerText = data.attendee_email;
                        document.getElementById('res-code').innerText = data.ticket_code;
                        
                        document.getElementById('scan-success').classList.remove('hidden');
                    } else {
                        document.getElementById('scan-success').classList.add('hidden');
                        document.getElementById('err-message').innerText = data.message;
                        document.getElementById('scan-error').classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error("Callback check-in error:", error);
                    document.getElementById('scan-idle').classList.add('hidden');
                    document.getElementById('scan-success').classList.add('hidden');
                    document.getElementById('err-message').innerText = "Gagal memproses data pemindaian (koneksi bermasalah).";
                    document.getElementById('scan-error').classList.remove('hidden');
                });
            }

            function onScanFailure(error) {
                // Non-verbose, ignore scanning failures on each frame
            }

            function resetScannerUI() {
                lastScannedPayload = null;
                document.getElementById('scan-success').classList.add('hidden');
                document.getElementById('scan-error').classList.add('hidden');
                document.getElementById('scan-idle').classList.remove('hidden');
            }

            function playBeep() {
                try {
                    let context = new (window.AudioContext || window.webkitAudioContext)();
                    let osc = context.createOscillator();
                    osc.type = "sine";
                    osc.frequency.setValueAtTime(800, context.currentTime); // 800Hz beep frequency
                    osc.connect(context.destination);
                    osc.start();
                    osc.stop(context.currentTime + 0.15); // play for 150ms
                } catch(e) {
                    console.error("Audio Context is blocked or not supported", e);
                }
            }
        </script>
    @endpush
</x-layouts.app>
