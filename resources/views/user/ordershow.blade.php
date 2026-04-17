@extends('user.layout')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .ordershow-page, .ordershow-page * {
    font-family: 'Sora', sans-serif;
}

.ordershow-page {
    background: #f4f4f0;
}

/* ── Hero Banner ── */
.ordershow-hero-banner {
    background-image: url("{{asset('user/assets/images/banners/banner-3.jfif')}}");
    background-size: cover;
    background-position: center;
    min-height: 320px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    position: relative;
    margin-bottom: 2rem;
}

.ordershow-hero-banner::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,.45);
}

.ordershow-hero-banner .banner-content {
    position: relative;
    z-index: 1;
}

.ordershow-hero-banner h1 {
    font-size: 2.8rem;
    font-weight: 700;
    color: #fff;
}

.ordershow-hero-banner h1 span {
    display: block;
    font-size: 1.1rem;
    color: rgba(255,255,255,.75);
    margin-top: .4rem;
}

/* ── Container (FIX SIZE) ── */
.container {
    max-width: 900px !important;
}

/* ── Back Link ── */
.back-link {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    font-size: .9rem;
    padding: .5rem 1rem;
    border-radius: 50px;
    background: #fff;
    border: 1.5px solid #e8e8e8;
    font-weight: 600;
    transition: .2s;
}

.back-link:hover {
    background: #111;
    color: #fff;
    border-color: #111;
}

/* ── Order Hero ── */
.order-hero {
    background: linear-gradient(135deg, #111, #2d2d2d);
    border-radius: 24px;
    padding: 2rem;
    color: #fff;
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
}

.order-hero::before {
    content: '';
    position: absolute;
    top: -60px;
    right: -60px;
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,.03);
    border-radius: 50%;
}

.hero-number {
    font-size: 1.3rem;
    font-weight: 800;
}

.hero-date {
    font-size: .9rem;
    color: rgba(255,255,255,.6);
}

/* ── Cards ── */
.info-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,.08);
    margin-bottom: 1.5rem;
}

.info-card-head {
    padding: 1.1rem 1.4rem;
    border-bottom: 1px solid #eee;
    font-size: 1rem;
    font-weight: 700;
}

.info-card-body {
    padding: 1.4rem;
}

/* ── Status Tracker ── */
.status-step {
    display: flex;
    gap: 1.2rem;
    padding-bottom: 1.5rem;
    position: relative;
}

.status-step::before {
    content: '';
    position: absolute;
    left: 21px;
    top: 45px;
    width: 2px;
    height: calc(100% - 10px);
    background: #e8e8e8;
}

.status-step:last-child::before {
    display: none;
}

.step-dot {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    border: 2px solid #e8e8e8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    background: #fff;
}

.step-dot.done {
    background: #22c55e;
    border-color: #22c55e;
    color: #fff;
}

.step-dot.active {
    background: #111;
    border-color: #111;
    color: #fff;
}

.step-name {
    font-size: 1rem;
    font-weight: 700;
}

.step-desc {
    font-size: .85rem;
    color: #777;
}

.step-time,
.step-curr {
    font-size: .8rem;
}

/* ── Product Section (BIG FIX) ── */
.prod-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: .9rem 0;
}

.prod-row + .prod-row {
    border-top: 1px solid #f1f1f1;
}

.prod-img,
.prod-placeholder {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    object-fit: cover;
}

.prod-placeholder {
    background: #f4f4f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.prod-name {
    font-size: 1rem;
    font-weight: 700;
}

.prod-meta {
    font-size: .85rem;
    color: #777;
}

.item-status-cancelled {
    font-size: .75rem;
    background: #fee2e2;
    color: #dc2626;
    padding: .2rem .6rem;
    border-radius: 50px;
}

/* ── Summary ── */
.sum-row {
    display: flex;
    justify-content: space-between;
    padding: .4rem 0;
    font-size: .95rem;
}

.sum-row.total {
    font-size: 1.1rem;
    font-weight: 800;
    border-top: 2px solid #eee;
    padding-top: .7rem;
}

/* ── Badges ── */
.badge-pill {
    padding: .4rem .9rem;
    border-radius: 50px;
    font-size: .8rem;
    font-weight: 700;
}

.badge-pending   { background: #fef9c3; color: #854d0e; }
.badge-confirmed { background: #dbeafe; color: #1d4ed8; }
.badge-shipped   { background: #ede9fe; color: #6d28d9; }
.badge-delivered { background: #dcfce7; color: #16a34a; }
.badge-cancelled { background: #fee2e2; color: #dc2626; }
.badge-paid      { background: #dcfce7; color: #16a34a; }
.badge-cod       { background: #e0f2fe; color: #0369a1; }

/* ── Tracking ── */
.tracking-box {
    background: #f8f8f8;
    border-radius: 14px;
    padding: 1rem;
    display: flex;
    gap: .8rem;
}

.tracking-val {
    font-size: 1rem;
    font-weight: 700;
}

/* ── Buttons ── */
.action-row {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
}

.btn-dark-full {
    flex: 1;
    background: #111;
    color: #fff;
    padding: .9rem;
    border-radius: 12px;
    font-weight: 700;
    text-align: center;
}

.btn-outline-full {
    flex: 1;
    border: 2px solid #111;
    padding: .9rem;
    border-radius: 12px;
    text-align: center;
    font-weight: 700;
}

.btn-outline-full:hover {
    background: #111;
    color: #fff;
}

/* ── Responsive ── */
@media (max-width: 768px) {

    .ordershow-hero-banner h1 {
        font-size: 2rem;
    }

    .container {
        max-width: 100% !important;
        padding: 0 15px;
    }

    .prod-img,
    .prod-placeholder {
        width: 65px;
        height: 65px;
    }

    .hero-number {
        font-size: 1.1rem;
    }

    .step-dot {
        width: 36px;
        height: 36px;
    }

    .action-row {
        flex-direction: column;
    }
}
    </style>

<main class="main ordershow-page">

    {{-- Hero Banner --}}
    <div class="ordershow-hero-banner">
        <div class="banner-content">
            <h1 class="text-white">Order Details<span>Track your order status</span></h1>
        </div>
    </div>

    <div class="container" style="max-width: 640px; padding-bottom: 3rem;">

        {{-- Back --}}
        <a href="{{ url('/orders') }}" class="back-link">← Back to My Orders</a>

        {{-- Hero --}}
        @php
            $statusIcons = [
                'pending'   => '⏳',
                'confirmed' => '✅',
                'shipped'   => '🚚',
                'delivered' => '🏠',
                'cancelled' => '❌',
            ];
            $isCancelled = $order->status === 'cancelled';
        @endphp
        <div class="order-hero">
            <div class="d-flex align-items-start justify-content-between flex-wrap gap-2">
                <div>
                    <div class="hero-number">{{ $statusIcons[$order->status] ?? '' }} {{ $order->order_number }}</div>
                    <div class="hero-date">Placed on {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y, h:i A') }}</div>
                </div>
                <span class="badge-pill badge-{{ $order->status }}" style="margin-top:.1rem">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            @if($order->tracking_number)
            <div class="tracking-box mt-3" style="background:rgba(255,255,255,.08)">
                <span style="font-size:1.4rem">🚚</span>
                <div>
                    <div class="tracking-label" style="color:rgba(255,255,255,.5)">Tracking Number</div>
                    <div class="tracking-val">{{ $order->tracking_number }}</div>
                </div>
            </div>
            @endif
        </div>

        {{-- ── Order Status Tracker ── --}}
        @if(!$isCancelled)
        <div class="info-card">
            <div class="info-card-head">📦 Order Progress</div>
            <div class="info-card-body">
                @php
                    $statuses   = ['pending','confirmed','shipped','delivered'];
                    $currentIdx = array_search($order->status, $statuses);
                    $statusInfo = [
                        'pending'   => ['icon'=>'⏳','name'=>'Order Placed',   'desc'=>'We have received your order'],
                        'confirmed' => ['icon'=>'✅','name'=>'Confirmed',       'desc'=>'Order confirmed & being packed'],
                        'shipped'   => ['icon'=>'🚚','name'=>'Shipped',         'desc'=>'Your order is on the way'],
                        'delivered' => ['icon'=>'🏠','name'=>'Delivered',       'desc'=>'Order delivered successfully'],
                    ];
                @endphp
                <div class="status-tracker">
                    @foreach($statuses as $idx => $status)
                    @php
                        $isDone   = $idx < $currentIdx;
                        $isActive = $idx === $currentIdx;
                        $info     = $statusInfo[$status];
                    @endphp
                    <div class="status-step {{ $isDone ? 'done' : '' }}">
                        <div class="step-dot {{ $isDone ? 'done' : ($isActive ? 'active' : 'pending') }}">
                            @if($isDone) ✓ @else {{ $idx + 1 }} @endif
                        </div>
                        <div class="step-content">
                            <div class="step-name">{{ $info['icon'] }} {{ $info['name'] }}</div>
                            <div class="step-desc">{{ $info['desc'] }}</div>
                            @if($isActive)
                                <div class="step-curr">● Currently here</div>
                            @endif
                            @if($status === 'delivered' && $order->delivered_at && $isDone)
                                <div class="step-time">{{ \Carbon\Carbon::parse($order->delivered_at)->format('d M Y') }}</div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @else
        {{-- Cancelled state card --}}
        <div class="info-card">
            <div class="info-card-head">❌ Order Cancelled</div>
            <div class="info-card-body" style="text-align:center;padding:1.5rem">
                <div style="font-size:2.5rem;margin-bottom:.75rem">😔</div>
                <div style="font-weight:700;color:#dc2626;margin-bottom:.35rem">This order has been cancelled.</div>
                <div style="font-size:.82rem;color:#aaa">If you were charged, a refund will be processed within 5–7 business days.</div>
            </div>
        </div>
        @endif

        {{-- ── Payment Details ── --}}
        <div class="info-card">
            <div class="info-card-head">💳 Payment Details</div>
            <div class="info-card-body">
                <div class="sum-row">
                    <span style="color:#888">Payment Method</span>
                    <span style="font-weight:600;text-transform:capitalize">{{ strtoupper($order->payment_method) }}</span>
                </div>
                <div class="sum-row">
                    <span style="color:#888">Payment Status</span>
                    @if($order->payment_status === 'paid')
                        <span class="badge-pill badge-paid">✅ Paid</span>
                    @elseif($order->payment_method === 'cod')
                        <span class="badge-pill badge-cod">📦 Pay on Delivery</span>
                    @elseif($order->payment_status === 'failed')
                        <span class="badge-pill badge-failed">❌ Failed</span>
                    @else
                        <span class="badge-pill badge-pending">⏳ Pending</span>
                    @endif
                </div>
                @if($order->razorpay_payment_id)
                <div class="sum-row">
                    <span style="color:#888">Transaction ID</span>
                    <span style="font-size:.78rem;font-weight:600;color:#555">{{ $order->razorpay_payment_id }}</span>
                </div>
                @endif
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
                    <span>Total {{ $order->payment_status === 'paid' ? 'Paid' : 'Amount' }}</span>
                    <span>₹{{ number_format($order->final_amount, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- ── Delivery Address ── --}}
        <div class="info-card">
            <div class="info-card-head">📍 Delivery Address</div>
            <div class="info-card-body" style="font-size:.85rem;color:#555;line-height:1.8">
                <strong style="color:#111">{{ $order->name }}</strong> · {{ $order->phone }}<br>
                {{ $order->address_line1 }}@if($order->address_line2), {{ $order->address_line2 }}@endif<br>
                {{ $order->city }}, {{ $order->state }} — {{ $order->postal_code }}
            </div>
        </div>

        {{-- ── Items Ordered ── --}}
        <div class="info-card">
            <div class="info-card-head">
                🛍️ Items Ordered
                <span style="color:#aaa;font-weight:400;font-size:.76rem;margin-left:.25rem">
                    {{ $order->items->count() }} item(s)
                </span>
            </div>
            <div class="info-card-body">
                @foreach($order->items as $item)
                <div class="prod-row">
                    @if($item->product_image)
                        <img src="{{ asset('admin/assets/images/' . $item->product_image) }}"
                             class="prod-img"
                             onerror="this.src='https://via.placeholder.com/56x56?text=📦'">
                    @else
                        <div class="prod-placeholder">📦</div>
                    @endif
                    <div style="flex:1;min-width:0">
                        <div class="prod-name text-truncate">{{ $item->product_name }}</div>
                        <div class="prod-meta">
                            @if($item->size) Size: {{ $item->size }} · @endif
                            Qty: {{ $item->qty }}
                            @if($item->discount_amount > 0)
                            · <span style="color:#16a34a">−₹{{ number_format($item->discount_amount, 2) }} off</span>
                            @endif
                        </div>
                        @if($item->status === 'cancelled')
                            <span class="item-status-cancelled">❌ Cancelled</span>
                        @endif
                    </div>
                    <div style="text-align:right;flex-shrink:0">
                        <div style="font-size:.88rem;font-weight:700;color:#111">₹{{ number_format($item->subtotal, 2) }}</div>
                        <div style="font-size:.72rem;color:#bbb">₹{{ number_format($item->final_price, 2) }} × {{ $item->qty }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @if($order->notes)
        {{-- ── Order Notes ── --}}
        <div class="info-card">
            <div class="info-card-head">📝 Order Notes</div>
            <div class="info-card-body" style="font-size:.84rem;color:#666;line-height:1.6">
                {{ $order->notes }}
            </div>
        </div>
        @endif

        {{-- ── Actions ── --}}
        <div class="action-row">
            <a href="{{ url('/') }}" class="btn-dark-full">🛍️ Continue Shopping</a>
            <a href="{{ url('/orders') }}" class="btn-outline-full">← My Orders</a>
        </div>

    </div>
</main>

@endsection