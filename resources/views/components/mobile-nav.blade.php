{{-- Mobile Bottom Navigation --}}
<nav class="md:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 py-3 transition-all duration-300 ease-in-out
            bg-[#fbfbe2]/90 backdrop-blur-xl shadow-[0_-10px_40px_rgba(25,28,60,0.05)]">

  <a href="{{ route('home') }}"
     class="flex flex-col items-center justify-center transition-all duration-300 ease-in-out
            {{ request()->routeIs('home') ? 'text-brand-brown scale-110' : 'text-brand-indigo/40 hover:text-brand-brown' }}">
    <span class="material-symbols-outlined">storefront</span>
    <span class="font-['Manrope'] text-[10px] uppercase tracking-[0.1em] font-bold mt-1">Discover</span>
  </a>

  <a href="{{ route('catalog.index') }}"
     class="flex flex-col items-center justify-center transition-all duration-300 ease-in-out
            {{ request()->routeIs('catalog*') ? 'text-brand-brown scale-110' : 'text-brand-indigo/40 hover:text-brand-brown' }}">
    <span class="material-symbols-outlined">grid_view</span>
    <span class="font-['Manrope'] text-[10px] uppercase tracking-[0.1em] font-bold mt-1">Katalog</span>
  </a>

  <a href="{{ route('cart.index') }}"
     class="flex flex-col items-center justify-center transition-all duration-300 ease-in-out
            {{ request()->routeIs('cart*') ? 'text-brand-brown scale-110' : 'text-brand-indigo/40 hover:text-brand-brown' }}">
    <span class="material-symbols-outlined">shopping_bag</span>
    <span class="font-['Manrope'] text-[10px] uppercase tracking-[0.1em] font-bold mt-1">Keranjang</span>
  </a>

  <a href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'penjual' ? route('seller.dashboard') : route('profile.edit'))) : route('login') }}"
     class="flex flex-col items-center justify-center transition-all duration-300 ease-in-out
            {{ request()->routeIs('dashboard*') || request()->routeIs('profile*') ? 'text-brand-brown scale-110' : 'text-brand-indigo/40 hover:text-brand-brown' }}">
    <span class="material-symbols-outlined">person</span>
    <span class="font-['Manrope'] text-[10px] uppercase tracking-[0.1em] font-bold mt-1">Profil</span>
  </a>

</nav>
