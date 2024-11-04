<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Huy;
use App\Models\LoHang;
use App\Models\SanPham;
use Carbon\Carbon;

class CancellationController extends Controller
{
    public function index()
    {
        // Lấy danh sách sản phẩm bị hủy
        $cancellations = Huy::with('sanPham', 'loHang')->get();
        return view('admin.cancellation.index', compact('cancellations'));
    }

    public function create()
    {
        // Lấy danh sách lô hàng để chọn
        $batches = LoHang::with('sanPham')->get();
        return view('admin.cancellation.create', compact('batches'));
    }

    public function store(Request $request)
    {
        // Xử lý lưu thông tin hủy sản phẩm
        $request->validate([
            'ma_lo_hang' => 'required|exists:lohang,ma_lo_hang',
            'so_luong' => 'required|integer|min:1',
            'ngay_huy' => 'required|date',
            'ly_do' => 'required|string|max:255',
        ]);

        $batch = LoHang::findOrFail($request->ma_lo_hang);

        // Kiểm tra số lượng trong lô hàng
        if ($request->so_luong > $batch->so_luong) {
            return back()->with('error', 'Số lượng hủy vượt quá số lượng trong lô hàng.');
        }

        // Giảm số lượng trong lô hàng
        $batch->so_luong -= $request->so_luong;
        $batch->save();

        // Lưu thông tin hủy
        Huy::create([
            'ma_lo_hang' => $request->ma_lo_hang,
            'ma_san_pham' => $batch->ma_san_pham,
            'so_luong' => $request->so_luong,
            'ngay_huy' => $request->ngay_huy,
            'ly_do' => $request->ly_do,
        ]);

        return redirect()->route('admin.cancellation.index')->with('success', 'Đã ghi nhận sản phẩm bị hủy.');
    }


    public function destroy($id)
    {
        // Xóa thông tin hủy
        $cancellation = Huy::findOrFail($id);

        // Khôi phục số lượng trong lô hàng
        $batch = $cancellation->loHang;
        $batch->so_luong += $cancellation->so_luong;
        $batch->save();

        $cancellation->delete();

        return redirect()->route('admin.cancellation.index')->with('success', 'Đã xóa thông tin hủy.');
    }
}
