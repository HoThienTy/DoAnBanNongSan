<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChuongTrinhKhuyenMai extends Model
{
    protected $table = 'chuong_trinh_khuyen_mai';
    protected $primaryKey = 'ma_khuyen_mai';
    public $timestamps = false;

    protected $fillable = [
        'ten_khuyen_mai',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'mo_ta',
    ];

    public function sanPhamKhuyenMai()
    {
        return $this->hasMany(KhuyenMaiSanPham::class, 'ma_khuyen_mai', 'ma_khuyen_mai');
    }
}
