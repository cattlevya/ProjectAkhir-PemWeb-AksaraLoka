<?php

namespace App\Services;

use App\Models\Store;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Carbon;

class StoreService
{
    /**
     * Buat toko baru untuk user yang upgrade ke penjual
     */
    public function createStore(User $user, array $data): Store
    {
        $user->update(['role' => User::ROLE_PENJUAL]);

        return Store::create([
            'user_id' => $user->id,
            'store_name' => $data['store_name'],
            'description' => $data['description'] ?? null,
            'logo' => $data['logo'] ?? null,
            'address' => $data['address'] ?? null,
        ]);
    }

    /**
     * Update informasi toko
     */
    public function updateStore(Store $store, array $data): Store
    {
        $store->update($data);
        return $store->fresh();
    }

    /**
     * Ambil statistik dashboard penjual
     */
    public function getStoreStats(Store $store): array
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();

        // Total pesanan hari ini
        $ordersToday = Order::whereHas('items', function ($q) use ($store) {
            $q->where('store_id', $store->id);
        })->whereDate('created_at', $today)->count();

        // Pendapatan bulan ini
        $monthlyRevenue = OrderItem::where('store_id', $store->id)
            ->whereHas('order', function ($q) use ($startOfMonth) {
                $q->where('created_at', '>=', $startOfMonth)
                  ->whereNotIn('status', [Order::STATUS_DIBATALKAN]);
            })->sum('subtotal');

        // Produk aktif
        $activeProducts = $store->products()->where('is_active', true)->count();

        // Pesanan pending (menunggu diproses)
        $pendingOrders = Order::whereHas('items', function ($q) use ($store) {
            $q->where('store_id', $store->id);
        })->whereIn('status', [
            Order::STATUS_DIBAYAR,
            Order::STATUS_MENUNGGU,
        ])->count();

        return [
            'orders_today' => $ordersToday,
            'monthly_revenue' => $monthlyRevenue,
            'active_products' => $activeProducts,
            'pending_orders' => $pendingOrders,
        ];
    }
}
