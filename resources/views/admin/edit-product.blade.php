@extends('admin.layouts')

@section('user-css')
<style>
    .page-header h2 {
        font-weight: 600;
        color: #2c3e50;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: none;
    }

    label {
        font-weight: 500;
        margin-bottom: 6px;
    }

    .form-control {
        border-radius: 10px;
        padding: 10px;
        border: 1px solid #ddd;
    }

    .form-control:focus {
        border-color: #5b5be6;
        box-shadow: 0 0 5px rgba(91, 91, 230, 0.3);
    }

    .section-title {
        font-weight: 600;
        margin-bottom: 10px;
        color: #5b5be6;
    }

    .size-box {
        background: #f8f9ff;
        border-radius: 10px;
        padding: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stock-input {
        width: 70px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #5b5be6, #7a7aff);
        border: none;
        border-radius: 10px;
        padding: 10px 25px;
    }

    .old-img {
        border-radius: 10px;
        margin: 5px;
    }
</style>
@endsection


@section('main-content')
<div class="content-wrapper">

    <div class="page-header mb-4">
        <h2>Edit Product</h2>
    </div>

    <div class="card p-4">

        <!-- GLOBAL ERROR -->
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ url('admin/updateproduct',$pro->proid) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">

                <!-- NAME -->
                <div class="col-md-6 mb-3">
                    <label>Product Name</label>
                    <input type="text" name="proname"
                        value="{{ old('proname',$pro->proname) }}"
                        class="form-control">
                    @error('proname')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- DESCRIPTION -->
                <div class="col-md-6 mb-3">
                    <label>Description</label>
                    <textarea name="description"
                        class="form-control">{{ old('description',$pro->description) }}</textarea>
                    @error('description')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- PRICE -->
                <div class="col-md-6 mb-3">
                    <label>Price</label>
                    <input type="number" name="price"
                        value="{{ old('price',$pro->price) }}"
                        class="form-control">
                    @error('price')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- DISCOUNT -->
                <div class="col-md-6 mb-3">
                    <label>Discount Price</label>
                    <input type="number" name="discount_price"
                        value="{{ old('discount_price',$pro->discount_price) }}"
                        class="form-control">
                    @error('discount_price')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- CATEGORY -->
                <div class="col-md-6 mb-3">
                    <label>Category</label>
                    <select name="catid" class="form-control">
                        @foreach($data as $d)
                        <option value="{{ $d->id }}"
                            {{ $d->id == old('catid',$pro->catid) ? 'selected' : '' }}>
                            {{ $d->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('catid')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- MAIN IMAGE -->
                <div class="col-md-6 mb-3">
                    <label>Change Main Image</label>
                    <input type="file" name="proimage" class="form-control">
                    @error('proimage')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror

                    <br>
                    <img src="{{ asset('admin/assets/images/'.$pro->proimage) }}"
                        width="100" class="old-img">
                </div>

                <!-- EXTRA IMAGES -->
                <div class="col-md-12 mb-3">
                    <div class="section-title">Product Images</div>

                    @foreach($pro->images as $img)
                    <div style="display:inline-block; position:relative; margin:5px;">

                        <!-- IMAGE -->
                        <img src="{{ asset('admin/assets/images/'.$img->image) }}"
                            width="90" class="old-img">

                        <!-- DELETE BUTTON -->
                        <a href="{{ url('admin/delete-product-image',$img->proimg_id) }}"
                            onclick="return confirm('Delete this image?')"
                            style="
                position:absolute;
                top:0;
                right:0;
                background:red;
                color:white;
                border-radius:50%;
                width:22px;
                height:22px;
                text-align:center;
                line-height:20px;
                text-decoration:none;
                font-weight:bold;
           ">
                            ×
                        </a>

                    </div>
                    @endforeach

                    <!-- ADD NEW -->
                    <input type="file" name="images[]" class="form-control mt-2" multiple>
                </div>
                <!-- SIZE -->
                <div class="col-md-12 mb-3">
                    <div class="section-title">Product Sizes & Stock</div>

                    @php
                    $sizes = ['S','M','L','XL','XXL','28','30','32','34','36'];

                    // existing sizes map
                    $existingSizes = [];
                    foreach($pro->size as $ps){
                    $existingSizes[$ps->size] = $ps->stock;
                    }
                    @endphp

                    <div class="row">

                        @foreach($sizes as $s)
                        <div class="col-md-3 mb-2">
                            <div class="size-box d-flex align-items-center">

                                <!-- CHECKBOX -->
                                <input type="checkbox"
                                    name="size[]"
                                    value="{{ $s }}"
                                    class="me-2 size-check"
                                    {{ isset($existingSizes[$s]) ? 'checked' : '' }}>

                                <span>{{ $s }}</span>

                                <!-- STOCK -->
                                <input type="number"
                                    name="stock[{{ $s }}]"
                                    value="{{ old('stock.'.$s) }}"
                                    class="form-control stock-input"
                                    placeholder="Qty"
                                    {{ isset($existingSizes[$s]) ? '' : 'disabled' }}>

                                <!-- CURRENT -->
                                @if(isset($existingSizes[$s]))
                                <small style="margin-left:5px;">
                                    ({{ $existingSizes[$s] }})
                                </small>
                                @endif

                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>

            <button class="btn btn-primary mt-3">Update Product</button>

        </form>

    </div>
</div>
@endsection


@section('js')
<script>
document.querySelectorAll('.size-check').forEach(function(cb){
    cb.addEventListener('change', function(){
        let input = this.closest('.size-box').querySelector('.stock-input');

        input.disabled = !this.checked;

        if(!this.checked){
            input.value = '';
        }
    });
});
</script>
@endsection