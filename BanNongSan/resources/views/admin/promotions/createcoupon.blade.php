
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
                <div class="container mt-5">
                    <h1>Tạo mã khuyến mãi</h1>
                    <form action="{{ route('admin.promotions.storecoupon') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="coupon_code">Mã khuyến mãi:</label>
                            <input type="text" name="coupon_code" id="coupon_code" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="coupon_discount">Giảm giá (%):</label>
                            <input type="number" name="coupon_discount" id="coupon_discount" class="form-control" min="0" max="100" required>
                        </div>
                        <div class="form-group">
                            <label for="usage_limit">Số lần sử dụng:</label>
                            <input type="number" name="usage_limit" id="usage_limit" class="form-control" min="1" required>
                        </div>
                        <div class="form-group">
                            <label for="ngay_bat_dau">Ngày bắt đầu:</label>
                            <input type="date" name="ngay_bat_dau" id="ngay_bat_dau" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="ngay_ket_thuc">Ngày kết thúc:</label>
                            <input type="date" name="ngay_ket_thuc" id="ngay_ket_thuc" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="mo_ta">Mô tả:</label>
                            <textarea name="mo_ta" id="mo_ta" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Tạo mã khuyến mãi</button>
                    </form>
                </div>
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
