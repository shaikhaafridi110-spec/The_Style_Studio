<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsershopController extends Controller
{
    
    public function shop(Request $r, $name = null)
    {
        // ── Base query ────────────────────────────────────────────
        // We do NOT filter by status here — inactive products are
        // shown on the page but rendered as disabled/unavailable.
        // If you want to HIDE inactive products entirely, uncomment:
        // ->where('status', 'active')
        $query = Product::with(['category', 'reviews', 'productsize'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        // ── Category via route segment ────────────────────────────
        if ($name) {
            $query->whereHas('category', fn($q) => $q->where('slug', $name));
        }

        // ── Category filter (sidebar checkboxes) ──────────────────
        if ($r->filled('category')) {
            $query->whereHas('category', fn($q) => $q->whereIn('slug', $r->category));
        }

        // ── Search ────────────────────────────────────────────────
        if ($r->filled('search')) {
            $query->where('proname', 'like', "%{$r->search}%");
        }

        // ── Size filter ───────────────────────────────────────────
        if ($r->filled('size')) {
            $query->whereHas('productsize', fn($q) => $q->whereIn('size', $r->size));
        }

        // ── Price range: capture GLOBAL min/max BEFORE price filter
        //    Clone so category/search/size are respected but price
        //    filter itself doesn't shrink the slider bounds.
        $boundsQuery = clone $query;
        $minPrice    = (int) ($boundsQuery->min('price') ?? 0);
        $maxPrice    = (int) ($boundsQuery->max('price') ?? 9999);

        // ── Price filter (applied AFTER bounds are captured) ──────
        if ($r->filled('min_price') && $r->filled('max_price')) {
            $query->whereBetween('price', [(int) $r->min_price, (int) $r->max_price]);
        }

        // ── Sorting ───────────────────────────────────────────────
        if ($r->sortby === 'popularity') {
            $topIds = OrderItem::select('product_id')
                ->groupBy('product_id')
                ->orderByRaw('SUM(qty) DESC')
                ->pluck('product_id')
                ->toArray();

            if (!empty($topIds)) {
                $ids = implode(',', $topIds);
                $query->whereIn('proid', $topIds)
                    ->orderByRaw("FIELD(proid, $ids)");
            }
        } elseif ($r->sortby === 'rating') {
            $query->orderByDesc('reviews_avg_rating');
        } elseif ($r->sortby === 'date') {
            $query->orderByDesc('proid');
        } elseif ($r->sortby === 'price_low') {
            // Final price = price - discount_price (when discount > 0), else price
            $query->orderByRaw('(price - IF(discount_price > 0, discount_price, 0)) ASC');
        } elseif ($r->sortby === 'price_high') {
            $query->orderByRaw('(price - IF(discount_price > 0, discount_price, 0)) DESC');
        } else {
            $query->orderBy('proid', 'asc');
        }

        // ── Sidebar categories (only non-empty ones) ──────────────
        $cat = Category::withCount('product')
            ->having('product_count', '>', 0)
            ->get();

        // ── Wishlist IDs for current user ─────────────────────────
        $wishlistIds = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('proid')->toArray()
            : [];

        // ── Cart items (guests get empty collection) ──────────────
        $cartItems = Auth::check()
            ? Cart::with('product')->where('user_id', Auth::id())->get()
            : collect();

        // ── Subtotal (respects discount_price) ────────────────────
        $subtotal = $cartItems->sum(function ($item) {
            $price    = $item->product->price ?? 0;
            $discount = $item->product->discount_price ?? 0;
            return ($price - $discount) * $item->qty;
        });

        // ── Paginate ──────────────────────────────────────────────
        $product = $query->paginate(12)->withQueryString();

        return view('user.shop', compact(
            'product',
            'cat',
            'minPrice',
            'maxPrice',
            'wishlistIds',
            'cartItems',
            'subtotal'
        ));
    }
}
