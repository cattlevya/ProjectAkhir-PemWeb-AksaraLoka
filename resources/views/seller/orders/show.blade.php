@extends('layouts.seller')

@section('title', 'Order Review | Artisan Console')

@section('content')
<div class="px-4 py-8 max-w-5xl mx-auto">
    {{-- Header --}}
    <header class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('seller.orders.index') }}" class="text-brand-brown hover:text-brand-indigo transition-colors">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                </a>
                <span class="text-brand-brown font-bold text-xs uppercase tracking-[0.3em] font-['Manrope']">Order Review</span>
            </div>
            <h1 class="text-5xl font-black tracking-tight text-brand-indigo font-['Epilogue']">{{ $order->order_code }}</h1>
            <p class="text-on-surface-variant mt-2 font-medium font-['Manrope']">
                Placed on {{ $order->created_at->format('d F Y, H:i') }} · By <span class="text-brand-indigo font-bold">{{ $order->buyer->name }}</span>
            </p>
        </div>
        
        <div class="flex items-center gap-3">
            <span class="px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-[0.2em] shadow-sm border
                @switch($order->status_color) 
                    @case('yellow') bg-amber-50 text-amber-800 border-amber-200 @break 
                    @case('blue') bg-blue-50 text-blue-800 border-blue-200 @break 
                    @case('indigo') bg-brand-indigo/10 text-brand-indigo border-brand-indigo/20 @break 
                    @case('green') bg-emerald-50 text-emerald-800 border-emerald-200 @break 
                    @case('red') bg-red-50 text-red-800 border-red-200 @break 
                    @default bg-surface-container text-on-surface-variant border-outline-variant/30 
                @endswitch">
                {{ $order->status_label }}
            </span>
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <div class="lg:col-span-8 space-y-12">
            {{-- 1. Order Items --}}
            <section class="bg-surface-container-low p-10 rounded-3xl border border-outline-variant/20 shadow-xl relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-brand-indigo/10 rounded-xl flex items-center justify-center text-brand-indigo">
                            <span class="material-symbols-outlined">inventory_2</span>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-brand-indigo font-['Epilogue']">Ordered Items</h2>
                            <p class="text-xs text-on-surface-variant font-medium font-['Manrope'] uppercase tracking-widest">Products from your store</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @php $storeSubtotal = 0; @endphp
                        @foreach($order->items as $item)
                        @php $storeSubtotal += $item->subtotal; @endphp
                        <div class="flex items-center gap-6 p-4 rounded-2xl hover:bg-surface-bright transition-colors group">
                            <div class="w-20 h-20 rounded-xl overflow-hidden shadow-md flex-shrink-0">
                                @if($item->product)
                                    <img src="{{ $item->product->primary_image_url }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-surface-container flex items-center justify-center">
                                        <span class="material-symbols-outlined text-outline-variant">image</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-brand-indigo text-lg">{{ $item->product->name ?? 'Deleted Product' }}</h4>
                                <p class="text-sm text-on-surface-variant font-medium font-['Manrope']">
                                    {{ $item->qty }} unit × Rp {{ number_format($item->price, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-black text-brand-brown font-['Epilogue'] italic">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-10 pt-8 border-t border-outline-variant/30 flex justify-between items-center px-4">
                        <span class="text-sm font-bold uppercase tracking-widest text-on-surface-variant">Merchant Earnings</span>
                        <span class="text-3xl font-black text-brand-brown font-['Epilogue']">
                            Rp {{ number_format($storeSubtotal, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
                <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[120px] opacity-[0.03] text-brand-indigo select-none">shopping_basket</span>
            </section>

            {{-- 2. Shipping Details --}}
            <section class="bg-surface-container-low p-10 rounded-3xl border border-outline-variant/20 shadow-xl relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-brand-brown/10 rounded-xl flex items-center justify-center text-brand-brown">
                            <span class="material-symbols-outlined">local_shipping</span>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-brand-indigo font-['Epilogue']">Shipping Address</h2>
                            <p class="text-xs text-on-surface-variant font-medium font-['Manrope'] uppercase tracking-widest">Delivery Destination</p>
                        </div>
                    </div>
                    <div class="bg-surface-bright p-6 rounded-2xl border border-outline-variant/10 italic text-brand-indigo font-medium leading-relaxed font-['Manrope']">
                        {{ $order->shipping_address }}
                    </div>
                </div>
            </section>
        </div>

        <div class="lg:col-span-4 space-y-12">
            {{-- 3. Payment Proof --}}
            <section class="bg-surface-container-low p-8 rounded-3xl border border-outline-variant/20 shadow-xl relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-10 h-10 bg-brand-ochre/10 rounded-xl flex items-center justify-center text-brand-ochre">
                            <span class="material-symbols-outlined">receipt_long</span>
                        </div>
                        <h2 class="text-xl font-bold text-brand-indigo font-['Epilogue']">Payment</h2>
                    </div>

                    @if($order->payment_proof)
                        <div class="relative group cursor-pointer rounded-2xl overflow-hidden border-2 border-brand-ochre/20 shadow-inner" 
                             onclick="window.open('{{ asset('storage/' . $order->payment_proof) }}', '_blank')">
                            <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-full object-cover max-h-96 group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-brand-indigo/60 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all text-white">
                                <span class="text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                    View Full Proof
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="py-12 flex flex-col items-center justify-center text-center bg-surface-bright rounded-2xl border-2 border-dashed border-outline-variant/30">
                            <span class="material-symbols-outlined text-4xl text-outline-variant mb-4 opacity-50">pending_actions</span>
                            <p class="text-xs font-bold text-on-surface-variant uppercase tracking-widest">No Proof Uploaded</p>
                        </div>
                    @endif
                </div>
            </section>

            {{-- 4. Status Update (Quick Action) --}}
            <section class="bg-brand-indigo text-white p-8 rounded-3xl shadow-xl relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-lg font-bold font-['Epilogue'] text-brand-ochre mb-4 uppercase tracking-widest">Update Status</h3>
                    <form action="{{ route('seller.orders.update-status', $order->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('patch')
                        <select name="status" class="w-full bg-white/10 border-2 border-white/10 rounded-xl px-4 py-3 text-sm font-bold text-white focus:border-brand-ochre outline-none transition-all">
                            <option value="menunggu_pembayaran" class="text-brand-indigo" {{ $order->status == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                            <option value="dibayar" class="text-brand-indigo" {{ $order->status == 'dibayar' ? 'selected' : '' }}>Dibayar (Bukti Valid)</option>
                            <option value="diproses" class="text-brand-indigo" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses (Sedang Packing)</option>
                            <option value="dikirim" class="text-brand-indigo" {{ $order->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="selesai" class="text-brand-indigo" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" class="text-brand-indigo" {{ $order->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        <button type="submit" class="w-full bg-brand-ochre text-brand-indigo py-4 rounded-xl font-bold tracking-tight hover:brightness-110 transition-all shadow-lg active:scale-95 border-none cursor-pointer font-['Epilogue']">
                            Apply Changes
                        </button>
                    </form>
                </div>
                <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[100px] opacity-[0.05] text-white select-none">edit_note</span>
            </section>
        </div>
    </div>
</div>
@endsection
