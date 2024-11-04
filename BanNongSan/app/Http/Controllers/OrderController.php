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
    public function index()
    {
        $orders = HoaDon::with('khachHang', 'nhanVien')->get();
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
