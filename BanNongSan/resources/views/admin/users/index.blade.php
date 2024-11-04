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
                    <text x="0" y="30" font-size="30" fill="rgb(25, 59, 98)" font-family="Arial, sans-serif">Organi</text>
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
                <h4 class="card-title">Danh sách người dùng</h4>
                {{-- @if(in_array('Quản lý người dùng', Auth::user()->quyen->pluck('TenQuyen')->toArray()))
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Thêm người dùng</a>
                @endif --}}
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tên đăng nhập</th>
                            <th>Email</th>
                            <th>Họ tên</th>
                            <th>Vai trò</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->TenDangNhap }}</td>
                                <td>{{ $user->Email }}</td>
                                <td>{{ $user->HoTen }}</td>
                                <td>{{ $user->vaiTro->TenVaiTro }}</td>
                                <td>
                                    @if(in_array('Quản lý người dùng', Auth::user()->quyen->pluck('TenQuyen')->toArray()))
                                        <a href="{{ route('admin.users.edit', $user->MaNguoiDung) }}" class="btn btn-sm btn-warning">Sửa</a>
                                        <form action="{{ route('admin.users.destroy', $user->MaNguoiDung) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">Xóa</button>
                                        </form>
                                    @else
                                        <span class="text-muted">Không có quyền</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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