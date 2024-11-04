<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);

        return view('user.shopping-cart.index', compact('cart'));
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

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function update(Request $request)
    {
        $cart = session()->get('cart', []);

        foreach ($request->input('quantities', []) as $MaSanPham => $quantity) {
            if (isset($cart[$MaSanPham])) {
                $cart[$MaSanPham]['quantity'] = $quantity;
            }
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật!');
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
