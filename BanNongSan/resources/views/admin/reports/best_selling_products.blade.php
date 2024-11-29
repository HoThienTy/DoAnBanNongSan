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
                <h1>Sản phẩm bán chạy nhất tháng {{ $currentMonth->format('m/Y') }}</h1>
                <div class="search-container">
                    <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm sản phẩm..."
                        onkeyup="filterTable()">
                </div>

                <a href="{{ route('admin.reports.best_selling_products.export_excel') }}" class="btn btn-success">Xuất
                    Excel</a>

                <table class="table" id="bestSellingTable">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng bán</th>
                            <th>% Số lượng bán</th>
                            <th>Doanh thu</th>
                            <th>% Doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bestSellingProducts as $product)
                            <tr>
                                <td>{{ $product->TenSanPham }}</td>
                                <td>{{ $product->TongSoLuongBan }}</td>
                                <td class="percentage">{{ number_format($product->PercentageByQuantity, 2) }}%</td>
                                <td>{{ number_format($product->DoanhThu, 2) }}</td>
                                <td class="revenue">{{ number_format($product->PercentageByRevenue, 2) }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <canvas id="bestSellingChart" width="400" height="200"></canvas>
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
