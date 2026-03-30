@extends('admin.layouts')

@section('user-css')
<style>
.page-header h2 { font-weight: 600; color: #2c3e50; }
.card { border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: none; }
label { font-weight: 500; margin-bottom: 6px; color: #444; }

.form-control {
    border-radius: 10px;
    padding: 10px;
    border: 1px solid #ddd;
}

.form-control:focus {
    border-color: #5b5be6;
    box-shadow: 0 0 5px rgba(91,91,230,0.3);
}

.section-title { font-weight: 600; margin-bottom: 10px; color: #5b5be6; }

.size-box {
    background: #f8f9ff;
    border-radius: 10px;
    padding: 8px 10px;
}

.stock-input { width: 70px; margin-left: auto; }

.btn-primary {
    background: linear-gradient(135deg, #5b5be6, #7a7aff);
    border: none;
    border-radius: 10px;
    padding: 10px 25px;
}

.text-danger { font-size: 13px; }
</style>
@endsection


@section('main-content')
<div class="content-wrapper">

    <div class="page-header mb-4">
        <h2>Add Product</h2>
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

        <form action="{{ url('admin/saveproduct') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">

                <!-- NAME -->
                <div class="col-md-6 mb-3">
                    <label>Product Name</label>
                    <input type="text" name="proname" value="{{ old('proname') }}" class="form-control">
                    @error('proname')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- DESCRIPTION -->
                <div class="col-md-6 mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- PRICE -->
                <div class="col-md-6 mb-3">
                    <label>Price</label>
                    <input type="number" name="price" value="{{ old('price') }}" class="form-control">
                    @error('price')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- DISCOUNT -->
                <div class="col-md-6 mb-3">
                    <label>Discount Price</label>
                    <input type="number" name="discount_price" value="{{ old('discount_price') }}" class="form-control">
                    @error('discount_price')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- CATEGORY -->
                <div class="col-md-6 mb-3">
                    <label>Category</label>
                    <select name="catid" class="form-control">
                        <option value="">Select Category</option>
                        @foreach($data as $d)
                        <option value="{{ $d->id }}" {{ old('catid') == $d->id ? 'selected' : '' }}>
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
                    <label>Main Image</label>
                    <input type="file" name="proimage" class="form-control" onchange="previewImg(event)">
                    @error('proimage')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                    <img id="preview" width="80" class="mt-2">
                </div>

                <!-- EXTRA IMAGES -->
                <div class="col-md-12 mb-3">
                    <div class="section-title">Extra Product Images</div>
                    <input type="file" name="images[]" class="form-control" multiple>
                    @error('images.*')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- SIZE -->
                <div class="col-md-12 mb-3">
                    <div class="section-title">Product Sizes & Stock</div>

                    <div class="row">
                        @php
                        $sizes = ['S','M','L','XL','XXL','28','30','32','34','36'];
                        @endphp

                        @foreach($sizes as $s)
                        <div class="col-md-3 mb-2">
                            <div class="size-box d-flex align-items-center">

                                <input type="checkbox"
                                       name="size[]"
                                       value="{{ $s }}"
                                       class="me-2 size-check"
                                       {{ in_array($s, old('size', [])) ? 'checked' : '' }}>

                                <span>{{ $s }}</span>

                                <input type="number"
                                       name="stock[{{ $s }}]"
                                       value="{{ old('stock.'.$s) }}"
                                       class="form-control stock-input"
                                       placeholder="Qty"
                                       {{ in_array($s, old('size', [])) ? '' : 'disabled' }}>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <button class="btn btn-primary mt-3">
                Save Product
            </button>

        </form>

    </div>
</div>
@endsection


@section('js')
<script>

// checkbox enable stock
document.querySelectorAll('.size-check').forEach(function(cb){
    cb.addEventListener('change', function(){
        let input = this.closest('.size-box').querySelector('.stock-input');
        input.disabled = !this.checked;
        if(!this.checked) input.value = '';
    });
});

// preview image
function previewImg(event){
    let img = document.getElementById('preview');
    img.src = URL.createObjectURL(event.target.files[0]);
}

</script>
@endsection