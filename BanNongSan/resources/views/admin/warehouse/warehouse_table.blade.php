<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mã sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng tồn</th>
            <th>Mức tối thiểu</th>
            <th>Ngày hết hạn gần nhất</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
            @php
                // Tính tổng số lượng tồn kho từ các lô hàng
                $tongSoLuongTon = $product->loHang->sum('so_luong');
                $mucToiThieu = $product->khoHang->MucToiThieu ?? 0;
                $status = '';

                // Kiểm tra số lượng tồn kho so với mức tối thiểu
                if ($tongSoLuongTon <= $mucToiThieu) {
                    $status .=
                        '<span class="badge badge-danger" data-toggle="tooltip" title="Số lượng tồn kho dưới mức tối thiểu">Tồn kho thấp</span> ';
                }

                // Lấy ngày hết hạn gần nhất
                $ngayHetHanGanNhat = $product->loHang()->where('so_luong', '>', 0)->min('han_su_dung');

                // Kiểm tra xem có lô hàng nào sắp hết hạn trong vòng 2 ngày tới không
                if ($ngayHetHanGanNhat) {
                    $ngayHetHanGanNhatCarbon = \Carbon\Carbon::parse($ngayHetHanGanNhat);
                    $now = \Carbon\Carbon::now();

                    // Kiểm tra xem sản phẩm đã hết hạn hay chưa
                    if ($ngayHetHanGanNhatCarbon->lt($now)) {
                        // Đã hết hạn
                        $status .= '<span class="badge badge-danger" data-toggle="tooltip" title="Sản phẩm đã hết hạn">Đã hết hạn</span>';
                    }
                    // Kiểm tra xem có lô hàng nào sắp hết hạn trong vòng 2 ngày tới không
                    elseif ($ngayHetHanGanNhatCarbon->between($now, $now->copy()->addDays(2))) {
                        $status .= '<span class="badge badge-warning" data-toggle="tooltip" title="Có lô hàng sắp hết hạn">Sắp hết hạn</span>';
                    }
                }

            @endphp
            <tr>
                <td>{{ $product->MaSanPham }}</td>
                <td>{{ $product->TenSanPham }}</td>
                <td>{{ $tongSoLuongTon }}</td>
                <td>{{ $mucToiThieu }}</td>
                <td>{{ $ngayHetHanGanNhat ? \Carbon\Carbon::parse($ngayHetHanGanNhat)->format('d/m/Y') : 'Không có' }}
                </td>
                <td>{!! $status ?: '<span class="badge badge-success">Ổn định</span>' !!}</td>
                <td>
                    <a href="{{ route('admin.warehouse.show', $product->MaSanPham) }}" class="btn btn-info">Chi tiết</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- Hiển thị phân trang tùy chỉnh --> 
@if ($products->hasPages())
    <nav>
        <ul class="pagination pagination-gutter justify-content-center">
            {{-- Nút "Trang trước" --}}
            @if ($products->onFirstPage())
                <li class="page-item page-indicator disabled">
                    <a class="page-link" href="javascript:void(0)">
                        <i class="la la-angle-left"></i>
                    </a>
                </li>
            @else
                <li class="page-item page-indicator">
                    <a class="page-link" href="{{ $products->previousPageUrl() }}">
                        <i class="la la-angle-left"></i>
                    </a>
                </li>
            @endif

            {{-- Hiển thị trang đầu nếu cần --}}
            @if ($products->currentPage() > 3)
                <li class="page-item"><a class="page-link" href="{{ $products->url(1) }}">1</a></li>
                @if ($products->currentPage() > 4)
                    <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                @endif
            @endif

            {{-- Hiển thị các trang xung quanh trang hiện tại --}}
            @for ($page = max($products->currentPage() - 2, 1); $page <= min($products->currentPage() + 2, $products->lastPage()); $page++)
                @if ($page == $products->currentPage())
                    <li class="page-item active"><a class="page-link" href="javascript:void(0)">{{ $page }}</a></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $products->url($page) }}">{{ $page }}</a></li>
                @endif
            @endfor

            {{-- Hiển thị trang cuối nếu cần --}}
            @if ($products->currentPage() < $products->lastPage() - 2)
                @if ($products->currentPage() < $products->lastPage() - 3)
                    <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                @endif
                <li class="page-item"><a class="page-link" href="{{ $products->url($products->lastPage()) }}">{{ $products->lastPage() }}</a></li>
            @endif

            {{-- Nút "Trang sau" --}}
            @if ($products->hasMorePages())
                <li class="page-item page-indicator">
                    <a class="page-link" href="{{ $products->nextPageUrl() }}">
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
