<div class="bg-brand-white p-8 md:p-10 rounded-3xl border border-brand-blush-lt/30 shadow-brand-soft">
    @if ($successMessage)
        <!-- Success Banner -->
        <div class="text-center py-10 space-y-6">
            <span class="w-16 h-16 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-full flex items-center justify-center mx-auto text-h2">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            </span>
            <div class="space-y-2">
                <h3 class="font-serif text-h3 font-bold text-brand-primary">Pesan Terkirim!</h3>
                <p class="text-body text-brand-ink/75 max-w-md mx-auto leading-relaxed">
                    {{ $successMessage }}
                </p>
            </div>
            <button 
                wire:click="$set('successMessage', '')" 
                type="button" 
                class="inline-flex items-center justify-center px-6 py-2.5 rounded-full text-caption font-semibold text-brand-primary border border-brand-primary/10 hover:bg-brand-primary/5 transition-all"
            >
                Kirim Pesan Lain
            </button>
        </div>
    @else
        <!-- Contact Form -->
        <form wire:submit.prevent="submit" class="space-y-6">
            
            <!-- Honeypot Field (Hidden from human eyes) -->
            <div class="hidden" aria-hidden="true" style="display: none !important;">
                <label for="contact-form-hp">Leave this field blank</label>
                <input 
                    id="contact-form-hp"
                    type="text" 
                    wire:model="honeypot" 
                    tabindex="-1" 
                    autocomplete="off" 
                />
            </div>

            <!-- Name Input -->
            <div class="space-y-1">
                <label for="contact-name" class="text-caption font-semibold text-brand-ink/80 block">Nama Lengkap</label>
                <input 
                    id="contact-name"
                    wire:model.defer="name" 
                    type="text" 
                    class="w-full px-4 py-3 rounded-xl border border-brand-blush-lt/30 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/50 text-body bg-brand-white"
                    placeholder="Masukkan nama lengkap Anda"
                    required
                />
                @error('name') <span class="text-xs text-red-600 font-medium block mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Email Input -->
                <div class="space-y-1">
                    <label for="contact-email" class="text-caption font-semibold text-brand-ink/80 block">Alamat Email</label>
                    <input 
                        id="contact-email"
                        wire:model.defer="email" 
                        type="email" 
                        class="w-full px-4 py-3 rounded-xl border border-brand-blush-lt/30 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/50 text-body bg-brand-white"
                        placeholder="nama@email.com"
                        required
                    />
                    @error('email') <span class="text-xs text-red-600 font-medium block mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Phone Input -->
                <div class="space-y-1">
                    <label for="contact-phone" class="text-caption font-semibold text-brand-ink/80 block">Nomor WhatsApp (Opsional)</label>
                    <input 
                        id="contact-phone"
                        wire:model.defer="phone" 
                        type="tel" 
                        class="w-full px-4 py-3 rounded-xl border border-brand-blush-lt/30 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/50 text-body bg-brand-white"
                        placeholder="081234567890"
                    />
                    @error('phone') <span class="text-xs text-red-600 font-medium block mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Message Input -->
            <div class="space-y-1">
                <label for="contact-message" class="text-caption font-semibold text-brand-ink/80 block">Isi Pesan / Pertanyaan</label>
                <textarea 
                    id="contact-message"
                    wire:model.defer="message" 
                    rows="5"
                    class="w-full px-4 py-3 rounded-xl border border-brand-blush-lt/30 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/50 text-body bg-brand-white"
                    placeholder="Tuliskan pertanyaan atau kendala yang ingin Anda tanyakan..."
                    required
                ></textarea>
                @error('message') <span class="text-xs text-red-600 font-medium block mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button with loading triggers -->
            <button 
                type="submit" 
                wire:loading.attr="disabled"
                class="w-full inline-flex items-center justify-center px-8 py-4 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-bold tracking-wide shadow-brand-soft hover:-translate-y-0.5 transition-all duration-300 disabled:opacity-55 focus:outline-none"
            >
                <span wire:loading.remove>Kirim Pesan</span>
                <span wire:loading>Sedang Mengirim...</span>
            </button>
        </form>
    @endif
</div>
