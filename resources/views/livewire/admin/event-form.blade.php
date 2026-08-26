<div>
    <!-- Tab Headers Nav -->
    <div class="border-b border-slate-200 mb-8">
        <nav class="flex gap-6 -mb-px" aria-label="Tabs">
            <button 
                wire:click="setTab('basic')" 
                type="button"
                :class="'{{ $activeTab }}' === 'basic' ? 'border-brand-primary text-brand-primary' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                class="py-4 px-1 border-b-2 font-medium text-caption focus:outline-none transition-all"
            >
                Informasi Dasar
            </button>
            <button 
                wire:click="setTab('speakers')" 
                type="button"
                :class="'{{ $activeTab }}' === 'speakers' ? 'border-brand-primary text-brand-primary' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                class="py-4 px-1 border-b-2 font-medium text-caption focus:outline-none transition-all"
            >
                Pembicara
            </button>
            <button 
                wire:click="setTab('sessions')" 
                type="button"
                :class="'{{ $activeTab }}' === 'sessions' ? 'border-brand-primary text-brand-primary' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                class="py-4 px-1 border-b-2 font-medium text-caption focus:outline-none transition-all"
            >
                Sesi & Agenda Rundown
            </button>
            <button 
                wire:click="setTab('seo')" 
                type="button"
                :class="'{{ $activeTab }}' === 'seo' ? 'border-brand-primary text-brand-primary' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                class="py-4 px-1 border-b-2 font-medium text-caption focus:outline-none transition-all"
            >
                Audience & SEO
            </button>
        </nav>
    </div>

    <!-- Form Content Container -->
    <form wire:submit.prevent="save" class="space-y-8">
        
        <!-- TAB 1: BASIC INFORMATION -->
        <div x-show="'{{ $activeTab }}' === 'basic'" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Phase Field -->
                <div class="space-y-1">
                    <label for="event-phase" class="text-caption font-semibold text-brand-ink/80 block">Fase Perjalanan Event</label>
                    <select 
                        id="event-phase"
                        wire:model.defer="phase_id" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body bg-brand-white"
                    >
                        <option value="">Pilih Fase...</option>
                        @foreach($phases as $phase)
                            <option value="{{ $phase->id }}">{{ $phase->title }}</option>
                        @endforeach
                    </select>
                    @error('phase_id') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Status Field -->
                <div class="space-y-1">
                    <label for="event-status" class="text-caption font-semibold text-brand-ink/80 block">Status Publikasi</label>
                    <select 
                        id="event-status"
                        wire:model.defer="status" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body bg-brand-white"
                    >
                        <option value="draft">Draft</option>
                        <option value="published">Diterbitkan</option>
                        <option value="archived">Diarsipkan</option>
                    </select>
                    @error('status') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Title Field -->
            <div class="space-y-1">
                <label for="event-title" class="text-caption font-semibold text-brand-ink/80 block">Judul Event</label>
                <input 
                    id="event-title"
                    wire:model.defer="title" 
                    type="text" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    placeholder="e.g. Taqwa Movement Fase 1: Finding Peace in Chaos"
                />
                @error('title') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Tagline Field -->
            <div class="space-y-1">
                <label for="event-tagline" class="text-caption font-semibold text-brand-ink/80 block">Tagline Event</label>
                <input 
                    id="event-tagline"
                    wire:model.defer="tagline" 
                    type="text" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    placeholder="e.g. Ketika Hidup Tak Sesuai Rencana"
                />
                @error('tagline') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Description Field -->
            <div class="space-y-1">
                <label for="event-description" class="text-caption font-semibold text-brand-ink/80 block">Deskripsi Lengkap (Rich Text / HTML)</label>
                <textarea 
                    id="event-description"
                    wire:model.defer="description" 
                    rows="8"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    placeholder="Masukkan narasi detail, manfaat, dan nilai dari event..."
                ></textarea>
                @error('description') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Date Field -->
                <div class="space-y-1">
                    <label for="event-date" class="text-caption font-semibold text-brand-ink/80 block">Tanggal Pelaksanaan</label>
                    <input 
                        id="event-date"
                        wire:model.defer="date" 
                        type="date" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    />
                    @error('date') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Location Field -->
                <div class="space-y-1">
                    <label for="event-location" class="text-caption font-semibold text-brand-ink/80 block">Lokasi / Tempat</label>
                    <input 
                        id="event-location"
                        wire:model.defer="location" 
                        type="text" 
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                        placeholder="e.g. Malang Creative Center, Lt. 5"
                    />
                    @error('location') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Ticket URL -->
            <div class="space-y-1">
                <label for="event-ticket-url" class="text-caption font-semibold text-brand-ink/80 block">Link Pembelian Tiket Eksternal</label>
                <input 
                    id="event-ticket-url"
                    wire:model.defer="ticket_url" 
                    type="url" 
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                    placeholder="https://eventimeindonesia.com/events/taqwa-fase-1"
                />
                @error('ticket_url') <span class="text-xs text-red-600 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- TAB 2: SPEAKERS SELECTION -->
        <div x-show="'{{ $activeTab }}' === 'speakers'" class="space-y-6">
            <h3 class="font-serif text-body-lg font-bold text-brand-primary mb-4">Pilih Pembicara Acara</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($allSpeakers as $speaker)
                    <label class="flex items-start gap-3 p-4 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition-colors">
                        <input 
                            type="checkbox" 
                            wire:model.defer="selectedSpeakers" 
                            value="{{ $speaker->id }}"
                            class="rounded border-slate-300 text-brand-primary focus:ring-brand-primary mt-1"
                        />
                        <div>
                            <span class="font-semibold text-brand-primary block leading-snug">{{ $speaker->name }}</span>
                            <span class="text-xs text-brand-ink/50">{{ $speaker->role_title }}</span>
                        </div>
                    </label>
                @endforeach
            </div>
            @error('selectedSpeakers') <span class="text-xs text-red-600 font-medium block">{{ $message }}</span> @enderror
        </div>

        <!-- TAB 3: SESSIONS & RUNNDOWN AGENDA -->
        <div x-show="'{{ $activeTab }}' === 'sessions'" class="space-y-12">
            
            <!-- 3.1 SESSIONS REPEATER -->
            <div class="space-y-6">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <h3 class="font-serif text-body-lg font-bold text-brand-primary">Sesi Acara</h3>
                    <button wire:click="addSession" type="button" class="text-xs text-brand-primary font-semibold hover:underline">+ Tambah Sesi</button>
                </div>

                <div class="space-y-6">
                    @foreach($sessions as $index => $session)
                        <div class="p-6 bg-slate-50 border border-slate-200 rounded-2xl relative space-y-4">
                            <button 
                                wire:click="removeSession({{ $index }})" 
                                type="button" 
                                class="absolute top-4 right-4 text-xs font-semibold text-red-600 hover:underline"
                            >
                                Hapus Sesi
                            </button>

                            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                                <div class="md:col-span-2">
                                    <label class="text-xs font-semibold text-brand-ink/75 block mb-1">Sesi Ke-</label>
                                    <input 
                                        type="number" 
                                        wire:model.defer="sessions.{{ $index }}.session_number" 
                                        class="w-full px-3 py-2 rounded-lg border border-slate-200 text-body text-center"
                                    />
                                </div>
                                <div class="md:col-span-6">
                                    <label class="text-xs font-semibold text-brand-ink/75 block mb-1">Judul Sesi</label>
                                    <input 
                                        type="text" 
                                        wire:model.defer="sessions.{{ $index }}.title" 
                                        class="w-full px-3 py-2 rounded-lg border border-slate-200 text-body"
                                        placeholder="e.g. Ketika Hidup Tak Sesuai Rencana"
                                    />
                                    @error("sessions.{$index}.title") <span class="text-xs text-red-600 block mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="text-xs font-semibold text-brand-ink/75 block mb-1">Jam Mulai</label>
                                    <input 
                                        type="time" 
                                        wire:model.defer="sessions.{{ $index }}.start_time" 
                                        class="w-full px-3 py-2 rounded-lg border border-slate-200 text-body text-center"
                                    />
                                </div>
                                <div class="md:col-span-2">
                                    <label class="text-xs font-semibold text-brand-ink/75 block mb-1">Jam Selesai</label>
                                    <input 
                                        type="time" 
                                        wire:model.defer="sessions.{{ $index }}.end_time" 
                                        class="w-full px-3 py-2 rounded-lg border border-slate-200 text-body text-center"
                                    />
                                </div>
                            </div>

                            <div>
                                <label class="text-xs font-semibold text-brand-ink/75 block mb-1">Deskripsi Sesi</label>
                                <textarea 
                                    wire:model.defer="sessions.{{ $index }}.description" 
                                    rows="2"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-200 text-body"
                                    placeholder="Jelaskan ringkasan materi sesi ini..."
                                ></textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 3.2 RUNNDOWN AGENDA REPEATER -->
            <div class="space-y-6">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <h3 class="font-serif text-body-lg font-bold text-brand-primary">Agenda Rundown Acara</h3>
                    <div class="flex gap-4">
                        <button wire:click="addAgendaItem(1)" type="button" class="text-xs text-brand-primary font-semibold hover:underline">+ Rundown Sesi 1</button>
                        <button wire:click="addAgendaItem(2)" type="button" class="text-xs text-brand-primary font-semibold hover:underline">+ Rundown Sesi 2</button>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($agendaItems as $index => $item)
                        <div class="p-4 bg-brand-white border border-slate-200 rounded-xl relative grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <button 
                                wire:click="removeAgendaItem({{ $index }})" 
                                type="button" 
                                class="absolute top-2 right-2 text-xs text-red-600 hover:underline"
                            >
                                Hapus
                            </button>

                            <div class="md:col-span-2">
                                <label class="text-xs font-semibold text-brand-ink/50 block mb-1">Sesi Group</label>
                                <select wire:model.defer="agendaItems.{{ $index }}.session_group" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 text-body text-center bg-slate-50">
                                    <option value="1">Sesi 1</option>
                                    <option value="2">Sesi 2</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="text-xs font-semibold text-brand-ink/50 block mb-1">Durasi</label>
                                <input type="text" wire:model.defer="agendaItems.{{ $index }}.duration_label" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 text-body text-center" placeholder="09.00 - 10.30"/>
                                @error("agendaItems.{$index}.duration_label") <span class="text-xs text-red-600 block">{{ $message }}</span> @enderror
                            </div>
                            <div class="md:col-span-4">
                                <label class="text-xs font-semibold text-brand-ink/50 block mb-1">Judul Agenda</label>
                                <input type="text" wire:model.defer="agendaItems.{{ $index }}.title" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 text-body" placeholder="e.g. Sesi Utama 01: Mengurai Bising Batin"/>
                                @error("agendaItems.{$index}.title") <span class="text-xs text-red-600 block">{{ $message }}</span> @enderror
                            </div>
                            <div class="md:col-span-4">
                                <label class="text-xs font-semibold text-brand-ink/50 block mb-1">Subjudul / Deskripsi Singkat</label>
                                <input type="text" wire:model.defer="agendaItems.{{ $index }}.subtitle" class="w-full px-2 py-1.5 rounded-lg border border-slate-200 text-body" placeholder="e.g. Bersama Ust. Dennis Lim"/>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 3.3 TOPICS REPEATER -->
            <div class="space-y-6">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <h3 class="font-serif text-body-lg font-bold text-brand-primary">Fokus Materi Sesi (Topics)</h3>
                    <div class="flex gap-4">
                        <button wire:click="addTopic(1)" type="button" class="text-xs text-brand-primary font-semibold hover:underline">+ Topik Sesi 1</button>
                        <button wire:click="addTopic(2)" type="button" class="text-xs text-brand-primary font-semibold hover:underline">+ Topik Sesi 2</button>
                    </div>
                </div>

                <div class="space-y-3">
                    @foreach($topics as $index => $topic)
                        <div class="p-3 bg-brand-white border border-slate-200 rounded-lg flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3 flex-grow">
                                <span class="text-xs font-bold px-2 py-1 bg-slate-100 border rounded-lg text-brand-primary">Sesi {{ $topic['session_number'] }}</span>
                                <input 
                                    type="text" 
                                    wire:model.defer="topics.{{ $index }}.topic_text" 
                                    class="flex-grow px-3 py-1.5 rounded-lg border border-slate-200 text-body focus:ring-brand-primary"
                                    placeholder="Jelaskan poin fokus materi yang dipelajari..."
                                />
                                @error("topics.{$index}.topic_text") <span class="text-xs text-red-600 block">{{ $message }}</span> @enderror
                            </div>
                            <button wire:click="removeTopic({{ $index }})" type="button" class="text-red-600 text-xs font-semibold hover:underline">Hapus</button>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- TAB 4: AUDIENCE & SEO METADATA -->
        <div x-show="'{{ $activeTab }}' === 'seo'" class="space-y-12">
            
            <!-- 4.1 AUDIENCE POINTS REPEATER -->
            <div class="space-y-6">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <h3 class="font-serif text-body-lg font-bold text-brand-primary">Cocok Untuk Kamu Yang (Audience Checklist)</h3>
                    <button wire:click="addAudiencePoint" type="button" class="text-xs text-brand-primary font-semibold hover:underline">+ Tambah Poin</button>
                </div>

                <div class="space-y-3">
                    @foreach($audiencePoints as $index => $ap)
                        <div class="p-3 bg-brand-white border border-slate-200 rounded-lg flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3 flex-grow">
                                <span class="text-caption text-brand-ink/50">#{{ $index + 1 }}</span>
                                <input 
                                    type="text" 
                                    wire:model.defer="audiencePoints.{{ $index }}.text" 
                                    class="flex-grow px-3 py-1.5 rounded-lg border border-slate-200 text-body"
                                    placeholder="e.g. Sering merasa cemas dan overthinking..."
                                />
                                @error("audiencePoints.{$index}.text") <span class="text-xs text-red-600 block">{{ $message }}</span> @enderror
                            </div>
                            <button wire:click="removeAudiencePoint({{ $index }})" type="button" class="text-red-600 text-xs font-semibold hover:underline">Hapus</button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 4.2 SEO TAB METADATA -->
            <div class="space-y-6">
                <h3 class="font-serif text-body-lg font-bold text-brand-primary border-b border-slate-100 pb-3">Optimasi SEO & Open Graph</h3>
                
                <div class="space-y-6">
                    <div class="space-y-1">
                        <label for="seo-meta-title" class="text-caption font-semibold text-brand-ink/80 block">Meta Title</label>
                        <input 
                            id="seo-meta-title"
                            wire:model.defer="meta_title" 
                            type="text" 
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                            placeholder="Biarkan kosong untuk menggunakan Judul Event"
                        />
                    </div>

                    <div class="space-y-1">
                        <label for="seo-meta-description" class="text-caption font-semibold text-brand-ink/80 block">Meta Description</label>
                        <textarea 
                            id="seo-meta-description"
                            wire:model.defer="meta_description" 
                            rows="3"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-200 focus:border-brand-primary focus:ring-2 focus:ring-brand-accent/30 text-body"
                            placeholder="Biarkan kosong untuk menggunakan tagline / deskripsi ringkas"
                        ></textarea>
                    </div>
                </div>
            </div>

        </div>

        <!-- Form Sticky Actions Footer -->
        <div class="pt-6 border-t border-slate-200 flex justify-end gap-3">
            <a 
                href="/admin/events" 
                class="px-6 py-3 rounded-full border border-slate-200 hover:bg-slate-50 text-caption font-semibold transition-all"
            >
                Batal
            </a>
            <button 
                type="submit" 
                class="px-8 py-3 rounded-full bg-brand-primary hover:bg-brand-secondary text-brand-white text-caption font-bold shadow-brand-soft hover:shadow-[0_12px_35px_rgba(80,46,136,0.15)] transition-all duration-300"
            >
                Simpan Event
            </button>
        </div>

    </form>
</div>
