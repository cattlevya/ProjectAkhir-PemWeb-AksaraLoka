@extends('layouts.seller')

@section('title', 'Manage Products')

@section('content')
<!-- Header Section -->
<header class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
    <div>
        <nav class="flex items-center gap-3 mb-4">
            <span class="text-secondary font-bold text-sm tracking-wider uppercase font-label">Gallery</span>
            <div class="h-[1px] w-10 bg-outline-variant/20"></div>
            <span class="text-on-surface-variant/60 text-sm font-label">Manage Collection</span>
        </nav>
        <h2 class="text-4xl font-black text-primary tracking-tighter">Your Masterpieces</h2>
    </div>
    <a href="{{ route('seller.products.create') }}" class="bg-secondary text-on-secondary px-8 py-4 rounded-xl font-bold flex items-center gap-2 hover:opacity-90 transition-all active:scale-95">
        <span class="material-symbols-outlined">add_circle</span>
        Curate New Piece
    </a>
</header>

@if($products->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
    @foreach($products as $product)
    <div class="bg-surface-container-low rounded-3xl overflow-hidden border border-outline-variant/10 group flex flex-col">
        <div class="aspect-[4/5] overflow-hidden relative">
            <img src="{{ $product->primaryImageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
            <div class="absolute top-4 right-4">
                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $product->is_active ? 'bg-secondary text-on-secondary' : 'bg-surface-variant text-on-surface-variant' }}">
                    {{ $product->is_active ? 'Active' : 'Private' }}
                </span>
            </div>
        </div>
        <div class="p-8 flex-1 flex flex-col">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="font-headline text-xl font-bold text-primary group-hover:text-secondary transition-colors">{{ $product->name }}</h3>
                    <p class="text-on-surface-variant text-xs font-medium uppercase tracking-widest mt-1">{{ $product->category->name ?? 'Uncategorized' }}</p>
                </div>
                <span class="font-headline text-lg font-black text-secondary">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            </div>
            
            <div class="flex items-center gap-6 mt-2 mb-8 text-[11px] font-bold text-primary/40 uppercase tracking-widest">
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">inventory_2</span>
                    Stock: {{ $product->stock }}
                </div>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">weight</span>
                    {{ $product->weight }}g
                </div>
            </div>

            <div class="mt-auto flex gap-3 pt-6 border-t border-outline-variant/10">
                <a href="{{ route('seller.products.edit', $product) }}" class="flex-1 bg-primary text-on-primary py-3 rounded-xl text-[10px] font-black uppercase tracking-widest text-center hover:bg-primary-container transition-all">
                    Edit Piece
                </a>
                <form action="{{ route('seller.products.destroy', $product) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to remove this piece from the gallery?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full border border-error/20 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest text-error hover:bg-error/5 transition-all">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="mt-12">
    {{ $products->links() }}
</div>
@else
<div class="bg-surface-container-low rounded-3xl p-20 flex flex-col items-center justify-center border-2 border-dashed border-outline-variant/20">
    <div class="w-20 h-20 bg-surface-container-high rounded-full flex items-center justify-center mb-6">
        <span class="material-symbols-outlined text-4xl text-primary/20">brush</span>
    </div>
    <h3 class="font-headline text-2xl font-bold text-primary mb-2">No masterpieces yet</h3>
    <p class="text-on-surface-variant mb-8 max-w-xs text-center">Start curating your collection to share the heritage of Banyumas with the world.</p>
    <a href="{{ route('seller.products.create') }}" class="bg-secondary text-on-secondary px-10 py-4 rounded-xl font-black uppercase tracking-widest text-xs hover:opacity-90 transition-all">
        Add Your First Product
    </a>
</div>
@endif
@endsection
