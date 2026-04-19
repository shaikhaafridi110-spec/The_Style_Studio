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
use App\Http\Controllers\UsershopController;
use App\Http\Controllers\AdminCouponController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Checkoutcontroller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersingleController;
use App\Http\Controllers\WishlistController;


// google authentication

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


// Forgot Password
Route::get('forgot-password', [Forgetpassword::class, 'forgotPassword'])->name('forgot.password');
Route::post('send-otp', [Forgetpassword::class, 'sendOtp']);

// Verify OTP
Route::get('verify-otp', [Forgetpassword::class, 'verifyOtpPage']);
Route::post('verify-otp', [Forgetpassword::class, 'verifyOtp']);

// Reset Password
Route::get('reset-password', [Forgetpassword::class, 'resetPasswordPage']);
Route::post('reset-password', [Forgetpassword::class, 'resetPassword']);
// login -register

Route::get('cprofile', function () {
    return view('cprofile');
});
Route::get('login',[LoginController::class,'login']);
Route::post('login_process',[LoginController::class,'loginProcess']);
Route::get('logout',[LoginController::class,'logout']);

Route::post('comlete_process',[LoginController::class,'cProcess']);




// *********************Admin****************************

Route::middleware(['isAdmin'])->group(function(){



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
Route::patch('admin/order-status/{id}', [OrderController::class, 'order_status_update']);
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




// LIST
Route::get('admin/coupon', [AdminCouponController::class, 'coupon']);
Route::get('admin/add-coupon', [AdminCouponController::class, 'addCoupon']);
Route::post('admin/save-coupon', [AdminCouponController::class, 'saveCoupon']);
Route::get('admin/edit-coupon/{id}', [AdminCouponController::class, 'editCoupon']);
Route::post('admin/update-coupon/{id}', [AdminCouponController::class, 'updateCoupon']);
Route::get('admin/delete-coupon/{id}', [AdminCouponController::class, 'deleteCoupon']);
Route::get('admin/coupon-status/{id}', [AdminCouponController::class, 'status']);

});


// user

Route::get('/', [UserController::class, 'index'])->name('home');
Route::get('/home', [UserController::class, 'index']);
Route::post('user/fcupon',[UserController::class,'fcupon']);




// shop

Route::get('user/shop', [UsershopController::class, 'shop']);
Route::get('user/shop/{name}', [UsershopController::class, 'shop'])->name('user.category')->middleware('isUser');













//cart

Route::get('user/cart', [CartController::class, 'cart'])->middleware('isUser');
Route::get('cart/remove/{id}', [CartController::class, 'cartremove'])->middleware('isUser');
Route::post('cart/update-qty', [CartController::class, 'updateCartQty'])->name('cart.updateQty')->middleware('isUser');
Route::post('/cart/add',    [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'updateQty'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove']   )->name('cart.remove');
Route::post('/cart/clear',  [CartController::class, 'clear']    )->name('cart.clear');


//single

Route::post('user/cart/add',[UsersingleController::class,'add'])->middleware('isUser');

Route::get('user/single-shop/{id}',            [UsersingleController::class, 'single'])->name('user.single');
Route::post('user/single/{id}/review',    [UsersingleController::class, 'addReview'])->name('user.review')->middleware('isUser');


//checkoutcontroller

Route::middleware('isUser')->group(function () {
 
    // Checkout page
    Route::get('user/checkout', [CheckoutController::class, 'index'])->name('checkout');
 
    // Apply coupon (AJAX)
    Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.applyCoupon');
 
    // Place order (branches internally to card/upi/cod)
    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
 
    // ── Card / Razorpay ─────────────────────────────────────────────────
    Route::post('/checkout/razorpay/success', [CheckoutController::class, 'razorpaySuccess'])->name('checkout.razorpaySuccess');
 
    // ── UPI ─────────────────────────────────────────────────────────────
    Route::post('/checkout/upi/confirm', [CheckoutController::class, 'upiConfirm'])->name('checkout.upiConfirm');
 
    // ── COD OTP ─────────────────────────────────────────────────────────
    Route::post('/checkout/otp/verify',  [CheckoutController::class, 'verifyOtp'])->name('checkout.verifyOtp');
    Route::post('/checkout/otp/resend',  [CheckoutController::class, 'resendOtp'])->name('checkout.resendOtp');
 
    // ── Result pages ────────────────────────────────────────────────────
    Route::get('/checkout/success/{orderId}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/failed',            [CheckoutController::class, 'failed'])->name('checkout.failed');
});
 
// Razorpay Webhook — NO auth middleware, verify signature inside controller
Route::post('/webhook/razorpay', [CheckoutController::class, 'razorpayWebhook'])
    ->name('webhook.razorpay')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

//wish list
Route::get('user/wishlist', [UserController::class, 'wishlist'])->middleware('isUser');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

//order
Route::middleware('isUser')->group(function () {
    Route::get('/orders',      [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});


//profile
Route::middleware('isUser')->group(function () {
 
    // Show profile page
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
 
    // Update personal info + address
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
 
    // Update password
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
 
});

Route::get('user/about', [UserController::class, 'about']);

// category

Route::get('user/categories', [UserController::class, 'allCategories'])->name('user.categories')->middleware('isUser');

//chat box
Route::post('user/chatbot', [UserController::class, 'chatbot'])->name('user.chatbot');
//contact

Route::post('/user/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('user/contact', [ContactController::class, 'contact'])->name('contact');;

