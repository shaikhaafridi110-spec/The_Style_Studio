<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home(){
         return view('user.index');
    }
    public function shop(){
         return view('user.shop');
    }
    public function single_shop(){
        return view('user.single_shop');
    }
    public function cart(){
        return view('user.cart');
    }
    public function checkout(){
        return view('user.checkout');
    }
    public function wishlist(){
        return view('user.wishlist');
    
    }
    public function about(){
        return view('user.about');
    }
    public function contact(){
        return view('user.contact');
    }

}
