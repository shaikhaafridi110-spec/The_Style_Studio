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
            text-decoration: none;
            color: #111;
            margin-bottom: 1.2rem;
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
            flex-shrink: 0;
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

        /* ── Product Section ── */
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
            flex-shrink: 0;
        }

        .prod-placeholder {
            background: #f4f4f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .prod-img-wrap {
            position: relative;
            flex-shrink: 0;
        }

        .prod-cancelled-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,.45);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .62rem;
            font-weight: 700;
            color: #fff;
            text-align: center;
            line-height: 1.3;
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
            display: inline-block;
            margin-top: .2rem;
        }

        /* ── Cancel Item Button ── */
        .btn-cancel-item {
            background: #fee2e2;
            color: #dc2626;
            border: none;
            border-radius: 8px;
            padding: .3rem .8rem;
            font-size: .75rem;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Sora', sans-serif;
            transition: .2s;
            white-space: nowrap;
        }

        .btn-cancel-item:hover {
            background: #dc2626;
            color: #fff;
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
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-dark-full:hover {
            background: #333;
            color: #fff;
        }

        .btn-outline-full {
            flex: 1;
            border: 2px solid #111;
            padding: .9rem;
            border-radius: 12px;
            text-align: center;
            font-weight: 700;
            text-decoration: none;
            color: #111;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-outline-full:hover {
            background: #111;
            color: #fff;
        }

        /* ── Cancel Modal Overlay ── */
        .cancel-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.55);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .cancel-modal-overlay.show {
            display: flex;
        }

        .cancel-modal-box {
            background: #fff;
            border-radius: 24px;
            padding: 2rem;
            max-width: 420px;
            width: 90%;
            margin: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,.3);
            animation: modalIn .25s ease;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: scale(.92) translateY(10px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        .cancel-modal-icon {
            font-size: 2.5rem;
            margin-bottom: .5rem;
        }

        .cancel-modal-title {
            font-size: 1.2rem;
            font-weight: 800;
            margin-bottom: .25rem;
        }

        .cancel-modal-subtitle {
            font-size: .84rem;
            color: #777;
            margin-bottom: 1.4rem;
        }

        .cancel-modal-label {
            font-size: .85rem;
            font-weight: 600;
            margin-bottom: .4rem;
            display: block;
        }

        .cancel-modal-select {
            width: 100%;
            padding: .75rem 1rem;
            border-radius: 12px;
            border: 1.5px solid #ddd;
            font-family: 'Sora', sans-serif;
            font-size: .85rem;
            margin-bottom: 1.4rem;
            background: #fafafa;
            outline: none;
            transition: .2s;
        }

        .cancel-modal-select:focus {
            border-color: #111;
        }

        .cancel-modal-actions {
            display: flex;
            gap: .8rem;
        }

        .btn-confirm-cancel {
            flex: 1;
            background: #dc2626;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: .85rem;
            font-weight: 700;
            font-size: .9rem;
            cursor: pointer;
            font-family: 'Sora', sans-serif;
            transition: .2s;
        }

        .btn-confirm-cancel:hover {
            background: #b91c1c;
        }

        .btn-go-back {
            flex: 1;
            background: #f4f4f0;
            color: #111;
            border: none;
            border-radius: 12px;
            padding: .85rem;
            font-weight: 700;
            font-size: .9rem;
            cursor: pointer;
            font-family: 'Sora', sans-serif;
            transition: .2s;
        }

        .btn-go-back:hover {
            background: #e8e8e0;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .ordershow-hero-banner h1 {
                font-size: 2rem;
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

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success" style="border-radius:12px;font-size:.88rem;margin-bottom:1rem;">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger" style="border-radius:12px;font-size:.88rem;margin-bottom:1rem;">
                ❌ {{ session('error') }}
            </div>
        @endif

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
            $canCancelItems = !in_array($order->status, ['delivered', 'cancelled']);
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
                    <div style="color:rgba(255,255,255,.5);font-size:.8rem;">Tracking Number</div>
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
                        <div class="step-dot {{ $isDone ? 'done' : ($isActive ? 'active' : '') }}">
                            @if($isDone) ✓ @else {{ $idx + 1 }} @endif
                        </div>
                        <div class="step-content">
                            <div class="step-name">{{ $info['icon'] }} {{ $info['name'] }}</div>
                            <div class="step-desc">{{ $info['desc'] }}</div>
                            @if($isActive)
                                <div class="step-curr" style="color:#111;font-weight:600;margin-top:.2rem;">● Currently here</div>
                            @endif
                            @if($status === 'delivered' && $order->delivered_at && $isDone)
                                <div class="step-time" style="color:#16a34a;margin-top:.2rem;">
                                    ✅ {{ \Carbon\Carbon::parse($order->delivered_at)->format('d M Y') }}
                                </div>
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
                    <span style="font-weight:600;text-transform:uppercase">{{ strtoupper($order->payment_method) }}</span>
                </div>
                <div class="sum-row">
                    <span style="color:#888">Payment Status</span>
                    @if($order->payment_status === 'paid')
                        <span class="badge-pill badge-paid">✅ Paid</span>
                    @elseif($order->payment_method === 'cod')
                        <span class="badge-pill badge-cod">📦 Pay on Delivery</span>
                    @elseif($order->payment_status === 'failed')
                        <span class="badge-pill" style="background:#fee2e2;color:#dc2626;">❌ Failed</span>
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
                @php $cancelledCount = $order->items->where('status','cancelled')->count(); @endphp
                @if($cancelledCount > 0)
                    <span style="color:#dc2626;font-weight:600;font-size:.76rem;margin-left:.3rem">
                        · {{ $cancelledCount }} cancelled
                    </span>
                @endif
            </div>
            <div class="info-card-body">
                @foreach($order->items as $item)
                <div class="prod-row">

                    {{-- Product Image --}}
                    <div class="prod-img-wrap">
                        @if($item->product_image)
                            <img src="{{ asset('admin/assets/images/' . $item->product_image) }}"
                                 class="prod-img"
                                 onerror="this.src='https://via.placeholder.com/80x80?text=📦'">
                        @else
                            <div class="prod-placeholder">📦</div>
                        @endif
                        @if($item->status === 'cancelled')
                            <div class="prod-cancelled-overlay">❌<br>Cancelled</div>
                        @endif
                    </div>

                    {{-- Product Info --}}
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
                            @if($item->cancel_reason)
                                <div style="font-size:.75rem;color:#999;margin-top:.2rem;">
                                    Reason: {{ $item->cancel_reason }}
                                </div>
                            @endif
                        @endif
                    </div>

                    {{-- Price + Cancel --}}
                    <div style="text-align:right;flex-shrink:0;display:flex;flex-direction:column;align-items:flex-end;gap:.4rem;">
                        <div style="font-size:.88rem;font-weight:700;color:{{ $item->status === 'cancelled' ? '#bbb' : '#111' }};
                             {{ $item->status === 'cancelled' ? 'text-decoration:line-through;' : '' }}">
                            ₹{{ number_format($item->subtotal, 2) }}
                        </div>
                        <div style="font-size:.72rem;color:#bbb">
                            ₹{{ number_format($item->final_price, 2) }} × {{ $item->qty }}
                        </div>

                        {{-- Cancel button: show only if item active AND order allows cancellation --}}
                        @if($item->status === 'active' && $canCancelItems)
                            <button class="btn-cancel-item"
                                    onclick="openCancelModal({{ $item->order_item_id }}, '{{ addslashes($item->product_name) }}')">
                                ✕ Cancel
                            </button>
                        @endif
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

{{-- ══════════════════════════════════════════
     CANCEL ITEM MODAL
══════════════════════════════════════════ --}}
<div id="cancelModal" class="cancel-modal-overlay">
    <div class="cancel-modal-box">
        <div class="cancel-modal-icon">🗑️</div>
        <div class="cancel-modal-title">Cancel Item?</div>
        <div class="cancel-modal-subtitle" id="cancelModalSubtitle">
            You are about to cancel this item.
        </div>

        <form id="cancelItemForm" method="POST">
            @csrf

            <label class="cancel-modal-label">Reason for cancellation</label>
            <select name="cancel_reason" class="cancel-modal-select">
                <option value="Changed my mind">Changed my mind</option>
                <option value="Ordered by mistake">Ordered by mistake</option>
                <option value="Found better price elsewhere">Found better price elsewhere</option>
                <option value="Delivery taking too long">Delivery taking too long</option>
                <option value="Other">Other</option>
            </select>

            <div class="cancel-modal-actions">
                <button type="submit" class="btn-confirm-cancel">
                    ✕ Confirm Cancel
                </button>
                <button type="button" class="btn-go-back" onclick="closeCancelModal()">
                    Go Back
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const baseOrderUrl = "{{ url('/orders/' . $order->id . '/items') }}";

    function openCancelModal(itemId, productName) {
        document.getElementById('cancelItemForm').action = baseOrderUrl + '/' + itemId + '/cancel';
        document.getElementById('cancelModalSubtitle').textContent =
            'You are about to cancel: ' + productName;
        document.getElementById('cancelModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeCancelModal() {
        document.getElementById('cancelModal').classList.remove('show');
        document.body.style.overflow = '';
    }

    // Close on backdrop click
    document.getElementById('cancelModal').addEventListener('click', function(e) {
        if (e.target === this) closeCancelModal();
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeCancelModal();
    });
</script>

@endsection         