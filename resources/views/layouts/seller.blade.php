<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Artisan Console') | AksaraLoka Seller</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;700;800;900&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "tertiary-fixed-dim": "#ffb77c",
                        "on-tertiary-fixed": "#2e1500",
                        "surface-container-highest": "#e4e4cc",
                        "error-container": "#ffdad6",
                        "error": "#ba1a1a",
                        "on-primary": "#ffffff",
                        "tertiary": "#331800",
                        "surface-container-high": "#eaead1",
                        "on-tertiary-fixed-variant": "#6d3900",
                        "on-tertiary": "#ffffff",
                        "secondary-fixed-dim": "#ffb68c",
                        "secondary-fixed": "#ffdbc9",
                        "secondary": "#934b19",
                        "primary-fixed": "#e0e0ff",
                        "inverse-primary": "#c1c3ed",
                        "secondary-container": "#ffa26a",
                        "surface-container-low": "#f5f5dc",
                        "outline": "#77767e",
                        "on-error": "#ffffff",
                        "surface-bright": "#fbfbe2",
                        "on-secondary": "#ffffff",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary-fixed-variant": "#753401",
                        "on-secondary-fixed": "#321200",
                        "on-primary-container": "#9799c0",
                        "on-surface": "#1b1d0e",
                        "on-tertiary-container": "#df8731",
                        "on-primary-fixed-variant": "#414466",
                        "on-primary-fixed": "#151938",
                        "tertiary-fixed": "#ffdcc2",
                        "surface": "#fbfbe2",
                        "primary-fixed-dim": "#c1c3ed",
                        "on-surface-variant": "#46464e",
                        "inverse-surface": "#303221",
                        "surface-variant": "#e4e4cc",
                        "inverse-on-surface": "#f2f2d9",
                        "surface-tint": "#595c7f",
                        "primary": "#191c3c",
                        "primary-container": "#2e3152",
                        "on-secondary-container": "#783603",
                        "on-primary-fixed": "#151938",
                        "surface-dim": "#dbdcc3",
                        "outline-variant": "#c7c5cf",
                        "background": "#fbfbe2",
                        "on-error-container": "#93000a",
                        "tertiary-container": "#512900",
                        "surface-container": "#efefd7",
                        "on-background": "#1b1d0e",
                        "brand-cream": "#fbfbe2",
                        "brand-indigo": "#191c3c",
                        "brand-brown": "#934b19",
                        "brand-ochre": "#c58c2b"
                    },
                    fontFamily: {
                        "headline": ["Epilogue"],
                        "body": ["Manrope"],
                        "label": ["Manrope"]
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Manrope', sans-serif; background-color: #fbfbe2; color: #1b1d0e; }
        .font-headline { font-family: 'Epilogue', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        
        .nav-link { 
            display: flex; 
            align-items: center; 
            padding: 0.75rem 1.5rem; 
            font-family: 'Manrope'; 
            font-weight: 500; 
            font-size: 0.875rem; 
            letter-spacing: 0.025em;
            transition-property: all;
            transition-duration: 300ms;
        }
        .nav-link.active {
            background-color: #2e3152;
            color: #fbfbe2;
            border-top-right-radius: 9999px;
            border-bottom-right-radius: 9999px;
            margin-right: 1rem;
        }
        .nav-link:not(.active) {
            color: rgba(25, 28, 60, 0.6);
        }
        .nav-link:not(.active):hover {
            background-color: rgba(46, 49, 82, 0.1);
            padding-left: 2rem;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-background text-on-background min-h-screen">

<!-- SideNavBar Anchor -->
<aside class="hidden lg:flex flex-col fixed left-0 top-0 h-full py-6 bg-[#fbfbe2] h-screen w-64 border-r border-[#c7c5cf]/15 z-50">
    <div class="px-6 mb-10">
        <h1 class="text-lg font-bold text-[#191c3c] tracking-tight">Artisan Console</h1>
        <p class="font-bold text-xs text-[#191c3c]/60">Store Management</p>
    </div>
    
    <nav class="flex-1 space-y-1">
        <a class="nav-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}" href="{{ route('seller.dashboard') }}">
            <span class="material-symbols-outlined mr-3">dashboard</span>
            Dashboard
        </a>
        <a class="nav-link {{ request()->routeIs('seller.products.index') ? 'active' : '' }}" href="{{ route('seller.products.index') }}">
            <span class="material-symbols-outlined mr-3">inventory_2</span>
            Manage Products
        </a>
        <a class="nav-link {{ request()->routeIs('seller.products.create') ? 'active' : '' }}" href="{{ route('seller.products.create') }}">
            <span class="material-symbols-outlined mr-3">add_box</span>
            Upload Product
        </a>
        <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
            <span class="material-symbols-outlined mr-3">settings</span>
            Settings
        </a>
    </nav>
    
    <div class="px-4 mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full py-4 bg-primary text-on-primary rounded-lg font-bold flex items-center justify-center gap-2 hover:opacity-90 hover:scale-[1.02] active:scale-95 transition-all duration-300">
                <span class="material-symbols-outlined">logout</span>
                Logout
            </button>
        </form>
        
        <div class="mt-6 flex items-center gap-3 px-2 transition-all duration-300 hover:translate-x-1">
            <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container font-black">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div>
                <p class="text-sm font-bold text-primary">{{ auth()->user()->name }}</p>
                <p class="text-[10px] text-primary/60 uppercase tracking-widest">Master Artisan</p>
            </div>
        </div>
    </div>
</aside>

<!-- Main Content Canvas -->
<main class="lg:ml-64 min-h-screen p-8 lg:p-12">
    @if(session('success'))
        <div class="mb-6 bg-[#fbfbe2] border-2 border-[#191c3c]/10 px-4 py-4 rounded-2xl shadow-sm flex items-start gap-4 animate-slide-up">
            <span class="material-symbols-outlined text-green-600 mt-0.5">check_circle</span>
            <div>
                <h4 class="font-bold text-[#191c3c] font-['Epilogue'] tracking-tight">Sukses</h4>
                <p class="text-sm text-[#46464e] mt-1">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-[#ffdad6]/30 border-2 border-[#ba1a1a]/20 px-4 py-4 rounded-2xl shadow-sm flex items-start gap-4 animate-slide-up">
            <span class="material-symbols-outlined text-[#ba1a1a] mt-0.5">error</span>
            <div>
                <h4 class="font-bold text-[#ba1a1a] font-['Epilogue'] tracking-tight">Terjadi Kesalahan</h4>
                <p class="text-sm text-[#ba1a1a]/90 mt-1">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 bg-[#ffdad6]/30 border-2 border-[#ba1a1a]/20 px-4 py-4 rounded-2xl shadow-sm flex items-start gap-4 animate-slide-up">
            <span class="material-symbols-outlined text-[#ba1a1a] mt-0.5">warning</span>
            <div>
                <h4 class="font-bold text-[#ba1a1a] font-['Epilogue'] tracking-tight">Ada yang salah dengan isian form</h4>
                <ul class="text-sm text-[#ba1a1a]/90 mt-1 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @yield('content')
</main>

<!-- BottomNavBar for Mobile -->
<nav class="lg:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 pb-6 pt-2 bg-[#fbfbe2]/90 backdrop-blur-lg border-t border-[#c7c5cf]/15 shadow-[0_-10px_40px_rgba(25,28,60,0.05)] rounded-t-3xl transition-all duration-300 ease-in-out">
    <a class="flex items-center justify-center {{ request()->routeIs('seller.dashboard') ? 'bg-[#2e3152] text-[#fbfbe2] rounded-2xl p-3 px-6' : 'text-[#191c3c]/50 p-2' }} transition-all duration-300" href="{{ route('seller.dashboard') }}">
        <span class="material-symbols-outlined">home</span>
    </a>
    <a class="flex items-center justify-center {{ request()->routeIs('seller.products.index') ? 'bg-[#2e3152] text-[#fbfbe2] rounded-2xl p-3 px-6' : 'text-[#191c3c]/50 p-2' }} transition-all duration-300" href="{{ route('seller.products.index') }}">
        <span class="material-symbols-outlined">inventory_2</span>
    </a>
    <a class="flex items-center justify-center {{ request()->routeIs('seller.products.create') ? 'bg-[#2e3152] text-[#fbfbe2] rounded-2xl p-3 px-6' : 'text-[#191c3c]/50 p-2' }} transition-all duration-300" href="{{ route('seller.products.create') }}">
        <span class="material-symbols-outlined">add_box</span>
    </a>
    <a class="flex items-center justify-center {{ request()->routeIs('profile.edit') ? 'bg-[#2e3152] text-[#fbfbe2] rounded-2xl p-3 px-6' : 'text-[#191c3c]/50 p-2' }} transition-all duration-300" href="{{ route('profile.edit') }}">
        <span class="material-symbols-outlined">settings</span>
    </a>
</nav>

@stack('scripts')
</body>
</html>
