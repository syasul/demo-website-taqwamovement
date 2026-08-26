<div class="space-y-12">
    <!-- Error Alert Box -->
    @if ($validationError)
        <div class="p-4 bg-rose-50 border border-rose-100 text-rose-700 text-caption rounded-2xl flex items-start gap-3 shadow-sm animate-fade-in">
            <svg class="w-5 h-5 shrink-0 mt-0.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <span class="font-medium">{{ $validationError }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
        
        <!-- Left: Ticket Selector & Attendee Form -->
        <div class="lg:col-span-8 space-y-12">
            <!-- Ticket Type Selector Cards -->
            <div class="space-y-6">
                <div class="border-b border-brand-blush-lt/10 pb-4">
                    <h2 class="font-serif text-h3 text-brand-primary font-bold">1. Pilih Kategori Tiket</h2>
                    <p class="text-caption text-brand-ink/60">Tentukan jumlah tiket yang ingin Anda pesan.</p>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    @foreach ($ticketTypes as $type)
                        @php
                            $available = $type->available_stock;
                            $isSoldOut = $available <= 0;
                            $isSelected = ($quantities[$type->id] ?? 0) > 0;
                        @endphp
                        <x-ui.glass-card 
                            class="transition-all duration-300 border flex flex-col md:flex-row md:items-center justify-between gap-6 p-6 rounded-2xl {{ $isSelected ? 'border-brand-primary/40 bg-brand-primary/5 shadow-brand-soft' : 'border-brand-primary/10 bg-brand-white/40 hover:border-brand-primary/25' }}"
                        >
                            <div class="space-y-3 flex-grow">
                                <div class="flex flex-wrap items-center gap-3">
                                    <h3 class="font-serif text-body-lg font-bold text-brand-primary">{{ $type->name }}</h3>
                                    @if($isSoldOut)
                                        <span class="bg-rose-50 border border-rose-100 text-rose-600 text-[10px] px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider">Sold Out</span>
                                    @else
                                        <span class="bg-emerald-50 border border-emerald-100 text-emerald-600 text-[10px] px-2.5 py-0.5 rounded-full font-semibold">Tersisa {{ $available }} tiket</span>
                                    @endif
                                </div>
                                <p class="text-caption text-brand-ink/70 leading-relaxed">{{ $type->description }}</p>
                            </div>
                            
                            <div class="flex items-center justify-between md:justify-end gap-6 shrink-0 border-t md:border-t-0 pt-4 md:pt-0 border-brand-blush-lt/10">
                                <div class="text-left md:text-right">
                                    <span class="text-xs text-brand-ink/40 block font-medium">Harga Per Tiket</span>
                                    <span class="text-body-lg font-bold text-brand-primary">Rp {{ number_format($type->price, 0, ',', '.') }}</span>
                                </div>
                                
                                 @if(!$isSoldOut)
                                    <div class="flex items-center gap-3 bg-brand-white/60 border border-brand-primary/10 rounded-full p-1.5 shadow-sm">
                                        <button 
                                            type="button"
                                            wire:click="decrementTicket({{ $type->id }})"
                                            class="w-8 h-8 rounded-full bg-brand-white border border-brand-primary/10 hover:border-brand-primary hover:bg-brand-primary/5 text-brand-primary flex items-center justify-center transition-all duration-200 focus:outline-none disabled:opacity-40 disabled:cursor-not-allowed"
                                            {{ ($quantities[$type->id] ?? 0) <= 0 ? 'disabled' : '' }}
                                            aria-label="Kurangi tiket"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path></svg>
                                        </button>
                                        <span class="w-6 text-center text-caption font-bold text-brand-primary select-none">
                                            {{ $quantities[$type->id] ?? 0 }}
                                        </span>
                                        <button 
                                            type="button"
                                            wire:click="incrementTicket({{ $type->id }})"
                                            class="w-8 h-8 rounded-full bg-brand-primary hover:bg-brand-secondary text-brand-white flex items-center justify-center transition-all duration-200 focus:outline-none disabled:opacity-40 disabled:cursor-not-allowed shadow-sm"
                                            {{ ($quantities[$type->id] ?? 0) >= min($available, $type->max_per_transaction) ? 'disabled' : '' }}
                                            aria-label="Tambah tiket"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                        </button>
                                    </div>
                                @else
                                    <span class="text-caption text-brand-ink/40 font-semibold px-5 py-2.5 border border-dashed border-brand-ink/20 rounded-full bg-slate-50">Habis</span>
                                @endif
                            </div>
                        </x-ui.glass-card>
                    @endforeach
                </div>
            </div>

            <!-- Dynamic Attendee Form Fields -->
            @if (count($attendees) > 0)
                <div class="space-y-6 animate-fade-in">
                    <div class="border-b border-brand-blush-lt/10 pb-4">
                        <h2 class="font-serif text-h3 text-brand-primary font-bold">2. Data Diri Peserta</h2>
                        <p class="text-caption text-brand-ink/60">Lengkapi data masing-masing peserta untuk keperluan pencetakan E-Tiket.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach ($attendees as $index => $attendee)
                            @php
                                $ticketName = $ticketTypes->firstWhere('id', $attendee['ticket_type_id'])?->name ?? 'Tiket';
                            @endphp
                            <x-ui.glass-card class="space-y-5 border border-brand-accent/20 relative pt-8 bg-brand-white/60">
                                <div class="absolute -top-3.5 left-6 px-4 py-1 rounded-full bg-brand-primary text-brand-white text-xs font-bold shadow-md">
                                    Peserta #{{ $index + 1 }}
                                </div>
                                
                                <div class="text-xs font-semibold text-brand-primary/80 border-b border-brand-blush-lt/10 pb-2 flex justify-between items-center">
                                    <span>Tipe: {{ $ticketName }}</span>
                                    <span class="w-2.5 h-2.5 rounded-full bg-brand-accent"></span>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-caption text-brand-ink/70 mb-1.5 font-semibold">Nama Lengkap</label>
                                        <input 
                                            type="text" 
                                            wire:model.blur="attendees.{{ $index }}.name" 
                                            placeholder="Nama lengkap sesuai KTP/Passport"
                                            class="w-full bg-brand-white border border-brand-primary/20 rounded-xl px-4 py-3 text-caption text-brand-ink placeholder-brand-ink/30 focus:ring-2 focus:ring-brand-accent focus:border-brand-accent focus:outline-none transition-all duration-300"
                                        />
                                        @error("attendees.{$index}.name")
                                            <span class="text-rose-500 text-xs mt-1.5 block font-medium">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-caption text-brand-ink/70 mb-1.5 font-semibold">Alamat Email</label>
                                        <input 
                                            type="email" 
                                            wire:model.blur="attendees.{{ $index }}.email" 
                                            placeholder="Contoh: nama@domain.com"
                                            class="w-full bg-brand-white border border-brand-primary/20 rounded-xl px-4 py-3 text-caption text-brand-ink placeholder-brand-ink/30 focus:ring-2 focus:ring-brand-accent focus:border-brand-accent focus:outline-none transition-all duration-300"
                                        />
                                        @error("attendees.{$index}.email")
                                            <span class="text-rose-500 text-xs mt-1.5 block font-medium">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </x-ui.glass-card>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Right: Order Summary sticky block -->
        <div class="lg:col-span-4 lg:sticky lg:top-28">
            <x-ui.glass-card class="space-y-6 border border-brand-primary/10 bg-brand-white/40 shadow-brand-soft">
                <h3 class="font-serif text-body-lg font-bold text-brand-primary border-b border-brand-blush-lt/10 pb-3">Ringkasan Pemesanan</h3>
                
                <!-- Ticket Breakdown lines -->
                <div class="space-y-4 text-caption text-brand-ink/80">
                    @php $hasTickets = false; @endphp
                    @foreach ($quantities as $typeId => $qty)
                        @if ($qty > 0)
                            @php
                                $type = $ticketTypes->firstWhere('id', intval($typeId));
                                $hasTickets = true;
                            @endphp
                            <div class="flex justify-between items-start gap-4">
                                <span class="font-medium text-brand-ink/80">{{ $type?->name }} <strong class="text-brand-primary">x{{ $qty }}</strong></span>
                                <span class="font-bold text-brand-primary">Rp {{ number_format(($type?->price ?? 0) * $qty, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    @endforeach

                    @if (!$hasTickets)
                        <div class="text-center py-8 text-brand-ink/40 space-y-2">
                            <svg class="w-10 h-10 mx-auto text-brand-ink/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            <p class="font-medium">Belum ada tiket terpilih.</p>
                        </div>
                    @endif
                </div>

                @if ($hasTickets)
                    <!-- Promo Code Input Form -->
                    <div class="pt-5 border-t border-brand-blush-lt/10 space-y-3">
                        <label class="block text-caption text-brand-ink/70 font-semibold">Gunakan Kode Promo</label>
                        @if ($appliedPromo)
                            <div class="flex items-center justify-between p-3 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-xs font-bold">
                                <span class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Kupon: {{ $appliedPromo->code }}
                                </span>
                                <button type="button" wire:click="removePromo" class="text-rose-600 hover:text-rose-800 font-bold ml-2 transition-colors focus:outline-none">Hapus</button>
                            </div>
                        @else
                            <div class="flex gap-2">
                                <input 
                                    type="text" 
                                    wire:model="promoCode" 
                                    placeholder="KODEPROMO"
                                    class="flex-grow bg-brand-white border border-brand-primary/20 rounded-xl px-4 py-2.5 text-caption font-semibold uppercase placeholder-brand-ink/30 focus:ring-2 focus:ring-brand-accent focus:border-brand-accent focus:outline-none transition-all duration-300"
                                />
                                <button 
                                    type="button" 
                                    wire:click="applyPromo"
                                    class="px-5 py-2.5 rounded-xl bg-brand-primary hover:bg-brand-secondary text-brand-white text-caption font-bold transition-all duration-300 focus:outline-none shadow-sm hover:shadow"
                                >
                                    Gunakan
                                </button>
                            </div>
                        @endif

                        @if ($promoError)
                            <span class="text-rose-500 text-xs mt-1.5 block font-medium">{{ $promoError }}</span>
                        @endif
                        @if ($promoSuccess)
                            <span class="text-emerald-600 text-xs mt-1.5 block font-bold">{{ $promoSuccess }}</span>
                        @endif
                    </div>

                    <!-- Payment breakdown totals -->
                    <div class="pt-5 border-t border-brand-blush-lt/10 space-y-3.5 text-caption text-brand-ink/75">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-bold text-brand-primary">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        @if ($discountAmount > 0)
                            <div class="flex justify-between text-emerald-600 font-bold">
                                <span>Potongan Kupon</span>
                                <span>- Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span>Biaya Admin Gateway</span>
                            <span class="font-bold text-brand-primary">Rp {{ number_format($adminFee, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-body-lg font-bold text-brand-primary border-t border-brand-primary/10 pt-4 mt-2">
                            <span>Total Bayar</span>
                            <span class="text-brand-accent text-body-lg font-extrabold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Checkout CTA Button -->
                    <div class="pt-6">
                        <x-ui.glass-button 
                            variant="accent"
                            wire:click="submitBooking" 
                            class="w-full py-3.5 justify-center flex gap-2 font-bold tracking-wide"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove>Lanjut Pembayaran</span>
                            <span wire:loading class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Memproses Order...
                            </span>
                        </x-ui.glass-button>
                    </div>
                @endif
            </x-ui.glass-card>
        </div>

    </div>
</div>
