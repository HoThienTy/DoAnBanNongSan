<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhMucSanPham;

class CategoryController extends Controller
{
    public function index()
    {
        // Lấy danh sách danh mục
        $categories = DanhMucSanPham::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        // Hiển thị form tạo danh mục
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'TenDanhMuc' => 'required|max:100|unique:danhmucsanpham,TenDanhMuc',
        ]);

        // Tạo mới danh mục
        DanhMucSanPham::create([
            'TenDanhMuc' => $request->TenDanhMuc,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được thêm thành công');
    }

    public function edit($id)
    {
        // Lấy thông tin danh mục
        $category = DanhMucSanPham::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        // Validate dữ liệu
        $request->validate([
            'TenDanhMuc' => 'required|max:100|unique:danhmucsanpham,TenDanhMuc,' . $id . ',MaDanhMuc',
        ]);

        // Cập nhật danh mục
        $category = DanhMucSanPham::findOrFail($id);
        $category->update([
            'TenDanhMuc' => $request->TenDanhMuc,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được cập nhật');
    }

    public function destroy($id)
    {
        // Xóa danh mục
        DanhMucSanPham::destroy($id);
        return redirect()->route('admin.categories.index')->with('success', 'Danh mục đã được xóa');
    }
}
