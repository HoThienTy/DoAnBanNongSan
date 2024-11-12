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
                <h1>Quản lý sản phẩm bị hủy</h1>
            
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @elseif(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
            
                <a href="{{ route('admin.cancellation.create') }}" class="btn btn-primary mb-3">Ghi nhận sản phẩm bị hủy</a>
            
                {{-- Kiểm tra nếu có dữ liệu --}}
                @if($cancellations->isEmpty())
                    <p>Không có sản phẩm nào bị hủy.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mã hủy</th>
                                <th>Sản phẩm</th>
                                <th>Lô hàng</th>
                                <th>Số lượng</th>
                                <th>Ngày hủy</th>
                                <th>Lý do</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cancellations as $cancellation)
                            <tr>
                                <td>{{ $cancellation->ma_huy }}</td>
                                <td>{{ $cancellation->sanPham->TenSanPham ?? 'Không có sản phẩm' }}</td>
                                <td>{{ $cancellation->loHang->ma_lo_hang ?? 'Không có lô hàng' }}</td>
                                <td>{{ $cancellation->so_luong }}</td>
                                <td>{{ $cancellation->ngay_huy }}</td>
                                <td>{{ $cancellation->ly_do }}</td>
                                <td>
                                    <form action="{{ route('admin.cancellation.destroy', $cancellation->ma_huy) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thông tin hủy này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
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
