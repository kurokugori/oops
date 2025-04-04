<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/trangchu','App\Http\Controllers\OopsController@trangchu');

Route::get('/trangchu/phone_brands/{id}','App\Http\Controllers\OopsController@phone_brands');

Route::get('/trangchu/chi_tiet/{id}','App\Http\Controllers\OopsController@chitiet');

Route::get('/', function () {
    // Có thể chuyển hướng đến trang login/register nếu chưa đăng nhập
    // hoặc dashboard nếu đã đăng nhập
    if (auth()->check()) {
        return redirect()->route('trangchu');
    }
    return redirect()->route('login_register.show');

})->name('home');

// --- Routes cho Xác thực ---

// Hiển thị trang chứa cả form Đăng nhập và Đăng ký
Route::get('/login-register', [AuthController::class, 'showLoginRegisterForm'])
     ->name('login_register.show') // Đặt tên route mới
     ->middleware('guest');      // Chỉ khách mới thấy trang này

// Xử lý submit form Đăng nhập
Route::post('/login', [AuthController::class, 'login'])
     ->name('login.perform')     // Đổi tên để tránh trùng lặp nếu cần
     ->middleware('guest');

// Xử lý submit form Đăng ký
Route::post('/register', [AuthController::class, 'register'])
     ->name('register.perform')  // Đổi tên để tránh trùng lặp nếu cần
     ->middleware('guest');

// Xử lý đăng xuất
Route::post('/logout', [AuthController::class, 'logout'])
     ->name('logout')
     ->middleware('auth');

// Trang dashboard (yêu cầu đăng nhập)
Route::get('/dashboard', function () {
    $user = auth()->user();
    // Sử dụng accessor fullName đã tạo trong model User
    return view('giaodiennguoidung.dashboard', ['userFullName' => $user->full_name]);
})->name('dashboard')->middleware('auth');

// --- Kết thúc Routes cho Xác thực ---