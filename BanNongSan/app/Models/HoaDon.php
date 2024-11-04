<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    protected $table = 'hoa_don';
    protected $primaryKey = 'ma_hoa_don';
    public $timestamps = false;

    protected $fillable = [
        'ma_khach_hang',
        'ma_nhan_vien',
        'ngay_dat',
        'tong_tien',
        'trang_thai',
    ];

    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'ma_khach_hang', 'MaKhachHang');
    }

    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'ma_nhan_vien', 'MaNhanVien');
    }

    public function chiTietHoaDon()
    {
        return $this->hasMany(ChiTietHoaDon::class, 'ma_hoa_don', 'ma_hoa_don');
    }

    public function thanhToan()
    {
        return $this->hasOne(ThanhToan::class, 'ma_hoa_don', 'ma_hoa_don');
    }
}
