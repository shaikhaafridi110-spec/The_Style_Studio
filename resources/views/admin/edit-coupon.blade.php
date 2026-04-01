@extends('admin.layouts')

@section('main-content')
<div class="content-wrapper">

    <div class="page-header mb-4">
        <h2>Edit Coupon</h2>
    </div>

    <div class="card p-4">

        <form action="{{ url('admin/update-coupon/'.$coupon->coupon_id) }}" method="POST">
            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>Coupon Code</label>
                    <input type="text" name="code" value="{{ $coupon->code }}" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Discount</label>
                    <input type="number" name="discount" value="{{ $coupon->discount }}" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Type</label>
                    <select name="type" class="form-control">
                        <option value="percent" {{ $coupon->type=='percent'?'selected':'' }}>Percent</option>
                        <option value="fixed" {{ $coupon->type=='fixed'?'selected':'' }}>Fixed</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Expiry Date</label>
                    <input type="date" name="expiry_date" value="{{ $coupon->expiry_date }}" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Usage Limit</label>
                    <input type="number" name="usage_limit" value="{{ $coupon->usage_limit }}" class="form-control">
                </div>

            </div>

            <button class="btn btn-primary mt-3">Update Coupon</button>

        </form>

    </div>
</div>
@endsection