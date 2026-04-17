{{-- resources/views/checkout/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="64x64" href="{{asset('user/assets/images/logo11.png')}}">
    <style>
        * { font-family: 'Sora', sans-serif; }
        body { background: #f4f4f0; }

        /* ── Progress Bar ── */
        .checkout-steps { display:flex; align-items:center; gap:0; margin-bottom:2rem; }
        .step { display:flex; flex-direction:column; align-items:center; flex:1; position:relative; }
        .step-circle {
            width:38px; height:38px; border-radius:50%;
            display:flex; align-items:center; justify-content:center;
            font-weight:700; font-size:.8rem; z-index:1;
            border: 2px solid #ddd; background:#fff; color:#aaa;
            transition: all .3s;
        }
        .step.active   .step-circle { background:#111; border-color:#111; color:#fff; }
        .step.done     .step-circle { background:#22c55e; border-color:#22c55e; color:#fff; }
        .step-label { font-size:.7rem; margin-top:.35rem; color:#aaa; font-weight:500; }
        .step.active .step-label, .step.done .step-label { color:#111; font-weight:600; }
        .step-line { flex:1; height:2px; background:#ddd; margin-top:-18px; z-index:0; }
        .step-line.done { background:#22c55e; }

        /* ── Cards ── */
        .ck-card {
            background:#fff; border-radius:16px; border:none;
            box-shadow: 0 1px 3px rgba(0,0,0,.07), 0 4px 12px rgba(0,0,0,.05);
            margin-bottom:1.25rem; overflow:hidden;
        }
        .ck-card-header {
            padding:1.1rem 1.4rem .8rem;
            border-bottom:1px solid #f0f0f0;
            display:flex; align-items:center; gap:.6rem;
        }
        .ck-card-header .icon {
            width:34px; height:34px; border-radius:10px;
            display:flex; align-items:center; justify-content:center;
            font-size:1rem;
        }
        .ck-card-header h6 { margin:0; font-weight:700; font-size:.95rem; }
        .ck-card-body { padding:1.4rem; }

        /* ── Form ── */
        .form-control, .form-select {
            border-radius:10px; border:1.5px solid #e8e8e8;
            padding:.65rem .9rem; font-size:.875rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus, .form-select:focus {
            border-color:#111; box-shadow:0 0 0 3px rgba(17,17,17,.07);
        }
        .form-label { font-size:.8rem; font-weight:600; color:#555; margin-bottom:.4rem; }

        /* ── Shipping Options ── */
        .ship-option { display:none; }
        .ship-label {
            display:flex; align-items:center; gap:1rem;
            border:2px solid #e8e8e8; border-radius:14px;
            padding:1rem 1.1rem; cursor:pointer;
            transition: all .2s; background:#fff;
            margin-bottom:.75rem;
        }
        .ship-label:last-of-type { margin-bottom:0; }
        .ship-option:checked + .ship-label {
            border-color:#111; background:#fafafa;
        }
        .ship-icon {
            width:42px; height:42px; border-radius:12px;
            display:flex; align-items:center; justify-content:center;
            font-size:1.3rem; flex-shrink:0;
        }
        .ship-icon.free     { background:#dcfce7; }
        .ship-icon.standard { background:#dbeafe; }
        .ship-icon.express  { background:#fef3c7; }
        .ship-info { flex:1; }
        .ship-name { font-weight:700; font-size:.88rem; color:#111; }
        .ship-days { font-size:.76rem; color:#888; margin-top:.1rem; }
        .ship-price { font-weight:700; font-size:.95rem; }
        .ship-price.free-tag { color:#22c55e; }
        .ship-badge {
            font-size:.65rem; padding:.2rem .5rem; border-radius:20px;
            font-weight:600; display:inline-block; margin-left:.4rem;
        }

        /* ── Payment Options ── */
        .pay-option { display:none; }
        .pay-label {
            display:flex; align-items:center; gap:.9rem;
            border:2px solid #e8e8e8; border-radius:14px;
            padding:.9rem 1.1rem; cursor:pointer;
            transition: all .2s; background:#fff;
            margin-bottom:.75rem;
        }
        .pay-label:last-of-type { margin-bottom:0; }
        .pay-option:checked + .pay-label {
            border-color:#111; background:#fafafa;
        }
        .pay-icon {
            width:40px; height:40px; border-radius:11px;
            display:flex; align-items:center; justify-content:center;
            font-size:1.2rem; flex-shrink:0;
        }
        .pay-icon.card { background:#ede9fe; }
        .pay-icon.upi  { background:#d1fae5; }
        .pay-icon.cod  { background:#fef9c3; }
        .pay-name { font-weight:700; font-size:.88rem; color:#111; }
        .pay-desc { font-size:.74rem; color:#888; margin-top:.1rem; }

        /* ── Custom Radio Dot ── */
        .radio-dot {
            width:20px; height:20px; border-radius:50%;
            border:2px solid #ddd; background:#fff;
            display:flex; align-items:center; justify-content:center;
            flex-shrink:0; margin-left:auto; transition: all .2s;
        }
        .ship-option:checked + .ship-label .radio-dot,
        .pay-option:checked  + .pay-label  .radio-dot  {
            border-color:#111; background:#111;
            box-shadow: inset 0 0 0 4px #fff;
        }

        /* ── Summary Card ── */
        .summary-card { position:sticky; top:16px; }
        .cart-item-row { display:flex; align-items:center; gap:.75rem; padding:.5rem 0; }
        .cart-item-img { width:54px; height:54px; border-radius:10px; object-fit:cover; border:1.5px solid #eee; }
        .cart-item-name { font-size:.82rem; font-weight:600; color:#111; }
        .cart-item-meta { font-size:.73rem; color:#999; }
        .total-row { display:flex; justify-content:space-between; align-items:center; padding:.3rem 0; font-size:.85rem; }
        .total-row.grand { font-size:1.1rem; font-weight:700; padding-top:.5rem; border-top:2px solid #f0f0f0; margin-top:.3rem; }

        /* ── Coupon ── */
        .coupon-wrap { display:flex; gap:.5rem; }
        .coupon-input {
            flex:1; border:2px dashed #ddd; border-radius:10px;
            padding:.6rem 1rem; font-size:.85rem; font-weight:600;
            letter-spacing:.08em; text-transform:uppercase;
            outline:none; transition: border-color .2s;
        }
        .coupon-input:focus { border-color:#111; border-style:solid; }
        .coupon-input.applied { border-color:#22c55e; border-style:solid; background:#f0fdf4; color:#16a34a; }
        .coupon-btn {
            border:none; background:#111; color:#fff; border-radius:10px;
            padding:.6rem 1.2rem; font-size:.82rem; font-weight:700;
            cursor:pointer; transition: background .2s; white-space:nowrap;
        }
        .coupon-btn:hover { background:#333; }
        .coupon-btn:disabled { background:#aaa; cursor:not-allowed; }

        /* ── Place Order Button ── */
        .place-btn {
            width:100%; background:#111; color:#fff;
            border:none; border-radius:14px; padding:1rem;
            font-size:1rem; font-weight:700; cursor:pointer;
            transition: all .2s; letter-spacing:.02em;
            display:flex; align-items:center; justify-content:center; gap:.5rem;
        }
        .place-btn:hover { background:#222; transform:translateY(-1px); box-shadow:0 6px 20px rgba(0,0,0,.18); }
        .place-btn:active { transform:translateY(0); }
        .place-btn:disabled { background:#aaa; cursor:not-allowed; transform:none; box-shadow:none; }

        /* ── Misc ── */
        .secure-badge { display:flex; align-items:center; justify-content:center; gap:.4rem; color:#999; font-size:.75rem; margin-top:.75rem; }
        .alert-custom { border-radius:12px; font-size:.84rem; padding:.75rem 1rem; border:none; }
        .saving-tag { background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0; border-radius:8px; padding:.4rem .8rem; font-size:.78rem; font-weight:600; }
    </style>
</head>
<body>

@if(session('error'))
<div style="background:#fee2e2;color:#b91c1c;padding:.7rem 1.4rem;font-size:.85rem;font-weight:600;text-align:center;">
    ⚠️ {{ session('error') }}
</div>
@endif

<div class="container py-4" style="max-width:1140px">

    {{-- ── Page Header ── --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ url()->previous() }}" class="btn btn-sm btn-light rounded-circle" style="width:36px;height:36px;padding:0;display:flex;align-items:center;justify-content:center;">←</a>
        <h4 class="mb-0 fw-bold">Checkout</h4>
    </div>

    {{-- ── Steps ── --}}
    <div class="checkout-steps mb-4">
        <div class="step done">
            <div class="step-circle">✓</div>
            <div class="step-label">Cart</div>
        </div>
        <div class="step-line done"></div>
        <div class="step active">
            <div class="step-circle">2</div>
            <div class="step-label">Checkout</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">3</div>
            <div class="step-label">Payment</div>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">4</div>
            <div class="step-label">Confirmed</div>
        </div>
    </div>

    <form id="checkoutForm" action="{{ route('checkout.placeOrder') }}" method="POST">
        @csrf

        <div class="row g-4">

            {{-- ══════════════ LEFT COLUMN ══════════════ --}}
            <div class="col-lg-7">

                {{-- ── 1. Delivery Address ── --}}
                <div class="ck-card">
                    <div class="ck-card-header">
                        <div class="icon" style="background:#ede9fe">📍</div>
                        <h6>Delivery Address</h6>
                    </div>
                    <div class="ck-card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name *</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required placeholder="John Doe">
                                @error('name')<div class="text-danger" style="font-size:.76rem;margin-top:.3rem">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number *</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required maxlength="10" placeholder="10-digit number">
                                @error('phone')<div class="text-danger" style="font-size:.76rem;margin-top:.3rem">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address Line 1 *</label>
                                <input type="text" name="address_line1" class="form-control" value="{{ old('address_line1', $user->address_line1) }}" required placeholder="Flat / House no, Street name">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Address Line 2 <span style="color:#bbb;font-weight:400">(optional)</span></label>
                                <input type="text" name="address_line2" class="form-control" value="{{ old('address_line2', $user->address_line2) }}" placeholder="Landmark, Area">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">City *</label>
                                <input type="text" name="city" class="form-control" value="{{ old('city', $user->city) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">State *</label>
                                <input type="text" name="state" class="form-control" value="{{ old('state', $user->state) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Pincode *</label>
                                <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $user->postal_code) }}" required maxlength="6">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Order Notes <span style="color:#bbb;font-weight:400">(optional)</span></label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="Special delivery instructions…"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── 2. Shipping Method ── --}}
                <div class="ck-card">
                    <div class="ck-card-header">
                        <div class="icon" style="background:#dbeafe">🚚</div>
                        <h6>Shipping Method</h6>
                    </div>
                    <div class="ck-card-body">

                        {{-- Free --}}
                        <input type="radio" name="shipping_type" id="ship_free" value="free"
                            class="ship-option" data-charge="0" checked>
                        <label for="ship_free" class="ship-label">
                            <div class="ship-icon free">📦</div>
                            <div class="ship-info">
                                <div class="ship-name">
                                    Standard Delivery
                                    <span class="ship-badge" style="background:#dcfce7;color:#16a34a">FREE</span>
                                </div>
                                <div class="ship-days">📅 Estimated 7–8 business days</div>
                            </div>
                            <div class="ship-price free-tag">FREE</div>
                            <div class="radio-dot"></div>
                        </label>

                        {{-- Standard (3-4 days) --}}
                        <input type="radio" name="shipping_type" id="ship_standard" value="standard"
                            class="ship-option" data-charge="{{ $shippingOptions['standard']['charge'] }}">
                        <label for="ship_standard" class="ship-label">
                            <div class="ship-icon standard">⚡</div>
                            <div class="ship-info">
                                <div class="ship-name">
                                    Express Delivery
                                    <span class="ship-badge" style="background:#dbeafe;color:#2563eb">POPULAR</span>
                                </div>
                                <div class="ship-days">📅 Estimated 3–4 business days</div>
                            </div>
                            <div class="ship-price">₹{{ $shippingOptions['standard']['charge'] }}</div>
                            <div class="radio-dot"></div>
                        </label>

                        {{-- Express (1-2 days) --}}
                        <input type="radio" name="shipping_type" id="ship_express" value="express"
                            class="ship-option" data-charge="{{ $shippingOptions['express']['charge'] }}">
                        <label for="ship_express" class="ship-label">
                            <div class="ship-icon express">🏎️</div>
                            <div class="ship-info">
                                <div class="ship-name">
                                    Overnight Delivery
                                    <span class="ship-badge" style="background:#fef3c7;color:#d97706">FASTEST</span>
                                </div>
                                <div class="ship-days">📅 Estimated 1–2 business days</div>
                            </div>
                            <div class="ship-price">₹{{ $shippingOptions['express']['charge'] }}</div>
                            <div class="radio-dot"></div>
                        </label>

                    </div>
                </div>

                {{-- ── 3. Payment Method ── --}}
                <div class="ck-card">
                    <div class="ck-card-header">
                        <div class="icon" style="background:#fef9c3">💳</div>
                        <h6>Payment Method</h6>
                    </div>
                    <div class="ck-card-body">

                        {{-- Card --}}
                        <input type="radio" name="payment_method" id="pay_card" value="card" class="pay-option">
                        <label for="pay_card" class="pay-label">
                            <div class="pay-icon card">💳</div>
                            <div class="flex-grow-1">
                                <div class="pay-name">Credit / Debit Card</div>
                                <div class="pay-desc">Visa, Mastercard, RuPay — secured by Razorpay</div>
                            </div>
                            <img src="https://razorpay.com/favicon.ico" alt="" height="18" style="opacity:.6">
                            <div class="radio-dot"></div>
                        </label>

                        {{-- UPI --}}
                        <input type="radio" name="payment_method" id="pay_upi" value="upi" class="pay-option">
                        <label for="pay_upi" class="pay-label">
                            <div class="pay-icon upi">📱</div>
                            <div class="flex-grow-1">
                                <div class="pay-name">UPI Payment</div>
                                <div class="pay-desc">GPay, PhonePe, Paytm — scan QR to pay instantly</div>
                            </div>
                            <div class="radio-dot"></div>
                        </label>

                        {{-- COD --}}
                        <input type="radio" name="payment_method" id="pay_cod" value="cod" class="pay-option" checked>
                        <label for="pay_cod" class="pay-label">
                            <div class="pay-icon cod">💵</div>
                            <div class="flex-grow-1">
                                <div class="pay-name">Cash on Delivery</div>
                                <div class="pay-desc">Pay when your order arrives — OTP verification required</div>
                            </div>
                            <div class="radio-dot"></div>
                        </label>

                    </div>
                </div>

            </div>{{-- /col-lg-7 --}}

            {{-- ══════════════ RIGHT: ORDER SUMMARY ══════════════ --}}
            <div class="col-lg-5">
                <div class="summary-card">

                    <div class="ck-card">
                        <div class="ck-card-header">
                            <div class="icon" style="background:#fce7f3">🛍️</div>
                            <h6>Order Summary</h6>
                            <span class="ms-auto" style="font-size:.78rem;color:#aaa">{{ $cart->count() }} item(s)</span>
                        </div>
                        <div class="ck-card-body">

                            {{-- Cart Items --}}
                            @foreach($cart as $item)
                            @php $price = $item->product->price - ($item->product->discount_price ?? 0); @endphp
                            <div class="cart-item-row">
                                <div style="position:relative">
                                    <img src="{{ asset('admin/assets/images/' . $item->product->proimage) }}"
                                        alt="{{ $item->product->proname }}"
                                        class="cart-item-img"
                                        onerror="this.src='https://via.placeholder.com/54x54?text=IMG'">
                                    <span style="position:absolute;top:-6px;right:-6px;background:#111;color:#fff;border-radius:50%;width:19px;height:19px;font-size:.65rem;display:flex;align-items:center;justify-content:center;font-weight:700">{{ $item->qty }}</span>
                                </div>
                                <div style="flex:1;min-width:0">
                                    <div class="cart-item-name text-truncate">{{ $item->product->proname }}</div>
                                    @if($item->size)<div class="cart-item-meta">Size: {{ $item->size }}</div>@endif
                                </div>
                                <div style="font-size:.88rem;font-weight:700;color:#111;white-space:nowrap">
                                    ₹{{ number_format($price * $item->qty, 2) }}
                                </div>
                            </div>
                            @endforeach

                            <div style="border-top:1.5px dashed #e8e8e8;margin:1rem 0"></div>

                            {{-- Coupon --}}
                            <div style="margin-bottom:1rem">
                                <label style="font-size:.78rem;font-weight:700;color:#555;display:block;margin-bottom:.5rem">🏷️ Coupon Code</label>
                                <div class="coupon-wrap">
                                    <input type="text" id="couponInput" name="coupon_code"
                                        class="coupon-input"
                                        placeholder="ENTER CODE"
                                        autocomplete="off">
                                    <button type="button" class="coupon-btn" onclick="applyCoupon()" id="couponBtn">Apply</button>
                                </div>
                                <div id="couponMsg" style="margin-top:.4rem;font-size:.78rem;min-height:1.2rem"></div>
                            </div>

                            <div style="border-top:1.5px dashed #e8e8e8;margin-bottom:1rem"></div>

                            {{-- Totals --}}
                            <div class="total-row">
                                <span style="color:#777">Subtotal</span>
                                <span style="font-weight:600">₹{{ number_format($subtotal, 2) }}</span>
                            </div>
                            @if($discount > 0)
                            <div class="total-row" style="color:#16a34a">
                                <span>Product Discount</span>
                                <span style="font-weight:600">− ₹{{ number_format($discount, 2) }}</span>
                            </div>
                            @endif
                            <div class="total-row" id="couponRow" style="display:none;color:#16a34a">
                                <span>Coupon Discount</span>
                                <span style="font-weight:600" id="couponDiscAmt">− ₹0.00</span>
                            </div>
                            <div class="total-row" id="shippingRow">
                                <span style="color:#777">Shipping</span>
                                <span id="shippingAmt" style="color:#16a34a;font-weight:600">FREE</span>
                            </div>

                            <div class="total-row grand">
                                <span>Total</span>
                                <span id="grandTotal">₹{{ number_format($total, 2) }}</span>
                            </div>

                            {{-- Savings tag --}}
                            <div id="savingsTag" style="display:none;margin-top:.5rem">
                                <div class="saving-tag" id="savingsText"></div>
                            </div>

                            {{-- Hidden fields --}}
                            <input type="hidden" id="shippingChargeInput" name="shipping_charge_display" value="0">

                            <button type="submit" class="place-btn mt-4" id="placeBtn">
                                <span id="placeBtnText">Place Order</span>
                                <span>→</span>
                            </button>

                            <div class="secure-badge">
                                🔒 100% Secure &amp; Encrypted Checkout
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>{{-- /row --}}
    </form>
</div>

<script>
// ── State ─────────────────────────────────────────────────────
let baseTotal       = {{ $total }};     // after product discount, before coupon+ship
let couponSaving    = 0;
let shippingCharge  = 0;
let couponApplied   = false;

// ── Recompute & refresh UI ─────────────────────────────────────
function refreshTotals() {
    const grand = Math.max(0, baseTotal - couponSaving + shippingCharge);
    document.getElementById('grandTotal').textContent = '₹' + grand.toFixed(2);

    // Shipping display
    const shipEl = document.getElementById('shippingAmt');
    if (shippingCharge === 0) {
        shipEl.textContent = 'FREE';
        shipEl.style.color = '#16a34a';
    } else {
        shipEl.textContent = '+ ₹' + shippingCharge.toFixed(2);
        shipEl.style.color = '#111';
    }

    // Savings
    const totalSave = {{ $discount }} + couponSaving;
    if (totalSave > 0) {
        document.getElementById('savingsTag').style.display = 'block';
        document.getElementById('savingsText').textContent  = '🎉 You\'re saving ₹' + totalSave.toFixed(2) + ' on this order!';
    } else {
        document.getElementById('savingsTag').style.display = 'none';
    }

    // Keep hidden input in sync (for JS debugging, actual server recomputes)
    document.getElementById('shippingChargeInput').value = shippingCharge;
}

// ── Shipping radio change ─────────────────────────────────────
document.querySelectorAll('.ship-option').forEach(radio => {
    radio.addEventListener('change', function() {
        shippingCharge = parseFloat(this.dataset.charge) || 0;
        // If coupon was applied, recalculate with new shipping
        if (couponApplied) {
            // re-apply coupon to get updated final (shipping added on top)
        }
        refreshTotals();
    });
});

// ── Apply Coupon ──────────────────────────────────────────────
function applyCoupon() {
    const code = document.getElementById('couponInput').value.trim();
    if (!code) return;

    if (couponApplied) {
        removeCoupon();
        return;
    }

    const btn = document.getElementById('couponBtn');
    btn.textContent = '…';
    btn.disabled = true;

    fetch('{{ route("checkout.applyCoupon") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ code, shipping_charge: shippingCharge })
    })
    .then(r => r.json())
    .then(data => {
        const msg   = document.getElementById('couponMsg');
        const input = document.getElementById('couponInput');

        if (data.status === 'success') {
            couponSaving = data.coupon_discount;
            couponApplied = true;

            input.classList.add('applied');
            input.readOnly = true;
            msg.innerHTML = `<span style="color:#16a34a;font-weight:600">✅ ${data.message}</span>`;
            document.getElementById('couponRow').style.display = 'flex';
            document.getElementById('couponDiscAmt').textContent = '− ₹' + couponSaving.toFixed(2);

            btn.textContent = 'Remove';
            btn.style.background = '#dc2626';
            btn.disabled = false;

            refreshTotals();
        } else {
            msg.innerHTML = `<span style="color:#dc2626;font-weight:600">❌ ${data.message}</span>`;
            btn.textContent = 'Apply';
            btn.disabled = false;
        }
    });
}

function removeCoupon() {
    couponSaving  = 0;
    couponApplied = false;
    const input = document.getElementById('couponInput');
    input.classList.remove('applied');
    input.readOnly = false;
    input.value   = '';
    document.getElementById('couponMsg').innerHTML = '';
    document.getElementById('couponRow').style.display = 'none';
    document.getElementById('couponDiscAmt').textContent = '− ₹0.00';

    const btn = document.getElementById('couponBtn');
    btn.textContent   = 'Apply';
    btn.style.background = '#111';
    btn.disabled = false;

    refreshTotals();
}

// ── Form submit loading state ─────────────────────────────────
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    const paySelected = document.querySelector('input[name="payment_method"]:checked');
    if (!paySelected) {
        e.preventDefault();
        alert('Please select a payment method.');
        return;
    }
    const btn = document.getElementById('placeBtn');
    document.getElementById('placeBtnText').textContent = 'Processing…';
    btn.disabled = true;
});

// ── Init ──────────────────────────────────────────────────────
refreshTotals();
</script>

</body>
</html>