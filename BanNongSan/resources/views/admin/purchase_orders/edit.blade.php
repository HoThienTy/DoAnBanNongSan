<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="admin, dashboard">
    <meta name="author" content="DexignZone">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Organi: Trang Chủ Admin">
    <meta property="og:title" content="Organi: Trang Chủ Admin">
    <meta property="og:description" content="Organi: Trang Chủ Admin">
    <meta property="og:image" content="https://dompet.dexignlab.com/xhtml/social-image.png">
    <meta name="format-detection" content="telephone=no">

    <!-- PAGE TITLE HERE -->
    <title>Organi: Trang Chủ Admin</title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets_admin/images/favicon.png') }}">

    @include('layouts.vendor-admin-css')
</head>

<body>


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="{{ route('admin.dashboard') }}" class="brand-logo">
                <svg width="150" height="40" xmlns="http://www.w3.org/2000/svg">
                    <text x="0" y="30" font-size="30" fill="rgb(25, 59, 98)"
                        font-family="Arial, sans-serif">Organi</text>
                </svg>

            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>

        @include('layouts.header-admin')


        @include('layouts.sidebar-admin')


        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                <h1>Sửa Phiếu Đặt Hàng #{{ $purchaseOrder->MaPhieuDatHang }}</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Lỗi!</strong> Vui lòng kiểm tra lại thông tin bên dưới:
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.purchase_orders.update', $purchaseOrder->MaPhieuDatHang) }}"
                    method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Thông tin nhà cung cấp -->
                    <div class="form-group">
                        <label for="MaNhaCungCap">Nhà cung cấp</label>
                        <select name="MaNhaCungCap" class="form-control" required>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->MaNhaCungCap }}"
                                    {{ $supplier->MaNhaCungCap == $purchaseOrder->MaNhaCungCap ? 'selected' : '' }}>
                                    {{ $supplier->TenNhaCungCap }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ngày đặt hàng -->
                    <div class="form-group">
                        <label for="NgayDat">Ngày đặt hàng</label>
                        <input type="date" name="NgayDat" class="form-control" value="{{ $purchaseOrder->NgayDat }}"
                            required>
                    </div>

                    <!-- Trạng thái đơn hàng -->
                    <div class="form-group">
                        <label for="TrangThai">Trạng thái</label>
                        <select name="TrangThai" class="form-control" required>
                            <option value="Đang xử lý"
                                {{ $purchaseOrder->TrangThai == 'Đang xử lý' ? 'selected' : '' }}>Đang xử lý</option>
                            <option value="Đã giao" {{ $purchaseOrder->TrangThai == 'Đã giao' ? 'selected' : '' }}>Đã
                                giao</option>
                            <option value="Đã thanh toán"
                                {{ $purchaseOrder->TrangThai == 'Đã thanh toán' ? 'selected' : '' }}>Đã thanh toán
                            </option>
                        </select>
                    </div>

                    <!-- Danh sách sản phẩm -->
                    <h3>Chi tiết sản phẩm</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá nhập</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody id="product-items">
                            @foreach ($purchaseOrder->chiTietPhieuDatHang as $index => $item)
                                <tr>
                                    <td>
                                        <select name="products[{{ $index }}][MaSanPham]" class="form-control"
                                            required>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->MaSanPham }}"
                                                    {{ $product->MaSanPham == $item->MaSanPham ? 'selected' : '' }}>
                                                    {{ $product->TenSanPham }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="products[{{ $index }}][SoLuong]"
                                            class="form-control" value="{{ $item->SoLuong }}" required min="1">
                                    </td>
                                    <td>
                                        <input type="number" name="products[{{ $index }}][DonGiaNhap]"
                                            class="form-control" value="{{ $item->DonGiaNhap }}" required
                                            min="0" step="0.01">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger remove-item">Xóa</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <button type="button" class="btn btn-secondary" id="add-product">Thêm sản phẩm</button>

                    <!-- Nút submit -->
                    <button type="submit" class="btn btn-primary">Cập nhật phiếu đặt hàng</button>
                </form>

                <!-- Template cho dòng sản phẩm mới -->
                <template id="product-row-template">
                    <tr>
                        <td>
                            <select name="products[__index__][MaSanPham]" class="form-control" required>
                                <option value="">-- Chọn sản phẩm --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->MaSanPham }}">{{ $product->TenSanPham }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="products[__index__][SoLuong]" class="form-control" required
                                min="1">
                        </td>
                        <td>
                            <input type="number" name="products[__index__][DonGiaNhap]" class="form-control" required
                                min="0" step="0.01">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger remove-item">Xóa</button>
                        </td>
                    </tr>
                </template>

            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    @include('layouts.vendor-admin-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let productIndex = {{ $purchaseOrder->chiTietPhieuDatHang->count() }};

            document.getElementById('add-product').addEventListener('click', function() {
                let template = document.getElementById('product-row-template').innerHTML;
                template = template.replace(/__index__/g, productIndex);

                let tbody = document.getElementById('product-items');
                tbody.insertAdjacentHTML('beforeend', template);

                productIndex++;
            });

            document.getElementById('product-items').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-item')) {
                    e.target.closest('tr').remove();
                }
            });
        });
    </script>

</body>

</html>
