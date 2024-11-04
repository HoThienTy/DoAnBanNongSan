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
                <h4 class="card-title">Chỉnh sửa thông tin người dùng</h4>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.users.update', $user->MaNguoiDung) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Tên đăng nhập</label>
                        <input type="text" name="TenDangNhap" class="form-control" value="{{ $user->TenDangNhap }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label>Mật khẩu mới (để trống nếu không thay đổi)</label>
                        <input type="password" name="MatKhau" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="Email" class="form-control" value="{{ $user->Email }}" required>
                    </div>
                    <div class="form-group">
                        <label>Họ tên</label>
                        <input type="text" name="HoTen" class="form-control" value="{{ $user->HoTen }}" required>
                    </div>
                    <div class="form-group">
                        <label>Vai trò</label>
                        <select name="MaVaiTro" class="form-control" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->MaVaiTro }}"
                                    {{ $user->MaVaiTro == $role->MaVaiTro ? 'selected' : '' }}>{{ $role->TenVaiTro }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div style="margin: 20px; text-align: center;">
                        <button type="submit" class="btn btn-success">Cập nhật</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lại</a>
                    </div>
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
