@extends('layouts.admin_layout')

@section('content')
<div class="admin-products">
    <h1>Products</h1>
    <a href="#" class="admin-btn">Add New Product</a>
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price (VNĐ)</th>
                <th>Category</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dữ liệu tĩnh mẫu -->
            <tr>
                <td>1</td>
                <td><img src="{{ asset('assets/img/products/product-1.jpg') }}" alt="Product Image"></td>
                <td>Organic Apple</td>
                <td>50,000</td>
                <td>Fruits</td>
                <td>100</td>
                <td>
                    <a href="#" class="admin-btn-edit">Edit</a>
                    <a href="#" class="admin-btn-delete">Delete</a>
                </td>
            </tr>
            <!-- Thêm các sản phẩm mẫu khác -->
        </tbody>
    </table>
</div>
@endsection
