<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Forgetpassword;

use App\Http\Controllers\GoogleController;


// google authentication

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


// Forgot Password
Route::get('forgot-password', [Forgetpassword::class, 'forgotPassword']);
Route::post('send-otp', [Forgetpassword::class, 'sendOtp']);

// Verify OTP
Route::get('verify-otp', [Forgetpassword::class, 'verifyOtpPage']);
Route::post('verify-otp', [Forgetpassword::class, 'verifyOtp']);

// Reset Password
Route::get('reset-password', [Forgetpassword::class, 'resetPasswordPage']);
Route::post('reset-password', [Forgetpassword::class, 'resetPassword']);
// login -register
Route::get('/', function () {
    return view('login');
});
Route::get('register', function () {
    return view('register');
});

Route::post('login_process',[LoginController::class,'loginProcess']);
Route::get('logout',[LoginController::class,'logout']);

Route::post('register_process',[LoginController::class,'registerProcess']);




// Admin

Route::get('admin/home',[AdminController::class,'adminhome']);
Route::get('admin/user',[AdminController::class,'adminuser']);
Route::get('admin/category',[AdminController::class,'admincategory']);

Route::get('admin/add-category',[AdminController::class,'addcategory']);
Route::get('admin/edit-category/{id}',[AdminController::class,'editcategory']);

Route::post('admin/update_category/{id}',[AdminController::class,'updatecategory']);


Route::post('admin/savecategory',[AdminController::class,'savecategory']);



Route::get('delete_user/{id}',[AdminController::class,'user_del']);
Route::get('delete_category/{id}',[AdminController::class,'category_del']);


// user

