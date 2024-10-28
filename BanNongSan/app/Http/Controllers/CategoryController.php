<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Hiển thị danh sách danh mục
        return view('admin.categories.index');
    }

    public function create()
    {
        // Hiển thị form thêm danh mục mới
        return view('admin.category_create');
    }

    public function store(Request $request)
    {
        // Xử lý lưu danh mục mới vào cơ sở dữ liệu
        return redirect()->route('admin.categories.index');
    }

    public function edit($id)
    {
        // Hiển thị form chỉnh sửa danh mục
        return view('admin.category_edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Xử lý cập nhật danh mục
        return redirect()->route('admin.categories.index');
    }

    public function destroy($id)
    {
        // Xóa danh mục
        return redirect()->route('admin.categories.index');
    }
}
