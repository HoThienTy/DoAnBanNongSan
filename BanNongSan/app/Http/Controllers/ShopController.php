<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\DanhMucSanPham;
use App\Models\ChuongTrinhKhuyenMai;
use Carbon\Carbon;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = SanPham::with([
            'danhMuc',
            'khoHang',
            'loHang',
            'khuyenMais' => function ($q) {
                $q->whereDate('ngay_bat_dau', '<=', now())
                    ->whereDate('ngay_ket_thuc', '>=', now());
            }
        ]);

        $query->withSum('loHang', 'so_luong');

        // Search và filters giữ nguyên...

        $products = $query->paginate(12);
        $categories = DanhMucSanPham::all();

        $discountedProducts = SanPham::with(['khuyenMais', 'khoHang', 'loHang'])
            ->whereHas('khuyenMais', function ($q) {
                $q->whereDate('ngay_bat_dau', '<=', now())
                    ->whereDate('ngay_ket_thuc', '>=', now());
            })
            ->withSum('loHang', 'so_luong')
            ->take(10)
            ->get();

        $latestProducts = SanPham::with(['khuyenMais'])
            ->withSum('loHang', 'so_luong')
            ->orderBy('NgayTao', 'desc')
            ->take(6)
            ->get();

        $activePromotions = ChuongTrinhKhuyenMai::whereDate('ngay_bat_dau', '<=', now())
            ->whereDate('ngay_ket_thuc', '>=', now())
            ->get();

        return view('user.shop.index', compact('products', 'categories', 'discountedProducts', 'latestProducts', 'activePromotions'));
    }
}
