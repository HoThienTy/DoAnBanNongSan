<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhieuDatHang extends Model
{
    protected $table = 'phieudathang';
    protected $primaryKey = 'MaPhieuDatHang';
    public $timestamps = false;

    protected $fillable = [
        'MaNhaCungCap',
        'NgayDat',
        'SoLuongDaGiao',
        'SoLuong',
        'TongTien',
    ];

    public function nhaCungCap()
    {
        return $this->belongsTo(NhaCungCap::class, 'MaNhaCungCap', 'MaNhaCungCap');
    }

    public function chiTietPhieuDatHang()
    {
        return $this->hasMany(ChiTietPhieuDatHang::class, 'MaPhieuDatHang', 'MaPhieuDatHang');
    }
}
