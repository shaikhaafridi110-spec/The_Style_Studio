<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class UsershopController extends Controller
{
    public function shop(Request $r, $name = null)
{
    $product = Product::with('category', 'reviews')
        ->withCount('reviews')
        ->withAvg('reviews', 'rating');

    // 🔍 SEARCH
    if ($r->search) {
        $product->where('proname', 'like', "%{$r->search}%");
    }

    // 📂 CATEGORY FROM URL
    if ($name) {
        $product->whereHas('category', function ($q) use ($name) {
            $q->where('slug', $name);
        });
    }

    // ✅ LEFT SIDEBAR MULTI CATEGORY FILTER
   if ($r->category) {
        $product->whereHas('category', function ($q) use ($r) {
            $q->whereIn('slug', $r->category);
        });
    }

    // 🔥 POPULARITY IDS
    $topIds = OrderItem::select('product_id')
        ->groupBy('product_id')
        ->orderByRaw('SUM(qty) DESC')
        ->pluck('product_id')
        ->toArray();

    // 🔽 SORTING (AFTER FILTERS)
    if ($r->sortby == 'popularity' && !empty($topIds)) {
        $ids = implode(',', $topIds);

        $product->whereIn('proid', $topIds)
                ->orderByRaw("FIELD(proid, $ids)");
    } 
    elseif ($r->sortby == 'rating') {
        $product->orderByDesc('reviews_avg_rating');
    } 
    else {
        $product->orderByDesc('proid');
    }

    // 📂 CATEGORY LIST WITH COUNT
  $cat = Category::withCount('product')
        ->having('product_count', '>', 0)
        ->get(); 

    // 📦 PAGINATION
    $product = $product->paginate(12)->withQueryString();

    return view('user.shop', compact('product', 'cat'));
}
}
