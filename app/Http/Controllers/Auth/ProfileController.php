<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $user = User::find($userId);

        return view('auth.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $param = $request->all();
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        // Kiểm tra email trùng
        $findUser = User::where('email', $param['email'])
            ->where('id', '!=', $userId)
            ->first();
        if ($findUser) {
            return redirect()->back()->with('error', 'Email này đã được sử dụng bởi người khác');
        }

        // Xử lý ảnh đại diện
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = $userId . '.' . $file->getClientOriginalExtension();
            $path = public_path('images/avatars');

            // Tạo thư mục nếu chưa có
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $file->move($path, $filename);
            $avatarPath = 'images/avatars/' . $filename;
        } else {
            // Giữ nguyên avatar cũ
            $avatarPath = $user->avatar;
        }

        // Cập nhật thông tin
        $user->update([
            'name' => $param['name'],
            'email' => $param['email'],
            'phone_number' => $param['phone'],
            'birthday' => $param['birthday'],
            'avatar' => $avatarPath,
        ]);

        return redirect()->back()->with('success', 'Cập nhật thông tin thành công');
    }

    public function changePasswordIndex(Request $request){
        $user = Auth::user();

        return view('auth.change-password', compact('user'));
    }

    public function updatePassword(Request $request){
        $param = $request->all();
        $user = Auth::user();

        if(!Hash::check($param['current_password'], $user->password)){
            return redirect()->back()->with('error', 'Mật khẩu hiện tay không đúng');   
        }
        $user->update([
            'password' => Hash::make($param['new_password'])
        ]);

        return redirect()->back()->with('success', 'Cập nhật mật kháu thành cong');
    }

}
