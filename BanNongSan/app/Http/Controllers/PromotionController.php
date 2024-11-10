<?php

namespace App\Http\Controllers;

use App\Models\MaKhuyenMai;
use Illuminate\Http\Request;
use App\Models\ChuongTrinhKhuyenMai;
use App\Models\SanPham;
use App\Models\KhuyenMaiSanPham;

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

        return view('admin.promotions.index', compact('productPromotions', 'couponPromotions'));
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
}
