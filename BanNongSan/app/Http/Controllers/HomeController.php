<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\DanhMucSanPham;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy danh sách sản phẩm
        $featuredProducts = SanPham::take(8)->get();
        $latestProducts = SanPham::orderBy('created_at', 'desc')->take(9)->get();

        // Lấy danh sách danh mục
        $categories = DanhMucSanPham::all();

        // Truyền dữ liệu tới view
        return view('welcome', compact('featuredProducts', 'latestProducts', 'categories'));
    }
}
