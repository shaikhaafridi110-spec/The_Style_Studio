@extends('user.layout')

@section('content')

<style>
    /* ── Toast ─────────────────────────────────────────── */
    #wl-toast {
        position: fixed;
        bottom: 28px;
        right: 24px;
        padding: 12px 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        color: #fff;
        z-index: 9999;
        opacity: 0;
        transform: translateY(16px);
        transition: opacity 0.3s ease, transform 0.3s ease;
        pointer-events: none;
        max-width: 280px;
    }
    #wl-toast.show   { opacity: 1; transform: translateY(0); }
    #wl-toast.green  { background: #2a9d5c; }
    #wl-toast.blue   { background: #2176ae; }
    #wl-toast.red    { background: #e63946; }

    /* ── Empty state ───────────────────────────────────── */
    .wl-empty {
        min-height: 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 80px 20px;
    }
    .wl-empty h2 { font-size: 28px; font-weight: 600; color: #333; margin: 16px 0 8px; }
    .wl-empty p  { color: #777; font-size: 15px; margin-bottom: 24px; }

    /* ── Table tweaks ──────────────────────────────────── */
    .table-wishlist th {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #999;
        font-weight: 700;
        border-bottom: 2px solid #eee;
        padding: 10px 12px;
    }
    .table-wishlist td { vertical-align: middle; padding: 14px 12px; }
    .table-wishlist .product-media {
        width: 80px; height: 80px;
        border-radius: 8px; overflow: hidden; flex-shrink: 0;
    }
    .table-wishlist .product-media img {
        width: 100%; height: 100%; object-fit: cover;
    }
    .table-wishlist .product-title a {
        font-size: 14px; font-weight: 600; color: #1a1a1a;
    }
    .table-wishlist .product-title a:hover { color: #e63946; }
    .table-wishlist .price-col { font-weight: 700; color: #1a1a1a; font-size: 15px; }
    .table-wishlist .in-stock  { color: #2a9d5c; font-size: 13px; font-weight: 600; }
    .table-wishlist .out-of-stock { color: #e63946; font-size: 13px; font-weight: 600; }

    /* ── Add to Cart btn ───────────────────────────────── */
    .btn-wl-cart {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #1a1a1a;
        color: #fff !important;
        border: none;
        border-radius: 6px;
        padding: 9px 16px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.2s ease;
    }
    .btn-wl-cart:hover  { background: #e63946; }
    .btn-wl-cart:disabled { opacity: 0.45; cursor: not-allowed; background: #999; }

    /* ── Remove btn ────────────────────────────────────── */
    .btn-wl-remove {
        width: 34px; height: 34px;
        border-radius: 50%;
        border: 2px solid #ddd;
        background: #fff;
        color: #999;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: border-color 0.2s, color 0.2s;
        font-size: 16px;
    }
    .btn-wl-remove:hover { border-color: #e63946; color: #e63946; }

    /* ── Size Modal ────────────────────────────────────── */
    #wlSizeModal .size-option {
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
    }
    #wlSizeModal .size-option:hover:not(.oos) { border-color: #1a1a1a; background: #f5f5f5; }
    #wlSizeModal .size-option.selected        { border-color: #1a1a1a; background: #1a1a1a; color: #fff; }
    #wlSizeModal .size-option.oos             { border-color: #eee; color: #ccc; cursor: not-allowed; text-decoration: line-through; }
    #wlSizeModal .size-option.oos .oos-lbl    { display: block; font-size: 9px; color: #e63946; text-decoration: none; margin-top: 2px; text-transform: uppercase; }
    #wlConfirmCart:hover { background: #e63946 !important; }
</style>

<!-- Toast -->
<div id="wl-toast"></div>

<!-- ── Size + Qty Modal ──────────────────────────────── -->
<div class="modal fade" id="wlSizeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content" style="border-radius:14px;overflow:hidden;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.15);">

            {{-- Header --}}
            <div class="modal-header" style="border-bottom:1px solid #eee;padding:16px 20px;display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <p style="font-size:11px;text-transform:uppercase;letter-spacing:1.5px;color:#999;margin:0 0 2px;">Add to Cart</p>
                    <h5 id="wlModalName" style="font-size:15px;font-weight:700;color:#1a1a1a;margin:0;"></h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" style="font-size:20px;color:#999;background:none;border:none;cursor:pointer;padding:4px 8px;">&times;</button>
            </div>

            {{-- Already in Cart section --}}
            <div id="wlAlreadySection" style="display:none; padding:12px 20px 0;">
                <p style="font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#2a9d5c;margin:0 0 8px;">✔ Already in Cart</p>
                <div id="wlAlreadyList" style="display:flex;flex-wrap:wrap;gap:8px;"></div>
                <hr style="margin:12px 0 0;border-color:#f0f0f0;">
            </div>

            {{-- Sizes --}}
            <div style="padding:18px 20px 4px;">
                <p style="font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#888;margin:0 0 10px;">Select Size</p>
                <div id="wlSizeOptions" style="display:flex;flex-wrap:wrap;gap:8px;"></div>
                <p id="wlSizeError" style="display:none;color:#e63946;font-size:12px;margin-top:8px;">⚠ Please select a size first.</p>
            </div>

            {{-- Qty --}}
            <div style="padding:16px 20px 6px;display:flex;align-items:center;justify-content:space-between;">
                <p style="font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:#888;margin:0;">Quantity</p>
                <div style="display:inline-flex;align-items:center;border:1.5px solid #ddd;border-radius:8px;overflow:hidden;">
                    <button type="button" id="wlQtyMinus"
                        style="width:36px;height:36px;border:none;background:transparent;font-size:20px;cursor:pointer;color:#333;"
                        onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='transparent'">−</button>
                    <span id="wlQtyValue"
                        style="min-width:36px;text-align:center;font-size:15px;font-weight:700;color:#1a1a1a;border-left:1.5px solid #ddd;border-right:1.5px solid #ddd;padding:6px 4px;user-select:none;">1</span>
                    <button type="button" id="wlQtyPlus"
                        style="width:36px;height:36px;border:none;background:transparent;font-size:20px;cursor:pointer;color:#333;"
                        onmouseover="this.style.background='#f5f5f5'" onmouseout="this.style.background='transparent'">+</button>
                </div>
            </div>

            {{-- Confirm --}}
            <div style="padding:16px 20px 20px;">
                <button type="button" id="wlConfirmCart"
                    style="width:100%;padding:13px;background:#1a1a1a;color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:700;letter-spacing:0.8px;text-transform:uppercase;cursor:pointer;transition:background 0.25s;">
                    🛒 Add to Cart
                </button>
            </div>

        </div>
    </div>
</div>

<main class="main">
    <div class="page-header text-center">
        <div class="container" style="padding-top:80px;">
            <h1 class="page-title">Wish List</h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container"></div>
    </nav>

    <div class="page-content">
        <div class="container">

            @if($wishlist->isEmpty())
                {{-- ── Empty State ──────────────────────────── --}}
                <div class="wl-empty">
                    <span style="font-size:56px;">🤍</span>
                    <h2>Your Wishlist is Empty</h2>
                    <p>Save items you love and come back to them anytime.</p>
                    <a href="{{ url('user/shop') }}" class="btn btn-primary btn-rounded">
                        <i class="icon-long-arrow-right"></i> Browse Products
                    </a>
                </div>

            @else
                <table class="table table-wishlist table-mobile">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Stock Status</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="wishlist-body">

                        @foreach($wishlist as $item)
                        @php
                            $pro   = $item->product;
                            $sizes = $pro->productsize ?? collect();
                            $hasStock = $sizes->sum('stock') > 0;
                        @endphp
                        <tr id="wl-row-{{ $item->id }}">

                            {{-- Product --}}
                            <td class="product-col">
                                <div class="product" style="display:flex;align-items:center;gap:14px;">
                                    <figure class="product-media">
                                        <a href="{{ url('user/single-shop/' . $pro->id) }}">
                                            <img src="{{ asset('admin/assets/images/' . $pro->proimage) }}"
                                                 alt="{{ $pro->proname }}">
                                        </a>
                                    </figure>
                                    <h3 class="product-title" style="margin:0;">
                                        <a href="{{ url('user/single-shop/' . $pro->id) }}">{{ $pro->proname }}</a>
                                        @if($pro->category)
                                            <span style="display:block;font-size:12px;color:#999;font-weight:400;margin-top:3px;">
                                                {{ $pro->category->name }}
                                            </span>
                                        @endif
                                    </h3>
                                </div>
                            </td>

                            {{-- Price --}}
                            <td class="price-col">
                                @if($pro->discount_price && $pro->discount_price > 0)
                                    @php
                                        $finalPrice = $pro->price - $pro->discount_price;
                                        $pct = number_format(($pro->discount_price / $pro->price) * 100, 2);
                                    @endphp
                                    <span style="color:#e63946;font-weight:700;font-size:15px;">₹{{ number_format($finalPrice, 2) }}</span>
                                    <span style="color:#aaa;font-size:12px;text-decoration:line-through;margin-left:4px;">₹{{ number_format($pro->price, 2) }}</span>
                                    <span style="display:block;font-size:11px;font-weight:700;color:#2a9d5c;margin-top:2px;">{{ $pct }}% off</span>
                                @else
                                    ₹{{ number_format($pro->price, 2) }}
                                @endif
                            </td>

                            {{-- Stock --}}
                            <td class="stock-col">
                                @if($hasStock)
                                    <span class="in-stock">✔ In Stock</span>
                                @else
                                    <span class="out-of-stock">✘ Out of Stock</span>
                                @endif
                            </td>

                            {{-- Add to Cart --}}
                            <td class="action-col">
                                @if($hasStock)
                                    <button type="button"
                                        class="btn-wl-cart wl-open-modal"
                                        data-id="{{ $pro->proid }}"
                                        data-name="{{ $pro->proname }}"
                                        data-sizes="{{ json_encode($sizes->map(fn($s) => ['size' => $s->size, 'stock' => $s->stock])) }}">
                                        <i class="icon-cart-plus"></i> Add to Cart
                                    </button>
                                @else
                                    <button class="btn-wl-cart" disabled>Out of Stock</button>
                                @endif
                            </td>

                            {{-- Remove --}}
                            <td class="remove-col">
                                <button type="button"
                                    class="btn-wl-remove wl-remove"
                                    data-id="{{ $item->id }}"
                                    data-proid="{{ $pro->proid }}"
                                    title="Remove from Wishlist">
                                    <i class="icon-close"></i>
                                </button>
                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>

                {{-- Share --}}
                <div class="wishlist-share" style="margin-top:24px;">
                    <div class="social-icons social-icons-sm mb-2">
                        <label class="social-label">Share on:</label>
                        <a href="#" class="social-icon" title="Facebook"  target="_blank"><i class="icon-facebook-f"></i></a>
                        <a href="#" class="social-icon" title="Twitter"   target="_blank"><i class="icon-twitter"></i></a>
                        <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                        <a href="#" class="social-icon" title="Youtube"   target="_blank"><i class="icon-youtube"></i></a>
                        <a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                    </div>
                </div>
            @endif

        </div>
    </div>
</main>

@endsection

@push('scripts')
<script>
    // ── Cart items keyed by proid (same pattern as shop page) ─────
    const cartData = @json(
        $cartItems->groupBy('proid')->map(fn($items) =>
            $items->map(fn($i) => ['cart_id' => $i->cart_id, 'size' => $i->size, 'qty' => $i->qty])
        )
    );

    // ── Toast ─────────────────────────────────────────────────────
    function wlToast(msg, type) {
        const $t = $('#wl-toast');
        $t.text(msg).removeClass('green blue red show').addClass(type + ' show');
        setTimeout(() => $t.removeClass('show'), 3000);
    }

    // ── Remove from Wishlist ──────────────────────────────────────
    $(document).on('click', '.wl-remove', function () {
        const btn    = $(this);
        const rowId  = btn.data('id');
        const proId  = btn.data('proid');

        $.ajax({
            url : "{{ route('wishlist.toggle') }}",
            type: "POST",
            data: { product_id: proId, _token: "{{ csrf_token() }}" },
            success: function (res) {
                if (res.status === 'removed') {
                    $('#wl-row-' + rowId).fadeOut(300, function () {
                        $(this).remove();
                        // Show empty state if no rows left
                        if ($('#wishlist-body tr').length === 0) {
                            location.reload();
                        }
                    });
                    wlToast('🗑️ Removed from wishlist', 'blue');
                }
            },
            error: function () { wlToast('Something went wrong.', 'red'); }
        });
    });

    // ── Open Size Modal ───────────────────────────────────────────
    let wlProductId = null;
    let wlQty       = 1;

    $(document).on('click', '.wl-open-modal', function () {
        wlProductId       = $(this).data('id');
        const productName = $(this).data('name');
        const sizesRaw    = $(this).data('sizes');
        const sizes       = Array.isArray(sizesRaw) ? sizesRaw : JSON.parse(sizesRaw || '[]');

        wlQty = 1;
        $('#wlQtyValue').text(1);
        $('#wlModalName').text(productName);
        $('#wlSizeError').hide();

        // ── Already in Cart section ───────────────────────────────
        const $section = $('#wlAlreadySection');
        const $list    = $('#wlAlreadyList');
        $list.empty();

        const inCart = cartData[wlProductId] || [];
        if (inCart.length > 0) {
            $section.show();
            inCart.forEach(function (item) {
                const label = item.size ? item.size : 'No Size';
                const $tag  = $('<div>').css({
                    display      : 'inline-flex',
                    alignItems   : 'center',
                    gap          : '5px',
                    background   : '#e8f7ef',
                    border       : '1.5px solid #2a9d5c',
                    borderRadius : '7px',
                    padding      : '5px 10px',
                    fontSize     : '13px',
                    fontWeight   : '700',
                    color        : '#1a7a47',
                }).text(label + ' ×' + item.qty);

                const $removeBtn = $('<button>').attr('type', 'button').css({
                    background : 'none',
                    border     : 'none',
                    color      : '#e63946',
                    fontSize   : '15px',
                    cursor     : 'pointer',
                    padding    : '0',
                    lineHeight : '1',
                    fontWeight : '700',
                }).html('&times;')
                  .attr('title', 'Remove from cart')
                  .on('click', function () {
                      wlRemoveFromCart(item.cart_id, wlProductId, $tag);
                  });

                $tag.append($removeBtn);
                $list.append($tag);
            });
        } else {
            $section.hide();
        }

        // ── Size pills ────────────────────────────────────────────
        const $grid = $('#wlSizeOptions');
        $grid.empty();

        if (sizes.length === 0) {
            $grid.html('<p style="color:#aaa;font-size:13px;">No sizes defined.</p>');
        } else {
            sizes.forEach(function (item) {
                const alreadyAdded = inCart.some(c => c.size === item.size);
                const inStock      = item.stock > 0;
                const disabled     = !inStock || alreadyAdded;

                const $pill = $('<div>')
                    .addClass('size-option' + (disabled ? ' oos' : ''))
                    .attr('data-size', item.size)
                    .attr('data-stock', item.stock)
                    .html(item.size + (alreadyAdded
                        ? '<span class="oos-lbl">In Cart</span>'
                        : (!inStock ? '<span class="oos-lbl">Out of Stock</span>' : '')));

                if (disabled) $pill.attr('title', alreadyAdded ? 'Already in cart' : 'Out of stock');
                $grid.append($pill);
            });
        }

        $('#wlSizeModal').modal('show');
    });

    // ── Remove from cart inside modal ─────────────────────────────
    function wlRemoveFromCart(cartId, productId, $tag) {
        $.ajax({
            url : "{{ route('cart.remove') }}",
            type: "POST",
            data: { cart_id: cartId, _token: "{{ csrf_token() }}" },
            success: function (res) {
                if (res.status === 'removed') {
                    $tag.remove();

                    // Update local cartData
                    if (cartData[productId]) {
                        cartData[productId] = cartData[productId].filter(i => i.cart_id !== cartId);
                        if (cartData[productId].length === 0) {
                            delete cartData[productId];
                            $('#wlAlreadySection').hide();
                        }
                    }

                    // Re-enable the size pill if it was marked "In Cart"
                    $('#wlSizeOptions .size-option.oos').each(function () {
                        const $pill   = $(this);
                        const sz      = $pill.attr('data-size');
                        const stillIn = (cartData[productId] || []).some(c => c.size === sz);
                        if (!stillIn && $pill.find('.oos-lbl').text() === 'In Cart') {
                            $pill.removeClass('oos').removeAttr('title').find('.oos-lbl').remove();
                        }
                    });

                    wlToast('🗑️ Removed from cart', 'blue');
                }
            },
            error: function () { wlToast('Could not remove. Try again.', 'red'); }
        });
    }

    // ── Qty stepper ───────────────────────────────────────────────
    $('#wlQtyMinus').on('click', function () {
        if (wlQty > 1) { wlQty--; $('#wlQtyValue').text(wlQty); }
    });
    $('#wlQtyPlus').on('click', function () {
        const stock = parseInt($('#wlSizeOptions .size-option.selected').data('stock') || 99);
        if (wlQty < stock) { wlQty++; $('#wlQtyValue').text(wlQty); }
    });

    // ── Size selection ────────────────────────────────────────────
    $(document).on('click', '#wlSizeOptions .size-option', function () {
        if ($(this).hasClass('oos')) return;
        $('#wlSizeOptions .size-option').removeClass('selected');
        $(this).addClass('selected');
        $('#wlSizeError').hide();
        wlQty = 1; $('#wlQtyValue').text(1);
    });

    // ── Confirm Add to Cart ───────────────────────────────────────
    $('#wlConfirmCart').on('click', function () {
        const $sel        = $('#wlSizeOptions .size-option.selected');
        const selectedSize = $sel.data('size');
        const btn          = $(this);

        if ($('#wlSizeOptions .size-option:not(.oos)').length > 0 && !selectedSize) {
            $('#wlSizeError').show();
            return;
        }

        btn.prop('disabled', true).text('Adding…');

        $.ajax({
            url : "{{ route('cart.add') }}",
            type: "POST",
            data: {
                product_id : wlProductId,
                size       : selectedSize || null,
                qty        : wlQty,
                _token     : "{{ csrf_token() }}"
            },
            success: function (res) {
                $('#wlSizeModal').modal('hide');
                btn.prop('disabled', false).html('🛒 Add to Cart');

                if (res.status === 'added') {
                    if (!cartData[wlProductId]) cartData[wlProductId] = [];
                    cartData[wlProductId].push({
                        cart_id : res.cart_id || null,
                        size    : selectedSize || null,
                        qty     : wlQty,
                    });
                    wlToast('🛒 ' + res.message, 'green');
                }
                else if (res.status === 'updated') wlToast('🔄 ' + res.message, 'blue');
                else if (res.status === 'login')   wlToast('🔒 ' + res.message, 'red');
            },
            error: function () {
                $('#wlSizeModal').modal('hide');
                btn.prop('disabled', false).html('🛒 Add to Cart');
                wlToast('Something went wrong. Please try again.', 'red');
            }
        });
    });
</script>
@endpush