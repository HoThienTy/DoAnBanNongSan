<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Các thẻ meta và link CSS -->
    @include('layouts.vendor-admin-css')
</head>
<body>
    <div id="main-wrapper">
        <!-- Nav header, Header, Sidebar -->
        @include('layouts.header-admin')
        @include('layouts.sidebar-admin')

        <!-- Content body start -->
        <div class="content-body">
            <div class="container-fluid">
                <h1>Ghi nhận sản phẩm bị hủy</h1>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @elseif(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('admin.cancellation.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="ma_lo_hang">Chọn lô hàng:</label>
                        <select name="ma_lo_hang" id="ma_lo_hang" class="form-control">
                            @foreach($batches as $batch)
                                <option value="{{ $batch->ma_lo_hang }}">{{ $batch->ma_lo_hang }} - {{ $batch->sanPham->TenSanPham }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="so_luong">Số lượng:</label>
                        <input type="number" name="so_luong" id="so_luong" class="form-control" min="1" required>
                    </div>

                    <div class="form-group">
                        <label for="ngay_huy">Ngày hủy:</label>
                        <input type="date" name="ngay_huy" id="ngay_huy" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="ly_do">Lý do:</label>
                        <input type="text" name="ly_do" id="ly_do" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Ghi nhận</button>
                </form>
            </div>
        </div>
        <!-- Content body end -->
    </div>
    <!-- Scripts -->
    @include('layouts.vendor-admin-js')
</body>
</html>
