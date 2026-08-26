<x-layouts.admin>
    @section('page_title', 'Ubah Sesi Event')

    <div class="mb-6">
        <a href="{{ route('admin.event-sessions.index') }}" class="text-caption font-semibold text-brand-primary hover:text-brand-secondary flex items-center gap-1.5 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Sesi
        </a>
    </div>

    <div class="bg-brand-white border border-slate-200 rounded-2xl p-6 md:p-8 max-w-3xl shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
        <form action="{{ route('admin.event-sessions.update', $eventSession->id) }}" method="POST" class="space-y-6">
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
                            <option value="{{ $event->id }}" {{ old('event_id', $eventSession->event_id) == $event->id ? 'selected' : '' }}>
                                {{ $event->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('event_id') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Session Title -->
                <div class="md:col-span-2 space-y-1">
                    <label for="title" class="text-caption font-semibold text-brand-ink/80 block">Judul Sesi</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        required
                        value="{{ old('title', $eventSession->title) }}"
                        placeholder="e.g. Ketika Hidup Tak Sesuai Rencana"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    />
                    @error('title') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Start Time -->
                <div class="space-y-1">
                    <label for="start_time" class="text-caption font-semibold text-brand-ink/80 block">Waktu Mulai (HH:MM)</label>
                    <input 
                        type="time" 
                        id="start_time" 
                        name="start_time" 
                        required
                        value="{{ old('start_time', substr($eventSession->start_time, 0, 5)) }}"
                        placeholder="09:00"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body font-mono"
                    />
                    @error('start_time') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- End Time -->
                <div class="space-y-1">
                    <label for="end_time" class="text-caption font-semibold text-brand-ink/80 block">Waktu Selesai (HH:MM)</label>
                    <input 
                        type="time" 
                        id="end_time" 
                        name="end_time" 
                        required
                        value="{{ old('end_time', substr($eventSession->end_time, 0, 5)) }}"
                        placeholder="11:30"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body font-mono"
                    />
                    @error('end_time') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Display Order -->
                <div class="space-y-1">
                    <label for="order" class="text-caption font-semibold text-brand-ink/80 block">Urutan Sesi (Index)</label>
                    <input 
                        type="number" 
                        id="order" 
                        name="order" 
                        required
                        min="1"
                        value="{{ old('order', $eventSession->order) }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    />
                    @error('order') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2 space-y-1">
                    <label for="description" class="text-caption font-semibold text-brand-ink/80 block">Isi Konten / Deskripsi Sesi</label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="4"
                        placeholder="Tuliskan detail mengenai sesi ini (e.g. pembahasan materi, poin pembelajaran)..."
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    >{{ old('description', $eventSession->description) }}</textarea>
                    @error('description') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Submit buttons -->
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a 
                    href="{{ route('admin.event-sessions.index') }}" 
                    class="px-5 py-2.5 rounded-full border border-slate-200 text-brand-ink/70 hover:bg-slate-50 font-medium transition-all text-caption"
                >
                    Batal
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-2.5 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium shadow-brand-soft transition-all text-caption"
                >
                    Perbarui Sesi
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
