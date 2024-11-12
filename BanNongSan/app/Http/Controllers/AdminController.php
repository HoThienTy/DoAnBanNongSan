<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Nếu bạn có mô hình User
use App\Models\SanPham;
use App\Models\HoaDon;
use App\Models\ChiTietHoaDon;
use App\Models\KhoHang;
use App\Models\NguoiDung;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Lấy tổng số khách hàng
        $totalCustomers = NguoiDung::where('MaVaiTro', '1')->count();

        // Lấy tổng số sản phẩm
        $totalProducts = SanPham::count();

        // Tính tổng doanh thu
        $totalRevenue = HoaDon::where('trang_thai', 'Đã giao')->sum('tong_tien');

        // Lấy số đơn hàng mới hôm nay
        $newOrders = HoaDon::whereDate('ngay_dat', Carbon::today())->count();

        // Lấy danh sách sản phẩm bán chạy (Top 5)
        $bestSellingProducts = ChiTietHoaDon::join('sanpham as sp', 'chi_tiet_hoa_don.ma_san_pham', '=', 'sp.MaSanPham')
            ->select('sp.TenSanPham', DB::raw('SUM(chi_tiet_hoa_don.so_luong) as TongSoLuongBan'))
            ->groupBy('sp.MaSanPham', 'sp.TenSanPham')
            ->orderBy('TongSoLuongBan', 'desc')
            ->limit(5)
            ->get();

        // Lấy danh sách sản phẩm sắp hết hàng (số lượng tồn kho dưới 10)
        $lowStockProducts = KhoHang::where('SoLuongTon', '<', 10)->get();

        // Lấy dữ liệu doanh thu theo tháng trong năm hiện tại
        $monthlyRevenue = HoaDon::select(
                DB::raw('MONTH(ngay_dat) as month'),
                DB::raw('SUM(tong_tien) as total')
            )
            ->whereYear('ngay_dat', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Lấy danh sách đơn hàng mới nhất
        $recentOrders = HoaDon::orderBy('ngay_dat', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalProducts',
            'totalRevenue',
            'newOrders',
            'bestSellingProducts',
            'lowStockProducts',
            'monthlyRevenue',
            'recentOrders'
        ));
    }

    public function settings()
    {
        return view('admin.settings.index');
    }
}
