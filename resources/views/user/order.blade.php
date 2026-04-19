@extends('user.layout')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .orders-page, .orders-page * {
            font-family: 'Sora', sans-serif;
        }

        .orders-page {
            background: #f4f4f0;
        }

        /* ── Hero Banner ── */
        .orders-hero-banner {
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

        .orders-hero-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,.45);
        }

        .orders-hero-banner h1 {
            position: relative;
            z-index: 1;
            font-size: 2.8rem;
            font-weight: 700;
            color: #fff;
        }

        .orders-hero-banner h1 span {
            display: block;
            font-size: 1.1rem;
            font-weight: 400;
            color: rgba(255,255,255,.75);
            margin-top: .4rem;
        }

        /* ── Filter Tabs ── */
        .filter-tabs {
            display: flex;
            gap: .6rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .filter-tab {
            padding: .5rem 1.2rem;
            border-radius: 50px;
            font-size: .85rem;
            font-weight: 600;
            border: 2px solid #e8e8e8;
            background: #fff;
            color: #555;
            text-decoration: none;
            transition: all .2s;
        }

        .filter-tab:hover,
        .filter-tab.active {
            background: #111;
            border-color: #111;
            color: #fff;
        }

        /* ── Order Card ── */
        .order-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,.08);
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: .25s;
        }

        .order-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 28px rgba(0,0,0,.12);
        }

        .order-card-head {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: .5rem;
        }

        .order-number {
            font-weight: 700;
            font-size: 1.1rem;
            color: #111;
        }

        .order-date {
            font-size: .9rem;
            color: #888;
        }

        .order-card-body {
            padding: 1.5rem;
        }

        /* ── Product Images ── */
        .thumb-strip {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            margin-bottom: 1rem;
        }

        .thumb {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            object-fit: cover;
            border: 1.5px solid #eee;
            flex-shrink: 0;
            transition: .2s;
        }

        .thumb:hover {
            transform: scale(1.05);
        }

        .thumb-placeholder,
        .more-badge {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .thumb-placeholder {
            background: #f4f4f0;
            border: 1.5px solid #eee;
        }

        .more-badge {
            background: #111;
            color: #fff;
            font-size: .85rem;
            font-weight: 700;
        }

        /* ── Amount Section ── */
        .amount-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: .8rem;
        }

        .amount-val {
            font-weight: 800;
            font-size: 1.3rem;
            color: #111;
        }

        .items-count {
            font-size: .9rem;
            color: #888;
        }

        /* ── Badges ── */
        .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            border-radius: 50px;
            padding: .35rem .8rem;
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

        /* ── Button ── */
        .btn-view {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: #111;
            color: #fff;
            border-radius: 10px;
            padding: .6rem 1.4rem;
            font-size: .9rem;
            font-weight: 700;
            text-decoration: none;
            transition: .2s;
        }

        .btn-view:hover {
            background: #333;
            color: #fff;
        }

        /* ── Empty State ── */
        .empty-state {
            background: #fff;
            border-radius: 20px;
            padding: 3rem 2rem;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,.08);
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .empty-state h5 {
            font-weight: 700;
        }

        .empty-state p {
            color: #888;
            font-size: .95rem;
        }

        /* ── Pagination ── */
        .pagination {
            gap: .3rem;
        }

        .page-link {
            border-radius: 8px !important;
            border: 2px solid #e8e8e8;
            color: #111;
            font-weight: 600;
            font-size: .9rem;
            padding: .5rem 1rem;
        }

        .page-item.active .page-link {
            background: #111;
            border-color: #111;
        }

        .page-link:hover {
            background: #f4f4f0;
            border-color: #ddd;
        }

        /* ── Cancelled item overlay on thumb ── */
        .thumb-wrap {
            position: relative;
            flex-shrink: 0;
        }

        .thumb-cancelled-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,.45);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .6rem;
            font-weight: 700;
            color: #fff;
            text-align: center;
            line-height: 1.3;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .orders-hero-banner h1 {
                font-size: 2rem;
            }

            .thumb {
                width: 65px;
                height: 65px;
            }

            .thumb-placeholder,
            .more-badge {
                width: 65px;
                height: 65px;
            }

            .amount-val {
                font-size: 1.1rem;
            }
        }
    </style>

<main class="main orders-page">

    {{-- Hero Banner --}}
    <div class="orders-hero-banner">
        <h1 class="text-white">My Orders<span>Track and manage all your orders</span></h1>
    </div>

    <div class="container" style="max-width: 1000px; padding-bottom: 3rem;">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success" style="border-radius:12px;font-size:.88rem;margin-bottom:1rem;font-family:'Sora',sans-serif;">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger" style="border-radius:12px;font-size:.88rem;margin-bottom:1rem;font-family:'Sora',sans-serif;">
                ❌ {{ session('error') }}
            </div>
        @endif

        {{-- Filter Tabs --}}
        @php
            $statuses = ['all','pending','confirmed','shipped','delivered','cancelled'];
            $current  = request('status', 'all');
            $icons    = [
                'all'       => '🗂️',
                'pending'   => '⏳',
                'confirmed' => '✅',
                'shipped'   => '🚚',
                'delivered' => '🏠',
                'cancelled' => '❌',
            ];
        @endphp
        <div class="filter-tabs">
            @foreach($statuses as $s)
            <a href="{{ url('/orders') }}?status={{ $s }}"
               class="filter-tab {{ $current === $s ? 'active' : '' }}">
                {{ $icons[$s] }} {{ ucfirst($s) }}
            </a>
            @endforeach
        </div>

        {{-- Orders --}}
        @forelse($orders as $order)
        @php
            $statusIcons = [
                'pending'   => '⏳',
                'confirmed' => '✅',
                'shipped'   => '🚚',
                'delivered' => '🏠',
                'cancelled' => '❌',
            ];
            $visibleItems = $order->items->take(4);
            $extra        = $order->items->count() - 4;
            $activeCount  = $order->items->where('status','active')->count();
            $cancelledCount = $order->items->where('status','cancelled')->count();
        @endphp
        <div class="order-card">
            <div class="order-card-head">
                <div>
                    <div class="order-number">{{ $order->order_number }}</div>
                    <div class="order-date">🕐 {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y, h:i A') }}</div>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="badge-pill badge-{{ $order->status }}">
                        {{ $statusIcons[$order->status] ?? '' }} {{ ucfirst($order->status) }}
                    </span>
                    @if($order->payment_method === 'cod')
                        <span class="badge-pill badge-cod">📦 COD</span>
                    @elseif($order->payment_status === 'paid')
                        <span class="badge-pill badge-paid">💳 Paid</span>
                    @endif
                    @if($cancelledCount > 0 && $order->status !== 'cancelled')
                        <span class="badge-pill" style="background:#fff3cd;color:#856404;">
                            ⚠️ {{ $cancelledCount }} item(s) cancelled
                        </span>
                    @endif
                </div>
            </div>

            <div class="order-card-body">
                {{-- Thumb strip --}}
                <div class="thumb-strip">
                    @foreach($visibleItems as $item)
                        <div class="thumb-wrap">
                            @if($item->product_image)
                                <img src="{{ asset('admin/assets/images/' . $item->product_image) }}"
                                     class="thumb"
                                     onerror="this.src='https://via.placeholder.com/52x52?text=📦'">
                            @else
                                <div class="thumb-placeholder">📦</div>
                            @endif
                            @if($item->status === 'cancelled')
                                <div class="thumb-cancelled-overlay">❌<br>Cancelled</div>
                            @endif
                        </div>
                    @endforeach
                    @if($extra > 0)
                        <div class="more-badge">+{{ $extra }}</div>
                    @endif
                </div>

                {{-- Amount + View button --}}
                <div class="amount-row">
                    <div>
                        <div class="amount-val">₹{{ number_format($order->final_amount, 2) }}</div>
                        <div class="items-count">
                            {{ $order->items->count() }} item(s) · {{ ucfirst($order->payment_method) }}
                            @if($activeCount < $order->items->count() && $order->status !== 'cancelled')
                                · <span style="color:#dc2626;font-size:.8rem;">{{ $cancelledCount }} cancelled</span>
                            @endif
                        </div>
                    </div>
                    <a href="{{ url('/orders/' . $order->id) }}" class="btn-view">
                        View Details →
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <span class="empty-icon">🛍️</span>
            <h5>No orders found</h5>
            <p>{{ $current !== 'all' ? 'No ' . $current . ' orders yet.' : 'You haven\'t placed any orders yet.' }}</p>
            <a href="{{ url('/shop') }}"
               style="display:inline-flex;align-items:center;gap:.4rem;background:#111;color:#fff;border-radius:12px;padding:.7rem 1.5rem;font-weight:700;font-size:.85rem;text-decoration:none;margin-top:.75rem;">
                🛒 Start Shopping
            </a>
        </div>
        @endforelse

        {{-- Pagination --}}
        @if($orders->hasPages())
        <div class="d-flex justify-content-center mt-3">
            {{ $orders->links() }}
        </div>
        @endif

    </div>
</main>

@endsection