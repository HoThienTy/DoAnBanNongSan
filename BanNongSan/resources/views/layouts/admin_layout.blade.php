<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ogani Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bao gồm CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/admin_style.css') }}" type="text/css">
    <!-- Thêm các link CSS khác nếu cần -->

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-1e3Hgx+dH2Y4AG6/yH/HY1n0j7b6Efy14kQJo/SfF4cV5lG2ODu6v+j3kB6Pi0Fx" crossorigin="anonymous">
</head>
<body>
    <!-- Sidebar Begin -->
    @include('admin.sidebar')
    <!-- Sidebar End -->

    <!-- Main Content Begin -->
    <div class="admin-content">
        <!-- Header Begin -->
        @include('admin.header')
        <!-- Header End -->

        <!-- Content Begin -->
        <div class="admin-main-content">
            @yield('content')
        </div>
        <!-- Content End -->
    </div>
    <!-- Main Content End -->

    <!-- Bao gồm JS -->
    <!-- Thêm các script JS nếu cần -->
</body>
</html>
