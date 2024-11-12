<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CancelledProductsExport implements FromView
{
    public function view(): View
    {
        $previousMonth = Carbon::now()->subMonth();

        // Tổng số lượng sản phẩm bị hủy theo từng sản phẩm
        $cancelledProducts = DB::table('huy as h')
            ->join('lohang as lh', 'h.ma_lo_hang', '=', 'lh.ma_lo_hang')
            ->join('sanpham as sp', 'h.ma_san_pham', '=', 'sp.MaSanPham')
            ->select('sp.TenSanPham', DB::raw('SUM(h.so_luong) as TongSoLuongHuy'))
            ->whereMonth('h.ngay_huy', '=', $previousMonth->month)
            ->whereYear('h.ngay_huy', '=', $previousMonth->year)
            ->groupBy('sp.MaSanPham', 'sp.TenSanPham')
            ->orderBy('TongSoLuongHuy', 'desc')
            ->get();

        // Thống kê số lượng hàng bị hủy theo từng lý do
        $cancelledReasons = DB::table('huy as h')
            ->select('h.ly_do', DB::raw('SUM(h.so_luong) as TongSoLuongHuy'))
            ->whereMonth('h.ngay_huy', '=', $previousMonth->month)
            ->whereYear('h.ngay_huy', '=', $previousMonth->year)
            ->groupBy('h.ly_do')
            ->get();

        return view('admin.reports.exports.cancelled_products_excel', compact('cancelledProducts', 'cancelledReasons', 'previousMonth'));
    }
}
