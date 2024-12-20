<!-- resources/views/user/shop/index.blade.php -->

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Cửa hàng">
    <meta name="keywords" content="Cửa hàng, sản phẩm, khuyến mãi">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa hàng</title>
    <!-- Line Awesome Icons -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css"
        integrity="sha512-m9hPrbV2Ih1M57e/0xjPSNHr1gYf1XJh8xIKRyYpIB0Mccp5mlqXu0JIzHm6qm/96nR7z9K3TttZUNPDb9eUnA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">
    @include('layouts.vendor-css')

    <!-- Thêm CSS cho nhãn giảm giá -->
    <style>
        .pagination {
            display: flex;
            list-style: none;
            padding-left: 0;
        }

        .pagination-gutter {
            gap: 5px;
        }

        .pagination .page-item {
            margin: 0 2px;
        }

        .pagination .page-link {
            display: block;
            padding: 8px 12px;
            color: #333;
            background-color: #f5f5f5;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }

        .pagination .page-link:hover {
            background-color: #007bff;
            color: #fff;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            color: #fff;
        }

        .pagination .page-item.disabled .page-link {
            color: #ccc;
            pointer-events: none;
        }

        .product__discount__percent {
            position: absolute;
            left: 0;
            top: 0;
            background: #e53637;
            color: #fff;
            padding: 5px 10px 10;
            font-size: 12px;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <!-- Page Preloader -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    @include('layouts.header')

    <!-- Hero Section Begin -->
    <section class="hero hero-normal">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>Tất cả danh mục</span>
                        </div>
                        <ul>
                            @foreach ($categories as $category)
                                <li><a
                                        href="{{ route('user.shop.index', ['category' => $category->MaDanhMuc]) }}">{{ $category->TenDanhMuc }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="{{ route('user.shop.index') }}" method="GET">
                                <div class="hero__search__categories">
                                    Tất cả
                                    <span class="arrow_carrot-down"></span>
                                </div>
                                <input type="text" name="search" placeholder="Bạn cần tìm gì?"
                                    value="{{ request('search') }}">
                                <button type="submit" class="site-btn">TÌM KIẾM</button>
                            </form>
                        </div>
                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <h5>0777526729</h5>
                                <span>Hỗ trợ 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Organi Shop</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.html">Home</a>
                            <span>Shop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item">
                            <h4>Danh mục</h4>
                            <ul>
                                @foreach ($categories as $category)
                                    <li><a
                                            href="{{ route('user.shop.index', ['category' => $category->MaDanhMuc]) }}">{{ $category->TenDanhMuc }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="sidebar__item">
                            <h4>Giá</h4>
                            <form action="{{ route('user.shop.index') }}" method="GET">
                                <!-- Giữ lại các tham số khác nếu có -->
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="category" value="{{ request('category') }}">
                                <div class="price-range-wrap">
                                    <div class="price-input">
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="number" name="price_min" placeholder="Giá thấp nhất"
                                                    value="{{ request('price_min', 0) }}">
                                            </div>
                                            <div class="col-6">
                                                <input type="number" name="price_max" placeholder="Giá cao nhất"
                                                    value="{{ request('price_max', 10000000) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="site-btn" style="margin-top: 10px;">Lọc giá</button>
                                </div>
                            </form>
                        </div>


                        <div class="sidebar__item">
                            <h4>Tình trạng</h4>
                            <div class="stock-filter">
                                <form action="{{ route('user.shop.index') }}" method="GET">
                                    <!-- Giữ lại các tham số tìm kiếm hiện tại -->
                                    @foreach (request()->except(['in_stock']) as $key => $value)
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endforeach
                                    <label>
                                        <input type="checkbox" name="in_stock" value="1"
                                            {{ request('in_stock') ? 'checked' : '' }} onchange="this.form.submit()">
                                        Chỉ hiển thị sản phẩm còn hàng
                                    </label>
                                </form>
                            </div>
                        </div>


                        <div class="sidebar__item sidebar__item__color--option">
                            <h4>Colors</h4>
                            <div class="sidebar__item__color sidebar__item__color--white">
                                <label for="white">
                                    White
                                    <input type="radio" id="white">
                                </label>
                            </div>
                            <div class="sidebar__item__color sidebar__item__color--gray">
                                <label for="gray">
                                    Gray
                                    <input type="radio" id="gray">
                                </label>
                            </div>
                            <div class="sidebar__item__color sidebar__item__color--red">
                                <label for="red">
                                    Red
                                    <input type="radio" id="red">
                                </label>
                            </div>
                            <div class="sidebar__item__color sidebar__item__color--black">
                                <label for="black">
                                    Black
                                    <input type="radio" id="black">
                                </label>
                            </div>
                            <div class="sidebar__item__color sidebar__item__color--blue">
                                <label for="blue">
                                    Blue
                                    <input type="radio" id="blue">
                                </label>
                            </div>
                            <div class="sidebar__item__color sidebar__item__color--green">
                                <label for="green">
                                    Green
                                    <input type="radio" id="green">
                                </label>
                            </div>
                        </div>
                        <!-- Latest Products Sidebar -->
                        <div class="sidebar__item">
                            <div class="latest-product__text">
                                <h4>Sản phẩm mới</h4>
                                <div class="latest-product__slider owl-carousel">
                                    @foreach ($latestProducts->chunk(3) as $chunk)
                                        <div class="latest-prdouct__slider__item">
                                            @foreach ($chunk as $product)
                                                <a href="{{ route('user.product-detail.show', $product->MaSanPham) }}"
                                                    class="latest-product__item">
                                                    <div class="latest-product__item__pic">
                                                        <img src="{{ asset('images/products/' . $product->HinhAnh) }}"
                                                            alt="{{ $product->TenSanPham }}">
                                                    </div>
                                                    <div class="latest-product__item__text">
                                                        <h6>{{ $product->TenSanPham }}</h6>
                                                        <span>{{ number_format($product->GiaBan, 0, ',', '.') }}
                                                            VNĐ</span>
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="col-lg-9 col-md-7">
                    @if ($discountedProducts->count() > 0)
                        <div class="product__discount">
                            <div class="section-title product__discount__title">
                                <h2>Sale Off</h2>
                            </div>
                            <div class="row">
                                <div class="product__discount__slider owl-carousel">
                                    @foreach ($discountedProducts as $product)
                                        @php
                                            // Lấy chương trình khuyến mãi đầu tiên
                                            $khuyenMai = $product->khuyenMais->first();
                                            // Tính phần trăm giảm giá
                                            $giamGia = $khuyenMai->pivot->giam_gia;
                                            // Tính giá sau khi giảm
                                            $giaGiam = $product->GiaBan - ($product->GiaBan * $giamGia) / 100;
                                        @endphp
                                        <div class="col-lg-4">
                                            <div class="product__discount__item">
                                                <div class="product__discount__item__pic set-bg"
                                                    data-setbg="{{ asset('images/products/' . $product->HinhAnh) }}">
                                                    <!-- Nhãn giảm giá -->
                                                    <div class="product__discount__percent">
                                                        -{{ number_format($giamGia, 0) }}%</div>
                                                    <ul class="product__item__pic__hover">
                                                        <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                                        <li><a href="javascript:void(0);"
                                                                onclick="addToCart({{ $product->MaSanPham }})">
                                                                <i class="fa fa-shopping-cart"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <!-- Liên kết tới trang chi tiết sản phẩm -->
                                                    <a href="{{ route('user.product-detail.show', $product->MaSanPham) }}"
                                                        class="product-link"></a>
                                                </div>
                                                <div class="product__discount__item__text">
                                                    <span>{{ $product->danhMuc->TenDanhMuc ?? '' }}</span>
                                                    <h5><a
                                                            href="{{ route('user.product-detail.show', $product->MaSanPham) }}">{{ $product->TenSanPham }}</a>
                                                    </h5>
                                                    <div class="product__item__price">
                                                        {{ number_format($giaGiam, 0, ',', '.') }} VNĐ
                                                        <span>{{ number_format($product->GiaBan, 0, ',', '.') }}
                                                            VNĐ</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="filter__item">
                        <div class="row">
                            <!-- Sắp xếp -->
                            <div class="col-lg-4 col-md-5">
                                <div class="filter__sort">
                                    <span>Sắp xếp</span>
                                    <form action="{{ route('user.shop.index') }}" method="GET" id="sortForm">
                                        <!-- Giữ lại các tham số khác nếu có -->
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                        <input type="hidden" name="category" value="{{ request('category') }}">
                                        <input type="hidden" name="price_min" value="{{ request('price_min') }}">
                                        <input type="hidden" name="price_max" value="{{ request('price_max') }}">
                                        <select name="sort"
                                            onchange="document.getElementById('sortForm').submit();">
                                            <option value="">Mặc định</option>
                                            <option value="name_asc"
                                                {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
                                            <option value="name_desc"
                                                {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên Z-A</option>
                                            <option value="price_asc"
                                                {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần
                                            </option>
                                            <option value="price_desc"
                                                {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần
                                            </option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                            <!-- Số lượng sản phẩm tìm thấy -->
                            <div class="col-lg-4 col-md-4">
                                <div class="filter__found">
                                    <h6><span>{{ $products->total() }}</span> sản phẩm được tìm thấy</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @forelse ($products as $product)
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg"
                                        data-setbg="{{ asset('images/products/' . $product->HinhAnh) }}">
                                        <ul class="product__item__pic__hover">
                                            <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                            <li><a href="javascript:void(0);"
                                                    onclick="addToCart({{ $product->MaSanPham }})">
                                                    <i class="fa fa-shopping-cart"></i>
                                                </a></li>
                                        </ul>
                                        <!-- Liên kết tới trang chi tiết sản phẩm -->
                                        <a href="{{ route('user.product-detail.show', $product->MaSanPham) }}"
                                            class="product-link"></a>
                                    </div>
                                    <div class="product__item__text">
                                        <h6><a
                                                href="{{ route('user.product-detail.show', $product->MaSanPham) }}">{{ $product->TenSanPham }}</a>
                                        </h6>
                                        <h5>{{ number_format($product->GiaBan, 0, ',', '.') }} VNĐ</h5>
                                        <p class="stock-info">
                                            @php
                                                $totalStock = $product->loHang->sum('so_luong');
                                            @endphp
                                            @if ($totalStock > 0)
                                                <span class="text-success">Còn {{ $totalStock }} sản phẩm</span>
                                            @else
                                                <span class="text-danger">Hết hàng</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>Không tìm thấy sản phẩm nào.</p>
                        @endforelse
                    </div>
                    @if ($products->hasPages())
                        <nav>
                            <ul class="pagination pagination-gutter" style="place-content: center;">
                                {{-- Nút "Trang trước" --}}
                                @if ($products->onFirstPage())
                                    <li class="page-item page-indicator disabled">
                                        <a class="page-link" href="javascript:void(0)">
                                            <i class="fa fa-angle-left"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item page-indicator">
                                        <a class="page-link" href="{{ $products->previousPageUrl() }}">
                                            <i class="fa fa-angle-left"></i>
                                        </a>
                                    </li>
                                @endif

                                {{-- Hiển thị trang đầu nếu cần --}}
                                @if ($products->currentPage() > 3)
                                    <li class="page-item"><a class="page-link" href="{{ $products->url(1) }}">1</a>
                                    </li>
                                    @if ($products->currentPage() > 4)
                                        <li class="page-item disabled"><a class="page-link" href="#">...</a>
                                        </li>
                                    @endif
                                @endif

                                {{-- Hiển thị các trang xung quanh trang hiện tại --}}
                                @for ($page = max($products->currentPage() - 2, 1); $page <= min($products->currentPage() + 2, $products->lastPage()); $page++)
                                    @if ($page == $products->currentPage())
                                        <li class="page-item active"><a class="page-link"
                                                href="javascript:void(0)">{{ $page }}</a></li>
                                    @else
                                        <li class="page-item"><a class="page-link"
                                                href="{{ $products->url($page) }}">{{ $page }}</a></li>
                                    @endif
                                @endfor

                                {{-- Hiển thị trang cuối nếu cần --}}
                                @if ($products->currentPage() < $products->lastPage() - 2)
                                    @if ($products->currentPage() < $products->lastPage() - 3)
                                        <li class="page-item disabled"><a class="page-link" href="#">...</a>
                                        </li>
                                    @endif
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $products->url($products->lastPage()) }}">{{ $products->lastPage() }}</a>
                                    </li>
                                @endif

                                {{-- Nút "Trang sau" --}}
                                @if ($products->hasMorePages())
                                    <li class="page-item page-indicator">
                                        <a class="page-link" href="{{ $products->nextPageUrl() }}">
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item page-indicator disabled">
                                        <a class="page-link" href="javascript:void(0)">
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    @endif

                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->

    @include('layouts.footer')
    @include('layouts.vendor-js')

    <!-- Script để thay đổi hình nền theo class set-bg và khởi tạo carousel -->
    <script>
        $(document).ready(function() {
            // Thay đổi hình nền
            $('.set-bg').each(function() {
                var bg = $(this).data('setbg');
                $(this).css('background-image', 'url(' + bg + ')');
            });

            // Khởi tạo carousel cho sản phẩm khuyến mãi
            $('.product__discount__slider').owlCarousel({
                loop: true,
                margin: 20,
                items: 3,
                dots: true,
                smartSpeed: 1200,
                autoHeight: false,
                autoplay: true,
                responsive: {
                    320: {
                        items: 1,
                    },
                    480: {
                        items: 2,
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 3,
                    }
                }
            });
        });
    </script>
    <script>
        function addToCart(MaSanPham, stockQuantity) {
            if (stockQuantity <= 0) {
                alert('Sản phẩm đã hết hàng!');
                return;
            }

            fetch(`/cart/add/${MaSanPham}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message || 'Sản phẩm đã được thêm vào giỏ hàng!');
                    window.location.href = '/cart';
                })

                window.location.href = '/cart';

        }
    </script>
</body>
<style>
    /* CSS cho phần hero search */
    .hero__search__form {
        width: 100%;
        height: 50px;
        border: 1px solid #ebebeb;
        position: relative;
        border-radius: 5px;
    }

    .hero__search__categories {
        position: relative;
        padding: 0 30px;
        cursor: pointer;
        height: 100%;
        display: flex;
        align-items: center;
        background: #f5f5f5;
        border-right: 1px solid #ebebeb;
    }

    .hero__search__categories span {
        margin-right: 10px;
    }

    .hero__search__form form {
        width: 100%;
        display: flex;
    }

    .hero__search__form input {
        width: 100%;
        border: none;
        padding-left: 20px;
        font-size: 15px;
        color: #333;
        height: 48px;
    }

    .hero__search__form button {
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
    }

    /* CSS cho phần filter và sidebar */
    .sidebar {
        padding: 30px;
        border-radius: 5px;
        background: #f5f5f5;
    }

    .sidebar__item {
        margin-bottom: 35px;
    }

    .sidebar__item h4 {
        color: #1c1c1c;
        font-weight: 700;
        margin-bottom: 25px;
    }

    .sidebar__item ul li {
        list-style: none;
        line-height: 40px;
    }

    .sidebar__item ul li a {
        font-size: 16px;
        color: #666666;
        line-height: 39px;
        display: block;
        transition: all 0.3s;
    }

    .sidebar__item ul li a:hover {
        color: #7fad39;
        padding-left: 10px;
    }

    /* CSS cho phần price filter */
    .price-range-wrap {
        padding: 20px;
        background: #ffffff;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .price-input {
        margin-bottom: 20px;
    }

    .price-input input {
        width: 100%;
        height: 40px;
        border: 1px solid #ebebeb;
        border-radius: 5px;
        padding: 0 15px;
        margin-bottom: 10px;
    }

    .filter__sort {
        padding: 10px;
        background: #ffffff;
        border-radius: 5px;
        display: flex;
        align-items: center;
    }

    .filter__sort span {
        font-size: 16px;
        color: #6f6f6f;
        margin-right: 15px;
    }

    .filter__sort select {
        border: 1px solid #ebebeb;
        border-radius: 4px;
        padding: 5px 10px;
        min-width: 150px;
    }

    .stock-info {
        margin-top: 8px;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .text-success {
        color: #28a745;
        padding: 4px 8px;
        border-radius: 4px;
        background-color: rgba(40, 167, 69, 0.1);
    }

    .text-danger {
        color: #dc3545;
        padding: 4px 8px;
        border-radius: 4px;
        background-color: rgba(220, 53, 69, 0.1);
    }

    .stock-filter {
        padding: 15px;
        background: #ffffff;
        border-radius: 5px;
    }

    .stock-filter label {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }
</style>

</html>
