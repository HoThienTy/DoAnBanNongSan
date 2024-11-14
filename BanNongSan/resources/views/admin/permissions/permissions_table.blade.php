<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mã Quyền</th>
            <th>Tên Quyền</th>
            <th>Hành Động</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($permissions as $permission)
            <tr>
                <td>{{ $permission->MaQuyen }}</td>
                <td>{{ $permission->TenQuyen }}</td>
                <td>
                    <a href="{{ route('permissions.edit', $permission->MaQuyen) }}" class="btn btn-sm btn-warning">Chỉnh Sửa</a>
                    <form action="{{ route('permissions.destroy', $permission->MaQuyen) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa quyền này?')">Xóa</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">Không tìm thấy quyền nào.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Phân trang -->
<!-- Hiển thị phân trang tùy chỉnh --> 
@if ($permissions->hasPages())
    <nav>
        <ul class="pagination pagination-gutter justify-content-center">
            {{-- Nút "Trang trước" --}}
            @if ($permissions->onFirstPage())
                <li class="page-item page-indicator disabled">
                    <a class="page-link" href="javascript:void(0)">
                        <i class="la la-angle-left"></i>
                    </a>
                </li>
            @else
                <li class="page-item page-indicator">
                    <a class="page-link" href="{{ $permissions->previousPageUrl() }}">
                        <i class="la la-angle-left"></i>
                    </a>
                </li>
            @endif

            {{-- Hiển thị trang đầu nếu cần --}}
            @if ($permissions->currentPage() > 3)
                <li class="page-item"><a class="page-link" href="{{ $permissions->url(1) }}">1</a></li>
                @if ($permissions->currentPage() > 4)
                    <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                @endif
            @endif

            {{-- Hiển thị các trang xung quanh trang hiện tại --}}
            @for ($page = max($permissions->currentPage() - 2, 1); $page <= min($permissions->currentPage() + 2, $permissions->lastPage()); $page++)
                @if ($page == $permissions->currentPage())
                    <li class="page-item active"><a class="page-link" href="javascript:void(0)">{{ $page }}</a></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $permissions->url($page) }}">{{ $page }}</a></li>
                @endif
            @endfor

            {{-- Hiển thị trang cuối nếu cần --}}
            @if ($permissions->currentPage() < $permissions->lastPage() - 2)
                @if ($permissions->currentPage() < $permissions->lastPage() - 3)
                    <li class="page-item disabled"><a class="page-link" href="#">...</a></li>
                @endif
                <li class="page-item"><a class="page-link" href="{{ $permissions->url($permissions->lastPage()) }}">{{ $permissions->lastPage() }}</a></li>
            @endif

            {{-- Nút "Trang sau" --}}
            @if ($permissions->hasMorePages())
                <li class="page-item page-indicator">
                    <a class="page-link" href="{{ $permissions->nextPageUrl() }}">
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