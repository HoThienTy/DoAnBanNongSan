<?php

namespace App\Http\Controllers;

use App\Models\KhoHang;
use App\Models\LichSuKhoHang;
use App\Models\MaKhuyenMai;
use Illuminate\Http\Request;
use App\Models\LoHang;
use App\Models\SanPham;
use App\Models\Huy;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();
        try {
            // Tạo lô hàng mới
            $batch = LoHang::create($request->all());

            // Cập nhật số lượng trong kho hàng
            $khoHang = KhoHang::firstOrCreate(
                ['MaSanPham' => $request->ma_san_pham],
                ['SoLuongTon' => 0, 'MucToiThieu' => 0]
            );

            $khoHang->SoLuongTon += $request->so_luong;
            $khoHang->save();

            // Ghi log
            LichSuKhoHang::create([
                'MaSanPham' => $request->ma_san_pham,
                'LoaiGiaoDich' => 'Nhap',
                'SoLuong' => $request->so_luong,
                'NgayGiaoDich' => now(),
                'GhiChu' => 'Nhập từ lô hàng #' . $batch->ma_lo_hang
            ]);

            DB::commit();
            return redirect()->route('admin.batch.index')->with('success', 'Đã thêm lô hàng mới.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi thêm lô hàng.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $batch = LoHang::findOrFail($id);

            // Giảm số lượng trong kho hàng
            $khoHang = KhoHang::where('MaSanPham', $batch->ma_san_pham)->first();
            if ($khoHang) {
                $khoHang->SoLuongTon -= $batch->so_luong;
                $khoHang->save();
            }

            // Ghi log
            LichSuKhoHang::create([
                'MaSanPham' => $batch->ma_san_pham,
                'LoaiGiaoDich' => 'Xoa',
                'SoLuong' => $batch->so_luong,
                'NgayGiaoDich' => now(),
                'GhiChu' => 'Xóa lô hàng #' . $id
            ]);

            $batch->delete();

            DB::commit();
            return redirect()->route('admin.batch.index')->with('success', 'Đã xóa lô hàng.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra khi xóa lô hàng.');
        }
    }

    public function show($id)
    {
        // Hiển thị chi tiết lô hàng
        $batch = LoHang::with('sanPham', 'huy')->findOrFail($id);
        return view('admin.batch.show', compact('batch'));
    }
}
