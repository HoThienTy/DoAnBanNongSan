<?php

namespace App\Http\Controllers;

use App\Models\LoHang;
use Illuminate\Http\Request;
use App\Models\KhoHang;
use App\Models\LichSuKhoHang;
use App\Models\SanPham;
use Carbon\Carbon;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        // Lấy các tham số tìm kiếm từ request
        $searchName = $request->input('TenSanPham');
        $searchCode = $request->input('MaSanPham');

        // Khởi tạo query builder
        $products = SanPham::with('khoHang');

        // Nếu có tham số tìm kiếm theo tên
        if ($searchName) {
            $products->where('TenSanPham', 'like', '%' . $searchName . '%');
        }

        // Nếu có tham số tìm kiếm theo mã
        if ($searchCode) {
            $products->where('MaSanPham', $searchCode);
        }

        // Lấy danh sách sản phẩm
        $products = $products->paginate(10);

        // Kiểm tra cảnh báo
        $warnings = [];

        foreach ($products as $product) {
            $khoHang = $product->khoHang;
            if ($khoHang) {
                if ($khoHang->SoLuongTon <= $khoHang->MucToiThieu) {
                    $warnings[] = "Sản phẩm {$product->TenSanPham} có số lượng tồn kho dưới mức tối thiểu.";
                }
                if ($khoHang->NgayHetHan && Carbon::parse($khoHang->NgayHetHan)->lt(Carbon::now()->addDays(2))) {
                    $warnings[] = "Sản phẩm {$product->TenSanPham} sắp hết hạn vào ngày {$khoHang->NgayHetHan}.";
                }
            }
        }

        return view('admin.warehouse.index', compact('products', 'warnings', 'searchName', 'searchCode'));
    }


    public function show($id)
    {
        // Hiển thị chi tiết kho hàng của sản phẩm
        $product = SanPham::with('khoHang', 'lichSuKhoHang')->findOrFail($id);
        return view('admin.warehouse.show', compact('product'));
    }

    public function adjustStock(Request $request, $id)
    {
        // Điều chỉnh số lượng tồn kho theo lô hàng
        $request->validate([
            'SoLuong' => 'required|integer|min:1',
            'LoaiGiaoDich' => 'required|in:Nhap,Xuat',
            'NgayHetHan' => 'nullable|date|after_or_equal:today',
            'GiaNhap' => 'required_if:LoaiGiaoDich,Nhap|numeric|min:0',
            'GhiChu' => 'nullable|string|max:255',
        ]);

        $sanPham = SanPham::findOrFail($id);

        if ($request->LoaiGiaoDich == 'Nhap') {
            // Tạo lô hàng mới
            LoHang::create([
                'ma_san_pham' => $sanPham->MaSanPham,
                'ngay_nhap' => Carbon::now()->toDateString(),
                'han_su_dung' => $request->NgayHetHan,
                'so_luong' => $request->SoLuong,
                'gia_nhap' => $request->GiaNhap,
                'trang_thai_khuyen_mai' => null,
            ]);

            // Ghi vào lịch sử kho hàng
            LichSuKhoHang::create([
                'MaSanPham' => $sanPham->MaSanPham,
                'LoaiGiaoDich' => 'Nhap',
                'SoLuong' => $request->SoLuong,
                'NgayGiaoDich' => Carbon::now(),
                'GhiChu' => $request->GhiChu,
            ]);

            return redirect()->route('admin.warehouse.show', $sanPham->MaSanPham)->with('success', 'Đã nhập kho thành công.');
        } else {
            // Xuất kho theo FIFO
            $soLuongCanXuat = $request->SoLuong;
            $loHangs = LoHang::where('ma_san_pham', $sanPham->MaSanPham)
                ->where('so_luong', '>', 0)
                ->orderBy('ngay_nhap', 'asc')
                ->get();

            foreach ($loHangs as $loHang) {
                if ($soLuongCanXuat <= 0) {
                    break;
                }

                if ($loHang->so_luong >= $soLuongCanXuat) {
                    // Trừ trực tiếp số lượng từ lô hàng này
                    $loHang->so_luong -= $soLuongCanXuat;
                    $loHang->save();
                    $soLuongCanXuat = 0;
                } else {
                    // Trừ hết số lượng của lô hàng này và tiếp tục với lô hàng tiếp theo
                    $soLuongCanXuat -= $loHang->so_luong;
                    $loHang->so_luong = 0;
                    $loHang->save();
                }
            }

            if ($soLuongCanXuat > 0) {
                return back()->with('error', 'Số lượng tồn kho không đủ để xuất.');
            }

            // Ghi vào lịch sử kho hàng
            LichSuKhoHang::create([
                'MaSanPham' => $sanPham->MaSanPham,
                'LoaiGiaoDich' => 'Xuat',
                'SoLuong' => $request->SoLuong,
                'NgayGiaoDich' => Carbon::now(),
                'GhiChu' => $request->GhiChu,
            ]);

            return redirect()->route('admin.warehouse.show', $sanPham->MaSanPham)->with('success', 'Đã xuất kho thành công.');
        }
    }


    public function setMinimumLevel(Request $request, $id)
    {
        // Đặt mức tồn kho tối thiểu
        $request->validate([
            'MucToiThieu' => 'required|integer|min:0',
        ]);

        $sanPham = SanPham::findOrFail($id);
        $khoHang = $sanPham->khoHang;

        if (!$khoHang) {
            // Nếu chưa có kho hàng cho sản phẩm này, tạo mới
            $khoHang = KhoHang::create([
                'MaSanPham' => $sanPham->MaSanPham,
                'SoLuongTon' => 0,
                'MucToiThieu' => $request->MucToiThieu,
            ]);
        } else {
            $khoHang->MucToiThieu = $request->MucToiThieu;
            $khoHang->save();
        }

        return redirect()->route('admin.warehouse.show', $sanPham->MaSanPham)->with('success', 'Đã cập nhật mức tồn kho tối thiểu.');
    }

    public function search(Request $request)
    {
        // Lấy các tham số tìm kiếm từ request
        $searchName = $request->input('TenSanPham');
        $searchCode = $request->input('MaSanPham');

        // Khởi tạo query builder với phân trang
        $products = SanPham::with('khoHang');

        // Nếu có tham số tìm kiếm theo tên
        if ($searchName) {
            $products->where('TenSanPham', 'like', '%' . $searchName . '%');
        }

        // Nếu có tham số tìm kiếm theo mã
        if ($searchCode) {
            $products->where('MaSanPham', $searchCode);
        }

        // Lấy danh sách sản phẩm với phân trang (10 sản phẩm mỗi trang)
        $products = $products->paginate(10);

        // Render view partial
        $html = view('admin.warehouse.warehouse_table', compact('products'))->render();

        // Trả về kết quả dưới dạng JSON
        return response()->json(['html' => $html]);
    }



}
