@extends('admin.layouts')

@section('main-content')
<div class="content-wrapper">

    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="page-title">Category Management</h2>
            <p class="page-subtitle">Add category here</p>
        </div>



    </div>
    <!-- Breadcrumb Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-2 px-3">
            <div class="d-flex align-items-center text-muted small">
                <i class="mdi mdi-home-outline me-2"></i>
                <span>Dashboard</span>
                <i class="mdi mdi-chevron-right mx-2"></i>
                <span class="text-dark fw-semibold">Add-Category</span>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="col-12 grid-margin stretch-card">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body">

                <h4 class="card-title mb-3">Add Category</h4>

                <form action="{{ url('admin/savecategory') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <!-- Category Name -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control custom-input" placeholder="Enter category name"required>
                        </div>

                        <!-- Slug -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control custom-input" placeholder="Enter slug" required>
                        </div>

                        <!-- Status -->

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <div class="form-group ">
                                <select name="status" required
                                    class="js-example-basic-single w-100 form-select text-dark">
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category Image</label>
                            <input type="file" name="image" class="form-control custom-input"require>
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="mdi mdi-content-save-outline"></i> Save
                        </button>

                        <a href="{{ url('admin/category') }}" class="btn btn-light">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>


@endsection