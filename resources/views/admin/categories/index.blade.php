@extends('layouts.app')
@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex items-start justify-between mb-10">
        <div>
            <p class="text-[11px] uppercase tracking-[0.3em] text-gold mb-3">Admin</p>
            <h1 class="font-display text-3xl text-espresso-deep">Kategori</h1>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="bg-espresso text-cream px-6 py-2.5 text-[11px] uppercase tracking-[0.2em] hover:bg-espresso-deep transition-colors">+ Kategori Baru</a>
    </div>

    <div class="space-y-3">
        @foreach($categories as $cat)
        <div class="flex items-center justify-between bg-cream-warm p-4">
            <div class="flex items-center gap-4">
                @if($cat->icon)
                    <img src="{{ asset('storage/' . $cat->icon) }}" class="w-10 h-10 object-contain">
                @else
                    <div class="w-10 h-10 bg-cream-mid flex items-center justify-center"><span class="text-gold font-display">{{ substr($cat->name, 0, 1) }}</span></div>
                @endif
                <div>
                    <p class="font-medium text-espresso-deep">{{ $cat->name }}</p>
                    <p class="text-[10px] text-secondary-text">{{ $cat->slug }} · {{ $cat->products_count }} produk</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.categories.edit', $cat) }}" class="border border-espresso-mid/20 px-4 py-1.5 text-[10px] uppercase tracking-wider text-espresso-mid hover:border-gold hover:text-gold transition-colors">Edit</a>
                <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Yakin?')">
                    @csrf @method('DELETE')
                    <button class="border border-red-200 px-4 py-1.5 text-[10px] uppercase tracking-wider text-red-600/70 hover:border-red-400 hover:text-red-600 transition-colors">Hapus</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
