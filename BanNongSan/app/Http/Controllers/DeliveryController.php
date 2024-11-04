<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HoaDon;
use App\Models\NhanVien;

class DeliveryController extends Controller
{
    public function index()
    {
        // Lấy danh sách các đơn hàng cần giao
        $orders = HoaDon::where('trang_thai', 'Đang giao hàng')->with('khachHang', 'nhanVien.nguoiDung')->get();

        // Lấy danh sách nhân viên giao hàng
        $deliveryPersons = NhanVien::with('nguoiDung')->get();

        return view('admin.delivery.index', compact('orders', 'deliveryPersons'));
    }

    public function assignDeliveryPerson(Request $request, $id)
    {
        $order = HoaDon::findOrFail($id);

        $request->validate([
            'ma_nhan_vien' => 'required|exists:nhanvien,MaNhanVien',
        ]);

        $order->ma_nhan_vien = $request->ma_nhan_vien;
        $order->save();

        return redirect()->route('admin.delivery.index')->with('success', 'Đã phân công nhân viên giao hàng.');
    }

    public function updateStatus(Request $request, $id)
    {
        $order = HoaDon::findOrFail($id);

        $request->validate([
            'trang_thai' => 'required|string',
        ]);

        $order->trang_thai = $request->trang_thai;
        $order->save();

        return redirect()->route('admin.delivery.index')->with('success', 'Trạng thái giao hàng đã được cập nhật.');
    }
}
