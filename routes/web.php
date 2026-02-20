<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;


// login -register
Route::get('/', function () {
    return view('login');
});
Route::get('register', function () {
    return view('register');
});

Route::post('login_process',[LoginController::class,'loginProcess']);





// Admin

Route::get('admin/home',[AdminController::class,'adminhome']);

// user

