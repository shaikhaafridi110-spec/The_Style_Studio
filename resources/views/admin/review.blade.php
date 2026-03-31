@extends('admin.layouts')

@section('user-css')
<style>
    .pagination {
        gap: 8px;
        align-items: center;
    }

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
    }

    .page-item .page-link:hover {
        background-color: #2f4fb3;
        color: #fff;
    }

    .page-item.active .page-link {
        background: linear-gradient(135deg, #4a6cf7, #2f4fb3);
        color: #fff;
        border: none;
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
            <h2 class="page-title">Review Management</h2>
            <p class="page-subtitle">Manage all product reviews</p>
        </div>
    </div>

    <!-- Breadcrumb -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-2 px-3">
            <div class="d-flex align-items-center text-muted small">
                <i class="mdi mdi-home-outline me-2"></i>
                <span>Dashboard</span>
                <i class="mdi mdi-chevron-right mx-2"></i>
                <span class="text-dark fw-semibold">Review</span>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Main Card -->
    <div class="card shadow-lg border-0 rounded-4">

        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between">
            <h5 class="mb-0">Review List</h5>

            <!-- FILTER -->
            <form method="GET" action="{{ url('admin/review') }}" class="d-flex gap-2">
                
            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Product</th>
                            <th>Rating</th>
                            <th>Review</th>
                            
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if($data->count() == 0)
                        <tr>
                            <td colspan="6" class="text-center text-danger">
                                No reviews found
                            </td>
                        </tr>
                        @endif

                        @foreach($data as $d)
                        <tr>

                            <!-- USER -->
                            <td>{{ $d->user->name }}</td>

                            <!-- PRODUCT -->
                            <td>{{ $d->product->proname }}</td>

                            <!-- RATING -->
                            <td>
                                @for($i=1;$i<=5;$i++)
                                    @if($i <= $d->rating)
                                        ⭐
                                    @else
                                        ☆
                                    @endif
                                @endfor
                            </td>

                            <!-- REVIEW -->
                            <td>{{ $d->review }}</td>

                            <!-- STATUS -->
                            

                            <!-- DELETE -->
                            <td>
                                <a href="{{ url('admin/delete-review',$d->review_id) }}"
                                   onclick="return confirm('Delete review?')"
                                   class="btn btn-danger btn-sm">
                                   Delete
                                </a>
                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>

                <!-- PAGINATION -->
                {{ $data->onEachSide(2)->links('pagination::bootstrap-5') }}

            </div>
        </div>

    </div>
</div>
@endsection