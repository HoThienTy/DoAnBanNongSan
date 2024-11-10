<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="dropdown header-profile">
                @if (Auth::check())
                    <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                        <img src="{{ asset('images/profile/pic1.jpg') }}" width="20" alt="">
                        <div class="header-info ms-3">
                            <span class="font-w600">Hi,<b>{{ Auth::user()->HoTen }}</b></span>
                            <small class="text-end font-w400">{{ Auth::user()->Email }}</small>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="#" class="dropdown-item ai-icon">
                            <!-- Icon -->
                            <span class="ms-2">Profile</span>
                        </a>
                        <a href="#" class="dropdown-item ai-icon"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <!-- Icon -->
                            <span class="ms-2">Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('auth.logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </div>
                @else
                    <a class="nav-link" href="{{ route('auth.login.index') }}">
                        <img src="{{ asset('images/profile/default.jpg') }}" width="20" alt="">
                        <div class="header-info ms-3">
                            <span class="font-w600">Hi,<b>Guest</b></span>
                            <small class="text-end font-w400">Please login</small>
                        </div>
                    </a>
                @endif
            </li>

            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-025-dashboard"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="index.html">Dashboard Light</a></li>
                    <li><a href="index-2.html">Dashboard Dark</a></li>
                    <li><a href="my-wallet.html">My Wallet</a></li>
                    <li><a href="page-invoices.html">Invoices</a></li>
                    <li><a href="cards-center.html">Cards Center</a></li>
                    <li><a href="page-transaction.html">Transaction</a></li>
                    <li><a href="transaction-details.html">Transaction Details</a></li>
                </ul>

            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-050-info"></i>
                    <span class="nav-text">Quản Lý Người Dùng</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.users.index') }}">Danh Sách Người Dùng</a></li>
                    <li><a href="{{ route('admin.users.create') }}">Thêm Người Dùng</a></li>
                </ul>
            </li>

            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-041-graph"></i>
                    <span class="nav-text">Báo Cáo Thống Kê</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="chart-flot.html">Flot</a></li>
                    <li><a href="chart-morris.html">Morris</a></li>
                    <li><a href="chart-chartjs.html">Chartjs</a></li>
                    <li><a href="chart-chartist.html">Chartist</a></li>
                    <li><a href="chart-sparkline.html">Sparkline</a></li>
                    <li><a href="chart-peity.html">Peity</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Quản Lý Đơn Hàng</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.orders.index') }}">Danh sách đơn hàng</a></li>
                </ul>
            </li>
            
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-folder"></i>
                    <span class="nav-text">Quản Lý Giao Hàng</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.delivery.index') }}">Danh sách giao hàng</a></li>
                </ul>
            </li>
            
            <li><a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                    <i class="flaticon-045-heart"></i>
                    <span class="nav-text">Quản Lý Sản Phẩm</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.products.index') }}">Danh sách sản phẩm</a></li>
                    <li><a href="{{ route('admin.products.create') }}">Thêm sản phẩm</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                    <i class="flaticon-013-checkmark"></i>
                    <span class="nav-text">Quản Lý Danh Mục</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.categories.index') }}">Danh sách danh mục</a></li>
                    <li><a href="{{ route('admin.categories.create') }}">Thêm danh mục</a></li>
                </ul>
            </li>

            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0)" aria-expanded="false">
                    <i class="flaticon-013-checkmark"></i>
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
                    <i class="flaticon-043-menu"></i>
                    <span class="nav-text">Quản Lý Khuyến Mãi</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('admin.promotions.index') }}">Danh sách khuyến mãi</a></li>
                    <li><a href="{{ route('admin.promotions.create') }}">Khuyến mãi theo sản phẩm</a></li>
                    <li><a href="{{ route('admin.promotions.createcoupon') }}">Thêm Mã khuyến mãi</a></li>
                </ul>
            </li>
            
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-022-copy"></i>
                    <span class="nav-text">Pages</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="page-login.html">Login</a></li>
                    <li><a href="page-register.html">Register</a></li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Error</a>
                        <ul aria-expanded="false">
                            <li><a href="page-error-400.html">Error 400</a></li>
                            <li><a href="page-error-403.html">Error 403</a></li>
                            <li><a href="page-error-404.html">Error 404</a></li>
                            <li><a href="page-error-500.html">Error 500</a></li>
                            <li><a href="page-error-503.html">Error 503</a></li>
                        </ul>
                    </li>
                    <li><a href="page-lock-screen.html">Lock Screen</a></li>
                    <li><a href="empty-page.html">Empty Page</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
