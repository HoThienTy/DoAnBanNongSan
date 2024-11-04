<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vaitro extends Model
{
    protected $table = 'vaitro';
    protected $primaryKey = 'MaVaiTro';
    public $timestamps = false;

    protected $fillable = [
        'TenVaiTro',
    ];

    public function users()
    {
        return $this->hasMany(NguoiDung::class, 'MaVaiTro', 'MaVaiTro');
    }

    public function quyen()
    {
        return $this->belongsToMany(Quyen::class, 'vaitro_quyen', 'MaVaiTro', 'MaQuyen');
    }
}
