@extends('admin.layouts')

@section('user-css')
<style>
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

    .shadow-sm {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
     #product-img {
        width: 100px;
        height: 120px;
        object-fit: cover;
        border-radius: 10px;
    }
</style>
@endsection

@section('main-content')
<div class="content-wrapper">

    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div class="wishlist-header">
            <h2 class="page-title">Wishlist</h2>
            <p class="page-subtitle">View of favorite products</p>
        </div>

    </div>

    <!-- Breadcrumb Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-2 px-3">
            <div class="d-flex align-items-center text-muted small">
                <i class="mdi mdi-home-outline me-2"></i>
                <span>Dashboard</span>
                <i class="mdi mdi-chevron-right mx-2"></i>
                <span class="text-dark fw-semibold">Withlist</span>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-gradient-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">User List</h5>
            <div class="d-flex justify-content-end">
                <form method="GET" action="" class="search-form">
                    
                </form>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table custom-table align-middle">
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Prduct name</th>
                            <th>Product Image</th>
                            
                            <th>Fulldetails of user</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($data->count() == 0)
                        <tr>
                            <td colspan="7" class="text-center text-danger">
                                No matching users found
                            </td>
                        </tr>
                        @endif


                        @foreach($data as $d)

                        <tr>
                            
                            <td>
                               {{ $d->user->name}}
                            </td>
                            
                            <td>{{$d->product->proname}}</td>
                            <td>
                                <img src="{{ asset('admin/assets/images/'.$d->product->proimage) }}"
                                    id="product-img"
                                    alt="   {{$d->product->proimage}}">
                            </td>
                            <td>
                                <form action="{{ url('admin/user')}}" method="get">
                                    <input type="hidden" name="userid" value="{{$d->user_id}}">
                             <button style="width:100px"
                                    class="btn btn-primary">
                                     Click
                            </button>
                            </form>
                            </td>

                            
                        </tr>

                        @endforeach

                    </tbody>

                </table>


                {{ $data->onEachSide(2)->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>


@endsection