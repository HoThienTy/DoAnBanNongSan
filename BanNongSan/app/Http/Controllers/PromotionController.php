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

        $promotion = ChuongTrinhKhuyenMai::create($request->only('ten_khuyen_mai', 'ngay_bat_dau', 'ngay_ket_thuc', 'mo_ta'));

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

        $promotion->update($request->only('ten_khuyen_mai', 'ngay_bat_dau', 'ngay_ket_thuc', 'mo_ta'));

        KhuyenMaiSanPham::where('ma_khuyen_mai', $promotion->ma_khuyen_mai)->delete();

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

    public function addCouponToBatch(Request $request, $batchId)
    {
        $loHang = LoHang::find($batchId);

        // Kiểm tra nếu lô hàng không tồn tại
        if (!$loHang) {
            return redirect()->route('admin.promotions.index')->with('error', 'Lô hàng không tồn tại.');
        }

        $couponCode = $request->input('coupon_code');
        $coupon = MaKhuyenMai::where('ma_khuyen_mai', $couponCode)->first();

        // Kiểm tra mã khuyến mãi hợp lệ
        if (!$coupon) {
            return redirect()->route('admin.promotions.index')->with('error', 'Mã khuyến mãi không hợp lệ.');
        }

        // Kiểm tra xem mã khuyến mãi đã được áp dụng chưa
        if ($loHang->khuyenMai->contains($coupon->id)) {
            return redirect()->route('admin.promotions.index')->with('info', 'Mã khuyến mãi đã được áp dụng cho lô hàng này.');
        }

        // Gắn mã khuyến mãi vào lô hàng
        $loHang->khuyenMai()->attach($coupon->id);

        // Duyệt qua các sản phẩm của lô hàng và gắn mã khuyến mãi vào mỗi sản phẩm
        // foreach ($loHang->sanPham as $sanPham) {
        //     // Kiểm tra nếu sanPham là đối tượng hợp lệ và khuyến mãi tồn tại
        //     if ($sanPham && $sanPham->khuyenMais()->exists()) {
        //         $sanPham->khuyenMais()->attach($coupon->id, ['giam_gia' => $coupon->giam_gia]);
        //     }
        // }

        // Trả về thông báo thành công
        return redirect()->route('admin.promotions.index')->with('success', 'Mã khuyến mãi đã được thêm vào lô hàng và các sản phẩm.');
    }



    public function addCouponToBatchPage()
    {
        $coupons = MaKhuyenMai::all();
        $batches = LoHang::with('khuyenMai')->get();

        return view('admin.promotions.addCouponToBatch', compact('coupons', 'batches'));
    }

    public function removeCouponFromBatch($batchId, $couponId)
    {
        // Tìm lô hàng theo ID
        $loHang = LoHang::find($batchId);

        // Kiểm tra nếu lô hàng tồn tại
        if (!$loHang) {
            return redirect()->route('admin.promotions.index')->with('error', 'Lô hàng không tồn tại.');
        }

        // Tìm mã khuyến mãi theo ID
        $coupon = MaKhuyenMai::find($couponId);

        // Kiểm tra nếu mã khuyến mãi tồn tại
        if (!$coupon) {
            return redirect()->route('admin.promotions.index')->with('error', 'Mã khuyến mãi không tồn tại.');
        }

        // Kiểm tra xem mã khuyến mãi có thuộc lô hàng này không
        if (!$loHang->khuyenMai->contains($coupon->id)) {
            return redirect()->route('admin.promotions.index')->with('info', 'Mã khuyến mãi này không áp dụng cho lô hàng.');
        }

        // Xóa mã khuyến mãi khỏi lô hàng
        $loHang->khuyenMai()->detach($coupon->id);

        // Thông báo thành công
        return redirect()->route('admin.promotions.index')->with('success', 'Mã khuyến mãi đã được xóa khỏi lô hàng.');
    }

}
