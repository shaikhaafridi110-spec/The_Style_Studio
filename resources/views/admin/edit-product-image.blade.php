@extends('admin.layouts')

@section('main-content')
<div class="content-wrapper">

    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title">Product Image Management</h2>
            <p class="page-subtitle">Edit Product Image</p>
        </div>
    </div>

    <!-- Breadcrumb -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-2 px-3">
            <div class="d-flex align-items-center text-muted small">
                <i class="mdi mdi-home-outline me-2"></i>
                <span>Dashboard</span>
                <i class="mdi mdi-chevron-right mx-2"></i>
                <span class="text-dark fw-semibold">Edit Product Image</span>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="col-12 grid-margin stretch-card">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">

                <h4 class="card-title mb-3">Edit Product Image</h4>

                <form action="{{ url('admin/update-product-image',$image->proimg_id) }}" 
                      method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <!-- Select Product -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Select Product</label>
                            <select name="proid" class="form-select" required>
                                @foreach($products as $product)
                                    <option value="{{ $product->proid }}"
                                        {{ $product->proid == $image->proid ? 'selected' : '' }}>
                                        {{ $product->proname }}
                                    </option>
                                @endforeach
                            </select>

                            @error('proid')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Sort Order -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sort Order</label>
                            <input type="number" name="sort_order"
                                   value="{{ $image->sort_order }}"
                                   class="form-control" required>

                            @error('sort_order')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Current Image -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Current Image</label><br>
                            <img src="{{ asset('admin/assets/images/'.$image->image) }}"
                                 width="120" class="mb-2" alt="">
                        </div>

                        <!-- Change Image -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Change Image</label>
                            <input type="file" name="image"
                                   class="form-control">

                            <small class="text-muted">Leave blank if not changing image</small>

                            @error('image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="mdi mdi-content-save-outline"></i> Update
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