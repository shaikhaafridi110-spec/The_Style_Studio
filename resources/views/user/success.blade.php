{{-- resources/views/checkout/success.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed!</title>
    <link rel="icon" type="image/png" sizes="64x64" href="{{asset('user/assets/images/logo11.png')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Sora', sans-serif; }
        body { background:#f4f4f0; padding: 1.5rem 0 3rem; }

        .success-hero {
            background:linear-gradient(135deg,#111,#2d2d2d);
            border-radius:24px; padding:2.5rem; text-align:center;
            color:#fff; margin-bottom:1.5rem; position:relative; overflow:hidden;
        }
        .success-hero::before {
            content:''; position:absolute; top:-60px; right:-60px;
            width:200px; height:200px; background:rgba(255,255,255,.03);
            border-radius:50%;
        }
        .confetti-icon { font-size:3.5rem; margin-bottom:.75rem; display:block; animation:bounce .6s ease; }
        @keyframes bounce { 0%,100%{transform:scale(1)} 50%{transform:scale(1.2)} }
        .success-hero h3 { font-weight:800; margin-bottom:.25rem; }
        .success-hero .order-id { color:rgba(255,255,255,.5); font-size:.82rem; }

        .info-card {
            background:#fff; border-radius:20px;
            box-shadow:0 2px 16px rgba(0,0,0,.07); margin-bottom:1.25rem;
        }
        .info-card-head {
            padding:1rem 1.25rem; border-bottom:1px solid #f4f4f0;
            font-weight:700; font-size:.9rem; display:flex; align-items:center; gap:.5rem;
        }
        .info-card-body { padding:1.25rem; }

        /* ── Order Status Tracker ── */
        .status-tracker { padding:.25rem 0; }
        .status-step {
            display:flex; align-items:flex-start; gap:1rem; position:relative;
            padding-bottom:1.5rem;
        }
        .status-step:last-child { padding-bottom:0; }
        .status-step::before {
            content:''; position:absolute; left:17px; top:36px;
            width:2px; height:calc(100% - 10px);
            background:#e8e8e8; z-index:0;
        }
        .status-step:last-child::before { display:none; }
        .status-step.done::before { background:linear-gradient(180deg,#22c55e,#e8e8e8); }
        .status-step.active::before { background:#e8e8e8; }

        .step-dot {
            width:36px; height:36px; border-radius:50%; flex-shrink:0; z-index:1;
            display:flex; align-items:center; justify-content:center;
            font-size:.9rem; border:2.5px solid #e8e8e8; background:#fff;
        }
        .step-dot.done   { background:#22c55e; border-color:#22c55e; color:#fff; }
        .step-dot.active { background:#111; border-color:#111; color:#fff; box-shadow:0 0 0 4px rgba(17,17,17,.12); }
        .step-dot.pending { background:#fff; border-color:#e8e8e8; color:#bbb; }

        .step-content { padding-top:.25rem; }
        .step-name   { font-weight:700; font-size:.88rem; color:#111; }
        .step-desc   { font-size:.76rem; color:#999; margin-top:.1rem; }
        .step-time   { font-size:.72rem; color:#22c55e; font-weight:600; margin-top:.1rem; }

        /* ── Summary rows ── */
        .sum-row { display:flex; justify-content:space-between; padding:.35rem 0; font-size:.84rem; }
        .sum-row.total { font-weight:800; font-size:1rem; border-top:2px solid #f4f4f0; padding-top:.65rem; margin-top:.25rem; }

        /* ── Product row ── */
        .prod-row { display:flex; align-items:center; gap:.9rem; padding:.5rem 0; }
        .prod-row + .prod-row { border-top:1px solid #f8f8f8; }
        .prod-img { width:52px; height:52px; border-radius:10px; object-fit:cover; border:1.5px solid #eee; flex-shrink:0; }
        .prod-name { font-size:.84rem; font-weight:600; color:#111; }
        .prod-meta { font-size:.74rem; color:#aaa; margin-top:.1rem; }

        /* ── Action buttons ── */
        .action-row { display:flex; gap:.75rem; margin-top:1.5rem; }
        .btn-primary-dark { background:#111; color:#fff; border:none; border-radius:12px; padding:.8rem 1.5rem; font-weight:700; font-size:.88rem; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:.4rem; transition:background .2s; }
        .btn-primary-dark:hover { background:#333; color:#fff; }
        .btn-outline-dark { background:transparent; color:#111; border:2px solid #111; border-radius:12px; padding:.8rem 1.5rem; font-weight:700; font-size:.88rem; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:.4rem; transition:all .2s; }
        .btn-outline-dark:hover { background:#111; color:#fff; }

        /* Payment badges */
        .badge-pill { display:inline-flex; align-items:center; gap:.3rem; border-radius:50px; padding:.3rem .75rem; font-size:.74rem; font-weight:700; }
        .badge-paid       { background:#dcfce7; color:#16a34a; }
        .badge-pending    { background:#fef9c3; color:#854d0e; }
        .badge-cod        { background:#e0f2fe; color:#0369a1; }
    </style>
</head>
<body>
<div class="container" style="max-width:640px">

    {{-- Hero --}}
    <div class="success-hero">
        <span class="confetti-icon">🎉</span>
        <h3>Order Placed Successfully!</h3>
        <p style="color:rgba(255,255,255,.6);margin-bottom:.5rem;font-size:.88rem">Thank you for shopping with us.</p>
        <div class="order-id">Order #{{ $order->order_number }}</div>
    </div>

    @if(session('info'))
    <div style="background:#dbeafe;border:1.5px solid #bfdbfe;color:#1d4ed8;border-radius:12px;padding:.75rem 1rem;font-size:.83rem;margin-bottom:1.25rem;font-weight:500">
        ℹ️ {{ session('info') }}
    </div>
    @endif

    {{-- ── Order Status Tracker ── --}}
    <div class="info-card">
        <div class="info-card-head">📦 Order Status</div>
        <div class="info-card-body">
            @php
                $statuses = ['pending','confirmed','shipped','delivered'];
                $current  = $order->status;
                $currentIdx = array_search($current, $statuses);

                $statusInfo = [
                    'pending'   => ['icon'=>'⏳', 'name'=>'Order Placed',   'desc'=>'We have received your order'],
                    'confirmed' => ['icon'=>'✅', 'name'=>'Confirmed',       'desc'=>'Your order is confirmed & being packed'],
                    'shipped'   => ['icon'=>'🚚', 'name'=>'Shipped',         'desc'=>'Your order is on the way'],
                    'delivered' => ['icon'=>'🏠', 'name'=>'Delivered',       'desc'=>'Order delivered successfully'],
                ];
            @endphp

            <div class="status-tracker">
                @foreach($statuses as $idx => $status)
                @php
                    $isDone   = $idx < $currentIdx;
                    $isActive = $idx === $currentIdx;
                    $info     = $statusInfo[$status];
                @endphp
                <div class="status-step {{ $isDone ? 'done' : ($isActive ? 'active' : '') }}">
                    <div class="step-dot {{ $isDone ? 'done' : ($isActive ? 'active' : 'pending') }}">
                        @if($isDone)✓
                        @elseif($isActive){{ $idx+1 }}
                        @else{{ $idx+1 }}
                        @endif
                    </div>
                    <div class="step-content">
                        <div class="step-name">{{ $info['icon'] }} {{ $info['name'] }}</div>
                        <div class="step-desc">{{ $info['desc'] }}</div>
                        @if($isActive)
                            <div class="step-time">● Currently here</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── Payment Summary ── --}}
    <div class="info-card">
        <div class="info-card-head">💳 Payment Details</div>
        <div class="info-card-body">
            <div class="sum-row">
                <span style="color:#888">Payment Method</span>
                <span style="font-weight:600;text-transform:capitalize">{{ $order->payment_method }}</span>
            </div>
            <div class="sum-row">
                <span style="color:#888">Payment Status</span>
                @if($order->payment_status === 'paid')
                    <span class="badge-pill badge-paid">✅ Paid</span>
                @elseif($order->payment_method === 'cod')
                    <span class="badge-pill badge-cod">📦 Pay on Delivery</span>
                @else
                    <span class="badge-pill badge-pending">⏳ Pending Verification</span>
                @endif
            </div>
            <div class="sum-row">
                <span style="color:#888">Subtotal</span>
                <span>₹{{ number_format($order->total_amount, 2) }}</span>
            </div>
            @if($order->discount_amount > 0)
            <div class="sum-row" style="color:#16a34a">
                <span>Discount</span>
                <span>− ₹{{ number_format($order->discount_amount, 2) }}</span>
            </div>
            @endif
            <div class="sum-row">
                <span style="color:#888">Shipping</span>
                @if($order->shipping_charge > 0)
                    <span>₹{{ number_format($order->shipping_charge, 2) }}</span>
                @else
                    <span style="color:#16a34a;font-weight:600">FREE</span>
                @endif
            </div>
            <div class="sum-row total">
                <span>Total Paid</span>
                <span>₹{{ number_format($order->final_amount, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- ── Delivery Address ── --}}
    <div class="info-card">
        <div class="info-card-head">📍 Delivery Address</div>
        <div class="info-card-body" style="font-size:.85rem;color:#555;line-height:1.7">
            <strong style="color:#111">{{ $order->name }}</strong> · {{ $order->phone }}<br>
            {{ $order->address_line1 }}@if($order->address_line2), {{ $order->address_line2 }}@endif<br>
            {{ $order->city }}, {{ $order->state }} — {{ $order->postal_code }}
        </div>
    </div>

    {{-- ── Items ── --}}
    <div class="info-card">
        <div class="info-card-head">🛍️ Items Ordered <span style="color:#aaa;font-weight:400;font-size:.78rem;margin-left:.25rem">{{ $order->items->count() }} item(s)</span></div>
        <div class="info-card-body">
            @foreach($order->items as $item)
            <div class="prod-row">
                @if($item->product_image)
                <img src="{{ asset('admin/assets/images/' . $item->product_image) }}" class="prod-img"
                    onerror="this.src='https://via.placeholder.com/52x52?text=IMG'">
                @else
                <div class="prod-img" style="background:#f4f4f0;display:flex;align-items:center;justify-content:center;font-size:1.5rem">📦</div>
                @endif
                <div style="flex:1;min-width:0">
                    <div class="prod-name text-truncate">{{ $item->product_name }}</div>
                    <div class="prod-meta">
                        @if($item->size)Size: {{ $item->size }} · @endif
                        Qty: {{ $item->qty }}
                    </div>
                </div>
                <div style="font-size:.88rem;font-weight:700;color:#111;white-space:nowrap">
                    ₹{{ number_format($item->subtotal, 2) }}
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── Actions ── --}}
    <div class="action-row">
        <a href="{{ url('/') }}" class="btn-primary-dark flex-fill justify-content-center">
            🛍️ Continue Shopping
        </a>
        <a href="{{ url('/orders') }}" class="btn-outline-dark flex-fill justify-content-center">
            📋 My Orders
        </a>
    </div>

</div>
</body>
</html>