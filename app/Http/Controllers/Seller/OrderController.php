<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $store = auth()->user()->store;
        if (!$store) {
            return redirect()->route('seller.register')->with('error', 'Toko tidak ditemukan.');
        }
        $status = $request->get('status');

        $orders = $this->orderService->getOrdersByStore($store, $status);

        return view('seller.orders.index', compact('orders', 'status'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $store = auth()->user()->store;
        $order->load(['buyer', 'items' => function ($q) use ($store) {
            $q->where('store_id', $store->id)->with('product.images');
        }]);

        return view('seller.orders.show', compact('order'));
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        $this->authorize('updateStatus', $order);

        try {
            $this->orderService->updateStatus($order, $request->status);
            return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
