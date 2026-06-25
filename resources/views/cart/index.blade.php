@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-6 pt-12 md:pt-20 pb-24">
    {{-- Artisan Breadcrumb --}}
    <div class="flex items-center space-x-4 mb-12">
        <span class="text-secondary font-semibold text-sm tracking-widest uppercase font-['Manrope']">Seleksi Anda</span>
        <div class="h-[1px] w-12 bg-outline-variant/20"></div>
        <span class="text-outline text-sm font-['Manrope']">Detail Keranjang</span>
    </div>

    <h1 class="text-4xl md:text-6xl font-bold text-primary mb-16 tracking-tighter leading-none font-['Epilogue']">
        Akuisisi <br/><span class="text-secondary">Pilihan</span>
    </h1>

    @if(count($cartItems) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            {{-- Cart Items List --}}
            <div class="lg:col-span-8 space-y-12">
                @foreach($cartItems as $productId => $item)
                    <div class="group grid grid-cols-1 md:grid-cols-4 gap-8 pb-12 border-b border-outline-variant/10">
                        <div class="md:col-span-1">
                            <div class="aspect-[4/5] overflow-hidden bg-surface-container-low">
                                <img src="{{ $item['image'] }}" 
                                     alt="{{ $item['name'] }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            </div>
                        </div>
                        <div class="md:col-span-3 flex flex-col justify-between py-2">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-[10px] uppercase tracking-[0.2em] text-secondary font-bold mb-2 font-['Manrope']">
                                        {{ $item['category'] ?? 'Produk UMKM' }}
                                    </p>
                                    <h3 class="text-2xl font-bold text-primary mb-1 font-['Epilogue']">
                                        {{ $item['name'] }}
                                    </h3>
                                    <p class="text-on-surface-variant text-sm font-medium font-['Manrope']">
                                        {{ $item['store_name'] ?? 'Pengrajin Lokal' }}
                                    </p>
                                </div>
                                <p class="text-xl font-black text-primary font-['Epilogue'] whitespace-nowrap flex-shrink-0 ml-4">
                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                </p>
                            </div>
                            
                            <div class="flex items-center justify-between mt-8">
                                {{-- Qty Controls --}}
                                <div class="flex items-center bg-surface-container-low px-4 py-2 space-x-6">
                                    <form action="{{ route('cart.update') }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="product_id" value="{{ $productId }}">
                                        <button type="submit" name="qty" value="{{ max(1, $item['qty'] - 1) }}" 
                                                class="text-primary hover:text-secondary transition-colors">
                                            <span class="material-symbols-outlined text-sm">remove</span>
                                        </button>
                                    </form>
                                    
                                    <span class="text-sm font-bold text-primary w-4 text-center font-['Manrope']">{{ $item['qty'] }}</span>
                                    
                                    <form action="{{ route('cart.update') }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="product_id" value="{{ $productId }}">
                                        <button type="submit" name="qty" value="{{ $item['qty'] + 1 }}" 
                                                class="text-primary hover:text-secondary transition-colors">
                                            <span class="material-symbols-outlined text-sm">add</span>
                                        </button>
                                    </form>
                                </div>

                                {{-- Remove Action --}}
                                <form action="{{ route('cart.remove', $productId) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center text-outline hover:text-error transition-colors text-[10px] font-bold uppercase tracking-widest font-['Manrope']">
                                        <span class="material-symbols-outlined text-lg mr-2">delete</span>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Summary Sidebar --}}
            <div class="lg:col-span-4">
                <div class="bg-surface-container-low p-8 md:p-10 sticky top-32">
                    <h2 class="text-xl font-bold text-primary mb-8 tracking-tight font-['Epilogue']">Ringkasan Pesanan</h2>
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between gap-4 text-sm font-medium text-on-surface-variant font-['Manrope']">
                            <span>Subtotal</span>
                            <span class="text-primary font-['Epilogue'] font-semibold whitespace-nowrap">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between gap-4 text-sm font-medium text-on-surface-variant font-['Manrope']">
                            <span>Pengiriman Terjamin</span>
                            <span class="text-primary whitespace-nowrap">Rp 0</span>
                        </div>
                        <div class="flex justify-between gap-4 text-sm font-medium text-on-surface-variant font-['Manrope']">
                            <span>Asuransi (Artisanal)</span>
                            <span class="text-primary whitespace-nowrap">Gratis</span>
                        </div>
                    </div>
                    <div class="border-t border-outline-variant/30 pt-6 mb-10">
                        <div class="flex justify-between gap-4 items-end">
                            <span class="text-sm font-bold uppercase tracking-widest text-primary font-['Manrope']">Total Investasi</span>
                            <span class="text-3xl font-black text-secondary font-['Epilogue'] whitespace-nowrap">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @auth
                        <a href="{{ route('checkout.index') }}" 
                           class="w-full bg-primary text-on-primary py-5 px-8 font-bold text-sm uppercase tracking-[0.2em] shadow-lg hover:bg-brand-indigo/90 transition-all flex items-center justify-center group font-['Manrope']">
                            Lanjut ke Checkout
                            <span class="material-symbols-outlined ml-3 transition-transform group-hover:translate-x-1">arrow_forward</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="w-full bg-primary text-on-primary py-5 px-8 font-bold text-sm uppercase tracking-[0.2em] shadow-lg hover:bg-brand-indigo/90 transition-all flex items-center justify-center group font-['Manrope']">
                            Login untuk Checkout
                            <span class="material-symbols-outlined ml-3 transition-transform group-hover:translate-x-1">arrow_forward</span>
                        </a>
                    @endauth

                    <div class="mt-8 flex items-center justify-center space-x-6 text-outline-variant">
                        <span class="material-symbols-outlined text-3xl">encrypted</span>
                        <span class="material-symbols-outlined text-3xl">verified</span>
                        <span class="material-symbols-outlined text-3xl">public</span>
                    </div>
                    <p class="mt-8 text-center text-[10px] text-on-surface-variant/60 uppercase tracking-widest leading-relaxed font-['Manrope']">
                        Bersumber Etis • Keaslian Mahakarya Terjamin • Transportasi Karbon Netral
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-32 border border-dashed border-outline-variant/30 bg-surface-container-low/30">
            <span class="material-symbols-outlined text-6xl text-outline-variant mb-6">shopping_bag</span>
            <h2 class="text-2xl font-bold text-primary mb-2 font-['Epilogue']">Keranjang Anda Kosong</h2>
            <p class="text-on-surface-variant mb-10 font-['Manrope']">Mulailah mengkurasi koleksi UMKM pilihan Anda.</p>
            <a href="{{ route('catalog.index') }}" 
               class="inline-block bg-primary text-on-primary px-10 py-4 font-bold text-sm uppercase tracking-[0.2em] hover:bg-brand-indigo/90 transition-all font-['Manrope']">
                Jelajahi Katalog
            </a>
        </div>
    @endif

    {{-- Featured Collections Hint --}}
    <section class="mt-32 pt-20 border-t border-outline-variant/10">
        <h4 class="text-sm font-bold uppercase tracking-[0.3em] text-secondary mb-10 font-['Manrope']">Anda Mungkin Juga Menyukai</h4>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            {{-- Dummy suggestion items --}}
            @php
                $suggestions = [
                    ['img' => 'images/dummy/batik.png', 'alt' => 'Batik Pattern'],
                    ['img' => 'images/dummy/login_editorial.png', 'alt' => 'Artisan Hands'],
                    ['img' => 'images/dummy/register_editorial.png', 'alt' => 'Banyumas Landscape'],
                    ['img' => 'images/dummy/nopia.png', 'alt' => 'Kuliner Nusantara'],
                ];
            @endphp
            @foreach($suggestions as $suggest)
                <div class="aspect-square bg-surface-container overflow-hidden">
                    <img src="{{ asset($suggest['img']) }}" 
                         alt="{{ $suggest['alt'] }}" 
                         class="w-full h-full object-cover opacity-60 hover:opacity-100 transition-opacity">
                </div>
            @endforeach
        </div>
    </section>
</main>
@endsection
