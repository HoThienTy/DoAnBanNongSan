<?php

namespace App\Http\Controllers;

use App\Models\MaKhuyenMai;
use App\Models\ChuongTrinhKhuyenMai;
use App\Models\SanPham;
use App\Models\KhuyenMaiSanPham;
use App\Models\LoHang;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        // Lấy khuyến mãi theo sản phẩm
        $productPromotions = ChuongTrinhKhuyenMai::all();

        // Lấy mã khuyến mãi (coupon)
        $couponPromotions = MaKhuyenMai::where('trang_thai', 1)
            ->whereDate('ngay_bat_dau', '<=', now())
            ->whereDate('ngay_ket_thuc', '>=', now())
            ->get();
        // Lấy tất cả lô hàng
        $batches = LoHang::all();

        return view('admin.promotions.index', compact('productPromotions', 'couponPromotions', 'batches'));
    }


    public function create()
    {
        $products = SanPham::all();
        return view('admin.promotions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_khuyen_mai' => 'required|max:255',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after_or_equal:ngay_bat_dau',
            'mo_ta' => 'nullable|string',
            'san_pham' => 'required|array',
            'san_pham.*.ma_san_pham' => 'required|exists:sanpham,MaSanPham',
            'san_pham.*.giam_gia' => 'required|numeric|min:0',
        ]);

        // Tạo chương trình khuyến mãi
        $promotion = ChuongTrinhKhuyenMai::create($request->only('ten_khuyen_mai', 'ngay_bat_dau', 'ngay_ket_thuc', 'mo_ta'));

        // Thêm sản phẩm vào chương trình khuyến mãi
        foreach ($request->san_pham as $item) {
            KhuyenMaiSanPham::create([
                'ma_khuyen_mai' => $promotion->ma_khuyen_mai,
                'ma_san_pham' => $item['ma_san_pham'],
                'giam_gia' => $item['giam_gia'],
            ]);
        }

        return redirect()->route('admin.promotions.index')->with('success', 'Chương trình khuyến mãi đã được thêm thành công');
    }

    public function edit($id)
    {
        $promotion = ChuongTrinhKhuyenMai::with('sanPhamKhuyenMai.sanPham')->findOrFail($id);
        $products = SanPham::all();
        return view('admin.promotions.edit', compact('promotion', 'products'));
    }

    public function update(Request $request, $id)
    {
        $promotion = ChuongTrinhKhuyenMai::findOrFail($id);

        $request->validate([
            'ten_khuyen_mai' => 'required|max:255',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after_or_equal:ngay_bat_dau',
            'mo_ta' => 'nullable|string',
            'san_pham' => 'required|array',
            'san_pham.*.ma_san_pham' => 'required|exists:sanpham,MaSanPham',
            'san_pham.*.giam_gia' => 'required|numeric|min:0',
        ]);

        // Cập nhật chương trình khuyến mãi
        $promotion->update($request->only('ten_khuyen_mai', 'ngay_bat_dau', 'ngay_ket_thuc', 'mo_ta'));

        // Xóa các sản phẩm khuyến mãi cũ
        KhuyenMaiSanPham::where('ma_khuyen_mai', $promotion->ma_khuyen_mai)->delete();

        // Thêm sản phẩm mới vào chương trình khuyến mãi
        foreach ($request->san_pham as $item) {
            KhuyenMaiSanPham::create([
                'ma_khuyen_mai' => $promotion->ma_khuyen_mai,
                'ma_san_pham' => $item['ma_san_pham'],
                'giam_gia' => $item['giam_gia'],
            ]);
        }

        return redirect()->route('admin.promotions.index')->with('success', 'Chương trình khuyến mãi đã được cập nhật');
    }

    public function destroy($id)
    {
        $promotion = ChuongTrinhKhuyenMai::findOrFail($id);
        $promotion->delete();
        return redirect()->route('admin.promotions.index')->with('success', 'Chương trình khuyến mãi đã được xóa');
    }

    // Thêm mã khuyến mãi vào lô hàng
    public function addCouponToBatch(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|exists:ma_khuyen_mai,ma_khuyen_mai',
            'batch_id' => 'required|exists:lohang,ma_lo_hang',
        ]);

        // Tìm mã khuyến mãi và lô hàng
        $coupon = MaKhuyenMai::where('ma_khuyen_mai', $request->coupon_code)->first();
        $batch = LoHang::findOrFail($request->batch_id);

        // Kiểm tra tính hợp lệ của mã khuyến mãi
        if (!$coupon->isValid()) {
            return redirect()->back()->withErrors(['coupon_code' => 'Mã khuyến mãi không hợp lệ hoặc đã hết hạn.']);
        }

        // Kiểm tra xem mã khuyến mãi đã được áp dụng cho lô hàng chưa
        if ($batch->khuyenMai()->where('ma_khuyen_mai', $coupon->ma_khuyen_mai)->exists()) {
            return redirect()->back()->withErrors(['coupon_code' => 'Mã khuyến mãi này đã được áp dụng cho lô hàng.']);
        }

        // Thêm mã khuyến mãi vào lô hàng
        $batch->khuyenMai()->attach($coupon->ma_khuyen_mai);

        // Kiểm tra lại số lượng mã khuyến mãi đã được thêm
        if ($batch->khuyenMai()->count() > 0) {
            $batch->trang_thai_khuyen_mai = 'Có khuyến mãi';
        }

        $batch->save();  // Lưu lại trạng thái lô hàng

        return redirect()->route('admin.promotions.addCouponToBatchPage')->with('success', 'Mã khuyến mãi đã được thêm vào lô hàng thành công');
    }

    public function addCouponToBatchPage()
    {
        // Lấy tất cả các mã khuyến mãi
        $coupons = MaKhuyenMai::all();

        // Lấy tất cả các lô hàng và eager load quan hệ khuyến mãi
        $batches = LoHang::with('khuyenMai')->get();  // Eager load `khuyenMai`

        return view('admin.promotions.addCouponToBatch', compact('coupons', 'batches'));
    }



    public function removeCouponFromBatch($ma_lo_hang, $coupon_id)
    {
        $batch = LoHang::findOrFail($ma_lo_hang);
        $batch->khuyenMai()->detach($coupon_id);

        // Kiểm tra xem lô hàng còn khuyến mãi hay không và cập nhật trạng thái
        if ($batch->khuyenMai->isEmpty()) {
            $batch->trang_thai_khuyen_mai = 'Không có';
        }


        $batch->save();

        return redirect()->back()->with('success', 'Mã khuyến mãi đã được xóa khỏi lô hàng.');
    }



}
