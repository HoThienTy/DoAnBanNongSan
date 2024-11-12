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
<style>
	b {
		font-size: 30px;
	}
</style>
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
                <!-- Thông tin tổng quan -->
                <div class="row">
                    <!-- Tổng số khách hàng -->
                    <div class="col-md-3">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">
                                <b>{{ $totalCustomers }}</b>
                                <p>Tổng số khách hàng</p>
                            </div>
                        </div>
                    </div>
                    <!-- Tổng số sản phẩm -->
                    <div class="col-md-3">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">
                                <b>{{ $totalProducts }}</b>
                                <p>Tổng số sản phẩm</p>
                            </div>
                        </div>
                    </div>
                    <!-- Tổng doanh thu -->
                    <div class="col-md-3">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">
                                <b>{{ number_format($totalRevenue, 0, ',', '.') }} VND</b>
                                <p>Tổng doanh thu</p>
                            </div>
                        </div>
                    </div>
                    <!-- Số đơn hàng mới -->
                    <div class="col-md-3">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body">
                                <b>{{ $newOrders }}</b>
                                <p>Đơn hàng mới hôm nay</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Biểu đồ doanh thu theo tháng -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Doanh thu theo tháng trong năm {{ \Carbon\Carbon::now()->year }}</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="revenueChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sản phẩm bán chạy và sản phẩm sắp hết hàng -->
                <div class="row">
                    <!-- Sản phẩm bán chạy -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Sản phẩm bán chạy</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach ($bestSellingProducts as $product)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $product->TenSanPham }}
                                            <span class="badge bg-primary rounded-pill">{{ $product->TongSoLuongBan }}
                                                sản phẩm</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Sản phẩm sắp hết hàng -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Sản phẩm sắp hết hàng</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach ($lowStockProducts as $product)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $product->TenSanPham }}
                                            <span class="badge bg-danger rounded-pill">Còn lại {{ $product->so_luong }}
                                                sản phẩm</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Đơn hàng mới nhất -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Đơn hàng mới nhất</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Mã đơn hàng</th>
                                            <th>Khách hàng</th>
                                            <th>Ngày đặt</th>
                                            <th>Tổng tiền</th>
                                            <th>Tình trạng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentOrders as $order)
                                            <tr>
                                                <td>{{ $order->ma_hoa_don }}</td>
                                                <td>{{ $order->ma_khach_hang }}</td>
                                                <td>{{ \Carbon\Carbon::parse($order->ngay_dat)->format('d/m/Y') }}</td>
                                                <td>{{ number_format($order->tong_tien, 0, ',', '.') }} VND</td>
                                                <td>{{ $order->trang_thai }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">Xem tất cả đơn
                                    hàng</a>
                            </div>
                        </div>
                    </div>
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
    <!-- Thêm script cho biểu đồ -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('revenueChart').getContext('2d');
        var revenueData = {!! json_encode($monthlyRevenue) !!};

        var months = [];
        var totals = [];

        revenueData.forEach(function(data) {
            months.push('Tháng ' + data.month);
            totals.push(data.total);
        });

        var revenueChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Doanh thu',
                    data: totals,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, values) {
                                return value.toLocaleString('vi-VN') + ' VND';
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed.y.toLocaleString('vi-VN') + ' VND';
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
