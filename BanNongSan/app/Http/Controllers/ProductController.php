<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\DanhMucSanPham;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Lấy các tham số tìm kiếm từ request
        $searchName = $request->input('TenSanPham');
        $searchCode = $request->input('MaSanPham');
        $searchCategory = $request->input('MaDanhMuc');

        // Lấy danh sách danh mục
        $categories = DanhMucSanPham::all();

        // Khởi tạo query builder
        $query = SanPham::with('danhMuc');

        // Nếu có tham số tìm kiếm theo tên
        if ($searchName) {
            $query->where('TenSanPham', 'like', '%' . $searchName . '%');
        }

        // Nếu có tham số tìm kiếm theo mã
        if ($searchCode) {
            $query->where('MaSanPham', $searchCode);
        }

        // Nếu có tham số tìm kiếm theo danh mục
        if ($searchCategory) {
            $query->where('MaDanhMuc', $searchCategory);
        }

        // Thực hiện query và lấy kết quả
        $products = $query->paginate(10);

        // Trả về view với dữ liệu
        return view('admin.products.index', compact('products', 'searchName', 'searchCode', 'searchCategory', 'categories'));
    }



    public function create()
    {
        // Lấy danh sách danh mục để hiển thị trong form
        $categories = DanhMucSanPham::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'TenSanPham' => 'required|max:100',
            'LoaiSanPham' => 'nullable|max:50',
            'DonViTinh' => 'required|max:20',
            'MoTa' => 'nullable|max:255',
            'HinhAnh' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'GiaBan' => 'required|numeric',
            'MaDanhMuc' => 'required|exists:danhmucsanpham,MaDanhMuc',
        ]);

        // Xử lý upload hình ảnh
        if ($request->hasFile('HinhAnh')) {
            $image = $request->file('HinhAnh');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $imageName);
        } else {
            $imageName = null;
        }

        // Tạo mới sản phẩm
        SanPham::create([
            'TenSanPham' => $request->TenSanPham,
            'LoaiSanPham' => $request->LoaiSanPham,
            'DonViTinh' => $request->DonViTinh,
            'MoTa' => $request->MoTa,
            'HinhAnh' => $imageName,
            'GiaBan' => $request->GiaBan,
            'NgayTao' => now(),
            'MaDanhMuc' => $request->MaDanhMuc,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được thêm thành công');
    }

    public function edit($id)
    {
        // Lấy sản phẩm và danh mục
        $product = SanPham::findOrFail($id);
        $categories = DanhMucSanPham::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Validate dữ liệu
        $request->validate([
            'TenSanPham' => 'required|max:100',
            'LoaiSanPham' => 'nullable|max:50',
            'DonViTinh' => 'required|max:20',
            'MoTa' => 'nullable|max:255',
            'HinhAnh' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'GiaBan' => 'required|numeric',
            'MaDanhMuc' => 'required|exists:danhmucsanpham,MaDanhMuc',
        ]);

        $product = SanPham::findOrFail($id);

        // Xử lý upload hình ảnh
        if ($request->hasFile('HinhAnh')) {
            // Xóa hình ảnh cũ nếu có
            if ($product->HinhAnh && file_exists(public_path('images/products/' . $product->HinhAnh))) {
                unlink(public_path('images/products/' . $product->HinhAnh));
            }

            $image = $request->file('HinhAnh');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $imageName);
        } else {
            $imageName = $product->HinhAnh;
        }

        // Cập nhật sản phẩm
        $product->update([
            'TenSanPham' => $request->TenSanPham,
            'LoaiSanPham' => $request->LoaiSanPham,
            'DonViTinh' => $request->DonViTinh,
            'MoTa' => $request->MoTa,
            'HinhAnh' => $imageName,
            'GiaBan' => $request->GiaBan,
            'MaDanhMuc' => $request->MaDanhMuc,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được cập nhật');
    }

    public function show($MaSanPham)
    {
        // Lấy thông tin sản phẩm
        $product = SanPham::findOrFail($MaSanPham);

        // Lấy các sản phẩm liên quan (ví dụ: cùng danh mục)
        $relatedProducts = SanPham::where('MaDanhMuc', $product->MaDanhMuc)
            ->where('MaSanPham', '!=', $MaSanPham)
            ->take(4)
            ->get();

        return view('user.product-detail.index', compact('product', 'relatedProducts'));
    }

    public function destroy($id)
    {
        $product = SanPham::findOrFail($id);

        // Xóa hình ảnh nếu có
        if ($product->HinhAnh && file_exists(public_path('images/products/' . $product->HinhAnh))) {
            unlink(public_path('images/products/' . $product->HinhAnh));
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được xóa');
    }

    public function search(Request $request)
    {
        // Lấy các tham số tìm kiếm từ request
        $searchName = $request->input('TenSanPham');
        $searchCode = $request->input('MaSanPham');
        $searchCategory = $request->input('MaDanhMuc');

        // Khởi tạo query builder
        $query = SanPham::with('danhMuc');

        // Nếu có tham số tìm kiếm theo tên
        if ($searchName) {
            $query->where('TenSanPham', 'like', '%' . $searchName . '%');
        }

        // Nếu có tham số tìm kiếm theo mã
        if ($searchCode) {
            $query->where('MaSanPham', $searchCode);
        }

        // Nếu có tham số tìm kiếm theo danh mục
        if ($searchCategory) {
            $query->where('MaDanhMuc', $searchCategory);
        }

        // Thêm phân trang
        $products = $query->paginate(10);

        // Render view partial
        $html = view('admin.products.product_table', compact('products'))->render();

        // Trả về kết quả dưới dạng JSON
        return response()->json(['html' => $html]);
    }


}
