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
                <h1>Chi tiết đơn hàng #{{ $order->ma_hoa_don }}</h1>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <h3>Thông tin khách hàng</h3>
                @if ($order->khachHang)
                    <p><strong>Tên khách hàng:</strong> {{ $order->khachHang->TenKhachHang }}</p>
                    <p><strong>Số điện thoại:</strong> {{ $order->khachHang->SoDienThoai }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->khachHang->DiaChi }}</p>
                @else
                    <p>Thông tin khách hàng không tồn tại.</p>
                @endif


                <h3>Chi tiết sản phẩm</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->chiTietHoaDon as $chiTiet)
                            <tr>
                                <td>{{ $chiTiet->sanPham->TenSanPham }}</td>
                                <td>{{ $chiTiet->so_luong }}</td>
                                <td>{{ $chiTiet->don_gia }}</td>
                                <td>{{ $chiTiet->thanh_tien }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h3>Thông tin thanh toán</h3>
                @if ($order->thanhToan)
                    <p><strong>Phương thức thanh toán:</strong>
                        {{ $order->thanhToan->phuongThucThanhToan->ten_phuong_thuc }}</p>
                    <p><strong>Ngày thanh toán:</strong> {{ $order->thanhToan->ngay_thanh_toan }}</p>
                    <p><strong>Số tiền:</strong> {{ $order->thanhToan->so_tien }}</p>
                @else
                    <p>Chưa có thông tin thanh toán.</p>
                @endif

                <h3>Thông tin khuyến mãi</h3>
                @if ($order->ma_khuyen_mai)
                    <p><strong>Mã khuyến mãi:</strong> {{ $order->ma_khuyen_mai }}</p>
                    <p><strong>Giảm giá:</strong> {{ $order->giam_gia }}%</p>
                @else
                    <p>Không áp dụng mã khuyến mãi.</p>
                @endif

                <h3>Tổng cộng</h3>
                @php
                    $subTotal = 0;
                    foreach ($order->chiTietHoaDon as $chiTiet) {
                        $subTotal += $chiTiet->don_gia * $chiTiet->so_luong;
                    }
                    $discountAmount = ($subTotal * $order->giam_gia) / 100;
                    $totalAfterDiscount = $subTotal - $discountAmount;
                @endphp
                <ul>
                    <li>Tổng phụ: {{ number_format($subTotal, 0, ',', '.') }} VNĐ</li>
                    @if ($order->giam_gia > 0)
                        <li>Giảm giá ({{ $order->giam_gia }}%): -{{ number_format($discountAmount, 0, ',', '.') }} VNĐ
                        </li>
                    @endif
                    <li>Tổng tiền: {{ number_format($totalAfterDiscount, 0, ',', '.') }} VNĐ</li>
                </ul>


                <h3>Cập nhật trạng thái đơn hàng</h3>
                <form action="{{ route('admin.orders.update', $order->ma_hoa_don) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="trang_thai">Trạng thái:</label>
                        <select name="trang_thai" id="trang_thai" class="form-control">
                            <option value="Đang xử lý" @if ($order->trang_thai == 'Đang xử lý') selected @endif>Đang xử lý
                            </option>
                            <option value="Đang giao hàng" @if ($order->trang_thai == 'Đang giao hàng') selected @endif>Đang giao
                                hàng</option>
                            <option value="Đã giao" @if ($order->trang_thai == 'Đã giao') selected @endif>Đã giao</option>
                            <option value="Đã hủy" @if ($order->trang_thai == 'Đã hủy') selected @endif>Đã hủy</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật trạng thái</button>
                </form>
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
