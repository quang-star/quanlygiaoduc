<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/index', function () {
//     return view('index');
// });
// Route::get('/khoahoc', function () {
//     return view('khoahoc');
// });
// Route::get('/taomoikhoahoc', function () {
//     return view('taomoikhoahoc');
// });

// Route::get('/taolophoc', function () {
//     return view('taolophoc');
// });
// Route::get('/lophoc', function () {
//     return view('admin.classes.lophoc');
// });
// Route::get('/lichhoc', function () {
//     return view('lichhoc');
// });

// Route::get('/hopdong', function () {
//     return view('hopdong');
// });
// Route::get('/taohopdong', function () {
//     return view('taohopdong');
// });
// Route::get('/ngonngu', function () {
//     return view('ngonngu');
// });
// Route::get('/chungchi', function () {
//     return view('chungchi');
// });
// Route::get('/level', function () {
//     return view('level');
// });
// Route::get('/hocvien', function () {
//     return view('hocvien');
// });
// Route::get('/hocvienchotest', function () {
//     return view('hocvienchotest');
// });
// Route::get('/hocvienchoxeplop', function () {
//     return view('hocvienchoxeplop');
// });
// Route::get('/taohocvienchotest', function () {
//     return view('taohocvienchotest');
// });
// Route::get('/diemdanh', function () {
//     return view('diemdanh');
// });
// Route::get('/dangnhap', function () {
//     return view('dangnhap');
// });
Route::get('/dangnhap', [App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'doLogin']);

Route::get('/forgot', [App\Http\Controllers\Auth\AuthController::class, 'forgotPassword']);
Route::post('/forgot', [App\Http\Controllers\Auth\AuthController::class, 'postForgotPassword']);
Route::get('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout']);
Route::get('/change_password', [App\Http\Controllers\Auth\AuthController::class, 'changePassword']);
Route::post('/change_password', [App\Http\Controllers\Auth\AuthController::class, 'postChangePassword']);

// dam bao cac route phai dang nhap moi duoc truy cap
Route::group(['middleware' => 'checkLogin'], function () {

    // route cho admin
    Route::group(['prefix' => 'admin'], function () {
      
        Route::get('/students/index', [\App\Http\Controllers\Admin\StudentController::class, 'index']);
    });

    // // route cho staff
    // Route::group(['prefix' => 'staff'], function () {

      
    //     // Route::post('/info/update', [App\Http\Controllers\Staff\ProfileController::class, 'update']);
    // });

    // // route cho client
    // Route::group(['prefix' => 'clients'], function () {

       
    // });
});
