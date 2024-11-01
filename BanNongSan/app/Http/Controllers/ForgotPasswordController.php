<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NguoiDung;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Notifications\Notifiable;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        Log::info('Email nhận được:', ['email' => $request->email]);


        $response = Password::broker('nguoidungs')->sendResetLink(
            $request->only('email')
        );

        if ($response == Password::RESET_LINK_SENT) {
            return back()->with('status', 'Link đặt lại mật khẩu đã được gửi!');
        } else {
            return back()->withErrors(['email' => 'Không tìm thấy người dùng với email này.']);
        }
    }
}
