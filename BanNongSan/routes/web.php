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
use App\Http\Middleware\CheckPermission;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\CancellationController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;

Route::get('/', [HomeController::class, 'index'])->name('welcome');


Route::get('/shop', [ShopController::class, 'index'])->name('user.shop.index');
Route::get('/productdetail/{MaSanPham}', [ProductDetailController::class, 'show'])->name('user.product-detail.show');
Route::get('/checkout', action: [CheckOutController::class, 'index'])->name('user.checkout.index');
Route::get('/shopping-cart', action: [ShoppingCartController::class, 'index'])->name('user.shopping-cart.index');
Route::get('/blog', action: [BlogController::class, 'index'])->name('user.blog.index');
Route::get('/blog-details', action: [BlogController::class, 'blogdetail'])->name('user.blog-details.index');


// Trang dashboard chính
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// Quản lý sản phẩm
Route::prefix('admin/products')->name('admin.products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index')->middleware(CheckPermission::class . ':Quản lý sản phẩm');
    Route::get('/create', [ProductController::class, 'create'])->name('create')->middleware(CheckPermission::class . ':Quản lý sản phẩm');
    Route::post('/store', [ProductController::class, 'store'])->name('store')->middleware(CheckPermission::class . ':Quản lý sản phẩm');
    Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit')->middleware(CheckPermission::class . ':Quản lý sản phẩm');
    Route::put('/{id}', [ProductController::class, 'update'])->name('update')->middleware(CheckPermission::class . ':Quản lý sản phẩm');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy')->middleware(CheckPermission::class . ':Quản lý sản phẩm');

    // Thêm route cho tìm kiếm sản phẩm bằng AJAX
    Route::get('/search', [ProductController::class, 'search'])->name('search')->middleware(CheckPermission::class . ':Quản lý sản phẩm');
});


// Quản lý danh mục
Route::prefix('admin/categories')->name('admin.categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index')->middleware(CheckPermission::class . ':Quản lý danh mục');
    Route::get('/create', [CategoryController::class, 'create'])->name('create')->middleware(CheckPermission::class . ':Quản lý danh mục');
    Route::post('/store', [CategoryController::class, 'store'])->name('store')->middleware(CheckPermission::class . ':Quản lý danh mục');
    Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit')->middleware(CheckPermission::class . ':Quản lý danh mục');
    Route::put('/{id}', [CategoryController::class, 'update'])->name('update')->middleware(CheckPermission::class . ':Quản lý danh mục');
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy')->middleware(CheckPermission::class . ':Quản lý danh mục');
});


// Quản lý kho hàng
// Quản lý kho hàng
Route::prefix('admin/warehouse')->name('admin.warehouse.')->middleware('auth')->group(function () {
    Route::get('/', [WarehouseController::class, 'index'])->name('index')->middleware(CheckPermission::class . ':Quản lý kho hàng');
    
    // Đặt route '/search' trước route '/{id}'
    Route::get('/search', [WarehouseController::class, 'search'])->name('search')->middleware(CheckPermission::class . ':Quản lý kho hàng');
    
    Route::get('/{id}', [WarehouseController::class, 'show'])->name('show')->middleware(CheckPermission::class . ':Quản lý kho hàng');
    Route::post('/{id}/adjust', [WarehouseController::class, 'adjustStock'])->name('adjust')->middleware(CheckPermission::class . ':Quản lý kho hàng');
    Route::post('/{id}/set-minimum', [WarehouseController::class, 'setMinimumLevel'])->name('set-minimum')->middleware(CheckPermission::class . ':Quản lý kho hàng');
});


Route::prefix('admin/batches')->name('admin.batch.')->middleware('auth')->group(function () {
    Route::get('/', [BatchController::class, 'index'])->name('index')->middleware(CheckPermission::class . ':Quản lý kho hàng');
    Route::get('/create', [BatchController::class, 'create'])->name('create')->middleware(CheckPermission::class . ':Quản lý kho hàng');
    Route::post('/store', [BatchController::class, 'store'])->name('store')->middleware(CheckPermission::class . ':Quản lý kho hàng');
    Route::get('/{id}', [BatchController::class, 'show'])->name('show')->middleware(CheckPermission::class . ':Quản lý kho hàng');
    Route::delete('/{id}', [BatchController::class, 'destroy'])->name('destroy')->middleware(CheckPermission::class . ':Quản lý kho hàng');
});

Route::prefix('admin/cancellations')->name('admin.cancellation.')->middleware('auth')->group(function () {
    Route::get('/', [CancellationController::class, 'index'])->name('index')->middleware(CheckPermission::class . ':Quản lý kho hàng');
    Route::get('/create', [CancellationController::class, 'create'])->name('create')->middleware(CheckPermission::class . ':Quản lý kho hàng');
    Route::post('/store', [CancellationController::class, 'store'])->name('store')->middleware(CheckPermission::class . ':Quản lý kho hàng');
    Route::delete('/{id}', [CancellationController::class, 'destroy'])->name('destroy')->middleware(CheckPermission::class . ':Quản lý kho hàng');
});

Route::prefix('admin/promotions')->name('admin.promotions.')->middleware('auth')->group(function () {
    Route::get('/', [PromotionController::class, 'index'])->name('index')->middleware(CheckPermission::class . ':Quản lý khuyến mãi');
    Route::get('/create', [PromotionController::class, 'create'])->name('create')->middleware(CheckPermission::class . ':Quản lý khuyến mãi');
    Route::post('/store', [PromotionController::class, 'store'])->name('store')->middleware(CheckPermission::class . ':Quản lý khuyến mãi');
    Route::get('/{id}/edit', [PromotionController::class, 'edit'])->name('edit')->middleware(CheckPermission::class . ':Quản lý khuyến mãi');
    Route::put('/{id}', [PromotionController::class, 'update'])->name('update')->middleware(CheckPermission::class . ':Quản lý khuyến mãi');
    Route::delete('/{id}', [PromotionController::class, 'destroy'])->name('destroy')->middleware(CheckPermission::class . ':Quản lý khuyến mãi');
});

// Quản lý đơn hàng
// Quản lý đơn hàng
Route::prefix('admin/orders')->name('admin.orders.')->middleware('auth')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index')->middleware(CheckPermission::class . ':Quản lý đơn hàng');
    Route::get('/{id}', [OrderController::class, 'show'])->name('show')->middleware(CheckPermission::class . ':Quản lý đơn hàng');
    Route::put('/{id}', [OrderController::class, 'update'])->name('update')->middleware(CheckPermission::class . ':Quản lý đơn hàng');
    Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy')->middleware(CheckPermission::class . ':Quản lý đơn hàng');
});

// Quản lý giao hàng
Route::prefix('admin/delivery')->name('admin.delivery.')->middleware('auth')->group(function () {
    Route::get('/', [DeliveryController::class, 'index'])->name('index')->middleware(CheckPermission::class . ':Quản lý giao hàng');
    Route::post('/{id}/assign', [DeliveryController::class, 'assignDeliveryPerson'])->name('assign')->middleware(CheckPermission::class . ':Quản lý giao hàng');
    Route::post('/{id}/update-status', [DeliveryController::class, 'updateStatus'])->name('update-status')->middleware(CheckPermission::class . ':Quản lý giao hàng');
});

Route::prefix('admin')->middleware(CheckPermission::class . ':Quản lý người dùng')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::prefix('users')->name('admin.users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index')->middleware(CheckPermission::class . ':Xem danh sách người dùng');
        Route::get('/create', [UserController::class, 'create'])->name('create')->middleware(CheckPermission::class . ':Quản lý người dùng');
        Route::post('/', [UserController::class, 'store'])->name('store')->middleware(CheckPermission::class . ':Quản lý người dùng');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit')->middleware(CheckPermission::class . ':Quản lý người dùng');
        Route::put('/{id}', [UserController::class, 'update'])->name('update')->middleware(CheckPermission::class . ':Quản lý người dùng');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy')->middleware(CheckPermission::class . ':Quản lý người dùng');
    });
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