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
            <!-- Thêm các danh mục mẫu khác -->
        </tbody>
    </table>
</div>
@endsection
