<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="admin, dashboard">
    <meta name="author" content="DexignZone">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Organi: Admin Dashboard">
    <meta property="og:title" content="Organi: Admin Dashboard">
    <meta property="og:description" content="Organi: Admin Dashboard">
    <meta property="og:image" content="https://dompet.dexignlab.com/xhtml/social-image.png">
    <meta name="format-detection" content="telephone=no">

    <!-- PAGE TITLE HERE -->
    <title>Organi: Admin Dashboard</title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">

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
            <a href="index.html" class="brand-logo">
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
                <h1>Chi tiết lô hàng - {{ $batch->ma_lo_hang }}</h1>
            
                <table class="table table-bordered">
                    <tr>
                        <th>Sản phẩm</th>
                        <td>{{ $batch->sanPham->TenSanPham }}</td>
                    </tr>
                    <tr>
                        <th>Ngày nhập</th>
                        <td>{{ $batch->ngay_nhap }}</td>
                    </tr>
                    <tr>
                        <th>Hạn sử dụng</th>
                        <td>{{ $batch->han_su_dung }}</td>
                    </tr>
                    <tr>
                        <th>Số lượng</th>
                        <td>{{ $batch->so_luong }}</td>
                    </tr>
                    <tr>
                        <th>Giá nhập</th>
                        <td>{{ number_format($batch->gia_nhap, 0, ',', '.') }} đ</td>
                    </tr>
                    <tr>
                        <th>Khuyến mãi</th>
                        <td>{{ $batch->trang_thai_khuyen_mai ?? 'Không có' }}</td>
                    </tr>
                </table>
            
                <h3>Sản phẩm bị hủy trong lô hàng này</h3>
                @if($batch->huy->isEmpty())
                    <p>Không có sản phẩm bị hủy.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Số lượng</th>
                                <th>Ngày hủy</th>
                                <th>Lý do</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($batch->huy as $cancellation)
                            <tr>
                                <td>{{ $cancellation->so_luong }}</td>
                                <td>{{ $cancellation->ngay_huy }}</td>
                                <td>{{ $cancellation->ly_do }}</td>
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
