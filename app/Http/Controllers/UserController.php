<?php

namespace App\Http\Controllers;
 
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class UserController extends Controller
{
    public function home(){
         return view('user.index');
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
             if (!Auth::check()) {
            return redirect()->route('login');
        }
 
        $wishlist = Wishlist::with(['product.category', 'product.productsize'])
                            ->where('user_id', Auth::id())
                            ->latest()
                            ->get();
 
        $cartItems = Cart::with('product')
                         ->where('user_id', Auth::id())
                         ->get();
 
        return view('user.wishlist', compact('wishlist', 'cartItems'));
    }
    public function about(){
        return view('user.about');
    }
    public function contact(){
        return view('user.contact');
    }

}
