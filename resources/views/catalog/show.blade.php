@extends('layouts.app')
@section('content')

<main class="pt-24 pb-32">
  <div class="max-w-screen-2xl mx-auto px-6">

    {{-- Breadcrumbs --}}
    <div class="mb-12 flex items-center gap-2 mt-4">
      <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}"
         class="text-[10px] font-bold uppercase tracking-[0.2em] text-brand-brown hover:text-brand-indigo transition-colors font-['Manrope']">
        {{ $product->category->name }}
      </a>
      <span class="w-8 h-[1px] bg-outline-variant"></span>
      <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-on-surface-variant font-['Manrope']">
        {{ $product->store->store_name }}
      </span>
    </div>

    {{-- Main Layout: 7/5 split --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">

      {{-- LEFT: Dynamic Image Gallery (7 cols) --}}
      <div class="lg:col-span-7 space-y-6" x-data="{ activeImg: '{{ $product->images->count() > 0 ? $product->images->first()->url : asset('images/dummy/hero_banyumas.png') }}' }">
        
        {{-- Main Viewer --}}
        <div class="relative rounded-2xl overflow-hidden shadow-2xl editorial-shadow bg-surface-container-low group">
            <img :src="activeImg" 
                 class="w-full aspect-[4/5] object-cover transition-all duration-700 group-hover:scale-105" 
                 alt="{{ $product->name }}" />
            
            <div class="absolute bottom-6 right-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div class="w-12 h-12 rounded-full bg-white/10 backdrop-blur-md flex items-center justify-center text-white">
                    <span class="material-symbols-outlined">zoom_in</span>
                </div>
            </div>
        </div>

        {{-- Thumbnail Gallery --}}
        @if($product->images->count() > 1)
        <div class="grid grid-cols-4 md:grid-cols-6 gap-4">
            @foreach($product->images as $index => $image)
            <button @click="activeImg = '{{ $image->url }}'"
                    class="relative aspect-square rounded-xl overflow-hidden transition-all duration-300 border-2 {{ $index > 5 ? 'hidden md:block' : '' }}"
                    :class="activeImg === '{{ $image->url }}' ? 'border-brand-brown shadow-lg scale-95 z-10' : 'border-transparent opacity-60 hover:opacity-100'">
                <img src="{{ $image->url }}" class="w-full h-full object-cover" alt="Detail {{ $index + 1 }}" />
                <div class="absolute inset-0 bg-brand-brown/10 active:bg-brand-brown/20 transition-colors"></div>
            </button>
            @endforeach
        </div>
        @elseif($product->images->count() == 0)
          <div class="p-8 bg-surface-container-low rounded-xl text-center text-on-surface-variant italic font-['Manrope'] opacity-50 border border-dashed border-outline-variant">
            ~ Tidak ada foto tambahan tersedia ~
          </div>
        @endif
      </div>

      {{-- RIGHT: Product Info (5 cols) --}}
      <div class="lg:col-span-5 sticky top-32 space-y-8">

        {{-- Title & Artist --}}
        <header class="flex justify-between items-start gap-4">
          <div>
            <h1 class="font-['Epilogue'] text-6xl md:text-7xl font-black tracking-tighter leading-none mb-4 text-brand-indigo">
              {{ $product->name }}
            </h1>
            <p class="text-xl text-brand-brown font-light italic font-['Manrope'] mb-2">
              Oleh {{ $product->store->store_name }}
            </p>
            @if(auth()->check() && \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists())
              <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-brown/10 text-brand-brown text-xs font-bold uppercase tracking-widest">
                <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">favorite</span>
                Tersimpan di Wishlist
              </span>
            @endif
          </div>
          <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="shrink-0">
             @csrf
             <button type="submit" class="w-14 h-14 rounded-full bg-surface-container-highest flex items-center justify-center transition-all active:scale-95 border-none shadow-sm {{ auth()->check() && \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists() ? 'text-brand-brown bg-brand-brown/20 ring-2 ring-brand-brown/30' : 'text-on-surface hover:text-brand-brown hover:bg-surface-container' }}" title="Toggle Wishlist">
                <span class="material-symbols-outlined text-3xl" {!! auth()->check() && \App\Models\Wishlist::where('user_id', auth()->id())->where('product_id', $product->id)->exists() ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>favorite</span>
             </button>
          </form>
        </header>

        {{-- Price + Stock label --}}
        <div class="flex items-baseline gap-4">
          <span class="font-['Epilogue'] text-3xl font-black text-brand-brown">
            Rp {{ number_format($product->price, 0, ',', '.') }}
          </span>
          <span class="text-xs text-on-surface-variant uppercase tracking-[0.2em] font-bold font-['Manrope']">
            Stok: {{ $product->stock }}
          </span>
        </div>

        {{-- Description --}}
        <p class="text-lg leading-relaxed text-on-surface-variant font-['Manrope']">
          {{ $product->description }}
        </p>

        {{-- Quantity + Add to cart --}}
        <div class="flex flex-col gap-4 pt-4" x-data="{ qty: 1 }">
          <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}"/>
            <input type="hidden" name="qty" x-model="qty"/>

            <button type="submit"
                    class="w-full bg-brand-brown text-white py-6 px-10 rounded-xl font-['Epilogue'] font-extrabold text-lg
                           flex items-center justify-between hover:bg-[#75390e] transition-all group active:scale-[0.98] border-none">
              <span>TAMBAH KE KERANJANG</span>
              <span class="material-symbols-outlined transition-transform group-hover:translate-x-2">arrow_forward</span>
            </button>
          </form>

          <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}"
             class="w-full bg-brand-brown/10 text-brand-brown py-6 px-10 rounded-xl font-['Epilogue'] font-extrabold text-lg
                    hover:bg-brand-brown/20 transition-all active:scale-[0.98] text-center">
            LIHAT PRODUK SERUPA
          </a>
        </div>

        {{-- Store note --}}
        <div class="p-8 bg-surface-container-low rounded-2xl relative overflow-hidden border-l-4 border-brand-ochre mt-8">
          <span class="absolute top-4 right-4 material-symbols-outlined text-brand-ochre scale-[4] opacity-10">format_quote</span>
          <h3 class="text-xs font-bold uppercase tracking-[0.3em] mb-4 text-brand-brown font-['Manrope']">
            Tentang Toko
          </h3>
          <p class="relative z-10 text-on-background italic leading-relaxed font-['Manrope']">
            "{{ $product->store->description ?? 'Produk berkualitas dari pengrajin lokal Banyumas yang berdedikasi.' }}"
          </p>
        </div>

        {{-- Specifications --}}
        <div class="pt-12 border-t border-outline-variant/30 mt-8">
          <h3 class="text-xs font-bold uppercase tracking-[0.3em] mb-6 text-brand-brown font-['Manrope']">
            Detail Produk
          </h3>
          <div class="grid grid-cols-2 gap-y-6">
            <div>
              <span class="block text-[10px] text-brand-brown uppercase font-black mb-1 font-['Manrope'] tracking-[0.2em]">Kategori</span>
              <span class="text-sm font-['Manrope']">{{ $product->category->name }}</span>
            </div>
            <div>
              <span class="block text-[10px] text-brand-brown uppercase font-black mb-1 font-['Manrope'] tracking-[0.2em]">Berat</span>
              <span class="text-sm font-['Manrope']">{{ $product->weight }}g</span>
            </div>
            <div>
              <span class="block text-[10px] text-brand-brown uppercase font-black mb-1 font-['Manrope'] tracking-[0.2em]">Toko</span>
              <span class="text-sm font-['Manrope']">{{ $product->store->store_name }}</span>
            </div>
            <div>
              <span class="block text-[10px] text-brand-brown uppercase font-black mb-1 font-['Manrope'] tracking-[0.2em]">Stok</span>
              <span class="text-sm font-['Manrope']">{{ $product->stock }} unit tersedia</span>
            </div>
          </div>
        </div>

      </div>
    </div>

    {{-- Large atmospheric banner --}}
    <section class="mt-32 relative h-[400px] rounded-3xl overflow-hidden flex items-center justify-center">
      <div class="absolute inset-0 bg-brand-indigo"></div>
      <div class="absolute inset-0 opacity-20">
        <img src="{{ $product->primaryImageUrl }}" class="w-full h-full object-cover grayscale mix-blend-overlay"/>
      </div>
      <div class="relative z-10 text-center max-w-2xl px-6">
        <h2 class="font-['Epilogue'] text-4xl md:text-5xl font-black tracking-tighter mb-6 leading-tight text-white">
          Setiap produk menyimpan cerita pengrajinnya.
        </h2>
        <p class="text-lg text-white/70 font-['Manrope']">
          AksaraLoka menghadirkan produk terbaik dari pengrajin lokal Banyumas untuk kamu.
        </p>
      </div>
    </section>

    {{-- Related Items --}}
    @if($relatedProducts->IsNotEmpty())
    <section class="mt-32">
      <div class="flex justify-between items-end mb-12">
        <div>
          <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-brown font-['Manrope']">Dari Ekosistem AksaraLoka</span>
          <h2 class="text-4xl font-black tracking-tighter mt-2 text-brand-indigo font-['Epilogue']">Mungkin Anda Suka</h2>
        </div>
        <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="group flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-brand-brown font-['Manrope']">
          Lihat Koleksi
          <span class="material-symbols-outlined transition-transform group-hover:translate-x-1">north_east</span>
        </a>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        @foreach($relatedProducts as $index => $related)
        <a href="{{ route('product.show', $related->slug) }}" class="group cursor-pointer {{ $index % 2 == 1 ? 'md:mt-12' : '' }} block border-none">
          <div class="aspect-[4/5] bg-surface-container-low rounded-xl overflow-hidden mb-4 relative shadow-lg editorial-shadow">
             <img src="{{ $related->primaryImageUrl }}" alt="{{ $related->name }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500 group-hover:scale-110" />
             @if(!$related->is_in_stock)
             <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                 <span class="bg-error text-white text-[10px] font-bold uppercase tracking-widest px-4 py-2 rounded-full backdrop-blur-md">Habis</span>
             </div>
             @endif
          </div>
          <div class="mt-6">
            <h3 class="font-['Epilogue'] text-xl font-bold tracking-tight text-brand-indigo group-hover:text-brand-brown transition-colors line-clamp-1">
              {{ $related->name }}
            </h3>
            <p class="text-on-surface-variant text-sm font-medium mt-1 font-['Manrope'] line-clamp-1">
              {{ $related->store->store_name }}
            </p>
            <span class="font-['Epilogue'] text-lg font-bold text-brand-brown block mt-3">
              {{ $related->formattedPrice }}
            </span>
          </div>
        </a>
        @endforeach
      </div>
    </section>
    @endif

  </div>
</main>
@endsection
