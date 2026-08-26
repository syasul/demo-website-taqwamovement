<x-layouts.admin>
    @section('page_title', 'Ubah Jenis Tiket')

    <div class="mb-6">
        <a href="{{ route('admin.ticket-types.index') }}" class="text-caption font-semibold text-brand-primary hover:text-brand-secondary flex items-center gap-1.5 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Tiket
        </a>
    </div>

    <div class="bg-brand-white border border-slate-200 rounded-2xl p-6 md:p-8 max-w-3xl shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
        <form action="{{ route('admin.ticket-types.update', $ticketType->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Event Selection -->
                <div class="md:col-span-2 space-y-1">
                    <label for="event_id" class="text-caption font-semibold text-brand-ink/80 block">Event</label>
                    <select 
                        id="event_id" 
                        name="event_id" 
                        required
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body bg-brand-white"
                    >
                        <option value="">Pilih Event...</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ old('event_id', $ticketType->event_id) == $event->id ? 'selected' : '' }}>
                                {{ $event->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('event_id') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Ticket Name -->
                <div class="md:col-span-2 space-y-1">
                    <label for="name" class="text-caption font-semibold text-brand-ink/80 block">Nama Tiket</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        required
                        value="{{ old('name', $ticketType->name) }}"
                        placeholder="e.g. Early Bird Access / Regular Pass"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    />
                    @error('name') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Price -->
                <div class="space-y-1">
                    <label for="price" class="text-caption font-semibold text-brand-ink/80 block">Harga Tiket (Rp)</label>
                    <input 
                        type="number" 
                        id="price" 
                        name="price" 
                        required
                        min="0"
                        value="{{ old('price', $ticketType->price) }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body font-semibold text-brand-primary"
                    />
                    @error('price') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Quota -->
                <div class="space-y-1">
                    <label for="quota" class="text-caption font-semibold text-brand-ink/80 block">Kuota Tiket</label>
                    <input 
                        type="number" 
                        id="quota" 
                        name="quota" 
                        required
                        min="0"
                        value="{{ old('quota', $ticketType->quota) }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    />
                    @error('quota') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Max per Transaction -->
                <div class="space-y-1">
                    <label for="max_per_transaction" class="text-caption font-semibold text-brand-ink/80 block">Maks. per Transaksi</label>
                    <input 
                        type="number" 
                        id="max_per_transaction" 
                        name="max_per_transaction" 
                        required
                        min="1"
                        value="{{ old('max_per_transaction', $ticketType->max_per_transaction) }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    />
                    @error('max_per_transaction') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Active Status -->
                <div class="flex items-center pt-8">
                    <label class="inline-flex items-center cursor-pointer select-none">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1"
                            {{ old('is_active', $ticketType->is_active) ? 'checked' : '' }}
                            class="rounded text-brand-primary focus:ring-brand-accent w-5 h-5 border-slate-200"
                        />
                        <span class="ml-2 text-caption font-semibold text-brand-ink/80">Aktifkan Penjualan Tiket</span>
                    </label>
                </div>

                <!-- Sale Start At -->
                <div class="space-y-1">
                    <label for="sale_start_at" class="text-caption font-semibold text-brand-ink/80 block">Jadwal Mulai Penjualan</label>
                    <input 
                        type="datetime-local" 
                        id="sale_start_at" 
                        name="sale_start_at" 
                        required
                        value="{{ old('sale_start_at', $ticketType->sale_start_at ? \Carbon\Carbon::parse($ticketType->sale_start_at)->format('Y-m-d\TH:i') : '') }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    />
                    @error('sale_start_at') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Sale End At -->
                <div class="space-y-1">
                    <label for="sale_end_at" class="text-caption font-semibold text-brand-ink/80 block">Jadwal Selesai Penjualan</label>
                    <input 
                        type="datetime-local" 
                        id="sale_end_at" 
                        name="sale_end_at" 
                        required
                        value="{{ old('sale_end_at', $ticketType->sale_end_at ? \Carbon\Carbon::parse($ticketType->sale_end_at)->format('Y-m-d\TH:i') : '') }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    />
                    @error('sale_end_at') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2 space-y-1">
                    <label for="description" class="text-caption font-semibold text-brand-ink/80 block">Deskripsi Tiket (Benefit)</label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="4"
                        placeholder="Tuliskan benefit yang didapatkan (e.g. snack, merchandise, seat baris depan)..."
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    >{{ old('description', $ticketType->description) }}</textarea>
                    @error('description') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Submit buttons -->
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a 
                    href="{{ route('admin.ticket-types.index') }}" 
                    class="px-5 py-2.5 rounded-full border border-slate-200 text-brand-ink/70 hover:bg-slate-50 font-medium transition-all text-caption"
                >
                    Batal
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-2.5 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium shadow-brand-soft transition-all text-caption"
                >
                    Perbarui Tiket
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
