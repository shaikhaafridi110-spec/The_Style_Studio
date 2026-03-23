@extends('admin.layouts')

@section('main-content')
<div class="content-wrapper">

    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="page-title">Product Management</h2>
            <p class="page-subtitle">Add Product here</p>
        </div>



    </div>
    <!-- Breadcrumb Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-2 px-3">
            <div class="d-flex align-items-center text-muted small">
                <i class="mdi mdi-home-outline me-2"></i>
                <span>Dashboard</span>
                <i class="mdi mdi-chevron-right mx-2"></i>
                <span class="text-dark fw-semibold">Add-Product</span>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="col-12 grid-margin stretch-card">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">

                <h4 class="card-title mb-3">Add Product</h4>

                <form action="{{ url('admin/saveproduct') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <!-- product Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="proname" class="form-control custom-input" placeholder="Enter product name" >
                            @error('proname')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- description -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Description</label>
                            <textarea type="text" name="description" class="form-control custom-input" placeholder="Enter description"></textarea>
                            @error('description')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <!--price -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" name="price" class="form-control custom-input" placeholder="Enter price" >
                            @error('price')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror 
                        </div>
                        <!-- discount_price -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Discount_Price</label>
                            <input type="number" name="discount_price" class="form-control custom-input" placeholder="Enter discount_price" >
                            @error('discount_price')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <!-- Category -->

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <div class="form-group ">
                                <select name="catid" 
                                    class="js-example-basic-single w-100 form-select text-dark">
                                    <option value="" disabled selected>Select Status</option>
                                    @foreach($data as $d)
                                        <option value="{{$d->id}}">{{$d->name}}</option>
                                    @endforeach
                                </select>
                                @error('catid')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Image</label>
                            <input type="file" name="proimage" class="form-control custom-input">
                            @error('proimage')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                     
                    <!-- Buttons -->
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="mdi mdi-content-save-outline"></i> Save
                        </button>

                        <a href="{{ url('admin/product') }}" class="btn btn-light">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>


@endsection