<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable; // Thêm dòng này

class NguoiDung extends Authenticatable implements CanResetPasswordContract
{
    use Notifiable, CanResetPassword;

    protected $table = 'NguoiDung';
    protected $primaryKey = 'MaNguoiDung';
    public $timestamps = false;

    protected $fillable = [
        'TenDangNhap',
        'MatKhau',
        'Email',
        'HoTen',
        'MaVaiTro',
    ];

    protected $hidden = [
        'MatKhau',
    ];

    // Để Laravel sử dụng cột 'MatKhau' cho mật khẩu
    public function getAuthPassword()
    {
        return $this->MatKhau;
    }

    // Thêm accessor cho thuộc tính 'email'
    public function getEmailAttribute()
    {
        return $this->attributes['Email'];
    }

    // Thêm mutator cho thuộc tính 'email' nếu cần
    public function setEmailAttribute($value)
    {
        $this->attributes['Email'] = $value;
    }

    // Để Laravel sử dụng cột 'Email' cho việc đặt lại mật khẩu
    public function getEmailForPasswordReset()
    {
        return $this->Email;
    }

    // Thêm accessor cho thuộc tính 'name' nếu cần
    public function getNameAttribute()
    {
        return $this->HoTen;
    }
}
