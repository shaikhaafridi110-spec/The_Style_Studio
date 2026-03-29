<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Forgetpassword;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminCategory;
use App\Http\Controllers\AdminWishlistController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminWishlistController as ControllersAdminWishlistController;

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




// *********************Admin****************************

Route::get('admin/home',[AdminController::class,'adminhome']);


//user
Route::get('admin/user',[AdminController::class,'adminuser']);
Route::get('delete_user/{id}',[AdminController::class,'user_del']);

//category
Route::get('admin/category',[AdminCategory::class,'admincategory']);

Route::get('admin/add-category',[AdminCategory::class,'addcategory']);
Route::get('admin/edit-category/{id}',[AdminCategory::class,'editcategory']);

Route::post('admin/update_category/{id}',[AdminCategory::class,'updatecategory']);


Route::post('admin/savecategory',[AdminCategory::class,'savecategory']);

Route::get('delete_category/{id}',[AdminCategory::class,'category_del']);
Route::get('admin/status/{id}',[AdminCategory::class,'status']);



//product
Route::get('admin/product', [AdminProductController::class, 'product']);
Route::get('admin/add-product', [AdminProductController::class, 'addproduct']);
Route::post('admin/saveproduct', [AdminProductController::class, 'saveproduct']);

Route::get('admin/delete_product/{id}', [AdminProductController::class, 'product_delete']);
Route::get('admin/prostatus/{id}', [AdminProductController::class, 'product_status']);
Route::get('admin/edit-product/{id}', [AdminProductController::class, 'product_edit']);
Route::post('admin/updateproduct/{id}', [AdminProductController::class, 'updateProduct']);



//product-img
Route::get('admin/product-image', [AdminProductController::class, 'productimage']);
Route::get('admin/add-product-image', [AdminProductController::class, 'addproductimage']);
Route::post('admin/save-product-image', [AdminProductController::class, 'saveproductimage']);


Route::get('admin/edit-product-image/{id}', [AdminProductController::class, 'editProductImage']);
Route::post('admin/update-product-image/{id}', [AdminProductController::class, 'updateProductImage']);
Route::get('admin/delete-product-image/{id}', [AdminProductController::class, 'deleteProductImage']);



//product-size


Route::get('admin/product-size',[AdminProductController::class,'productsize']);
Route::get('admin/add-product_size',[AdminProductController::class,'addproductsize']);
Route::post('admin/save-product-size', [AdminProductController::class, 'saveproductsize']);
Route::post('admin/update-product-stock', [AdminProductController::class, 'updatestock']);
Route::get('admin/delete_product-size/{id}', [AdminProductController::class, 'deletesize']);




//wishlist


Route::get('admin/wishlist',[AdminWishlistController::class,'withlist']);



//order list
Route::get('admin/Order',[OrderController::class,'orderlist']);
Route::get('admin/Order-items',[OrderController::class,'orderitems']);
Route::get('admin/delete_order-item/{id}',[OrderController::class,'orderitem_del']);



Route::get('admin/delete_order/{id}',[OrderController::class,'order_del']);

Route::get('admin/order-user',[OrderController::class,'order_user']);















// user

Route::get('/', [UserController::class, 'home']);
Route::get('user/shop', [UserController::class, 'shop']);
Route::get('user/single-shop', [UserController::class, 'single_shop']);
Route::get('user/cart', [UserController::class, 'cart']);
Route::get('user/checkout', [UserController::class, 'checkout']);
Route::get('user/wishlist', [UserController::class, 'wishlist']);
Route::get('user/about', [UserController::class, 'about']);
Route::get('user/contact', [UserController::class, 'contact']);



