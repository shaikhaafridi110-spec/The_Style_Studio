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
    $data = Wishlist::select('proid')
        ->selectRaw('COUNT(*) as total_wishlist') // ✅ correct count   
        ->with('product')
        ->groupBy('proid')
        ->orderByDesc('total_wishlist') // highest first
        ->paginate(10);

    return view('admin/wishlist', compact('data'));
}
}
