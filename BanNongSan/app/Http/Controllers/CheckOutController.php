<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use Illuminate\Http\Request;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CheckOutController extends Controller
{
    public function index()
    {
        // Lấy giỏ hàng từ session
        $cart = session('cart', []);
        $total = 0;

        // Tính tổng tiền giỏ hàng
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Kiểm tra xem có mã giảm giá không
        $coupon = session('coupon');
        $discount = 0;

        if ($coupon) {
            // Tính mức giảm giá
            $discount = ($total * $coupon->giam_gia) / 100;
        }

        // Tính tổng sau khi giảm giá
        $finalTotal = $total - $discount;

        return view('user.checkout.index', compact('cart', 'total', 'discount', 'finalTotal'));
    }

    public function placeOrder(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'HoTen' => 'required|max:255',
            'Email' => 'nullable|email|max:255',
            'SoDienThoai' => 'required|max:20',
            'street' => 'required|max:255',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'payment_method' => 'required|in:cod,online',
        ]);

        // Lấy tên tỉnh/thành, quận/huyện, phường/xã từ API
        $provinceCode = $request->input('province');
        $districtCode = $request->input('district');
        $wardCode = $request->input('ward');

        // Bạn có thể gọi API để lấy tên đầy đủ
        $provinceName = $this->getProvinceName($provinceCode);
        $districtName = $this->getDistrictName($districtCode);
        $wardName = $this->getWardName($wardCode);

        // Ghép địa chỉ đầy đủ
        $DiaChi = $request->input('street') . ', ' . $wardName . ', ' . $districtName . ', ' . $provinceName;

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // Tính tổng tiền
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Kiểm tra mã khuyến mãi
        $coupon = session('coupon');
        $discount = 0;
        if ($coupon) {
            $discount = ($total * $coupon->giam_gia) / 100;
        }

        $finalTotal = $total - $discount;

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
                    'DiaChi' => $DiaChi, // Sử dụng biến $DiaChi đã xây dựng
                    // Các cột khác nếu cần
                ]);
            } else {
                // Cập nhật địa chỉ khách hàng nếu cần
                $khachHang->update([
                    'TenKhachHang' => $request->HoTen,
                    'SoDienThoai' => $request->SoDienThoai,
                    'DiaChi' => $DiaChi, // Cập nhật địa chỉ
                ]);
            }
        } else {
            // Nếu người dùng chưa đăng nhập, tạo khách hàng tạm thời
            $khachHang = KhachHang::create([
                'TenKhachHang' => $request->HoTen,
                'SoDienThoai' => $request->SoDienThoai,
                'DiaChi' => $DiaChi, // Sử dụng biến $DiaChi đã xây dựng
                // Các cột khác nếu cần
            ]);
        }

        // Lấy mã khách hàng
        $maKhachHang = $khachHang->MaKhachHang;
        $phuongThucThanhToan = $request->input('payment_method');

        // Tạo đơn hàng
        $donHang = DonHang::create([
            'ma_khach_hang' => $maKhachHang,
            'ma_nhan_vien' => null,
            'ngay_dat' => date('Y-m-d'),
            'tong_tien' => $finalTotal,
            'trang_thai' => 'Đang xử lý',
            'phuong_thuc_thanh_toan' => $phuongThucThanhToan,
            'ma_khuyen_mai' => $coupon ? $coupon->ma_khuyen_mai : null,
            'giam_gia' => $coupon ? $coupon->giam_gia : 0,
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
        // Xóa mã giảm giá khỏi session sau khi thanh toán
        session()->forget('coupon');

        return redirect()->route('user.checkout.success');
    }

    public function success()
    {
        return view('user.checkout.success');
    }

    private function getProvinceName($code)
    {
        $response = Http::get("https://provinces.open-api.vn/api/p/{$code}");
        if ($response->successful()) {
            return $response->json()['name'];
        }
        return '';
    }

    private function getDistrictName($code)
    {
        $response = Http::get("https://provinces.open-api.vn/api/d/{$code}");
        if ($response->successful()) {
            return $response->json()['name'];
        }
        return '';
    }

    private function getWardName($code)
    {
        $response = Http::get("https://provinces.open-api.vn/api/w/{$code}");
        if ($response->successful()) {
            return $response->json()['name'];
        }
        return '';
    }



}
