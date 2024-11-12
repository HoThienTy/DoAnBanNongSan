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
                <h1>Giao dịch với nhà cung cấp: {{ $supplier->TenNhaCungCap }}</h1>

                <h3>Thông tin nhà cung cấp</h3>
                <ul>
                    <li>Địa chỉ: {{ $supplier->DiaChi }}</li>
                    <li>Số điện thoại: {{ $supplier->SoDienThoai }}</li>
                    <li>Email: {{ $supplier->Email }}</li>
                </ul>

                <h3>Lịch sử giao dịch</h3>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Mã phiếu đặt hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $phieuDatHang)
                            <tr>
                                <td>{{ $phieuDatHang->MaPhieuDatHang }}</td>
                                <td>{{ $phieuDatHang->NgayDat }}</td>
                                <td>{{ number_format($phieuDatHang->TongTien, 0, ',', '.') }} VND</td>
                                <td>
                                    <a href="{{ route('admin.suppliers.transactionDetail', [$supplier->MaNhaCungCap, $phieuDatHang->MaPhieuDatHang]) }}"
                                        class="btn btn-info btn-sm">Xem chi tiết</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $transactions->links() }}

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


</body>

</html>
