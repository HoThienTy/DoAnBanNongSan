<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KhoHang extends Model
{
    protected $table = 'khohang';
    protected $primaryKey = 'MaKhoHang';
    public $timestamps = true;

    protected $fillable = [
        'MaSanPham',
        'SoLuongTon',
        'MucToiThieu',
        'NgayHetHan',
    ];

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'MaSanPham', 'MaSanPham');
    }

    public function capNhatSoLuongTon()
    {
        $tongSoLuong = $this->sanPham->loHang()->sum('so_luong');
        $this->SoLuongTon = $tongSoLuong;
        $this->save();
    }

}
