<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use App\Models\DanhMucSanPham;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Chia sẻ dữ liệu giỏ hàng cho mọi view
        View::composer('*', function ($view) {
            $cart = session()->get('cart', []);
            $cartCount = count($cart);
            $cartTotal = 0;

            foreach ($cart as $item) {
                $cartTotal += $item['price'] * $item['quantity'];
            }

            // Kiểm tra nếu có mã khuyến mãi trong session
            if ($coupon = session('coupon')) {
                $discount = $coupon->giam_gia; // % giảm giá từ mã khuyến mãi
                $cartTotal *= (100 - $discount) / 100;
            }

            $view->with('cartCount', $cartCount)->with('cartTotal', $cartTotal);

            // Chia sẻ danh mục sản phẩm
            $categories = DanhMucSanPham::all();
            $view->with('categories', $categories);
        });
    }
}
