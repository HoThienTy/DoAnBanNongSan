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
        // Lấy danh sách danh mục để hiển thị trong sidebar
        $categories = DanhMucSanPham::all();

        // Khởi tạo query builder cho sản phẩm
        $query = SanPham::query();

        // Tìm kiếm theo tên sản phẩm
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('TenSanPham', 'like', '%' . $search . '%');
        }

        // Lọc theo danh mục
        if ($request->has('category')) {
            $category = $request->input('category');
            $query->where('MaDanhMuc', $category);
        }

        // Lọc theo khoảng giá
        if ($request->has('price_min') && $request->has('price_max')) {
            $priceMin = $request->input('price_min');
            $priceMax = $request->input('price_max');
            $query->whereBetween('GiaBan', [$priceMin, $priceMax]);
        }

        // Sắp xếp sản phẩm
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            switch ($sort) {
                case 'name_asc':
                    $query->orderBy('TenSanPham', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('TenSanPham', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('GiaBan', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('GiaBan', 'desc');
                    break;
                default:
                    $query->orderBy('MaSanPham', 'desc');
                    break;
            }
        } else {
            $query->orderBy('MaSanPham', 'desc');
        }

        // Phân trang, mỗi trang 12 sản phẩm
        $products = $query->paginate(12);

        // Lấy các sản phẩm có khuyến mãi hiện tại
        $currentDate = Carbon::now()->toDateString();

        $latestProducts = SanPham::orderBy('NgayTao', 'desc')->take(6)->get();


        $discountedProducts = SanPham::whereHas('khuyenMais', function ($q) use ($currentDate) {
            $q->where('ngay_bat_dau', '<=', $currentDate)
              ->where('ngay_ket_thuc', '>=', $currentDate);
        })->with(['khuyenMais' => function ($q) use ($currentDate) {
            $q->where('ngay_bat_dau', '<=', $currentDate)
              ->where('ngay_ket_thuc', '>=', $currentDate);
        }])->take(10)->get();

        // Trả về view với dữ liệu
        return view('user.shop.index', compact('products', 'categories', 'discountedProducts', 'latestProducts'));
    }
}
