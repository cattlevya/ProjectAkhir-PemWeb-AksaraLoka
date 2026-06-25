@extends('layouts.seller')

@section('title', 'Dashboard')

@section('content')
<!-- Header Section -->
<header class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
    <div>
        <nav class="flex items-center gap-3 mb-4">
            <span class="text-secondary font-bold text-sm tracking-wider uppercase font-label">{{ $store->store_name ?? 'Toko Anda' }}</span>
            <div class="h-[1px] w-10 bg-outline-variant/20"></div>
            <span class="text-on-surface-variant/60 text-sm font-label">Dashboard Overview</span>
        </nav>
        <h2 class="text-4xl font-black text-primary tracking-tighter">Artisan Console</h2>
    </div>
    <div class="flex items-center gap-4">
        <div class="bg-surface-container-low px-6 py-3 flex flex-col items-end rounded-lg">
            <span class="text-[10px] uppercase tracking-[0.2em] text-primary/40 font-bold">Total Revenue</span>
            <span class="text-xl font-black text-secondary">Rp {{ isset($stats['total_revenue']) ? number_format($stats['total_revenue'], 0, ',', '.') : '0' }}</span>
        </div>
    </div>
</header>

<!-- Stats Bento Grid -->
<section class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-16">
    <div class="md:col-span-2 bg-primary-container p-8 text-on-primary relative overflow-hidden flex flex-col justify-between h-64 group rounded-2xl">
        <div class="relative z-10">
            <span class="material-symbols-outlined text-4xl text-secondary-container mb-4">auto_stories</span>
            <h3 class="text-2xl font-bold tracking-tight">Active Collections</h3>
            <p class="text-on-primary/60 mt-2 max-w-xs">You have {{ $stats['total_products'] ?? 0 }} heritage pieces currently listed in the global gallery.</p>
        </div>
        <div class="relative z-10 flex items-baseline gap-2">
            <span class="text-5xl font-black italic">{{ $stats['total_products'] ?? 0 }}</span>
            <span class="text-sm uppercase tracking-widest opacity-60">Handcrafted Items</span>
        </div>
    </div>
    <div class="bg-surface-container-low p-8 flex flex-col justify-between h-64 rounded-2xl">
        <div>
            <span class="material-symbols-outlined text-secondary text-3xl">pending_actions</span>
            <p class="text-sm font-bold mt-4 uppercase tracking-tighter text-on-surface-variant">Pending Orders</p>
        </div>
        <div>
            <span class="text-4xl font-black text-primary">{{ isset($stats['pending_orders']) ? sprintf("%02d", $stats['pending_orders']) : '00' }}</span>
            <div class="flex items-center text-error text-xs font-bold mt-1">
                <span class="material-symbols-outlined text-sm">priority_high</span> Action Required
            </div>
        </div>
    </div>
    <div class="bg-surface-container-high p-8 flex flex-col justify-between h-64 rounded-2xl">
        <div>
            <span class="material-symbols-outlined text-secondary text-3xl">check_circle</span>
            <p class="text-sm font-bold mt-4 uppercase tracking-tighter text-on-surface-variant">Completed Sales</p>
        </div>
        <div>
            <span class="text-4xl font-black text-primary">{{ isset($stats['total_orders']) ? sprintf("%02d", $stats['total_orders']) : '00' }}</span>
            <p class="text-xs text-primary/40 font-medium mt-1">Successful Shipments</p>
        </div>
    </div>
</section>

<!-- Workflow Split -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-12">
    <!-- Pesanan Masuk (Order Workflow) -->
    <section class="xl:col-span-2">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-black text-primary tracking-tight">Pesanan Masuk</h3>
        </div>
        
        <div class="space-y-6">
            @forelse($recentOrders as $order)
            <!-- Dynamic Order Item -->
            <div class="bg-surface-container-low p-6 flex flex-col md:flex-row gap-6 items-start md:items-center rounded-2xl border border-outline-variant/10">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-1">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-primary/40">#{{ $order->id }}</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase 
                            @if($order->status === 'menunggu_pembayaran') bg-yellow-100 text-yellow-800 
                            @elseif($order->status === 'dikirim') bg-blue-100 text-blue-800 
                            @else bg-surface-variant text-primary/60 @endif">
                            {{ str_replace('_', ' ', $order->status) }}
                        </span>
                    </div>
                    <h4 class="font-bold text-lg text-primary">{{ $order->items->first()->product->name ?? 'Produk Dihapus' }} @if($order->items->count() > 1) <span class="text-xs text-secondary font-bold">+{{ $order->items->count() - 1 }} lainnya</span> @endif</h4>
                    <p class="text-sm text-on-surface-variant">Buyer: {{ $order->shipping_name ?? $order->buyer->name }}</p>
                </div>
                <div class="text-right w-full md:w-auto">
                    <p class="font-black text-primary mb-2">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    <a href="{{ route('seller.orders.show', $order) }}" class="bg-secondary text-on-secondary px-6 py-2 rounded text-xs font-black uppercase tracking-widest hover:opacity-90 inline-block">Detail</a>
                </div>
            </div>
            @empty
            <div class="bg-surface-container-low p-12 flex flex-col items-center justify-center rounded-2xl border border-outline-variant/10 text-center">
                <span class="material-symbols-outlined text-4xl text-primary/20 mb-4">inventory_2</span>
                <p class="font-bold text-primary">Belum ada pesanan masuk</p>
                <p class="text-xs text-on-surface-variant mt-2">Pesanan baru akan muncul di sini</p>
            </div>
            @endforelse
        </div>
    </section>

    <!-- Product Management Quick Actions -->
    <section class="bg-surface-container-high/40 p-8 rounded-2xl border border-outline-variant/10">
        <div class="flex items-center gap-3 mb-8">
            <span class="material-symbols-outlined text-secondary">brush</span>
            <h3 class="text-xl font-black text-primary tracking-tight">Curate New Piece</h3>
        </div>
        <div class="flex flex-col gap-4">
            <a href="{{ route('seller.products.create') }}" class="bg-primary text-on-primary p-6 rounded-xl flex items-center justify-between group hover:bg-primary-container transition-all">
                <div>
                    <p class="font-bold">Upload Product</p>
                    <p class="text-[10px] uppercase tracking-widest opacity-60">Add to collection</p>
                </div>
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">add_circle</span>
            </a>
            <a href="{{ route('seller.products.index') }}" class="bg-surface-container-low text-primary p-6 rounded-xl flex items-center justify-between group hover:bg-surface-container transition-all border border-outline-variant/20">
                <div>
                    <p class="font-bold">Manage Gallery</p>
                    <p class="text-[10px] uppercase tracking-widest opacity-60">View all items</p>
                </div>
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </a>
        </div>
    </section>
</div>
@endsection
