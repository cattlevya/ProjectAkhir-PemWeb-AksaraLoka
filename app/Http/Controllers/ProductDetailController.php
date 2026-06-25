<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductDetailController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->active()
            ->with(['store.user', 'category', 'images'])
            ->firstOrFail();

        // Produk terkait dari toko/kategori yang sama
        $relatedProducts = Product::active()
            ->inStock()
            ->where('id', '!=', $product->id)
            ->where(function ($q) use ($product) {
                $q->where('store_id', $product->store_id)
                  ->orWhere('category_id', $product->category_id);
            })
            ->with(['store', 'category', 'images'])
            ->take(4)
            ->get();

        return view('catalog.show', compact('product', 'relatedProducts'));
    }
}
