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
                <h1 class="mt-4">Danh Sách Quyền</h1>
            
                @if(session('success'))
                    <div class="alert alert-success mt-2">{{ session('success') }}</div>
                @endif
            
                @if(session('error'))
                    <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                @endif
            
                <div class="mb-3 mt-3">
                    <a href="{{ route('permissions.create') }}" class="btn btn-primary">Thêm Quyền Mới</a>
                </div>
            
                <!-- Form tìm kiếm -->
                <div class="card mb-3">
                    <div class="card-body">
                        <form id="searchForm" action="{{ route('permissions.search') }}" method="GET">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="search" class="form-label">Tên Quyền</label>
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Nhập tên quyền" value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                                <button type="button" id="clearSearch" class="btn btn-secondary">Làm mới</button>
                            </div>
                        </form>
                    </div>
                </div>
            
                <!-- Hiển thị danh sách quyền -->
                <div id="permissionsTable">
                    @include('admin.permissions.permissions_table', ['permissions' => $permissions])
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
            // Xử lý tìm kiếm
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                fetchPermissions(1);
            });
    
            // Xử lý làm mới tìm kiếm
            $('#clearSearch').on('click', function() {
                $('#search').val('');
                fetchPermissions(1);
            });
    
            // Hàm fetchPermissions với AJAX
            function fetchPermissions(page = 1) {
                var search = $('#search').val();
    
                $.ajax({
                    url: '{{ route('permissions.search') }}',
                    type: 'GET',
                    data: {
                        search: search,
                        page: page
                    },
                    success: function(response) {
                        $('#permissionsTable').html(response);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Có lỗi xảy ra. Vui lòng thử lại.');
                    }
                });
            }
    
            // Xử lý phân trang với AJAX
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetchPermissions(page);
            });
        });
    </script>
</body>

</html>
