@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 pt-12 md:pt-20 pb-24">
    {{-- Artisan Breadcrumb --}}
    <div class="flex items-center space-x-4 mb-12">
        <span class="text-secondary font-semibold text-sm tracking-widest uppercase font-['Manrope']">Akun Saya</span>
        <div class="h-[1px] w-12 bg-outline-variant/20"></div>
        <span class="text-outline text-sm font-['Manrope']">Daftar Keinginan</span>
    </div>

    <h1 class="text-4xl md:text-6xl font-bold text-primary mb-16 tracking-tighter leading-none font-['Epilogue']">
        Wishlist <br/><span class="text-secondary">Anda</span>
    </h1>

    @if($wishlists->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($wishlists as $wishlist)
                <div class="group relative aspect-[4/5] bg-surface-container-low rounded-xl overflow-hidden shadow-lg editorial-shadow border-none block">
                    <a href="{{ route('product.show', $wishlist->product->slug) }}" class="absolute inset-0 z-10"></a>
                    
                    <img src="{{ $wishlist->product->primaryImageUrl }}" alt="{{ $wishlist->product->name }}" 
                         class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 md:group-hover:scale-105" />
                         
                    @if(!$wishlist->product->is_in_stock)
                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center pointer-events-none">
                            <span class="bg-error text-white text-[10px] font-bold uppercase tracking-widest px-4 py-2 rounded-full backdrop-blur-md">Habis</span>
                        </div>
                    @endif

                    <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 bg-gradient-to-t from-primary/90 via-primary/50 to-transparent pointer-events-none translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500">
                        <h3 class="font-['Epilogue'] text-2xl font-bold tracking-tight text-brand-cream line-clamp-1">
                            {{ $wishlist->product->name }}
                        </h3>
                        <p class="text-outline-variant text-sm font-medium mt-1 font-['Manrope'] line-clamp-1">
                            {{ $wishlist->product->store->store_name }}
                        </p>
                        <span class="font-['Epilogue'] text-xl font-bold text-brand-ochre block mt-3">
                            {{ $wishlist->product->formattedPrice }}
                        </span>
                    </div>

                    {{-- Remove and Add to cart buttons (z-20 to be clickable above the a tag) --}}
                    <div class="absolute top-4 right-4 z-20 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        {{-- Remove --}}
                        <form action="{{ route('wishlist.destroy', $wishlist->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-10 h-10 rounded-full bg-white/90 text-error flex items-center justify-center hover:bg-error hover:text-white transition-colors shadow-lg" title="Hapus dari Wishlist">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </form>

                        {{-- Add to Cart --}}
                        @if($wishlist->product->is_in_stock)
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $wishlist->product->id }}">
                            <input type="hidden" name="qty" value="1">
                            <button type="submit" class="w-10 h-10 rounded-full bg-brand-brown/90 text-white flex items-center justify-center hover:bg-brand-brown transition-colors shadow-lg" title="Tambah ke Keranjang">
                                <span class="material-symbols-outlined text-[18px]">shopping_bag</span>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-32 border border-dashed border-outline-variant/30 bg-surface-container-low/30">
            <span class="material-symbols-outlined text-6xl text-outline-variant mb-6">favorite_border</span>
            <h2 class="text-2xl font-bold text-primary mb-2 font-['Epilogue']">Wishlist Anda Kosong</h2>
            <p class="text-on-surface-variant mb-10 font-['Manrope']">Simpan produk favorit Anda untuk dibeli nanti.</p>
            <a href="{{ route('catalog.index') }}" 
               class="inline-block bg-primary text-on-primary px-10 py-4 font-bold text-sm uppercase tracking-[0.2em] hover:bg-brand-indigo/90 transition-all font-['Manrope']">
                Temukan Produk
            </a>
        </div>
    @endif
</main>
@endsection
