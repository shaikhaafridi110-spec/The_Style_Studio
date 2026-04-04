<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
   public function toggle(Request $request)
{
    if (!Auth::check()) {
        return response()->json(['status' => 'login']);
    }

    $product_id = $request->product_id;

    $wishlist = Wishlist::where('user_id', Auth::id())
        ->where('proid', $product_id)
        ->first();

    if ($wishlist) {
        // ❌ REMOVE
        $wishlist->delete();
        return response()->json(['status' => 'removed']);
    } else {
        // ❤️ ADD
        Wishlist::create([
            'user_id' => Auth::id(),
            'proid' => $product_id
        ]);

        return response()->json(['status' => 'added']);
    }
}
}
