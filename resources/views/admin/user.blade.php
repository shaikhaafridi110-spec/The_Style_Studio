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
</style>
@endsection

@section('main-content')
<div class="content-wrapper">

    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title">User Management</h2>
            <p class="page-subtitle">Manage all registered users here</p>
        </div>

    </div>

    <!-- Breadcrumb Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-2 px-3">
            <div class="d-flex align-items-center text-muted small">
                <i class="mdi mdi-home-outline me-2"></i>
                <span>Dashboard</span>
                <i class="mdi mdi-chevron-right mx-2"></i>
                <span class="text-dark fw-semibold">User</span>
            </div>
        </div>
    </div>
    @session('success')

        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endsession
    <!-- Main Content Card -->
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-gradient-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">User List</h5>
            <div class="d-flex justify-content-end">
                <form method="GET" action="{{ url('admin/user') }}" class="search-form">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        onchange="this.form.submit()"
                        class="form-control search-input"
                        placeholder="Search user...">
                </form>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table custom-table align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            
                            <th>Edit / Check_Details</th>
                          
                            <th>Delete</th>
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
                            <td>{{$d->name}}</td>
                            <td>{{ $d->email }}</td>
                            <td>{{ $d->phone }}</td>
                            
                            <td>
                                <a edit href="{{url('admin/edit_user',$d->id)}}" class="btn btn-sm btn-primary">
                                    <i class="mdi mdi-pencil-outline"></i> Edit/Check
                        
                        
                        </td>
                         
                            <td>
                                <a href="{{url('delete_user',$d->id)}}"
                                    class="btn btn-sm btn-delete"
                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="mdi mdi-delete-outline"></i> Delete
                                </a>
                            </td>

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