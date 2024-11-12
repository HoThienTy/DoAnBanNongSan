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
                <h1>Báo cáo hàng hủy tháng {{ $previousMonth->format('m/Y') }}</h1>
                <a href="{{ route('admin.reports.cancelled_products.export_excel') }}" class="btn btn-success">Xuất Excel</a>

                <h3>Tổng số lượng sản phẩm bị hủy theo từng sản phẩm</h3>
                <canvas id="productCancellationChart" width="400" height="200"></canvas>

                <h3>Thống kê số lượng hàng bị hủy theo từng lý do</h3>
                <canvas id="reasonCancellationChart" width="400" height="200"></canvas>

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
        // Dữ liệu cho biểu đồ sản phẩm
        var productLabels = {!! json_encode($cancelledProducts->pluck('TenSanPham')) !!};
        var productData = {!! json_encode($cancelledProducts->pluck('TongSoLuongHuy')) !!};

        var ctx = document.getElementById('productCancellationChart').getContext('2d');
        var productChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: productLabels,
                datasets: [{
                    label: 'Số lượng bị hủy',
                    data: productData,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255,99,132,1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });

        // Dữ liệu cho biểu đồ lý do
        var reasonLabels = {!! json_encode($cancelledReasons->pluck('ly_do')) !!};
        var reasonData = {!! json_encode($cancelledReasons->pluck('TongSoLuongHuy')) !!};

        var ctx2 = document.getElementById('reasonCancellationChart').getContext('2d');
        var reasonChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: reasonLabels,
                datasets: [{
                    label: 'Số lượng bị hủy',
                    data: reasonData,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        // Thêm màu nếu có nhiều lý do
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255,206,86,1)',
                        'rgba(75,192,192,1)',
                        // Thêm màu nếu có nhiều lý do
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
</body>

</html>
