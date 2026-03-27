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
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prduct Size</label>
                            <select name="size" class="form-select">
                                <option value="">Select Size</option>

                                <!-- Upper -->
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>

                                <!-- Lower -->
                                <option value="28">28</option>
                                <option value="30">30</option>
                                <option value="32">32</option>
                                <option value="34">34</option>
                                <option value="36">36</option>
                                <option value="38">38</option>
                            </select>
                            @error('size')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- qty--->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" class="form-control custom-input" placeholder="Enter stock">
                            @error('stock')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
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