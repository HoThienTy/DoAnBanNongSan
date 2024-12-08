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
            <!-- Thêm phần này vào file cancelled_products.blade.php -->
            <div class="container-fluid">
                <h1>Báo cáo hàng hủy</h1>

                <!-- Form chọn tháng -->
                <form method="GET" action="{{ route('admin.reports.cancelled_products') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="month" class="form-control">
                                @foreach ($availableMonths as $availableMonth)
                                    <option
                                        value="{{ Carbon\Carbon::createFromFormat('m/Y', $availableMonth->Thang)->format('m') }}"
                                        {{ $selectedDate->format('m') == Carbon\Carbon::createFromFormat('m/Y', $availableMonth->Thang)->format('m') ? 'selected' : '' }}>
                                        {{ $availableMonth->Thang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Xem báo cáo</button>
                        </div>
                    </div>
                </form>

                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Thống kê hủy hàng theo sản phẩm - Tháng {{ $selectedDate->format('m/Y') }}</h3>
                    </div>
                    <div class="card-body">
                        <table class="table" id="cancelledProductsTable">
                            <thead>
                                <tr>
                                    <th>Tên Sản Phẩm</th>
                                    <th>Số Lượng Hủy</th>
                                    <th>Phần Trăm Hủy</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cancelledProducts as $product)
                                    <tr>
                                        <td>{{ $product->TenSanPham }}</td>
                                        <td>{{ $product->TongSoLuongHuy }}</td>
                                        <td>{{ number_format($product->PhanTramHuy, 2) }}%</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Biểu đồ thống kê -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>Biểu đồ số lượng hủy theo sản phẩm</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="productCancellationChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>Biểu đồ lý do hủy</h3>
                            </div>
                            <div class="card-body">
                                <canvas id="reasonCancellationChart"></canvas>
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
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255,206,86,1)',
                        'rgba(75,192,192,1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });

        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toLowerCase();
            table = document.getElementById("cancelledProductsTable");
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

</html>
