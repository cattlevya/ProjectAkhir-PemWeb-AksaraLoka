<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use Illuminate\Http\UploadedFile;

class CheckoutService
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Proses checkout dengan atomic transaction + pessimistic locking
     *
     * KRITIS: Seluruh proses dibungkus DB::transaction() dengan lockForUpdate()
     * untuk mencegah race condition pada stok produk
     */
    public function processCheckout(User $buyer, string $shippingAddress, ?UploadedFile $paymentProof = null): array
    {
        $cartItems = $this->cartService->getCartItems();

        if (empty($cartItems)) {
            throw new \RuntimeException('Keranjang belanja kosong.');
        }

        return DB::transaction(function () use ($cartItems, $buyer, $shippingAddress, $paymentProof) {
            $itemsByStore = [];
            
            // Generate base order_code: UMKM-YYYYMMDD-XXXXX
            $baseOrderCode = $this->generateOrderCode();

            // Handle Payment Proof Upload (if provided)
            $proofPath = null;
            if ($paymentProof) {
                // Simpan ke storage/app/public/payments/proofs
                $proofPath = $paymentProof->store('payments/proofs', 'public');
            }

            // 1. Re-validasi stok dengan pessimistic locking & grouping
            foreach ($cartItems as $productId => $item) {
                $product = Product::lockForUpdate()->find($productId);

                if (!$product) {
                    throw new \RuntimeException("Produk '{$item['name']}' tidak ditemukan.");
                }

                if (!$product->is_active) {
                    throw new \RuntimeException("Produk '{$product->name}' sudah tidak aktif.");
                }

                if ($product->stock < $item['qty']) {
                    throw new \RuntimeException(
                        "Stok produk '{$product->name}' tidak mencukupi. " .
                        "Tersedia: {$product->stock}, Diminta: {$item['qty']}"
                    );
                }

                // 2. Atomic stock decrement
                $product->decrement('stock', $item['qty']);

                $subtotal = $product->price * $item['qty'];

                if (!isset($itemsByStore[$product->store_id])) {
                    $itemsByStore[$product->store_id] = [
                        'totalAmount' => 0,
                        'items' => []
                    ];
                }

                $itemsByStore[$product->store_id]['totalAmount'] += $subtotal;
                $itemsByStore[$product->store_id]['items'][] = [
                    'product_id' => $product->id,
                    'store_id' => $product->store_id,
                    'qty' => $item['qty'],
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ];
            }

            $orders = [];
            $storeIndex = 1;

            // 3. Create orders per store
            foreach ($itemsByStore as $storeData) {
                $orderCode = count($itemsByStore) > 1 ? "{$baseOrderCode}-{$storeIndex}" : $baseOrderCode;
                
                $order = Order::create([
                    'order_code' => $orderCode,
                    'buyer_id' => $buyer->id,
                    'total_amount' => $storeData['totalAmount'],
                    'shipping_address' => $shippingAddress,
                    'payment_proof' => $proofPath,
                    'status' => Order::STATUS_MENUNGGU,
                ]);

                foreach ($storeData['items'] as $itemData) {
                    $order->items()->create($itemData);
                }
                
                $orders[] = $order;
                $storeIndex++;
            }

            // 4. Kosongkan keranjang
            $this->cartService->clearCart();

            return [
                'baseCode' => $baseOrderCode,
                'orders' => collect($orders)
            ];
        }, 3); // retry 3 kali jika deadlock
    }

    /**
     * Generate kode order unik: UMKM-YYYYMMDD-XXXXX
     */
    private function generateOrderCode(): string
    {
        $date = Carbon::now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -5));
        $code = "UMKM-{$date}-{$random}";

        // Pastikan unik
        while (Order::where('order_code', $code)->exists()) {
            $random = strtoupper(substr(uniqid(), -5));
            $code = "UMKM-{$date}-{$random}";
        }

        return $code;
    }
}
