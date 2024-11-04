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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
        <div class="content-body card">
            <!-- row -->
            <div class="container-fluid">
                <h1>Quản lý giao hàng</h1>
            
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
            
                @if($orders->isEmpty())
                    <p>Không có đơn hàng cần giao.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mã hóa đơn</th>
                                <th>Khách hàng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Nhân viên giao hàng</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->ma_hoa_don }}</td>
                                <td>{{ $order->khachHang->HoTen }}</td>
                                <td>{{ $order->ngay_dat }}</td>
                                <td>{{ $order->tong_tien }}</td>
                                <td>{{ $order->nhanVien->nguoiDung->HoTen ?? 'Chưa phân công' }}</td>
                                <td>{{ $order->trang_thai }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->ma_hoa_don) }}" class="btn btn-info">Xem</a>
                                    @if(!$order->ma_nhan_vien)
                                    <form action="{{ route('admin.delivery.assign', $order->ma_hoa_don) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        <div class="form-group">
                                            <label for="ma_nhan_vien">Chọn nhân viên:</label>
                                            <select name="ma_nhan_vien" class="form-control">
                                                <!-- Lấy danh sách nhân viên giao hàng -->
                                                @foreach($deliveryPersons as $nhanVien)
                                                    <option value="{{ $nhanVien->MaNhanVien }}">{{ $nhanVien->nguoiDung->HoTen }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Phân công</button>
                                    </form>
                                    @endif
                                    <form action="{{ route('admin.delivery.update-status', $order->ma_hoa_don) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        <div class="form-group">
                                            <label for="trang_thai">Trạng thái:</label>
                                            <select name="trang_thai" class="form-control">
                                                <option value="Đang giao hàng" @if($order->trang_thai == 'Đang giao hàng') selected @endif>Đang giao hàng</option>
                                                <option value="Đã giao" @if($order->trang_thai == 'Đã giao') selected @endif>Đã giao</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-success">Cập nhật</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
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
