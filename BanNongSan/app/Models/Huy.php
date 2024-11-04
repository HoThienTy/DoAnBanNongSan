<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Huy extends Model
{
    protected $table = 'huy';
    protected $primaryKey = 'ma_huy';
    public $timestamps = false;

    protected $fillable = [
        'ma_lo_hang',
        'ma_san_pham',
        'so_luong',
        'ngay_huy',
        'ly_do',
    ];

    public function loHang()
    {
        return $this->belongsTo(LoHang::class, 'ma_lo_hang', 'ma_lo_hang');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'ma_san_pham', 'MaSanPham');
    }
}
