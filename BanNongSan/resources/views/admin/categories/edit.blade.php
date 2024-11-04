@extends('layouts.admin_layout')

@section('content')
    <div class="admin-categories">
        <h1>Categories</h1>
        <a href="#" class="admin-btn">Add New Category</a>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dữ liệu tĩnh mẫu -->
                <tr>
                    <td>1</td>
                    <td>Fruits</td>
                    <td>
                        <a href="#" class="admin-btn-edit">Edit</a>
                        <a href="#" class="admin-btn-delete">Delete</a>
                    </td>
                </tr>
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
                                <h1>Chỉnh sửa danh mục</h1>
                            
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            
                                <form action="{{ route('admin.categories.update', $category->MaDanhMuc) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="TenDanhMuc">Tên danh mục</label>
                                        <input type="text" name="TenDanhMuc" class="form-control" value="{{ $category->TenDanhMuc }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-success">Cập nhật danh mục</button>
                                </form>
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
                <!-- Thêm các danh mục mẫu khác -->
            </tbody>
        </table>
    </div>
@endsection
