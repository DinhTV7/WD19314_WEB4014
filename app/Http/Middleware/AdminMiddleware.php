<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm nếu không đăng và không phải là admin thì không đưuọc phép truy cập
        if (!Auth::check() || !Auth::user()->isRoleAdmin()) {
            return redirect()->route('login')
                        ->withErrors('Bạn không đủ quyền truy cập và trang Admin');
        }
        return $next($request);
    }
}
