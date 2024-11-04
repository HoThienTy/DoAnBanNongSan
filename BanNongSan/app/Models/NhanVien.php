<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    protected $table = 'nhanvien';
    protected $primaryKey = 'MaNhanVien';
    public $timestamps = false;

    protected $fillable = [
        'MaNguoiDung',
        // Các cột khác nếu cần
    ];

    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'MaNguoiDung', 'MaNguoiDung');
    }

    public function hoaDon()
    {
        return $this->hasMany(HoaDon::class, 'ma_nhan_vien', 'MaNhanVien');
    }
}
