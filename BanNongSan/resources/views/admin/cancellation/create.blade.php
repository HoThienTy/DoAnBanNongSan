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
                <h1>Ghi nhận sản phẩm bị hủy</h1>
            
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @elseif(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
            
                <form action="{{ route('admin.cancellation.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="ma_lo_hang">Chọn lô hàng:</label>
                        <select name="ma_lo_hang" id="ma_lo_hang" class="form-control">
                            @foreach($batches as $batch)
                                <option value="{{ $batch->ma_lo_hang }}">{{ $batch->ma_lo_hang }} - {{ $batch->sanPham->TenSanPham }} - {{$batch->so_luong}}</option>
                            @endforeach
                        </select>
                    </div>
            
                    <div class="form-group">
                        <label for="so_luong">Số lượng:</label>
                        <input type="number" name="so_luong" id="so_luong" class="form-control" min="1" required>
                    </div>
            
                    <div class="form-group">
                        <label for="ngay_huy">Ngày hủy:</label>
                        <input type="date" name="ngay_huy" id="ngay_huy" class="form-control" required>
                    </div>
            
                    <div class="form-group">
                        <label for="ly_do">Lý do:</label>
                        <input type="text" name="ly_do" id="ly_do" class="form-control" required>
                    </div>
            
                    <button type="submit" class="btn btn-primary">Ghi nhận</button>
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

