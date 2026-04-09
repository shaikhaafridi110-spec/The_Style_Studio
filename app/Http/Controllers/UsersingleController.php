<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Productsize;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class UsersingleController extends Controller
{
    public function single($id)
    {
        $product    = Product::with(['category', 'images', 'size'])->findOrFail($id);
        $reviews    = Review::with('user')->where('proid', $id)->latest()->get();
        $avgRating  = $reviews->avg('rating') ?? 0;
        $related    = Product::where('catid', $product->catid)
                        ->where('proid', '!=', $id)
                        ->where('status', 'active')
                        ->take(5)->get();

        $userReviewed = false;
        if (Auth::check()) {
            $userReviewed = Review::where('proid', $id)
                                  ->where('user_id', Auth::id())
                                  ->exists();
        }

        return view('user.single_shop', compact(
            'product', 'reviews', 'avgRating', 'related', 'userReviewed'
        ));
    }

    public function addReview(Request $req, $id)
    {
        

        $req->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'proid' => $id],
            ['rating'  => $req->rating, 'review' => $req->review]
        );

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
    public function add(Request $req)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                             ->with('error', 'Please login to add items to cart.');
        }

        $req->validate([
            'proid' => 'required|exists:products,proid',
            'size'  => 'required',
            'qty'   => 'required|integer|min:1|max:10'],
    [
        'qty.required' => 'Please enter a quantity.',
        'qty.integer'  => 'Quantity must be a whole number.',
        'qty.min'      => 'Minimum quantity is 1.',
        'qty.max'      => '🛒 Whoa! Maximum 10 items per order. You cannot add more than 10 at a time.',
    
        ]);

        // check stock
        $sizeStock = Productsize::where('proid', $req->proid)
                                ->where('size', $req->size)
                                ->first();

        if (!$sizeStock || $sizeStock->stock < 1) {
            return redirect()->back()
                             ->with('error', 'Selected size is out of stock.');
        }

        if ($req->qty > $sizeStock->stock) {
            return redirect()->back()
                             ->with('error', 'Only ' . $sizeStock->stock . ' items available in this size.');
        }

        // check if already in cart
        $existing = Cart::where('user_id', Auth::id())
                        ->where('proid', $req->proid)
                        ->where('size', $req->size)
                        ->first();

        if ($existing) {
            $addQty  = $req->qty;
            $newQty  = $existing->qty + $addQty;

            // cap at available stock
            if ($newQty > $sizeStock->stock) {
                return redirect()->back()
                                 ->with('error', 'Only ' . $sizeStock->stock . ' items available. You already have ' . $existing->qty . ' in cart.');
            }

            $existing->qty = $newQty;
            $existing->save();

            // minus only the newly added qty from stock
            $sizeStock->stock -= $addQty;
            $sizeStock->save();

        } else {
            // new cart item
            Cart::create([
                'user_id' => Auth::id(),
                'proid'   => $req->proid,
                'size'    => $req->size,
                'qty'     => $req->qty,
            ]);

            // minus from stock
            $sizeStock->stock -= $req->qty;
            $sizeStock->save();
        }

        return redirect('user/cart')
                         ->with('success', 'Item added to cart successfully!');
    }
}