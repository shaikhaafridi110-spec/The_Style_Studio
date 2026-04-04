@extends('user.layout')

@section('content')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<style>
    .fixed-img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .product-media {
        overflow: hidden;
    }

    .product-media img {
        transition: 0.3s;
    }

    .product-media:hover img {
        transform: scale(1.1);
    }

    .no-product-box {
        min-height: 400px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .no-product-box {
        width: 100%;
        text-align: center;
        padding: 80px 20px;
    }

    .no-product-box h2 {
        font-size: 36px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .no-product-box p {
        font-size: 16px;
        color: #777;
    }

    .no-product-box .emoji {
        font-size: 40px;
    }

    .custom-control-input {
        cursor: pointer;
        z-index: 10;
        position: relative;
    }

    .custom-control-input {
        position: relative !important;
        z-index: 2;
        cursor: pointer;
    }

    .custom-control-label {
        cursor: pointer;
    }

    .btn-wishlist.active {
        color: red;
    }

    .product-action-vertical {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
    }

    .btn-wishlist {
        z-index: 20;
        cursor: pointer;
    }

    .product-media {
        position: relative;
    }

    .product-media img {
        pointer-events: none;
    }
    .product-media {
    position: relative;
}

.product-media img {
    pointer-events: none; /* 🔥 VERY IMPORTANT */
}

.product-action-vertical {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 100;
}

.btn-wishlist {
    z-index: 200;
    cursor: pointer;
}
.btn-wishlist {
    width: 40px;
    height: 40px;
    border: 2px solid #000;
    border-radius: 50%;
    background: #fff;

    display: flex;
    align-items: center;
    justify-content: center;

    cursor: pointer;
    transition: all 0.3s ease;

    padding: 0; /* 🔥 important */
}

/* default heart */
.btn-wishlist::before {
    content: "♡";
    font-size: 18px;
    color: #000;
}

/* hover */
.btn-wishlist:hover {
    border-color: red;
}

.btn-wishlist:hover::before {
    color: red;
}

/* active (wishlist) */
.btn-wishlist.active {
    border-color: red;
}

.btn-wishlist.active::before {
    content: "❤";
    color: red;
}
</style>
<main class="main">
    <div class="page-header text-center">
        <div class="container" style="padding-top: 80px;">
            <h1 class="page-title">Shop Now<span></span></h1>
        </div><!-- End .container -->
    </div><!-- End .page-header -->
    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container">

        </div><!-- End .container -->
    </nav><!-- End .breadcrumb-nav -->
    <form method="GET" id="filterForm">
        @if(request('search'))
        <input type="hidden" name="search" value="{{ request('search') }}">
        @endif
        <div class="page-content">
            <div class="container">

                <div class="row">
                    <div class="col-lg-9">
                        <div class="toolbox">
                            <div class="toolbox-left">
                                <div class="toolbox-info">
                                    @if($product->count())
                                    Showing
                                    {{ $product->firstItem() }} to {{ $product->lastItem() }}
                                    of {{ $product->total() }} Products
                                    @else
                                    No products found
                                    @endif
                                </div><!-- End .toolbox-info -->
                            </div><!-- End .toolbox-left -->



                            <div class="toolbox-right">
                                <div class="toolbox-sort">
                                    <label for="sortby">Sort by:</label>

                                    <div class="select-custom">
                                        <select name="sortby"
                                            id="sortby"
                                            class="form-control"
                                            onchange="this.form.submit()">

                                            <option value="">Select Option</option>

                                            <option value="popularity"
                                                {{ request('sortby')=='popularity' ? 'selected' : '' }}>
                                                Most Popular
                                            </option>

                                            <option value="rating"
                                                {{ request('sortby')=='rating' ? 'selected' : '' }}>
                                                Most Rated
                                            </option>

                                            <option value="date"
                                                {{ request('sortby')=='date' ? 'selected' : '' }}>
                                                Date
                                            </option>

                                        </select>
                                    </div>

                                </div>
                            </div>

                        </div><!-- End .toolbox -->

                        <div class="products mb-3">
                            <div class="row justify-content-center">
                                @if($product->count())
                                @foreach($product as $pro)

                                <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                                    <div class="product product-7 text-center">

                                        <figure class="product-media">


                                            <img src="{{ asset('admin/assets/images/'.$pro->proimage) }}"
                                                alt="{{ $pro->proname }}"
                                                class="product-image fixed-img">

                                            <div class="product-action-vertical">
                                                <button type="button"
    class="btn-wishlist add-to-wishlist {{ in_array($pro->proid, $wishlistIds ?? []) ? 'active' : '' }}"
    data-id="{{ $pro->proid }}">
</button>
                                            </div>

                                            <div class="product-action">
                                                <a href="#"
                                                    class="btn-product btn-cart">
                                                    <span>add to cart</span>
                                                </a>
                                            </div>

                                        </figure>

                                        <div class="product-body">

                                            <!-- ✅ CATEGORY FIX -->
                                            <div class="product-cat">
                                                <a href="{{url('user/shop',$pro->category->slug)}}">{{ $pro->category->name ?? 'Category' }}</a>
                                            </div>

                                            <!-- ✅ TITLE FIX -->
                                            <h3 class="product-title">
                                                <a href="{{ url('user/single-shop/'.$pro->id) }}">
                                                    {{ $pro->proname }}
                                                </a>
                                            </h3>

                                            <!-- ✅ PRICE FIX -->
                                            <div class="product-price">
                                                ₹{{ $pro->price }}
                                            </div>

                                            <!-- OPTIONAL RATING -->
                                            <div class="ratings-container">
                                                <div class="ratings">
                                                    <div class="ratings-val" style="width: {{ ($pro->reviews_avg_rating ?? 0) * 20 }}%;"></div>
                                                </div>
                                                <span class="ratings-text">({{$pro->reviews_count}})</span>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                @endforeach
                                @else
                                <div class="col-12">
                                    <div class="no-product-box">
                                        <h2>No Products Found <span class="emoji">😢</span></h2>
                                        <p>Try different category or search</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div><!-- End .products -->


                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                {{ $product->onEachSide(2)->links() }}
                            </ul>
                        </nav>
                    </div><!-- End .col-lg-9 -->
                    <aside class="col-lg-3 order-lg-first">

                        <div class="sidebar sidebar-shop">
                            <div class="widget widget-clean">
                                <label>Filters:</label>
                                <a href="{{ url('user/shop') }}">Clean All</a>
                            </div><!-- End .widget widget-clean -->

                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                                        Category
                                    </a>
                                </h3><!-- End .widget-title -->

                                <div class="collapse show" id="widget-1">
                                    <div class="widget-body">
                                        <div class="filter-items filter-items-count">



                                            @foreach($cat as $c)
                                            <div class="filter-item">

                                                <input type="checkbox"

                                                    name="category[]"
                                                    value="{{ $c->slug }}"
                                                    {{ in_array($c->slug, request('category',[])) ? 'checked' : '' }}
                                                    onchange="this.form.submit()" id="cat-{{ $c->id }}">

                                                <label for="cat-{{ $c->id }}">
                                                    {{ $c->name }}
                                                </label>

                                                <span>{{ $c->product_count }}</span>

                                            </div>
                                            @endforeach


                                            <!-- End .filter-item -->
                                        </div><!-- End .filter-items -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-2" role="button" aria-expanded="true" aria-controls="widget-2">
                                        Size
                                    </a>
                                </h3><!-- End .widget-title -->

                                <div class="collapse show" id="widget-2">
                                    <div class="widget-body">
                                        <div class="filter-items">
                                            @php
                                            $sizes = ['S','M','L','XL','XXL','28','30','32','34','36'];
                                            @endphp

                                            @foreach($sizes as $index => $s)
                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                        onchange="this.form.submit()"
                                                        {{ in_array($s, request('size',[])) ? 'checked' : '' }}
                                                        id="size-{{ $index }}"
                                                        name="size[]"
                                                        value="{{ $s }}">

                                                    <label for="size-{{ $index }}">{{ $s }}</label>
                                                </div>
                                            </div>
                                            @endforeach


                                        </div><!-- End .filter-items -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->





                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true" aria-controls="widget-5">
                                        Price
                                    </a>
                                </h3><!-- End .widget-title -->

                                <div class="collapse show" id="widget-5">
                                    <div class="widget-body">
                                        <div class="filter-price">
                                            <div class="filter-price-text">
                                                Price Range:
                                                <span id="filter-price-range"></span>
                                            </div><!-- End .filter-price-text -->
                                            <input type="hidden" name="min_price" id="min_price" value="{{ request('min_price') }}">
                                            <input type="hidden" name="max_price" id="max_price" value="{{ request('max_price') }}">
                                            <div id="price-slider"></div><!-- End #price-slider -->
                                        </div><!-- End .filter-price -->
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->
                        </div>
                        <!-- End .sidebar sidebar-shop -->
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div>
    </form><!-- End .page-content -->
</main><!-- End .main -->



@endsection


@push('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
    $(function() {

        let min = parseInt(@json(request('min_price') ?? $minPrice));
        let max = parseInt(@json(request('max_price') ?? $maxPrice));

        let dbMin = {
            {
                $minPrice
            }
        };
        let dbMax = {
            {
                $maxPrice
            }
        };

        $("#price-slider").slider({
            range: true,
            min: dbMin,
            max: dbMax,
            values: [min, max],

            create: function() {
                $("#filter-price-range").text("₹" + min + " - ₹" + max);
            },

            slide: function(event, ui) {
                $("#filter-price-range").text("₹" + ui.values[0] + " - ₹" + ui.values[1]);
            },

            change: function(event, ui) {
                $("#min_price").val(ui.values[0]);
                $("#max_price").val(ui.values[1]);
                document.getElementById('filterForm').submit();
            }
        });

    });
</script>
<script>

   
  $(document).on('click', '.add-to-wishlist', function (e) {
    e.preventDefault();

    let product_id = $(this).attr('data-id');
    let btn = $(this); // ✅ current clicked button ONLY

    $.ajax({
        url: "{{ route('wishlist.toggle') }}",
        type: "POST",
        data: {
            product_id: product_id,
            _token: "{{ csrf_token() }}"
        },

        success: function (res) {

            if (res.status == 'added') {
                btn.addClass('active'); // ✅ only this button
            }

            else if (res.status == 'removed') {
                btn.removeClass('active'); // ✅ only this button
            }
        }
    });
});
</script>
@endpush