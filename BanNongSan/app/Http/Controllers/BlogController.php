<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        return view(view: 'user.blog.index');
    }

    public function blogdetail()
    {
        return view(view: 'user.blog-details.index');
    }

}
