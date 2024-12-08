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
                                <h4 class="card-title">Báo cáo sản phẩm bán chạy</h4>
                                <div class="d-flex align-items-center">
                                    <form action="{{ route('admin.reports.best_selling_products') }}" method="GET"
                                        class="d-flex">
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
                                    <a href="{{ route('admin.reports.best_selling_products.export_excel') }}"
                                        class="btn btn-success ms-2">
                                        Xuất Excel
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="card bg-primary text-white">
                                            <div class="card-body">
                                                <h5>Tổng số lượng bán</h5>
                                                <h3>{{ number_format($totalQuantity) }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-success text-white">
                                            <div class="card-body">
                                                <h5>Tổng doanh thu</h5>
                                                <h3>{{ number_format($totalRevenue, 0, ',', '.') }} VNĐ</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Sản phẩm</th>
                                                <th>Số lượng bán</th>
                                                <th>% Tổng số lượng</th>
                                                <th>Doanh thu</th>
                                                <th>% Tổng doanh thu</th>
                                                <th>So với tháng trước</th>
                                                <th>Số đơn hàng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bestSellingProducts as $product)
                                                <tr>
                                                    <td>{{ $product->TenSanPham }}</td>
                                                    <td>{{ number_format($product->TongSoLuongBan) }}</td>
                                                    <td>{{ number_format($product->PercentageByQuantity, 1) }}%</td>
                                                    <td>{{ number_format($product->DoanhThu, 0, ',', '.') }} VNĐ</td>
                                                    <td>{{ number_format($product->PercentageByRevenue, 1) }}%</td>
                                                    <td
                                                        class="{{ $product->PercentageChange >= 0 ? 'text-success' : 'text-danger' }}">
                                                        {{ number_format($product->PercentageChange, 1) }}%
                                                    </td>
                                                    <td>{{ $product->SoDonHang }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <canvas id="bestSellingChart" class="mt-4"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                var ctx = document.getElementById('bestSellingChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($bestSellingProducts->pluck('TenSanPham')) !!},
                        datasets: [{
                            label: 'Số lượng bán',
                            data: {!! json_encode($bestSellingProducts->pluck('TongSoLuongBan')) !!},
                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                            borderColor: 'rgb(75, 192, 192)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        @endpush
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
        // Dữ liệu cho biểu đồ sản phẩm bán chạy
        var bestSellingLabels = {!! json_encode($bestSellingProducts->pluck('TenSanPham')) !!};
        var bestSellingData = {!! json_encode($bestSellingProducts->pluck('TongSoLuongBan')) !!};
        var bestSellingRevenueData = {!! json_encode($bestSellingProducts->pluck('DoanhThu')) !!};
        var bestSellingQuantityPercentage = {!! json_encode($bestSellingProducts->pluck('PercentageByQuantity')) !!};
        var bestSellingRevenuePercentage = {!! json_encode($bestSellingProducts->pluck('PercentageByRevenue')) !!};

        var ctx = document.getElementById('bestSellingChart').getContext('2d');
        var bestSellingChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: bestSellingLabels,
                datasets: [{
                        label: 'Số lượng bán',
                        data: bestSellingData,
                        backgroundColor: 'rgba(153, 102, 255, 0.5)',
                        borderColor: 'rgba(153,102,255,1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Doanh thu',
                        data: bestSellingRevenueData,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Hàm lọc bảng khi người dùng nhập vào ô tìm kiếm
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toLowerCase();
            table = document.getElementById("bestSellingTable");
            tr = table.getElementsByTagName("tr");

            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                if (td) {
                    var match = false;
                    for (var j = 0; j < td.length; j++) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            match = true;
                            break;
                        }
                    }
                    if (match) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

</body>
<style>
    /* CSS cho bảng sản phẩm bán chạy */
    .table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
    }

    .table th,
    .table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .table th {
        background-color: #f2f2f2;
        color: #333;
    }

    .table tr:hover {
        background-color: #f9f9f9;
    }

    .table .percentage {
        font-weight: bold;
        color: #4caf50;
    }

    .table .revenue {
        color: #ff9800;
    }

    /* CSS cho nút Excel */
    .btn-success {
        background-color: #4caf50;
        color: white;
        padding: 10px 15px;
        text-decoration: none;
        border-radius: 5px;
        margin: 20px 0;
        display: inline-block;
    }

    .btn-success:hover {
        background-color: #45a049;
    }

    /* CSS cho ô tìm kiếm */
    .search-container {
        margin-bottom: 20px;
        display: flex;
        justify-content: flex-start;
        align-items: center;
    }

    .search-container input {
        width: 300px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
        margin-right: 20px;
    }

    .search-container input:focus {
        outline: none;
        border-color: #4caf50;
    }
</style>

</html>
