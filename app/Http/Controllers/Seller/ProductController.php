<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;
        if (!$store) {
            return redirect()->route('seller.register')->with('error', 'Toko tidak ditemukan.');
        }
        $products = $store->products()
            ->with(['category', 'images'])
            ->latest()
            ->paginate(15);

        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $store = auth()->user()->store;
        if (!$store) {
            return redirect()->route('seller.register')->with('error', 'Toko tidak ditemukan.');
        }
        $categories = Category::all();
        return view('seller.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $store = auth()->user()->store;
        if (!$store) {
            return redirect()->route('seller.register')->with('error', 'Toko tidak ditemukan.');
        }
        $data = $request->validated();

        $product = $store->products()->create([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'weight' => $data['weight'] ?? null,
        ]);

        // Upload gambar produk
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => $index === (int) ($data['primary_image'] ?? 0),
                ]);
            }
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        $categories = Category::all();
        $product->load('images');

        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $data = $request->validated();

        $product->update([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'weight' => $data['weight'] ?? null,
            'is_active' => $data['is_active'] ?? $product->is_active,
        ]);

        // Hapus gambar yang diminta
        if (!empty($data['remove_images'])) {
            foreach ($data['remove_images'] as $imageId) {
                $img = ProductImage::where('id', $imageId)
                    ->where('product_id', $product->id)
                    ->first();
                if ($img) {
                    Storage::disk('public')->delete($img->image_path);
                    $img->delete();
                }
            }
        }

        // Upload gambar baru
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        // Set primary image
        if (isset($data['primary_image'])) {
            $product->images()->update(['is_primary' => false]);
            $product->images()->where('id', $data['primary_image'])->update(['is_primary' => true]);
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        // Hapus semua gambar dari storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
