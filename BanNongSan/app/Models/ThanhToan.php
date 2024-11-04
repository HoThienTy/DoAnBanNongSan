<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThanhToan extends Model
{
    protected $table = 'thanh_toan';
    protected $primaryKey = 'ma_thanh_toan';
    public $timestamps = false;

    protected $fillable = [
        'ma_hoa_don',
        'ma_phuong_thuc',
        'ngay_thanh_toan',
        'so_tien',
    ];

    public function hoaDon()
    {
        return $this->belongsTo(HoaDon::class, 'ma_hoa_don', 'ma_hoa_don');
    }

    public function phuongThucThanhToan()
    {
        return $this->belongsTo(PhuongThucThanhToan::class, 'ma_phuong_thuc', 'ma_phuong_thuc');
    }
}
