<?php

namespace App\Http\Controllers;

use App\Models\HoaDon;
use App\Models\KhachHang;
use Illuminate\Http\Request;
use App\Models\NguoiDung;
use App\Models\Vaitro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Lấy danh sách người dùng và phân quyền, phân trang 12 người dùng mỗi trang
        $users = NguoiDung::with('vaiTro')->paginate(5);
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

        $data = $request->only('TenDangNhap', 'Email', 'HoTen', 'MaVaiTro');

        // Nếu có nhập mật khẩu mới
        if ($request->filled('MatKhau')) {
            $data['MatKhau'] = bcrypt($request->MatKhau);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Thông tin người dùng đã được cập nhật');
    }


    public function destroy($id)
    {
        // Xóa người dùng
        NguoiDung::destroy($id);
        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa');
    }

    // Xem lịch sử đơn hàng
    public function orders()
    {
        $user = Auth::user();
        $khachHang = $user->khachHang;

        if (!$khachHang) {
            // Tạo bản ghi KhachHang cho người dùng
            $khachHang = KhachHang::create([
                'MaNguoiDung' => $user->MaNguoiDung,
                // Các thông tin khác nếu cần
            ]);
        }

        $orders = HoaDon::where('ma_khach_hang', $khachHang->MaKhachHang)
            ->orderBy('ngay_dat', 'desc')
            ->get();

        return view('user.account.orders', compact('orders'));
    }


    // Theo dõi tình trạng đơn hàng
    public function trackOrder()
    {
        // Bạn có thể hiển thị các đơn hàng đang trong quá trình xử lý
        $user = Auth::user();
        $khachHang = $user->khachHang;
        $orders = HoaDon::where('ma_khach_hang', $khachHang->MaKhachHang)
            ->where('trang_thai', '!=', 'Đã giao hàng')
            ->orderBy('ngay_dat', 'desc')
            ->get();

        return view('user.account.trackOrder', compact('orders'));
    }

    // Hiển thị form đổi thông tin tài khoản
    public function editProfile()
    {
        $user = Auth::user();
        return view('user.account.editProfile', compact('user'));
    }

    // Xử lý cập nhật thông tin tài khoản
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validate dữ liệu
        $request->validate([
            'TenDangNhap' => 'required|max:255',
            'email' => 'required|email|max:255',
            // Các trường khác nếu cần
        ]);

        // Cập nhật thông tin người dùng
        $user->TenDangNhap = $request->input('TenDangNhap');
        $user->Email = $request->input('email');
        $user->save();

        // Kiểm tra và tạo bản ghi Khách Hàng nếu chưa có
        if (!$user->khachHang) {
            KhachHang::create([
                'MaNguoiDung' => $user->MaNguoiDung,
                // Các thông tin khác của Khách Hàng nếu cần
            ]);
        }

        return redirect()->route('user.account.editProfile')->with('success', 'Cập nhật thông tin tài khoản thành công.');
    }


    // Hiển thị form đổi mật khẩu
    public function changePassword()
    {
        return view('user.account.changePassword');
    }

    // Xử lý đổi mật khẩu
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Validate dữ liệu
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->input('current_password'), $user->MatKhau)) {
            return redirect()->back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        // Cập nhật mật khẩu mới
        $user->MatKhau = Hash::make($request->input('new_password'));
        $user->save();


        return redirect()->route('user.account.changePassword')->with('success', 'Đổi mật khẩu thành công.');
    }

    public function orderDetail($id)
    {
        $user = Auth::user();
        $khachHang = $user->khachHang;

        if (!$khachHang) {
            return redirect()->route('user.account.orders')->withErrors(['error' => 'Không tìm thấy thông tin khách hàng.']);
        }

        $order = HoaDon::where('ma_hoa_don', $id)
            ->where('ma_khach_hang', $khachHang->MaKhachHang)
            ->firstOrFail();

        $chiTietHoaDon = $order->chiTietHoaDon()->with('sanPham')->get();

        return view('user.account.orderDetail', compact('order', 'chiTietHoaDon'));
    }



}
