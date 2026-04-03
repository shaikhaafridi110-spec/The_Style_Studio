@extends('user.layout')

@section('content')
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
                        <form method="GET">
                            

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
                        </form>
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
                                            <a href="#" class="btn-product-icon btn-wishlist btn-expandable">
                                                <span>add to wishlist</span>
                                            </a>
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
                                        <form method="GET" id="filterForm">
                                            

                                            @foreach($cat as $c)
                                            <div class="filter-item">

                                                <input type="checkbox"
                                                    id="cat-{{ $c->id }}"
                                                    name="category[]"
                                                    value="{{ $c->slug }}"
                                                    {{ in_array($c->slug, request('category', [])) ? 'checked' : '' }}
                                                    onchange="this.form.submit()">

                                                <label for="cat-{{ $c->id }}">
                                                    {{ $c->name }}
                                                </label>

                                                <span>{{ $c->product_count }}</span>

                                            </div>
                                            @endforeach

                                        </form>
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
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="size-1">
                                                <label class="custom-control-label" for="size-1">XS</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="size-2">
                                                <label class="custom-control-label" for="size-2">S</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" checked id="size-3">
                                                <label class="custom-control-label" for="size-3">M</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" checked id="size-4">
                                                <label class="custom-control-label" for="size-4">L</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="size-5">
                                                <label class="custom-control-label" for="size-5">XL</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="size-6">
                                                <label class="custom-control-label" for="size-6">XXL</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->
                                    </div><!-- End .filter-items -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->

                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-3" role="button" aria-expanded="true" aria-controls="widget-3">
                                    Colour
                                </a>
                            </h3><!-- End .widget-title -->

                            <div class="collapse show" id="widget-3">
                                <div class="widget-body">
                                    <div class="filter-colors">
                                        <a href="#" style="background: #b87145;"><span class="sr-only">Color Name</span></a>
                                        <a href="#" style="background: #f0c04a;"><span class="sr-only">Color Name</span></a>
                                        <a href="#" style="background: #333333;"><span class="sr-only">Color Name</span></a>
                                        <a href="#" class="selected" style="background: #cc3333;"><span class="sr-only">Color Name</span></a>
                                        <a href="#" style="background: #3399cc;"><span class="sr-only">Color Name</span></a>
                                        <a href="#" style="background: #669933;"><span class="sr-only">Color Name</span></a>
                                        <a href="#" style="background: #f2719c;"><span class="sr-only">Color Name</span></a>
                                        <a href="#" style="background: #ebebeb;"><span class="sr-only">Color Name</span></a>
                                    </div><!-- End .filter-colors -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->

                        <div class="widget widget-collapsible">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true" aria-controls="widget-4">
                                    Brand
                                </a>
                            </h3><!-- End .widget-title -->

                            <div class="collapse show" id="widget-4">
                                <div class="widget-body">
                                    <div class="filter-items">
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="brand-1">
                                                <label class="custom-control-label" for="brand-1">Next</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="brand-2">
                                                <label class="custom-control-label" for="brand-2">River Island</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="brand-3">
                                                <label class="custom-control-label" for="brand-3">Geox</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="brand-4">
                                                <label class="custom-control-label" for="brand-4">New Balance</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="brand-5">
                                                <label class="custom-control-label" for="brand-5">UGG</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="brand-6">
                                                <label class="custom-control-label" for="brand-6">F&F</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="brand-7">
                                                <label class="custom-control-label" for="brand-7">Nike</label>
                                            </div><!-- End .custom-checkbox -->
                                        </div><!-- End .filter-item -->

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

                                        <div id="price-slider"></div><!-- End #price-slider -->
                                    </div><!-- End .filter-price -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->
                    </div><!-- End .sidebar sidebar-shop -->
                </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main><!-- End .main -->
@endsection