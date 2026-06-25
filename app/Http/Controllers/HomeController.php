<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Hero: 3 produk terbaru untuk layout bento
        $heroProducts = Product::with(['category', 'images', 'store'])
                             ->active()
                             ->inStock()
                             ->latest()->take(3)->get();

        // Gastronomi (Kuliner): max 8 produk
        $kulineerProducts = Product::with(['category', 'images', 'store'])
                                  ->active()
                                  ->inStock()
                                  ->whereHas('category', fn($q) => $q->where('slug', 'kuliner'))
                                  ->latest()->take(8)->get();

        // Wastra: max 5 produk (1 feature besar, 4 grid kecil)
        $wastraProducts = Product::with(['category', 'images', 'store'])
                                ->active()
                                ->inStock()
                                ->whereHas('category', fn($q) => $q->where('slug', 'wastra'))
                                ->latest()->take(5)->get();

        return view('home', compact('heroProducts', 'kulineerProducts', 'wastraProducts'));
    }
}
