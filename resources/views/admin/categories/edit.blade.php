@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="font-display text-3xl text-espresso-deep mb-8">Edit Kategori</h1>
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="space-y-6">
            <div>
                <label class="text-[10px] uppercase tracking-[0.2em] text-secondary-text block mb-2">Nama Kategori *</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="w-full bg-cream-warm border border-cream-mid px-4 py-3 text-sm focus:border-gold focus:ring-0">
                @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-[10px] uppercase tracking-[0.2em] text-secondary-text block mb-2">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="w-full bg-cream-warm border border-cream-mid px-4 py-3 text-sm focus:border-gold focus:ring-0">
            </div>
            <div>
                <label class="text-[10px] uppercase tracking-[0.2em] text-secondary-text block mb-2">Icon</label>
                @if($category->icon)<img src="{{ asset('storage/' . $category->icon) }}" class="w-12 h-12 mb-2 object-contain">@endif
                <input type="file" name="icon" accept="image/*" class="block w-full text-sm text-secondary-text file:mr-4 file:py-2 file:px-4 file:border-0 file:text-[10px] file:uppercase file:tracking-wider file:bg-espresso file:text-cream file:cursor-pointer">
            </div>
        </div>
        <div class="mt-8 flex gap-4">
            <button type="submit" class="bg-espresso text-cream px-8 py-3 text-[11px] uppercase tracking-[0.2em] font-semibold hover:bg-espresso-deep transition-colors">Simpan</button>
            <a href="{{ route('admin.categories.index') }}" class="border border-espresso-mid/20 px-8 py-3 text-[11px] uppercase tracking-[0.2em] text-espresso-mid hover:border-gold hover:text-gold transition-colors">Batal</a>
        </div>
    </form>
</div>
@endsection
