<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerRegistrationController;
use App\Http\Controllers\Seller;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/produk/{slug}', [ProductDetailController::class, 'show'])->name('product.show');

/*
|--------------------------------------------------------------------------
| Cart Routes (Guest + Auth)
|--------------------------------------------------------------------------
*/

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::patch('/update', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{productId}', [CartController::class, 'remove'])->name('remove');
});

use App\Http\Controllers\WishlistController;

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Pembeli)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{wishlist}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // Profile (Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{group_code}', [CheckoutController::class, 'success'])->name('checkout.success');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/payment', [OrderController::class, 'uploadPayment'])->name('orders.upload-payment');

    // Seller Registration (upgrade pembeli → penjual)
    Route::get('/become-seller', [SellerRegistrationController::class, 'create'])->name('seller.register');
    Route::post('/become-seller', [SellerRegistrationController::class, 'store'])->name('seller.register.store');
});

/*
|--------------------------------------------------------------------------
| Seller Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::prefix('seller')->name('seller.')->middleware(['auth', 'role:penjual'])->group(function () {
    Route::get('/dashboard', [Seller\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', Seller\ProductController::class);
    Route::get('/orders', [Seller\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [Seller\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [Seller\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('/reports', [Seller\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/pdf', [Seller\ReportController::class, 'exportPdf'])->name('reports.export-pdf');
    Route::patch('/store', [Seller\ProfileController::class, 'updateStore'])->name('store.update');
});

/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/export-pdf', [Admin\DashboardController::class, 'exportPdf'])->name('dashboard.export-pdf');
    Route::resource('categories', Admin\CategoryController::class);
    Route::get('/orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    if ($user->isPenjual()) {
        return redirect()->route('seller.dashboard');
    }
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
