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
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Báo cáo doanh thu</h4>
                                <div class="d-flex align-items-center">
                                    <form action="{{ route('admin.reports.revenue') }}" method="GET" class="d-flex">
                                        <select name="month" class="form-control me-2">
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $selectedDate->month == $i ? 'selected' : '' }}>
                                                    Tháng {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                        <select name="year" class="form-control me-2">
                                            @for ($i = $selectedDate->year - 2; $i <= $selectedDate->year; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $selectedDate->year == $i ? 'selected' : '' }}>
                                                    Năm {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                        <button type="submit" class="btn btn-primary">Xem</button>
                                    </form>
                                    <a href="{{ route('admin.reports.revenue.export_excel') }}"
                                        class="btn btn-success ms-2">
                                        Xuất Excel
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-3">
                                        <div class="card bg-primary text-white">
                                            <div class="card-body">
                                                <h5>Tổng doanh thu</h5>
                                                <h3>{{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div
                                            class="card {{ $percentChange >= 0 ? 'bg-success' : 'bg-danger' }} text-white">
                                            <div class="card-body">
                                                <h5>So với tháng trước</h5>
                                                <h3>{{ number_format($percentChange, 1) }}%</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-info text-white">
                                            <div class="card-body">
                                                <h5>Tổng đơn hàng</h5>
                                                <h3>{{ $totalOrders }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <canvas id="revenueChart" width="400" height="200"></canvas>

                                <div class="table-responsive mt-4">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Ngày</th>
                                                <th>Doanh thu</th>
                                                <th>Số đơn hàng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($revenueData as $data)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($data->Ngay)->format('d/m/Y') }}</td>
                                                    <td>{{ number_format($data->TongTien, 0, ',', '.') }} VNĐ</td>
                                                    <td>{{ $data->SoDonHang }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                var ctx = document.getElementById('revenueChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode(
                            $revenueData->pluck('Ngay')->map(function ($date) {
                                return \Carbon\Carbon::parse($date)->format('d/m');
                            }),
                        ) !!},
                        datasets: [{
                            label: 'Doanh thu',
                            data: {!! json_encode($revenueData->pluck('TongTien')) !!},
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return new Intl.NumberFormat('vi-VN', {
                                            style: 'currency',
                                            currency: 'VND'
                                        }).format(value);
                                    }
                                }
                            }
                        }
                    }
                });
            </script>
        @endpush
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
        var revenueLabels = {!! json_encode(
            $revenueData->pluck('Ngay')->map(function ($date) {
                return \Carbon\Carbon::parse($date)->format('d/m');
            }),
        ) !!};
        var revenueData = {!! json_encode($revenueData->pluck('TongTien')) !!};

        var ctx = document.getElementById('revenueChart').getContext('2d');
        var revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Doanh thu',
                    data: revenueData,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75,192,192,1)',
                    borderWidth: 1,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('vi-VN', {
                                    style: 'currency',
                                    currency: 'VND'
                                });
                            }
                        }
                    }
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.yLabel.toLocaleString('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            });
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
