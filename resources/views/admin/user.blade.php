@extends('admin.layouts')

@section('user-css')
<style>
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
                            <th>Address Line 1</th>
                            <th>Address Line 2</th>
                            <th>City / State</th>
                            <th>Postal Code</th>
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
                            <td>{{ $d->address_line1 }}</td>
                            <td>{{ $d->address_line2 }}</td>
                            <td>{{ $d->city }}, {{ $d->state }}</td>
                            <td>{{ $d->postal_code }}</td>
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
                {{$data->links()}}
            </div>
        </div>
    </div>
</div>


@endsection