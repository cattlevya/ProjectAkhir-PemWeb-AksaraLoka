@extends('layouts.app')
@section('content')

<main class="pt-24 pb-32 px-6 max-w-screen-2xl mx-auto">

  {{-- Editorial Header --}}
  <section class="mb-16 mt-8 flex flex-col md:flex-row justify-between items-end gap-8">
    <div class="max-w-2xl">
      <span class="text-brand-brown font-bold tracking-[0.2em] uppercase text-xs mb-4 block font-['Manrope']">
        @if(request('category'))
          {{ ucfirst(request('category')) }} · Koleksi AksaraLoka
        @else
          Semua Koleksi · Banyumas
        @endif
      </span>
      <h1 class="text-5xl md:text-7xl font-['Epilogue'] font-extrabold tracking-tighter text-brand-indigo leading-[0.9]">
        Produk<br/>
        <span class="text-brand-ochre italic">Pilihan</span> Terbaik.
      </h1>
    </div>
    <div class="flex gap-3">
      <button class="flex items-center gap-2 px-6 py-3 bg-surface-container-highest text-on-surface font-semibold rounded-xl hover:bg-surface-container transition-all font-['Manrope']">
        <span class="material-symbols-outlined text-xl">tune</span>
        <span>Filter</span>
      </button>
      <div class="relative">
        <select name="sort" onchange="window.location.href=this.value"
                class="flex items-center gap-2 px-6 py-3 bg-surface-container-highest text-on-surface font-semibold rounded-xl hover:bg-surface-container transition-all font-['Manrope'] border-none focus:ring-0 cursor-pointer appearance-none pr-10">
          <option value="{{ request()->fullUrlWithQuery(['sort' => '']) }}">Urutkan</option>
          <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}"  {{ request('sort') === 'price_asc'  ? 'selected' : '' }}>Harga Terendah</option>
          <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
          <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}"     {{ request('sort') === 'newest'     ? 'selected' : '' }}>Terbaru</option>
        </select>
        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant">expand_more</span>
      </div>
    </div>
  </section>



  {{-- Product Grid — Staggered Editorial Layout --}}
  <div class="grid grid-cols-1 md:grid-cols-12 gap-x-8 gap-y-16">

    @php $index = 0; @endphp
    @foreach($products as $product)

      @if($index === 0)
      {{-- First item: FEATURED LARGE (8 cols wide) --}}
      <div class="md:col-span-8 flex flex-col group cursor-pointer">
        <a href="{{ route('product.show', $product->slug) }}">
          <div class="relative overflow-hidden rounded-3xl bg-brand-cream/50 aspect-[16/9] group-hover:shadow-2xl transition-all duration-500">
            <img src="{{ $product->primaryImageUrl }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"/>
            @if($product->stock <= 5)
              <div class="absolute top-6 left-6">
                <span class="bg-surface/90 backdrop-blur px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest text-brand-brown">
                  Stok Terbatas
                </span>
              </div>
            @endif
          </div>
          <div class="mt-8 flex justify-between items-start">
            <div>
              <h3 class="font-['Epilogue'] text-3xl font-bold tracking-tight text-brand-indigo group-hover:text-brand-brown transition-colors">
                {{ $product->name }}
              </h3>
              <p class="text-on-surface-variant font-medium mt-1 font-['Manrope']">
                {{ $product->store->store_name }}
              </p>
            </div>
            <span class="font-['Epilogue'] text-2xl font-black text-brand-indigo">
              Rp {{ number_format($product->price, 0, ',', '.') }}
            </span>
          </div>
        </a>
      </div>

      @elseif($index === 1)
      {{-- Second item: Standard (4 cols) --}}
      <div class="md:col-span-4 flex flex-col group cursor-pointer relative block">
        <a href="{{ route('product.show', $product->slug) }}" class="absolute inset-0 z-10"></a>
        <div class="relative overflow-hidden rounded-3xl bg-brand-cream/30 aspect-[4/5] editorial-shadow group-hover:shadow-2xl transition-all duration-500">
          <img src="{{ $product->primaryImageUrl }}"
               alt="{{ $product->name }}"
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"/>
          <div class="absolute top-4 right-4 z-20">
            <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
               @csrf
               <button type="submit" class="w-10 h-10 bg-surface/80 backdrop-blur rounded-full flex items-center justify-center transition-colors border-none shadow-md {{ auth()->check() && $product->wishlists()->where('user_id', auth()->id())->exists() ? 'text-brand-brown opacity-100' : 'text-on-surface-variant hover:text-brand-brown' }}">
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
              {{ $product->category->name }}
            </p>
            <span class="font-['Epilogue'] text-lg font-bold text-brand-brown block mt-3">
              Rp {{ number_format($product->price, 0, ',', '.') }}
            </span>
          </div>
      </div>

      @else
      {{-- Items 3+: 4 cols grid, staggered --}}
      <div class="md:col-span-4 flex flex-col group cursor-pointer relative block">
        <a href="{{ route('product.show', $product->slug) }}" class="absolute inset-0 z-10"></a>
        <div class="relative overflow-hidden rounded-3xl bg-brand-cream/30 editorial-shadow aspect-[4/5] group-hover:shadow-2xl transition-all duration-500">
          <img src="{{ $product->primaryImageUrl }}"
               alt="{{ $product->name }}"
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"/>
          <div class="absolute top-4 right-4 z-20">
            <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
               @csrf
               <button type="submit" class="w-10 h-10 bg-surface/80 backdrop-blur rounded-full flex items-center justify-center transition-colors border-none shadow-md {{ auth()->check() && $product->wishlists()->where('user_id', auth()->id())->exists() ? 'text-brand-brown opacity-100' : 'text-on-surface-variant hover:text-brand-brown' }}">
                 <span class="material-symbols-outlined text-xl">favorite</span>
               </button>
            </form>
          </div>
          @if($loop->iteration <= 2)
            <div class="absolute bottom-4 left-4 pointer-events-none">
              <span class="bg-brand-indigo text-white px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tighter">
                Baru
              </span>
            </div>
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
      @endif

      @php $index++; @endphp
    @endforeach

  </div>

  {{-- Pagination --}}
  <div class="mt-20 flex justify-center">
    {{ $products->withQueryString()->links() }}
  </div>

</main>
@endsection
