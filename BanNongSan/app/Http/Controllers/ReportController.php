<?php

namespace App\Http\Controllers;

use App\Exports\BestSellingProductsExport;
use App\Exports\CancelledProductsExport;
use App\Exports\InventoryExport;
use App\Exports\RevenueExport;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    // Báo cáo hàng hủy theo sản phẩm và lý do
    public function cancelledProductsReport()
    {
        // Tháng trước
        $previousMonth = Carbon::now()->subMonth();

        // Tổng số lượng sản phẩm bị hủy
        $cancelledProducts = DB::table('huy as h')
            ->join('lohang as lh', 'h.ma_lo_hang', '=', 'lh.ma_lo_hang')
            ->join('sanpham as sp', 'h.ma_san_pham', '=', 'sp.MaSanPham')
            ->select('sp.TenSanPham', DB::raw('SUM(h.so_luong) as TongSoLuongHuy'))
            ->whereMonth('h.ngay_huy', '=', $previousMonth->month)
            ->whereYear('h.ngay_huy', '=', $previousMonth->year)
            ->groupBy('sp.MaSanPham', 'sp.TenSanPham')
            ->orderBy('TongSoLuongHuy', 'desc')
            ->get();

        // Tính tổng số lượng nhập vào để tính tỷ lệ phần trăm
        $totalQuantity = DB::table('lohang')->sum('so_luong'); // Tổng số lượng sản phẩm nhập

        // Tính phần trăm số lượng hủy so với tổng số lượng
        foreach ($cancelledProducts as $product) {
            $product->PercentageCancelled = ($product->TongSoLuongHuy / $totalQuantity) * 100;
        }

        // Truy vấn lý do hủy sản phẩm từ cột 'ly_do' trong bảng 'huy'
        $cancelledReasons = DB::table('huy as h')
            ->select('h.ly_do', DB::raw('SUM(h.so_luong) as TongSoLuongHuy'))
            ->whereMonth('h.ngay_huy', '=', $previousMonth->month)
            ->whereYear('h.ngay_huy', '=', $previousMonth->year)
            ->groupBy('h.ly_do')
            ->orderBy('TongSoLuongHuy', 'desc')
            ->get();

        return view('admin.reports.cancelled_products', compact('cancelledProducts', 'previousMonth', 'cancelledReasons'));
    }



    // Báo cáo doanh thu
    public function revenueReport()
    {
        // Tháng này
        $currentMonth = Carbon::now();

        // Dữ liệu doanh thu theo ngày
        $revenueData = DB::table('hoa_don')
            ->select(DB::raw('DATE(ngay_dat) as Ngay'), DB::raw('SUM(tong_tien) as TongTien'))
            ->whereMonth('ngay_dat', '=', $currentMonth->month)
            ->whereYear('ngay_dat', '=', $currentMonth->year)
            ->groupBy('Ngay')
            ->orderBy('Ngay')
            ->get();

        return view('admin.reports.revenue', compact('revenueData', 'currentMonth'));
    }


    // Báo cáo tồn kho
    public function inventoryReport(Request $request)
    {
        $search = $request->input('search'); // Lấy từ khóa tìm kiếm từ request

        $inventoryData = DB::table('sanpham as sp')
            ->leftJoin('lohang as lh', 'sp.MaSanPham', '=', 'lh.ma_san_pham')
            ->select('sp.TenSanPham', DB::raw('SUM(lh.so_luong) as TongSoLuong'))
            ->when($search, function ($query, $search) {
                return $query->where('sp.TenSanPham', 'like', '%' . $search . '%');
            })
            ->groupBy('sp.MaSanPham', 'sp.TenSanPham')
            ->orderBy('TongSoLuong', 'desc')
            ->limit(20)
            ->get();

        return view('admin.reports.inventory', compact('inventoryData'));
    }


    // Báo cáo sản phẩm bán chạy
    public function bestSellingProductsReport()
    {
        // Tháng này
        $currentMonth = Carbon::now();

        // Dữ liệu sản phẩm bán chạy và doanh thu
        $bestSellingProducts = DB::table('chi_tiet_hoa_don as cthd')
            ->join('sanpham as sp', 'cthd.ma_san_pham', '=', 'sp.MaSanPham')
            ->join('hoa_don as hd', 'cthd.ma_hoa_don', '=', 'hd.ma_hoa_don')
            ->select('sp.TenSanPham', DB::raw('SUM(cthd.so_luong) as TongSoLuongBan'), DB::raw('SUM(cthd.so_luong * cthd.don_gia) as DoanhThu'))
            ->whereMonth('hd.ngay_dat', '=', $currentMonth->month)
            ->whereYear('hd.ngay_dat', '=', $currentMonth->year)
            ->groupBy('sp.MaSanPham', 'sp.TenSanPham')
            ->orderBy('TongSoLuongBan', 'desc')
            ->get();

        // Tính tổng số lượng bán và tổng doanh thu
        $totalQuantity = $bestSellingProducts->sum('TongSoLuongBan');
        $totalRevenue = $bestSellingProducts->sum('DoanhThu');

        // Tính tỷ lệ phần trăm giữa số lượng bán và doanh thu
        foreach ($bestSellingProducts as $product) {
            // Tính phần trăm theo số lượng bán
            $product->PercentageByQuantity = ($product->TongSoLuongBan / $totalQuantity) * 100;

            // Tính phần trăm theo doanh thu
            $product->PercentageByRevenue = ($product->DoanhThu / $totalRevenue) * 100;
        }

        return view('admin.reports.best_selling_products', compact('bestSellingProducts', 'currentMonth'));
    }

    public function exportInventoryExcel()
    {
        return Excel::download(new InventoryExport, 'bao_cao_ton_kho.xlsx');
    }

    public function exportCancelledProductsExcel()
    {
        return Excel::download(new CancelledProductsExport, 'bao_cao_hang_huy.xlsx');
    }
    public function exportRevenueExcel()
    {
        return Excel::download(new RevenueExport, 'bao_cao_doanh_thu.xlsx');
    }

    public function exportBestSellingProductsExcel()
    {
        return Excel::download(new BestSellingProductsExport, 'bao_cao_san_pham_ban_chay.xlsx');
    }
}
