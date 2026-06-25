@extends('layouts.app')
@section('content')

{{-- ================================================ --}}
{{-- HERO — Full-width cinematic dengan overlay text  --}}
{{-- ================================================ --}}
<section class="px-6 max-w-screen-2xl mx-auto mb-20 mt-6 pt-24"
         x-data="{ show: false }"
         x-intersect.once="show = true">
  <div class="relative rounded-3xl overflow-hidden aspect-[21/9] flex items-center group bg-brand-indigo"
       :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
       style="transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);">

    {{-- Hero image --}}
    <img src="{{ asset('images/hero/artisan_workshop.jpg') }}"
         alt="AksaraLoka Hero - Artisan Workshop"
         class="absolute inset-0 w-full h-full object-cover transition-transform duration-[1.5s] ease-out opacity-90"
         :class="show ? 'scale-100' : 'scale-110'"/>

    {{-- Gradient overlay --}}
    <div class="absolute inset-0 bg-gradient-to-t from-[#1a0f0a]/90 via-[#1a0f0a]/20 to-transparent"></div>

    {{-- Text content --}}
    <div class="relative z-10 p-12 w-full max-w-3xl">
      <h1 class="font-['Epilogue'] text-6xl md:text-8xl text-white font-black tracking-tighter mb-6 leading-[0.9]"
          :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
          style="transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.4s;">
        Melestarikan Budaya,<br/>Membangun Ekonomi.
      </h1>
      <p class="text-white/80 text-lg md:text-xl font-['Manrope'] mb-10 max-w-xl leading-relaxed"
         :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
         style="transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.6s;">
        Temukan mahakarya pengrajin lokal Banyumas, dari Batik tulis legendaris hingga kelezatan kuliner otentik yang khas.
      </p>
      <div :class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
           style="transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.8s;">
        <button @click="window.scrollTo({ top: document.getElementById('catalog-grid').offsetTop - 100, behavior: 'smooth' })"
           class="inline-flex items-center gap-3 bg-brand-brown text-white px-10 py-4 rounded-xl font-bold text-lg hover:bg-[#75390e] transition-all active:scale-95 border-none shadow-lg shadow-brand-brown/30 group-hover:shadow-brand-brown/50 cursor-pointer">
          Mulai Belanja
          <span class="material-symbols-outlined transform transition-transform group-hover:translate-x-1">arrow_forward</span>
        </button>
      </div>
    </div>
  </div>
</section>

{{-- ================================================ --}}
{{-- BENTO GRID — Featured Products                   --}}
{{-- ================================================ --}}
<section id="catalog-grid" class="px-6 max-w-screen-2xl mx-auto mb-32">
  <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
    <div>
      <p class="text-brand-brown font-bold uppercase tracking-widest text-xs mb-3">Pilihan Terkurasi</p>
      <h2 class="font-['Epilogue'] text-5xl font-black tracking-tighter text-brand-indigo">
        Produk Pilihan
      </h2>
    </div>
    <p class="max-w-md text-on-surface-variant text-lg font-['Manrope']">
      Seleksi tangan dari para pengrajin terbaik Banyumas yang mendefinisikan ulang produk lokal berkualitas tinggi.
    </p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
    {{-- Large feature card (7 cols) --}}
    @if($heroProducts->isNotEmpty())
    <div class="md:col-span-7 group cursor-pointer">
      <a href="{{ route('product.show', $heroProducts[0]->slug) }}">
        <div class="rounded-3xl overflow-hidden aspect-[4/3] mb-6 bg-brand-cream/50 relative group-hover:shadow-2xl transition-all duration-500">
          <img src="{{ $heroProducts[0]->primaryImageUrl }}"
               alt="{{ $heroProducts[0]->name }}"
               class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"/>
        </div>
        <div class="flex justify-between items-start">
          <div>
            <h3 class="font-['Epilogue'] text-3xl font-bold tracking-tight mb-2 text-brand-indigo">
              {{ $heroProducts[0]->name }}
            </h3>
            <p class="text-on-surface-variant font-medium">{{ $heroProducts[0]->store->store_name }}</p>
          </div>
          <span class="text-2xl font-black tracking-tighter text-brand-brown font-['Epilogue']">
            Rp {{ number_format($heroProducts[0]->price, 0, ',', '.') }}
          </span>
        </div>
      </a>
    </div>

    {{-- Vertical split (5 cols, 2 cards stacked) --}}
    <div class="md:col-span-5 flex flex-col gap-8">
      @foreach($heroProducts->slice(1, 2) as $product)
      <div class="group cursor-pointer">
        <a href="{{ route('product.show', $product->slug) }}">
          <div class="rounded-3xl overflow-hidden aspect-[16/10] mb-4 bg-brand-cream/50 relative group-hover:shadow-xl transition-all duration-500">
            <img src="{{ $product->primaryImageUrl }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"/>
          </div>
          <div class="flex justify-between items-center">
            <h4 class="font-['Epilogue'] text-xl font-bold tracking-tight text-brand-indigo group-hover:text-brand-brown transition-colors">
              {{ $product->name }}
            </h4>
            <span class="text-sm font-bold text-brand-brown uppercase tracking-widest text-[10px]">Lihat Detail</span>
          </div>
        </a>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</section>

{{-- ================================================ --}}
{{-- EDITORIAL SPOTLIGHT — Kuliner Section            --}}
{{-- ================================================ --}}
<section class="bg-surface-container py-24 px-6 mb-32">
  <div class="max-w-screen-2xl mx-auto">
    {{-- Section header --}}
    <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
      <div>
        <p class="text-brand-brown font-bold uppercase tracking-widest text-xs mb-3 font-['Manrope']">Gastronomi</p>
        <h2 class="font-['Epilogue'] text-5xl font-black tracking-tighter text-brand-indigo">
          Cita Rasa Lokal
        </h2>
      </div>
      <a href="{{ route('catalog.index', ['category' => 'kuliner']) }}"
         class="flex items-center gap-2 text-sm font-bold text-brand-brown uppercase tracking-widest group">
        Lihat Semua Kuliner
        <span class="material-symbols-outlined transition-transform group-hover:translate-x-1">north_east</span>
      </a>
    </div>

    {{-- Product grid — KULINER STYLE: Square (1:1), 4 kolom, inner card --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
      @foreach($kulineerProducts as $product)
      <div class="group cursor-pointer relative block">
        <a href="{{ route('product.show', $product->slug) }}" class="absolute inset-0 z-10"></a>
        <div class="relative aspect-[4/5] rounded-3xl overflow-hidden mb-6 bg-brand-cream/30 editorial-shadow group-hover:shadow-2xl transition-all duration-500">
          <img src="{{ $product->primaryImageUrl }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"/>
          {{-- Wishlist button on hover --}}
          <div class="absolute top-4 right-4 z-20">
            <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                @csrf
                <button type="submit" class="w-10 h-10 rounded-full bg-white/80 backdrop-blur-md flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 transition-all active:scale-90 border-none outline-none {{ auth()->check() && $product->wishlists()->where('user_id', auth()->id())->exists() ? 'text-brand-brown opacity-100' : 'text-on-surface hover:text-brand-brown' }}">
                  <span class="material-symbols-outlined text-xl">favorite</span>
                </button>
            </form>
          </div>
        </div>
        <div class="mt-6 pointer-events-none relative z-0">
          <h3 class="font-['Epilogue'] text-xl font-bold tracking-tight text-brand-indigo group-hover:text-brand-brown transition-colors line-clamp-1">
            {{ $product->name }}
          </h3>
          <p class="text-on-surface-variant text-sm font-medium mt-1 font-['Manrope'] line-clamp-1">
            {{ $product->store->store_name }}
          </p>
          <span class="font-['Epilogue'] text-lg font-bold text-brand-brown block mt-3">
            Rp {{ number_format($product->price, 0, ',', '.') }}
          </span>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

{{-- ================================================ --}}
{{-- TRENDING — Wastra Section                         --}}
{{-- ================================================ --}}
<section class="px-6 max-w-screen-2xl mx-auto mb-32">
  <div class="text-center mb-16">
    <p class="text-brand-brown font-bold uppercase tracking-widest text-xs mb-3 font-['Manrope']">Wastra</p>
    <h3 class="font-['Epilogue'] text-4xl font-black tracking-tight text-brand-indigo mb-4">
      Tekstil & Kerajinan
    </h3>
    {{-- Category filter pills --}}
    <div class="flex justify-center gap-4 mt-6 flex-wrap">
      <a href="{{ route('catalog.index', ['category' => 'wastra']) }}"
         class="px-6 py-2 rounded-full bg-brand-indigo text-white font-bold text-sm">
        Semua Wastra
      </a>
      <a href="{{ route('catalog.index', ['category' => 'batik']) }}"
         class="px-6 py-2 rounded-full bg-surface-container-high hover:bg-surface-container transition-colors text-on-surface-variant font-bold text-sm cursor-pointer">
        Batik
      </a>
      <a href="{{ route('catalog.index', ['category' => 'tenun']) }}"
         class="px-6 py-2 rounded-full bg-surface-container-high hover:bg-surface-container transition-colors text-on-surface-variant font-bold text-sm cursor-pointer">
        Tenun
      </a>
    </div>
  </div>

  {{-- Grid — Portrait 3:4, staggered --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
    @foreach($wastraProducts as $product)
    <div class="group relative block">
      <a href="{{ route('product.show', $product->slug) }}" class="absolute inset-0 z-10"></a>
      <div class="relative aspect-[4/5] rounded-3xl overflow-hidden mb-6 bg-brand-cream/30 editorial-shadow group-hover:shadow-2xl transition-all duration-500">
        <img src="{{ $product->primaryImageUrl }}"
               alt="{{ $product->name }}"
               class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"/>
        <div class="absolute top-4 right-4 z-20">
          <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
             @csrf
             <button type="submit" class="w-10 h-10 rounded-full bg-white/80 backdrop-blur-md flex items-center justify-center shadow-lg opacity-0 group-hover:opacity-100 transition-all active:scale-90 border-none outline-none {{ auth()->check() && $product->wishlists()->where('user_id', auth()->id())->exists() ? 'text-brand-brown opacity-100' : 'text-on-surface hover:text-brand-brown' }}">
                <span class="material-symbols-outlined text-xl">favorite</span>
             </button>
          </form>
        </div>
          @if($product->stock <= 5)
            <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-brand-indigo text-white text-[10px] font-black uppercase tracking-widest">
              Sisa {{ $product->stock }}
            </span>
          @endif
        </div>
        <div class="mt-6 pointer-events-none relative z-0">
          <h3 class="font-['Epilogue'] text-xl font-bold tracking-tight text-brand-indigo group-hover:text-brand-brown transition-colors line-clamp-1">
            {{ $product->name }}
          </h3>
          <p class="text-on-surface-variant text-sm font-medium mt-1 font-['Manrope'] line-clamp-1">
            {{ $product->store->store_name }}
          </p>
          <span class="font-['Epilogue'] text-lg font-bold text-brand-brown block mt-3">
            Rp {{ number_format($product->price, 0, ',', '.') }}
          </span>
        </div>
      </div>
    @endforeach
  </div>
</section>
@endsection
