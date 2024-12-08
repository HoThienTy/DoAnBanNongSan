<?php

namespace App\Http\Controllers;

use App\Models\ChiTietHoaDon;
use App\Models\HoaDon;
use App\Models\KhachHang;
use App\Models\KhoHang;
use App\Models\LichSuKhoHang;
use App\Models\LoHang;
use App\Models\SanPham;
use Illuminate\Http\Request;
use App\Models\DonHang;
use App\Models\ChiTietDonHang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        DB::beginTransaction();
        try {
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

            $cart = session()->get('cart', []);
            if (empty($cart)) {
                return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
            }

            // Kiểm tra số lượng tồn kho cho từng sản phẩm
            foreach ($cart as $MaSanPham => $item) {
                $product = SanPham::with('loHang')->find($MaSanPham);
                $totalStock = $product->loHang->sum('so_luong');

                if ($item['quantity'] > $totalStock) {
                    return redirect()->back()->with(
                        'error',
                        "Sản phẩm '{$item['name']}' chỉ còn {$totalStock} sản phẩm trong kho!"
                    );
                }
            }

            // Tính tổng tiền và giảm giá
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // Áp dụng mã giảm giá nếu có
            $coupon = session('coupon');
            $discount = 0;
            if ($coupon) {
                $discount = ($total * $coupon->giam_gia) / 100;
            }

            $finalTotal = $total - $discount;

            // Tạo địa chỉ đầy đủ
            $DiaChi = $request->input('street') . ', ' . $this->getWardName($request->ward) . ', '
                . $this->getDistrictName($request->district) . ', '
                . $this->getProvinceName($request->province);

            // Tạo hoặc cập nhật thông tin khách hàng
            if (Auth::check()) {
                $user = Auth::user();
                $khachHang = $user->khachHang;
                if (!$khachHang) {
                    $khachHang = KhachHang::create([
                        'MaNguoiDung' => $user->MaNguoiDung,
                        'TenKhachHang' => $request->HoTen,
                        'SoDienThoai' => $request->SoDienThoai,
                        'DiaChi' => $DiaChi,
                    ]);
                }
            } else {
                $khachHang = KhachHang::create([
                    'TenKhachHang' => $request->HoTen,
                    'SoDienThoai' => $request->SoDienThoai,
                    'DiaChi' => $DiaChi,
                ]);
            }

            // Tạo đơn hàng
            $donHang = HoaDon::create([
                'ma_khach_hang' => $khachHang->MaKhachHang,
                'ngay_dat' => now(),
                'tong_tien' => $finalTotal,
                'trang_thai' => 'Đang xử lý',
                'phuong_thuc_thanh_toan' => $request->payment_method,
                'ma_khuyen_mai' => $coupon ? $coupon->ma_khuyen_mai : null,
                'giam_gia' => $discount,
            ]);

            // Tạo chi tiết đơn hàng và cập nhật kho
            foreach ($cart as $MaSanPham => $item) {
                ChiTietHoaDon::create([
                    'ma_hoa_don' => $donHang->ma_hoa_don,
                    'ma_san_pham' => $MaSanPham,
                    'so_luong' => $item['quantity'],
                    'don_gia' => $item['price'],
                    'thanh_tien' => $item['price'] * $item['quantity'],
                ]);

                // Cập nhật số lượng trong kho theo FIFO
                $remainingQuantity = $item['quantity'];
                $loHangs = LoHang::where('ma_san_pham', $MaSanPham)
                    ->where('so_luong', '>', 0)
                    ->orderBy('ngay_nhap', 'asc')
                    ->get();

                foreach ($loHangs as $loHang) {
                    if ($remainingQuantity <= 0)
                        break;

                    $quantityToDeduct = min($remainingQuantity, $loHang->so_luong);
                    $loHang->so_luong -= $quantityToDeduct;
                    $loHang->save();
                    $remainingQuantity -= $quantityToDeduct;
                }
            }

            DB::commit();

            // Xóa giỏ hàng và mã giảm giá
            session()->forget(['cart', 'coupon']);

            return redirect()->route('user.checkout.success');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xử lý đơn hàng: ' . $e->getMessage());
        }
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
