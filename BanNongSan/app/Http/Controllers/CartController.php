<?php

namespace App\Http\Controllers;

use App\Models\MaKhuyenMai;
use Illuminate\Http\Request;
use App\Models\SanPham;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        $total = 0;
        $discount = 0;
        $finalTotal = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Lấy mã giảm giá nếu có
        $coupon = session('coupon');
        if ($coupon) {
            $discount = ($total * $coupon->giam_gia) / 100;
            $finalTotal = $total - $discount;
        } else {
            $finalTotal = $total;
        }

        $coupons = MaKhuyenMai::where('trang_thai', 1)
            ->whereDate('ngay_bat_dau', '<=', now())
            ->whereDate('ngay_ket_thuc', '>=', now())
            ->get();

        return view('user.shopping-cart.index', compact('cart', 'coupons', 'total', 'discount', 'finalTotal'));
    }

    public function add(Request $request, $MaSanPham)
    {
        $product = SanPham::with('loHang')->findOrFail($MaSanPham);
        $quantity = $request->input('quantity', 1);
        $totalStock = $product->loHang->sum('so_luong');

        if ($quantity > $totalStock) {
            return response()->json([
                'success' => false,
                'message' => "Sản phẩm chỉ còn $totalStock trong kho"
            ]);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$MaSanPham])) {
            $newQuantity = $cart[$MaSanPham]['quantity'] + $quantity;
            if ($newQuantity > $totalStock) {
                return response()->json([
                    'success' => false,
                    'message' => "Không thể thêm vượt quá số lượng trong kho"
                ]);
            }
            $cart[$MaSanPham]['quantity'] = $newQuantity;
        } else {
            $cart[$MaSanPham] = [
                "name" => $product->TenSanPham,
                "quantity" => $quantity,
                "price" => $product->GiaBan,
                "photo" => $product->HinhAnh
            ];
        }

        session()->put('cart', $cart);
        return response()->json([
            'success' => true,
            'message' => 'Đã thêm sản phẩm vào giỏ hàng'
        ]);
    }

    public function update(Request $request)
    {
        $cart = session()->get('cart', []);
        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Giỏ hàng trống'
            ]);
        }

        foreach ($request->quantities as $productId => $quantity) {
            $product = SanPham::with('loHang')->find($productId);
            $totalStock = $product->loHang->sum('so_luong');

            if ($quantity > $totalStock) {
                return response()->json([
                    'success' => false,
                    'message' => "Sản phẩm {$product->TenSanPham} chỉ còn $totalStock trong kho"
                ]);
            }

            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $quantity;
            }
        }

        session()->put('cart', $cart);
        $this->recalculateCart();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật giỏ hàng thành công'
        ]);
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        $MaSanPham = $request->input('MaSanPham');

        if (isset($cart[$MaSanPham])) {
            unset($cart[$MaSanPham]);
            session()->put('cart', $cart);
            $this->recalculateCart();
        }

        return redirect()->back()->with('success', 'Đã xóa mã khuyến mãi.');
    }

    private function recalculateCart()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $coupon = session('coupon');
        if ($coupon) {
            $discount = ($total * $coupon->giam_gia) / 100;
            $finalTotal = $total - $discount;
        } else {
            $discount = 0;
            $finalTotal = $total;
        }

        session()->put('cartTotals', [
            'total' => $total,
            'discount' => $discount,
            'finalTotal' => $finalTotal
        ]);
    }
}