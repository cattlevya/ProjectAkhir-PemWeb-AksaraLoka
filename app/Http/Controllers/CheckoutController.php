<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Services\CartService;
use App\Services\CheckoutService;

class CheckoutController extends Controller
{
    protected CartService $cartService;
    protected CheckoutService $checkoutService;

    public function __construct(CartService $cartService, CheckoutService $checkoutService)
    {
        $this->cartService = $cartService;
        $this->checkoutService = $checkoutService;
    }

    public function index()
    {
        $cartItems = $this->cartService->getCartItems();
        $cartTotal = $this->cartService->getCartTotal();
        
        if (auth()->user()->isAdmin() || auth()->user()->isPenjual()) {
            return redirect()->route('home')
                ->with('error', 'Akun Anda tidak dapat melakukan checkout.');
        }

        if (empty($cartItems)) {
            return redirect()->route('catalog.index')
                ->with('warning', 'Keranjang belanja kosong.');
        }

        return view('checkout.index', compact('cartItems', 'cartTotal'));
    }

    public function process(CheckoutRequest $request)
    {
        try {
            if ($request->user()->isAdmin() || $request->user()->isPenjual()) {
                return redirect()->route('home')
                    ->with('error', 'Akun Anda tidak dapat melakukan checkout.');
            }
            $result = $this->checkoutService->processCheckout(
                $request->user(),
                $request->shipping_address,
                $request->file('payment_proof')
            );

            return redirect()->route('checkout.success', ['group_code' => $result['baseCode']])
                ->with('success', 'Pesanan berhasil dibuat!');
        } catch (\RuntimeException $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    public function success(string $groupCode)
    {
        $orders = \App\Models\Order::where('order_code', 'like', $groupCode . '%')
            ->where('buyer_id', auth()->id())
            ->with(['items.product.images', 'items.store'])
            ->get();

        if ($orders->isEmpty()) {
            abort(404);
        }
        
        $recommendedProducts = \App\Models\Product::with(['category', 'store'])
            ->active()
            ->inStock()
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('checkout.success', compact('orders', 'groupCode', 'recommendedProducts'));
    }
}
