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

    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div class="wishlist-header">
            <h2 class="page-title">Order List</h2>
            <p class="page-subtitle">View of all orders</p>
        </div>

    </div>

    <!-- Breadcrumb Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-2 px-3">
            <div class="d-flex align-items-center text-muted small">
                <i class="mdi mdi-home-outline me-2"></i>
                <span>Dashboard</span>
                <i class="mdi mdi-chevron-right mx-2"></i>
                <span class="text-dark fw-semibold">Order List</span>
            </div>
        </div>
    </div>
    @session('success')

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endsession

    <!-- Main Content Card -->
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-gradient-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Order List</h5>
            <div class="d-flex justify-content-end">
                <form method="GET" action="" class="d-flex align-items-center gap-3 filter-form">
                    <select name="status" style="width: fit-content;"
                        class="form-select filter-select"
                        onchange="this.form.submit()">

                        <option value="">Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>
                    <select name="payment_status" style="width: fit-content;"
                        class="form-select filter-select"
                        onchange="this.form.submit()">

                        <option value="">Payment Status</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>

                    </select>


                    <select name="date" style="width: fit-content;"
                        class="form-select filter-select"
                        onchange="this.form.submit()">

                        <option value="">Date</option>

                        @foreach($date as $key => $group)
                        <option value="{{$group->order_date}}" {{ request('date') == $group->order_date ? 'selected' : '' }}>
                            {{ date('d M Y', strtotime($group->order_date)) }}
                        </option>
                        @endforeach

                    </select>
                </form>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table custom-table align-middle">
                    <thead>
                        <tr>
                            <th>User_id</th>
                            <th>Order Status</th>
                            <th>Amount Status</th>

                            <th>payment</th>

                            <th>tracking_number</th>

                            <th>notes</th>
                            <th>Edit</th>
                            <th>Delete</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if($data->count() == 0)
                        <tr>
                            <td colspan="9" class="text-center text-danger">
                                No orders found.
                            </td>
                        </tr>
                        @endif


                        @foreach($data as $d)

                        <tr>

                            <td>{{ $d->name}}</td>
                            <td>
                                <div class="d-flex flex-column gap-2 capitalize">
                                    <h8 style="text-transform: capitalize;"> order_number: {{ $d->order_number }}</h8>
                                    <h8 style="text-transform: capitalize;">Status: {{$d->status}}</h8>
                                    <h8 style="text-transform: capitalize;">Order Date: {{ date('d M Y', strtotime($d->order_date)) }}</h8>
                                    <h8 style="text-transform: capitalize;">Delivery Date:
                                        @if($d->delivery_date)
                                        {{ date('d M Y', strtotime($d->delivery_date)) }}
                                        @else
                                        N/A
                                        @endif
                                    </h8>
                                </div>
                            </td>
                            <td>

                                <div class="d-flex flex-column gap-1">
                                    <h8>Total: {{$d->total_amount}}</h8>
                                    <h8>Discount: {{$d->discount_amount}}</h8>
                                    <h8>Tax: {{ $d->tax_amount }}</h8>
                                    <h8 style="padding-bottom:1px;">Shipping: {{$d->shipping_charge}}</h8>

                                    <h8 style="border-bottom:2px dashed black ;border-top:2px dashed black">Final: {{ $d->final_amount  }}</h8>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-2 capitalize">
                                    <h8 style="text-transform: capitalize;">Method: {{$d->payment_method}}</h8>
                                    <h8 style="text-transform: capitalize;">Status: {{$d->payment_status}}</h8>

                                </div>
                            </td>


                            <td>
                                @if($d->tracking_number)
                                {{ $d->tracking_number }}
                                @else
                                <span class="text-muted">N/A</span>
                                @endif
                            </td>


                            <td>
                                @if($d->notes)
                                {{ $d->notes }}
                                @else
                                <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            
                            <td>
                                <a href="{{ url('admin/order-edit/'.$d->id) }}" class="btn btn-sm btn-warning">
                                    Edit
                                </a>
                            </td>

                            </td>
                            <td>
                                <a href="{{ url('admin/delete_order/'.$d->id) }}" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this order?');">
                                    Delete
                                </a>
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>


                {{ $data->onEachSide(2)->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>


@endsection