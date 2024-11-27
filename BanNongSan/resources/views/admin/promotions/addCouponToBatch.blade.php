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
                <h1>Thêm Mã Khuyến Mãi vào Lô Hàng</h1>

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sản Phẩm</th>
                            <th>Khuyến Mãi Hiện Tại</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($batches as $batch)
                            <tr>
                                <td>{{ $batch->ma_lo_hang }}</td>
                                <td>{{ $batch->sanPham->TenSanPham }}</td>
                                <td>
                                    @if ($batch->khuyenMai->isNotEmpty())
                                        <!-- Hiển thị các mã khuyến mãi -->
                                        @foreach ($batch->khuyenMai as $coupon)
                                            {{ $coupon->ma_khuyen_mai }}<br>
                                        @endforeach
                                    @else
                                        Không có khuyến mãi
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.promotions.addCouponToBatch') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="batch_id" value="{{ $batch->ma_lo_hang }}">
                                        <select name="coupon_code" class="form-control">
                                            <option value="">Chọn Mã Khuyến Mãi</option>
                                            @foreach ($coupons as $coupon)
                                                <option value="{{ $coupon->ma_khuyen_mai }}">
                                                    {{ $coupon->ma_khuyen_mai }} - {{ $coupon->mo_ta }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-success mt-2">Thêm Mã Khuyến Mãi</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
