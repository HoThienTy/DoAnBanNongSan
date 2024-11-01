<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopGridController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/shopgrid', [ShopGridController::class, 'index'])->name('user.shop-grid.index');
Route::get('/productdetail', action: [ProductDetailController::class, 'index'])->name('user.product-detail.index');
Route::get('/checkout', action: [CheckOutController::class, 'index'])->name('user.checkout.index');
Route::get('/shopping-cart', action: [ShoppingCartController::class, 'index'])->name('user.shopping-cart.index');
Route::get('/blog', action: [BlogController::class, 'index'])->name('user.blog.index');
Route::get('/blog-details', action: [BlogController::class, 'blogdetail'])->name('user.blog-details.index');


// Trang dashboard chính
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Quản lý sản phẩm
Route::prefix('admin/products')->name('admin.products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/store', [ProductController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
});

// Quản lý danh mục
Route::prefix('admin/categories')->name('admin.categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::post('/store', [CategoryController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
});

// Quản lý đơn hàng
Route::prefix('admin/orders')->name('admin.orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/{id}', [OrderController::class, 'show'])->name('show');
    Route::put('/{id}', [OrderController::class, 'update'])->name('update');
    Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy');
});

// Quản lý người dùng
Route::prefix('admin/users')->name('admin.users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
});

// Trang cài đặt
Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');

// Đăng ký
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('auth.register.index');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register.store');

// Đăng nhập
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login.index');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login.store');

// Quên mật khẩu
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Đặt lại mật khẩu
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


// Đăng xuất
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');