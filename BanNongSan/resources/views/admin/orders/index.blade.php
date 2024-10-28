@extends('layouts.admin_layout')

@section('content')
<div class="admin-orders">
    <h1>Orders</h1>
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Total Amount (VNĐ)</th>
                <th>Status</th>
                <th>Date Ordered</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Dữ liệu tĩnh mẫu -->
            <tr>
                <td>1</td>
                <td>John Doe</td>
                <td>150,000</td>
                <td>Pending</td>
                <td>01-10-2023</td>
                <td>
                    <a href="#" class="admin-btn-view">View</a>
                </td>
            </tr>
            <!-- Thêm các đơn hàng mẫu khác -->
        </tbody>
    </table>
</div>
@endsection
