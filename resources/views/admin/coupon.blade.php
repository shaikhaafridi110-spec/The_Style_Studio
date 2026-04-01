@extends('admin.layouts')

@section('user-css')
<style>
    .page-title { font-weight: 600; font-size: 26px; }
    .page-subtitle { font-size: 14px; color: #6c757d; }

    .bg-gradient-primary {
        background: linear-gradient(45deg, #4e73df, #224abe);
    }

    .card { border-radius: 12px; }

    .btn-edit {
        background: linear-gradient(45deg, #36b9cc, #1c7ed6);
        color: #fff;
        border-radius: 20px;
        padding: 5px 14px;
    }

    .btn-delete {
        background: linear-gradient(45deg, #ff4d4d, #cc0000);
        color: #fff;
        border-radius: 20px;
        padding: 5px 14px;
    }

    .add-btn {
        background: linear-gradient(45deg, #6a5af9, #8360c3);
        color: #fff;
        padding: 8px 18px;
        border-radius: 30px;
        border: none;
    }

    /* Pagination */
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
    }
</style>
@endsection


@section('main-content')
<div class="content-wrapper">

    <!-- HEADER -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title">Coupon Management</h2>
            <p class="page-subtitle">Manage all coupons</p>
        </div>

        <a href="{{ url('admin/add-coupon') }}" class="btn add-btn">
            + Add Coupon
        </a>
    </div>

    <!-- SUCCESS -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- CARD -->
    <div class="card shadow-lg border-0 rounded-4">

        <!-- HEADER -->
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between">

            <h5>Coupon List</h5>

            <form method="GET" class="d-flex gap-2">

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       placeholder="Search code...">

                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">All</option>
                    <option value="1" {{ request('status')=='1'?'selected':'' }}>Active</option>
                    <option value="0" {{ request('status')=='0'?'selected':'' }}>Inactive</option>
                </select>

            </form>
        </div>

        <!-- BODY -->
        <div class="card-body">
            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Discount</th>
                           
                            <th>Expiry</th>
                            <th>Used</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @if($data->count()==0)
                        <tr>
                            <td colspan="7" class="text-center text-danger">
                                No coupons found
                            </td>
                        </tr>
                        @endif

                        @foreach($data as $d)
                        <tr>

                            <td>{{ $d->code }}</td>

                            <td>{{ $d->type == 'percent' ? $d->discount.'%' : '₹'.$d->discount }}</td>

                            

                            <td>{{ $d->expiry_date ?? '-' }}</td>

                            <td>{{ $d->used_count }}</td>

                            <!-- STATUS -->
                            <td>
                                <a href="{{ url('admin/coupon-status/'.$d->coupon_id) }}"
                                   class="btn btn-sm {{ $d->status=='1' ? 'btn-success' : 'btn-danger' }}">
                                    {{ $d->status=='1' ? 'Active' : 'Inactive' }}
                                </a>
                            </td>

                            <!-- ACTION -->
                            <td>

                                <a href="{{ url('admin/edit-coupon/'.$d->coupon_id) }}"
                                   class="btn btn-sm btn-edit">
                                    <i class="mdi mdi-pencil"></i>
                                    Edit
                                </a>

                                <a href="{{ url('admin/delete-coupon/'.$d->coupon_id) }}"
                                   class="btn btn-sm btn-delete"
                                   onclick="return confirm('Delete this coupon?')">
                                    <i class="mdi mdi-delete"></i>
                                    Delete
                                </a>

                            </td>

                        </tr>
                        @endforeach

                    </tbody>

                </table>

                <!-- PAGINATION -->
                {{ $data->onEachSide(2)->links('pagination::bootstrap-5') }}

            </div>
        </div>

    </div>
</div>
@endsection