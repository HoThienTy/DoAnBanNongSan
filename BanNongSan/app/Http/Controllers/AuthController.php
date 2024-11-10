<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\NguoiDung;

class AuthController extends Controller
{
    // Hiển thị form đăng ký
    public function showRegisterForm()
    {
        return view('auth.register.index');
    }

    // Xử lý đăng ký người dùng
    public function register(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'ten_dang_nhap' => 'required|unique:NguoiDung,TenDangNhap',
            'mat_khau' => 'required|min:6|confirmed',
            'email' => 'required|email|unique:NguoiDung,Email',
            'ho_ten' => 'required',
        ]);

        // Tạo người dùng mới
        $nguoiDung = new NguoiDung();
        $nguoiDung->TenDangNhap = $request->ten_dang_nhap;
        $nguoiDung->MatKhau = Hash::make($request->mat_khau);
        $nguoiDung->Email = $request->email;
        $nguoiDung->HoTen = $request->ho_ten;
        $nguoiDung->MaVaiTro = 1; // Vai trò Khách hàng
        $nguoiDung->save();

        // Tạo người dùng mới
        $user = NguoiDung::create([
            'TenDangNhap' => $request->TenDangNhap,
            'MatKhau' => bcrypt($request->MatKhau),
            'Email' => $request->Email,
            'HoTen' => $request->HoTen,
            'MaVaiTro' => 1, // Mặc định là khách hàng
        ]);

        // Tạo bản ghi Khách Hàng
        KhachHang::create([
            'MaNguoiDung' => $user->MaNguoiDung,
            // Các thông tin khác nếu cần
        ]);

        // Đăng nhập người dùng
        Auth::login($nguoiDung);

        // Chuyển hướng đến trang chủ
        return redirect()->route('auth.login.index');
    }

    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('auth.login.index');
    }

    // Xử lý đăng nhập người dùng
    public function login(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'ten_dang_nhap' => 'required',
            'mat_khau' => 'required',
        ]);

        // Thử đăng nhập
        if (
            Auth::attempt([
                'TenDangNhap' => $request->ten_dang_nhap,
                'password' => $request->mat_khau
            ])
        ) {
            // Đăng nhập thành công
            return redirect()->route('welcome');
        } else {
            // Đăng nhập thất bại
            return back()->withErrors([
                'ten_dang_nhap' => 'Tên đăng nhập hoặc mật khẩu không đúng.',
            ]);
        }
    }

    // Xử lý đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login.index');
    }

}
