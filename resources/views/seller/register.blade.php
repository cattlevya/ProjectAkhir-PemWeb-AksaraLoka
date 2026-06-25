@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <p class="text-[11px] uppercase tracking-[0.3em] text-gold mb-3">Bergabung</p>
    <h1 class="font-display text-3xl text-espresso-deep mb-6 italic">Buka Toko Anda</h1>
    <p class="text-secondary-text mb-10 leading-relaxed">Daftarkan toko Anda di AksaraLoka dan mulai menjual produk ke seluruh Indonesia.</p>

    <form action="{{ route('seller.register.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="space-y-6">
            <div>
                <label class="text-[10px] uppercase tracking-[0.2em] text-secondary-text block mb-2">Nama Toko *</label>
                <input type="text" name="store_name" value="{{ old('store_name') }}" required class="w-full bg-cream-warm border border-cream-mid px-4 py-3 text-sm focus:border-gold focus:ring-0">
                @error('store_name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-[10px] uppercase tracking-[0.2em] text-secondary-text block mb-2">Deskripsi Toko</label>
                <textarea name="description" rows="4" class="w-full bg-cream-warm border border-cream-mid px-4 py-3 text-sm focus:border-gold focus:ring-0">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="text-[10px] uppercase tracking-[0.2em] text-secondary-text block mb-2">Alamat Toko *</label>
                <textarea name="address" rows="3" required class="w-full bg-cream-warm border border-cream-mid px-4 py-3 text-sm focus:border-gold focus:ring-0">{{ old('address') }}</textarea>
                @error('address') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-[10px] uppercase tracking-[0.2em] text-secondary-text block mb-2">Logo Toko</label>
                <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-secondary-text file:mr-4 file:py-2 file:px-4 file:border-0 file:text-[10px] file:uppercase file:tracking-wider file:bg-espresso file:text-cream file:cursor-pointer">
            </div>
        </div>
        <button type="submit" class="mt-10 w-full bg-espresso text-cream py-4 text-[11px] uppercase tracking-[0.2em] font-semibold hover:bg-espresso-deep transition-colors">
            Daftarkan Toko
        </button>
    </form>
</div>
@endsection
