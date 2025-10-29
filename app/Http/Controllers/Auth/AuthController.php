<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\MailResgister;
use App\Models\User;
use App\Services\MailService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;
use Illuminate\Routing\Controller as BaseController;

use function Laravel\Prompts\alert;

class AuthController extends BaseController
{
    /**
     * Xử lý thông tin đăng nhập và redirect đến trang dashboard
     */
    public function login()
    {
        return view('auth.login');
    }


    /**
     * Xử lý thông tin đăng nhập và redirect đến trang dashboard
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doLogin(Request $request)
    {
        $param = $request->all();
        $remember = $request->has('remember');
        // kiểm tra thống tin đăng nhập 
        $checkLogin = Auth::attempt([
            'email' => $param['email'],
            'password' => $param['password'],
        ], $remember);

        if ($checkLogin) {
            $user = Auth::user();
            session(['user_id' => $user->id]);
            // kiểm tra quyen truy cap
            $role = $user->role;
            if ($role == User::ROLE_ADMIN) {
                return redirect('/admin/dashboard/index');
            } elseif ($role == User::ROLE_STUDENT) {
                return redirect('/student/all-schedule');
                if ($user->active == User::INACTIVE) {
                    return redirect('/login')
                        ->with('error', 'Tài khoản đang bị khoá vui lòng liên hệ với người quản lý');
                }
            } elseif ($role == User::ROLE_TEACHER) {
                if ($user->active == User::INACTIVE) {
                    return redirect('/login')->with('error', 'Tài khoản đang bị khoá vui lòng liên hệ với người quản lý');
                }
                return redirect('/teacher/teach-schedule/index');
            }
        } else {
            return redirect('/login')->with('error', 'Email hoặc mật khẩu không đúng.');
        }
    }



    /**
     * Đăng xuất người dùng ra khỏi hệ thống
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Đăng xuất thành công');
    }

    public function forgotPasswordIndex()
    {
        return view('auth.forgot-password');
    }

    /**
     * Gửi liên kết đặt lại mật khẩu đến email của người dùng
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forgotPassword(Request $request)
    {
        $param = $request->all();
        $email = $param['email'];
        // Kiểm tra xem có email này có trong hệ thống khônng
        $user = User::where('email', $email)->first();

        // Nếu không tìm thấy email này trong hệ thống thì thông báo lỗi
        if (!$user) {
            return back()->with('error', 'Email không tồn tại trong hệ thống.');
        }
        // Kiểm tra xem tài khoản này có đang bị khóa không 
        if ($user->active == User::INACTIVE) {
            return redirect('/login')
                ->with('error', 'Tài khoản đang bị khoá vui lòng liên hệ với người quản lý');
        }
        // tạo token và gửi đến mail của người dùng
        $token = Str::random(64);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );
        $resetLink = url('/reset-password/' . $token);
        MailService::sendMailResetPassword($user, $resetLink);
        return back()->with('success', 'Đã gửi liên kết đặt lại mật khẩu tới email của bạn.');
    }


    /**
     * Hiển thị form đổi mật khẩu cho người dùng
     *
     * @param Request $request
     * @param string $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function resetPasswordIndex(Request $request, $token)
    {

        $reset = DB::table('password_reset_tokens')->where('token', $token)->first();
        $email = $reset ? $reset->email : null;

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email
        ]);
    }

    /**
     * Đặt lại mật khẩu cho người dùng
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return back()->with('error', 'Liên kết không hợp lệ hoặc đã hết hạn.');
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/login')->with('success', 'Đặt lại mật khẩu thành công, bạn có thể đăng nhập.');
    }
}
