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
        <h2>Chi tiết đơn hàng #{{ $order->ma_hoa_don }}</h2>
        <p>Ngày đặt: {{ $order->ngay_dat }}</p>
        <p>Tổng tiền: {{ number_format($order->tong_tien, 0, ',', '.') }} VNĐ</p>
        <p>Trạng thái: {{ $order->trang_thai }}</p>
    
        <h3>Danh sách sản phẩm</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chiTietHoaDon as $chiTiet)
                <tr>
                    <td>{{ $chiTiet->sanPham->TenSanPham }}</td>
                    <td>{{ $chiTiet->so_luong }}</td>
                    <td>{{ number_format($chiTiet->don_gia, 0, ',', '.') }} VNĐ</td>
                    <td>{{ number_format($chiTiet->thanh_tien, 0, ',', '.') }} VNĐ</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    
        <a href="{{ route('user.account.orders') }}" class="btn btn-primary">Quay lại lịch sử đơn hàng</a>
    </div>

    @include('layouts.footer')
    @include('layouts.vendor-js')



</body>

</html>
