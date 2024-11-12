<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RevenueExport implements FromView
{
    public function view(): View
    {
        $currentMonth = Carbon::now();

        // Dữ liệu doanh thu theo ngày
        $revenueData = DB::table('hoa_don')
            ->select(DB::raw('DATE(ngay_dat) as Ngay'), DB::raw('SUM(tong_tien) as TongTien'))
            ->whereMonth('ngay_dat', '=', $currentMonth->month)
            ->whereYear('ngay_dat', '=', $currentMonth->year)
            ->groupBy('Ngay')
            ->orderBy('Ngay')
            ->get();

        return view('admin.reports.exports.revenue_excel', compact('revenueData', 'currentMonth'));
    }
}
