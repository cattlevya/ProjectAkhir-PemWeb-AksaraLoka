{{-- Product Card Component --}}
{{-- Usage: @include('components.product-card', ['product' => $product]) --}}

<div class="group animate-fade-in">
    <a href="{{ route('product.show', $product->slug) }}" class="block">
        {{-- Conditional Image Layout --}}
        @if($product->category && $product->category->isWastra())
            {{-- Portrait Full-Bleed 2:3 — untuk tekstil & kain --}}
            <div class="aspect-[2/3] overflow-hidden bg-cream-warm">
                <img src="{{ $product->primary_image_url }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-[1.03]"
                     loading="lazy">
            </div>
        @elseif($product->category && $product->category->isKuliner())
            {{-- Square dengan inner padding — untuk produk makanan --}}
            <div class="aspect-square bg-cream p-8 flex items-center justify-center overflow-hidden">
                <img src="{{ $product->primary_image_url }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-contain transition-transform duration-700 ease-out group-hover:scale-[1.03]"
                     loading="lazy">
            </div>
        @else
            {{-- Default: Square --}}
            <div class="aspect-square overflow-hidden bg-cream-warm">
                <img src="{{ $product->primary_image_url }}"
                     alt="{{ $product->name }}"
                     class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-[1.03]"
                     loading="lazy">
            </div>
        @endif

        {{-- Product Info --}}
        <div class="mt-3 space-y-1">
            <p class="text-[10px] uppercase tracking-[0.15em] text-gold">
                {{ $product->category->name ?? 'Uncategorized' }}
            </p>
            <h3 class="text-sm font-medium text-espresso-deep leading-tight group-hover:text-gold transition-colors duration-300">
                {{ $product->name }}
            </h3>
            <p class="text-sm text-secondary-text font-display italic">
                {{ $product->formatted_price }}
            </p>
            @if($product->store)
                <p class="text-[10px] text-secondary-text tracking-wide">
                    {{ $product->store->store_name }}
                </p>
            @endif
        </div>
    </a>
</div>
