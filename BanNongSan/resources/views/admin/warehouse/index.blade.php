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
                <h1>Quản lý kho hàng</h1>
            
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
            
                @if(!empty($warnings))
                    <div class="alert alert-warning">
                        <h4>Cảnh báo kho hàng</h4>
                        <ul>
                            @foreach($warnings as $warning)
                                <li>{{ $warning }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            
                <!-- Form tìm kiếm -->
                <div class="card mb-3">
                    <div class="card-body">
                        <form id="searchForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="searchName">Tên sản phẩm</label>
                                    <input type="text" name="TenSanPham" id="searchName" class="form-control" placeholder="Nhập tên sản phẩm" value="{{ $searchName ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="searchCode">Mã sản phẩm</label>
                                    <input type="text" name="MaSanPham" id="searchCode" class="form-control" placeholder="Nhập mã sản phẩm" value="{{ $searchCode ?? '' }}">
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="button" id="searchButton" class="btn btn-primary">Tìm kiếm</button>
                            </div>
                        </form>
                    </div>
                </div>
            
                <!-- Bảng danh sách kho hàng -->
                <div id="warehouseTable">
                    @include('admin.warehouse.warehouse_table', ['products' => $products])
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
            // Khởi tạo tooltip
            $('[data-toggle="tooltip"]').tooltip();
    
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
            function fetchWarehouses() {
                var name = $('#searchName').val();
                var code = $('#searchCode').val();
    
                $.ajax({
                    url: '{{ route('admin.warehouse.search') }}',
                    type: 'GET',
                    data: {
                        TenSanPham: name,
                        MaSanPham: code,
                    },
                    success: function(response) {
                        // Cập nhật bảng kho hàng
                        $('#warehouseTable').html(response.html);
                        // Khởi tạo lại tooltip cho nội dung mới
                        $('[data-toggle="tooltip"]').tooltip();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Có lỗi xảy ra. Vui lòng thử lại.');
                    }
                });
            }
    
            // Gọi hàm fetchWarehouses khi người dùng nhập vào ô tìm kiếm với debounce
            $('#searchName, #searchCode').on('keyup', debounce(function() {
                fetchWarehouses();
            }, 500));
    
            // Gọi hàm fetchWarehouses khi người dùng nhấn nút tìm kiếm
            $('#searchButton').on('click', function() {
                fetchWarehouses();
            });
        });
    </script>
</body>

</html>
