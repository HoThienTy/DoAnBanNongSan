<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LichSuKhoHang extends Model
{
    protected $table = 'lichsukhohang';
    protected $primaryKey = 'MaLichSu';
    public $timestamps = false;

    protected $fillable = [
        'MaSanPham',
        'LoaiGiaoDich',
        'SoLuong',
        'NgayGiaoDich',
        'GhiChu',
    ];

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'MaSanPham', 'MaSanPham');
    }
}
