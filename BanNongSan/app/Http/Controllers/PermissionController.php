<?php

namespace App\Http\Controllers;

use App\Models\Quyen;
use App\Models\Vaitro;
use App\Models\NguoiDung;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Hiển thị danh sách quyền.
     */
    public function index()
    {
        $permissions = Quyen::paginate(10); // Phân trang 10 quyền mỗi trang
        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Hiển thị form thêm quyền mới.
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Lưu quyền mới vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'TenQuyen' => 'required|unique:quyen,TenQuyen|max:255',
        ]);

        // Tạo quyền mới
        Quyen::create([
            'TenQuyen' => $request->TenQuyen,
        ]);

        return redirect()->route('permissions.index')->with('success', 'Quyền đã được thêm thành công.');
    }

    /**
     * Hiển thị form chỉnh sửa quyền.
     */
    public function edit($id)
    {
        $permission = Quyen::findOrFail($id);
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Cập nhật quyền trong cơ sở dữ liệu.
     */
    public function update(Request $request, $id)
    {
        $permission = Quyen::findOrFail($id);

        // Validate dữ liệu
        $request->validate([
            'TenQuyen' => 'required|unique:quyen,TenQuyen,' . $id . ',MaQuyen|max:255',
        ]);

        // Cập nhật quyền
        $permission->update([
            'TenQuyen' => $request->TenQuyen,
        ]);

        return redirect()->route('permissions.index')->with('success', 'Quyền đã được cập nhật thành công.');
    }

    /**
     * Xóa quyền khỏi cơ sở dữ liệu.
     */
    public function destroy($id)
    {
        $permission = Quyen::findOrFail($id);

        // Kiểm tra xem quyền này có được gán cho vai trò nào không
        if ($permission->vaiTro()->count() > 0) {
            return redirect()->route('permissions.index')->with('error', 'Không thể xóa quyền này vì nó đang được gán cho vai trò.');
        }

        // Kiểm tra xem quyền này có được gán trực tiếp cho người dùng nào không
        if ($permission->nguoiDung()->count() > 0) {
            return redirect()->route('permissions.index')->with('error', 'Không thể xóa quyền này vì nó đang được gán cho người dùng.');
        }

        $permission->delete();

        return redirect()->route('permissions.index')->with('success', 'Quyền đã được xóa thành công.');
    }

    /**
     * Hiển thị form phân quyền cho vai trò.
     */
    public function assignForm()
    {
        $roles = Vaitro::all();
        $permissions = Quyen::all();
        return view('admin.permissions.assign_permissions', compact('roles', 'permissions'));
    }

    /**
     * Xử lý việc gán quyền cho vai trò.
     */
    public function assignPermissions(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'MaVaiTro' => 'required|exists:vaitro,MaVaiTro',
            'permissions' => 'array',
            'permissions.*' => 'exists:quyen,MaQuyen',
        ]);

        $role = Vaitro::findOrFail($request->MaVaiTro);
        $permissions = $request->permissions ?? [];

        // Gán quyền cho vai trò (sync sẽ gán lại toàn bộ quyền mới, bỏ qua các quyền cũ không được chọn)
        $role->quyen()->sync($permissions);

        return redirect()->route('permissions.assign.form')->with('success', 'Đã cập nhật quyền cho vai trò thành công.');
    }

    /**
     * Hiển thị form phân quyền cho người dùng.
     */
    public function assignUserForm(Request $request)
    {
        $permissions = Quyen::all();

        if ($request->isMethod('post')) {
            // Nếu form chọn người dùng đã được submit
            $user_id = $request->input('MaNguoiDung');
            $user = NguoiDung::findOrFail($user_id);
            return view('admin.permissions.assign_user_permissions', compact('user', 'permissions'));
        }

        // Nếu chưa chọn người dùng
        $users = NguoiDung::all();
        return view('admin.permissions.assign_user_permissions', compact('users', 'permissions'));
    }

    /**
     * Xử lý phân quyền cho người dùng.
     */
    public function assignUserPermissions(Request $request, $user_id)
    {
        $user = NguoiDung::findOrFail($user_id);

        // Validate dữ liệu
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:quyen,MaQuyen',
        ]);

        $permissions = $request->permissions ?? [];

        // Gán quyền cho người dùng (sync sẽ gán lại toàn bộ quyền mới, bỏ qua các quyền cũ không được chọn)
        $user->quyen()->sync($permissions);

        return redirect()->route('permissions.assign.user.form')->with('success', 'Đã cập nhật quyền cho người dùng thành công.');
    }

    /**
     * Tìm kiếm quyền.
     */
    public function search(Request $request)
    {
        $search = $request->input('search');

        $permissions = Quyen::where('TenQuyen', 'like', '%' . $search . '%')->paginate(10);

        return view('admin.permissions.partials.permissions_table', compact('permissions'))->render();
    }
}
