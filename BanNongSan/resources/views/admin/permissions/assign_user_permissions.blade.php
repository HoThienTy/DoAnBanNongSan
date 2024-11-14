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
                <h1 class="mt-4">Phân Quyền Cho Người Dùng</h1>
            
                @if(session('success'))
                    <div class="alert alert-success mt-2">{{ session('success') }}</div>
                @endif
            
                @if($errors->any())
                    <div class="alert alert-danger mt-2">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            
                <!-- Form chọn người dùng để phân quyền -->
                <form action="{{ route('permissions.assign.user') }}" method="POST" class="mt-3">
                    @csrf
            
                    <div class="mb-3">
                        <label for="MaNguoiDung" class="form-label">Chọn Người Dùng</label>
                        <select name="MaNguoiDung" id="MaNguoiDung" class="form-control" required>
                            <option value="">-- Chọn Người Dùng --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->MaNguoiDung }}">{{ $user->HoTen }} ({{ $user->TenDangNhap }})</option>
                            @endforeach
                        </select>
                    </div>
            
                    <button type="submit" class="btn btn-primary">Chọn</button>
                </form>
            
                <!-- Nếu đã chọn người dùng, hiển thị form phân quyền -->
                @if(isset($user))
                    <hr>
                    <h2>Phân Quyền Cho: {{ $user->HoTen }} ({{ $user->TenDangNhap }})</h2>
            
                    <form action="{{ route('permissions.assign.user.permissions', $user->MaNguoiDung) }}" method="POST" class="mt-3">
                        @csrf
            
                        <div class="mb-3">
                            <label class="form-label">Chọn Quyền</label>
                            <div class="row">
                                @foreach ($permissions as $permission)
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->MaQuyen }}" id="permission{{ $permission->MaQuyen }}"
                                                {{ $user->quyen->contains('MaQuyen', $permission->MaQuyen) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="permission{{ $permission->MaQuyen }}">
                                                {{ $permission->TenQuyen }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
            
                        <button type="submit" class="btn btn-success">Gán Quyền</button>
                        <a href="{{ route('permissions.assign.user.form') }}" class="btn btn-secondary">Quay Lại</a>
                    </form>
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
