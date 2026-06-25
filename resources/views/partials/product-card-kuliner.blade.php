<article class="group cursor-pointer">
  <a href="{{ route('product.show', $product->slug) }}" class="block">
    <div class="aspect-square bg-[var(--color-cream-warm)] dark:bg-[var(--color-dark-card)] p-6 overflow-hidden relative flex items-center justify-center">
      <img src="{{ $product->primaryImageUrl }}"
           alt="{{ $product->name }}"
           class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
           loading="lazy"/>
      <div class="absolute inset-0 bg-[var(--color-espresso)]/0 group-hover:bg-[var(--color-espresso)]/40
                  transition-all duration-300 flex items-end justify-center pb-4">
        <form action="{{ route('cart.add') }}" method="POST" class="inline" onclick="event.stopPropagation();">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="qty" value="1">
            <button type="submit" class="opacity-0 group-hover:opacity-100 translate-y-3 group-hover:translate-y-0
                           transition-all duration-300
                           bg-[var(--color-cream)] text-[var(--color-espresso)]
                           text-[10px] uppercase tracking-widest px-5 py-2">
              + Keranjang
            </button>
        </form>
      </div>
    </div>
    <div class="pt-3 text-center">
      <span class="block text-[10px] uppercase tracking-[0.2em] text-[var(--color-gold)] mb-1">
        {{ $product->category->name ?? 'Gastronomi' }}
      </span>
      <h3 class="font-['Fraunces'] text-[var(--color-espresso)] dark:text-[var(--color-cream)] text-base">
        {{ $product->name }}
      </h3>
      <p class="font-['Fraunces'] italic text-[var(--color-text-secondary)] text-sm mt-1">
        Rp {{ number_format($product->price, 0, ',', '.') }}
      </p>
    </div>
  </a>
</article>
