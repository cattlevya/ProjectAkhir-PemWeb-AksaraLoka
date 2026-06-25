@extends('layouts.app')
@section('content')

<main class="pt-24 pb-32 max-w-screen-2xl mx-auto px-6">
  {{-- 1. Profile Hero Section --}}
  <section class="mb-16 mt-8">
    <div class="flex flex-col md:flex-row items-end gap-8">
      <div class="relative group">
        {{-- Custom placeholder avatar --}}
        <div class="w-32 h-32 md:w-48 md:h-48 rounded-xl overflow-hidden bg-brand-indigo flex items-center justify-center shadow-lg editorial-shadow">
          @if(auth()->user()->profile_photo_url ?? false)
            <img src="{{ auth()->user()->profile_photo_url }}" class="w-full h-full object-cover" />
          @else
            <span class="text-6xl font-black font-['Epilogue'] text-white">
              {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </span>
          @endif
        </div>
        <button class="absolute bottom-2 right-2 bg-brand-brown text-white p-2 rounded-lg shadow-xl hover:scale-105 transition-transform border-none outline-none">
          <span class="material-symbols-outlined text-sm">edit</span>
        </button>
      </div>

      <div class="flex-1">
        <div class="flex items-center gap-3 mb-2">
          <span class="px-3 py-1 bg-brand-ochre text-white text-[10px] font-bold uppercase tracking-[0.2em] rounded-full font-['Manrope']">
            @if(auth()->user()->role === 'penjual') Artisan @elseif(auth()->user()->role === 'admin') Curator @else Member @endif
          </span>
          <span class="text-on-surface-variant text-xs font-semibold uppercase tracking-widest italic font-['Manrope']">
            Since {{ auth()->user()->created_at->format('Y') }}
          </span>
        </div>
        <h1 class="text-5xl md:text-7xl font-black tracking-tighter text-brand-indigo mb-2 font-['Epilogue']">
          {{ auth()->user()->name }}
        </h1>
        <p class="text-on-surface-variant max-w-lg font-medium opacity-80 font-['Manrope']">
          {{ auth()->user()->email }} @if(auth()->user()->role === 'penjual') | Artisan di ekosistem AksaraLoka @endif
        </p>
      </div>

      <div class="flex gap-4">
        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit"
                  class="bg-brand-indigo text-white px-8 py-4 rounded-xl font-bold tracking-tight hover:opacity-90 transition-all shadow-lg active:scale-95 border-none cursor-pointer font-['Epilogue']">
            Sign Out
          </button>
        </form>
      </div>
    </div>
  </section>

  {{-- 2. Stats Bento Grid --}}
  <section class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-16">
    <div class="md:col-span-1 bg-surface-container-low p-8 rounded-xl border border-outline-variant/30 editorial-shadow">
      <span class="text-on-surface-variant text-[11px] font-bold uppercase tracking-widest block mb-4 font-['Manrope']">Total Belanja</span>
      <p class="text-3xl font-black tracking-tighter text-brand-indigo font-['Epilogue']">
        Rp {{ number_format(auth()->user()->orders()->where('status', 'selesai')->sum('total_amount'), 0, ',', '.') }}
      </p>
      <div class="mt-4 flex items-center text-brand-brown font-bold text-xs font-['Manrope']">
        <span class="material-symbols-outlined text-sm mr-1">trending_up</span> +5% vs last month
      </div>
    </div>

    <div class="md:col-span-1 bg-surface-container-low p-8 rounded-xl border border-outline-variant/30 editorial-shadow">
      <span class="text-on-surface-variant text-[11px] font-bold uppercase tracking-widest block mb-4 font-['Manrope']">Saved Items</span>
      <p class="text-3xl font-black tracking-tighter text-brand-indigo font-['Epilogue']">
        {{ auth()->user()->wishlists()->count() }}
      </p>
      <div class="mt-4 flex -space-x-2">
        @foreach(auth()->user()->wishlists()->with('product')->take(3)->get() as $wish)
          <div class="w-8 h-8 rounded-full border-2 border-surface-container-low overflow-hidden bg-brand-ochre">
             <img src="{{ $wish->product->primaryImageUrl }}" class="w-full h-full object-cover">
          </div>
        @endforeach
      </div>
    </div>

    @if(auth()->user()->role !== 'penjual')
    <div class="md:col-span-2 bg-brand-brown text-white p-8 rounded-xl relative overflow-hidden flex flex-col justify-between shadow-xl editorial-shadow">
      <div class="relative z-10">
        <span class="text-[#f4e2ba]/70 text-[11px] font-bold uppercase tracking-widest block mb-2 opacity-80 font-['Manrope']">Premium Reward</span>
        <h3 class="text-2xl font-bold tracking-tight leading-tight max-w-xs font-['Epilogue']">
          Anda memiliki akses awal untuk Koleksi Wastra '24.
        </h3>
      </div>
      <a href="{{ route('catalog.index', ['category' => 'wastra']) }}" class="relative z-10 w-fit bg-[#f4e2ba] text-brand-brown px-6 py-2 rounded-lg font-bold text-sm mt-4 active:scale-95 transition-all text-center">
        Lihat Koleksi
      </a>
      <div class="absolute top-0 right-0 w-48 h-48 bg-white/10 rounded-full -mr-12 -mt-12 blur-3xl"></div>
      <span class="material-symbols-outlined absolute -right-8 -bottom-8 text-[150px] opacity-10">verified_user</span>
    </div>
    @else
    <div class="md:col-span-2 bg-brand-indigo text-white p-8 rounded-xl relative overflow-hidden flex flex-col justify-between shadow-xl editorial-shadow">
      <div class="relative z-10">
        <span class="text-brand-ochre text-[11px] font-bold uppercase tracking-widest block mb-2 opacity-80 font-['Manrope']">Workspace</span>
        <h3 class="text-2xl font-bold tracking-tight leading-tight max-w-xs font-['Epilogue']">
          Akses Studio Artisan Anda.
        </h3>
      </div>
      <a href="{{ route('seller.dashboard') }}" class="relative z-10 w-fit bg-brand-ochre text-brand-indigo px-6 py-2 rounded-lg font-bold text-sm mt-4 active:scale-95 transition-all text-center">
        Masuk Dashboard
      </a>
      <span class="material-symbols-outlined absolute -right-8 -bottom-8 text-[150px] opacity-10">storefront</span>
    </div>
    @endif
  </section>

  {{-- 3. Favorites Section --}}
  @if(auth()->user()->wishlists()->count() > 0)
  <section class="mb-24">
    <div class="flex justify-between items-end mb-12">
      <div>
        <span class="text-brand-brown font-bold text-[11px] uppercase tracking-widest mb-1 block font-['Manrope']">Curated by you</span>
        <h2 class="text-4xl font-black tracking-tighter text-brand-indigo font-['Epilogue']">Favorit Anda</h2>
      </div>
      <a class="text-sm font-bold border-b-2 border-brand-indigo pb-1 hover:text-brand-brown hover:border-brand-brown transition-colors font-['Manrope']" href="{{ route('wishlist.index') }}">
        Lihat semua ({{ auth()->user()->wishlists()->count() }})
      </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
      @foreach(auth()->user()->wishlists()->with('product.store')->take(3)->get() as $wish)
      <div class="group cursor-pointer">
        <div class="bg-surface-container-low rounded-xl overflow-hidden mb-6 aspect-[4/5] relative editorial-shadow">
          <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $wish->product->primaryImageUrl }}"/>
          <form action="{{ route('wishlist.toggle', $wish->product->id) }}" method="POST" class="absolute top-4 right-4">
            @csrf
            <button type="submit" class="w-10 h-10 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-brand-brown shadow-sm border-none">
              <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">favorite</span>
            </button>
          </form>
        </div>
        <div class="flex justify-between items-start">
          <div>
            <p class="text-on-surface-variant text-[11px] font-bold uppercase tracking-[0.15em] mb-1 font-['Manrope']">
                {{ $wish->product->category->name }}
            </p>
            <h4 class="text-xl font-bold tracking-tight text-brand-indigo font-['Epilogue']">{{ $wish->product->name }}</h4>
          </div>
          <span class="text-lg font-black tracking-tighter text-brand-brown font-['Epilogue']">
            Rp {{ number_format($wish->product->price, 0, ',', '.') }}
          </span>
        </div>
      </div>
      @endforeach
    </div>
  </section>
  @endif

  {{-- 4. Purchases & Settings Tabs --}}
  <section class="grid grid-cols-1 lg:grid-cols-3 gap-16 border-t border-outline-variant/30 pt-16">

    {{-- Recent Purchases --}}
    <div class="lg:col-span-2">
      <div class="flex justify-between items-center mb-8">
        <h3 class="text-2xl font-bold tracking-tight text-brand-indigo font-['Epilogue']">Riwayat Pesanan</h3>
        <a href="{{ route('orders.index') }}" class="text-sm font-bold text-brand-brown hover:underline font-['Manrope'] tracking-widest uppercase">Lihat Semua</a>
      </div>
      
      <div class="space-y-4">
        @forelse(auth()->user()->orders()->latest()->take(5)->get() as $order)
        <div class="bg-surface-container-low hover:bg-surface-container-highest transition-colors p-6 rounded-xl flex items-center gap-6 border border-outline-variant/10 editorial-shadow">
          <div class="w-20 h-20 bg-surface-container rounded-lg overflow-hidden shrink-0 flex items-center justify-center text-outline">
            @if($order->items->first() && $order->items->first()->product)
                <img src="{{ $order->items->first()->product->primaryImageUrl }}" class="w-full h-full object-cover">
            @else
                <span class="material-symbols-outlined text-4xl">inventory_2</span>
            @endif
          </div>
          <div class="flex-1">
            <div class="flex justify-between mb-1">
              <p class="font-bold text-brand-indigo font-['Epilogue']">
                {{ $order->items->count() > 1 ? $order->items->first()->product->name . ' + ' . ($order->items->count() - 1) . ' lainnya' : ($order->items->first()->product->name ?? 'Order #' . $order->order_code) }}
              </p>
              <p class="font-black text-brand-brown">{{ $order->formatted_total }}</p>
            </div>
            <div class="flex gap-4 text-xs font-semibold text-on-surface-variant uppercase tracking-widest font-['Manrope']">
              <span>Order #{{ $order->order_code }}</span>
              <span>•</span>
              <span class="{{ $order->status === 'selesai' ? 'text-green-700' : 'text-brand-ochre' }}">{{ $order->status_label }}</span>
            </div>
          </div>
          <a href="{{ route('orders.show', $order) }}" class="bg-surface-bright px-4 py-2 rounded-lg text-xs font-bold border border-outline hover:bg-brand-indigo hover:text-white transition-all font-['Manrope']">
            Detail
          </a>
        </div>
        @empty
        <div class="bg-surface-container-low p-6 rounded-xl border border-dashed border-outline-variant/50 text-center text-outline font-['Manrope']">
          Belum ada pesanan
        </div>
        @endforelse
      </div>
    </div>

    {{-- Settings Sidebar (Breeze Integration) --}}
    <div class="lg:col-span-1 border-l border-outline-variant/30 pl-0 lg:pl-16" x-data="{ modalProfile: false, modalPassword: false, modalDelete: false }">
      <h3 class="text-2xl font-bold tracking-tight mb-8 text-brand-indigo font-['Epilogue']">Pengaturan Akun</h3>
      
      <div class="space-y-4">
        <button @click="modalProfile = true" type="button" class="w-full text-left bg-surface-container-low hover:bg-surface-container transition-colors p-6 rounded-2xl editorial-shadow flex items-center justify-between group border border-outline-variant/10 cursor-pointer">
          <div>
            <p class="font-bold text-sm text-brand-indigo font-['Epilogue'] uppercase tracking-widest">Informasi Dasar</p>
            <p class="text-xs text-on-surface-variant font-['Manrope'] mt-1">Ubah nama dan alamat email</p>
          </div>
          <span class="material-symbols-outlined text-brand-indigo group-hover:translate-x-1 transition-transform">arrow_forward_ios</span>
        </button>

        <button @click="modalPassword = true" type="button" class="w-full text-left bg-surface-container-low hover:bg-surface-container transition-colors p-6 rounded-2xl editorial-shadow flex items-center justify-between group border border-outline-variant/10 cursor-pointer">
          <div>
            <p class="font-bold text-sm text-brand-brown font-['Epilogue'] uppercase tracking-widest">Keamanan</p>
            <p class="text-xs text-on-surface-variant font-['Manrope'] mt-1">Perbarui kata sandi akun Anda</p>
          </div>
          <span class="material-symbols-outlined text-brand-brown group-hover:translate-x-1 transition-transform">arrow_forward_ios</span>
        </button>
        
        <div class="pt-6 mt-6 border-t border-outline-variant/30">
          <button @click="modalDelete = true" type="button" class="w-full text-left bg-red-50 hover:bg-red-100 transition-colors p-6 rounded-2xl editorial-shadow flex items-center justify-between group border border-red-100 cursor-pointer">
            <div>
              <p class="font-bold text-sm text-red-600 font-['Epilogue'] uppercase tracking-widest">Hapus Akun</p>
              <p class="text-xs text-red-500 font-['Manrope'] mt-1">Hapus akun secara permanen</p>
            </div>
            <span class="material-symbols-outlined text-red-600 group-hover:translate-x-1 transition-transform">delete_forever</span>
          </button>
        </div>
      </div>

      {{-- Modals --}}
      <template x-teleport="body">
        <div>
          {{-- Profile Modal --}}
          <div x-show="modalProfile" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm"
               x-transition.opacity duration.300ms style="display: none;">
            <div @click.away="modalProfile = false" class="bg-surface-bright p-8 rounded-3xl w-full max-w-xl shadow-2xl relative editorial-shadow"
                 x-show="modalProfile"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100">
              <button @click="modalProfile = false" class="absolute top-6 right-6 text-on-surface-variant hover:text-brand-brown p-2 rounded-full border-none bg-surface-container-low cursor-pointer transition-colors">
                <span class="material-symbols-outlined text-sm">close</span>
              </button>
              <p class="font-bold text-sm text-brand-indigo mb-6 font-['Epilogue'] uppercase tracking-widest">Informasi Dasar</p>
              @include('profile.partials.update-profile-information-form')
            </div>
          </div>

          {{-- Password Modal --}}
          <div x-show="modalPassword" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm"
               x-transition.opacity duration.300ms style="display: none;">
            <div @click.away="modalPassword = false" class="bg-surface-bright p-8 rounded-3xl w-full max-w-xl shadow-2xl relative editorial-shadow"
                 x-show="modalPassword"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100">
              <button @click="modalPassword = false" class="absolute top-6 right-6 text-on-surface-variant hover:text-brand-brown p-2 rounded-full border-none bg-surface-container-low cursor-pointer transition-colors">
                <span class="material-symbols-outlined text-sm">close</span>
              </button>
              <p class="font-bold text-sm text-brand-brown mb-6 font-['Epilogue'] uppercase tracking-widest">Keamanan</p>
              @include('profile.partials.update-password-form')
            </div>
          </div>

          {{-- Delete Modal --}}
          <div x-show="modalDelete" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm"
               x-transition.opacity duration.300ms style="display: none;">
            <div @click.away="modalDelete = false" class="bg-surface-bright p-8 rounded-3xl w-full max-w-xl shadow-2xl relative editorial-shadow"
                 x-show="modalDelete"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100">
              <button @click="modalDelete = false" class="absolute top-6 right-6 text-on-surface-variant hover:text-red-500 p-2 rounded-full border-none bg-surface-container-low cursor-pointer transition-colors">
                <span class="material-symbols-outlined text-sm">close</span>
              </button>
              @include('profile.partials.delete-user-form')
            </div>
          </div>
        </div>
      </template>
    </div>
  </section>
</main>

@endsection
