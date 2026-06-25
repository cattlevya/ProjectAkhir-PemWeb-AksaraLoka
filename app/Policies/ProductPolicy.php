<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Hanya penjual yang punya toko bisa membuat produk
     */
    public function create(User $user): bool
    {
        return $user->isPenjual() && $user->hasStore();
    }

    /**
     * Hanya pemilik toko yang bisa mengubah produk miliknya
     */
    public function update(User $user, Product $product): bool
    {
        if ($user->isAdmin()) return true;
        return $user->isPenjual() && $product->store_id === $user->store?->id;
    }

    /**
     * Hanya pemilik toko yang bisa menghapus produk miliknya
     */
    public function delete(User $user, Product $product): bool
    {
        if ($user->isAdmin()) return true;
        return $user->isPenjual() && $product->store_id === $user->store?->id;
    }
}
