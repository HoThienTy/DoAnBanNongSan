<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ogani | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">
    @include('layouts.vendor-css')

</head>
<style>
    .option-address {
        width: 100%;
        height: 46px;
        border: 1px solid #ebebeb;
        padding-left: 20px;
        font-size: 16px;
        color: #b2b2b2;
        border-radius: 4px;
    }
</style>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    @include('layouts.header')

    <div class="container">
        <h2>Đổi thông tin tài khoản</h2>
    
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    
        <!-- Hiển thị lỗi nếu có -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        <form action="{{ route('user.account.updateProfile') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="TenDangNhap">Tên đăng nhập</label>
                <input type="text" name="TenDangNhap" class="form-control" value="{{ $user->TenDangNhap }}" required>
            </div>
            <div class="form-group">
                <label for="email">Địa chỉ email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>
            <!-- Các trường khác nếu cần -->
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>

    @include('layouts.footer')
    @include('layouts.vendor-js')



</body>

</html>
