<x-layouts.admin>
    @section('page_title', 'Kelola Kode Promo / Diskon')

    <!-- Top Action Header -->
    <div class="mb-6 flex justify-between items-center flex-wrap gap-4">
        <p class="text-caption text-brand-ink/60">Kelola kupon diskon, persentase potongan harga, dan batas kuota promo.</p>
        <a 
            href="{{ route('admin.promo-codes.create') }}" 
            class="inline-flex items-center justify-center px-4 py-2.5 rounded-full text-brand-white bg-brand-primary hover:bg-brand-secondary font-medium tracking-wide text-caption shadow-brand-soft hover:-translate-y-0.5 transition-all duration-300"
        >
            + Tambah Kode Promo
        </a>
    </div>

    <!-- Data Table Card -->
    <div class="bg-brand-white border border-slate-200 rounded-2xl shadow-[0_1px_3px_rgba(0,0,0,0.02)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" aria-label="Promo codes list">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-brand-ink/50 uppercase tracking-wider">
                        <th class="px-6 py-4">Kode Promo</th>
                        <th class="px-6 py-4">Jenis Potongan</th>
                        <th class="px-6 py-4 text-center">Nilai Diskon</th>
                        <th class="px-6 py-4 text-center">Batas Penggunaan</th>
                        <th class="px-6 py-4 text-center">Masa Berlaku</th>
                        <th class="px-6 py-4 w-36 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-body text-brand-ink/80">
                    @forelse($promoCodes as $code)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-mono font-bold text-brand-primary whitespace-nowrap">
                                {{ $code->code }}
                            </td>
                            <td class="px-6 py-4 text-caption text-brand-ink/65 font-medium whitespace-nowrap">
                                {{ $code->discount_type === 'percentage' ? 'Persentase (%)' : 'Potongan Tetap (Rp)' }}
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-brand-primary whitespace-nowrap">
                                {{ $code->discount_type === 'percentage' ? $code->discount_value . '%' : 'Rp ' . number_format($code->discount_value, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center text-caption whitespace-nowrap font-medium">
                                {{ $code->quota }} ({{ $code->used_count }} Terpakai)
                            </td>
                            <td class="px-6 py-4 text-center text-caption text-brand-ink/65 whitespace-nowrap">
                                {{ $code->valid_from->format('d M') }} s/d {{ $code->valid_until->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.promo-codes.edit', $code->id) }}" class="p-1.5 text-brand-primary hover:bg-brand-primary/5 rounded-lg font-semibold text-caption transition-colors">Edit</a>
                                    
                                    <form method="POST" action="{{ route('admin.promo-codes.destroy', $code->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kode promo ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg font-semibold text-caption transition-colors">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-caption text-brand-ink/50 italic">
                                Belum ada kode promo ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($promoCodes->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50">
                {{ $promoCodes->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
