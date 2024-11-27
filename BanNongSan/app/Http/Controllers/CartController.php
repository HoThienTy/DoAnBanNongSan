<?php

namespace App\Http\Controllers;

use App\Models\MaKhuyenMai;
use Illuminate\Http\Request;
use App\Models\SanPham;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);

        // Lấy danh sách mã khuyến mãi khả dụng
        $coupons = MaKhuyenMai::where('trang_thai', 1)
            ->whereDate('ngay_bat_dau', '<=', now())
            ->whereDate('ngay_ket_thuc', '>=', now())
            ->get();

        return view('user.shopping-cart.index', compact('cart', 'coupons'));
    }


    // Thêm sản phẩm vào giỏ hàng
    public function add(Request $request, $MaSanPham)
    {
        $product = SanPham::findOrFail($MaSanPham);

        $quantity = $request->input('quantity', 1);

        $cart = session()->get('cart', []);

        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        if (isset($cart[$MaSanPham])) {
            // Nếu có, tăng số lượng
            $cart[$MaSanPham]['quantity'] += $quantity;
        } else {
            // Nếu chưa, thêm sản phẩm vào giỏ hàng
            $cart[$MaSanPham] = [
                "name" => $product->TenSanPham,
                "quantity" => $quantity,
                "price" => $product->GiaBan,
                "photo" => $product->HinhAnh
            ];
        }

        // Lưu giỏ hàng vào session
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);

        if ($cart) {
            // Cập nhật số lượng cho từng sản phẩm
            foreach ($request->quantities as $productId => $quantity) {
                if (isset($cart[$productId])) {
                    $cart[$productId]['quantity'] = $quantity;
                }
            }

            // Lưu lại giỏ hàng đã cập nhật vào session
            session()->put('cart', $cart);

            if ($request->ajax()) {
                // Trả về một response JSON nếu là yêu cầu AJAX
                return response()->json(['success' => true, 'message' => 'Giỏ hàng đã được cập nhật.']);
            }

            // Nếu không phải AJAX, chuyển hướng lại trang giỏ hàng
            return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật.');
        }

        return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
    }



    // Xóa sản phẩm khỏi giỏ hàng
    public function remove(Request $request)
    {
        $MaSanPham = $request->input('MaSanPham');

        $cart = session()->get('cart', []);

        if (isset($cart[$MaSanPham])) {
            unset($cart[$MaSanPham]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
    }
}
