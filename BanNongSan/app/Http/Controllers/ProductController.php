<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Hiển thị danh sách sản phẩm
        return view('admin.products.index');
    }

    public function create()
    {
        // Hiển thị form thêm sản phẩm mới
        return view('admin.product_create');
    }

    public function store(Request $request)
    {
        // Xử lý lưu sản phẩm mới vào cơ sở dữ liệu
        // Hiện tại chúng ta chỉ cần chuyển hướng về trang danh sách sản phẩm
        return redirect()->route('admin.products.index');
    }

    public function edit($id)
    {
        // Hiển thị form chỉnh sửa sản phẩm
        return view('admin.product_edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Xử lý cập nhật sản phẩm
        return redirect()->route('admin.products.index');
    }

    public function destroy($id)
    {
        // Xóa sản phẩm
        return redirect()->route('admin.products.index');
    }
}
