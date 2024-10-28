<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopGridController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\ShoppingCartController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/shopgrid', [ShopGridController::class, 'index'])->name('user.shop-grid.index');
Route::get('/productdetail', action: [ProductDetailController::class, 'index'])->name('user.product-detail.index');
Route::get('/checkout', action: [CheckOutController::class, 'index'])->name('user.checkout.index');
Route::get('/shopping-cart', action: [ShoppingCartController::class, 'index'])->name('user.shopping-cart.index');
Route::get('/login', action: [AuthController::class, 'login'])->name('auth.login.index');
Route::get('/register', action: [AuthController::class, 'register'])->name('auth.register.index');
Route::get('/blog', action: [BlogController::class, 'index'])->name('user.blog.index');
Route::get('/blog-details', action: [BlogController::class, 'blogdetail'])->name('user.blog-details.index');