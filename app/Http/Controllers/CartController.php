<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        if (auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isPenjual())) {
            return redirect()->route('home')->with('error', 'Fitur keranjang hanya untuk pembeli.');
        }
        $cartItems = $this->cartService->getCartItems();
        $cartTotal = $this->cartService->getCartTotal();

        return view('cart.index', compact('cartItems', 'cartTotal'));
    }

    public function add(Request $request)
    {
        if (auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isPenjual())) {
            return redirect()->route('home')->with('error', 'Fitur keranjang hanya untuk pembeli.');
        }
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'nullable|integer|min:1',
        ]);

        $this->cartService->addToCart(
            $request->input('product_id'),
            $request->input('qty', 1)
        );

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'qty' => 'required|integer|min:1',
        ]);

        $this->cartService->updateQty(
            $request->input('product_id'),
            $request->input('qty')
        );

        return redirect()->back()->with('success', 'Keranjang berhasil diupdate.');
    }

    public function remove(int $productId)
    {
        $this->cartService->removeFromCart($productId);

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
