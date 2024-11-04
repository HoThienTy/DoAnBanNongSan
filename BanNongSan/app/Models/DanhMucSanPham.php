<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhMucSanPham extends Model
{
    protected $table = 'danhmucsanpham';
    protected $primaryKey = 'MaDanhMuc';
    public $timestamps = false;

    protected $fillable = [
        'TenDanhMuc',
    ];

    public function sanPham()
    {
        return $this->hasMany(SanPham::class, 'MaDanhMuc', 'MaDanhMuc');
    }

    public function sanPhams()
    {
        return $this->hasMany(SanPham::class, 'MaDanhMuc', 'MaDanhMuc');
    }
}
