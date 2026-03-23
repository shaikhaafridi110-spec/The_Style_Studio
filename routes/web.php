<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Forgetpassword;

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\AdminProductController;


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
Route::get('/login', function () {
    return view('login');
});
Route::get('cprofile', function () {
    return view('cprofile');
});

Route::post('login_process',[LoginController::class,'loginProcess']);
Route::get('logout',[LoginController::class,'logout']);

Route::post('comlete_process',[LoginController::class,'cProcess']);




// Admin

Route::get('admin/home',[AdminController::class,'adminhome']);


//user
Route::get('admin/user',[AdminController::class,'adminuser']);
Route::get('delete_user/{id}',[AdminController::class,'user_del']);

//category
Route::get('admin/category',[AdminController::class,'admincategory']);

Route::get('admin/add-category',[AdminController::class,'addcategory']);
Route::get('admin/edit-category/{id}',[AdminController::class,'editcategory']);

Route::post('admin/update_category/{id}',[AdminController::class,'updatecategory']);


Route::post('admin/savecategory',[AdminController::class,'savecategory']);

Route::get('delete_category/{id}',[AdminController::class,'category_del']);



//product
Route::get('admin/product', [AdminProductController::class, 'product']);
Route::get('admin/add-product', [AdminProductController::class, 'addproduct']);
Route::post('admin/saveproduct', [AdminProductController::class, 'saveproduct']);

Route::get('admin/delete_product/{id}', [AdminProductController::class, 'product_delete']);



//product-img
Route::get('admin/product-image', [AdminController::class, 'productimage']);
Route::get('admin/add-product-image', [AdminController::class, 'addproductimage']);
Route::post('admin/save-product-image', [AdminController::class, 'saveproductimage']);


Route::get('admin/edit-product-image/{id}', [AdminController::class, 'editProductImage']);
Route::post('admin/update-product-image/{id}', [AdminController::class, 'updateProductImage']);
Route::get('admin/delete-product-image/{id}', [AdminController::class, 'deleteProductImage']);

// user

Route::get('/', [UserController::class, 'home']);
Route::get('user/shop', [UserController::class, 'shop']);
Route::get('user/single-shop', [UserController::class, 'single_shop']);
Route::get('user/cart', [UserController::class, 'cart']);
Route::get('user/checkout', [UserController::class, 'checkout']);
Route::get('user/wishlist', [UserController::class, 'wishlist']);
Route::get('user/about', [UserController::class, 'about']);
Route::get('user/contact', [UserController::class, 'contact']);



