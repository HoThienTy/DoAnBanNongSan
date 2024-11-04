<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    protected $table = 'chi_tiet_hoa_don'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'ma_chi_tiet'; // Khóa chính của bảng

    protected $fillable = [
        'ma_hoa_don',
        'ma_san_pham',
        'so_luong',
        'don_gia',
        'thanh_tien',
    ];

    public $timestamps = false; // Nếu bảng không có cột 'created_at' và 'updated_at'

    // Định nghĩa mối quan hệ với DonHang
    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'ma_hoa_don', 'ma_hoa_don');
    }

    // Định nghĩa mối quan hệ với SanPham
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'ma_san_pham', 'MaSanPham');
    }
}
