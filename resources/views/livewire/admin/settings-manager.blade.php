<div class="space-y-8">
    <!-- Success Banner -->
    @if (session()->has('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 text-caption font-semibold flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Tab Headers Nav -->
    <div class="border-b border-slate-200">
        <nav class="flex gap-6 -mb-px" aria-label="Tabs">
            <button 
                wire:click="setTab('general')" 
                type="button"
                :class="'{{ $activeTab }}' === 'general' ? 'border-brand-primary text-brand-primary' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                class="py-4 px-1 border-b-2 font-medium text-caption focus:outline-none transition-all"
            >
                Informasi Umum
            </button>
            <button 
                wire:click="setTab('socials')" 
                type="button"
                :class="'{{ $activeTab }}' === 'socials' ? 'border-brand-primary text-brand-primary' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                class="py-4 px-1 border-b-2 font-medium text-caption focus:outline-none transition-all"
            >
                Sosial Media & Integrasi
            </button>
        </nav>
    </div>

    <!-- Settings Form -->
    <form wire:submit.prevent="save" class="bg-brand-white border border-slate-200 p-8 rounded-3xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] space-y-6">
        
        <!-- TAB 1: GENERAL SETTINGS -->
        <div x-show="'{{ $activeTab }}' === 'general'" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Site Name -->
                <div class="space-y-1">
                    <label for="settings-sitename" class="text-caption font-semibold text-brand-ink/80 block">Nama Website / Organisasi</label>
                    <input 
                        id="settings-sitename"
                        wire:model.defer="site_name" 
                        type="text" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    />
                    @error('site_name') <span class="text-xs text-red-600 block mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Site Tagline -->
                <div class="space-y-1">
                    <label for="settings-tagline" class="text-caption font-semibold text-brand-ink/80 block">Slogan / Tagline</label>
                    <input 
                        id="settings-tagline"
                        wire:model.defer="site_tagline" 
                        type="text" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    />
                    @error('site_tagline') <span class="text-xs text-red-600 block mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Site Description -->
            <div class="space-y-1">
                <label for="settings-description" class="text-caption font-semibold text-brand-ink/80 block">Deskripsi Singkat Meta</label>
                <textarea 
                    id="settings-description"
                    wire:model.defer="site_description" 
                    rows="3"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                ></textarea>
                @error('site_description') <span class="text-xs text-red-600 block mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Phone -->
                <div class="space-y-1">
                    <label for="settings-phone" class="text-caption font-semibold text-brand-ink/80 block">Nomor WhatsApp Hotline</label>
                    <input 
                        id="settings-phone"
                        wire:model.defer="phone" 
                        type="text" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    />
                    @error('phone') <span class="text-xs text-red-600 block mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div class="space-y-1">
                    <label for="settings-email" class="text-caption font-semibold text-brand-ink/80 block">Alamat Email Umum</label>
                    <input 
                        id="settings-email"
                        wire:model.defer="email" 
                        type="email" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    />
                    @error('email') <span class="text-xs text-red-600 block mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Address -->
            <div class="space-y-1">
                <label for="settings-address" class="text-caption font-semibold text-brand-ink/80 block">Alamat Kantor Pusat</label>
                <textarea 
                    id="settings-address"
                    wire:model.defer="address" 
                    rows="2"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                ></textarea>
                @error('address') <span class="text-xs text-red-600 block mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- TAB 2: SOCIALS SETTINGS -->
        <div x-show="'{{ $activeTab }}' === 'socials'" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Instagram -->
                <div class="space-y-1">
                    <label for="settings-instagram" class="text-caption font-semibold text-brand-ink/80 block">Link Instagram</label>
                    <input 
                        id="settings-instagram"
                        wire:model.defer="instagram" 
                        type="url" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                        placeholder="https://instagram.com/username"
                    />
                    @error('instagram') <span class="text-xs text-red-600 block mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- TikTok -->
                <div class="space-y-1">
                    <label for="settings-tiktok" class="text-caption font-semibold text-brand-ink/80 block">Link TikTok</label>
                    <input 
                        id="settings-tiktok"
                        wire:model.defer="tiktok" 
                        type="url" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                        placeholder="https://tiktok.com/@username"
                    />
                    @error('tiktok') <span class="text-xs text-red-600 block mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- YouTube -->
                <div class="space-y-1">
                    <label for="settings-youtube" class="text-caption font-semibold text-brand-ink/80 block">Link Channel YouTube</label>
                    <input 
                        id="settings-youtube"
                        wire:model.defer="youtube" 
                        type="url" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                        placeholder="https://youtube.com/c/channelname"
                    />
                    @error('youtube') <span class="text-xs text-red-600 block mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Facebook -->
                <div class="space-y-1">
                    <label for="settings-facebook" class="text-caption font-semibold text-brand-ink/80 block">Link Facebook</label>
                    <input 
                        id="settings-facebook"
                        wire:model.defer="facebook" 
                        type="url" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                        placeholder="https://facebook.com/username"
                    />
                    @error('facebook') <span class="text-xs text-red-600 block mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Twitter/X -->
                <div class="space-y-1">
                    <label for="settings-twitter" class="text-caption font-semibold text-brand-ink/80 block">Link Twitter / X</label>
                    <input 
                        id="settings-twitter"
                        wire:model.defer="twitter" 
                        type="url" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                        placeholder="https://twitter.com/username"
                    />
                    @error('twitter') <span class="text-xs text-red-600 block mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- WhatsApp Link -->
                <div class="space-y-1">
                    <label for="settings-whatsapp" class="text-caption font-semibold text-brand-ink/80 block">Link WhatsApp Direct</label>
                    <input 
                        id="settings-whatsapp"
                        wire:model.defer="whatsapp_link" 
                        type="url" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                        placeholder="https://wa.me/6281234567890"
                    />
                    @error('whatsapp_link') <span class="text-xs text-red-600 block mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Google Maps Direction URL -->
                <div class="space-y-1 col-span-2">
                    <label for="settings-maps" class="text-caption font-semibold text-brand-ink/80 block">Link Google Maps Kantor</label>
                    <input 
                        id="settings-maps"
                        wire:model.defer="map_link" 
                        type="url" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                        placeholder="https://goo.gl/maps/..."
                    />
                    @error('map_link') <span class="text-xs text-red-600 block mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="pt-6 border-t border-slate-200 flex justify-end">
            <button 
                type="submit" 
                class="px-8 py-3 rounded-full bg-brand-primary hover:bg-brand-secondary text-brand-white text-caption font-bold shadow-brand-soft hover:shadow-[0_12px_35px_rgba(80,46,136,0.15)] transition-all duration-300"
            >
                Simpan Pengaturan
            </button>
        </div>

    </form>
</div>
