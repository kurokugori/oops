<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/trangchu','App\Http\Controllers\OopsController@trangchu');

Route::get('/trangchu/phone_brands/{id}','App\Http\Controllers\OopsController@phone_brands');

Route::get('/trangchu/chi_tiet/{id}','App\Http\Controllers\OopsController@chitiet');