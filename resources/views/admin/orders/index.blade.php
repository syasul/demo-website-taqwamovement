<x-layouts.admin>
    @section('page_title', 'Daftar Transaksi Tiket')

    <!-- Filter Actions -->
    <div class="mb-6 flex justify-between items-center flex-wrap gap-4">
        <div class="flex gap-2">
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded-full text-xs font-semibold {{ !$currentStatus ? 'bg-brand-primary text-brand-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} transition-colors">
                Semua Status
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'paid']) }}" class="px-4 py-2 rounded-full text-xs font-semibold {{ $currentStatus === 'paid' ? 'bg-emerald-600 text-brand-white' : 'bg-emerald-50 text-emerald-600 hover:bg-emerald-100' }} transition-colors">
                Lunas
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-full text-xs font-semibold {{ $currentStatus === 'pending' ? 'bg-amber-500 text-brand-white' : 'bg-amber-50 text-amber-600 hover:bg-amber-100' }} transition-colors">
                Pending
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'expired']) }}" class="px-4 py-2 rounded-full text-xs font-semibold {{ $currentStatus === 'expired' ? 'bg-slate-500 text-brand-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} transition-colors">
                Expired
            </a>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-brand-white border border-slate-200 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" aria-label="Orders list">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-brand-ink/50 uppercase tracking-wider">
                        <th class="px-6 py-4">No. Order</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Event</th>
                        <th class="px-6 py-4 text-center">Total</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Metode</th>
                        <th class="px-6 py-4 text-right">Tanggal Pemesanan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-body text-brand-ink/80">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-semibold text-brand-primary whitespace-nowrap">
                                {{ $order->order_number }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-brand-ink">{{ $order->user->name ?? '-' }}</div>
                                <div class="text-[11px] text-brand-ink/50">{{ $order->user->email ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4 text-caption text-brand-ink/65 font-medium whitespace-nowrap">
                                {{ Str::limit($order->event->title ?? '-', 25) }}
                            </td>
                            <td class="px-6 py-4 text-center font-semibold text-brand-primary whitespace-nowrap">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                @if($order->status === 'paid')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border bg-emerald-50 text-emerald-700 border-emerald-200">Lunas</span>
                                @elseif($order->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border bg-amber-50 text-amber-700 border-amber-200">Pending</span>
                                @elseif($order->status === 'expired')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border bg-slate-100 text-slate-600 border-slate-200">Expired</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider border bg-rose-50 text-rose-700 border-rose-200">Gagal/Batal</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-caption text-brand-ink/65 whitespace-nowrap">
                                {{ strtoupper($order->payment->payment_method ?? 'Snap') }}
                            </td>
                            <td class="px-6 py-4 text-right text-caption text-brand-ink/65 whitespace-nowrap">
                                {{ $order->created_at->format('d M Y, H:i') }} WIB
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-caption text-brand-ink/50 italic">
                                Belum ada data transaksi pemesanan tiket.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination links -->
        @if($orders->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
