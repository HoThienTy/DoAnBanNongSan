<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Hiển thị danh sách đơn hàng
        return view('admin.orders.index');
    }

    public function show($id)
    {
        // Hiển thị chi tiết đơn hàng
        return view('admin.order_detail', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Cập nhật trạng thái đơn hàng
        return redirect()->route('admin.orders.index');
    }

    public function destroy($id)
    {
        // Xóa đơn hàng
        return redirect()->route('admin.orders.index');
    }
}
