<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Pembeli bisa melihat pesanannya sendiri,
     * Penjual bisa melihat pesanan yang berisi produk tokonya,
     * Admin bisa melihat semua
     */
    public function view(User $user, Order $order): bool
    {
        if ($user->isAdmin()) return true;

        // Pembeli pemilik pesanan
        if ($order->buyer_id === $user->id) return true;

        // Penjual yang tokonya terlibat dalam pesanan ini
        if ($user->isPenjual() && $user->store) {
            return $order->items()->where('store_id', $user->store->id)->exists();
        }

        return false;
    }

    /**
     * Hanya pembeli yang bisa upload bukti pembayaran, dan hanya saat menunggu pembayaran
     */
    public function uploadPaymentProof(User $user, Order $order): bool
    {
        return $order->buyer_id === $user->id
            && $order->status === Order::STATUS_MENUNGGU;
    }

    /**
     * Penjual bisa update status pesanan yang berisi produk tokonya,
     * Admin bisa update semua
     */
    public function updateStatus(User $user, Order $order): bool
    {
        if ($user->isAdmin()) return true;

        if ($user->isPenjual() && $user->store) {
            return $order->items()->where('store_id', $user->store->id)->exists();
        }

        return false;
    }
}
