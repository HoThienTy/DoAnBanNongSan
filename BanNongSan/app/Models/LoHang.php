<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LoHang extends Model
{
    protected $table = 'lohang';
    protected $primaryKey = 'ma_lo_hang';
    public $timestamps = false;

    protected $fillable = [
        'ma_san_pham',
        'ngay_nhap',
        'han_su_dung',
        'so_luong',
        'gia_nhap',
        'trang_thai_khuyen_mai',
    ];

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'ma_san_pham', 'MaSanPham');
    }

    public function huy()
    {
        return $this->hasMany(Huy::class, 'ma_lo_hang', 'ma_lo_hang');
    }
    public function chuongTrinhKhuyenMai()
    {
        return $this->belongsTo(ChuongTrinhKhuyenMai::class, 'ma_khuyen_mai', 'ma_khuyen_mai');
    }

    public function khuyenMai()
    {
        return $this->belongsToMany(MaKhuyenMai::class, 'lohang_ma_khuyen_mai', 'ma_lo_hang', 'ma_khuyen_mai');
    }

    public function up()
    {
        Schema::table('lohang', function (Blueprint $table) {
            $table->string('trang_thai')->default('active'); // active, empty, expired
        });
    }

    

}
