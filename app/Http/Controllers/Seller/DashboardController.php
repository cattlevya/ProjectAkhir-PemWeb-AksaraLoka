<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\StoreService;

class DashboardController extends Controller
{
    protected StoreService $storeService;

    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    public function index()
    {
        $store = auth()->user()->store;

        if (!$store) {
            return redirect()->route('seller.register')
                ->with('warning', 'Silakan daftarkan toko Anda terlebih dahulu.');
        }

        $stats = $this->storeService->getStoreStats($store);

        $recentOrders = \App\Models\Order::whereHas('items', function ($q) use ($store) {
            $q->where('store_id', $store->id);
        })->with(['buyer', 'items' => function ($q) use ($store) {
            $q->where('store_id', $store->id)->with('product');
        }])->latest()->take(10)->get();

        return view('seller.dashboard', compact('store', 'stats', 'recentOrders'));
    }
}
