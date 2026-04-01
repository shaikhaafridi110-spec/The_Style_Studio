@extends('admin.layouts')

@section('main-content')
<div class="content-wrapper">

    <div class="page-header mb-4">
        <h2>Add Coupon</h2>
    </div>

    <div class="card p-4">

        @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $err)
                <div>{{ $err }}</div>
            @endforeach
        </div>
        @endif

        <form action="{{ url('admin/save-coupon') }}" method="POST">
            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>Coupon Code</label>
                    <input type="text" name="code" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Discount</label>
                    <input type="number" name="discount" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Type</label>
                    <select  style="height: 40px;" name="type" class="form-control">
                        <option value="percent">Percent</option>
                        <option value="fixed">Fixed</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Expiry Date</label>
                    <input type="date" name="expiry_date" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Usage Limit</label>
                    <input type="number" name="usage_limit" class="form-control">
                </div>

            </div>

            <button class="btn btn-primary mt-3">Save Coupon</button>

        </form>

    </div>
</div>
@endsection