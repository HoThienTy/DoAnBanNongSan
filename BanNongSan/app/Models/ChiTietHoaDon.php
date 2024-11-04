<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietHoaDon extends Model
{
    protected $table = 'chi_tiet_hoa_don';
    protected $primaryKey = 'ma_chi_tiet';
    public $timestamps = false;

    protected $fillable = [
        'ma_hoa_don',
        'ma_san_pham',
        'so_luong',
        'don_gia',
        'thanh_tien',
    ];

    public function hoaDon()
    {
        return $this->belongsTo(HoaDon::class, 'ma_hoa_don', 'ma_hoa_don');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'ma_san_pham', 'MaSanPham');
    }
}
