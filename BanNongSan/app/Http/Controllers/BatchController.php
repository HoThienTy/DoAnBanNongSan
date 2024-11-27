<?php

namespace App\Http\Controllers;

use App\Models\MaKhuyenMai;
use Illuminate\Http\Request;
use App\Models\LoHang;
use App\Models\SanPham;
use App\Models\Huy;
use Carbon\Carbon;

class BatchController extends Controller
{
    public function index()
    {
        // Lấy danh sách lô hàng
        $batches = LoHang::with('sanPham')->get();
        return view('admin.batch.index', compact('batches'));
    }

    public function create()
    {
        // Lấy danh sách sản phẩm để chọn
        $products = SanPham::all();
        return view('admin.batch.create', compact('products'));
    }

    public function store(Request $request)
    {
        // Xử lý lưu lô hàng mới
        $request->validate([
            'ma_san_pham' => 'required|exists:sanpham,MaSanPham',
            'ngay_nhap' => 'required|date',
            'han_su_dung' => 'required|date|after:ngay_nhap',
            'so_luong' => 'required|integer|min:1',
            'gia_nhap' => 'required|numeric|min:0',
            'trang_thai_khuyen_mai' => 'nullable|string|max:255',
        ]);

        LoHang::create($request->all());

        return redirect()->route('admin.batch.index')->with('success', 'Đã thêm lô hàng mới.');
    }

    public function show($id)
    {
        // Hiển thị chi tiết lô hàng
        $batch = LoHang::with('sanPham', 'huy')->findOrFail($id);
        return view('admin.batch.show', compact('batch'));
    }

    public function destroy($id)
    {
        // Xóa lô hàng
        $batch = LoHang::findOrFail($id);
        $batch->delete();

        return redirect()->route('admin.batch.index')->with('success', 'Đã xóa lô hàng.');
    }
}
