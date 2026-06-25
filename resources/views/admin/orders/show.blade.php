@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <p class="text-[11px] uppercase tracking-[0.3em] text-gold mb-3">Admin — Pesanan</p>
    <h1 class="font-display text-3xl text-espresso-deep mb-2">{{ $order->order_code }}</h1>
    <p class="text-sm text-secondary-text mb-8">{{ $order->created_at->format('d M Y, H:i') }} · {{ $order->buyer->name }} ({{ $order->buyer->email }})</p>

    <span class="inline-block px-4 py-2 text-[11px] uppercase tracking-wider mb-8 @switch($order->status_color) @case('yellow') bg-yellow-50 text-yellow-700 @break @case('blue') bg-blue-50 text-blue-700 @break @case('green') bg-green-50 text-green-700 @break @case('red') bg-red-50 text-red-700 @break @default bg-gray-50 text-gray-700 @endswitch">{{ $order->status_label }}</span>

    <div class="bg-cream-warm p-6 mb-6">
        <h2 class="text-[11px] uppercase tracking-[0.2em] text-secondary-text mb-4">Semua Item</h2>
        @foreach($order->items as $item)
        <div class="flex items-center gap-4 py-3 border-b border-cream-mid last:border-0">
            <div class="flex-1">
                <p class="text-sm font-medium text-espresso-deep">{{ $item->product->name ?? '—' }}</p>
                <p class="text-[10px] text-secondary-text">{{ $item->store->store_name ?? '' }} · {{ $item->qty }}x @ {{ $item->formatted_price }}</p>
            </div>
            <p class="text-sm font-display italic">{{ $item->formatted_subtotal }}</p>
        </div>
        @endforeach
        <div class="flex justify-between pt-4 mt-2 font-semibold">
            <span>Total</span><span class="font-display text-lg italic">{{ $order->formatted_total }}</span>
        </div>
    </div>

    <div class="bg-cream-warm p-6 mb-6">
        <h2 class="text-[11px] uppercase tracking-[0.2em] text-secondary-text mb-2">Alamat</h2>
        <p class="text-sm text-espresso-mid">{{ $order->shipping_address }}</p>
    </div>

    @if($order->payment_proof)
    <div class="bg-cream-warm p-6 mb-6">
        <h2 class="text-[11px] uppercase tracking-[0.2em] text-secondary-text mb-4">Bukti Pembayaran</h2>
        <img src="{{ asset('storage/' . $order->payment_proof) }}" class="max-w-xs">
    </div>
    @endif

    <a href="{{ route('admin.orders.index') }}" class="text-sm text-secondary-text hover:text-gold transition-colors">← Kembali</a>
</div>
@endsection
