@extends('admin.layouts')

@section('user-css')
<style>
    /* Pagination container */
    .pagination {
        gap: 8px;
        align-items: center;
    }

    /* Page items */
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

    /* Hover effect */
    .page-item .page-link:hover {
        background-color: #2f4fb3;
        color: #fff;
        border-color: #2f4fb3;
    }

    /* Active page */
    .page-item.active .page-link {
        background: linear-gradient(135deg, #4a6cf7, #2f4fb3);
        color: #fff;
        border: none;
        box-shadow: 0 4px 10px rgba(47, 79, 179, 0.4);
    }

    /* Disabled (dots ...) */
    .page-item.disabled .page-link {
        background-color: #f1f1f1;
        color: #999;
        border: none;
    }

    /* Prev/Next arrows */
    .page-item:first-child .page-link,
    .page-item:last-child .page-link {
        border-radius: 12px;
        width: auto;
        padding: 0 12px;
    }

    .page-title {
        font-weight: 600;
        font-size: 26px;
    }

    .page-subtitle {
        font-size: 14px;
        color: #6c757d;
    }

    .bg-gradient-primary {
        background: linear-gradient(45deg, #4e73df, #224abe);
    }

    .card {
        border-radius: 12px;
    }

    .btn-primary {
        border-radius: 8px;
        padding: 6px 15px;
    }

    .shadow-sm {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    #product-img {
        width: 100px;
        height: 120px;
        object-fit: cover;
        border-radius: 10px;
    }
</style>
@endsection



@section('main-content')
<div class="content-wrapper">

    <h2>Edit Order</h2>

    <form action="{{ url('admin/order-update/'.$order->id) }}" method="POST">
        @csrf

        <!-- ================= USER ================= -->
        <div class="card p-3 mb-3">
            <h4>User Details</h4>

            <label>Name</label>
            <input type="text" name="name" value="{{ old('name',$order->name) }}" class="form-control">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror

            <label>Email</label>
            <input type="text" name="email" value="{{ old('email',$order->user->email ?? '') }}" class="form-control">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror

            <label>Phone</label>
            <input type="text" name="phone" value="{{ old('phone',$order->phone) }}" class="form-control">
            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror

            <label>Address</label>
            <input type="text" name="address_line1" value="{{ $order->address_line1 }}" class="form-control">
        </div>

        <!-- ================= ORDER ================= -->
        <div class="card shadow-sm p-4 mb-4 border-0">

            <h4 class="mb-3 fw-bold text-dark">Order Details</h4>

            <!-- STATUS -->
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
                    <option value="confirmed" {{ $order->status=='confirmed'?'selected':'' }}>Confirmed</option>
                    <option value="shipped" {{ $order->status=='shipped'?'selected':'' }}>Shipped</option>
                    <option value="delivered" {{ $order->status=='delivered'?'selected':'' }}>Delivered</option>
                </select>
            </div>

            <!-- AMOUNT + PAYMENT METHOD (DISPLAY ONLY) -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center p-3 rounded"
                    style="background: linear-gradient(45deg,#6a5acd,#4e73df); color:#fff;">

                    <div>
                        <div style="font-size:14px;">Total Amount</div>
                        <div style="font-size:22px; font-weight:700;">
                            ₹ {{ $order->final_amount }}
                        </div>
                    </div>

                    <div class="text-end">
                        <div style="font-size:14px;">Payment Method</div>
                        <div style="font-size:16px; font-weight:600;">
                            {{ strtoupper($order->payment_method) }}
                        </div>
                    </div>

                </div>
            </div>

            <!-- PAYMENT STATUS -->
            <div class="mb-3">
                <label class="form-label">Payment Status</label>
                <select name="payment_status" class="form-control">
                    <option value="pending" {{ $order->payment_status=='pending'?'selected':'' }}>Pending</option>
                    <option value="paid" {{ $order->payment_status=='paid'?'selected':'' }}>Paid</option>
                </select>
            </div>

            <!-- TRACKING NUMBER -->
            <div class="mb-3">
                <label class="form-label">Tracking Number</label>
                <input type="text" name="tracking_number"
                    value="{{ old('tracking_number',$order->tracking_number) }}"
                    class="form-control" placeholder="Enter tracking number">
            </div>

            <!-- NOTES -->
            <div class="mb-3">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="3"
                    placeholder="Enter notes">{{ old('notes',$order->notes) }}</textarea>
            </div>

        </div>

        <!-- ================= ORDER ITEMS (EDITABLE) ================= -->
        <div class="card p-4 mb-4 border-0 shadow-sm">
            <h4 class="mb-3 fw-bold">Order Items</h4>

            <div class="row">
                @forelse($order->items as $item)

                <div class="col-md-6 mb-3">
                    <div class="d-flex p-3 border rounded align-items-center shadow-sm"
                        style="background:#fafbff;">

                        <!-- PRODUCT IMAGE -->
                        <div class="me-3">
                            <img src="{{ asset('admin/assets/images/'.$item->product->proimage) }}"
                                id="product-img">
                        </div>

                        <!-- PRODUCT DETAILS -->
                        <div class="flex-grow-1">

                            <h6 class="fw-bold mb-1">
                                {{ $item->product->proname ?? 'No Product' }}
                            </h6>

                            <small class="text-muted">
                                Size: {{ $item->size }} | Qty: {{ $item->qty }}
                            </small>

                            <div class="mt-2">
                                <span class="fw-semibold text-dark">
                                    ₹ {{ $item->final_price }}
                                </span>
                            </div>

                            <!-- STATUS -->
                            <div class="mt-2">
                                <span class="badge 
                            {{ $item->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </div>

                            <!-- CANCEL INFO -->
                            @if($item->status == 'cancelled')
                            <div class="mt-2 text-danger small">
                                Cancelled: {{ $item->cancelled_at }} <br>
                                Reason: {{ $item->cancel_reason }}
                            </div>
                            @endif

                        </div>

                    </div>
                </div>

                @empty
                <p class="text-danger">No Items Found</p>
                @endforelse
            </div>
        </div>

        <button class="btn btn-success">Update Order</button>

    </form>

</div>
@endsection