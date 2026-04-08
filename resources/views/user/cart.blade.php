@extends('user.layout')

@section('content')
<style>
    .old-price {
        color: #aaa;
        font-size: 13px;
        text-decoration: line-through;
        margin-left: 5px;
    }
    #toast-msg {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        padding: 12px 20px;
        border-radius: 6px;
        font-size: 14px;
        color: #fff;
        transition: all 0.3s ease;
    }
    .qty-input:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>

<main class="main">
    <div class="page-header text-center">
        <div class="container" style="padding-top: 80px;">
            <h1 class="page-title">Shopping Cart<span></span></h1>
        </div>
    </div>

    <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
        <div class="container"></div>
    </nav>

    <div class="page-content">
        <div class="cart">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <table class="table table-cart table-mobile">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $subtotal = 0;
                                    $d = 0;
                                @endphp

                                @forelse($cart as $c)
                                @php
                                    if ($c->product->discount_price && $c->product->discount_price > 0) {
                                        $f = $c->product->price - $c->product->discount_price;
                                    } else {
                                        $f = $c->product->price;
                                    }
                                    $total     = $f * $c->qty;
                                    $subtotal += $c->product->price * $c->qty;
                                    $d        += ($c->product->discount_price ?? 0) * $c->qty;
                                @endphp

                                <tr data-cart-id="{{ $c->cart_id }}">
                                    <td class="product-col">
                                        <div class="product">
                                            <figure class="product-media">
                                                <a href="#">
                                                    <img src="{{ asset('admin/assets/images/'.$c->product->proimage) }}"
                                                         width="100px" height="100px" alt="">
                                                </a>
                                            </figure>
                                            <h3 class="product-title">
                                                <a href="#">{{ $c->product->proname }}<br>
                                                    Size:- <span>{{ $c->size }}</span>
                                                </a>
                                            </h3>
                                        </div>
                                    </td>

                                    <td class="price-col">
                                        ₹{{ number_format($f, 2) }}<br>
                                        @if($c->product->discount_price && $c->product->discount_price > 0)
                                            <span class="old-price">₹{{ number_format($c->product->price, 2) }}</span>
                                        @endif
                                    </td>

                                    <td class="quantity-col">
                                        <div class="cart-product-quantity">
                                            <input type="number"
                                                   class="form-control qty-input"
                                                   value="{{ $c->qty }}"
                                                   min="1"
                                                   max="{{ $c->selected_size->stock + $c->qty }}"
                                                   step="1"
                                                   data-cart-id="{{ $c->cart_id }}"
                                                   data-original="{{ $c->qty }}">
                                        </div>
                                    </td>

                                    <td class="total-col row-total">₹{{ number_format($total, 2) }}</td>

                                    <td class="remove-col">
                                        <a href="{{ url('cart/remove', $c->cart_id) }}" class="btn-remove">
                                            <i class="icon-close"></i>
                                        </a>
                                    </td>
                                </tr>

                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        Your cart is empty. <a href="{{ url('/') }}">Continue Shopping</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="cart-bottom">
                            <a href="{{ url('user/shop') }}" class="btn btn-outline-dark-2">
                                <span>CONTINUE SHOPPING</span>
                            </a>
                        </div>
                    </div>

                    <aside class="col-lg-3">
                        <div class="summary summary-cart">
                            <h3 class="summary-title">Cart Total</h3>

                            <table class="table table-summary">
                                <tbody>
                                    <tr class="summary-subtotal">
                                        <td>Subtotal:</td>
                                        <td id="cart-subtotal">₹{{ number_format($subtotal, 2) }}</td>
                                    </tr>
                                    <tr class="summary-shipping">
                                        <td>Discount:</td>
                                        <td id="cart-discount">₹{{ number_format($d, 2) }}</td>
                                    </tr>
                                    <tr style="border-top: 1px gray solid;" class="summary-total">
                                        <td>Total:</td>
                                        <td id="cart-total">₹{{ number_format($subtotal - $d, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
							@if($subtotal>0)
                            <a href="{{ url('user/checkout') }}"
                               class="btn btn-outline-primary-2 btn-order btn-block">
                               PROCEED TO CHECKOUT
                            </a>
							@endif
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</main>

{{-- Toast --}}
<div id="toast-msg"></div>

<script>
    document.querySelectorAll('.qty-input').forEach(function(input) {
        // On arrow click or manual change
        input.addEventListener('change', function() {
            updateCart(this);
        });

        // On Enter key press
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                updateCart(this);
            }
        });
    });

    function updateCart(input) {
        const cartId   = input.getAttribute('data-cart-id');
        const qty      = parseInt(input.value);
        const max      = parseInt(input.getAttribute('max'));
        const original = parseInt(input.getAttribute('data-original'));

        // Client-side validation
        if (isNaN(qty) || qty < 1) {
            showToast('Quantity must be at least 1', 'error');
            input.value = original;
            return;
        }

        if (qty > max) {
            showToast('Only ' + max + ' items available in stock', 'error');
            input.value = max;
            return;
        }

        // Same value - no need to update
        if (qty === original) return;

        // Disable input while request is processing
        input.disabled = true;

        fetch('{{ url("cart/update-qty") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ cart_id: cartId, qty: qty })
        })
        .then(res => res.json())
        .then(data => {
            input.disabled = false;

            if (data.status === 'success') {
                // Update row total
                const row = document.querySelector('tr[data-cart-id="' + cartId + '"]');
                row.querySelector('.row-total').innerText = data.row_total;

                // Update summary totals
                document.getElementById('cart-subtotal').innerText = data.subtotal;
                document.getElementById('cart-discount').innerText = data.discount;
                document.getElementById('cart-total').innerText    = data.total;

                // Update stored original value
                input.setAttribute('data-original', qty);

                showToast('Cart updated successfully!', 'success');

            } else if (data.status === 'error') {
                showToast(data.message, 'error');
                input.value = original;

            } else if (data.status === 'login') {
                window.location.href = '{{ url("login") }}';
            }
        })
        .catch(function() {
            input.disabled = false;
            input.value = original;
            showToast('Something went wrong. Please try again.', 'error');
        });
    }

    function showToast(message, type) {
        const toast = document.getElementById('toast-msg');
        toast.innerText        = message;
        toast.style.background = type === 'success' ? '#28a745' : '#dc3545';
        toast.style.display    = 'block';
        setTimeout(function() {
            toast.style.display = 'none';
        }, 3000);
    }
</script>

@endsection