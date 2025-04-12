<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
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

Route::get('/edit/{id}', [AdminController::class, 'oopsedit'])->name("oopsedit");
Route::post('/delete', [AdminController::class, 'oopsdelete'])->name("oopsdelete"); 