<?php

namespace App\Http\Controllers;

use App\Models\MaKhuyenMai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    public function createcoupon()
    {
        return view('admin.promotions.createcoupon');
    }

    public function storecoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50|unique:ma_khuyen_mai,ma_khuyen_mai',
            'coupon_discount' => 'required|numeric|min:0|max:100',
            'usage_limit' => 'required|integer|min:1',
        ]);

        MaKhuyenMai::create([
            'ma_khuyen_mai' => $request->coupon_code,
            'giam_gia' => $request->coupon_discount,
            'ngay_bat_dau' => $request->ngay_bat_dau ?? now(),
            'ngay_ket_thuc' => $request->ngay_ket_thuc ?? now()->addDays(30),
            'trang_thai' => 1,
            'mo_ta' => $request->mo_ta,
            'so_lan_su_dung' => 0,  // Số lần sử dụng khởi tạo
            'so_lan_khoi_tao' => $request->usage_limit,  // Số lần tối đa cho phép
        ]);

        return redirect()->route('admin.promotions.index')->with('success', 'Mã khuyến mãi đã được tạo thành công');
    }


    public function apply(Request $request)
    {
        $request->validate(['coupon_code' => 'required|string']);

        // Kiểm tra giỏ hàng có trống không
        if (!session()->has('cart') || empty(session('cart'))) {
            return response()->json([
                'success' => false,
                'message' => 'Giỏ hàng trống, vui lòng thêm sản phẩm trước khi áp dụng mã giảm giá.'
            ]);
        }

        // Tìm mã khuyến mãi
        $coupon = MaKhuyenMai::where('ma_khuyen_mai', $request->coupon_code)
            ->where('trang_thai', 1)
            ->whereDate('ngay_bat_dau', '<=', now())
            ->whereDate('ngay_ket_thuc', '>=', now())
            ->first();

        // Kiểm tra mã khuyến mãi có tồn tại không
        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Mã khuyến mãi không tồn tại hoặc đã hết hạn.'
            ]);
        }

        // Kiểm tra số lần sử dụng
        if ($coupon->so_lan_su_dung >= $coupon->so_lan_khoi_tao) {
            return response()->json([
                'success' => false,
                'message' => 'Mã khuyến mãi đã hết lượt sử dụng.'
            ]);
        }

        // Kiểm tra xem mã đã được áp dụng chưa
        if (session()->has('coupon')) {
            return response()->json([
                'success' => false,
                'message' => 'Đã có mã khuyến mãi được áp dụng.'
            ]);
        }

        // Lưu mã khuyến mãi vào session
        session(['coupon' => $coupon]);

        // Tăng số lần sử dụng
        $coupon->increment('so_lan_su_dung');

        // Tính toán lại giá trị giỏ hàng
        $total = 0;
        foreach (session('cart') as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        $discount = ($total * $coupon->giam_gia) / 100;
        $finalTotal = $total - $discount;

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng mã khuyến mãi thành công',
            'coupon' => $coupon,
            'total' => number_format($total, 0, ',', '.') . ' VNĐ',
            'discount' => number_format($discount, 0, ',', '.') . ' VNĐ',
            'finalTotal' => number_format($finalTotal, 0, ',', '.') . ' VNĐ'
        ]);
    }

    public function remove()
    {
        session()->forget('coupon');

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa mã khuyến mãi'
        ]);
    }

    public function destroy($id)
    {
        // Tìm mã khuyến mãi dựa trên ID
        $coupon = MaKhuyenMai::findOrFail($id);

        // Xóa mã khuyến mãi
        $coupon->delete();

        // Chuyển hướng về trang quản lý mã khuyến mãi với thông báo thành công
        return redirect()->route('admin.promotions.index')->with('success', 'Mã khuyến mãi đã được xóa');
    }


}
