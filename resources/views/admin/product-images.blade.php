@extends('admin.layouts')

@section('user-css')
<style>
    .filter-select {
    background-color: #ffffff;
    color: #333;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 10px 12px;
    font-size: 14px;
    width: 100%;
    transition: all 0.3s ease;
    cursor: pointer;
}

/* Hover Effect */
.filter-select:hover {
    border-color: #007bff;
}

/* Focus Effect */

.filter-select:focus {
    outline: none;
    box-shadow: 0 0 8px rgba(255,255,255,0.4);
}

/* Dropdown arrow custom */
.filter-select {
    background-color:white; /* match your blue */
    color: #090909;
    border: 1px solid #ffffff80;
    border-radius: 12px;
    padding: 10px 14px;
    font-size: 15px;
    width: 220px;
    appearance: none;
    cursor: pointer;
max-height: 200px;
    overflow-y: auto;
    /* arrow color white */
    background-image: url("data:image/svg+xml;utf8,<svg fill='white' height='20' viewBox='0 0 20 20' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M5 7l5 5 5-5z'/></svg>");
    background-repeat: no-repeat;
    background-position: right 12px center;
}
.filter-select option {
    color: #000; /* dropdown list always white bg */
    background-color: #fff;
}


    .btn-edit {
        background: linear-gradient(45deg, #36b9cc, #1c7ed6);
        color: #fff;
        border-radius: 20px;
        padding: 5px 14px;
        transition: 0.3s;
        margin-bottom: 10px;
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        color: #fff;
    }

    .btn-delete {
        background: linear-gradient(45deg, #ff4d4d, #cc0000);
        color: #fff;
        border-radius: 20px;
        padding: 5px 14px;
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

    #product-img {
        width: 100px;
        height: 120px;
        object-fit: cover;
        border-radius: 10px;
    }

    .shadow-sm {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .add-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        /* space between icon & text */
        background: linear-gradient(45deg, #6a5af9, #8360c3);
        color: #fff;
        padding: 8px 18px;
        border-radius: 30px;
        font-weight: 500;
        border: none;
        transition: 0.3s ease;
    }

    .add-btn i {
        font-size: 18px;
        line-height: 1;
    }

    .add-btn:hover {
        transform: translateY(-2px);
        color: #fff;
    }

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
</style>
@endsection

@section('main-content')
<div class="content-wrapper">

    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="page-title">Product Management</h2>
            <p class="page-subtitle">Manage all Product_images here</p>
        </div>

        <div>
            <a href="{{ url('admin/add-product-image') }}" class="btn add-btn">
                <i class="mdi mdi-plus"></i>
                <span>Add Product-Images</span>
            </a>
        </div>

    </div>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    <!-- Breadcrumb Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-2 px-3">
            <div class="d-flex align-items-center text-muted small">
                <i class="mdi mdi-home-outline me-2"></i>
                <span>Dashboard</span>
                <i class="mdi mdi-chevron-right mx-2"></i>
                <span class="text-dark fw-semibold">Product-Images</span>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-gradient-primary text-white rounded-top-4 
            d-flex justify-content-between align-items-center">

            <h5 class="mb-0">Product-Images List</h5>

            <form method="GET" action="{{ url('admin/product-image') }}"
                class="d-flex align-items-center gap-3 filter-form">


                <!-- category Dropdown -->
                <select  name="product"
                    class="form-select filter-select"
                    onchange="this.form.submit()" >

                    <option value="">Product</option>

                    @foreach($pro as $p)
                    <option value="{{ $p->proid }}"
                        {{ request('product') == $p->proid ? 'selected' : '' }}>
                        {{ $p->proname }}
                    </option>
                    @endforeach

                </select>

                <!-- Search Input -->


            </form>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table custom-table align-middle">
                    <thead>
                        <tr>

                            <th>Proname</th>
                            <th>Image</th>
                            <th>Sort_Order</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if($productImages->count() == 0)
                        <tr>
                            <td colspan="7" class="text-center text-danger">
                                No found
                            </td>
                        </tr>
                        @endif


                        @foreach($productImages as $p)

                        <tr>
                            <td>{{$p->product->proname}}</td>

                            <td>
                                <img src="{{ asset('admin/assets/images/'.$p->image) }}"
                                    id="product-img"
                                    alt="">


                            </td>
                            <td>{{ $p->sort_order }}</td>

                            <td>
                                <a href="{{ url('admin/edit-product-image',$p->proimg_id) }}"
                                    class="btn btn-sm btn-edit">
                                    <i class="mdi mdi-pencil-outline"></i> Edit
                                </a><br>

                                <a href="{{ url('admin/delete-product-image',$p->proimg_id) }}"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this image?')">
                                    <i class="mdi mdi-delete"></i> Delete
                                </a>
                            </td>


                        </tr>

                        @endforeach

                    </tbody>

                </table>
            </div>
            <!-- {{$productImages->links()}}
              -->
            {{ $productImages->onEachSide(1)->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>


@endsection