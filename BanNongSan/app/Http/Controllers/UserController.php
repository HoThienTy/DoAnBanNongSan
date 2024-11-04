<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NguoiDung;
use App\Models\Vaitro;

class UserController extends Controller
{
    public function index()
    {
        // Lấy danh sách người dùng và phân quyền
        $users = NguoiDung::with('vaiTro')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        // Lấy danh sách vai trò để sử dụng trong form
        $roles = Vaitro::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // Validate dữ liệu form
        $request->validate([
            'TenDangNhap' => 'required|unique:NguoiDung,TenDangNhap|max:50',
            'MatKhau' => 'required|min:6',
            'Email' => 'required|email|unique:NguoiDung,Email',
            'HoTen' => 'required|max:100',
            'MaVaiTro' => 'required|exists:vaitro,MaVaiTro'
        ]);

        // Tạo mới người dùng
        NguoiDung::create([
            'TenDangNhap' => $request->TenDangNhap,
            'MatKhau' => bcrypt($request->MatKhau),
            'Email' => $request->Email,
            'HoTen' => $request->HoTen,
            'MaVaiTro' => $request->MaVaiTro,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được thêm thành công');
    }

    public function edit($id)
    {
        // Hiển thị form chỉnh sửa thông tin người dùng
        $user = NguoiDung::findOrFail($id);
        $roles = Vaitro::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        // Validate và cập nhật thông tin người dùng
        $user = NguoiDung::findOrFail($id);

        $request->validate([
            'TenDangNhap' => 'required|max:50|unique:NguoiDung,TenDangNhap,' . $id . ',MaNguoiDung',
            'Email' => 'required|email|unique:NguoiDung,Email,' . $id . ',MaNguoiDung',
            'HoTen' => 'required|max:100',
            'MaVaiTro' => 'required|exists:vaitro,MaVaiTro'
        ]);

        $user->update($request->only('TenDangNhap', 'Email', 'HoTen', 'MaVaiTro'));

        return redirect()->route('admin.users.index')->with('success', 'Thông tin người dùng đã được cập nhật');
    }

    public function destroy($id)
    {
        // Xóa người dùng
        NguoiDung::destroy($id);
        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa');
    }
}
