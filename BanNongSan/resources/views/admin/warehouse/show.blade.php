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
                <h1>Chi tiết kho hàng - {{ $product->TenSanPham }}</h1>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @elseif(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <h3>Thông tin kho hàng</h3>
                @php
                    $khoHang = $product->khoHang;
                @endphp
                <table class="table table-bordered">
                    <tr>
                        <th>Số lượng tồn</th>
                        <td>{{ $khoHang->SoLuongTon ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>Mức tồn kho tối thiểu</th>
                        <td>{{ $khoHang->MucToiThieu ?? 'Chưa đặt' }}</td>
                    </tr>
                    <tr>
                        <th>Ngày hết hạn</th>
                        <td>{{ $khoHang->NgayHetHan ?? 'Không có' }}</td>
                    </tr>
                </table>

                <h3>Điều chỉnh kho hàng</h3>
                <form action="{{ route('admin.warehouse.adjust', $product->MaSanPham) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="LoaiGiaoDich">Loại giao dịch</label>
                        <select name="LoaiGiaoDich" class="form-control" id="LoaiGiaoDich" required>
                            <option value="Nhap">Nhập kho</option>
                            <option value="Xuat">Xuất kho</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="SoLuong">Số lượng</label>
                        <input type="number" name="SoLuong" class="form-control" required min="1">
                    </div>
                    <div class="form-group" id="NhapKhoFields">
                        <label for="GiaNhap">Giá nhập</label>
                        <input type="number" name="GiaNhap" class="form-control" min="0" step="0.01">
                        <label for="NgayHetHan">Hạn sử dụng</label>
                        <input type="date" name="NgayHetHan" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="GhiChu">Ghi chú</label>
                        <textarea name="GhiChu" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật kho hàng</button>
                </form>


                <h3>Đặt mức tồn kho tối thiểu</h3>
                <form action="{{ route('admin.warehouse.set-minimum', $product->MaSanPham) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="MucToiThieu">Mức tối thiểu</label>
                        <input type="number" name="MucToiThieu" class="form-control" required min="0"
                            value="{{ $khoHang->MucToiThieu ?? 0 }}">
                    </div>
                    <button type="submit" class="btn btn-warning">Đặt mức tối thiểu</button>
                </form>

                <h3>Lịch sử nhập xuất kho</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Loại giao dịch</th>
                            <th>Số lượng</th>
                            <th>Ngày giao dịch</th>
                            <th>Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->lichSuKhoHang as $lichSu)
                            <tr>
                                <td>{{ $lichSu->LoaiGiaoDich }}</td>
                                <td>{{ $lichSu->SoLuong }}</td>
                                <td>{{ $lichSu->NgayGiaoDich }}</td>
                                <td>{{ $lichSu->GhiChu }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
    @section('scripts')
<script>
    $(document).ready(function() {
        function toggleNhapKhoFields() {
            if ($('#LoaiGiaoDich').val() == 'Nhap') {
                $('#NhapKhoFields').show();
            } else {
                $('#NhapKhoFields').hide();
            }
        }
        toggleNhapKhoFields();
        $('#LoaiGiaoDich').change(function() {
            toggleNhapKhoFields();
        });
    });
</script>
@endsection

</body>

</html>
