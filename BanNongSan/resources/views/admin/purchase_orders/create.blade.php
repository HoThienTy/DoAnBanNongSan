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
                <h1>Thêm đơn đặt hàng</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.purchase_orders.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="MaNhaCungCap">Nhà cung cấp</label>
                        <select name="MaNhaCungCap" class="form-control" required>
                            <option value="">-- Chọn nhà cung cấp --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->MaNhaCungCap }}">{{ $supplier->TenNhaCungCap }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="NgayDat">Ngày đặt</label>
                        <input type="date" name="NgayDat" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="TrangThai">Trạng thái</label>
                        <select name="TrangThai" class="form-control" required>
                            <option value="Đang xử lý">Đang xử lý</option>
                            <option value="Đã giao">Đã giao</option>
                            <option value="Đã thanh toán">Đã thanh toán</option>
                        </select>
                    </div>
                    <h3>Sản phẩm</h3>
                    <table class="table table-bordered" id="products_table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th><button type="button" class="btn btn-success btn-sm" id="add_row">+</button></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="products[0][MaSanPham]" class="form-control" required>
                                        <option value="">-- Chọn sản phẩm --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->MaSanPham }}">{{ $product->TenSanPham }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" name="products[0][SoLuong]" class="form-control" required
                                        min="1"></td>
                                <td><input type="number" name="products[0][DonGiaNhap]" class="form-control" required
                                        min="0" step="0.01"></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove_row">-</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Tạo đơn đặt hàng</button>
                </form>

                
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
        document.getElementById('add_row').addEventListener('click', function() {
            var tableBody = document.querySelector('#products_table tbody');
            var newRow = tableBody.rows[0].cloneNode(true);
            var rowCount = tableBody.rows.length;

            // Cập nhật tên của các input
            newRow.querySelectorAll('input, select').forEach(function(input) {
                var name = input.name;
                input.name = name.replace(/\d+/, rowCount);
                input.value = '';
            });

            tableBody.appendChild(newRow);
        });

        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove_row')) {
                var row = e.target.closest('tr');
                var tableBody = document.querySelector('#products_table tbody');
                if (tableBody.rows.length > 1) {
                    row.remove();
                }
            }
        });
    </script>


</body>

</html>
