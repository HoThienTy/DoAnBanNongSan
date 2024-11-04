<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhuongThucThanhToan extends Model
{
    protected $table = 'phuong_thuc_thanh_toan';
    protected $primaryKey = 'ma_phuong_thuc';
    public $timestamps = false;

    protected $fillable = [
        'ten_phuong_thuc',
        'mo_ta',
    ];

    public function thanhToan()
    {
        return $this->hasMany(ThanhToan::class, 'ma_phuong_thuc', 'ma_phuong_thuc');
    }
}
