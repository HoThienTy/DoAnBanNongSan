<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PermissionController;
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
use App\Http\Controllers\CartController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ReportController;

Route::get('/', [HomeController::class, 'index'])->name('welcome');


Route::get('/shop', [ShopController::class, 'index'])->name('user.shop.index');
Route::get('/productdetail/{MaSanPham}', [ProductDetailController::class, 'show'])->name('user.product-detail.show');
Route::get('/checkout', action: [CheckOutController::class, 'index'])->name('user.checkout.index');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('user.checkout.success');
Route::get('/shopping-cart', action: [ShoppingCartController::class, 'index'])->name('user.shopping-cart.index');
Route::get('/blog', action: [BlogController::class, 'index'])->name('user.blog.index');
Route::get('/blog-details', action: [BlogController::class, 'blogdetail'])->name('user.blog-details.index');
// Hiển thị chi tiết sản phẩm
Route::get('/product/{MaSanPham}', [ProductController::class, 'show'])->name('user.product-detail.show');

// Thêm sản phẩm vào giỏ hàng
Route::post('/cart/add/{MaSanPham}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/update-totals', [CartController::class, 'updateTotals'])->name('cart.updateTotals');
// Hiển thị giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Cập nhật số lượng sản phẩm trong giỏ hàng
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

// Xóa sản phẩm khỏi giỏ hàng
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Trang thanh toán
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

// Xử lý đơn hàng khi thanh toán
Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');

// Trang dashboard chính
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware(CheckPermission::class . ':Quản trị viên');

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

Route::get('/admin/reports/inventory/export-excel', [ReportController::class, 'exportInventoryExcel'])->name('admin.reports.inventory.export_excel');
Route::get('/admin/reports/cancelled-products/export-excel', [ReportController::class, 'exportCancelledProductsExcel'])->name('admin.reports.cancelled_products.export_excel');
Route::get('/admin/reports/revenue/export-excel', [ReportController::class, 'exportRevenueExcel'])->name('admin.reports.revenue.export_excel');
Route::get('/admin/reports/best-selling-products/export-excel', [ReportController::class, 'exportBestSellingProductsExcel'])->name('admin.reports.best_selling_products.export_excel');

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
Route::prefix('admin/warehouse')->name('admin.warehouse.')->middleware('auth')->group(function () {
    Route::get('/', [WarehouseController::class, 'index'])->name('index')->middleware(CheckPermission::class . ':Quản lý kho hàng');

    // Đặt route '/search' trước route '/{id}'
    Route::get('/search', action: [WarehouseController::class, 'search'])->name('search')->middleware(CheckPermission::class . ':Quản lý kho hàng');

    Route::get('/{id}', [WarehouseController::class, 'show'])->name('show')->middleware(CheckPermission::class . ':Quản lý kho hàng');
    Route::post('/{id}/adjust', [WarehouseController::class, 'adjustStock'])->name('adjust')->middleware(CheckPermission::class . ':Quản lý kho hàng');
    Route::post('/{id}/set-minimum', [WarehouseController::class, 'setMinimumLevel'])->name('set-minimum')->middleware(CheckPermission::class . ':Quản lý kho hàng');
});

// Quản lý quyền
Route::prefix('admin/permissions')->name('permissions.')->middleware('auth')->group(function () {
    Route::get('/', [PermissionController::class, 'index'])->name('index')->middleware(CheckPermission::class . ':Quản lý quyền');

    // Đặt route '/search' trước route '/{id}'
    Route::get('/search', [PermissionController::class, 'search'])->name('search')->middleware(CheckPermission::class . ':Quản lý quyền');

    Route::get('/create', [PermissionController::class, 'create'])->name('create')->middleware(CheckPermission::class . ':Quản lý quyền');
    Route::post('/', [PermissionController::class, 'store'])->name('store')->middleware(CheckPermission::class . ':Quản lý quyền');

    Route::get('/{id}/edit', [PermissionController::class, 'edit'])->name('edit')->middleware(CheckPermission::class . ':Quản lý quyền');
    Route::put('/{id}', [PermissionController::class, 'update'])->name('update')->middleware(CheckPermission::class . ':Quản lý quyền');

    Route::delete('/{id}', [PermissionController::class, 'destroy'])->name('destroy')->middleware(CheckPermission::class . ':Quản lý quyền');

    // Routes mới cho phân quyền
    Route::get('/assign', [PermissionController::class, 'assignForm'])->name('assign.form')->middleware(CheckPermission::class . ':Quản lý quyền');
    Route::post('/assign', [PermissionController::class, 'assignPermissions'])->name('assign')->middleware(CheckPermission::class . ':Quản lý quyền');

    // Routes mới cho phân quyền người dùng
    Route::get('/assign-user', [PermissionController::class, 'assignUserForm'])->name('assign.user.form')->middleware(CheckPermission::class . ':Quản lý quyền');
    Route::post('/assign-user', [PermissionController::class, 'assignUserForm'])->name('assign.user'); // Form chọn người dùng
    Route::post('/assign-user/{user_id}', [PermissionController::class, 'assignUserPermissions'])->name('assign.user.permissions')->middleware(CheckPermission::class . ':Quản lý quyền');
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
    Route::get('/search', [CancellationController::class, 'search'])->name('search')->middleware(CheckPermission::class . ':Quản lý kho hàng');
    ;

});

Route::prefix('admin/promotions')->name('admin.promotions.')->middleware('auth')->group(function () {
    Route::get('/', [PromotionController::class, 'index'])->name('index')->middleware(CheckPermission::class . ':Quản lý khuyến mãi');
    Route::get('/create', [PromotionController::class, 'create'])->name('create')->middleware(CheckPermission::class . ':Quản lý khuyến mãi');
    Route::post('/store', [PromotionController::class, 'store'])->name('store')->middleware(CheckPermission::class . ':Quản lý khuyến mãi');

    // Routes mới cho mã khuyến mãi với CouponController
    Route::get('/createcoupon', [CouponController::class, 'createcoupon'])->name('createcoupon')->middleware(CheckPermission::class . ':Quản lý khuyến mãi');
    Route::post('/storecoupon', [CouponController::class, 'storecoupon'])->name('storecoupon')->middleware(CheckPermission::class . ':Quản lý khuyến mãi');

    // Danh sách các lô hàng
    Route::get('/addcoupon', [PromotionController::class, 'addCouponToBatchPage'])->name('addCouponToBatchPage')->middleware(CheckPermission::class . ':Quản lý khuyến mãi');
    // Thêm mã khuyến mãi vào lô hàng
    Route::post('/addcoupon', [PromotionController::class, 'addCouponToBatch'])->name('addCouponToBatch')->middleware(CheckPermission::class . ':Quản lý khuyến mãi');

    Route::get('/{id}/edit', [PromotionController::class, 'edit'])->name('edit')->middleware(CheckPermission::class . ':Quản lý khuyến mãi');
    Route::put('/{id}', [PromotionController::class, 'update'])->name('update')->middleware(CheckPermission::class . ':Quản lý khuyến mãi');
    Route::delete('/{id}', [PromotionController::class, 'destroy'])->name('destroy')->middleware(CheckPermission::class . ':Quản lý khuyến mãi');
    Route::post('/addCouponToBatch/{batchId}', [PromotionController::class, 'addCouponToBatch'])->name('addCouponToBatch')->middleware(CheckPermission::class . ':Quản lý khuyến mãi');

    Route::delete('/promotions/{batchId}/removeCoupon/{couponId}', [PromotionController::class, 'removeCouponFromBatch'])
    ->name('removeCouponFromBatch');

});
Route::delete('/admin/coupons/{id}', [CouponController::class, 'destroy'])->name('coupon.destroy');

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

// Quản lý nhà cung cấp
Route::prefix('admin/suppliers')->name('admin.suppliers.')->middleware('auth')->group(function () {
    Route::get('/', [SupplierController::class, 'index'])->name('index')->middleware(CheckPermission::class . ':Quản lý nhà cung cấp');
    Route::get('/create', [SupplierController::class, 'create'])->name('create')->middleware(CheckPermission::class . ':Quản lý nhà cung cấp');
    Route::post('/store', [SupplierController::class, 'store'])->name('store')->middleware(CheckPermission::class . ':Quản lý nhà cung cấp');
    Route::get('/{id}/edit', [SupplierController::class, 'edit'])->name('edit')->middleware(CheckPermission::class . ':Quản lý nhà cung cấp');
    Route::put('/{id}', [SupplierController::class, 'update'])->name('update')->middleware(CheckPermission::class . ':Quản lý nhà cung cấp');
    Route::delete('/{id}', [SupplierController::class, 'destroy'])->name('destroy')->middleware(CheckPermission::class . ':Quản lý nhà cung cấp');
    Route::get('/{id}', [SupplierController::class, 'show'])->name('show')->middleware(CheckPermission::class . ':Quản lý nhà cung cấp');

    // Chi tiết giao dịch
    Route::get('/{supplierId}/transaction/{transactionId}', [SupplierController::class, 'transactionDetail'])->name('transactionDetail')->middleware(CheckPermission::class . ':Quản lý nhà cung cấp');
});



// Quản lý đặt hàng từ nhà cung cấp
Route::prefix('admin/purchase-orders')->name('admin.purchase_orders.')->middleware('auth')->group(function () {
    Route::get('/', [PurchaseOrderController::class, 'index'])->name('index')->middleware(CheckPermission::class . ':Quản lý đặt hàng');
    Route::get('/create', [PurchaseOrderController::class, 'create'])->name('create')->middleware(CheckPermission::class . ':Quản lý đặt hàng');
    Route::post('/store', [PurchaseOrderController::class, 'store'])->name('store')->middleware(CheckPermission::class . ':Quản lý đặt hàng');
    Route::get('/{id}', [PurchaseOrderController::class, 'show'])->name('show')->middleware(CheckPermission::class . ':Quản lý đặt hàng');
    Route::get('/{id}/edit', [PurchaseOrderController::class, 'edit'])->name('edit')->middleware(CheckPermission::class . ':Quản lý đặt hàng');
    Route::put('/{id}', [PurchaseOrderController::class, 'update'])->name('update')->middleware(CheckPermission::class . ':Quản lý đặt hàng');
    Route::delete('/{id}', [PurchaseOrderController::class, 'destroy'])->name('destroy')->middleware(CheckPermission::class . ':Quản lý đặt hàng');
});

Route::prefix('admin/reports')->name('admin.reports.')->middleware('auth')->group(function () {
    Route::get('/cancelled-products', [ReportController::class, 'cancelledProductsReport'])->name('cancelled_products');
    Route::get('/revenue', [ReportController::class, 'revenueReport'])->name('revenue');
    Route::get('/inventory', [ReportController::class, 'inventoryReport'])->name('inventory');
    Route::get('/best-selling-products', [ReportController::class, 'bestSellingProductsReport'])->name('best_selling_products');
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


// Các route liên quan đến tài khoản người dùng
Route::prefix('account')->name('user.account.')->middleware('auth')->group(function () {
    Route::get('/orders', [UserController::class, 'orders'])->name('orders');
    Route::get('/track-order', [UserController::class, 'trackOrder'])->name('trackOrder');
    Route::get('/edit-profile', [UserController::class, 'editProfile'])->name('editProfile');
    Route::post('/edit-profile', [UserController::class, 'updateProfile'])->name('updateProfile');
    Route::get('/change-password', [UserController::class, 'changePassword'])->name('changePassword');
    Route::post('/change-password', [UserController::class, 'updatePassword'])->name('updatePassword');

    // Định nghĩa route cho chi tiết đơn hàng
    Route::get('/orders/{id}', [UserController::class, 'orderDetail'])->name('orderDetail');
});


Route::post('/coupon/apply', [CouponController::class, 'apply'])->name('coupon.apply');
Route::get('/coupon/remove', [CouponController::class, 'remove'])->name('coupon.remove');


// Route đăng xuất
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
