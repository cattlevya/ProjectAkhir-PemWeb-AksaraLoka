@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <p class="text-[11px] uppercase tracking-[0.3em] text-gold mb-3">Pesanan</p>
    <h1 class="font-display text-3xl text-espresso-deep mb-8">Pesanan Masuk</h1>

    {{-- Status Filter --}}
    <div class="flex flex-wrap gap-2 mb-8">
        <a href="{{ route('seller.orders.index') }}" class="px-4 py-1.5 text-[10px] uppercase tracking-wider {{ !$status ? 'bg-espresso text-cream' : 'border border-espresso-mid/20 text-espresso-mid hover:border-gold hover:text-gold' }} transition-colors">Semua</a>
        @foreach(\App\Models\Order::STATUS_LABELS as $key => $label)
            <a href="{{ route('seller.orders.index', ['status' => $key]) }}" class="px-4 py-1.5 text-[10px] uppercase tracking-wider {{ $status === $key ? 'bg-espresso text-cream' : 'border border-espresso-mid/20 text-espresso-mid hover:border-gold hover:text-gold' }} transition-colors">{{ $label }}</a>
        @endforeach
    </div>

    @if($orders->count() > 0)
    <div class="space-y-4">
        @foreach($orders as $order)
        <div class="bg-cream-warm p-6">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <a href="{{ route('seller.orders.show', $order) }}" class="font-medium text-espresso-deep hover:text-gold">{{ $order->order_code }}</a>
                    <p class="text-[10px] text-secondary-text mt-1">{{ $order->buyer->name }} · {{ $order->created_at->format('d M Y') }}</p>
                </div>
                <span class="px-3 py-1 text-[9px] uppercase tracking-wider
                    @switch($order->status_color) @case('yellow') bg-yellow-50 text-yellow-700 @break @case('blue') bg-blue-50 text-blue-700 @break @case('indigo') bg-indigo-50 text-indigo-700 @break @case('green') bg-green-50 text-green-700 @break @case('red') bg-red-50 text-red-700 @break @default bg-gray-50 text-gray-700 @endswitch">
                    {{ $order->status_label }}
                </span>
            </div>

            {{-- Items preview --}}
            @foreach($order->items as $item)
            <div class="flex items-center gap-3 text-sm py-1">
                <span class="text-secondary-text">{{ $item->product->name ?? '—' }} × {{ $item->qty }}</span>
                <span class="text-espresso-mid font-display italic ml-auto">{{ $item->formatted_subtotal }}</span>
            </div>
            @endforeach

            {{-- Status Update Form --}}
            @if(count($order->getValidTransitions()) > 0)
            <form action="{{ route('seller.orders.update-status', $order) }}" method="POST" class="mt-4 pt-4 border-t border-cream-mid flex items-center gap-3">
                @csrf @method('PATCH')
                <select name="status" class="bg-cream border border-cream-mid px-3 py-1.5 text-sm focus:border-gold focus:ring-0">
                    @foreach($order->getValidTransitions() as $transition)
                        <option value="{{ $transition }}">{{ \App\Models\Order::STATUS_LABELS[$transition] }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-espresso text-cream px-4 py-1.5 text-[10px] uppercase tracking-wider hover:bg-espresso-deep transition-colors">Update</button>
            </form>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <p class="text-secondary-text text-center py-10">Tidak ada pesanan{{ $status ? ' dengan status ini' : '' }}.</p>
    @endif
</div>
@endsection
