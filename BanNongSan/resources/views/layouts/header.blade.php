<!-- Humberger Begin -->
<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
        <a href="#"><img src="{{ asset('assets/img/logo.png') }}" alt="Logo"></a>
    </div>
    <div class="humberger__menu__cart">
        <ul>
            <li><a href="{{ route('cart.index') }}"><i class="fa fa-shopping-bag"></i>
                    <span>{{ $cartCount }}</span></a></li>
        </ul>
        <div class="header__cart__price">Tổng: <span>{{ number_format($cartTotal, 0, ',', '.') }} VNĐ</span></div>
    </div>
    <div class="humberger__menu__widget">
        <div class="header__top__right__language">
            <img src="img/language.png" alt="">
            <div>English</div>
            <span class="arrow_carrot-down"></span>
            <ul>
                <li><a href="#">VietNamese</a></li>
                <li><a href="#">English</a></li>
            </ul>
        </div>
        <div class="header__top__right__auth">
            @if (Auth::check())
                <div class="header__top__right__language">
                    <div>{{ Auth::user()->HoTen }}</div>
                    <span class="arrow_carrot-down"></span>
                    <ul>
                        <li><a href="#">Quản lý tài khoản</a></li>
                        <li>
                            <a href="{{ route('auth.logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Đăng xuất
                            </a>
                            <form id="logout-form" action="{{ route('auth.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('auth.login.index') }}"><i class="fa fa-user"></i> Login</a>
            @endif
        </div>

    </div>
    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li class="active"><a href="{{ route('welcome') }}">Home</a>
            </li>
            <li><a href="{{ route('user.shop.index') }}">Shop</a></li>
            <li><a href="#">Pages</a>
                <ul class="header__menu__dropdown">
                    <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                </ul>
            </li>
            <li><a href="{{ route('user.blog.index') }}">Blog</a></li>
            <li><a href="./contact.html">Contact</a></li>
        </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    <div class="header__top__right__social">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-linkedin"></i></a>
        <a href="#"><i class="fa fa-pinterest-p"></i></a>
    </div>
    <div class="humberger__menu__contact">
        <ul>
            <li><i class="fa fa-envelope"></i>homykim@gmail.com</li>
        </ul>
    </div>
</div>
<!-- Humberger End -->

<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fa fa-envelope"></i>homykim@gmail.com</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <!-- Phần header của bạn -->
                    <div class="header__top__right">
                        <div class="header__top__right__auth">
                            @if (Auth::check())
                                <div class="header__top__right__language">
                                    <img src="{{ asset('assets/img/user_icon.png') }}" alt="">
                                    <div>{{ Auth::user()->TenDangNhap }} <span class="arrow_carrot-down"></span></div>
                                    <ul>
                                        <!-- Các mục trong menu dropdown -->
                                        <li><a href="{{ route('user.account.orders') }}">Lịch sử đơn hàng</a></li>
                                        <li><a href="{{ route('user.account.trackOrder') }}">Tình trạng đơn hàng</a>
                                        </li>
                                        <li><a href="{{ route('user.account.editProfile') }}">Đổi thông tin tài
                                                khoản</a></li>
                                        <li><a href="{{ route('user.account.changePassword') }}">Đổi mật khẩu</a></li>
                                        @if (Auth::user()->MaVaiTro == 2 || Auth::user()->MaVaiTro == 3)
                                            <li><a href="{{ route('admin.dashboard') }}">Trang quản trị</a></li>
                                        @endif
                                        <li><a href="{{ route('auth.logout') }}">Đăng xuất</a></li>
                                    </ul>
                                </div>
                            @else
                                <a href="{{ route('auth.login.index') }}"><i class="fa fa-user"></i> Đăng nhập</a>
                                <a href="{{ route('auth.register.index') }}"><i class="fa fa-user-plus"></i> Đăng
                                    ký</a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a href="/"><img src="{{ asset('assets/img/logo.png') }}" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">
                    <ul>
                        <li class="active"><a href="/">Trang Chủ</a></li>
                        <li><a href="{{ route('user.shop.index') }}">Cửa Hàng</a></li>
                        <li><a href="#">Pages</a>
                            <ul class="header__menu__dropdown">
                                <li><a href="{{ route('user.shopping-cart.index') }}">Giỏ Hàng</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ route('user.blog.index') }}">Blog</a></li>
                        <li><a href="./contact.html">Liên Hệ</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        <li><a href="{{ route('cart.index') }}"><i class="fa fa-shopping-bag"></i>
                                <span>{{ $cartCount }}</span></a></li>
                    </ul>
                    <div class="header__cart__price">Tổng: <span>{{ number_format($cartTotal, 0, ',', '.') }}
                            VNĐ</span></div>
                </div>

            </div>
        </div>
        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header Section End -->
