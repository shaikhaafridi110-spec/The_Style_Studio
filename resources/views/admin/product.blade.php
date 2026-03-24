@extends('admin.layouts')

@section('user-css')
<style>
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
</style>
@endsection

@section('main-content')
<div class="content-wrapper">

    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="page-title">Product Management</h2>
            <p class="page-subtitle">Manage all Product here</p>
        </div>

        <div>
            <a href="{{ url('admin/add-product') }}" class="btn add-btn">
                <i class="mdi mdi-plus"></i>
                <span>Add Product</span>
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
                <span class="text-dark fw-semibold">Product</span>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-gradient-primary text-white rounded-top-4 
            d-flex justify-content-between align-items-center">

            <h5 class="mb-0">Product List</h5>

            <form method="GET" action="{{ url('admin/product') }}"
                class="d-flex align-items-center gap-3 filter-form">

                <!-- Status Dropdown -->
                <select style="background-color: white;" name="status"
                    class="form-select filter-select"
                    onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>
                </select>

                <!-- Search Input -->
                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control filter-input"
                    placeholder="Search product..."
                    onkeyup="this.form.submit()">

            </form>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table custom-table align-middle">
                    <thead>
                        <tr>
                            
                            <th>Proname</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Status</th>
                            <th>Category</th>
                            <th>Proimage</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if($products->count() == 0)
                        <tr>
                            <td colspan="7" class="text-center text-danger">
                                No matching product found
                            </td>
                        </tr>
                        @endif


                        @foreach($products as $p)

                        <tr>
                            <td>{{$p->proname}}</td>
                            <td>{!! $p->description !!}</td>
                            <td>{{ $p->price }}</td>
                            <td>{{ $p->discount_price }}</td>
                            <td>
                                <a href="{{url('admin/prostatus',$p->proid)}}" class="btn {{ $p->status == 'active' ? 'btn-success' : 'btn-danger' }}">
    
                                {{ $p->status }}
                                </a>
                            </td>
                            <td>{{ $p->category->name }}</td>
                            <td>
                                    <img src="{{ asset('admin/assets/images/'.$p->proimage) }}"
                                    id="product-img"
                                    alt="">
                                    {{$p->proimage}}
                                   
                            </td>
                            <td>
                                <a href="{{ url('admin/edit-product',$p->proid) }}"
                                    class="btn btn-sm btn-edit">
                                    <i class="mdi mdi-pencil-outline"></i> Edit
                                </a><br>
                                <a href="{{url('admin/delete_product',$p->proid)}}"
                                    class="btn btn-sm btn-delete"
                                    onclick="return confirm('Are you sure you want to delete this Product?')">
                                    <i class="mdi mdi-delete-outline"></i> Delete
                                </a>
                            </td>


                        </tr>

                        @endforeach

                    </tbody>

                </table>
            </div>
            {{$products->links()}}
        </div>
    </div>
</div>


@endsection