<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    protected $table = 'khachhang'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'MaKhachHang';
    public $timestamps = false;

    protected $fillable = [
        'TenKhachHang',
        'SoDienThoai',
        'DiaChi',
        'MaNguoiDung',
    ];

    // Quan hệ với model NguoiDung
    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'MaNguoiDung', 'MaNguoiDung');
    }

    // Quan hệ với model HoaDon
    public function hoaDon()
    {
        return $this->hasMany(HoaDon::class, 'ma_khach_hang', 'MaKhachHang');
    }
}
