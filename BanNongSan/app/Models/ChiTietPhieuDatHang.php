<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuDatHang extends Model
{
    protected $table = 'chitietphieudathang';
    protected $primaryKey = 'MaChiTietPhieuDatHang';
    public $timestamps = false;

    protected $fillable = [
        'MaPhieuDatHang',
        'MaSanPham',
        'SoLuong',
        'DonGiaNhap',
    ];

    public function phieuDatHang()
    {
        return $this->belongsTo(PhieuDatHang::class, 'MaPhieuDatHang', 'MaPhieuDatHang');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'MaSanPham', 'MaSanPham');
    }
}
