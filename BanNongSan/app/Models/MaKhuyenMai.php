<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaKhuyenMai extends Model
{
    protected $table = 'ma_khuyen_mai';
    // App\Models\MaKhuyenMai.php
    protected $fillable = [
        'ma_khuyen_mai',
        'giam_gia',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'trang_thai',
        'mo_ta',
        'so_lan_su_dung',
        'so_lan_khoi_tao',
    ];
    public $timestamps = false; // Tắt timestamps

    public function isValid()
    {
        $now = now();
        return $this->trang_thai && $this->ngay_bat_dau <= $now && $this->ngay_ket_thuc >= $now;
    }
}
