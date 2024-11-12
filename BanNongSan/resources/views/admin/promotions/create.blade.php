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
                <h1>Thêm chương trình khuyến mãi</h1>
            
                @if($errors->any())
                    <div class="alert alert-danger">
                        Vui lòng kiểm tra lại dữ liệu nhập vào!
                    </div>
                @endif
            
                <form action="{{ route('admin.promotions.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="ten_khuyen_mai">Tên khuyến mãi:</label>
                        <input type="text" name="ten_khuyen_mai" id="ten_khuyen_mai" class="form-control" value="{{ old('ten_khuyen_mai') }}" required>
                    </div>
            
                    <div class="form-group">
                        <label for="ngay_bat_dau">Ngày bắt đầu:</label>
                        <input type="date" name="ngay_bat_dau" id="ngay_bat_dau" class="form-control" value="{{ old('ngay_bat_dau') }}" required>
                    </div>
            
                    <div class="form-group">
                        <label for="ngay_ket_thuc">Ngày kết thúc:</label>
                        <input type="date" name="ngay_ket_thuc" id="ngay_ket_thuc" class="form-control" value="{{ old('ngay_ket_thuc') }}" required>
                    </div>
            
                    <div class="form-group">
                        <label for="mo_ta">Mô tả:</label>
                        <textarea name="mo_ta" id="mo_ta" class="form-control">{{ old('mo_ta') }}</textarea>
                    </div>
            
                    <h3>Chọn sản phẩm và giảm giá</h3>
                    <div id="product-discounts">
                        <div class="product-discount-item">
                            <div class="form-group">
                                <label for="san_pham[0][ma_san_pham]">Sản phẩm:</label>
                                <select name="san_pham[0][ma_san_pham]" class="form-control">
                                    @foreach($products as $product)
                                        <option value="{{ $product->MaSanPham }}">{{ $product->TenSanPham }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="san_pham[0][giam_gia]">Giảm giá (%):</label>
                                <input type="number" name="san_pham[0][giam_gia]" class="form-control" min="0" max="100" required>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" id="add-product-discount">Thêm sản phẩm</button>
            
                    <button type="submit" class="btn btn-primary">Thêm khuyến mãi</button>
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
    <script>
        let index = 1;
        document.getElementById('add-product-discount').addEventListener('click', function() {
            let container = document.getElementById('product-discounts');
            let newItem = document.createElement('div');
            newItem.classList.add('product-discount-item');
            newItem.innerHTML = `
                <hr>
                <div class="form-group">
                    <label for="san_pham[${index}][ma_san_pham]">Sản phẩm:</label>
                    <select name="san_pham[${index}][ma_san_pham]" class="form-control">
                        @foreach($products as $product)
                            <option value="{{ $product->MaSanPham }}">{{ $product->TenSanPham }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="san_pham[${index}][giam_gia]">Giảm giá (%):</label>
                    <input type="number" name="san_pham[${index}][giam_gia]" class="form-control" min="0" max="100" required>
                </div>
            `;
            container.appendChild(newItem);
            index++;
        });
    </script>
</body>

</html>
