<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Toggle a product in / out of the authenticated user's wishlist.
     * Guests receive a friendly login prompt instead of an error.
     */
    public function toggle(Request $request)
    {
        // ── Guest check ───────────────────────────────────────────
        if (!Auth::check()) {
            return response()->json([
                'status'  => 'login',
                'message' => 'Please log in to add items to your wishlist.',
            ]);
        }

        // ── Validate input ────────────────────────────────────────
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,proid'],
        ]);

        $productId = $validated['product_id'];
        $userId    = Auth::id();

        // ── Toggle ────────────────────────────────────────────────
        $wishlist = Wishlist::where('user_id', $userId)
                            ->where('proid', $productId)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();

            return response()->json([
                'status'  => 'removed',
                'message' => 'Removed from your wishlist.',
            ]);
        }

        Wishlist::create([
            'user_id' => $userId,
            'proid'   => $productId,
        ]);

        return response()->json([
            'status'  => 'added',
            'message' => 'Added to your wishlist!',
        ]);
    }
}