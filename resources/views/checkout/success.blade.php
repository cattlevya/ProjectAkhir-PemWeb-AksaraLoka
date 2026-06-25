@extends('layouts.app')

@section('content')
<main class="pt-24 pb-32">
    <!-- Hero Section -->
    <section class="max-w-6xl mx-auto px-6 py-12 text-center md:text-left flex flex-col md:flex-row items-center gap-12">
        <div class="md:w-1/2 space-y-6">
            <div class="flex items-center gap-3 text-secondary font-bold uppercase tracking-widest text-xs">
                <span class="w-8 h-[1px] bg-outline-variant/50"></span>
                Order Confirmed
            </div>
            <h1 class="font-display text-5xl md:text-7xl font-black text-primary tracking-tighter leading-tight">
                A New Legacy <br/>Begins
            </h1>
            <p class="text-lg text-on-surface-variant max-w-md font-light leading-relaxed">
                Your acquisition is now being prepared by our master artisans in Banyumas. Each stroke and fold is a testament to centuries of heritage.
            </p>
            <div class="flex flex-wrap gap-4 pt-4 justify-center md:justify-start">
                <a href="{{ route('orders.index') }}" class="bg-primary text-on-primary px-8 py-4 rounded-lg font-bold hover:opacity-90 transition-all flex items-center gap-2 group">
                    Track Your Acquisition
                    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
                <a href="{{ route('catalog.index') }}" class="bg-surface-container-high text-primary px-8 py-4 rounded-lg font-bold hover:bg-surface-container-highest transition-all">
                    Return to Gallery
                </a>
            </div>
        </div>
        
        <!-- Artistic Confirmation Graphic -->
        <div class="md:w-1/2 relative">
            <div class="w-full aspect-square bg-surface-container-low rounded-full overflow-hidden flex items-center justify-center border-[12px] border-surface">
                <div class="absolute inset-0 opacity-10 pointer-events-none" 
                     style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAVkylOa59qpakzcd8wOo2crKXEbg6UGByIu8KoO6EdFhxuj8jBOyi_8MPGBHWMUXKqPVIjPC9QDU0eESYwV3Y0Nkpt-oA3mCs-4gm4wBOuQ5eVefu_2bmLQ3d1dzgMVl4UWnNorvK-DBLZBhdoE55sWqVZLJsX5ZEFiD10WSdd9A34rw4eGIWmsqvYyeVa6J1ATWQagVW50FbJBuzj_7A_loF0rSq0p5gW5mf1ub1zbmQuzfHhsWbrAyQuJInlbIHfcpROd5jmFl4'); background-size: cover;"></div>
                <div class="z-10 bg-surface rounded-full p-12 shadow-2xl">
                    <span class="material-symbols-outlined text-[120px] text-secondary" style="font-variation-settings: 'FILL' 1;">verified</span>
                </div>
            </div>
            
            <!-- Floating Detail Card -->
            <div class="absolute -bottom-6 -left-6 md:left-0 bg-surface p-6 shadow-xl border border-outline-variant/10 rounded-lg max-w-xs w-full">
                <div class="space-y-3">
                    <div class="flex justify-between items-center text-[10px] text-outline font-bold uppercase tracking-tighter">
                        <span>Group Identifier</span>
                        <span class="text-primary font-black">{{ $groupCode }}</span>
                    </div>
                    <div class="h-[1px] bg-outline-variant/20 w-full"></div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-on-surface-variant">Arrival Window</span>
                        <span class="font-bold text-primary italic">~ 10 Days</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Artisan Impact Section -->
    <section class="bg-surface-container-low py-20 mt-12">
        <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-16 items-center">
            <div class="relative group">
                <img class="w-full aspect-[4/5] object-cover rounded-lg shadow-2xl grayscale hover:grayscale-0 transition-all duration-700" 
                     src="https://lh3.googleusercontent.com/aida-public/AB6AXuBC_KsL50WI1qzMRsBO47CE2AbPSmNXSweLf40V-_UBgfjQ0az2MBorkVA7xRjj-E7YRfuLbmtsTpx3qYy_Ul-dh_aYJ66p96UEHTdsyH-pN_9R4YXPsV3Mv5jVujGNOGUoMl03Wy10GCw-I49M-d1Qi0eL-M4qcv7kUDwBTlJiGvsxMuG7Ki-yi24pKI66uFkVWAPdUfELQVVb8DLCiHp01kBuJVDZ49xQJcAk6fBbd--yatmKqDNXHru-9Xw7ObX8KZnX1F2kAjs"/>
                <div class="absolute -top-4 -right-4 bg-secondary text-on-secondary p-8 rounded-lg max-w-[200px] font-display font-medium leading-tight shadow-xl">
                    Direct support to local artisan families in Banyumas.
                </div>
            </div>
            <div class="space-y-8">
                <h2 class="font-display text-4xl font-bold text-primary tracking-tight">The Artisan's Promise</h2>
                <p class="text-on-surface-variant font-body leading-loose text-lg">
                    Banyumas handicrafts are not mass-produced; they are "born" through patience. Your order supports the preservation of traditional <span class="text-secondary font-bold">Banyumasan Batik</span> and <span class="text-secondary font-bold">Terracotta pottery</span>. We honor the slow pace of creation to ensure every piece carries the soul of the curator's vision.
                </p>
                <div class="grid grid-cols-2 gap-6 pt-4">
                    <div class="space-y-2">
                        <span class="material-symbols-outlined text-secondary">eco</span>
                        <h4 class="font-bold text-primary text-sm">Natural Dyes</h4>
                        <p class="text-[10px] text-on-surface-variant leading-relaxed uppercase tracking-widest font-bold">Sourced from local indigo and mango leaves.</p>
                    </div>
                    <div class="space-y-2">
                        <span class="material-symbols-outlined text-secondary">history_edu</span>
                        <h4 class="font-bold text-primary text-sm">Heritage Verified</h4>
                        <p class="text-[10px] text-on-surface-variant leading-relaxed uppercase tracking-widest font-bold">Includes a signed certificate of origin.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recommended Section -->
    <section class="max-w-6xl mx-auto px-6 py-24">
        <div class="flex justify-between items-end mb-12">
            <div class="space-y-2">
                <h3 class="font-display text-3xl font-black text-primary tracking-tight">You May Also Treasure</h3>
                <p class="text-on-surface-variant text-sm font-medium">Handpicked items that complement your new acquisition.</p>
            </div>
            <a class="text-secondary font-bold border-b-2 border-secondary pb-1 hover:text-primary hover:border-primary transition-all text-sm uppercase tracking-widest font-label" href="{{ route('catalog.index') }}">Explore All</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            @foreach($recommendedProducts as $product)
            <a href="{{ route('product.show', $product->slug) }}" class="space-y-4 group cursor-pointer block">
                <div class="aspect-[3/4] bg-surface-container overflow-hidden rounded-2xl shadow-sm group-hover:shadow-xl transition-all duration-500">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" src="{{ $product->primary_image_url }}" alt="{{ $product->name }}"/>
                </div>
                <div>
                    <span class="text-[10px] uppercase tracking-widest text-secondary font-bold">{{ $product->category->name ?? 'Kategori' }}</span>
                    <h4 class="font-display text-xl font-bold text-primary mt-1">{{ $product->name }}</h4>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-on-surface-variant text-xs font-medium italic">Toko: {{ $product->store->store_name ?? 'AksaraLoka' }}</span>
                        <span class="text-primary font-black text-sm">{{ $product->formatted_price }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </section>
</main>
@endsection

