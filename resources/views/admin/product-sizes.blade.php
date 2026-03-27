@extends('admin.layouts')

@section('user-css')
<style>
    .stock-form {
        display: flex;
        align-items: center;
    }

    .stock-input {
        width: 70px;
        height: 32px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 6px;
        outline: none;
    }

    .stock-input:focus {
        border-color: #6c63ff;
        box-shadow: 0 0 5px rgba(108, 99, 255, 0.3);
    }

    .qty-btn {
        width: 32px;
        height: 32px;
        border: none;
        background: #6c63ff;
        color: #fff;
        font-weight: bold;
        border-radius: 6px;
        cursor: pointer;
    }

    .qty-btn:hover {
        background: #4e73df;
    }

    .minus {
        background: #ff4d4f;
    }

    .minus:hover {
        background: #d9363e;
    }
</style>
<style>
    .size-badge {
        background: linear-gradient(45deg, #6c63ff, #4e73df);
        color: #fff;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
    }

    .delete-btn {
        background: #ff4d4f;
        padding: 6px 10px;
        border-radius: 8px;
        transition: 0.2s;
    }

    .delete-btn:hover {
        background: #e60000;

    }

    table tr:hover {
        background-color: #f9fafc;
    }

    .size-list li {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f5f6fa;
        padding: 10px 14px;
        border-radius: 10px;
        margin-bottom: 10px;
        border: 1px solid transparent;
        transition: all 0.2s ease;
    }

    .size-list li:hover {
        background: #eef1ff;
        border: 1px solid #dcdfff;
    }

    .custom-table {
        border-collapse: collapse;
    }

    .custom-table th,
    .custom-table td {
        border: 1px solid #dee2e6;
    }

    .custom-table tr:hover {
        background-color: #f9fafc;
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

    .size-list {
        list-style: none;
        width: fit-content;
        padding: 0;
        margin: 0;
    }

    .size-list li {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f5f6fa;
        padding: 8px 12px;
        border-radius: 8px;
        margin-bottom: 8px;
    }

    .size-badge {
        background: #6c63ff;
        color: #fff;
        padding: 5px 10px;
        border-radius: 6px;
        font-weight: bold;
    }

    .size-qty {
        color: #333;
        margin-left: 10px;
        flex-grow: 1;
    }

    .delete-btn {
        background: #ff4d4f;
        color: white;
        padding: 6px 10px;
        border-radius: 6px;
        text-decoration: none;
    }
</style>
<style>
    .size-row1 {
        display: flex;
   
        align-items: center;
        justify-content: space-evenly;
        margin: 10px;
        
        gap: 8px;
        background: #f5f6fa;
        padding: 8px 10px;
        border-radius: 8px;
        margin-bottom: 8px;
        width: fit-content;
    }

    /* Size Badge */
    .badge-size {
        background: #6c63ff;
        color: white;
        padding: 5px 10px;
        border-radius: 6px;
        font-weight: 600;
    }

    /* Old stock */
    .old-stock {
        color: #555;
        font-size: 14px;
    }

    /* Input */
    .input-stock {
        width: 50px;
        height: 30px;
        text-align: center;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    /* Buttons */
    .btn-minus,
    .btn-plus {
        width: 28px;
        height: 28px;
        border: none;
        border-radius: 6px;
        color: white;
        font-weight: bold;
        cursor: pointer;
    }

    .btn-minus {
        background: #ff4d4f;
    }

    .btn-plus {
        background: #6c63ff;
    }

    /* Update button */
    .btn-update {
        margin-top: 8px;
        background: linear-gradient(45deg, #6c63ff, #4e73df);
        color: white;
        padding: 6px 14px;
        border: none;
        border-radius: 8px;
    }
</style>

@endsection

@section('main-content')
<div class="content-wrapper">

    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="page-title">Product Management</h2>
            <p class="page-subtitle">Manage all Product Sizes here</p>
        </div>

        <div>
            <a href="{{ url('admin/add-product_size') }}" class="btn add-btn">
                <i class="mdi mdi-plus"></i>
                <span>Add Product-Size</span>
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
                <span class="text-dark fw-semibold">Product Sizes</span>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-gradient-primary text-white rounded-top-4 
            d-flex justify-content-between align-items-center">

            <h5 class="mb-0">Product Size List</h5>

            <form method="GET" action="{{ url('admin/product') }}"
                class="d-flex align-items-center gap-3 filter-form">

                <!-- Status Dropdown -->


                <!-- category Dropdown -->


                <!-- Search Input -->


            </form>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table custom-table align-middle">
                    <thead>
                        <tr>

                            <th>Product name</th>
                            <th>Product Image</th>
                            <th>Size(Stock)</th>

                            <th>Action</th>


                        </tr>
                    </thead>

                    <tbody>
                        @if($groupproduct->count() == 0)
                        <tr>
                            <td colspan="7" class="text-center text-danger">
                                No matching product found
                            </td>
                        </tr>
                        @endif


                        @foreach($groupproduct as $p)
                        @php
                        $sizes = \App\Models\ProductSize::where('proid', $p->proid)->get();
                        @endphp
                        <tr>
                            <td>{{ $sizes->first()->product->proname }}</td>
                            <td>
                                <img src="{{ asset('admin/assets/images/'.$sizes->first()->product->proimage) }}"
                                    id="product-img"
                                    alt="">


                            </td>

                            <td>
                                <form action="{{ url('admin/update-product-stock') }}" method="POST">
                                    @csrf

                                    @foreach($sizes as $s)
                                    <div class="size-row" style="display: flex;">
                                        <div class="size-row1">
                                        <span class="badge-size">{{ $s->size }}</span>

                                        <span class="old-stock">({{ $s->stock }})</span>
                                        </div>
                                        <div class="size-row1">
                                        <button type="button" class="btn-minus">-</button>

                                        <input type="number" name="stock[]" value="0" class="input-stock">

                                        <button type="button" class="btn-plus">+</button>

                                        <input type="hidden" name="proid[]" value="{{ $s->proid }}">
                                        <input type="hidden" name="size[]" value="{{ $s->size }}">
                                        </div>
                                    </div>
                                    
                                    @endforeach

                                    <button class="btn-update">Update Stock</button>
                                </form>
                                
                            </td>

                            <td>
                                <ul class="size-list">
                                    @foreach($sizes as $s)
                                    <li>


                                        <a href="{{ url('admin/delete_product-size', $s->prosize_id) }}"
                                            class="delete-btn"
                                            onclick="return confirm('Delete this size?')">
                                            <i class="mdi mdi-delete-outline"></i>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </td>



                        </tr>

                        @endforeach

                    </tbody>

                </table>
            </div>


            {{ $groupproduct->onEachSide(2)->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>


@endsection


@section('js')
<script>
document.querySelectorAll('.btn-plus').forEach(btn => {
    btn.onclick = function() {
        let input = this.previousElementSibling;
        input.value = parseInt(input.value || 0) + 1;
    }
});

document.querySelectorAll('.btn-minus').forEach(btn => {
    btn.onclick = function() {
        let input = this.nextElementSibling;
        if (input.value > 0) input.value--;
    }
});
</script>
@endsection