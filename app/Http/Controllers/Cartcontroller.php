<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Productsize;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cartremove($id)
    {
        $cartItem = Cart::find($id);

        if ($cartItem) {
            // Restore stock on remove
            $sizeRow = Productsize::where('proid', $cartItem->proid)
                ->where('size', $cartItem->size)
                ->first();
            if ($sizeRow) {
                $sizeRow->stock += $cartItem->qty;
                $sizeRow->save();
            }
            $cartItem->delete();
        }

        return redirect('user/cart');
    }

    public function cart()
    {
        $cart = Cart::with(['product.size'])
            ->where('user_id', Auth::id())
            ->get()
            ->map(function ($item) {
                $item->selected_size = $item->product->size
                    ->where('size', $item->size)
                    ->first();
                return $item;
            });

        return view('user.cart', compact('cart'));
    }

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
            $sizeRow = Productsize::where('proid', $productId)
                ->where('size', $size)
                ->first();
            if ($sizeRow) {
                $sizeRow->stock = max(0, $sizeRow->stock - $qty);
                $sizeRow->save();
            }

            $cartItem->increment('qty', $qty);

            return response()->json([
                'status'     => 'updated',
                'message'    => 'Cart quantity updated!',
                'cart_count' => Cart::where('user_id', $userId)->sum('qty'),
            ]);
        }

        $sizeRow = Productsize::where('proid', $productId)
            ->where('size', $size)
            ->first();
        if ($sizeRow) {
            $sizeRow->stock = max(0, $sizeRow->stock - $qty);
            $sizeRow->save();
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

        $sizeRow = Productsize::where('proid', $cartItem->proid)
            ->where('size', $cartItem->size)
            ->first();

        if ($validated['action'] === 'increment') {
            if ($sizeRow) {
                $sizeRow->stock = max(0, $sizeRow->stock - 1);
                $sizeRow->save();
            }
            $cartItem->increment('qty');
        } else {
            if ($cartItem->qty <= 1) {
                if ($sizeRow) {
                    $sizeRow->stock += 1;
                    $sizeRow->save();
                }
                $cartItem->delete();

                return response()->json([
                    'status'     => 'removed',
                    'cart_id'    => $validated['cart_id'],
                    'subtotal'   => '₹' . number_format($this->getSubtotal(), 2),
                    'cart_count' => Cart::where('user_id', Auth::id())->sum('qty'),
                ]);
            }

            if ($sizeRow) {
                $sizeRow->stock += 1;
                $sizeRow->save();
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

    // ── NEW: Direct quantity input update ─────────────────────────
    public function updateCartQty(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'login']);
        }

        $request->validate([
            'cart_id' => ['required', 'integer', 'exists:carts,cart_id'],
            'qty'     => ['required', 'integer', 'min:1'],
        ]);

        $cartItem = Cart::with('product')
            ->where('cart_id', $request->cart_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $sizeRow = Productsize::where('proid', $cartItem->proid)
            ->where('size', $cartItem->size)
            ->first();

        $newQty = $request->qty;
        $oldQty = $cartItem->qty;
        $diff   = $newQty - $oldQty;

        // Check stock availability
        if ($sizeRow) {
            if ($diff > 0 && $sizeRow->stock < $diff) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Only ' . ($sizeRow->stock + $oldQty) . ' items available in stock',
                ]);
            }
            $sizeRow->stock -= $diff;
            $sizeRow->save();
        }

        $cartItem->qty = $newQty;
        $cartItem->save();

        // Calculate row total with discount
        $price = ($cartItem->product->discount_price && $cartItem->product->discount_price > 0)
            ? $cartItem->product->price - $cartItem->product->discount_price
            : $cartItem->product->price;

        $rowTotal = $price * $newQty;

        // Recalculate full cart totals
        $allCart  = Cart::with('product')->where('user_id', Auth::id())->get();
        $subtotal = 0;
        $discount = 0;

        foreach ($allCart as $item) {
            $subtotal += $item->product->price * $item->qty;
            $discount += ($item->product->discount_price ?? 0) * $item->qty;
        }

        return response()->json([
            'status'    => 'success',
            'message'   => 'Cart updated successfully',
            'row_total' => '₹' . number_format($rowTotal, 2),
            'subtotal'  => '₹' . number_format($subtotal, 2),
            'discount'  => '₹' . number_format($discount, 2),
            'total'     => '₹' . number_format($subtotal - $discount, 2),
        ]);
    }

    public function remove(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'login']);
        }

        $validated = $request->validate([
            'cart_id' => ['required', 'integer', 'exists:carts,cart_id'],
        ]);

        $cartItem = Cart::where('cart_id', $validated['cart_id'])
            ->where('user_id', Auth::id())
            ->first();

        if ($cartItem) {
            $sizeRow = Productsize::where('proid', $cartItem->proid)
                ->where('size', $cartItem->size)
                ->first();
            if ($sizeRow) {
                $sizeRow->stock += $cartItem->qty;
                $sizeRow->save();
            }
            $cartItem->delete();
        }

        return response()->json([
            'status'     => 'removed',
            'cart_id'    => $validated['cart_id'],
            'subtotal'   => '₹' . number_format($this->getSubtotal(), 2),
            'cart_count' => Cart::where('user_id', Auth::id())->sum('qty'),
        ]);
    }

    public function clear()
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'login']);
        }

        $cartItems = Cart::where('user_id', Auth::id())->get();

        foreach ($cartItems as $cartItem) {
            $sizeRow = Productsize::where('proid', $cartItem->proid)
                ->where('size', $cartItem->size)
                ->first();
            if ($sizeRow) {
                $sizeRow->stock += $cartItem->qty;
                $sizeRow->save();
            }
        }

        Cart::where('user_id', Auth::id())->delete();

        return response()->json([
            'status'  => 'cleared',
            'message' => 'Your cart has been cleared.',
        ]);
    }

    private function getSubtotal(): float
    {
        return Cart::with('product')
            ->where('user_id', Auth::id())
            ->get()
            ->sum(fn($item) => ($item->product->price ?? 0) * $item->qty);
    }
}