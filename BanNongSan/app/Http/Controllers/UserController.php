<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Hiển thị danh sách người dùng
        return view('admin.users.index');
    }

    public function edit($id)
    {
        // Hiển thị form chỉnh sửa thông tin người dùng
        return view('admin.user_edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Cập nhật thông tin người dùng
        return redirect()->route('admin.users.index');
    }

    public function destroy($id)
    {
        // Xóa người dùng
        return redirect()->route('admin.users.index');
    }
}
