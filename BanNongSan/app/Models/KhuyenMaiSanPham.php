<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhuyenMaiSanPham extends Model
{
    protected $table = 'khuyen_mai_san_pham';
    public $timestamps = false;
    protected $primaryKey = ['ma_khuyen_mai', 'ma_san_pham'];
    public $incrementing = false;

    protected $fillable = [
        'ma_khuyen_mai',
        'ma_san_pham',
        'giam_gia',
    ];

    public function chuongTrinhKhuyenMai()
    {
        return $this->belongsTo(ChuongTrinhKhuyenMai::class, 'ma_khuyen_mai', 'ma_khuyen_mai');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'ma_san_pham', 'MaSanPham');
    }
}
