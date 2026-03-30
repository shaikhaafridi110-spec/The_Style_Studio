@extends('admin.layouts')

@section('user-css')
<style>
    .form-control {
        border-radius: 8px;
    }

    .text-danger {
        font-size: 13px;
    }
    .btn-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    font-size: 14px;
    border-radius: 10px;
    border: 1px solid rgba(255,255,255,0.3);
    color: #fff;
    background: transparent;
    transition: all 0.3s ease;
}

/* Icon style */
.btn-back i {
    font-size: 16px;
    transition: transform 0.3s ease;
}

/* Hover effect */
.btn-back:hover {
    background: rgba(255,255,255,0.15);
    color: #fff;
    transform: translateY(-2px);
}

/* Icon slide effect */
.btn-back:hover i {
    transform: translateX(-4px);
}
</style>
@endsection

@section('main-content')
<div class="content-wrapper">

    <div class="page-header mb-4">
        <h2 class="page-title">Edit User</h2>
        <p class="page-subtitle">Update User Details</p>
    </div>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between">
            <h5 class="mb-0">Edit User</h5>

            <a href="{{ url()->previous() }}" class="btn-back">
    <i class="mdi mdi-arrow-left"></i> Back
</a>
        </div>

        <div class="card-body">

            <form action="{{ url('admin/user-update', $data->id) }}" method="POST">
                @csrf
               

                <div class="row">

                    <!-- Name -->
                    <div class="col-md-6 mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $data->name) }}">

                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $data->email) }}">

                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6 mb-3">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control"
                            value="{{ old('phone', $data->phone) }}">

                        @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address 1 -->
                    <div class="col-md-6 mb-3">
                        <label>Address Line 1</label>
                        <textarea name="address_line1" class="form-control" rows="3">{{ old('address_line1', $data->address_line1) }}</textarea>

                        @error('address_line1')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address Line 2 -->
                    <div class="col-md-6 mb-3">
                        <label>Address Line 2</label>
                        <textarea name="address_line2" class="form-control" rows="3">{{ old('address_line2', $data->address_line2) }}</textarea>

                        @error('address_line2')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- City -->
                    <div class="col-md-6 mb-3">
                        <label>City</label>
                        <input type="text" name="city" class="form-control"
                            value="{{ old('city', $data->city) }}">

                        @error('city')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- State -->
                    <div class="col-md-6 mb-3">
                        <label>State</label>
                        <input type="text" name="state" class="form-control"
                            value="{{ old('state', $data->state) }}">

                        @error('state')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Postal Code -->
                    <div class="col-md-6 mb-3">
                        <label>Postal Code</label>
                        <input type="text" name="postal_code" class="form-control"
                            value="{{ old('postal_code', $data->postal_code) }}">

                        @error('postal_code')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    
                    

                        
                </div>

                <button type="submit" class="btn btn-primary mt-3">Update User</button>

            </form>

        </div>
    </div>
</div>
@endsection