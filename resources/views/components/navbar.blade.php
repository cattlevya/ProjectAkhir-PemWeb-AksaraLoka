<header class="fixed top-0 w-full z-50 bg-[#fbfbe2]/80 backdrop-blur-2xl transition-all duration-300 ease-in-out border-b border-transparent hover:border-outline-variant/30">
  <div class="flex justify-between items-center px-6 py-4 w-full max-w-screen-2xl mx-auto">

    {{-- LEFT: Brand + Nav --}}
    <div class="flex items-center gap-8">
      <a href="/" class="text-2xl font-bold tracking-tighter text-brand-indigo font-['Epilogue']">
        AksaraLoka
      </a>
      <nav class="hidden md:flex items-center gap-6">
        <a href="{{ route('home') }}"
           class="font-['Epilogue'] tracking-tight text-sm
                  {{ request()->routeIs('home') ? 'font-bold text-brand-brown border-b-2 border-brand-brown pb-0.5' : 'text-brand-indigo/60 hover:text-brand-brown transition-colors duration-300' }}">
          Discover
        </a>
        <a href="{{ route('catalog.index', ['category' => 'kuliner']) }}"
           class="font-['Epilogue'] tracking-tight text-sm
                  {{ request()->routeIs('catalog*') && request('category') === 'kuliner' ? 'font-bold text-brand-brown border-b-2 border-brand-brown pb-0.5' : 'text-brand-indigo/60 hover:text-brand-brown transition-colors duration-300' }}">
          Kuliner
        </a>
        <a href="{{ route('catalog.index', ['category' => 'wastra']) }}"
           class="font-['Epilogue'] tracking-tight text-sm
                  {{ request()->routeIs('catalog*') && request('category') === 'wastra' ? 'font-bold text-brand-brown border-b-2 border-brand-brown pb-0.5' : 'text-brand-indigo/60 hover:text-brand-brown transition-colors duration-300' }}">
          Wastra
        </a>
      </nav>
    </div>

    {{-- RIGHT: Search + Actions --}}
    <div class="flex items-center gap-4">

      {{-- Search bar (hidden on mobile) --}}
      <div class="hidden lg:flex items-center bg-surface-container-highest px-4 py-2 rounded-xl transition-all duration-300 ease-in-out focus-within:ring-2 focus-within:ring-brand-brown/50 focus-within:bg-white shadow-sm">
        <span class="material-symbols-outlined text-outline text-lg">search</span>
        <form action="{{ route('catalog.index') }}" method="GET">
          <input name="q" value="{{ request('q') }}"
                 class="bg-transparent border-none focus:ring-0 text-sm w-56 placeholder:text-outline/60 text-brand-indigo font-['Manrope']"
                 placeholder="Search collections..."/>
        </form>
      </div>

      {{-- Wishlist --}}
      <a href="{{ route('wishlist.index') }}" class="p-2 text-on-surface-variant hover:text-brand-brown transition-all duration-300 hover:scale-110 active:scale-95 relative group">
        <span class="material-symbols-outlined">favorite</span>
        @auth
          @php
            $wishlistCount = \App\Models\Wishlist::where('user_id', auth()->id())->count();
          @endphp
          @if($wishlistCount > 0)
            <span class="absolute top-1 right-1 w-4 h-4 bg-brand-brown text-white text-[9px] font-bold rounded-full flex items-center justify-center animate-bounce">
              {{ $wishlistCount }}
            </span>
          @endif
        @endauth
      </a>

      {{-- Cart dengan badge --}}
      <a href="{{ route('cart.index') }}" class="p-2 text-on-surface-variant hover:text-brand-brown transition-all duration-300 hover:scale-110 active:scale-95 relative group">
        <span class="material-symbols-outlined">shopping_bag</span>
        @if(session('cart') && count(session('cart')) > 0)
          <span class="absolute top-1 right-1 w-4 h-4 bg-brand-brown text-white text-[9px] font-bold rounded-full flex items-center justify-center animate-bounce">
            {{ count(session('cart')) }}
          </span>
        @endif
      </a>

      {{-- Auth --}}
      @auth
        <div x-data="{ open: false }" class="relative">
          <button @click="open = !open" @click.away="open = false"
             class="w-9 h-9 rounded-full bg-brand-indigo text-white text-sm font-bold flex items-center justify-center hover:bg-brand-brown transition-all duration-300 hover:scale-105 shadow-sm focus:outline-none">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
          </button>
          
          <div x-show="open" 
               x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="opacity-0 scale-95 translate-y-2"
               x-transition:enter-end="opacity-100 scale-100 translate-y-0"
               x-transition:leave="transition ease-in duration-150"
               x-transition:leave-start="opacity-100 scale-100 translate-y-0"
               x-transition:leave-end="opacity-0 scale-95 translate-y-2"
               style="display: none;"
               class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-lg border border-outline-variant/20 py-2 z-50">
            <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'penjual' ? route('seller.dashboard') : route('profile.edit')) }}" class="block px-4 py-2 text-sm text-on-surface hover:bg-surface-container-low hover:text-brand-brown transition-colors">Dashboard</a>
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-on-surface hover:bg-surface-container-low hover:text-brand-brown transition-colors">Profile</a>
            <form method="POST" action="{{ route('logout') }}" class="block">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-error hover:bg-red-50 transition-colors">Logout</button>
            </form>
          </div>
        </div>
      @else
        <a href="{{ route('login') }}"
           class="hidden md:block font-['Epilogue'] text-sm font-bold text-brand-indigo/60 hover:text-brand-brown transition-colors px-3 py-2">
          Masuk
        </a>
        <a href="{{ route('register') }}"
           class="hidden md:flex items-center gap-2 bg-brand-indigo text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-primary-dim hover:-translate-y-0.5 hover:shadow-md transition-all duration-300 active:scale-95">
          Daftar
        </a>
      @endauth
    </div>
  </div>
</header>
