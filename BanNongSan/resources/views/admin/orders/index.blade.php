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
                <h1>Quản lý đơn hàng</h1>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Form tìm kiếm -->
                <form action="{{ route('admin.orders.index') }}" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="Tìm kiếm mã đơn hàng, khách hàng, tổng tiền..."
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                </form>

                @if ($orders->isEmpty())
                    <p>Không có đơn hàng nào.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mã hóa đơn</th>
                                <th>Khách hàng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->ma_hoa_don }}</td>
                                    <td>{{ $order->khachHang->TenKhachHang }}</td>
                                    <td>{{ $order->ngay_dat }}</td>
                                    <td>{{ number_format($order->tong_tien, 0, ',', '.') }} VNĐ</td>
                                    <td>{{ $order->trang_thai }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->ma_hoa_don) }}"
                                            class="btn btn-info">Xem</a>
                                        <form action="{{ route('admin.orders.destroy', $order->ma_hoa_don) }}"
                                            method="POST" class="d-inline-block"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Hiển thị phân trang tùy chỉnh -->
                    @if ($orders->hasPages())
                        <nav>
                            <ul class="pagination pagination-gutter" style="place-content: center;">
                                {{-- Nút "Trang trước" --}}
                                @if ($orders->onFirstPage())
                                    <li class="page-item page-indicator disabled">
                                        <a class="page-link" href="javascript:void(0)">
                                            <i class="la la-angle-left"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item page-indicator">
                                        <a class="page-link" href="{{ $orders->previousPageUrl() }}">
                                            <i class="la la-angle-left"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- Hiển thị trang đầu nếu cần --}}
                                @if ($orders->currentPage() > 3)
                                    <li class="page-item"><a class="page-link" href="{{ $orders->url(1) }}">1</a></li>
                                    @if ($orders->currentPage() > 4)
                                        <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                                    @endif
                                @endif

                                {{-- Hiển thị các trang xung quanh trang hiện tại --}}
                                @for ($page = max($orders->currentPage() - 2, 1); $page <= min($orders->currentPage() + 2, $orders->lastPage()); $page++)
                                    @if ($page == $orders->currentPage())
                                        <li class="page-item active"><a class="page-link"
                                                href="javascript:void(0)">{{ $page }}</a></li>
                                    @else
                                        <li class="page-item"><a class="page-link"
                                                href="{{ $orders->url($page) }}">{{ $page }}</a></li>
                                    @endif
                                @endfor

                                {{-- Hiển thị trang cuối nếu cần --}}
                                @if ($orders->currentPage() < $orders->lastPage() - 2)
                                    @if ($orders->currentPage() < $orders->lastPage() - 3)
                                        <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                                    @endif
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $orders->url($orders->lastPage()) }}">{{ $orders->lastPage() }}</a>
                                    </li>
                                @endif

                                {{-- Nút "Trang sau" --}}
                                @if ($orders->hasMorePages())
                                    <li class="page-item page-indicator">
                                        <a class="page-link" href="{{ $orders->nextPageUrl() }}">
                                            <i class="la la-angle-right"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item page-indicator disabled">
                                        <a class="page-link" href="javascript:void(0)">
                                            <i class="la la-angle-right"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    @endif
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
