@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <p class="text-[11px] uppercase tracking-[0.3em] text-gold mb-3">Akun</p>
    <h1 class="font-display text-3xl text-espresso-deep mb-10">Pesanan Saya</h1>

    @if($orders->count() > 0)
    <div class="space-y-6">
        @foreach($orders as $order)
        <a href="{{ route('orders.show', $order) }}" class="block bg-cream-warm p-6 hover:bg-cream-mid transition-colors group">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-sm font-medium text-espresso-deep">{{ $order->order_code }}</p>
                    <p class="text-[10px] text-secondary-text mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                <span class="px-3 py-1 text-[10px] uppercase tracking-wider font-medium
                    @switch($order->status_color)
                        @case('yellow') bg-yellow-50 text-yellow-700 @break
                        @case('blue') bg-blue-50 text-blue-700 @break
                        @case('indigo') bg-indigo-50 text-indigo-700 @break
                        @case('purple') bg-purple-50 text-purple-700 @break
                        @case('green') bg-green-50 text-green-700 @break
                        @case('red') bg-red-50 text-red-700 @break
                        @default bg-gray-50 text-gray-700
                    @endswitch">
                    {{ $order->status_label }}
                </span>
            </div>
            <div class="flex items-center justify-between">
                <p class="text-[10px] text-secondary-text">{{ $order->items->count() }} produk</p>
                <p class="font-display italic text-espresso-deep">{{ $order->formatted_total }}</p>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="text-center py-20">
        <p class="text-secondary-text mb-4">Belum ada pesanan.</p>
        <a href="{{ route('catalog.index') }}" class="inline-block bg-espresso text-cream px-8 py-3 text-[11px] uppercase tracking-[0.2em] hover:bg-espresso-deep transition-colors">Mulai Belanja</a>
    </div>
    @endif
</div>
@endsection
