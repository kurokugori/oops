<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OopsController; // *** Thêm dòng này ***
use App\Http\Controllers\CommentController;
/*
Route::get('/', function () {
    return view('welcome');
}); // *** Có thể xóa route welcome mặc định này nếu không dùng ***
*/

// --- Routes Chính ---

// Route xử lý logic hiển thị trang chủ
Route::get('/trangchu', [OopsController::class, 'trangchu']) // *** Cập nhật cú pháp & Thêm tên ***
     ->name('trangchu');

// Route xử lý trang danh sách sản phẩm theo hãng
Route::get('/trangchu/phone_brands/{id}', [OopsController::class, 'phone_brands']) // *** Cập nhật cú pháp ***
     ->name('phone_brands.show'); // *** Nên đặt tên cụ thể hơn ***

// Route xử lý trang chi tiết sản phẩm
Route::get('/trangchu/chi_tiet/{id}', [OopsController::class, 'chitiet']) // *** Cập nhật cú pháp ***
      ->name('product.detail'); // *** Nên đặt tên cụ thể hơn ***

//Route cho comment
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');

// Route xử lý cho tìm kiếm sản phẩm
Route::get('/search', [OopsController::class, 'search'])->name('search');

// Route gốc '/' - Điều hướng dựa trên trạng thái đăng nhập
Route::get('/', function () {
    if (auth()->check()) {
        // Bây giờ đã có route tên 'trangchu' để chuyển hướng đến
        return redirect()->route('trangchu');
    }
    // Chuyển hướng đến trang đăng nhập/đăng ký nếu là khách
    return redirect()->route('login_register.show');
})->name('home'); // Route gốc này tên là 'home'


// --- Routes cho Xác thực ---

// Hiển thị trang chứa cả form Đăng nhập và Đăng ký
Route::get('/login-register', [AuthController::class, 'showLoginRegisterForm'])
     ->name('login_register.show')
     ->middleware('guest');

// Xử lý submit form Đăng nhập
Route::post('/login', [AuthController::class, 'login'])
     ->name('login.perform')
     ->middleware('guest');

// Xử lý submit form Đăng ký
Route::post('/register', [AuthController::class, 'register'])
     ->name('register.perform')
     ->middleware('guest');

// Xử lý đăng xuất
Route::post('/logout', [AuthController::class, 'logout'])
     ->name('logout')
     ->middleware('auth');


// --- Routes cho khu vực tài khoản (cần đăng nhập) ---
Route::middleware(['auth'])->prefix('tai-khoan')->group(function () { // *** Thêm prefix cho gọn ***

    // Route hiển thị trang thông tin tài khoản
    Route::get('/', [AccountController::class, 'edit'])->name('account.edit'); // URL sẽ là /tai-khoan

    // Route xử lý cập nhật thông tin tài khoản
    Route::put('/', [AccountController::class, 'update'])->name('account.update'); // URL sẽ là /tai-khoan (method PUT)

    // Ví dụ route đổi mật khẩu (nếu có)
    // Route::get('/doi-mat-khau', [PasswordController::class, 'showChangeForm'])->name('password.change.show');
    // Route::put('/doi-mat-khau', [PasswordController::class, 'updatePassword'])->name('password.change.update');

});
// --- Kết thúc Routes cho khu vực tài khoản ---

// Route::get('/dashboard', function () { /* ... */ })->name('dashboard'); // Xóa hoặc sửa route dashboard cũ nếu không dùng đến

// Route cho trang đặt hàng
Route::get('/order',[OopsController::class, 'order'])->name('order');
// Route thêm vào giỏ hàng
Route::post('/cart/add',[OopsController::class, 'cartadd'])->name('cartadd');
// Route xóa sản phẩm trong giỏ hàng
Route::post('/cart/delete',[OopsController::class, 'cartdelete'])->name('cartdelete');

/*Route::post('/order/create','App\Http\Controllers\OopsController@ordercreate')
          ->middleware('auth')->name('ordercreate');*/

//Route đặt hàng
//Route::post('/luu-don-hang', [OopsController::class, 'saveOrder'])->name('saveorder');

Route::get('/checkout', [OopsController::class, 'showCheckoutForm'])
          ->middleware('auth')->name('checkout');
Route::post('/save-order', [OopsController::class, 'saveOrder'])
          ->middleware('auth')->name('saveorder');



// Trang quản lý sản phẩm
Route::get('/login/admin', [AdminController::class, 'showLoginForm'])->name('login');
Route::post('/login/admin', [AdminController::class, 'login']);
Route::get('/quanly', [AdminController::class, 'index']);

Route::post('/logout/admin', [AdminController::class, 'logout'])->name('logout.admin');
Route::get('/index', [AdminController::class, 'index'])->name('admin.index');
Route::get('/products', [AdminController::class, 'manageProduct'])->name('admin.products');


Route::get('/create', [AdminController::class, 'oopscreate'])->name("oopscreate");// thêm sản phẩm

Route::post('/save/{action}', [AdminController::class, 'oopssave'])->name("oopssave");

Route::get('/edit/{id}', [AdminController::class, 'oopsedit'])->name("oopsedit");
Route::post('/delete', [AdminController::class, 'oopsdelete'])->name("oopsdelete"); 

// Trang quản lý đơn đặt hàng
Route::get('/orders/admin', [AdminController::class, 'manageOrders'])->name('admin.orders');
Route::put('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.updateStatus');
Route::get('/orders/{ma_don_hang}/details', [AdminController::class, 'ajaxOrderDetails']);// Route cho AJAX lấy chi tiết đơn hàng



//Trang quản lý doanh thu
Route::get('/revenue', [AdminController::class, 'manageRevenue'])->name('admin.revenue');
Route::get('/revenue/sync', [AdminController::class, 'syncRevenue'])->name('admin.revenue.sync');



