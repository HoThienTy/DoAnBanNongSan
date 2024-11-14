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

        $coupon = MaKhuyenMai::where('ma_khuyen_mai', $request->coupon_code)
            ->where('trang_thai', 1)
            ->whereDate('ngay_bat_dau', '<=', now())
            ->whereDate('ngay_ket_thuc', '>=', now())
            ->first();

        if (!$coupon) {
            return redirect()->back()->withErrors(['coupon_code' => 'Mã khuyến mãi không hợp lệ hoặc đã hết hạn.']);
        }

        if ($coupon->so_lan_su_dung >= $coupon->so_lan_khoi_tao) {
            return redirect()->back()->withErrors(['coupon_code' => 'Mã khuyến mãi đã đạt số lần sử dụng tối đa.']);
        }

        // Tăng số lần sử dụng
        $coupon->increment('so_lan_su_dung');

        session(['coupon' => $coupon]);

        return redirect()->back()->with('success', 'Mã khuyến mãi đã được áp dụng.');
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
