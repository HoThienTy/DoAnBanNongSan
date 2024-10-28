<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopGridController extends Controller
{
    public function index()
    {
        return view('user.shop-grid.index');
    }

}
