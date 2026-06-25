@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <p class="text-[11px] uppercase tracking-[0.3em] text-gold mb-3">Admin</p>
    <h1 class="font-display text-3xl text-espresso-deep mb-8">Semua Pesanan</h1>

    <div class="flex flex-wrap gap-2 mb-8">
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-1.5 text-[10px] uppercase tracking-wider {{ !$status ? 'bg-espresso text-cream' : 'border border-espresso-mid/20 text-espresso-mid hover:border-gold hover:text-gold' }} transition-colors">Semua</a>
        @foreach(\App\Models\Order::STATUS_LABELS as $key => $label)
            <a href="{{ route('admin.orders.index', ['status' => $key]) }}" class="px-4 py-1.5 text-[10px] uppercase tracking-wider {{ $status === $key ? 'bg-espresso text-cream' : 'border border-espresso-mid/20 text-espresso-mid hover:border-gold hover:text-gold' }} transition-colors">{{ $label }}</a>
        @endforeach
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="border-b border-espresso-mid/20">
                <th class="text-left py-3 text-[10px] uppercase tracking-wider text-secondary-text font-medium">Kode</th>
                <th class="text-left py-3 text-[10px] uppercase tracking-wider text-secondary-text font-medium">Pembeli</th>
                <th class="text-left py-3 text-[10px] uppercase tracking-wider text-secondary-text font-medium">Status</th>
                <th class="text-right py-3 text-[10px] uppercase tracking-wider text-secondary-text font-medium">Total</th>
                <th class="text-right py-3 text-[10px] uppercase tracking-wider text-secondary-text font-medium">Tanggal</th>
            </tr></thead>
            <tbody>
                @foreach($orders as $order)
                <tr class="border-b border-cream-mid hover:bg-cream-warm transition-colors">
                    <td class="py-3"><a href="{{ route('admin.orders.show', $order) }}" class="text-espresso-deep hover:text-gold font-medium">{{ $order->order_code }}</a></td>
                    <td class="py-3 text-secondary-text">{{ $order->buyer->name }}</td>
                    <td class="py-3"><span class="px-2 py-0.5 text-[9px] uppercase tracking-wider @switch($order->status_color) @case('yellow') bg-yellow-50 text-yellow-700 @break @case('blue') bg-blue-50 text-blue-700 @break @case('green') bg-green-50 text-green-700 @break @case('red') bg-red-50 text-red-700 @break @default bg-gray-50 text-gray-700 @endswitch">{{ $order->status_label }}</span></td>
                    <td class="py-3 text-right font-display italic">{{ $order->formatted_total }}</td>
                    <td class="py-3 text-right text-secondary-text text-[10px]">{{ $order->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-8">{{ $orders->links() }}</div>
</div>
@endsection
