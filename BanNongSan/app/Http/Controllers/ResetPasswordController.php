<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NguoiDung;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'mat_khau' => 'required|confirmed|min:6',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->mat_khau,
            'password_confirmation' => $request->mat_khau_confirmation,
            'token' => $request->token,
        ];

        $response = Password::broker('nguoidungs')->reset($credentials, function ($user, $password) {
            $user->MatKhau = Hash::make($password);
            $user->setRememberToken(Str::random(60));
            $user->save();
        });

        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('auth.login.index')->with('status', 'Mật khẩu đã được đặt lại!');
        } else {
            return back()->withErrors(['email' => 'Có lỗi xảy ra, vui lòng thử lại.']);
        }
    }
}
