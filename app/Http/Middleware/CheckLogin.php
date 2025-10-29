<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(!Auth::check()){
            return redirect('/login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        } $user = Auth::user();

        // Ví dụ: kiểm tra route prefix để đảm bảo quyền truy cập
        if ($user->role == User::ROLE_ADMIN && !$request->is('admin/*')) {
            return redirect('/admin/students/index');
        }

        if ($user->role === User::ROLE_STUDENT && !$request->is('student/*')) {
            return redirect('/student/all-schedule');
        }
        if ($user->role === User::ROLE_TEACHER && !$request->is('teacher/*')) {
            return redirect('/teacher/teach-schedule/index');
        }
        return $next($request);
    }
}
