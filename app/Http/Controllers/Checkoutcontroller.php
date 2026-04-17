<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Productsize;
use App\Models\Coupon;
use App\Models\CouponUsage;
use Razorpay\Api\Api;

class CheckoutController extends Controller
{
    // ── Shipping options (single source of truth) ─────────────
    const SHIPPING_OPTIONS = [
        'free'     => ['label' => 'Standard',  'charge' => 0,   'days' => '7–8 days'],
        'standard' => ['label' => 'Express',   'charge' => 99,  'days' => '3–4 days'],
        'express'  => ['label' => 'Overnight', 'charge' => 199, 'days' => '1–2 days'],
    ];

    // ─────────────────────────────────────────────────────────
    // 1. SHOW CHECKOUT PAGE
    // ─────────────────────────────────────────────────────────
    public function index()
    {
        $cart = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($cart->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        $subtotal = 0;
        $discount = 0;
        foreach ($cart as $item) {
            $subtotal += ($item->product->price ?? 0) * $item->qty;
            $discount += ($item->product->discount_price ?? 0) * $item->qty;
        }

        $total           = $subtotal - $discount;
        $user            = Auth::user();
        $shippingOptions = self::SHIPPING_OPTIONS;

        return view('user.checkout', compact('cart', 'subtotal', 'discount', 'total', 'user', 'shippingOptions'));
    }

    // ─────────────────────────────────────────────────────────
    // 2. APPLY COUPON (AJAX) — one use per user, enforced here
    // ─────────────────────────────────────────────────────────
    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string', 'shipping_charge' => 'nullable|numeric']);

        $coupon = Coupon::where('code', strtoupper(trim($request->code)))
            ->where('status', '1')
            ->first();

        if (!$coupon) {
            return response()->json(['status' => 'error', 'message' => 'Invalid or inactive coupon code.']);
        }

        if ($coupon->expiry_date && $coupon->expiry_date < now()->toDateString()) {
            return response()->json(['status' => 'error', 'message' => 'This coupon has expired.']);
        }

        if (!is_null($coupon->usage_limit) && $coupon->used_count >= $coupon->usage_limit) {
            return response()->json(['status' => 'error', 'message' => 'This coupon has reached its usage limit.']);
        }

        // ✅ BULLETPROOF: Check single-use per user
        $alreadyUsed = CouponUsage::where('coupon_id', $coupon->coupon_id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($alreadyUsed) {
            return response()->json(['status' => 'error', 'message' => 'You have already used this coupon.']);
        }

        // Calculate base (product discount applied, before coupon)
        $cart     = Cart::with('product')->where('user_id', Auth::id())->get();
        $subtotal = 0;
        $discount = 0;
        foreach ($cart as $item) {
            $subtotal += $item->product->price * $item->qty;
            $discount += ($item->product->discount_price ?? 0) * $item->qty;
        }
        $afterProductDiscount = $subtotal - $discount;

        // Apply coupon on product-discounted price (not shipping)
        $couponDiscount = $coupon->type === 'percent'
            ? round($afterProductDiscount * $coupon->discount / 100, 2)
            : (float) $coupon->discount;

        $couponDiscount = min($couponDiscount, $afterProductDiscount);

        $shipping    = (float) ($request->shipping_charge ?? 0);
        $finalAmount = max(0, $afterProductDiscount - $couponDiscount + $shipping);

        return response()->json([
            'status'          => 'success',
            'message'         => 'Coupon applied! You saved ₹' . number_format($couponDiscount, 2),
            'coupon_discount' => $couponDiscount,
            'final_amount'    => $finalAmount,
            'coupon_id'       => $coupon->coupon_id,
        ]);
    }

    // ─────────────────────────────────────────────────────────
    // 3. PLACE ORDER
    // ─────────────────────────────────────────────────────────
    public function placeOrder(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'phone'           => 'required|digits:10',
            'address_line1'   => 'required|string',
            'address_line2'   => 'nullable|string',
            'city'            => 'required|string',
            'state'           => 'required|string',
            'postal_code'     => 'required|string|max:10',
            'payment_method'  => 'required|in:cod,upi,card',
            'shipping_type'   => 'required|in:free,standard,express',
            'coupon_code'     => 'nullable|string',
            'notes'           => 'nullable|string',
        ]);

        $cart = Cart::with('product')->where('user_id', Auth::id())->get();
        if ($cart->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        // ── Totals ────────────────────────────────────────
        $subtotal = 0;
        $discount = 0;
        foreach ($cart as $item) {
            $subtotal += $item->product->price * $item->qty;
            $discount += ($item->product->discount_price ?? 0) * $item->qty;
        }
        $afterProductDiscount = $subtotal - $discount;

        // Shipping
        $shippingType   = $request->shipping_type;
        $shippingCharge = self::SHIPPING_OPTIONS[$shippingType]['charge'] ?? 0;

        // Coupon (re-verify server-side, never trust client)
        $couponDiscount = 0;
        $coupon         = null;

        if ($request->coupon_code) {
            $coupon = Coupon::where('code', strtoupper(trim($request->coupon_code)))
                ->where('status', '1')
                ->first();

            if ($coupon) {
                // ✅ Re-check usage on server side before order creation
                $alreadyUsed = CouponUsage::where('coupon_id', $coupon->coupon_id)
                    ->where('user_id', Auth::id())
                    ->exists();

                if ($alreadyUsed) {
                    return back()->withInput()->with('error', 'That coupon has already been used by your account.');
                }

                if ($coupon->expiry_date && $coupon->expiry_date < now()->toDateString()) {
                    $coupon = null; // expired, skip silently
                } elseif (!is_null($coupon->usage_limit) && $coupon->used_count >= $coupon->usage_limit) {
                    $coupon = null; // exhausted
                } else {
                    $couponDiscount = $coupon->type === 'percent'
                        ? round($afterProductDiscount * $coupon->discount / 100, 2)
                        : (float) $coupon->discount;
                    $couponDiscount = min($couponDiscount, $afterProductDiscount);
                }
            }
        }

        $finalAmount = max(0, $afterProductDiscount - $couponDiscount + $shippingCharge);

        // ── DB Transaction ────────────────────────────────
        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id'         => Auth::id(),
                'order_number'    => 'ORD-' . strtoupper(uniqid()),
                'total_amount'    => $subtotal,
                'discount_amount' => $discount + $couponDiscount,
                'tax_amount'      => 0,
                'shipping_charge' => $shippingCharge,
                'final_amount'    => $finalAmount,
                'payment_method'  => $request->payment_method,
                'payment_status'  => 'pending',
                'status'          => 'pending',
                'name'            => $request->name,
                'phone'           => $request->phone,
                'address_line1'   => $request->address_line1,
                'address_line2'   => $request->address_line2,
                'city'            => $request->city,
                'state'           => $request->state,
                'postal_code'     => $request->postal_code,
                'notes'           => $request->notes,
            ]);

            foreach ($cart as $item) {
                $finalPrice = $item->product->price - ($item->product->discount_price ?? 0);
                OrderItem::create([
                    'order_id'        => $order->id,
                    'product_id'      => $item->proid,
                    'product_name'    => $item->product->proname,
                    'product_image'   => $item->product->proimage,
                    'original_price'  => $item->product->price,
                    'discount_amount' => $item->product->discount_price ?? 0,
                    'tax_amount'      => 0,
                    'final_price'     => $finalPrice,
                    'qty'             => $item->qty,
                    'size'            => $item->size,
                    'subtotal'        => $finalPrice * $item->qty,
                    'status'          => 'active',
                ]);
            }

            // ✅ Record coupon usage (prevents double-use)
            if ($coupon) {
                CouponUsage::create([
                    'coupon_id' => $coupon->coupon_id,
                    'user_id'   => Auth::id(),
                    'order_id'  => $order->id,
                ]);
                $coupon->increment('used_count');
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Order could not be placed. Please try again.');
        }

        switch ($request->payment_method) {
            case 'card': return $this->razorpayPayment($order);
            case 'upi':  return $this->upiQR($order);
            case 'cod':  return $this->sendOtp($order);
        }
    }

    // ─────────────────────────────────────────────────────────
    // 4. CARD → RAZORPAY
    // ─────────────────────────────────────────────────────────
    private function razorpayPayment(Order $order)
    {
        $api           = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $razorpayOrder = $api->order->create([
            'receipt'  => $order->order_number,
            'amount'   => (int)($order->final_amount * 100),
            'currency' => 'INR',
            'notes'    => ['order_id' => $order->id, 'customer' => $order->name],
        ]);

        $order->update(['razorpay_order_id' => $razorpayOrder['id']]);

        return view('user.razorpay', [
            'order'     => $order,
            'rzp_key'   => env('RAZORPAY_KEY'),
            'rzp_order' => $razorpayOrder['id'],
            'amount'    => (int)($order->final_amount * 100),
            'user'      => Auth::user(),
        ]);
    }

    // ─────────────────────────────────────────────────────────
    // 5. RAZORPAY SUCCESS CALLBACK
    // ─────────────────────────────────────────────────────────
    public function razorpaySuccess(Request $request)
    {
        $request->validate([
            'razorpay_order_id'   => 'required',
            'razorpay_payment_id' => 'required',
            'razorpay_signature'  => 'required',
        ]);

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);
        } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {
            return redirect()->route('checkout.failed')->with('error', 'Payment verification failed.');
        }

        $order = Order::where('razorpay_order_id', $request->razorpay_order_id)->first();
        if ($order) {
            $order->update([
                'payment_status'      => 'paid',
                'status'              => 'confirmed',
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);
            Cart::where('user_id', $order->user_id)->delete();
        }

        return redirect()->route('checkout.success', $order->id);
    }

    // ─────────────────────────────────────────────────────────
    // 6. UPI → QR CODE
    // ─────────────────────────────────────────────────────────
    private function upiQR(Order $order)
    {
        $upiId    = env('UPI_ID', 'yourshop@okaxis');
        $shopName = env('APP_NAME', 'MyShop');
        $qrString = "upi://pay?pa={$upiId}&pn=" . urlencode($shopName)
            . "&am={$order->final_amount}&cu=INR"
            . "&tn=" . urlencode('Order ' . $order->order_number);

        return view('user.upi', compact('order', 'qrString'));
    }

    // ─────────────────────────────────────────────────────────
    // 7. UPI CONFIRM ("I Paid")
    // ─────────────────────────────────────────────────────────
    public function upiConfirm(Request $request)
    {
        $request->validate(['order_id' => 'required|integer|exists:orders,id']);

        $order = Order::where('id', $request->order_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $order->update(['status' => 'confirmed']);
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('checkout.success', $order->id)
            ->with('info', 'Your UPI payment will be verified shortly.');
    }

    // ─────────────────────────────────────────────────────────
    // 8. COD → SEND OTP
    // ─────────────────────────────────────────────────────────
    private function sendOtp(Order $order)
    {
        $otp  = rand(100000, 999999);
        $user = Auth::user();

        $order->update(['otp' => $otp, 'otp_verified' => false]);

        Mail::raw(
            "Dear {$user->name},\n\nYour OTP to confirm COD order #{$order->order_number} is:\n\n{$otp}\n\nValid for 10 minutes. Do not share this with anyone.\n\nThank you!",
            fn($msg) => $msg->to($user->email)->subject("OTP for Order #{$order->order_number}")
        );

        return view('user.otp', compact('order'));
    }

    // ─────────────────────────────────────────────────────────
    // 9. RESEND OTP
    // ─────────────────────────────────────────────────────────
    public function resendOtp(Request $request)
    {
        $request->validate(['order_id' => 'required|integer|exists:orders,id']);

        $order = Order::where('id', $request->order_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $otp  = rand(100000, 999999);
        $user = Auth::user();

        $order->update(['otp' => $otp]);

        Mail::raw(
            "Your new OTP for order #{$order->order_number} is: {$otp}",
            fn($msg) => $msg->to($user->email)->subject("New OTP — Order #{$order->order_number}")
        );

        return response()->json(['status' => 'success', 'message' => 'OTP resent to ' . $user->email]);
    }

    // ─────────────────────────────────────────────────────────
    // 10. VERIFY OTP
    // ─────────────────────────────────────────────────────────
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'otp'      => 'required|digits:6',
        ]);

        $order = Order::where('id', $request->order_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ((string)$order->otp !== (string)$request->otp) {
            return response()->json(['status' => 'error', 'message' => 'Incorrect OTP. Please try again.']);
        }

        $order->update([
            'otp_verified'   => true,
            'payment_status' => 'pending',
            'status'         => 'confirmed',
        ]);

        Cart::where('user_id', Auth::id())->delete();

        return response()->json([
            'status'   => 'success',
            'message'  => 'Order confirmed!',
            'redirect' => route('checkout.success', $order->id),
        ]);
    }

    // ─────────────────────────────────────────────────────────
    // 11. SUCCESS PAGE
    // ─────────────────────────────────────────────────────────
    public function success($orderId)
    {
        $order = Order::with('items')
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $shippingOptions = self::SHIPPING_OPTIONS;

        return view('user.success', compact('order', 'shippingOptions'));
    }

    // ─────────────────────────────────────────────────────────
    // 12. FAILED PAGE
    // ─────────────────────────────────────────────────────────
    public function failed()
    {
        return view('checkout.failed');
    }

    // ─────────────────────────────────────────────────────────
    // 13. RAZORPAY WEBHOOK
    // ─────────────────────────────────────────────────────────
    public function razorpayWebhook(Request $request)
    {
        $secret    = env('RAZORPAY_WEBHOOK_SECRET');
        $signature = $request->header('X-Razorpay-Signature');
        $payload   = $request->getContent();

        if (!hash_equals(hash_hmac('sha256', $payload, $secret), $signature)) {
            return response()->json(['status' => 'invalid signature'], 400);
        }

        $event = $request->input('event');
        $data  = $request->input('payload.payment.entity');

        if ($event === 'payment.captured' && $data) {
            $order = Order::where('razorpay_order_id', $data['order_id'])->first();
            if ($order && $order->payment_status !== 'paid') {
                $order->update([
                    'payment_status'      => 'paid',
                    'status'              => 'confirmed',
                    'razorpay_payment_id' => $data['id'],
                ]);
                Cart::where('user_id', $order->user_id)->delete();
            }
        }

        return response()->json(['status' => 'ok']);
    }
}