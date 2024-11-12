<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NhaCungCap;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = NhaCungCap::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('TenNhaCungCap', 'like', '%' . $search . '%')
                  ->orWhere('DiaChi', 'like', '%' . $search . '%')
                  ->orWhere('SoDienThoai', 'like', '%' . $search . '%')
                  ->orWhere('Email', 'like', '%' . $search . '%');
        }

        $suppliers = $query->paginate(10);

        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'TenNhaCungCap' => 'required|max:100',
            'DiaChi' => 'nullable|max:255',
            'SoDienThoai' => 'nullable|max:15',
            'Email' => 'nullable|email|max:100',
        ]);

        NhaCungCap::create($request->all());

        return redirect()->route('admin.suppliers.index')->with('success', 'Nhà cung cấp đã được thêm thành công.');
    }

    public function edit($id)
    {
        $supplier = NhaCungCap::findOrFail($id);

        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'TenNhaCungCap' => 'required|max:100',
            'DiaChi' => 'nullable|max:255',
            'SoDienThoai' => 'nullable|max:15',
            'Email' => 'nullable|email|max:100',
        ]);

        $supplier = NhaCungCap::findOrFail($id);
        $supplier->update($request->all());

        return redirect()->route('admin.suppliers.index')->with('success', 'Nhà cung cấp đã được cập nhật.');
    }

    public function destroy($id)
    {
        $supplier = NhaCungCap::findOrFail($id);

        // Kiểm tra xem nhà cung cấp có phiếu đặt hàng nào không
        if ($supplier->phieuDatHang()->exists()) {
            return redirect()->route('admin.suppliers.index')->with('error', 'Không thể xóa nhà cung cấp này vì có giao dịch liên quan.');
        }

        $supplier->delete();

        return redirect()->route('admin.suppliers.index')->with('success', 'Nhà cung cấp đã được xóa.');
    }

    public function show($id)
    {
        $supplier = NhaCungCap::findOrFail($id);

        // Lấy lịch sử giao dịch với nhà cung cấp
        $transactions = $supplier->phieuDatHang()->with('chiTietPhieuDatHang.sanPham')->paginate(10);

        return view('admin.suppliers.show', compact('supplier', 'transactions'));
    }

    public function transactionDetail($supplierId, $transactionId)
    {
        $supplier = NhaCungCap::findOrFail($supplierId);

        $transaction = $supplier->phieuDatHang()
            ->where('MaPhieuDatHang', $transactionId)
            ->with('chiTietPhieuDatHang.sanPham')
            ->firstOrFail();

        return view('admin.suppliers.transaction_detail', compact('supplier', 'transaction'));
    }
}
