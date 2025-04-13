<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OopsController;
/*Route::get('/', function () {
    return view('welcome');
});*/


Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminController::class, 'login']);
Route::get('/', [AdminController::class, 'index']);

Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
Route::get('/index', [AdminController::class, 'index'])->name('admin.index');
Route::get('/products', [AdminController::class, 'manageProduct'])->name('admin.products');

Route::get('/orders', [AdminController::class, 'manageOrders'])->name('admin.orders');
Route::get('/revenue', [AdminController::class, 'manageRevenue'])->name('admin.revenue');

Route::get('/create', [AdminController::class, 'oopscreate'])->name("oopscreate");

Route::post('/save/{action}', [AdminController::class, 'oopssave'])->name("oopssave");

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
          

//hậu
Route::get('/edit/{id}', [AdminController::class, 'oopsedit'])->name("oopsedit");
Route::post('/delete', [AdminController::class, 'oopsdelete'])->name("oopsdelete"); 

