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
use App\Http\Controllers\AdminReviewController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\ContactController;
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
Route::get('admin/edit_user/{id}',[AdminController::class,'edit_user']);
Route::post('admin/user-update/{id}',[AdminController::class,'update_user']);
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


Route::get('admin/delete-product-image/{id}', [AdminProductController::class, 'deleteProductImage']);




//wishlist


Route::get('admin/wishlist',[AdminWishlistController::class,'withlist']);



//order list
Route::get('admin/Order', [OrderController::class, 'orderlist']);
Route::get('admin/delete_order/{id}', [OrderController::class, 'order_del']);

Route::get('admin/order-edit/{id}', [OrderController::class, 'order_edit']);
Route::post('admin/order-update/{id}', [OrderController::class, 'order_update']);

Route::get('admin/Order-items', [OrderController::class, 'orderitems']);
Route::get('admin/delete_order-item/{id}', [OrderController::class, 'orderitem_del']);


//review

Route::get('admin/review',[AdminReviewController::class,'review']);
Route::get('admin/delete-review/{id}',[AdminReviewController::class,'review_del']);
Route::get('admin/review-status/{id}',[AdminReviewController::class,'review_status']);




//contract

Route::get('admin/contact', [ContactController::class, 'contactilst']);
Route::get('admin/delete_contact/{id}', [ContactController::class, 'contactdelete']);
Route::get('admin/contact-status/{id}', [ContactController::class, 'contactstatus']);

Route::get('admin/contact-reply/{id}', [ContactController::class, 'contactreplyForm']);
Route::post('admin/contact-reply/{id}', [ContactController::class, 'contactreply']);







// user

Route::get('/', [UserController::class, 'home']);
Route::get('user/shop', [UserController::class, 'shop']);
Route::get('user/single-shop', [UserController::class, 'single_shop']);
Route::get('user/cart', [UserController::class, 'cart']);
Route::get('user/checkout', [UserController::class, 'checkout']);
Route::get('user/wishlist', [UserController::class, 'wishlist']);
Route::get('user/about', [UserController::class, 'about']);
Route::get('user/contact', [UserController::class, 'contact']);



