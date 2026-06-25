@extends('layouts.seller')

@section('title', 'Curate New Piece')

@section('content')
<!-- Header Section -->
<header class="mb-12">
    <nav class="flex items-center gap-3 mb-4">
        <a href="{{ route('seller.products.index') }}" class="text-secondary font-bold text-sm tracking-wider uppercase font-label hover:underline">Gallery</a>
        <div class="h-[1px] w-10 bg-outline-variant/20"></div>
        <span class="text-on-surface-variant/60 text-sm font-label">Curate New Piece</span>
    </nav>
    <h2 class="text-4xl font-black text-primary tracking-tighter">New Masterpiece</h2>
</header>

<div class="max-w-4xl bg-surface-container-low rounded-3xl p-8 lg:p-12 border border-outline-variant/10">
    <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="space-y-10">
            {{-- Section 1: Basic Info --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="md:col-span-2">
                    <label class="text-[10px] uppercase font-black tracking-[0.2em] text-primary/40 block mb-4">Product Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Hand-Drawn Batik Motif Lumbon" required 
                           class="w-full bg-white/50 border-none rounded-xl px-6 py-4 text-primary font-bold placeholder:text-primary/20 focus:ring-2 focus:ring-secondary transition-all">
                    @error('name') <p class="text-error text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-[10px] uppercase font-black tracking-[0.2em] text-primary/40 block mb-4">Collection / Category *</label>
                    <select name="category_id" required 
                            class="w-full bg-white/50 border-none rounded-xl px-6 py-4 text-primary font-bold focus:ring-2 focus:ring-secondary transition-all appearance-none cursor-pointer">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-error text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-[10px] uppercase font-black tracking-[0.2em] text-primary/40 block mb-4">Price (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" min="1000" placeholder="100000" required 
                           class="w-full bg-white/50 border-none rounded-xl px-6 py-4 text-primary font-bold placeholder:text-primary/20 focus:ring-2 focus:ring-secondary transition-all">
                    @error('price') <p class="text-error text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="text-[10px] uppercase font-black tracking-[0.2em] text-primary/40 block mb-4">The Story Behind the Piece *</label>
                    <textarea name="description" rows="6" placeholder="Describe the heritage, the artisan, and the technique..." required 
                              class="w-full bg-white/50 border-none rounded-xl px-6 py-4 text-primary font-bold placeholder:text-primary/20 focus:ring-2 focus:ring-secondary transition-all">{{ old('description') }}</textarea>
                    @error('description') <p class="text-error text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Section 2: Logistics --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 pt-10 border-t border-outline-variant/10">
                <div>
                    <label class="text-[10px] uppercase font-black tracking-[0.2em] text-primary/40 block mb-4">Stock Availability *</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required 
                           class="w-full bg-white/50 border-none rounded-xl px-6 py-4 text-primary font-bold focus:ring-2 focus:ring-secondary transition-all">
                    @error('stock') <p class="text-error text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-[10px] uppercase font-black tracking-[0.2em] text-primary/40 block mb-4">Weight (Grams)</label>
                    <input type="number" name="weight" value="{{ old('weight') }}" min="1" placeholder="250"
                           class="w-full bg-white/50 border-none rounded-xl px-6 py-4 text-primary font-bold placeholder:text-primary/20 focus:ring-2 focus:ring-secondary transition-all">
                    @error('weight') <p class="text-error text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Section 3: Visuals --}}
            <div class="pt-10 border-t border-outline-variant/10">
                <label class="text-[10px] uppercase font-black tracking-[0.2em] text-primary/40 block mb-6">Gallery Visuals * (1-5 images)</label>
                
                <div class="relative">
                    <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp" required
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                           id="image-input" onchange="previewImages(this)">
                    <div class="border-2 border-dashed border-outline-variant/30 rounded-2xl p-12 text-center group hover:border-secondary transition-all">
                        <span class="material-symbols-outlined text-4xl text-primary/20 mb-4 group-hover:text-secondary group-hover:scale-110 transition-all">upload_file</span>
                        <p class="text-sm font-bold text-primary">Drop product photography here</p>
                        <p class="text-[10px] text-primary/40 mt-2 uppercase tracking-widest">or click to browse your archive</p>
                    </div>
                </div>
                
                @error('images') <p class="text-error text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                @error('images.*') <p class="text-error text-xs mt-2 font-bold">{{ $message }}</p> @enderror

                {{-- Preview --}}
                <div id="image-preview" class="flex gap-4 mt-8 flex-wrap"></div>

                <div class="mt-8 bg-primary/5 p-6 rounded-xl border border-primary/10">
                    <label class="text-[10px] uppercase font-black tracking-[0.2em] text-primary/40 block mb-2">Identify Hero Image (Index, starts at 0)</label>
                    <input type="number" name="primary_image" value="0" min="0" max="4"
                           class="w-24 bg-white border-none rounded-lg px-4 py-2 text-primary font-bold focus:ring-2 focus:ring-secondary transition-all">
                    <p class="text-[10px] text-primary/40 mt-2">The selected image will be the primary visual in the marketplace gallery.</p>
                </div>
            </div>
        </div>

        <div class="mt-12 pt-10 border-t border-outline-variant/10 flex flex-col md:flex-row gap-4">
            <button type="submit" class="flex-1 bg-secondary text-on-secondary px-8 py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-xs hover:opacity-90 transition-all active:scale-[0.98]">
                Publish to Gallery
            </button>
            <a href="{{ route('seller.products.index') }}" class="px-8 py-5 rounded-2xl font-black uppercase tracking-[0.2em] text-xs text-primary/40 hover:text-primary transition-all text-center">
                Discard Draft
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewImages(input) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    if (input.files) {
        Array.from(input.files).forEach((file, i) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'w-24 h-32 rounded-xl overflow-hidden bg-white relative shadow-sm border border-outline-variant/10';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover">
                    <div class="absolute bottom-0 left-0 w-full bg-primary/80 backdrop-blur-sm text-white text-[10px] font-black py-1 text-center">
                        #${i}
                    </div>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
}
</script>
@endpush
@endsection
