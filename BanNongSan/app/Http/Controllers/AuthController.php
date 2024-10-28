<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use stdClass;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Register API - POST (name, email, password)
    public function register()
    {
        return view(view: 'auth.register.index');

    }

    // Login API - POST (email, password)
    public function login()
    {
        return view(view: 'auth.login.index');
    }
}