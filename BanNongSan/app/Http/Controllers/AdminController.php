<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Ở đây chúng ta đang sử dụng dữ liệu tĩnh, bạn có thể thay thế bằng dữ liệu thực sau này
        return view('admin.dashboard');
    }

    public function settings()
    {
        return view('admin.settings.index');
    }
}
