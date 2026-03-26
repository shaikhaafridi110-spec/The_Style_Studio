@extends('admin.layouts')

@section('main-content')
<div class="content-wrapper">

    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title">Product Image Management</h2>
            <p class="page-subtitle">Add Product Image here</p>
        </div>
    </div>

    <!-- Breadcrumb -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-2 px-3">
            <div class="d-flex align-items-center text-muted small">
                <i class="mdi mdi-home-outline me-2"></i>
                <span>Dashboard</span>
                <i class="mdi mdi-chevron-right mx-2"></i>
                <span class="text-dark fw-semibold">Add Product Image</span>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="col-12 grid-margin stretch-card">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">

                <h4 class="card-title mb-3">Add Product Image</h4>

                <form action="{{ url('admin/save-product-image') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <!-- Select Product -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Select Product</label>
                            <select name="proid" class="form-select" required>
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

                        <!-- Sort Order -->
                       

                        <!-- Image Upload -->
                        <div class="">
                            <label class="form-label">Product Image</label>
                            <input type="file" name="image[]"
                                class="form-control" multiple required>
                                @error('image')
    <small class="text-danger">{{ $message }}</small>
@enderror
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="mdi mdi-content-save-outline"></i> Save
                        </button>

                        <a href="{{ url('admin/product-images') }}" class="btn btn-light">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection