<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table = 'sanpham';
    protected $primaryKey = 'MaSanPham';
    public $timestamps = false;

    protected $fillable = [
        'TenSanPham',
        'LoaiSanPham',
        'DonViTinh',
        'MoTa',
        'HinhAnh',
        'GiaBan',
        'NgayTao',
        'MaDanhMuc',
    ];

    public function danhMuc()
    {
        return $this->belongsTo(DanhMucSanPham::class, 'MaDanhMuc', 'MaDanhMuc');
    }

    public function khoHang()
    {
        return $this->hasOne(KhoHang::class, 'MaSanPham', 'MaSanPham');
    }

    public function lichSuKhoHang()
    {
        return $this->hasMany(LichSuKhoHang::class, 'MaSanPham', 'MaSanPham');
    }

    public function loHang()
    {
        return $this->hasMany(LoHang::class, 'ma_san_pham', 'MaSanPham');
    }

    public function huy()
    {
        return $this->hasMany(Huy::class, 'ma_san_pham', 'MaSanPham');
    }

    public function tongSoLuongTon()
    {
        return $this->loHang()->sum('so_luong');
    }

    public function khuyenMaiSanPham()
    {
        return $this->hasMany(KhuyenMaiSanPham::class, 'ma_san_pham', 'MaSanPham');
    }

}
