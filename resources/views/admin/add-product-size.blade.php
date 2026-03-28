@extends('admin.layouts')

@section('main-content')
<div class="content-wrapper">

    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title">Product Size Management</h2>
            <p class="page-subtitle">Add Product Size here</p>
        </div>
    </div>

    <!-- Breadcrumb -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-2 px-3">
            <div class="d-flex align-items-center text-muted small">
                <i class="mdi mdi-home-outline me-2"></i>
                <span>Dashboard</span>
                <i class="mdi mdi-chevron-right mx-2"></i>
                <span class="text-dark fw-semibold">Add Product Size</span>
            </div>
        </div>
    </div>
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    <!-- Main Card -->
    <div class="col-12 grid-margin stretch-card">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">

                <h4 class="card-title mb-3">Add Product Size</h4>

                <form action="{{ url('admin/save-product-size') }}" method="POST">
                    @csrf

                    <div class="row">

                        <!-- Select Product -->
                        <div class="mb-3">
                            <label class="form-label">Select Product</label>
                            <select name="proid" class="form-select">
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                <option value="{{ $product->proid }}">
                                    {{ $product->proname }}
                                </option>
                                @endforeach
                            </select>
                            @error('proid')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- size-->
                        <div class="mb-3">
                            <label class="form-label">Product Sizes</label>

                            <div class="row">

                                @php
                                $sizes = ['S','M','L','XL','XXL','28','30','32','34','36','38'];
                                @endphp

                                @foreach($sizes as $s)
                                <div class="col-md-3 mb-2">
                                    <div class="d-flex align-items-center border rounded p-2">

                                        <!-- Checkbox -->
                                        <input type="checkbox" name="size[]" value="{{ $s }}" class="me-2 size-check">

                                        <!-- Label -->
                                        <label class="me-2">{{ $s }}</label>

                                        <!-- Stock Input -->
                                        <input type="number"
                                            name="stock[{{ $s }}]"
                                            class="form-control form-control-sm stock-input"
                                            placeholder="Qty"
                                            min="1"
                                            
                                            disabled>

                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>


                    </div>

                    <!-- Buttons -->
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="mdi mdi-content-save-outline"></i> Save
                        </button>

                        <a href="{{ url('admin/product_size') }}" class="btn btn-light">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection



@section('js')
<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".size-check").forEach(function (checkbox) {

        checkbox.addEventListener("change", function () {

            let stockInput = this.closest('.d-flex').querySelector(".stock-input");

            if (this.checked) {
                stockInput.disabled = false;
                stockInput.focus();
            } else {
                stockInput.disabled = true;
                stockInput.value = "";
            }

        });

    });

});
</script>
<script>
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(el => el.style.display = 'none');
}, 3000);
</script>
@endsection