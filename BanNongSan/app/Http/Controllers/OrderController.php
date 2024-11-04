<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HoaDon;
use App\Models\ChiTietHoaDon;
use App\Models\KhachHang;
use App\Models\NhanVien;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = HoaDon::with('khachHang', 'nhanVien');

        // Tìm kiếm
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('ma_hoa_don', 'LIKE', "%$search%")
                ->orWhere('tong_tien', 'LIKE', "%$search%")
                ->orWhereHas('khachHang', function ($q) use ($search) {
                    $q->where('TenKhachHang', 'LIKE', "%$search%");
                });
        }

        // Phân trang, mỗi trang hiển thị 10 đơn hàng
        $orders = $query->orderBy('ngay_dat', 'desc')->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }


    public function show($id)
    {
        $order = HoaDon::with('chiTietHoaDon.sanPham', 'khachHang', 'thanhToan.phuongThucThanhToan')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = HoaDon::findOrFail($id);

        $request->validate([
            'trang_thai' => 'required|string',
        ]);

        $order->trang_thai = $request->trang_thai;
        $order->save();

        return redirect()->route('admin.orders.show', $id)->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
    }

    public function destroy($id)
    {
        $order = HoaDon::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Đơn hàng đã được xóa.');
    }
}
