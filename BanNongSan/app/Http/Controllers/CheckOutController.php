<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use Illuminate\Http\Request;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use Illuminate\Support\Facades\Auth;

class CheckOutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('user.checkout.index', compact('cart', 'total'));
    }

    public function placeOrder(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'HoTen' => 'required|max:255',
            'Email' => 'nullable|email|max:255',
            'SoDienThoai' => 'required|max:20',
            'DiaChi' => 'required|max:500',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // Tính tổng tiền
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Lấy hoặc tạo khách hàng
        if (Auth::check()) {
            // Nếu người dùng đã đăng nhập
            $user = Auth::user();
            // Giả sử bạn có quan hệ giữa User và KhachHang
            $khachHang = $user->khachHang;
            if (!$khachHang) {
                // Nếu chưa có bản ghi KhachHang, tạo mới
                $khachHang = KhachHang::create([
                    'MaNguoiDung' => $user->id, // Hoặc 'MaNguoiDung' tùy theo tên cột của bạn
                    'TenKhachHang' => $request->HoTen,
                    'SoDienThoai' => $request->SoDienThoai,
                    'DiaChi' => $request->DiaChi,
                    // Các cột khác nếu cần
                ]);
            }
        } else {
            // Nếu người dùng chưa đăng nhập, tạo khách hàng tạm thời
            $khachHang = KhachHang::create([
                'TenKhachHang' => $request->HoTen,
                'SoDienThoai' => $request->SoDienThoai,
                'DiaChi' => $request->DiaChi,
                // Các cột khác nếu cần
            ]);
        }

        // Lấy mã khách hàng
        $maKhachHang = $khachHang->MaKhachHang;

        // Tạo đơn hàng
        $donHang = DonHang::create([
            'ma_khach_hang' => $maKhachHang,
            'ma_nhan_vien' => null, // Bạn có thể để null nếu không có
            'ngay_dat' => date('Y-m-d'),
            'tong_tien' => $total,
            'trang_thai' => 'Đang xử lý',
        ]);

        // Lưu chi tiết đơn hàng
        foreach ($cart as $MaSanPham => $item) {
            ChiTietDonHang::create([
                'ma_hoa_don' => $donHang->ma_hoa_don,
                'ma_san_pham' => $MaSanPham,
                'so_luong' => $item['quantity'],
                'don_gia' => $item['price'],
                'thanh_tien' => $item['price'] * $item['quantity'],
            ]);
        }

        // Xóa giỏ hàng
        session()->forget('cart');

        return redirect()->route('welcome')->with('success', 'Đơn hàng của bạn đã được đặt thành công!');
    }


}
