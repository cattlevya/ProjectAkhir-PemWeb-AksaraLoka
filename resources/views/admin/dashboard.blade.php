<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Curator Portal | AksaraLoka Admin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;700;900&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet"/>
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
                        "on-background": "#1b1d0e"
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
    </style>
</head>
<body class="bg-surface">

<!-- SideNavBar Anchor -->
<aside class="hidden lg:flex flex-col fixed left-0 top-0 h-full py-6 bg-[#fbfbe2] h-screen w-64 border-r border-[#c7c5cf]/15 z-50">
    <div class="px-6 mb-10">
        <h1 class="text-lg font-bold text-[#191c3c] font-headline uppercase tracking-widest">Curator Portal</h1>
        <p class="text-xs text-[#191c3c]/60 font-label">Heritage Management</p>
    </div>
    
    <nav class="flex-1 space-y-2">
        <a class="flex items-center px-6 py-3 bg-[#2e3152] text-[#fbfbe2] rounded-r-full mr-4 transition-all duration-300 font-['Manrope'] font-medium text-sm tracking-wide group" href="{{ route('admin.dashboard') }}">
            <span class="material-symbols-outlined mr-3 text-lg">dashboard</span>
            <span>Dashboard</span>
        </a>
        <a class="flex items-center px-6 py-3 text-[#191c3c]/60 hover:bg-[#2e3152]/10 hover:pl-8 transition-all duration-300 font-['Manrope'] font-medium text-sm tracking-wide" href="{{ route('home') }}">
            <span class="material-symbols-outlined mr-3 text-lg">storefront</span>
            <span>View Store</span>
        </a>
    </nav>
    
    <div class="px-6 mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full bg-secondary text-on-secondary py-3 rounded-lg font-bold text-sm uppercase tracking-widest shadow-lg hover:opacity-90 transition-opacity">
                Log Out
            </button>
        </form>
        
        <div class="mt-8 flex items-center space-x-3 border-t border-outline-variant/15 pt-6">
            <div class="h-10 w-10 rounded-full bg-primary-container flex items-center justify-center overflow-hidden">
                <span class="material-symbols-outlined text-on-primary-container">shield_person</span>
            </div>
            <div>
                <p class="text-xs font-bold text-primary">{{ auth()->user()->name }}</p>
                <p class="text-[10px] text-on-surface-variant uppercase tracking-tighter">Chief Curator</p>
            </div>
        </div>
    </div>
</aside>

<!-- Main Content Canvas -->
<main class="lg:ml-64 min-h-screen p-8 lg:p-12">
    <!-- Artisan Breadcrumb -->
    <header class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="space-y-2">
            <div class="flex items-center gap-4">
                <span class="text-secondary text-sm font-bold uppercase tracking-widest font-label">OVERVIEW</span>
                <div class="w-10 h-[1px] bg-outline-variant/20"></div>
                <span class="text-on-surface-variant/40 text-sm font-bold uppercase tracking-widest font-label">DASHBOARD</span>
            </div>
            <h2 class="text-4xl lg:text-5xl font-black text-primary font-headline tracking-tighter">Marketplace Performance</h2>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.dashboard.export-pdf') }}" target="_blank" class="flex items-center gap-2 px-6 py-2 bg-primary text-on-primary rounded text-sm font-bold hover:opacity-90 transition-opacity">
                <span class="material-symbols-outlined text-lg">picture_as_pdf</span>
                Export PDF
            </a>
        </div>
    </header>

    <!-- Bento Grid Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="col-span-1 md:col-span-2 bg-primary-container p-8 rounded-xl flex flex-col justify-between text-on-primary min-h-[220px]">
            <div class="flex justify-between items-start">
                <span class="material-symbols-outlined text-3xl text-secondary-container">payments</span>
            </div>
            <div>
                <p class="text-on-primary-container text-sm font-medium uppercase tracking-widest">Gross Revenue (GMV)</p>
                <p class="text-4xl font-headline font-black mt-1">Rp {{ number_format($stats['gmv'], 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="bg-surface-container-low p-8 rounded-xl flex flex-col justify-between min-h-[220px]">
            <span class="material-symbols-outlined text-3xl text-secondary">shopping_bag</span>
            <div>
                <p class="text-on-surface-variant text-sm font-medium uppercase tracking-widest">Total Orders</p>
                <p class="text-4xl font-headline font-black text-primary mt-1">{{ number_format($stats['total_orders']) }}</p>
            </div>
        </div>
        <div class="bg-surface-container-low p-8 rounded-xl flex flex-col justify-between min-h-[220px]">
            <span class="material-symbols-outlined text-3xl text-secondary">person_add</span>
            <div>
                <p class="text-on-surface-variant text-sm font-medium uppercase tracking-widest">Total Artists / Stores</p>
                <p class="text-4xl font-headline font-black text-primary mt-1">{{ number_format($stats['total_stores']) }}</p>
            </div>
        </div>
    </div>

    <!-- Secondary Section: Operations Asymmetry -->
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-8 items-start">
        
        <!-- Left: Recent Orders / Activities -->
        <div class="xl:col-span-3 space-y-8">
            <section class="bg-surface-container-lowest p-8 rounded-2xl border border-outline-variant/15 shadow-sm">
                <div class="flex justify-between items-center mb-10">
                    <h3 class="text-xl font-headline font-bold text-primary">Monthly Trend Placeholder</h3>
                    <div class="flex gap-2">
                        <span class="flex items-center gap-1 text-xs font-bold"><span class="w-3 h-3 bg-primary rounded-full"></span> Users</span>
                        <span class="flex items-center gap-1 text-xs font-bold"><span class="w-3 h-3 bg-secondary rounded-full"></span> Orders</span>
                    </div>
                </div>
                
                <!-- Visual Placeholder for Chart -->
                <div class="h-64 flex items-end justify-between gap-4 px-4 border-b border-outline-variant/10 pb-2">
                    <!-- Fake Bars -->
                    <div class="flex-1 bg-surface-container-high rounded-t-lg h-[40%] group relative">
                        <div class="absolute inset-0 bg-primary opacity-0 group-hover:opacity-10 transition-opacity rounded-t-lg"></div>
                    </div>
                    <div class="flex-1 bg-surface-container-high rounded-t-lg h-[65%] group relative">
                        <div class="absolute inset-0 bg-primary opacity-0 group-hover:opacity-10 transition-opacity rounded-t-lg"></div>
                    </div>
                    <div class="flex-1 bg-surface-container-high rounded-t-lg h-[45%] group relative">
                        <div class="absolute inset-0 bg-primary opacity-0 group-hover:opacity-10 transition-opacity rounded-t-lg"></div>
                    </div>
                    <div class="flex-1 bg-primary/40 rounded-t-lg h-[90%]"></div>
                    <div class="flex-1 bg-surface-container-high rounded-t-lg h-[70%] group relative">
                        <div class="absolute inset-0 bg-primary opacity-0 group-hover:opacity-10 transition-opacity rounded-t-lg"></div>
                    </div>
                </div>
            </section>

            <!-- Recent Orders Table -->
            <section>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-headline font-bold text-primary">Recent Global Orders</h3>
                </div>
                <div class="bg-surface-container-low rounded-2xl overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-max">
                        <thead>
                            <tr class="border-b border-outline-variant/10 text-[10px] uppercase tracking-widest text-on-surface-variant/60">
                                <th class="px-6 py-4">Transaction ID</th>
                                <th class="px-6 py-4">Penerima / Pembeli</th>
                                <th class="px-6 py-4">Total Amount</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Toko</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @forelse($recentOrders as $order)
                            <tr class="hover:bg-white/40 transition-colors">
                                <td class="px-6 py-4 font-bold text-primary">#{{ $order->id }}</td>
                                <td class="px-6 py-4">
                                    <p class="font-bold text-primary">{{ $order->shipping_name ?? $order->buyer->name }}</p>
                                    <p class="text-[10px] text-on-surface-variant">{{ $order->created_at->format('d M Y') }}</p>
                                </td>
                                <td class="px-6 py-4 font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded text-[10px] font-bold uppercase 
                                        @if($order->status === 'menunggu_pembayaran') bg-yellow-100 text-yellow-800 
                                        @elseif($order->status === 'dibatalkan') bg-red-100 text-red-800 
                                        @else bg-green-100 text-green-800 @endif
                                    ">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @foreach($order->items->unique('store_id') as $item)
                                        <span class="inline-block bg-primary/10 px-2 py-0.5 rounded text-xs text-primary">{{ $item->store->store_name ?? 'Unknown' }}</span>
                                    @endforeach
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-on-surface-variant">Belum ada transaksi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        
        <!-- Right Column: Oversight & Stats -->
        <div class="space-y-8">
            
            <!-- User Oversight Widget -->
            <section class="bg-surface-container-high p-6 rounded-2xl">
                <h3 class="text-sm font-bold text-primary uppercase tracking-widest mb-6">User Oversight</h3>
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-secondary/20 flex items-center justify-center text-secondary">
                                <span class="material-symbols-outlined text-sm">brush</span>
                            </div>
                            <span class="text-xs font-bold">Total Seller (Artists)</span>
                        </div>
                        <span class="text-sm font-black text-primary">{{ number_format($stats['total_stores']) }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-primary-container/20 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-sm">group</span>
                            </div>
                            <span class="text-xs font-bold">Total Registered Users</span>
                        </div>
                        <span class="text-sm font-black text-primary">{{ number_format($stats['total_users']) }}</span>
                    </div>
                </div>
            </section>

        </div>
    </div>
</main>

<!-- BottomNavBar (Mobile Anchor) -->
<nav class="lg:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-4 pb-6 pt-2 bg-[#fbfbe2]/90 backdrop-blur-lg border-t border-[#c7c5cf]/15 shadow-[0_-10px_40px_rgba(25,28,60,0.05)] rounded-t-3xl">
    <a class="flex flex-col items-center justify-center bg-[#2e3152] text-[#fbfbe2] rounded-2xl p-3 px-6 duration-300 scale-110" href="javascript:void(0)">
        <span class="material-symbols-outlined">dashboard</span>
        <span class="font-['Manrope'] text-[10px] uppercase tracking-[0.1em]">Dash</span>
    </a>
    <a class="flex flex-col items-center justify-center text-[#191c3c]/50 p-2 hover:opacity-80 transition-opacity" href="{{ route('home') }}">
        <span class="material-symbols-outlined">storefront</span>
        <span class="font-['Manrope'] text-[10px] uppercase tracking-[0.1em]">Store</span>
    </a>
</nav>

</body>
</html>
