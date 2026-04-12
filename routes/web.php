<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreAuthController;
use App\Http\Controllers\ApiController;

// Home
Route::get('/', [ProductController::class, 'home'])->name('home');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Coupons
Route::get('/coupons', [ProductController::class, 'coupons'])->name('coupons');

// Renewed Deals
Route::get('/renewed-deals', [ProductController::class, 'renewedDeals'])->name('renewed-deals');

// Outlet
Route::get('/outlet', [ProductController::class, 'outlet'])->name('outlet');

// MyShop Resale
Route::get('/myshop-resale', [ProductController::class, 'myshopResale'])->name('myshop-resale');

// Local Deals
Route::get('/local-deals', [ProductController::class, 'localDeals'])->name('local-deals');

// Electronics
Route::get('/electronics', [ProductController::class, 'electronics'])->name('electronics');

// Home & Garden
Route::get('/home-garden', [ProductController::class, 'homeGarden'])->name('home-garden');

// Fashion
Route::get('/fashion', [ProductController::class, 'fashion'])->name('fashion');

// Sports
Route::get('/sports', [ProductController::class, 'sports'])->name('sports');

// Best Price
Route::get('/best-price', [ProductController::class, 'bestPrice'])->name('best-price');

// A-Z Listings
Route::get('/a-z-listings', [ProductController::class, 'azListings'])->name('a-z-listings');

// Beauty
Route::get('/beauty', [ProductController::class, 'beauty'])->name('beauty');

// New Releases
Route::get('/new-releases', [ProductController::class, 'newReleases'])->name('new-releases');

// Cart
Route::get('/cart', [ProductController::class, 'cart'])->name('cart.index');
Route::post('/cart/add/{id}', [ProductController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/remove/{id}', [ProductController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update/{id}', [ProductController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/clear', [ProductController::class, 'clearCart'])->name('cart.clear');

// Checkout & Payment
Route::get('/checkout', [ProductController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [ProductController::class, 'processCheckout'])->name('checkout.process');
Route::get('/payment', [ProductController::class, 'payment'])->name('payment');
Route::post('/payment/stripe', [ProductController::class, 'stripePayment'])->name('payment.stripe');
Route::get('/order/success/{order}', [ProductController::class, 'orderSuccess'])->name('order.success');
Route::get('/orders', [ProductController::class, 'orders'])->name('orders.index');
Route::get('/account', [ProductController::class, 'account'])->name('account')->middleware('auth');

// Live search API
Route::get('/api/search', [ProductController::class, 'search'])->name('products.search');

// Frontend Auth
Route::get('/login',    [StoreAuthController::class, 'showLogin'])->name('store.login');
Route::post('/login',   [StoreAuthController::class, 'login'])->name('store.login.post');
Route::get('/register', [StoreAuthController::class, 'showRegister'])->name('store.register');
Route::post('/register',[StoreAuthController::class, 'register'])->name('store.register.post');
Route::post('/logout',  [StoreAuthController::class, 'logout'])->name('store.logout');

// API Routes with API Key Middleware
Route::middleware('api.key')->group(function () {
    Route::get('/api/products', [ApiController::class, 'products'])->name('api.products');
    Route::get('/api/products/{id}', [ApiController::class, 'product'])->name('api.product');
});

// Test route to check if middleware is working
Route::get('/test-middleware', function () {
    return 'Middleware is working!';
})->middleware('api.key');
