<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    protected $table = 'hoa_don'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'ma_hoa_don'; // Khóa chính của bảng

    protected $fillable = [
        'ma_khach_hang',
        'ma_nhan_vien',
        'ngay_dat',
        'tong_tien',
        'trang_thai',
    ];

    public $timestamps = false; // Nếu bảng không có cột 'created_at' và 'updated_at'

    // Định nghĩa mối quan hệ với ChiTietDonHang
    public function chiTietDonHang()
    {
        return $this->hasMany(ChiTietDonHang::class, 'ma_hoa_don', 'ma_hoa_don');
    }
}
