@extends('user.layout')

@section('content')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<style>
    /* ── Product Image ─────────────────────────────── */
    .fixed-img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        pointer-events: none;
    }

    /* ── Product Card ──────────────────────────────── */
    .product-media {
        position: relative;
        overflow: hidden;
    }

    .product-media img {
        transition: transform 0.3s ease;
    }

    .product-media:hover img {
        transform: scale(1.08);
    }

    /* ── Out of Stock Card ─────────────────────────── */
    .product-unavailable {
        opacity: 0.72;
    }

    .product-unavailable .product-media img {
        filter: grayscale(30%);
    }

    .product-unavailable .product-media:hover img {
        transform: none;
    }

    /* ── Inactive Card (fully disabled) ───────────── */
    .product-inactive {
        opacity: 0.55;
        cursor: not-allowed;
    }

    .product-inactive .product-media img {
        filter: grayscale(60%);
    }

    .product-inactive .product-media:hover img {
        transform: none;
    }

    .product-inactive .add-to-cart,
    .product-inactive .btn-wishlist {
        pointer-events: none !important;
    }

    .product-inactive a {
        pointer-events: none !important;
        color: #aaa !important;
    }

    /* ── Overlay on unavailable cards ─────────────── */
    .unavailable-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.30);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        pointer-events: none;
    }

    .unavailable-overlay span {
        background: rgba(0,0,0,0.68);
        color: #fff;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
        padding: 7px 16px;
        border-radius: 30px;
        border: 1.5px solid rgba(255,255,255,0.25);
    }

    /* ── No Products Box ───────────────────────────── */
    .no-product-box {
        min-height: 400px;
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 80px 20px;
    }

    .no-product-box h2 {
        font-size: 32px;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .no-product-box p {
        font-size: 15px;
        color: #777;
    }

    /* ── Wishlist Button ───────────────────────────── */
    .product-action-vertical {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 100;
    }

    .btn-wishlist {
        width: 38px;
        height: 38px;
        border: 2px solid #ccc;
        border-radius: 50%;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        padding: 0;
        transition: border-color 0.25s ease, transform 0.2s ease;
        z-index: 200;
    }

    .btn-wishlist::before {
        content: "♡";
        font-size: 17px;
        color: #555;
        line-height: 1;
    }

    .btn-wishlist:hover {
        border-color: #e63946;
        transform: scale(1.1);
    }

    .btn-wishlist:hover::before {
        color: #e63946;
    }

    .btn-wishlist.active {
        border-color: #e63946;
        background: #fff0f0;
    }

    .btn-wishlist.active::before {
        content: "❤";
        color: #e63946;
    }

    /* ── Toast Notification ────────────────────────── */
    #wishlist-toast {
        position: fixed;
        bottom: 28px;
        left: 50%;
        transform: translateX(-50%) translateY(20px);
        background: #222;
        color: #fff;
        padding: 12px 24px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 500;
        z-index: 9999;
        opacity: 0;
        transition: opacity 0.3s ease, transform 0.3s ease;
        white-space: nowrap;
        pointer-events: none;
    }

    #wishlist-toast.show {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }

    #wishlist-toast.toast-success { background: #2a9d5c; }
    #wishlist-toast.toast-removed  { background: #555; }
    #wishlist-toast.toast-login    { background: #e63946; }

    /* ── Always-visible product action bar ────────── */
    .product-7 .product-action {
        position: static !important;
        transform: none !important;
        opacity: 1 !important;
        visibility: visible !important;
        background: transparent !important;
        padding: 8px 0 4px !important;
        display: flex !important;
        justify-content: center;
        left: auto !important;
        right: auto !important;
        bottom: auto !important;
    }

    /* ── Add to Cart Button ────────────────────────── */
    .btn-cart {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px;
        background: #222 !important;
        color: #fff !important;
        border: none !important;
        border-radius: 4px !important;
        padding: 9px 18px !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        letter-spacing: 0.8px;
        cursor: pointer !important;
        transition: background 0.25s ease, transform 0.15s ease;
        text-transform: uppercase !important;
        width: auto !important;
        height: auto !important;
        text-indent: 0 !important;
        overflow: visible !important;
        white-space: nowrap;
        line-height: normal !important;
    }

    .btn-cart::before,
    .btn-cart::after {
        display: none !important;
    }

    .btn-cart:hover:not(:disabled) {
        background: #e63946 !important;
        color: #fff !important;
        transform: translateY(-1px);
    }

    /* ── Disabled cart button (OOS / Inactive) ─────── */
    .btn-cart:disabled,
    .btn-cart.btn-disabled {
        background: #bbb !important;
        color: #fff !important;
        cursor: not-allowed !important;
        opacity: 0.85;
        transform: none !important;
        pointer-events: none !important;
    }

    .btn-cart.loading {
        opacity: 0.6;
        pointer-events: none;
    }

    /* ── Size Modal ────────────────────────────────── */
    #sizeModal .size-option {
        min-width: 50px;
        padding: 8px 14px;
        border: 2px solid #ddd;
        border-radius: 7px;
        text-align: center;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.18s ease;
        user-select: none;
        background: #fff;
        color: #333;
        position: relative;
    }

    #sizeModal .size-option:hover:not(.out-of-stock) {
        border-color: #1a1a1a;
        background: #f5f5f5;
    }

    #sizeModal .size-option.selected {
        border-color: #1a1a1a;
        background: #1a1a1a;
        color: #fff;
    }

    #sizeModal .size-option.out-of-stock {
        border-color: #eee;
        color: #ccc;
        cursor: not-allowed;
        background: #fafafa;
        text-decoration: line-through;
    }

    #sizeModal .size-option.out-of-stock .oos-label {
        display: block;
        font-size: 9px;
        font-weight: 500;
        letter-spacing: 0.3px;
        color: #e63946;
        text-decoration: none;
        margin-top: 2px;
        text-transform: uppercase;
    }

    /* ── Low Stock label inside size pill ──────────── */
    #sizeModal .size-option .low-stock-label {
        display: block;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 0.3px;
        color: #e67e22;
        margin-top: 2px;
        text-transform: uppercase;
        text-decoration: none;
        white-space: nowrap;
    }

    /* Keep orange label visible when pill is selected */
    #sizeModal .size-option.selected .low-stock-label {
        color: #ffc87a;
    }

    #confirmAddToCart:hover  { background: #e63946 !important; }
    #confirmAddToCart:active { transform: scale(0.98); }

    /* ── Cart Toast (right side) ───────────────────── */
    #cart-toast {
        position: fixed;
        bottom: 28px;
        right: 24px;
        background: #222;
        color: #fff;
        padding: 12px 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        z-index: 9999;
        opacity: 0;
        transform: translateY(16px);
        transition: opacity 0.3s ease, transform 0.3s ease;
        pointer-events: none;
        display: flex;
        align-items: center;
        gap: 8px;
        max-width: 280px;
    }

    #cart-toast.show {
        opacity: 1;
        transform: translateY(0);
    }

    #cart-toast.toast-added   { background: #2a9d5c; }
    #cart-toast.toast-updated { background: #2176ae; }
    #cart-toast.toast-login   { background: #e63946; }

    /* ── Discount Badge ────────────────────────────── */
    .badge-discount {
        position: absolute;
        top: 10px;
        left: 10px;
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.4px;
        padding: 4px 8px;
        border-radius: 4px;
        z-index: 100;
        pointer-events: none;
    }

    .badge-discount.badge-sale     { background: #e63946; }
    .badge-discount.badge-oos      { background: #888; }
    .badge-discount.badge-inactive { background: #444; }

    /* ── Price display ─────────────────────────────── */
    .product-price .new-price {
        color: #e63946;
        font-weight: 700;
        font-size: 15px;
    }
    .product-price .old-price {
        color: #aaa;
        font-size: 13px;
        text-decoration: line-through;
        margin-left: 5px;
    }
    .product-price .price-muted {
        color: #aaa;
    }

    /* ── Sidebar Checkbox Fix ──────────────────────── */
    .custom-control-input {
        position: relative !important;
        z-index: 2;
        cursor: pointer;
    }

    .custom-control-label {
        cursor: pointer;
    }

    /* ── OOS Wishlist hint ─────────────────────────── */
    .oos-wishlist-hint {
        font-size: 11px;
        color: #999;
        text-align: center;
        margin-top: 4px;
        font-style: italic;
    }
</style>

<!-- Wishlist Toast (bottom-center) -->
<div id="wishlist-toast"></div>

<!-- Cart Toast (bottom-right) -->
<div id="cart-toast"></div>

<!-- ── Size + Qty Modal ──────────────────────────────────── -->
<div class="modal fade" id="sizeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content" style="border-radius:14px; overflow:hidden; border:none; box-shadow:0 20px 60px rgba(0,0,0,0.15);">

            {{-- Header --}}
            <div class="modal-header" style="border-bottom:1px solid #eee; padding:16px 20px; display:flex; align-items:center; justify-content:space-between;">
                <div>
                    <p style="font-size:11px;text-transform:uppercase;letter-spacing:1.5px;color:#999;margin:0 0 2px;">Add to Cart</p>
                    <h5 class="modal-title" id="modalProductName" style="font-size:15px;font-weight:700;color:#1a1a1a;margin:0;"></h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" style="font-size:20px;color:#999;background:none;border:none;cursor:pointer;padding:4px 8px;">&times;</button>
            </div>

            {{-- Already in cart section --}}
            <div id="alreadyInCartSection" style="display:none; padding:12px 20px 0;">
                <p style="font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#2a9d5c;margin:0 0 8px;">✔ Already in Cart</p>
                <div id="alreadyInCartList" style="display:flex;flex-wrap:wrap;gap:8px;"></div>
                <hr style="margin:12px 0 0; border-color:#f0f0f0;">
            </div>

            {{-- Size label --}}
            <div style="padding:18px 20px 4px;">
                <p style="font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#888;margin:0 0 10px;">Select Size</p>
                <div class="size-grid" id="sizeOptions" style="display:flex;flex-wrap:wrap;gap:8px;padding:0;">
                    {{-- Injected by JS --}}
                </div>
                <p id="sizeError" style="display:none;color:#e63946;font-size:12px;margin-top:8px;">⚠ Please select a size first.</p>
            </div>

            {{-- Qty stepper --}}
            <div style="padding:16px 20px 6px; display:flex; align-items:center; justify-content:space-between;">
                <p style="font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#888;margin:0;">Quantity</p>
                <div style="display:inline-flex;align-items:center;border:1.5px solid #ddd;border-radius:8px;overflow:hidden;background:#fff;">
                    <button type="button" id="modalQtyMinus"
                        style="width:36px;height:36px;border:none;background:transparent;font-size:20px;cursor:pointer;color:#333;display:flex;align-items:center;justify-content:center;transition:background 0.15s;"
                        onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='transparent'">−</button>
                    <span id="modalQtyValue"
                        style="min-width:36px;text-align:center;font-size:15px;font-weight:700;color:#1a1a1a;border-left:1.5px solid #ddd;border-right:1.5px solid #ddd;padding:6px 4px;user-select:none;">1</span>
                    <button type="button" id="modalQtyPlus"
                        style="width:36px;height:36px;border:none;background:transparent;font-size:20px;cursor:pointer;color:#333;display:flex;align-items:center;justify-content:center;transition:background 0.15s;"
                        onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='transparent'">+</button>
                </div>
            </div>

            {{-- Confirm button --}}
            <div style="padding:16px 20px 20px;">
                <button type="button" id="confirmAddToCart"
                    style="width:100%;padding:13px;background:#1a1a1a;color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:700;letter-spacing:0.8px;text-transform:uppercase;cursor:pointer;transition:background 0.25s;">
                    🛒 Add to Cart
                </button>
            </div>

        </div>
    </div>
</div>

<main class="main">
    <div class="page-header text-center">
        <div class="container" style="padding-top: 80px;">
            <h1 class="page-title">Shop Now</h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container"></div>
    </nav>

    <form method="GET" id="filterForm">
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif

        <div class="page-content">
            <div class="container">
                <div class="row">

                    {{-- ── Products Column ──────────────────────── --}}
                    <div class="col-lg-9">

                        <div class="toolbox">
                            <div class="toolbox-left">
                                <div class="toolbox-info">
                                    @if($product->count())
                                        Showing {{ $product->firstItem() }} to {{ $product->lastItem() }}
                                        of {{ $product->total() }} Products
                                    @else
                                        No products found
                                    @endif
                                </div>
                            </div>

                            <div class="toolbox-right">
                                <div class="toolbox-sort">
                                    <label for="sortby">Sort by:</label>
                                    <div class="select-custom">
                                        <select name="sortby" id="sortby" class="form-control" onchange="this.form.submit()">
                                            <option value="">Select Option</option>
                                            <option value="popularity" {{ request('sortby') == 'popularity' ? 'selected' : '' }}>Most Popular</option>
                                            <option value="rating"     {{ request('sortby') == 'rating'     ? 'selected' : '' }}>Most Rated</option>
                                            <option value="date"       {{ request('sortby') == 'date'       ? 'selected' : '' }}>Date</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End .toolbox -->

                        <div class="products mb-3">
                            <div class="row justify-content-center">

                                @if($product->count())
                                    @foreach($product as $pro)
                                    @php
                                        $totalStock   = $pro->productsize->sum('stock');
                                        $isOutOfStock = $totalStock === 0;
                                        $isInactive   = isset($pro->status) && $pro->status !== 'active';
                                        $unavailable  = $isOutOfStock || $isInactive;
                                        $blockNav     = $isInactive;
                                    @endphp

                                    <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                                        <div class="product product-7 text-center
                                            {{ $isOutOfStock && !$isInactive ? 'product-unavailable' : '' }}
                                            {{ $isInactive ? 'product-inactive' : '' }}">

                                            <figure class="product-media">

                                                {{-- Unavailable overlay --}}
                                                @if($unavailable)
                                                    <div class="unavailable-overlay">
                                                        <span>
                                                            {{ $isInactive ? '🚫 Unavailable' : '😔 Out of Stock' }}
                                                        </span>
                                                    </div>
                                                @endif

                                                {{-- Image --}}
                                                <a href="{{url('user/single-shop/' . $pro->proid) }}">
                                                    <img src="{{ asset('admin/assets/images/' . $pro->proimage) }}"
                                                         alt="{{ $pro->proname }}"
                                                         class="product-image fixed-img">
                                                </a>

                                                {{-- Badges --}}
                                                @if($isInactive)
                                                    <span class="badge-discount badge-inactive">Unavailable</span>
                                                @elseif($isOutOfStock)
                                                    <span class="badge-discount badge-oos">Out of Stock</span>
                                                @elseif($pro->discount_price && $pro->discount_price > 0)
                                                    @php $pct = number_format(($pro->discount_price / $pro->price) * 100, 2); @endphp
                                                    <span class="badge-discount badge-sale">-{{ $pct }}%</span>
                                                @endif

                                                {{-- Wishlist Button (hidden only for inactive) --}}
                                                @if(!$isInactive)
                                                <div class="product-action-vertical">
                                                    <button type="button"
                                                        class="btn-wishlist add-to-wishlist {{ in_array($pro->proid, $wishlistIds ?? []) ? 'active' : '' }}"
                                                        data-id="{{ $pro->proid }}"
                                                        title="{{ $isOutOfStock ? 'Save for later — notify when back in stock' : 'Add to Wishlist' }}">
                                                    </button>
                                                </div>
                                                @endif

                                                {{-- Cart Button --}}
                                                <div class="product-action">
                                                    @if($unavailable)
                                                        <button type="button"
                                                            class="btn-product btn-cart btn-disabled"
                                                            disabled
                                                            title="{{ $isInactive ? 'This product is currently unavailable' : 'This product is out of stock' }}">
                                                            {{ $isInactive ? '🚫 Unavailable' : '😔 Out of Stock' }}
                                                        </button>
                                                    @else
                                                        <button type="button"
                                                            class="btn-product btn-cart add-to-cart"
                                                            data-id="{{ $pro->proid }}"
                                                            data-name="{{ $pro->proname }}"
                                                            data-sizes="{{ json_encode($pro->productsize->map(fn($s) => ['size' => $s->size, 'stock' => $s->stock])) }}">
                                                            🛒 Add to Cart
                                                        </button>
                                                    @endif
                                                </div>

                                            </figure>

                                            <div class="product-body">
                                                <div class="product-cat">
                                                    <a href="{{ url('user/shop', $pro->category->slug) }}">
                                                        {{ $pro->category->name ?? 'Category' }}
                                                    </a>
                                                </div>

                                                <h3 class="product-title">
                                                    <a href="{{url('user/single-shop/' . $pro->proid) }}"
                                                       style="{{ $blockNav ? 'color:#aaa; pointer-events:none;' : '' }}">
                                                        {{ $pro->proname }}
                                                    </a>
                                                </h3>

                                                <div class="product-price">
                                                    @if($pro->discount_price && $pro->discount_price > 0)
                                                        @php $finalPrice = $pro->price - $pro->discount_price; @endphp
                                                        <span class="new-price {{ $unavailable ? 'price-muted' : '' }}">
                                                            ₹{{ number_format($finalPrice, 2) }}
                                                        </span>
                                                        <span class="old-price">₹{{ number_format($pro->price, 2) }}</span>
                                                    @else
                                                        <span class="{{ $unavailable ? 'price-muted' : '' }}">
                                                            ₹{{ number_format($pro->price, 2) }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="ratings-container">
                                                    <div class="ratings">
                                                        <div class="ratings-val" style="width: {{ ($pro->reviews_avg_rating ?? 0) * 20 }}%;"></div>
                                                    </div>
                                                    <span class="ratings-text">({{ $pro->reviews_count }})</span>
                                                </div>

                                                @if($isOutOfStock && !$isInactive)
                                                    <p class="oos-wishlist-hint">♡ Save to wishlist</p>
                                                @endif

                                            </div>

                                        </div>
                                    </div>
                                    @endforeach

                                @else
                                    <div class="col-12">
                                        <div class="no-product-box">
                                            <span style="font-size:48px;">😢</span>
                                            <h2>No Products Found</h2>
                                            <p>Try a different category or search term.</p>
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

                    {{-- ── Sidebar ────────────────────────────────── --}}
                    <aside class="col-lg-3 order-lg-first">
                        <div class="sidebar sidebar-shop">

                            <div class="widget widget-clean">
                                <label>Filters:</label>
                                <a href="{{ url('user/shop') }}">Clean All</a>
                            </div>

                            {{-- Category --}}
                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-1" role="button"
                                       aria-expanded="true" aria-controls="widget-1">Category</a>
                                </h3>
                                <div class="collapse show" id="widget-1">
                                    <div class="widget-body">
                                        <div class="filter-items filter-items-count">
                                            @foreach($cat as $c)
                                            <div class="filter-item">
                                                <input type="checkbox"
                                                    name="category[]"
                                                    value="{{ $c->slug }}"
                                                    {{ in_array($c->slug, request('category', [])) ? 'checked' : '' }}
                                                    onchange="this.form.submit()"
                                                    id="cat-{{ $c->id }}">
                                                <label for="cat-{{ $c->id }}">{{ $c->name }}</label>
                                                <span>{{ $c->product_count }}</span>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Size --}}
                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-2" role="button"
                                       aria-expanded="true" aria-controls="widget-2">Size</a>
                                </h3>
                                <div class="collapse show" id="widget-2">
                                    <div class="widget-body">
                                        <div class="filter-items">
                                            @php $sizes = ['S','M','L','XL','XXL','28','30','32','34','36']; @endphp
                                            @foreach($sizes as $index => $s)
                                            <div class="filter-item">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                        onchange="this.form.submit()"
                                                        {{ in_array($s, request('size', [])) ? 'checked' : '' }}
                                                        id="size-{{ $index }}"
                                                        name="size[]"
                                                        value="{{ $s }}">
                                                    <label for="size-{{ $index }}">{{ $s }}</label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Price --}}
                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-5" role="button"
                                       aria-expanded="true" aria-controls="widget-5">Price</a>
                                </h3>
                                <div class="collapse show" id="widget-5">
                                    <div class="widget-body">
                                        <div class="filter-price">
                                            <div class="filter-price-text">
                                                Price Range: <span id="filter-price-range"></span>
                                            </div>
                                            <input type="hidden" name="min_price" id="min_price" value="{{ request('min_price') }}">
                                            <input type="hidden" name="max_price" id="max_price" value="{{ request('max_price') }}">
                                            <div id="price-slider"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </aside>

                </div><!-- End .row -->
            </div><!-- End .container -->
        </div>
    </form>
</main>

@endsection


@push('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
    // ── Cart items already in cart (keyed by proid → [sizes]) ─────
    const cartData = @json(
        $cartItems->groupBy('proid')->map(fn($items) =>
            $items->map(fn($i) => ['cart_id' => $i->cart_id, 'size' => $i->size, 'qty' => $i->qty])
        )
    );

    // ── Price Slider ──────────────────────────────────────────────
    $(function () {
        let min   = parseInt(@json(request('min_price') ?? $minPrice));
        let max   = parseInt(@json(request('max_price') ?? $maxPrice));
        let dbMin = {{ $minPrice }};
        let dbMax = {{ $maxPrice }};

        $("#price-slider").slider({
            range : true,
            min   : dbMin,
            max   : dbMax,
            values: [min, max],
            create: function () {
                $("#filter-price-range").text("₹" + min + " – ₹" + max);
            },
            slide : function (event, ui) {
                $("#filter-price-range").text("₹" + ui.values[0] + " – ₹" + ui.values[1]);
            },
            change: function (event, ui) {
                $("#min_price").val(ui.values[0]);
                $("#max_price").val(ui.values[1]);
                document.getElementById('filterForm').submit();
            }
        });
    });

    // ── Toast Helper ──────────────────────────────────────────────
    function showToast(message, type) {
        const toast = $('#wishlist-toast');
        toast.text(message)
             .removeClass('toast-success toast-removed toast-login')
             .addClass('toast-' + type + ' show');

        setTimeout(function () {
            toast.removeClass('show');
        }, 3000);
    }

    // ── Wishlist Toggle ───────────────────────────────────────────
    $(document).on('click', '.add-to-wishlist', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const btn        = $(this);
        const product_id = btn.data('id');

        $.ajax({
            url : "{{ route('wishlist.toggle') }}",
            type: "POST",
            data: {
                product_id: product_id,
                _token    : "{{ csrf_token() }}"
            },
            success: function (res) {
                if (res.status === 'added') {
                    btn.addClass('active');
                    showToast('❤️ ' + res.message, 'success');
                } else if (res.status === 'removed') {
                    btn.removeClass('active');
                    showToast('🗑️ ' + res.message, 'removed');
                } else if (res.status === 'login') {
                    showToast('🔒 ' + res.message, 'login');
                }
            },
            error: function () {
                showToast('Something went wrong. Please try again.', 'login');
            }
        });
    });

    // ── Cart Toast Helper ─────────────────────────────────────────
    function showCartToast(message, type) {
        const toast = $('#cart-toast');
        toast.text(message)
             .removeClass('toast-added toast-updated toast-login')
             .addClass('toast-' + type + ' show');

        setTimeout(function () {
            toast.removeClass('show');
        }, 3000);
    }

    // ── Add To Cart — open modal with product sizes + qty ────────
    let cartProductId = null;
    let cartQty       = 1;

    $(document).on('click', '.add-to-cart', function (e) {
        e.preventDefault();

        cartProductId     = $(this).data('id');
        const productName = $(this).data('name') || $(this).closest('.product').find('.product-title a').text().trim();
        const sizesRaw    = $(this).data('sizes');
        const sizes       = Array.isArray(sizesRaw) ? sizesRaw : JSON.parse(sizesRaw || '[]');

        // ── Reset modal ───────────────────────────────────────────
        cartQty = 1;
        $('#modalQtyValue').text(1);
        $('#modalProductName').text(productName);
        $('#sizeError').hide();

        // ── Show already-in-cart sizes with remove buttons ────────
        const $alreadySection = $('#alreadyInCartSection');
        const $alreadyList    = $('#alreadyInCartList');
        $alreadyList.empty();

        const cartItems = cartData[cartProductId] || [];
        if (cartItems.length > 0) {
            $alreadySection.show();
            cartItems.forEach(function (item) {
                const label = item.size ? item.size : 'No Size';
                const $tag  = $('<div>').css({
                    display        : 'inline-flex',
                    alignItems     : 'center',
                    gap            : '5px',
                    background     : '#e8f7ef',
                    border         : '1.5px solid #2a9d5c',
                    borderRadius   : '7px',
                    padding        : '5px 10px',
                    fontSize       : '13px',
                    fontWeight     : '700',
                    color          : '#1a7a47',
                });
                $tag.text(label + ' ×' + item.qty);

                const $removeBtn = $('<button>').attr('type','button').css({
                    background   : 'none',
                    border       : 'none',
                    color        : '#e63946',
                    fontSize     : '15px',
                    cursor       : 'pointer',
                    padding      : '0',
                    lineHeight   : '1',
                    fontWeight   : '700',
                }).html('&times;')
                  .attr('title', 'Remove from cart')
                  .on('click', function () {
                      removeFromCartInModal(item.cart_id, cartProductId, $tag);
                  });

                $tag.append($removeBtn);
                $alreadyList.append($tag);
            });
        } else {
            $alreadySection.hide();
        }

        // ── Build size pills ──────────────────────────────────────
        const $grid = $('#sizeOptions');
        $grid.empty();

        if (sizes.length === 0) {
            $grid.html('<p style="color:#aaa;font-size:13px;padding:4px 0 8px;">No sizes defined for this product.</p>');
        } else {
            sizes.forEach(function (item) {
                const alreadyAdded = cartItems.some(c => c.size === item.size);
                const inStock      = item.stock > 0;
                const isLowStock   = inStock && !alreadyAdded && item.stock <= 3;
                const disabled     = !inStock || alreadyAdded;

                // Build the inner HTML for the pill
                let pillHTML = item.size;

                if (alreadyAdded) {
                    pillHTML += '<span class="oos-label">In Cart</span>';
                } else if (!inStock) {
                    pillHTML += '<span class="oos-label">Out of Stock</span>';
                } else if (isLowStock) {
                    pillHTML += '<span class="low-stock-label">Only ' + item.stock + ' left</span>';
                }

                const $pill = $('<div>')
                    .addClass('size-option' + (disabled ? ' out-of-stock' : ''))
                    .attr('data-size', item.size)
                    .attr('data-stock', item.stock)
                    .html(pillHTML);

                if (disabled) {
                    $pill.attr('title', alreadyAdded ? 'Already in cart' : 'Out of stock');
                }

                $grid.append($pill);
            });
        }

        $('#sizeModal').modal('show');
    });

    // ── Remove cart item from within modal ────────────────────────
    function removeFromCartInModal(cartId, productId, $tag) {
        $.ajax({
            url : "{{ route('cart.remove') }}",
            type: "POST",
            data: { cart_id: cartId, _token: "{{ csrf_token() }}" },
            success: function (res) {
                if (res.status === 'removed') {
                    $tag.remove();

                    if (cartData[productId]) {
                        cartData[productId] = cartData[productId].filter(i => i.cart_id !== cartId);
                        if (cartData[productId].length === 0) {
                            delete cartData[productId];
                            $('#alreadyInCartSection').hide();
                        }
                    }

                    // Re-enable pill for that size if it was marked "In Cart"
                    $('#sizeOptions .size-option.out-of-stock').each(function () {
                        const $pill       = $(this);
                        const sizeLabel   = $pill.attr('data-size');
                        const sizeStock   = parseInt($pill.attr('data-stock') || 0);
                        const stillInCart = (cartData[productId] || []).some(c => c.size === sizeLabel);
                        const $oosLabel   = $pill.find('.oos-label');

                        if (!stillInCart && $oosLabel.text() === 'In Cart') {
                            $pill.removeClass('out-of-stock').removeAttr('title');
                            $oosLabel.remove();

                            // Re-add low stock label if applicable
                            if (sizeStock > 0 && sizeStock <= 3) {
                                $pill.append('<span class="low-stock-label">Only ' + sizeStock + ' left</span>');
                            }
                        }
                    });

                    if (res.cart_count !== undefined) {
                        $('.cart-count, #cart-count').text(res.cart_count);
                    }

                    showCartToast('🗑️ Removed from cart', 'updated');
                }
            },
            error: function () {
                showCartToast('Could not remove item. Try again.', 'login');
            }
        });
    }

    // ── Qty minus ─────────────────────────────────────────────────
    $('#modalQtyMinus').on('click', function () {
        if (cartQty > 1) { cartQty--; $('#modalQtyValue').text(cartQty); }
    });

    // ── Qty plus ──────────────────────────────────────────────────
    $('#modalQtyPlus').on('click', function () {
        const stock = parseInt($('#sizeOptions .size-option.selected').data('stock') || 99);
        if (cartQty < stock) { cartQty++; $('#modalQtyValue').text(cartQty); }
    });

    // ── Size selection (skip out-of-stock) ────────────────────────
    $(document).on('click', '#sizeOptions .size-option', function () {
        if ($(this).hasClass('out-of-stock')) return;
        $('#sizeOptions .size-option').removeClass('selected');
        $(this).addClass('selected');
        $('#sizeError').hide();
        cartQty = 1;
        $('#modalQtyValue').text(1);
    });

    // ── Confirm add to cart ───────────────────────────────────────
    $('#confirmAddToCart').on('click', function () {
        const $selected    = $('#sizeOptions .size-option.selected');
        const selectedSize = $selected.data('size');
        const btn          = $(this);

        if ($('#sizeOptions .size-option:not(.out-of-stock)').length > 0 && !selectedSize) {
            $('#sizeError').show();
            return;
        }

        btn.prop('disabled', true).text('Adding…');

        $.ajax({
            url : "{{ route('cart.add') }}",
            type: "POST",
            data: {
                product_id : cartProductId,
                size       : selectedSize || null,
                qty        : cartQty,
                _token     : "{{ csrf_token() }}"
            },
            success: function (res) {
                $('#sizeModal').modal('hide');
                btn.prop('disabled', false).html('🛒 Add to Cart');

                if (res.status === 'added') {
                    if (!cartData[cartProductId]) cartData[cartProductId] = [];
                    cartData[cartProductId].push({
                        cart_id : res.cart_id || null,
                        size    : selectedSize || null,
                        qty     : cartQty,
                    });
                    showCartToast('🛒 ' + res.message, 'added');
                }
                else if (res.status === 'updated') showCartToast('🔄 ' + res.message, 'updated');
                else if (res.status === 'login')   showCartToast('🔒 ' + res.message, 'login');
            },
            error: function () {
                $('#sizeModal').modal('hide');
                btn.prop('disabled', false).html('🛒 Add to Cart');
                showCartToast('Something went wrong. Please try again.', 'login');
            }
        });
    });
</script>
@endpush