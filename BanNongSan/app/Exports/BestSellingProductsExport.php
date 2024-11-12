<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BestSellingProductsExport implements FromView
{
    public function view(): View
    {
        $currentMonth = Carbon::now();

        // Dữ liệu sản phẩm bán chạy
        $bestSellingProducts = DB::table('chi_tiet_hoa_don as cthd')
            ->join('sanpham as sp', 'cthd.ma_san_pham', '=', 'sp.MaSanPham')
            ->join('hoa_don as hd', 'cthd.ma_hoa_don', '=', 'hd.ma_hoa_don')
            ->select('sp.TenSanPham', DB::raw('SUM(cthd.so_luong) as TongSoLuongBan'))
            ->whereMonth('hd.ngay_dat', '=', $currentMonth->month)
            ->whereYear('hd.ngay_dat', '=', $currentMonth->year)
            ->groupBy('sp.MaSanPham', 'sp.TenSanPham')
            ->orderBy('TongSoLuongBan', 'desc')
            ->limit(10)
            ->get();

        return view('admin.reports.exports.best_selling_products_excel', compact('bestSellingProducts', 'currentMonth'));
    }
}
