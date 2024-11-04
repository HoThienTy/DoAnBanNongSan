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
                <h1>Thêm lô hàng mới</h1>
            
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            
                <form action="{{ route('admin.batch.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="ma_san_pham">Sản phẩm</label>
                        <select name="ma_san_pham" class="form-control" required>
                            <option value="">-- Chọn sản phẩm --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->MaSanPham }}">{{ $product->TenSanPham }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ngay_nhap">Ngày nhập</label>
                        <input type="date" name="ngay_nhap" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="han_su_dung">Hạn sử dụng</label>
                        <input type="date" name="han_su_dung" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="so_luong">Số lượng</label>
                        <input type="number" name="so_luong" class="form-control" required min="1">
                    </div>
                    <div class="form-group">
                        <label for="gia_nhap">Giá nhập</label>
                        <input type="number" name="gia_nhap" class="form-control" required min="0" step="0.01">
                    </div>
                    <div class="form-group">
                        <label for="trang_thai_khuyen_mai">Trạng thái khuyến mãi</label>
                        <input type="text" name="trang_thai_khuyen_mai" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm lô hàng</button>
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
</body>

</html>
