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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                <h1>Danh sách sản phẩm</h1>            
                <!-- Form tìm kiếm -->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="basic-form">
                            <form id="searchForm">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" name="TenSanPham" id="searchName" class="form-control" placeholder="Tìm kiếm theo tên" value="{{ $searchName ?? '' }}">
                                    </div>
                                    <div class="col-sm-4 mt-2 mt-sm-0">
                                        <input type="text" name="MaSanPham" id="searchCode" class="form-control" placeholder="Tìm kiếm theo mã" value="{{ $searchCode ?? '' }}">
                                    </div>
                                    <div class="col-sm-4 mt-2 mt-sm-0">
                                        <select name="MaDanhMuc" id="searchCategory" class="form-control">
                                            <option value="">-- Chọn danh mục --</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->MaDanhMuc }}" {{ isset($searchCategory) && $searchCategory == $category->MaDanhMuc ? 'selected' : '' }}>
                                                    {{ $category->TenDanhMuc }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            
                <!-- Thông báo thành công nếu có -->
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
            
                <!-- Bảng danh sách sản phẩm -->
                <div id="productTable">
                    @include('admin.products.product_table', ['products' => $products])
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
    <script>
        $(document).ready(function() {
            // Hàm debounce để giảm số lần gửi yêu cầu
            function debounce(func, wait) {
                let timeout;
                return function() {
                    const context = this,
                          args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), wait);
                };
            }
    
            // Hàm gửi yêu cầu AJAX
            function fetchProducts(page = 1) {
                var name = $('#searchName').val();
                var code = $('#searchCode').val();
                var category = $('#searchCategory').val();
    
                $.ajax({
                    url: '{{ route('admin.products.search') }}' + '?page=' + page,
                    type: 'GET',
                    data: {
                        TenSanPham: name,
                        MaSanPham: code,
                        MaDanhMuc: category,
                    },
                    success: function(response) {
                        // Cập nhật bảng sản phẩm
                        $('#productTable').html(response.html);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
    
            // Gọi hàm fetchProducts khi người dùng nhập vào ô tìm kiếm với debounce
            $('#searchName, #searchCode').on('keyup', debounce(function() {
                fetchProducts();
            }, 500));
    
            // Gọi hàm fetchProducts khi người dùng thay đổi lựa chọn trong combobox
            $('#searchCategory').on('change', function() {
                fetchProducts();
            });
    
            // Xử lý sự kiện khi nhấn vào liên kết phân trang
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetchProducts(page);
            });
        });
    </script>
    
</body>

</html>
