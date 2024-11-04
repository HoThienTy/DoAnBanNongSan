<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quyen extends Model
{
    protected $table = 'quyen';
    protected $primaryKey = 'MaQuyen';
    public $timestamps = false;

    protected $fillable = [
        'TenQuyen',
    ];

    public function vaiTro()
    {
        return $this->belongsToMany(Vaitro::class, 'vaitro_quyen', 'MaQuyen', 'MaVaiTro');
    }
}
