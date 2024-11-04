<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * Kiểm tra xem người dùng có vai trò Admin hay không.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $requiredPermission = null): Response
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login.index')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        // Lấy vai trò và quyền của người dùng
        $user = Auth::user();
        $permissions = $user->quyen->pluck('TenQuyen')->toArray();

        if ($requiredPermission && !in_array($requiredPermission, $permissions)) {
            return redirect()->route('welcome')->with('error', 'Bạn không có quyền truy cập trang này.');
        }

        return $next($request);
    }
}
