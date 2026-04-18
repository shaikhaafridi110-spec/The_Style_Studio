@extends('admin.layouts')

@section('user-css')
<style>
    /* ===== PAGINATION ===== */
    .pagination {
        gap: 8px;
        align-items: center;
    }
    .page-item .page-link {
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ddd;
        color: #2f4fb3;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .page-item .page-link:hover {
        background-color: #2f4fb3;
        color: #fff;
        border-color: #2f4fb3;
    }
    .page-item.active .page-link {
        background: linear-gradient(135deg, #4a6cf7, #2f4fb3);
        color: #fff;
        border: none;
        box-shadow: 0 4px 10px rgba(47, 79, 179, 0.4);
    }
    .page-item.disabled .page-link {
        background-color: #f1f1f1;
        color: #999;
        border: none;
    }
    .page-item:first-child .page-link,
    .page-item:last-child .page-link {
        border-radius: 12px;
        width: auto;
        padding: 0 12px;
    }

    /* ===== PAGE LAYOUT ===== */
    .page-title {
        font-weight: 700;
        font-size: 26px;
        color: #1a2340;
    }
    .page-subtitle {
        font-size: 14px;
        color: #6c757d;
    }
    .bg-gradient-primary {
        background: linear-gradient(45deg, #4e73df, #224abe);
    }
    .card {
        border-radius: 14px;
    }
    .shadow-sm {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    /* ===== STATUS PROGRESS STEPPER ===== */
    .status-stepper {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0;
        margin: 12px 0 20px;
    }
    .status-step {
        display: flex;
        align-items: center;
    }
    .step-pill {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 7px 18px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }
    .step-pill.done {
        color: #fff;
        box-shadow: 0 3px 10px rgba(0,0,0,0.15);
    }
    .step-pill.pending-step.done    { background: #f6c23e; border-color: #f6c23e; }
    .step-pill.confirmed-step.done  { background: #4e73df; border-color: #4e73df; }
    .step-pill.shipped-step.done    { background: #36b9cc; border-color: #36b9cc; }
    .step-pill.delivered-step.done  { background: #1cc88a; border-color: #1cc88a; }
    .step-pill.inactive {
        background: #f1f3f9;
        color: #adb5bd;
        border-color: #e0e4ef;
    }
    .step-arrow {
        font-size: 18px;
        color: #ccc;
        margin: 0 4px;
        font-weight: 300;
    }

    /* ===== ADVANCE BUTTON ===== */
    .btn-advance {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 26px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(0,0,0,0.15);
    }
    .btn-advance:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }
    .btn-advance.to-confirmed { background: linear-gradient(135deg,#4e73df,#224abe); color:#fff; }
    .btn-advance.to-shipped   { background: linear-gradient(135deg,#36b9cc,#1a7a88); color:#fff; }
    .btn-advance.to-delivered { background: linear-gradient(135deg,#1cc88a,#13855c); color:#fff; }
    .btn-advance.is-delivered {
        background: #e8faf3;
        color: #1cc88a;
        border: 2px solid #1cc88a;
        cursor: not-allowed;
        box-shadow: none;
    }
    .btn-advance.is-delivered:hover { transform: none; }

    /* ===== PRODUCT ITEM CARDS ===== */
    .item-card {
        display: flex;
        align-items: center;
        padding: 16px;
        border-radius: 14px;
        border: 1.5px solid #e8ecf8;
        background: linear-gradient(135deg, #f8f9ff, #eef1ff);
        box-shadow: 0 2px 12px rgba(78,115,223,0.07);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        height: 100%;
    }
    .item-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(78,115,223,0.14);
    }
    .item-img {
        width: 80px;
        height: 90px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.12);
        flex-shrink: 0;
        margin-right: 16px;
    }
    .item-name {
        font-size: 15px;
        font-weight: 700;
        color: #1a2340;
        margin-bottom: 6px;
    }
    .item-meta-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        font-weight: 600;
        background: #fff;
        border: 1px solid #dde3f5;
        border-radius: 20px;
        padding: 3px 10px;
        color: #4e73df;
        margin-right: 5px;
        margin-bottom: 4px;
    }
    .item-price {
        font-size: 16px;
        font-weight: 800;
        color: #4e73df;
        margin: 6px 0 4px;
    }
    .cancel-box {
        margin-top: 8px;
        padding: 8px 10px;
        background: rgba(231,74,59,0.08);
        border-radius: 8px;
        color: #e74a3b;
        font-size: 12px;
        line-height: 1.6;
    }

    /* ===== AMOUNT SUMMARY BANNER ===== */
    .amount-banner {
        background: linear-gradient(45deg, #6a5acd, #4e73df);
        border-radius: 14px;
        color: #fff;
        padding: 20px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        box-shadow: 0 4px 16px rgba(78,115,223,0.25);
    }

    /* ===== SECTION HEADING ===== */
    .section-heading {
        font-size: 17px;
        font-weight: 700;
        color: #1a2340;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* ===== FORM INPUTS ===== */
    .form-label {
        font-weight: 600;
        font-size: 13px;
        color: #444;
        margin-bottom: 4px;
    }
    .form-control, .form-select {
        border-radius: 8px;
        border: 1.5px solid #dde3f5;
        font-size: 14px;
        padding: 9px 12px;
        transition: border-color 0.2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 3px rgba(78,115,223,0.12);
    }
</style>
@endsection


@section('main-content')
<div class="content-wrapper" style="padding: 24px;">

    <!-- ===== PAGE HEADER ===== -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="page-title mb-0">Edit Order</h2>
            <p class="page-subtitle mb-0">Order #{{ $order->order_number }}</p>
        </div>
        <a href="{{ url('admin/Order') }}" class="btn btn-outline-secondary btn-sm px-4"
           style="border-radius:50px; font-weight:600;">
            ← Back to Orders
        </a>
    </div>

    <!-- ===== BREADCRUMB ===== -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-2 px-3">
            <div class="d-flex align-items-center text-muted small">
                <i class="mdi mdi-home-outline me-1"></i>
                <span>Dashboard</span>
                <i class="mdi mdi-chevron-right mx-2"></i>
                <a href="{{ url('admin/Order') }}" class="text-decoration-none text-muted">Orders</a>
                <i class="mdi mdi-chevron-right mx-2"></i>
                <span class="text-dark fw-semibold">Edit Order</span>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        ✅ {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        ❌ {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- ===== FORM START ===== -->
    <form action="{{ url('admin/order-update/'.$order->id) }}" method="POST">
        @csrf

        <div class="row g-4">

            <!-- ========== LEFT COLUMN ========== -->
            <div class="col-lg-5">

                <!-- USER DETAILS CARD -->
                <div class="card border-0 shadow-sm p-4 mb-4">
                    <div class="section-heading">
                        👤 User Details
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name"
                               value="{{ old('name', $order->name) }}"
                               class="form-control @error('name') is-invalid @enderror">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email"
                               value="{{ old('email', $order->user->email ?? '') }}"
                               class="form-control @error('email') is-invalid @enderror">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone"
                               value="{{ old('phone', $order->phone) }}"
                               class="form-control @error('phone') is-invalid @enderror">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Address</label>
                        <input type="text" name="address_line1"
                               value="{{ old('address_line1', $order->address_line1) }}"
                               class="form-control">
                    </div>
                </div>

            </div>

            <!-- ========== RIGHT COLUMN ========== -->
            <div class="col-lg-7">

                <!-- ORDER DETAILS CARD -->
                <div class="card border-0 shadow-sm p-4 mb-4">
                    <div class="section-heading">
                        📦 Order Details
                    </div>

                    <!-- AMOUNT BANNER -->
                    <div class="amount-banner">
                        <div>
                            <div style="font-size:12px; opacity:0.8; text-transform:uppercase; letter-spacing:1px;">
                                Final Amount
                            </div>
                            <div style="font-size:28px; font-weight:800; line-height:1.1;">
                                ₹ {{ number_format($order->final_amount, 2) }}
                            </div>
                            <div style="font-size:12px; opacity:0.7; margin-top:4px;">
                                Total: ₹{{ $order->total_amount }}
                                &nbsp;|&nbsp; Discount: ₹{{ $order->discount_amount }}
                                &nbsp;|&nbsp; Tax: ₹{{ $order->tax_amount }}
                                &nbsp;|&nbsp; Ship: ₹{{ $order->shipping_charge }}
                            </div>
                        </div>
                        <div class="text-end">
                            <div style="font-size:12px; opacity:0.8; text-transform:uppercase; letter-spacing:1px;">
                                Payment Method
                            </div>
                            <div style="font-size:18px; font-weight:700; margin-top:4px;">
                                {{ strtoupper($order->payment_method) }}
                            </div>
                        </div>
                    </div>

                    <!-- ===== ORDER STATUS STEPPER ===== -->
                    @php
                        $statusFlow  = ['pending' => 'confirmed', 'confirmed' => 'shipped', 'shipped' => 'delivered'];
                        $stepClasses = [
                            'pending'   => 'pending-step',
                            'confirmed' => 'confirmed-step',
                            'shipped'   => 'shipped-step',
                            'delivered' => 'delivered-step',
                        ];
                        $stepIcons = [
                            'pending'   => '🕐',
                            'confirmed' => '✅',
                            'shipped'   => '🚚',
                            'delivered' => '📬',
                        ];
                        $stepOrder  = ['pending', 'confirmed', 'shipped', 'delivered'];
                        $currentIdx = array_search($order->status, $stepOrder);
                        $next       = $statusFlow[$order->status] ?? null;
                        $btnClass   = $next ? 'to-'.$next : 'is-delivered';
                    @endphp

                    <div class="mb-1">
                        <label class="form-label">Order Status</label>
                    </div>

                    {{-- Hidden input carries the (possibly updated) status --}}
                    <input type="hidden" name="status" id="statusInput" value="{{ $order->status }}">

                    {{-- Progress Stepper --}}
                    <div class="status-stepper">
                        @foreach($stepOrder as $i => $step)
                            <div class="status-step">
                                <div class="step-pill {{ $stepClasses[$step] }} {{ $i <= $currentIdx ? 'done' : 'inactive' }}">
                                    {{ $stepIcons[$step] }} {{ ucfirst($step) }}
                                </div>
                                @if(!$loop->last)
                                    <span class="step-arrow">›</span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    {{-- Advance Button --}}
                    <div class="mb-4">
                        @if($next)
                            <button type="button"
                                    class="btn-advance {{ $btnClass }}"
                                    onclick="advanceStatus('{{ $next }}')">
                                {{ $stepIcons[$next] }}
                                Mark as {{ ucfirst($next) }}
                            </button>
                        @else
                            <button type="button" class="btn-advance is-delivered" disabled>
                                📬 Order Delivered
                            </button>
                        @endif
                    </div>

                    <!-- PAYMENT STATUS -->
                    <div class="mb-3">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-select">
                            <option value="pending"  {{ $order->payment_status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                            <option value="paid"     {{ $order->payment_status == 'paid'    ? 'selected' : '' }}>✅ Paid</option>
                        </select>
                    </div>

                    <!-- TRACKING NUMBER -->
                    <div class="mb-3">
                        <label class="form-label">Tracking Number</label>
                        <input type="text" name="tracking_number"
                               value="{{ old('tracking_number', $order->tracking_number) }}"
                               class="form-control"
                               placeholder="Enter tracking number">
                    </div>

                    <!-- NOTES -->
                    <div class="mb-0">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3"
                                  placeholder="Enter notes">{{ old('notes', $order->notes) }}</textarea>
                    </div>

                </div>

            </div>
        </div>

        <!-- ===== ORDER ITEMS CARD ===== -->
        <div class="card border-0 shadow-sm p-4 mb-4">
            <div class="section-heading">
                🛍️ Order Items
                <span style="background:#e8ecf8; color:#4e73df; font-size:12px;
                             font-weight:700; padding:3px 10px; border-radius:20px;">
                    {{ $order->items->count() }} item(s)
                </span>
            </div>

            <div class="row g-3">
                @forelse($order->items as $item)
                <div class="col-md-6 col-xl-4">
                    <div class="item-card">

                        {{-- Product Image --}}
                        <img src="{{ asset('admin/assets/images/'.$item->product->proimage) }}"
                             class="item-img"
                             alt="{{ $item->product->proname ?? 'Product' }}">

                        {{-- Details --}}
                        <div class="flex-grow-1">
                            <div class="item-name">
                                {{ $item->product->proname ?? 'No Product' }}
                            </div>

                            <div>
                                <span class="item-meta-badge">📏 {{ $item->size }}</span>
                                <span class="item-meta-badge">🔢 Qty: {{ $item->qty }}</span>
                            </div>

                            <div class="item-price">₹ {{ number_format($item->final_price, 2) }}</div>

                            <span class="badge rounded-pill
                                {{ $item->status == 'active' ? 'bg-success' : 'bg-danger' }}"
                                style="font-size:11px;">
                                {{ ucfirst($item->status) }}
                            </span>

                            @if($item->status == 'cancelled')
                            <div class="cancel-box">
                                <strong>Cancelled:</strong> {{ $item->cancelled_at }}<br>
                                <strong>Reason:</strong> {{ $item->cancel_reason }}
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-warning mb-0">⚠️ No items found for this order.</div>
                </div>
                @endforelse
            </div>
        </div>

        <!-- ===== SUBMIT ===== -->
        <div class="d-flex gap-3">
            <button type="submit" class="btn btn-primary px-5"
                    style="border-radius:50px; font-weight:700; font-size:15px; padding:10px 32px;">
                💾 Update Order
            </button>
            <a href="{{ url('admin/Order') }}"
               class="btn btn-outline-secondary px-4"
               style="border-radius:50px; font-weight:600;">
                Cancel
            </a>
        </div>

    </form>

</div>

<script>
function advanceStatus(nextStatus) {
    document.getElementById('statusInput').value = nextStatus;
    document.querySelector('form').submit();
}
</script>
@endsection