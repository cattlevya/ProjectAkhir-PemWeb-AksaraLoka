<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadPaymentProofRequest;
use App\Models\Order;
use App\Services\OrderService;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        if (auth()->user()->isAdmin() || auth()->user()->isPenjual()) {
            return redirect()->route('home')->with('error', 'Hanya pembeli yang memiliki riwayat belanja.');
        }
        $orders = $this->orderService->getOrdersByBuyer(auth()->user());

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        $order->load('items.product.images', 'items.store', 'buyer');

        return view('orders.show', compact('order'));
    }

    public function uploadPayment(UploadPaymentProofRequest $request, Order $order)
    {
        $this->authorize('uploadPaymentProof', $order);

        $path = $request->file('payment_proof')->store('payment-proofs', 'public');

        $this->orderService->uploadPaymentProof($order, $path);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Bukti pembayaran berhasil diupload!');
    }
}
