@extends('admin.layouts')

@section('user-css')
<style>
.page-title { font-weight: 600; font-size: 26px; }
.page-subtitle { font-size: 14px; color: #6c757d; }
.bg-gradient-primary { background: linear-gradient(45deg, #4e73df, #224abe); }
.card { border-radius: 12px; }
.shadow-sm { box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
.btn-back {
    background: #ffffff;
    color: #2f4fb3;
    border-radius: 10px;
    padding: 6px 14px;
    font-weight: 500;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.btn-back i {
    font-size: 18px;
    transition: transform 0.3s ease;
}

/* Hover effect */
.btn-back:hover {
    background: #2f4fb3;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(47, 79, 179, 0.3);
}

/* Icon slide effect */
.btn-back:hover i {
    transform: translateX(-3px);
}
</style>
@endsection

@section('main-content')
<div class="content-wrapper">

    <!-- Header -->
    <div class="page-header mb-4">
        <h2 class="page-title">User</h2>
        <p class="page-subtitle">Order User Details</p>
    </div>

    <!-- Card -->
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
    <h5 class="mb-0">User Details</h5>

    <a href="{{ url()->previous() }}" class="btn-back">
    <i class="mdi mdi-arrow-left"></i> Back
</a>
</div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th>Name</th>
                    <td>{{ $data->name }}</td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td>{{ $data->email }}</td>
                </tr>

                <tr>
                    <th>Phone</th>
                    <td>{{ $data->phone }}</td>
                </tr>

                <tr>
                    <th>Address Line 1</th>
                    <td>{{ $data->address_line1 }}</td>
                </tr>

                <tr>
                    <th>Address Line 2</th>
                    <td>{{ $data->address_line2 }}</td>
                </tr>

                <tr>
                    <th>City</th>
                    <td>{{ $data->city }}</td>
                </tr>

                <tr>
                    <th>State</th>
                    <td>{{ $data->state }}</td>
                </tr>

                <tr>
                    <th>Postal Code</th>
                    <td>{{ $data->postal_code }}</td>
                </tr>

            </table>

        </div>
    </div>
</div>
@endsection