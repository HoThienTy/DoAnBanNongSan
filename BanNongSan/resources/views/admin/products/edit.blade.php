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
                <div class="container-fluid">
                    <h1>Chỉnh sửa sản phẩm</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.update', $product->MaSanPham) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="TenSanPham">Tên sản phẩm</label>
                            <input type="text" name="TenSanPham" class="form-control"
                                value="{{ $product->TenSanPham }}" required>
                        </div>
                        <div class="form-group">
                            <label for="LoaiSanPham">Loại sản phẩm</label>
                            <input type="text" name="LoaiSanPham" class="form-control"
                                value="{{ $product->LoaiSanPham }}">
                        </div>
                        <div class="form-group">
                            <label for="DonViTinh">Đơn vị tính</label>
                            <input type="text" name="DonViTinh" class="form-control"
                                value="{{ $product->DonViTinh }}" required>
                        </div>
                        <div class="form-group">
                            <label for="MoTa">Mô tả</label>
                            <textarea name="MoTa" class="form-control">{{ $product->MoTa }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="HinhAnh">Hình ảnh</label>
                            @if ($product->HinhAnh)
                                <img src="{{ asset('images/products/' . $product->HinhAnh) }}"
                                    alt="{{ $product->TenSanPham }}" width="100">
                            @endif
                            <input type="file" name="HinhAnh" class="form-control-file">
                        </div>
                        <div class="form-group">
                            <label for="GiaBan">Giá bán</label>
                            <input type="number" name="GiaBan" class="form-control" value="{{ $product->GiaBan }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="MaDanhMuc">Danh mục</label>
                            <select name="MaDanhMuc" class="form-control" required>
                                <option value="">-- Chọn danh mục --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->MaDanhMuc }}"
                                        {{ $product->MaDanhMuc == $category->MaDanhMuc ? 'selected' : '' }}>
                                        {{ $category->TenDanhMuc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Cập nhật sản phẩm</button>
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
