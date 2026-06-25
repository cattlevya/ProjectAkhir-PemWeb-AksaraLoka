<div class="overflow-hidden bg-[var(--color-espresso-mid)] py-3" aria-hidden="true">
  <div class="marquee-track flex gap-0 whitespace-nowrap">
    @for($i = 0; $i < 4; $i++)
    <span class="text-[var(--color-cream)] text-[10px] uppercase tracking-[0.25em] px-10 opacity-60">
      Batik Banyumas
    </span>
    <span class="text-[var(--color-gold)] text-[10px] px-3">✦</span>
    <span class="text-[var(--color-cream)] text-[10px] uppercase tracking-[0.25em] px-10 opacity-60">
      Mendoan Asli
    </span>
    <span class="text-[var(--color-gold)] text-[10px] px-3">✦</span>
    <span class="text-[var(--color-cream)] text-[10px] uppercase tracking-[0.25em] px-10 opacity-60">
      Tenun Serayu
    </span>
    <span class="text-[var(--color-gold)] text-[10px] px-3">✦</span>
    <span class="text-[var(--color-cream)] text-[10px] uppercase tracking-[0.25em] px-10 opacity-60">
      Getuk Goreng
    </span>
    <span class="text-[var(--color-gold)] text-[10px] px-3">✦</span>
    @endfor
  </div>
</div>

<style>
.marquee-track {
  animation: marquee 30s linear infinite;
  display: inline-flex;
}
@keyframes marquee {
  from { transform: translateX(0); }
  to   { transform: translateX(-50%); }
}
</style>
