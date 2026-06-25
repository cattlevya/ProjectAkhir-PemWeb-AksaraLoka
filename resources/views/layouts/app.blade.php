<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="AksaraLoka — Marketplace premium untuk produk UMKM Banyumas. Temukan Wastra & Kuliner terbaik dari pengrajin lokal.">

        <title>{{ isset($title) ? $title . ' — ' : '' }}AksaraLoka</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@700;800;900&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

        <!-- Tailwind Configuration -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              colors: {
                "brand-cream":   "#fbfbe2",
                "brand-indigo":  "#191c3c",
                "brand-brown":   "#934b19",
                "brand-ochre":   "#c58c2b",
                "surface":                    "#fbfbe2",
                "surface-bright":             "#ffffff",
                "surface-container-lowest":   "#ffffff",
                "surface-container-low":      "#f5f5dc",
                "surface-container":          "#efeed1",
                "surface-container-high":     "#eae8ca",
                "surface-container-highest":  "#e4e2c2",
                "surface-dim":                "#dedec3",
                "surface-variant":            "#e6e1d6",
                "on-surface":          "#191c3c",
                "on-surface-variant":  "#49454f",
                "on-background":       "#191c3c",
                "on-primary":          "#ffffff",
                "on-secondary":        "#ffffff",
                "primary":             "#191c3c",
                "primary-dim":         "#12142d",
                "primary-container":   "#dce1ff",
                "secondary":           "#934b19",
                "secondary-container": "#ffdcbe",
                "tertiary":            "#c58c2b",
                "tertiary-container":  "#f4e2ba",
                "outline":             "#79747e",
                "outline-variant":     "#c9c5b4",
                "error":               "#ba1a1a",
                "background":          "#fbfbe2",
                "inverse-surface":     "#191c3c",
              },
              borderRadius: {
                DEFAULT: "0.5rem",
                lg:  "0.75rem",
                xl:  "1rem",
                "2xl": "1.5rem",
                "3xl": "2rem",
                full: "9999px",
              },
              fontFamily: {
                headline: ["Epilogue"],
                body:     ["Manrope"],
                label:    ["Manrope"],
              },
              animation: {
                'bounce-short': 'bounce 1s ease-in-out 3',
                'slide-up': 'slideUp 0.5s ease-out forwards',
              },
              keyframes: {
                slideUp: { '0%': { transform: 'translateY(100%)', opacity: 0 }, '100%': { transform: 'translateY(0)', opacity: 1 } }
              }
            },
          },
        }
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Theme Initialization to prevent FOUC -->
        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                // document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="font-body antialiased bg-brand-cream text-brand-indigo">
        {{-- Desktop Navbar --}}
        @include('components.navbar')

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="fixed top-20 right-4 z-50 bg-green-50 border border-green-200 text-green-800 px-6 py-3 text-sm tracking-wide animate-slide-up" id="flash-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="fixed top-20 right-4 z-50 bg-red-50 border border-red-200 text-red-800 px-6 py-3 text-sm tracking-wide animate-slide-up" id="flash-error">
                {{ session('error') }}
            </div>
        @endif
        @if(session('warning'))
            <div class="fixed top-20 right-4 z-50 bg-yellow-50 border border-yellow-200 text-yellow-800 px-6 py-3 text-sm tracking-wide animate-slide-up" id="flash-warning">
                {{ session('warning') }}
            </div>
        @endif

        {{-- Page Content --}}
        <main class="min-h-screen">
            {{ $slot ?? '' }}
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="bg-surface-container-low py-20 border-t border-outline-variant/30">
          <div class="max-w-screen-2xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12">

            <div class="col-span-1 md:col-span-2">
              <span class="font-['Epilogue'] text-2xl font-black italic tracking-tighter text-brand-indigo block mb-6">
                AksaraLoka
              </span>
              <p class="max-w-sm text-on-surface-variant leading-relaxed font-['Manrope']">
                Platform marketplace premium untuk produk UMKM Banyumas. Kami menghubungkan pengrajin lokal dengan pembeli yang menghargai kualitas dan keaslian.
              </p>
            </div>

            <div>
              <h5 class="font-bold uppercase tracking-widest text-xs mb-6 text-brand-brown font-['Manrope']">Koleksi</h5>
              <ul class="space-y-4 text-sm text-on-surface-variant font-['Manrope']">
                <li><a href="{{ route('catalog.index', ['category' => 'wastra']) }}" class="hover:text-brand-brown transition-colors">Wastra & Tekstil</a></li>
                <li><a href="{{ route('catalog.index', ['category' => 'kuliner']) }}" class="hover:text-brand-brown transition-colors">Kuliner Lokal</a></li>
                <li><a href="{{ route('catalog.index') }}" class="hover:text-brand-brown transition-colors">Semua Produk</a></li>
              </ul>
            </div>

            <div>
              <h5 class="font-bold uppercase tracking-widest text-xs mb-6 text-brand-brown font-['Manrope']">Informasi</h5>
              <ul class="space-y-4 text-sm text-on-surface-variant font-['Manrope']">
                <li><a href="#" class="hover:text-brand-brown transition-colors">Cara Belanja</a></li>
                <li><a href="#" class="hover:text-brand-brown transition-colors">Daftar Sebagai Penjual</a></li>
                <li><a href="#" class="hover:text-brand-brown transition-colors">Hubungi Kami</a></li>
              </ul>
            </div>

          </div>
          <div class="max-w-screen-2xl mx-auto px-6 mt-20 pt-8 border-t border-outline-variant/20 flex flex-col md:flex-row justify-between gap-4 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant font-['Manrope']">
            <span>© {{ date('Y') }} AksaraLoka. Semua hak dilindungi.</span>
            <div class="flex gap-8">
              <a href="#" class="hover:text-brand-brown">Privasi</a>
              <a href="#" class="hover:text-brand-brown">Ketentuan</a>
            </div>
          </div>
        </footer>

        {{-- Mobile Bottom Nav --}}
        @include('components.mobile-nav')

        {{-- Auto-dismiss flash messages --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const flashes = document.querySelectorAll('[id^="flash-"]');
                flashes.forEach(el => {
                    setTimeout(() => {
                        el.style.transition = 'opacity 0.5s ease-out';
                        el.style.opacity = '0';
                        setTimeout(() => el.remove(), 500);
                    }, 4000);
                });
            });
        </script>

        @stack('scripts')
    </body>
</html>
