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
                <h1>Quản lý chương trình khuyến mãi</h1>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary mb-3">Thêm chương trình khuyến
                    mãi</a>
                <a href="{{ route('admin.promotions.createcoupon') }}" class="btn btn-secondary mb-3">Thêm mã khuyến
                    mãi</a>

                <!-- Hiển thị các khuyến mãi sản phẩm -->
                <h3>Chương trình khuyến mãi theo sản phẩm</h3>
                @if ($productPromotions->isEmpty())
                    <p>Không có chương trình khuyến mãi nào.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mã khuyến mãi</th>
                                <th>Tên khuyến mãi</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc</th>
                                <th>Mô tả</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productPromotions as $promotion)
                                <tr>
                                    <td>{{ $promotion->ma_khuyen_mai }}</td>
                                    <td>{{ $promotion->ten_khuyen_mai }}</td>
                                    <td>{{ $promotion->ngay_bat_dau }}</td>
                                    <td>{{ $promotion->ngay_ket_thuc }}</td>
                                    <td>{{ $promotion->mo_ta }}</td>
                                    <td>
                                        <a href="{{ route('admin.promotions.edit', $promotion->ma_khuyen_mai) }}"
                                            class="btn btn-warning">Sửa</a>
                                        <form
                                            action="{{ route('admin.promotions.destroy', $promotion->ma_khuyen_mai) }}"
                                            method="POST" class="d-inline-block"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa chương trình khuyến mãi này?');">
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

                <!-- Hiển thị các mã khuyến mãi -->
                <h3>Mã khuyến mãi</h3>
                @if ($couponPromotions->isEmpty())
                    <p>Không có mã khuyến mãi nào.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mã</th>
                                <th>Giảm giá (%)</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc</th>
                                <th>Mô tả</th>
                                <th>Số lần đã sử dụng</th>
                                <th>Số lần sử dụng tối đa</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($couponPromotions as $coupon)
                                <tr>
                                    <td>{{ $coupon->ma_khuyen_mai }}</td>
                                    <td>{{ $coupon->giam_gia }}%</td>
                                    <td>{{ $coupon->ngay_bat_dau }}</td>
                                    <td>{{ $coupon->ngay_ket_thuc }}</td>
                                    <td>{{ $coupon->mo_ta }}</td>
                                    <td>{{ $coupon->so_lan_su_dung }}</td>
                                    <td>{{ $coupon->so_lan_khoi_tao }}</td>
                                    <td>
                                        <form action="{{ route('coupon.destroy', $coupon->id) }}" method="POST"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa mã khuyến mãi này?');">
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
