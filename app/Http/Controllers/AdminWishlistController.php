<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminWishlistController extends Controller
{
    public function withlist()
    {
        
        $data = Wishlist::select('*')->with('user')->with('product');
        
       
        $data = $data->paginate(10)->withQueryString();
        return view('admin/wishlist',compact('data'));
        //return view('user',);

    }
}
