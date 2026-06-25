<article class="group cursor-pointer">
  <a href="{{ route('product.show', $product->slug) }}" class="block">
    <div class="aspect-[2/3] overflow-hidden bg-[var(--color-cream-warm)] relative">
      <img src="{{ $product->primaryImageUrl }}"
           alt="{{ $product->name }}"
           class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
           loading="lazy"/>
      {{-- Stock badge --}}
      @if($product->stock <= 5 && $product->stock > 0)
        <span class="absolute top-3 left-3 bg-[var(--color-espresso)] text-[var(--color-cream)]
                     text-[10px] uppercase tracking-widest px-2 py-1">
          Sisa {{ $product->stock }}
        </span>
      @endif
    </div>
    <div class="pt-4">
      <span class="block text-[10px] uppercase tracking-[0.2em] text-[var(--color-gold)] mb-1">
        {{ $product->store->store_name ?? 'AksaraLoka' }}
      </span>
      <h3 class="font-['Fraunces'] text-[var(--color-espresso)] dark:text-[var(--color-cream)] text-base leading-snug">
        {{ $product->name }}
      </h3>
      <p class="font-['Fraunces'] italic text-[var(--color-text-secondary)] text-sm mt-1.5">
        Rp {{ number_format($product->price, 0, ',', '.') }}
      </p>
    </div>
  </a>
</article>
