<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class InventoryExport implements FromView
{
    public function view(): View
    {
        $inventoryData = DB::table('sanpham as sp')
            ->leftJoin('lohang as lh', 'sp.MaSanPham', '=', 'lh.ma_san_pham')
            ->select('sp.TenSanPham', DB::raw('SUM(lh.so_luong) as TongSoLuong'))
            ->groupBy('sp.MaSanPham', 'sp.TenSanPham')
            ->orderBy('TongSoLuong', 'desc')
            ->get();

        return view('admin.reports.exports.inventory_excel', compact('inventoryData'));
    }
}
