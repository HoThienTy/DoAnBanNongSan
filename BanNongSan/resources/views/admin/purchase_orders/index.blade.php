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
                <h1>Danh sách đơn đặt hàng</h1>

                <a href="{{ route('admin.purchase_orders.create') }}" class="btn btn-primary mb-3">Thêm đơn đặt hàng</a>

                <form method="GET" action="{{ route('admin.purchase_orders.index') }}" class="form-inline mb-3">
                    <input type="text" name="search" placeholder="Tìm kiếm..." value="{{ request('search') }}"
                        class="form-control mr-2">
                    <button type="submit" class="btn btn-secondary">Tìm kiếm</button>
                </form>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Nhà cung cấp</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái</th>
                            <th>Tổng tiền</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->MaPhieuDatHang }}</td>
                                <td>{{ $order->nhaCungCap->TenNhaCungCap }}</td>
                                <td>{{ $order->NgayDat }}</td>
                                <td>{{ $order->TrangThai }}</td>
                                <td>{{ number_format($order->TongTien, 0, ',', '.') }} VND</td>
                                <td>
                                    <a href="{{ route('admin.purchase_orders.show', $order->MaPhieuDatHang) }}"
                                        class="btn btn-info btn-sm">Xem</a>
                                    <a href="{{ route('admin.purchase_orders.edit', $order->MaPhieuDatHang) }}"
                                        class="btn btn-warning btn-sm">Sửa</a>
                                    <form action="{{ route('admin.purchase_orders.destroy', $order->MaPhieuDatHang) }}"
                                        method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $orders->links() }}

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
