<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mã sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Danh mục</th>
            <th>Giá bán</th>
            <th>Hình ảnh</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @if($products->count() > 0)
            @foreach($products as $product)
            <tr>
                <td>{{ $product->MaSanPham }}</td>
                <td>{{ $product->TenSanPham }}</td>
                <td>{{ $product->danhMuc->TenDanhMuc ?? 'Không có' }}</td>
                <td>{{ number_format($product->GiaBan, 0, ',', '.') }} VND</td>
                <td>
                    @if($product->HinhAnh)
                        <img src="{{ asset('images/products/'.$product->HinhAnh) }}" alt="{{ $product->TenSanPham }}" style="object-fit: cover" width="100" height="60">
                    @else
                        Không có hình ảnh
                    @endif
                </td>
                <td>{{ $product->NgayTao }}</td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->MaSanPham) }}" class="btn btn-warning">Chỉnh sửa</a>
                    <form action="{{ route('admin.products.destroy', $product->MaSanPham) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" class="text-center">Không tìm thấy sản phẩm phù hợp.</td>
            </tr>
        @endif
    </tbody>
</table>

<!-- Hiển thị phân trang tùy chỉnh -->
@if ($products->hasPages())
    <nav>
        <ul class="pagination pagination-gutter" style="place-content: center;">
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