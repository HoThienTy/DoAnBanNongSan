<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RevenueExport implements FromView
{
    protected $month;
    protected $year;

    public function __construct($month = null, $year = null)
    {
        $this->month = $month ?? now()->month;
        $this->year = $year ?? now()->year;
    }

    public function view(): View
    {
        $selectedDate = Carbon::createFromDate($this->year, $this->month, 1);
        
        $revenueData = DB::table('hoa_don')
            ->select(
                DB::raw('DATE(ngay_dat) as Ngay'),
                DB::raw('SUM(tong_tien) as TongTien'),
                DB::raw('COUNT(*) as SoDonHang')
            )
            ->whereMonth('ngay_dat', '=', $this->month)
            ->whereYear('ngay_dat', '=', $this->year)
            ->where('trang_thai', 'Đã giao')
            ->groupBy('Ngay')
            ->orderBy('Ngay')
            ->get();

        return view('admin.reports.exports.revenue_excel', compact('revenueData', 'selectedDate'));
    }
}