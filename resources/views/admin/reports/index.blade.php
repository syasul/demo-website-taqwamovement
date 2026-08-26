<x-layouts.admin>
    @section('page_title', 'Laporan Penjualan Tiket')

    <!-- Date Filter Form -->
    <div class="bg-brand-white border border-slate-200 rounded-2xl p-6 shadow-[0_1px_3px_rgba(0,0,0,0.02)] mb-8">
        <form method="GET" action="{{ route('admin.reports.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
            <div>
                <label class="block text-caption text-brand-ink/75 font-semibold mb-2">Tanggal Mulai</label>
                <input 
                    type="date" 
                    name="start_date" 
                    value="{{ $startDate }}"
                    class="w-full border border-slate-200 rounded-full px-4 py-2.5 text-caption text-brand-ink focus:ring-brand-primary focus:border-brand-primary"
                />
            </div>
            <div>
                <label class="block text-caption text-brand-ink/75 font-semibold mb-2">Tanggal Selesai</label>
                <input 
                    type="date" 
                    name="end_date" 
                    value="{{ $endDate }}"
                    class="w-full border border-slate-200 rounded-full px-4 py-2.5 text-caption text-brand-ink focus:ring-brand-primary focus:border-brand-primary"
                />
            </div>
            <div class="flex gap-3">
                <button 
                    type="submit" 
                    class="flex-grow inline-flex items-center justify-center px-6 py-3 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium tracking-wide text-caption shadow-brand-soft transition-all"
                >
                    Filter
                </button>
                <a 
                    href="{{ route('admin.reports.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                    class="inline-flex items-center justify-center px-6 py-3 rounded-full text-brand-primary border border-brand-primary/20 hover:bg-brand-primary/5 font-medium tracking-wide text-caption transition-all"
                >
                    Ekspor CSV
                </a>
            </div>
        </form>
    </div>

    <!-- Analytics Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-brand-white border border-slate-200 rounded-2xl p-6 shadow-[0_1px_3px_rgba(0,0,0,0.02)] space-y-2">
            <span class="text-xs text-brand-ink/50 block font-semibold uppercase tracking-wider">Total Pendapatan</span>
            <h2 class="text-h2 font-serif text-brand-primary font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
            <span class="text-xs text-brand-ink/40">Total dana bersih terkumpul</span>
        </div>
        <div class="bg-brand-white border border-slate-200 rounded-2xl p-6 shadow-[0_1px_3px_rgba(0,0,0,0.02)] space-y-2">
            <span class="text-xs text-brand-ink/50 block font-semibold uppercase tracking-wider">Tiket Terjual</span>
            <h2 class="text-h2 font-serif text-brand-primary font-bold">{{ $totalTicketsSold }} Tiket</h2>
            <span class="text-xs text-brand-ink/40">Dari seluruh event & sub-tiket</span>
        </div>
        <div class="bg-brand-white border border-slate-200 rounded-2xl p-6 shadow-[0_1px_3px_rgba(0,0,0,0.02)] space-y-2">
            <span class="text-xs text-brand-ink/50 block font-semibold uppercase tracking-wider">Rata-Rata Order</span>
            <h2 class="text-h2 font-serif text-brand-primary font-bold">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</h2>
            <span class="text-xs text-brand-ink/40">Nilai transaksi per pelanggan</span>
        </div>
        <div class="bg-brand-white border border-slate-200 rounded-2xl p-6 shadow-[0_1px_3px_rgba(0,0,0,0.02)] space-y-2">
            <span class="text-xs text-brand-ink/50 block font-semibold uppercase tracking-wider">Potongan Diskon</span>
            <h2 class="text-h2 font-serif text-emerald-600 font-bold">Rp {{ number_format($totalDiscount, 0, ',', '.') }}</h2>
            <span class="text-xs text-brand-ink/40">Klaim kode promo yang dipakai</span>
        </div>
    </div>

    <!-- Details Section Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Table: Sales by Event -->
        <div class="bg-brand-white border border-slate-200 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] p-6 space-y-4">
            <h3 class="font-serif text-body-lg font-bold text-brand-primary border-b border-slate-100 pb-2">Penjualan Berdasarkan Program Event</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse" aria-label="Event sales list">
                    <thead>
                        <tr class="text-xs font-bold text-brand-ink/50 uppercase tracking-wider border-b border-slate-100 pb-2">
                            <th class="py-2">Event</th>
                            <th class="py-2 text-center">Order Lunas</th>
                            <th class="py-2 text-right">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-caption text-brand-ink/80">
                        @forelse($salesByEvent as $item)
                            <tr>
                                <td class="py-3 font-semibold text-brand-primary">{{ Str::limit($item->event->title ?? '-', 35) }}</td>
                                <td class="py-3 text-center">{{ $item->count }} Transaksi</td>
                                <td class="py-3 text-right font-bold text-brand-primary">Rp {{ number_format($item->revenue, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-6 text-center text-brand-ink/40 italic">Belum ada data penjualan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Table: Popularity by Ticket Type -->
        <div class="bg-brand-white border border-slate-200 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] p-6 space-y-4">
            <h3 class="font-serif text-body-lg font-bold text-brand-primary border-b border-slate-100 pb-2">Popularitas Jenis Tiket</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse" aria-label="Ticket type sales list">
                    <thead>
                        <tr class="text-xs font-bold text-brand-ink/50 uppercase tracking-wider border-b border-slate-100 pb-2">
                            <th class="py-2">Nama Tiket</th>
                            <th class="py-2 text-center">Jumlah Terjual</th>
                            <th class="py-2 text-right">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-caption text-brand-ink/80">
                        @forelse($salesByTicketType as $item)
                            <tr>
                                <td class="py-3 font-semibold text-brand-primary">
                                    {{ $item->ticketType->name ?? 'Standard' }}
                                    <span class="text-[10px] block font-normal text-brand-ink/40">{{ $item->ticketType->event->title ?? '' }}</span>
                                </td>
                                <td class="py-3 text-center font-bold">{{ $item->qty_sold }} Tiket</td>
                                <td class="py-3 text-right font-bold text-brand-primary">Rp {{ number_format($item->revenue, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-6 text-center text-brand-ink/40 italic">Belum ada data tiket terjual.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-layouts.admin>
