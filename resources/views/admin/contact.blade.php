@extends('admin.layouts')

@section('user-css')
<style>
    /* SAME STYLE AS USER PAGE */

    /* Pagination */
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
        transition: all 0.3s ease;
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

    .shadow-sm {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
</style>
@endsection


@section('main-content')
<div class="content-wrapper">

    <!-- PAGE HEADER -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title">Contact Management</h2>
            <p class="page-subtitle">Manage all contact queries</p>
        </div>
    </div>

    <!-- BREADCRUMB -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body py-2 px-3">
            <div class="d-flex align-items-center text-muted small">
                <i class="mdi mdi-home-outline me-2"></i>
                <span>Dashboard</span>
                <i class="mdi mdi-chevron-right mx-2"></i>
                <span class="text-dark fw-semibold">Contact</span>
            </div>
        </div>
    </div>

    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- MAIN CARD -->
    <div class="card shadow-lg border-0 rounded-4">

        <!-- CARD HEADER -->
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Contact List</h5>

            <form method="GET" class="d-flex gap-2">
                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control"
                    placeholder="Search contact...">

                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">All</option>
                    <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                    <option value="in_progress" {{ request('status')=='in_progress'?'selected':'' }}>In Progress</option>
                    <option value="resolved" {{ request('status')=='resolved'?'selected':'' }}>Resolved</option>
                </select>
            </form>
        </div>

        <!-- CARD BODY -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table custom-table align-middle">

                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Reply</th>
                            <th>Delete</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if($data->count() == 0)
                        <tr>
                            <td colspan="6" class="text-center text-danger">
                                No messages found
                            </td>
                        </tr>
                        @endif

                        @foreach($data as $d)
                        <tr>

                            <!-- USER / VISITOR -->
                            <td>
                                @if($d->user)
                                <strong>{{ $d->user->name }}</strong>
                                <br>
                                <span class="badge bg-success">User</span>
                                @else
                                {{ $d->name }}
                                <br>
                                <span class="badge bg-secondary">Visitor</span>
                                @endif
                            </td>

                            <!-- EMAIL -->
                            <td>
                                {{ $d->user ? $d->user->email : $d->email }}
                            </td>

                            <!-- MESSAGE -->
                            <td>{{ $d->message }}</td>

                            <!-- STATUS -->
                            <td>
                                @if($d->status == 'in_progress')
                                <!-- CLICKABLE -->
                                <a href="{{ url('admin/contact-status/'.$d->contact_id) }}"
                                    class="btn btn-sm btn-warning">
                                    {{ ucfirst($d->status) }}
                                </a>

                                @elseif($d->status == 'pending')
                                <!-- DISABLED -->
                                <button class="btn btn-sm btn-secondary" disabled>
                                    {{ ucfirst($d->status) }}
                                </button>
                                @else
                                <!-- RESOLVED (DISABLED GREEN) -->
                                <button class="btn btn-sm btn-success" disabled>
                                    {{ ucfirst($d->status) }}
                                </button>
                                @endif
                            </td>
                            <!-- REPLY -->
                            
                            <td>
                                @if($d->status == 'pending')
                                <!-- DISABLED -->
                                <a  class="btn btn-sm btn-primary"   href="{{ url('admin/contact-reply/'.$d->contact_id) }}"
                                    >
                                    Reply
                                </a>
                                @else
                                <!-- ENABLED -->
                                
                                <button class="btn btn-sm btn-secondary" disabled>
                                    Repled
                                    </button>
                                
                                @endif
                            
                            </td>

                            <!-- DELETE -->
                            <td>
                                <a href="{{ url('admin/delete_contact/'.$d->contact_id) }}"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure?')">
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