<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Productsize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;

class UsershopController extends Controller
{
    public function shop(Request $r, $name = null)
    {
        $product = Product::with('category', 'reviews', 'productsize')
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        
        $wishlistIds = [];

        if (Auth::check()) {
            $wishlistIds = Wishlist::where('user_id', Auth::id())
                ->pluck('proid')
                ->toArray();
        }

        if ($name) {
            $product->whereHas('category', function ($q) use ($name) {
                $q->where('slug', $name);
            });
        }


        if ($r->category) {
            $product->whereHas('category', function ($q) use ($r) {
                $q->whereIn('slug', $r->category);
            });
        }

      
        if ($r->search) {
            $product->where('proname', 'like', "%{$r->search}%");
        }




       
        $topIds = OrderItem::select('product_id')
            ->groupBy('product_id')
            ->orderByRaw('SUM(qty) DESC')
            ->pluck('product_id')
            ->toArray();

    
        if ($r->sortby == 'popularity' && !empty($topIds)) {
            $ids = implode(',', $topIds);

            $product->whereIn('proid', $topIds)
                ->orderByRaw("FIELD(proid, $ids)");
        } elseif ($r->sortby == 'rating') {
            $product->orderByDesc('reviews_avg_rating');
        } elseif ($r->sortby == 'date') {
            $product->orderByDesc('proid');
        } else {
            $product->orderBy('proid', 'asc');
        }

     
        $cat = Category::withCount('product')
            ->having('product_count', '>', 0)
            ->get();

        if ($r->size) {
            $product->whereHas('productsize', function ($q) use ($r) {
                $q->whereIn('size', $r->size);
            });
        }
        $minPrice =  $product->min('price');
        $maxPrice =  $product->max('price');
        if ($r->min_price && $r->max_price) {
            $product->whereBetween('price', [$r->min_price, $r->max_price]);
        }

        $product = $product->paginate(12)->withQueryString();

        return view('user.shop', compact('product', 'cat', 'minPrice', 'maxPrice','wishlistIds'));
    }
}
