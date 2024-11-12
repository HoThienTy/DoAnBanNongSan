<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhieuDatHang;
use App\Models\ChiTietPhieuDatHang;
use App\Models\NhaCungCap;
use App\Models\SanPham;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = PhieuDatHang::with('nhaCungCap');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('MaPhieuDatHang', 'LIKE', "%$search%")
                ->orWhereHas('nhaCungCap', function ($q) use ($search) {
                    $q->where('TenNhaCungCap', 'LIKE', "%$search%");
                });
        }

        $orders = $query->orderBy('NgayDat', 'desc')->paginate(10);

        return view('admin.purchase_orders.index', compact('orders'));
    }

    public function create()
    {
        $suppliers = NhaCungCap::all();
        $products = SanPham::all();
        return view('admin.purchase_orders.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'MaNhaCungCap' => 'required|exists:nhacungcap,MaNhaCungCap',
            'NgayDat' => 'required|date',
            'TrangThai' => 'required|string|max:50',
            'products.*.MaSanPham' => 'required|exists:sanpham,MaSanPham',
            'products.*.SoLuong' => 'required|integer|min:1',
            'products.*.DonGiaNhap' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $order = PhieuDatHang::create([
                'MaNhaCungCap' => $request->MaNhaCungCap,
                'NgayDat' => $request->NgayDat,
                'TrangThai' => $request->TrangThai,
                'TongTien' => 0, // Sẽ cập nhật sau
            ]);

            $tongTien = 0;

            foreach ($request->products as $productData) {
                $chiTiet = ChiTietPhieuDatHang::create([
                    'MaPhieuDatHang' => $order->MaPhieuDatHang,
                    'MaSanPham' => $productData['MaSanPham'],
                    'SoLuong' => $productData['SoLuong'],
                    'DonGiaNhap' => $productData['DonGiaNhap'],
                ]);

                $tongTien += $chiTiet->SoLuong * $chiTiet->DonGiaNhap;
            }

            $order->TongTien = $tongTien;
            $order->save();
        });

        return redirect()->route('admin.purchase_orders.index')->with('success', 'Đã tạo đơn đặt hàng.');
    }

    public function show($id)
    {
        $order = PhieuDatHang::with('nhaCungCap', 'chiTietPhieuDatHang.sanPham')->findOrFail($id);
        return view('admin.purchase_orders.show', compact('order'));
    }

    public function edit($id)
    {
        $purchaseOrder = PhieuDatHang::with('chiTietPhieuDatHang')->findOrFail($id);
        $suppliers = NhaCungCap::all();
        $products = SanPham::all();
        return view('admin.purchase_orders.edit', compact('purchaseOrder', 'suppliers', 'products'));
    }


    public function update(Request $request, $id)
{
    $order = PhieuDatHang::findOrFail($id);

    $request->validate([
        'MaNhaCungCap' => 'required|exists:nhacungcap,MaNhaCungCap',
        'NgayDat' => 'required|date',
        'TrangThai' => 'required|string|max:50',
        'products.*.MaSanPham' => 'required|exists:sanpham,MaSanPham',
        'products.*.SoLuong' => 'required|integer|min:1',
        'products.*.DonGiaNhap' => 'required|numeric|min:0',
    ]);

    DB::transaction(function () use ($request, $order) {
        // Thay vì gọi $order->update([...]), hãy gán trực tiếp các thuộc tính
        $order->MaNhaCungCap = $request->MaNhaCungCap;
        $order->NgayDat = $request->NgayDat;
        $order->TrangThai = $request->TrangThai;

        // Xóa chi tiết cũ
        $order->chiTietPhieuDatHang()->delete();

        $tongTien = 0;

        foreach ($request->products as $productData) {
            $chiTiet = ChiTietPhieuDatHang::create([
                'MaPhieuDatHang' => $order->MaPhieuDatHang,
                'MaSanPham' => $productData['MaSanPham'],
                'SoLuong' => $productData['SoLuong'],
                'DonGiaNhap' => $productData['DonGiaNhap'],
            ]);

            $tongTien += $chiTiet->SoLuong * $chiTiet->DonGiaNhap;
        }

        $order->TongTien = $tongTien;
        $order->save(); // Gọi save() một lần sau khi hoàn thành
    });

    return redirect()->route('admin.purchase_orders.index')->with('success', 'Đã cập nhật đơn đặt hàng.');
}


    public function destroy($id)
    {
        $order = PhieuDatHang::findOrFail($id);
        $order->chiTietPhieuDatHang()->delete();
        $order->delete();

        return redirect()->route('admin.purchase_orders.index')->with('success', 'Đã xóa đơn đặt hàng.');
    }
}
