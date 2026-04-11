<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreAuthController;

// Home
Route::get('/', [ProductController::class, 'home'])->name('home');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Live search API
Route::get('/api/search', [ProductController::class, 'search'])->name('products.search');

// Frontend Auth
Route::get('/login',    [StoreAuthController::class, 'showLogin'])->name('store.login');
Route::post('/login',   [StoreAuthController::class, 'login'])->name('store.login.post');
Route::get('/register', [StoreAuthController::class, 'showRegister'])->name('store.register');
Route::post('/register',[StoreAuthController::class, 'register'])->name('store.register.post');
Route::post('/logout',  [StoreAuthController::class, 'logout'])->name('store.logout');
