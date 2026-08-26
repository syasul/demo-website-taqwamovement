<x-layouts.admin>
    @section('page_title', 'Tambah Kode Promo')

    <div class="mb-6">
        <a href="{{ route('admin.promo-codes.index') }}" class="text-caption font-semibold text-brand-primary hover:text-brand-secondary flex items-center gap-1.5 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Promo
        </a>
    </div>

    <div class="bg-brand-white border border-slate-200 rounded-2xl p-6 md:p-8 max-w-3xl shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
        <form action="{{ route('admin.promo-codes.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Promo Code -->
                <div class="md:col-span-2 space-y-1">
                    <label for="code" class="text-caption font-semibold text-brand-ink/80 block">Kode Promo</label>
                    <input 
                        type="text" 
                        id="code" 
                        name="code" 
                        required
                        value="{{ old('code') }}"
                        placeholder="e.g. TAQWAFEST (otomatis diubah ke huruf kapital)"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body uppercase font-bold tracking-wider"
                    />
                    @error('code') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Discount Type -->
                <div class="space-y-1">
                    <label for="discount_type" class="text-caption font-semibold text-brand-ink/80 block">Jenis Diskon</label>
                    <select 
                        id="discount_type" 
                        name="discount_type" 
                        required
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body bg-brand-white"
                    >
                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Nominal Tetap (Rp)</option>
                        <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                    </select>
                    @error('discount_type') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Discount Value -->
                <div class="space-y-1">
                    <label for="discount_value" class="text-caption font-semibold text-brand-ink/80 block">Nilai Diskon</label>
                    <input 
                        type="number" 
                        id="discount_value" 
                        name="discount_value" 
                        required
                        min="0"
                        value="{{ old('discount_value', 0) }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body font-bold text-brand-primary"
                    />
                    @error('discount_value') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Quota -->
                <div class="space-y-1">
                    <label for="quota" class="text-caption font-semibold text-brand-ink/80 block">Kuota Pemakaian</label>
                    <input 
                        type="number" 
                        id="quota" 
                        name="quota" 
                        required
                        min="0"
                        value="{{ old('quota', 50) }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    />
                    @error('quota') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Ticket Type Restriction -->
                <div class="space-y-1">
                    <label for="ticket_type_id" class="text-caption font-semibold text-brand-ink/80 block">Batasan Jenis Tiket</label>
                    <select 
                        id="ticket_type_id" 
                        name="ticket_type_id" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body bg-brand-white"
                    >
                        <option value="">Berlaku untuk Semua Jenis Tiket</option>
                        @foreach($ticketTypes as $type)
                            <option value="{{ $type->id }}" {{ old('ticket_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->event->title ?? '-' }} - {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('ticket_type_id') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Valid From -->
                <div class="space-y-1">
                    <label for="valid_from" class="text-caption font-semibold text-brand-ink/80 block">Jadwal Mulai Berlaku</label>
                    <input 
                        type="datetime-local" 
                        id="valid_from" 
                        name="valid_from" 
                        required
                        value="{{ old('valid_from') }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    />
                    @error('valid_from') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Valid Until -->
                <div class="space-y-1">
                    <label for="valid_until" class="text-caption font-semibold text-brand-ink/80 block">Jadwal Selesai Berlaku</label>
                    <input 
                        type="datetime-local" 
                        id="valid_until" 
                        name="valid_until" 
                        required
                        value="{{ old('valid_until') }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    />
                    @error('valid_until') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Submit buttons -->
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a 
                    href="{{ route('admin.promo-codes.index') }}" 
                    class="px-5 py-2.5 rounded-full border border-slate-200 text-brand-ink/70 hover:bg-slate-50 font-medium transition-all text-caption"
                >
                    Batal
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-2.5 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium shadow-brand-soft transition-all text-caption"
                >
                    Simpan Kode Promo
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
