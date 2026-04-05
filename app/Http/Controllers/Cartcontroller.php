<?php

// ── routes/web.php ─────────────────────────────────────────────────────────
// Route::get('/cart',         [CartController::class, 'index']    )->name('cart.index');

// ──────────────────────────────────────────────────────────────────────────

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // ── Cart page ─────────────────────────────────────────────────
    

    // ── Add or increment ──────────────────────────────────────────
    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status'  => 'login',
                'message' => 'Please log in to add items to your cart.',
            ]);
        }

        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,proid'],
            'size'       => ['nullable', 'string', 'max:10'],
            'qty'        => ['nullable', 'integer', 'min:1'],
        ]);

        $productId = $validated['product_id'];
        $size      = $validated['size'] ?? null;
        $qty       = $validated['qty']  ?? 1;
        $userId    = Auth::id();

        $cartItem = Cart::where('user_id', $userId)
                        ->where('proid', $productId)
                        ->where('size', $size)
                        ->first();

        if ($cartItem) {
            $cartItem->increment('qty', $qty);

            return response()->json([
                'status'     => 'updated',
                'message'    => 'Cart quantity updated!',
                'cart_count' => Cart::where('user_id', $userId)->sum('qty'),
            ]);
        }

        Cart::create([
            'user_id' => $userId,
            'proid'   => $productId,
            'qty'     => $qty,
            'size'    => $size,
        ]);

        $newItem = Cart::where('user_id', $userId)
                       ->where('proid', $productId)
                       ->where('size', $size)
                       ->latest('cart_id')
                       ->first();

        return response()->json([
            'status'     => 'added',
            'message'    => 'Item added to your cart!',
            'cart_id'    => $newItem->cart_id,
            'cart_count' => Cart::where('user_id', $userId)->sum('qty'),
        ]);
    }

    // ── Update qty (+/-) ──────────────────────────────────────────
    public function updateQty(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'login']);
        }

        $validated = $request->validate([
            'cart_id' => ['required', 'integer', 'exists:carts,cart_id'],
            'action'  => ['required', 'in:increment,decrement'],
        ]);

        $cartItem = Cart::with('product')
                        ->where('cart_id', $validated['cart_id'])
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        if ($validated['action'] === 'increment') {
            $cartItem->increment('qty');
        } else {
            if ($cartItem->qty <= 1) {
                $cartItem->delete();

                return response()->json([
                    'status'     => 'removed',
                    'cart_id'    => $validated['cart_id'],
                    'subtotal'   => '₹' . number_format($this->getSubtotal(), 2),
                    'cart_count' => Cart::where('user_id', Auth::id())->sum('qty'),
                ]);
            }
            $cartItem->decrement('qty');
        }

        $cartItem->refresh();
        $lineTotal = ($cartItem->product->price ?? 0) * $cartItem->qty;

        return response()->json([
            'status'     => 'updated',
            'cart_id'    => $cartItem->cart_id,
            'new_qty'    => $cartItem->qty,
            'line_total' => '₹' . number_format($lineTotal, 2),
            'subtotal'   => '₹' . number_format($this->getSubtotal(), 2),
            'cart_count' => Cart::where('user_id', Auth::id())->sum('qty'),
        ]);
    }

    // ── Remove single item ────────────────────────────────────────
    public function remove(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'login']);
        }

        $validated = $request->validate([
            'cart_id' => ['required', 'integer', 'exists:carts,cart_id'],
        ]);

        Cart::where('cart_id', $validated['cart_id'])
            ->where('user_id', Auth::id())
            ->delete();

        return response()->json([
            'status'     => 'removed',
            'cart_id'    => $validated['cart_id'],
            'subtotal'   => '₹' . number_format($this->getSubtotal(), 2),
            'cart_count' => Cart::where('user_id', Auth::id())->sum('qty'),
        ]);
    }

    // ── Clear entire cart ─────────────────────────────────────────
    public function clear()
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'login']);
        }

        Cart::where('user_id', Auth::id())->delete();

        return response()->json([
            'status'  => 'cleared',
            'message' => 'Your cart has been cleared.',
        ]);
    }

    // ── Private: recalculate subtotal ─────────────────────────────
    private function getSubtotal(): float
    {
        return Cart::with('product')
                   ->where('user_id', Auth::id())
                   ->get()
                   ->sum(fn($item) => ($item->product->price ?? 0) * $item->qty);
    }
}