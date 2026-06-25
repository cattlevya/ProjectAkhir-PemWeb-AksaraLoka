@extends('layouts.app')
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <p class="text-[11px] uppercase tracking-[0.3em] text-gold mb-3">Laporan</p>
    <h1 class="font-display text-3xl text-espresso-deep mb-8">Laporan Penjualan</h1>

    {{-- Date Filter --}}
    <form action="{{ route('seller.reports.index') }}" method="GET" class="flex flex-wrap items-end gap-4 mb-10">
        <div>
            <label class="text-[10px] uppercase tracking-[0.2em] text-secondary-text block mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ $startDate }}" class="bg-cream-warm border border-cream-mid px-3 py-2 text-sm focus:border-gold focus:ring-0">
        </div>
        <div>
            <label class="text-[10px] uppercase tracking-[0.2em] text-secondary-text block mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ $endDate }}" class="bg-cream-warm border border-cream-mid px-3 py-2 text-sm focus:border-gold focus:ring-0">
        </div>
        <button type="submit" class="bg-espresso text-cream px-6 py-2 text-[10px] uppercase tracking-wider hover:bg-espresso-deep transition-colors">Filter</button>
        <a href="{{ route('seller.reports.export-pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="border border-espresso-mid/20 px-6 py-2 text-[10px] uppercase tracking-wider text-espresso-mid hover:border-gold hover:text-gold transition-colors">
            Export PDF
        </a>
    </form>

    {{-- Summary --}}
    <div class="grid grid-cols-2 gap-4 mb-10">
        <div class="bg-cream-warm p-6">
            <p class="text-[10px] uppercase tracking-[0.2em] text-secondary-text mb-2">Total Pendapatan</p>
            <p class="font-display text-2xl text-espresso-deep">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="bg-cream-warm p-6">
            <p class="text-[10px] uppercase tracking-[0.2em] text-secondary-text mb-2">Total Pesanan</p>
            <p class="font-display text-2xl text-espresso-deep">{{ $totalOrders }}</p>
        </div>
    </div>

    {{-- Detail Table --}}
    @if($orderItems->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-espresso-mid/20">
                <th class="text-left py-3 text-[10px] uppercase tracking-wider text-secondary-text font-medium">Kode Order</th>
                <th class="text-left py-3 text-[10px] uppercase tracking-wider text-secondary-text font-medium">Produk</th>
                <th class="text-center py-3 text-[10px] uppercase tracking-wider text-secondary-text font-medium">Qty</th>
                <th class="text-right py-3 text-[10px] uppercase tracking-wider text-secondary-text font-medium">Harga</th>
                <th class="text-right py-3 text-[10px] uppercase tracking-wider text-secondary-text font-medium">Subtotal</th>
            </tr></thead>
            <tbody>
                @foreach($orderItems as $item)
                <tr class="border-b border-cream-mid">
                    <td class="py-3 text-espresso-mid">{{ $item->order->order_code }}</td>
                    <td class="py-3">{{ $item->product->name ?? '—' }}</td>
                    <td class="py-3 text-center">{{ $item->qty }}</td>
                    <td class="py-3 text-right font-display italic">{{ $item->formatted_price }}</td>
                    <td class="py-3 text-right font-display italic">{{ $item->formatted_subtotal }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot><tr class="border-t-2 border-espresso-mid/30">
                <td colspan="4" class="py-3 text-right font-semibold text-[11px] uppercase tracking-wider">Total</td>
                <td class="py-3 text-right font-display text-lg italic font-semibold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            </tr></tfoot>
        </table>
    </div>
    @else
    <p class="text-secondary-text text-center py-10">Tidak ada data penjualan pada periode ini.</p>
    @endif
</div>
@endsection
