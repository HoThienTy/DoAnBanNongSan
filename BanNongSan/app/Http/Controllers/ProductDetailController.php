<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SanPham;

class ProductDetailController extends Controller
{
    public function show($MaSanPham)
    {
        // Lấy thông tin sản phẩm
        $product = SanPham::with([
            'khuyenMais' => function ($q) {
                $currentDate = Carbon::now()->toDateString();
                $q->where('ngay_bat_dau', '<=', $currentDate)
                    ->where('ngay_ket_thuc', '>=', $currentDate);
            }
        ])->findOrFail($MaSanPham);

        // Lấy các sản phẩm liên quan
        $relatedProducts = SanPham::where('MaDanhMuc', $product->MaDanhMuc)
            ->where('MaSanPham', '!=', $product->MaSanPham)
            ->take(4)
            ->get();

        return view('user.product-detail.index', compact('product', 'relatedProducts'));
    }

}
