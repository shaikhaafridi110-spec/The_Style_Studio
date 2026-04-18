<?php

namespace App\Http\Controllers;
 
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;

class UserController extends Controller
{
   public function index()
    {
        // ALL products for trendy section
        $trendyAll = Product::with('category')
                        ->where('status', 'active')
                        
                        ->take(13)
                        ->get();

        // Products by category slug for tabs
        $trendyWomen = Product::with('category')
                        ->whereHas('category', fn($q) => $q->wherein('slug', ['women-jeans','women-top','women-dress']))
                        ->where('status', 'active')
                        ->latest()->take(8)->get();

        $trendyMen = Product::with('category')
                        ->whereHas('category', fn($q) => $q->wherein('slug', ['men-shirt', 'men-jeans','men-tshirt']))
                        ->where('status', 'active')
                        ->latest()->take(8)->get();

        

        // New arrivals
        $newAll = Product::with('category')
                        ->where('status', 'active')
                        ->latest()
                        ->take(8)
                        ->get();

        $newClothing = Product::with('category')
                        ->where('status', 'active')
                        ->latest()->take(8)->get();

        

       

        return view('user.index', compact(
            'trendyAll', 'trendyWomen', 'trendyMen', 
            'newAll', 'newClothing'
        ));
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
    

}
