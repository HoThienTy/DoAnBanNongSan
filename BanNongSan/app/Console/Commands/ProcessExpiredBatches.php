<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LoHang;
use App\Models\Huy;
use Carbon\Carbon;

class ProcessExpiredBatches extends Command
{
    protected $signature = 'batches:process-expired';

    protected $description = 'Xử lý các lô hàng đã hết hạn';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Lấy các lô hàng đã hết hạn và còn số lượng > 0
        $expiredBatches = LoHang::where('han_su_dung', '<', Carbon::now()->toDateString())
            ->where('so_luong', '>', 0)
            ->get();

        foreach ($expiredBatches as $batch) {
            // Ghi nhận sản phẩm bị hủy
            Huy::create([
                'ma_lo_hang' => $batch->ma_lo_hang,
                'ma_san_pham' => $batch->ma_san_pham,
                'so_luong' => $batch->so_luong,
                'ngay_huy' => Carbon::now()->toDateString(),
                'ly_do' => 'Hết hạn sử dụng',
            ]);

            // Giảm số lượng trong lô hàng xuống 0
            $batch->so_luong = 0;
            $batch->save();

            $this->info("Đã xử lý lô hàng {$batch->ma_lo_hang} của sản phẩm {$batch->sanPham->TenSanPham}");
        }

        $this->info('Hoàn thành xử lý các lô hàng hết hạn.');
    }
}
