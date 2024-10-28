@extends('layouts.admin_layout')

@section('content')
<div class="admin-users">
    <h1>Users</h1>
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Date Registered</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dữ liệu tĩnh mẫu -->
            <tr>
                <td>1</td>
                <td>Jane Smith</td>
                <td>jane.smith@example.com</td>
                <td>User</td>
                <td>15-09-2023</td>
                <td>
                    <a href="#" class="admin-btn-edit">Edit</a>
                </td>
            </tr>
            <!-- Thêm các người dùng mẫu khác -->
        </tbody>
    </table>
</div>
@endsection
