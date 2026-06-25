<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    const SESSION_KEY = 'cart_items';

    /**
     * Tambah produk ke keranjang
     */
    public function addToCart(int $productId, int $qty = 1): void
    {
        $product = Product::with('primaryImage')->findOrFail($productId);
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] += $qty;
        } else {
            $cart[$productId] = [
                'qty' => $qty,
                'price' => $product->price,
                'name' => $product->name,
                'image' => $product->primary_image_url,
                'store_id' => $product->store_id,
                'store_name' => $product->store->store_name ?? '',
                'stock' => $product->stock,
                'weight' => $product->weight,
                'slug' => $product->slug,
            ];
        }

        // Batasi qty jangan melebihi stok
        if ($cart[$productId]['qty'] > $product->stock) {
            $cart[$productId]['qty'] = $product->stock;
        }

        $this->saveCart($cart);
    }

    /**
     * Hapus produk dari keranjang
     */
    public function removeFromCart(int $productId): void
    {
        $cart = $this->getCart();
        unset($cart[$productId]);
        $this->saveCart($cart);
    }

    /**
     * Update quantity produk di keranjang
     */
    public function updateQty(int $productId, int $qty): void
    {
        $cart = $this->getCart();
        if (isset($cart[$productId])) {
            if ($qty <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['qty'] = min($qty, $cart[$productId]['stock']);
            }
        }
        $this->saveCart($cart);
    }

    /**
     * Ambil semua item keranjang
     */
    public function getCartItems(): array
    {
        return $this->getCart();
    }

    /**
     * Hitung total harga keranjang
     */
    public function getCartTotal(): float
    {
        $cart = $this->getCart();
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }
        return $total;
    }

    /**
     * Hitung jumlah item di keranjang
     */
    public function cartCount(): int
    {
        $cart = $this->getCart();
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['qty'];
        }
        return $count;
    }

    /**
     * Kosongkan keranjang
     */
    public function clearCart(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    /**
     * Ambil data cart dari session
     */
    private function getCart(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    /**
     * Simpan data cart ke session
     */
    private function saveCart(array $cart): void
    {
        Session::put(self::SESSION_KEY, $cart);
    }
}
