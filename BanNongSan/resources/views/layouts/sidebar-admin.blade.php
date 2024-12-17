<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="dropdown header-profile">
                @if (Auth::check())
                    <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                        <div class="header-info ms-3">
                            <span class="font-w600">Hi,{{ Auth::user()->HoTen }}</span>
                            <small class="text-end font-w400">{{ Auth::user()->Email }}</small>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="#" class="dropdown-item ai-icon">
                            <!-- Icon -->
                            <span class="ms-2">Profile</span>
                        </a>
                        <a href="{{ route('auth.logout') }}" class="dropdown-item ai-icon"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Đăng xuất
                            </a>
                            <form id="logout-form" action="{{ route('auth.logout') }}" method="GET"
                                style="display: none;">
                                @csrf
                            </form>
                    </div>
                @else
                    <a class="nav-link" href="{{ route('auth.login.index') }}">
                        <div class="header-info ms-3">
                            <span class="font-w600">Hi,<b>Guest</b></span>
                            <small class="text-end font-w400">Please login</small>
                        </div>
                    </a>
                @endif
            </li>

            <li><a href="{{ route('admin.dashboard') }}" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-025-dashboard"></i>
                    <span class="nav-text">Trang Chủ</span>
                </a>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-user"></i>
                    <span class="nav-text">Quản Lý Người Dùng</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.users.index') }}">Danh Sách Người Dùng</a></li>
                    <li><a href="{{ route('admin.users.create') }}">Thêm Người Dùng</a></li>
                </ul>
            </li>

            <!-- Báo Cáo Thống Kê -->
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-041-graph"></i>
                    <span class="nav-text">Báo Cáo Thống Kê</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.reports.cancelled_products') }}">Hàng hủy</a></li>
                    <li><a href="{{ route('admin.reports.revenue') }}">Doanh thu</a></li>
                    <li><a href="{{ route('admin.reports.inventory') }}">Tồn kho</a></li>
                    <li><a href="{{ route('admin.reports.best_selling_products') }}">Sản phẩm bán chạy</a></li>
                </ul>
            </li>

            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-list"></i>
                    <span class="nav-text">Quản Lý Đơn Hàng</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.orders.index') }}">Danh sách đơn hàng</a></li>
                </ul>
            </li>

            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-location"></i>
                    <span class="nav-text">Quản Lý Giao Hàng</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.delivery.index') }}">Danh sách giao hàng</a></li>
                </ul>
            </li>

            <!-- Quản Lý Nhà Cung Cấp -->
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-share"></i>
                    <span class="nav-text">Quản Lý Nhà Cung Cấp</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.suppliers.index') }}">Danh sách nhà cung cấp</a></li>
                    <li><a href="{{ route('admin.suppliers.create') }}">Thêm nhà cung cấp</a></li>
                </ul>
            </li>

            <!-- Quản Lý Đặt Hàng -->
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-notebook"></i>
                    <span class="nav-text">Quản Lý Đặt Hàng</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.purchase_orders.index') }}">Danh sách phiếu đặt hàng</a></li>
                    <li><a href="{{ route('admin.purchase_orders.create') }}">Thêm phiếu đặt hàng</a></li>
                </ul>
            </li>

            <li><a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                    <i class="flaticon-381-id-card"></i>
                    <span class="nav-text">Quản Lý Sản Phẩm</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.products.index') }}">Danh sách sản phẩm</a></li>
                    <li><a href="{{ route('admin.products.create') }}">Thêm sản phẩm</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                    <i class="flaticon-381-folder"></i>
                    <span class="nav-text">Quản Lý Danh Mục</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.categories.index') }}">Danh sách danh mục</a></li>
                    <li><a href="{{ route('admin.categories.create') }}">Thêm danh mục</a></li>
                </ul>
            </li>

            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                    <i class="flaticon-381-home"></i>
                    <span class="nav-text">Quản Lý Kho</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.warehouse.index') }}">Danh sách kho hàng</a></li>
                </ul>
            </li>

            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                    <i class="flaticon-381-list"></i>
                    <span class="nav-text">Quản Lý Lô Hàng</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.batch.index') }}">Danh sách lô hàng</a></li>
                    <li><a href="{{ route('admin.batch.create') }}">Thêm lô hàng mới</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                    <i class="flaticon-381-error"></i>
                    <span class="nav-text">Quản Lý Hủy Hàng</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.cancellation.index') }}">Danh sách hủy hàng</a></li>
                    <li><a href="{{ route('admin.cancellation.create') }}">Ghi nhận hủy hàng</a></li>
                </ul>
            </li>


            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-promotion"></i>
                    <span class="nav-text">Quản Lý Khuyến Mãi</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.promotions.index') }}">Danh sách khuyến mãi</a></li>
                    <li><a href="{{ route('admin.promotions.create') }}">Khuyến mãi theo sản phẩm</a></li>
                    <li><a href="{{ route('admin.promotions.createcoupon') }}">Thêm Mã khuyến mãi</a></li>
                    <li><a href="{{ route('admin.promotions.addCouponToBatchPage') }}">Thêm Mã Khuyến Mãi vào Lô Hàng</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                    <i class="flaticon-381-key"></i> <!-- Thay icon phù hợp -->
                    <span class="nav-text">Quản Lý Quyền</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('permissions.index') }}">Danh Sách Quyền</a></li>
                    <li><a href="{{ route('permissions.create') }}">Thêm Quyền Mới</a></li>
                    <li><a href="{{ route('permissions.assign.form') }}">Phân Quyền</a></li>
                    <li><a href="{{ route('permissions.assign.user.form') }}">Phân Quyền Người Dùng</a></li> <!-- Mục mới -->
                </ul>
            </li>



        </ul>
    </div>
</div>
