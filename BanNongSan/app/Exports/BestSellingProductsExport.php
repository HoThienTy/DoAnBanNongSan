<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BestSellingProductsExport implements FromView
{
    public function __construct($month = null, $year = null)
    {
        $this->month = $month ?? now()->month;
        $this->year = $year ?? now()->year;
    }

    public function view(): View
    {
        $selectedDate = Carbon::createFromDate($this->year, $this->month, 1);

        $bestSellingProducts = DB::table('chi_tiet_hoa_don as cthd')
            ->join('sanpham as sp', 'cthd.ma_san_pham', '=', 'sp.MaSanPham')
            ->join('hoa_don as hd', 'cthd.ma_hoa_don', '=', 'hd.ma_hoa_don')
            ->select(
                'sp.TenSanPham',
                DB::raw('SUM(cthd.so_luong) as TongSoLuongBan'),
                DB::raw('SUM(cthd.so_luong * cthd.don_gia) as DoanhThu'),
                DB::raw('COUNT(DISTINCT hd.ma_hoa_don) as SoDonHang')
            )
            ->whereMonth('hd.ngay_dat', $this->month)
            ->whereYear('hd.ngay_dat', $this->year)
            ->where('hd.trang_thai', 'Đã giao')
            ->groupBy('sp.TenSanPham')
            ->orderBy('TongSoLuongBan', 'desc')
            ->limit(10)
            ->get();

        return view('admin.reports.exports.best_selling_products_excel', compact(
            'bestSellingProducts',
            'selectedDate'
        ));
    }
}
