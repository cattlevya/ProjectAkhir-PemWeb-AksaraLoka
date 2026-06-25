<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    /**
     * Update status pesanan dengan validasi state machine
     *
     * Status hanya boleh bertransisi sesuai urutan yang ditentukan.
     * Tidak boleh melompat atau kembali ke status sebelumnya.
     */
    public function updateStatus(Order $order, string $newStatus): void
    {
        if (!$order->canTransitionTo($newStatus)) {
            $currentLabel = $order->status_label;
            $newLabel = Order::STATUS_LABELS[$newStatus] ?? $newStatus;
            throw new \RuntimeException(
                "Status tidak dapat diubah dari '{$currentLabel}' ke '{$newLabel}'."
            );
        }

        $order->update(['status' => $newStatus]);
    }

    /**
     * Batalkan pesanan
     */
    public function cancelOrder(Order $order): void
    {
        if (!$order->canTransitionTo(Order::STATUS_DIBATALKAN)) {
            throw new \RuntimeException(
                "Pesanan dengan status '{$order->status_label}' tidak dapat dibatalkan."
            );
        }

        // Kembalikan stok produk
        foreach ($order->items as $item) {
            $item->product->increment('stock', $item->qty);
        }

        $order->update(['status' => Order::STATUS_DIBATALKAN]);
    }

    /**
     * Ambil pesanan berdasarkan toko penjual
     */
    public function getOrdersByStore(Store $store, ?string $status = null): Collection
    {
        $query = Order::whereHas('items', function ($q) use ($store) {
            $q->where('store_id', $store->id);
        })->with(['buyer', 'items' => function ($q) use ($store) {
            // Hanya tampilkan item milik toko ini
            $q->where('store_id', $store->id)->with('product');
        }])->latest();

        if ($status) {
            $query->where('status', $status);
        }

        return $query->get();
    }

    /**
     * Ambil pesanan berdasarkan pembeli
     */
    public function getOrdersByBuyer(User $buyer): Collection
    {
        return Order::where('buyer_id', $buyer->id)
            ->with(['items.product.images', 'items.store'])
            ->latest()
            ->get();
    }

    /**
     * Ambil semua pesanan untuk admin
     */
    public function getAllOrders(?string $status = null)
    {
        $query = Order::with(['buyer', 'items.product', 'items.store'])->latest();

        if ($status) {
            $query->where('status', $status);
        }

        return $query->paginate(15);
    }

    /**
     * Upload bukti pembayaran
     */
    public function uploadPaymentProof(Order $order, string $path): void
    {
        $order->update([
            'payment_proof' => $path,
            'status' => Order::STATUS_DIBAYAR,
        ]);
    }
}
