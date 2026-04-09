@extends('user.layout')

@section('content')

<style>
    /* ── GALLERY ── */
    .product-gallery-wrapper {
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    /* THUMBNAIL COLUMN */
    .thumb-col {
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 90px;
        flex-shrink: 0;
    }

    .thumb-item {
        width: 90px;
        height: 100px;
        border: 2px solid #e0e0e0;
        border-radius: 6px;
        overflow: hidden;
        cursor: pointer;
        transition: border-color .2s;
    }

    .thumb-item.active,
    .thumb-item:hover {
        border-color: #c96;
    }

    .thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* MAIN IMAGE */
    .main-img-col {
        flex: 1;
    }

    .main-img-col figure {
        margin: 0;
        border-radius: 8px;
        overflow: hidden;
        background: #f5f5f5;
    }

    #main-product-img {
        width: 100%;
        height: 500px;
        object-fit: contain;
        display: block;
        transition: opacity .2s;
    }

    /* ── STAR RATING (clickable) ── */
    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 2px;
        margin-bottom: 10px;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        font-size: 34px;
        color: #ccc;
        cursor: pointer;
        line-height: 1;
        transition: color .15s;
    }

    .star-rating label:hover,
    .star-rating label:hover~label,
    .star-rating input:checked~label {
        color: #f7a800;
    }

    /* ── REVIEW DISPLAY STARS ── */
    .review-stars {
        font-size: 16px;
    }

    .review-stars .filled {
        color: #f7a800;
    }

    .review-stars .empty {
        color: #ddd;
    }

    /* ── REVIEW CARD ── */
    .review {
        border-bottom: 1px solid #f0f0f0;
        padding: 16px 0;
    }

    .review:last-child {
        border-bottom: none;
    }

    /* ── PRICE ── */
    .new-price {
        color: #c96;
        font-size: 24px;
        font-weight: 700;
        margin-right: 8px;
    }

    .old-price {
        color: #aaa;
        font-size: 18px;
        text-decoration: line-through;
    }

    .discount-badge {
        display: inline-block;
        background: #e8f5e9;
        color: #2e7d32;
        font-size: 13px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 4px;
        margin-left: 8px;
        vertical-align: middle;
    }
</style>

<main class="main">

    {{-- PAGE HEADER --}}
    <div class="page-header text-center">
        <div class="container" style="padding-top:80px;">
            <h1 class="page-title">{{ $product->proname }}</h1>
        </div>
    </div>

    {{-- BREADCRUMB --}}
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('user/product') }}">Products</a></li>
                <li class="breadcrumb-item active">{{ $product->proname }}</li>
            </ol>
        </div>
    </nav>

    <div class="page-content">
        <div class="container">

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow"
                style="border-left:4px solid #dc3545; border-radius:6px;">
                <i class="icon-close mr-2" style="color:#dc3545;"></i>
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
            @endif
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow"
                style="border-left:4px solid #28a745; border-radius:6px;">
                <i class="icon-check mr-2" style="color:#28a745;"></i>
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
            @endif

            <div class="product-details-top mb-5">
                <div class="row">

                    {{-- ── LEFT: GALLERY ── --}}
                    <div class="col-md-6 mb-4">
                        <div class="product-gallery-wrapper">

                            {{-- THUMBNAILS --}}
                            <div class="thumb-col">

                                <div class="thumb-item active"
                                    data-image="{{ asset('admin/assets/images/' . $product->proimage) }}">
                                    <img src="{{ asset('admin/assets/images/' . $product->proimage) }}"
                                        alt="main">
                                </div>

                                @foreach($product->images->sortBy('sort_order') as $img)
                                <div class="thumb-item"
                                    data-image="{{ asset('admin/assets/images/' . $img->image) }}">
                                    <img src="{{ asset('admin/assets/images/' . $img->image) }}"
                                        alt="thumb {{ $loop->iteration }}">
                                </div>
                                @endforeach

                            </div>

                            {{-- MAIN IMAGE --}}
                            <div class="main-img-col">
                                <figure>
                                    <img id="main-product-img"
                                        src="{{ asset('admin/assets/images/' . $product->proimage) }}"
                                        alt="{{ $product->proname }}">
                                </figure>
                            </div>

                        </div>
                    </div>

                    {{-- ── RIGHT: PRODUCT INFO ── --}}
                    <div class="col-md-6">
                        <div class="product-details">

                            <h1 class="product-title">{{ $product->proname }}</h1>

                            {{-- AVERAGE RATING STARS --}}
                            <div class="ratings-container mb-2">
                                <div class="ratings">
                                    <div class="ratings-val"
                                        style="width:{{ ($avgRating/5)*100 }}%;"></div>
                                </div>
                                <a class="ratings-text" href="#"
                                    onclick="
                                       document.getElementById('product-review-link').click();
                                       return false;">
                                    ( {{ $reviews->count() }} Reviews )
                                </a>
                            </div>

                            {{-- PRICE --}}
                            {{-- PRICE --}}
                            <div class="product-price mb-3">
                                @if($product->discount_price && $product->discount_price > 0)
                                @php
                                $finalPrice = $product->price - $product->discount_price;
                                $discountPct = number_format(($product->discount_price / $product->price) * 100,2);
                                @endphp
                                <span class="new-price">₹{{ number_format($finalPrice, 2) }}</span>
                                <span class="old-price">₹{{ number_format($product->price, 2) }}</span>
                                <span class="discount-badge">-{{ $discountPct }}% OFF</span>
                                @else
                                <span style="color:#c96;font-size:24px;font-weight:700;">
                                    ₹{{ number_format($product->price, 2) }}
                                </span>
                                @endif
                            </div>

                            {{-- DESCRIPTION (renders HTML tags) --}}
                            <div class="product-content mb-3">
                                {!! $product->description !!}
                            </div>

                            {{-- ADD TO CART FORM --}}
                            @if($product->size->count())
                            <form action="{{ url('user/cart/add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="proid" value="{{ $product->proid }}">

                                <div class="details-filter-row details-row-size mb-3">
                                    <label for="size">Size:</label>
                                    <div class="select-custom">
                                        <select name="size" id="size"
                                            class="form-control" required>
                                            <option value="" disabled selected>Select a size</option>
                                            @foreach($product->size as $s)
                                            <option value="{{ $s->size }}"
                                                {{ $s->stock == 0 ? 'disabled' : '' }}>
                                                {{ strtoupper($s->size) }}
                                                {{ $s->stock == 0 ? '(Out of Stock)' : '' }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="details-filter-row details-row-size mb-3">
                                    <label for="qty">Qty:</label>
                                    <div class="product-details-quantity">
                                        <input type="number" name="qty" id="qty"
                                            class="form-control"
                                            value="1"required>
                                        
                                    </div>
                                    @error('qty')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                </div>

                                <div class="product-details-action">
                                    @auth
                                    <button type="submit" class="btn-product btn-cart">
                                        <span>add to cart</span>
                                    </button>
                                    @else
                                    <a href="{{ url('login') }}"
                                        class="btn-product btn-cart">
                                        <span>Login</span>
                                    </a>
                                    @endauth
                                </div>
                            </form>
                            @else
                            <div class="alert alert-warning mt-3">
                                Currently <strong>Out of Stock</strong>.
                            </div>
                            @endif

                            {{-- CATEGORY --}}
                            <div class="product-details-footer mt-3">
                                <div class="product-cat">
                                    <span>Category:</span>
                                    <a href="#">{{ $product->category->name ?? 'N/A' }}</a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            {{-- END PRODUCT TOP --}}


            {{-- ── TABS ── --}}
            <div class="product-details-tab">
                <ul class="nav nav-pills justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="product-desc-link"
                            data-toggle="tab" href="#product-desc-tab" role="tab">
                            Description
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-review-link"
                            data-toggle="tab" href="#product-review-tab" role="tab">
                            Reviews ({{ $reviews->count() }})
                        </a>
                    </li>
                </ul>

                <div class="tab-content">

                    {{-- DESCRIPTION TAB --}}
                    <div class="tab-pane fade show active"
                        id="product-desc-tab" role="tabpanel">
                        <div class="product-desc-content">
                            <h3>Product Information</h3>
                            {!! $product->description !!}
                        </div>
                    </div>

                    {{-- REVIEWS TAB --}}
                    <div class="tab-pane fade"
                        id="product-review-tab" role="tabpanel">
                        <div class="reviews p-3">
                            <h3 class="mb-4">Reviews ({{ $reviews->count() }})</h3>

                            {{-- LIST REVIEWS --}}
                            @forelse($reviews as $review)
                            <div class="review">
                                <div class="row no-gutters">
                                    <div class="col-auto pr-4">
                                        <h5 class="mb-1">
                                            {{ $review->user->name ?? 'Anonymous' }}
                                        </h5>
                                        {{-- STAR DISPLAY --}}
                                        <div class="review-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="{{ $i <= $review->rating ? 'filled' : 'empty' }}">
                                                &#9733;
                                                </span>
                                                @endfor
                                        </div>
                                        <small class="text-muted">
                                            {{ $review->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    <div class="col">
                                        <p class="mb-0 mt-1">
                                            {{ $review->review ?? '' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-muted">No reviews yet. Be the first!</p>
                            @endforelse

                            <hr class="mt-4">

                            {{-- WRITE REVIEW --}}
                            <div class="add-review mt-4">
                                <h4 class="mb-3">Write a Review</h4>

                                @auth
                                @if($userReviewed)
                                <div class="alert alert-info">
                                    You have already reviewed this product.
                                </div>
                                @else
                                <form action="{{ route('user.review', $product->proid) }}"
                                    method="POST">
                                    @csrf

                                    {{-- CLICKABLE STARS --}}
                                    <div class="form-group">
                                        <label class="d-block mb-1">
                                            Your Rating
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="star-rating">
                                            <input type="radio" id="star5" name="rating" value="5"
                                                {{ old('rating')==5 ? 'checked':'' }} required>
                                            <label for="star5" title="5 stars">&#9733;</label>

                                            <input type="radio" id="star4" name="rating" value="4"
                                                {{ old('rating')==4 ? 'checked':'' }}>
                                            <label for="star4" title="4 stars">&#9733;</label>

                                            <input type="radio" id="star3" name="rating" value="3"
                                                {{ old('rating')==3 ? 'checked':'' }}>
                                            <label for="star3" title="3 stars">&#9733;</label>

                                            <input type="radio" id="star2" name="rating" value="2"
                                                {{ old('rating')==2 ? 'checked':'' }}>
                                            <label for="star2" title="2 stars">&#9733;</label>

                                            <input type="radio" id="star1" name="rating" value="1"
                                                {{ old('rating')==1 ? 'checked':'' }}>
                                            <label for="star1" title="1 star">&#9733;</label>
                                        </div>
                                        @error('rating')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    {{-- REVIEW TEXT --}}
                                    <div class="form-group mt-3">
                                        <label>Your Review
                                            <span class="text-muted">(optional)</span>
                                        </label>
                                        <textarea name="review"
                                            class="form-control"
                                            rows="4"
                                            placeholder="Share your experience...">{{ old('review') }}</textarea>
                                        @error('review')
                                        <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <button type="submit"
                                        class="btn btn-primary mt-2 px-4">
                                        Submit Review
                                    </button>
                                </form>
                                @endif
                                @else
                                <p>
                                    <a href="{{ url('login') }}">Login</a>
                                    to write a review.
                                </p>
                                @endauth
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            {{-- END TABS --}}


            {{-- ── RELATED PRODUCTS ── --}}
            @if($related->count())
            <h2 class="title text-center mb-4 mt-5">You May Also Like</h2>

            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow"
                data-toggle="owl"
                data-owl-options='{
                         "nav":false,"dots":true,"margin":20,"loop":false,
                         "responsive":{
                             "0":{"items":1},
                             "480":{"items":2},
                             "768":{"items":3},
                             "992":{"items":4},
                             "1200":{"items":4,"nav":true,"dots":false}
                         }
                     }'>

                @foreach($related as $rel)
                <div class="product product-7 text-center">
                    <figure class="product-media">

                        {{-- DISCOUNT BADGE --}}
                        @if($rel->discount_price > 0)
                        @php
                        $pct = number_format(($rel->discount_price/ $rel->price) * 100,2);
                        @endphp
                        <span class="product-label label-sale">-{{ $pct }}%</span>
                        @endif

                        <a href="{{ route('user.single', $rel->proid) }}">
                            <img src="{{ asset('admin/assets/images/' . $rel->proimage) }}"
                                alt="{{ $rel->proname }}"
                                class="product-image"
                                style="height:280px;object-fit:cover;">
                        </a>
                        <div class="product-action">
                            <a href="{{ route('user.single', $rel->proid) }}"
                                class="btn-product btn-cart">
                                <span>view product</span>
                            </a>
                        </div>
                    </figure>

                    <div class="product-body">
                        <div class="product-cat">
                            <a href="#">{{ $rel->category->name ?? '' }}</a>
                        </div>
                        <h3 class="product-title">
                            <a href="{{ route('user.single', $rel->proid) }}">
                                {{ $rel->proname }}
                            </a>
                        </h3>
                        <div class="product-price">
                            @if($rel->discount_price > 0)
                            @php
                            $finalPrice = $rel->price - $rel->discount_price;
                            $pct = round(($rel->discount_price / $rel->price) * 100);
                            @endphp
                            {{-- in product-body --}}
                            <span class="new-price">₹{{ number_format($finalPrice, 2) }}</span>
                            <span class="old-price">₹{{ number_format($rel->price, 2) }}</span>
                            @else
                            <span class="new-price" style="color:gray ;font-size: large; font-weight: normal;">₹{{ number_format($rel->price, 2) }}</span>

                            @endif
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            @endif

        </div>
    </div>
</main>

{{-- THUMBNAIL SWITCHER - plain JS, no AJAX --}}
<script>
    document.querySelectorAll('.thumb-item').forEach(function(thumb) {
        thumb.addEventListener('click', function() {
            // update main image
            document.getElementById('main-product-img').src =
                this.getAttribute('data-image');

            // update active border
            document.querySelectorAll('.thumb-item').forEach(function(el) {
                el.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
</script>

<script>
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(el) {
            el.classList.remove('show');
            el.classList.add('fade');
            setTimeout(function() {
                el.remove();
            }, 300);
        });
    }, 4000);
</script>

@endsection