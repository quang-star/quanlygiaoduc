<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\MailResgister;
use App\Models\User;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Routing\Controller as BaseController;

use function Laravel\Prompts\alert;

class AuthController extends BaseController
{
    public function login()
    {
        //session(['showLogin' => false]);
        return view('dangnhap');
    }


    public function doLogin(Request $request)
    {
        $param = $request->all();
        $remember = $request->has('remember');

        $checkLogin = Auth::attempt([
            'email' => $param['email'],
            'password' => $param['password'],
        ], $remember);

        if ($checkLogin) {
            $user = Auth::user();
            session(['user_id' => $user->id]);

            $role = $user->role;
            if ($role == 0) {
                return redirect('hopdong');
            } elseif ($role == 1) {
                return redirect('khoahoc');
            } elseif ($role == 2) {
                return redirect('hocvien');
            }
        } else {
            return redirect('/dangnhap')->with('error', 'Email hoặc mật khẩu không đúng.');
        }
    }




    // public function forgotPassword()
    // {
    //     return view('clients.forgot');
    // }

    // public function postForgotPassword(Request $request)
    // {
    //     $param = $request->all();
    //     $action = $param['action'] ?? 'send_code';
    //     // Kiểm tra xem có đang xác minh mã hay không
    //     if ($action === 'send_code') {
    //         $user = User::where('email', $param['email'])->first();
    //         if (!$user) {
    //             return redirect('/forgot')->with('error', 'Email không tồn tại');
    //         }
    //         $verifyCode = rand(100000, 999999);
    //         try {
    //             $mail = new MailResgister();
    //             $mail->setEmail($param['email']);
    //             $mail->setVerifyCode($verifyCode);
    //             Mail::to($param['email'])->send($mail);
    //             session([
    //                 'forgot' => true,
    //                 'temp_user_data' => ['email' => $param['email']],
    //                 'verify_code' => $verifyCode
    //             ]);
    //             return redirect('/forgot')->with('success', 'Mã xác nhận đã được gửi đến email của bạn');
    //         } catch (\Exception $e) {
    //             return redirect('/forgot')->with('error', 'Không thể gửi mã xác nhận. Vui lòng thử lại.');
    //         }
    //     }
    //     // Xử lý các hành động xác minh và đặt lại mật khẩu
    //     if ($action === 'verify') {
    //         if ($param['verification_code'] != session('verify_code')) {
    //             return redirect('/forgot')->with('error', 'Mã xác nhận không đúng');
    //         }
    //         session()->forget('verify_code');
    //         session(['new_password' => true]);
    //         return redirect('/forgot')->with('success', 'Xác minh thành công. Vui lòng đặt mật khẩu mới');
    //     }
    //     // Xử lý đặt lại mật khẩu
    //     if ($action === 'reset_password') {
    //         if ($param['new_password'] !== $param['re_new_password']) {
    //             return redirect('/forgot')->with('error', 'Mật khẩu không khớp');
    //         }
    //         $user = User::where('email', session('temp_user_data.email'))->first();
    //         if (!$user) {
    //             return redirect('/forgot')->with('error', 'Không tìm thấy người dùng');
    //         }
    //         $user->password = Hash::make($param['new_password']);
    //         $user->save();
    //         session()->forget(['forgot', 'new_password', 'temp_user_data']);
    //         return redirect('/login')->with('success', 'Đổi mật khẩu thành công. Vui lòng đăng nhập lại');
    //     }
    //     return redirect('/forgot')->with('error', 'Hành động không hợp lệ');
    // }



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
    $request->session()->regenerateToken();
        return redirect('/dangnhap')->with('success', 'Đăng xuất thành công');
    }
    // public function changePassword(Request $request)
    // {

    //     $userId = session('user_id');
    //     $user = User::find($userId);
    //     if ($user->role == User::ROLE_ADMIN) {
    //         return view('admin.change-password');
    //     } else if ($user->role == 1) {
    //         return view('staff.change-password');
    //     } else if ($user->role == 2) {
    //         return view('clients.change-password');
    //     }
    // }
    // public function postChangePassword(Request $request)
    // {
    //     $param = $request->all();
    //     //$user = Auth::user();
    //     $userId = session('user_id');
    //     $user = User::find($userId);
    //     if (!Hash::check($param['current_password'], $user->password)) {
    //         return redirect('/change_password')->with('error', 'Mật khẩu hiện tại không đúng');
    //     }
    //   //  dd($param['new_password']);
    //     $user->password = Hash::make($param['new_password']);

    //     $user->save();
    //     return redirect('/change_password')->with('success', 'Đổi mật khẩu thành công');
    // }
}
