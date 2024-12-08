<?php

namespace App\Http\Controllers;

use App\Models\ChuongTrinhKhuyenMai;
use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\DanhMucSanPham;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = SanPham::with([
            'danhMuc',
            'khoHang',
            'loHang',
            'khuyenMais' => function ($q) {
                $q->whereDate('ngay_bat_dau', '<=', now())
                    ->whereDate('ngay_ket_thuc', '>=', now());
            }
        ])
            ->withSum('loHang', 'so_luong')
            ->take(8)
            ->get();

        $latestProducts = SanPham::with([
            'khoHang',
            'loHang',
            'khuyenMais' => function ($q) {
                $q->whereDate('ngay_bat_dau', '<=', now())
                    ->whereDate('ngay_ket_thuc', '>=', now());
            }
        ])
            ->withSum('loHang', 'so_luong')
            ->orderBy('created_at', 'desc')
            ->take(9)
            ->get();

        $categories = DanhMucSanPham::all();

        $activePromotions = ChuongTrinhKhuyenMai::whereDate('ngay_bat_dau', '<=', now())
            ->whereDate('ngay_ket_thuc', '>=', now())
            ->get();

        return view('welcome', compact('featuredProducts', 'latestProducts', 'categories', 'activePromotions'));
    }
}
