@extends('user.layout')

@section('content')

{{-- REUSABLE PRODUCT CARD MACRO --}}
@php
function productCard($product) {
    $finalPrice = $product->discount_price > 0
        ? $product->price - $product->discount_price
        : $product->price;
    $discountPct = $product->discount_price > 0
        ? round(($product->discount_price / $product->price) * 100)
        : 0;
    return ['finalPrice' => $finalPrice, 'discountPct' => $discountPct];
}
@endphp

<main class="main">

    {{-- ── SLIDER ── --}}
    <div class="intro-slider-container mb-0">
        <div class="intro-slider owl-carousel owl-theme owl-nav-inside owl-light"
             data-toggle="owl"
             data-owl-options='{"nav": false, "dots": false}'>

            <div class="intro-slide"
                 style="background-image: url('{{ asset('user/assets/images/demos/demo-5/slider/slide-1.jpg') }}');">
                <div class="container intro-content text-center">
                    <h3 class="intro-subtitle text-white">Don't Miss</h3>
                    <h1 class="intro-title text-white">Mystery Deals</h1>
                    <div class="intro-text text-white">Online Only</div>
                    <a href="{{ url('user/shop') }}" class="btn btn-primary">Discover NOW</a>
                </div>
            </div>

            <div class="intro-slide"
                 style="background-image: url('{{ asset('user/assets/images/demos/demo-5/slider/slide-2.jpg') }}');">
                <div class="container intro-content text-center">
                    <h3 class="intro-subtitle text-white">Limited time only</h3>
                    <h1 class="intro-title text-white">Treat Yourself</h1>
                    <div class="intro-text text-white">Up to 50% off</div>
                    <a href="{{ url('user/shop') }}" class="btn btn-primary">Shop NOW</a>
                </div>
            </div>

        </div>
        <span class="slider-loader text-white"></span>
    </div>

    {{-- ── FEATURES ── --}}
    <div class="container">
        <div class="row" style="margin-top:50px; margin-bottom:50px;">
            <div class="col-lg-3 col-sm-6">
                <div class="icon-box text-center">
                    <span class="icon-box-icon text-dark"><i class="icon-truck"></i></span>
                    <div class="icon-box-content">
                        <h3 class="icon-box-title">Free Shipping</h3>
                        <p>Shipping charge is completely free</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="icon-box text-center">
                    <span class="icon-box-icon text-dark"><i class="icon-rotate-left"></i></span>
                    <div class="icon-box-content">
                        <h3 class="icon-box-title">No Refund Policy</h3>
                        <p>Products once sold cannot be refunded</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="icon-box text-center">
                    <span class="icon-box-icon text-dark"><i class="icon-lock"></i></span>
                    <div class="icon-box-content">
                        <h3 class="icon-box-title">Secure Payment</h3>
                        <p>100% secure payment</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="icon-box text-center">
                    <span class="icon-box-icon text-dark"><i class="icon-headphones"></i></span>
                    <div class="icon-box-content">
                        <h3 class="icon-box-title">Quality Support</h3>
                        <p>Always online feedback 24/7</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── BANNERS ── --}}
        <div class="banner-group">
            <div class="row">
                <div class="col-md-6">
                    <div class="banner banner-border">
                        <a href="{{ url('user/shop') }}">
                            <img src="{{ asset('user/assets/images/demos/demo-5/banners/banner-1.jpg') }}" alt="Banner">
                        </a>
                        <div class="banner-content">
                            <h4 class="banner-subtitle"><a href="#">New Collection</a></h4>
                            <h3 class="banner-title">
                                <a href="#"><span>Seasonal<br>Essentials</span></a>
                            </h3>
                            <a href="{{ url('user/shop') }}" class="btn btn-outline-primary-2 banner-link">
                                Explore Now <i class="icon-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="banner banner-border-hover">
                        <a href="{{ url('user/shop') }}">
                            <img src="{{ asset('user/assets/images/demos/demo-5/banners/banner-2.jpg') }}" alt="Banner">
                        </a>
                        <div class="banner-content">
                            <h4 class="banner-subtitle"><a href="#">Men's Collection</a></h4>
                            <h3 class="banner-title">
                                <a href="#"><span>Modern & Comfortable<br>Everyday Wear</span></a>
                            </h3>
                            <a href="{{ url('user/shop') }}" class="btn btn-outline-primary-2 banner-link">
                                Shop Collection <i class="icon-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="banner banner-border-hover">
                        <a href="{{ url('user/shop') }}">
                            <img src="{{ asset('user/assets/images/demos/demo-5/banners/banner-3.jpg') }}" alt="Banner">
                        </a>
                        <div class="banner-content">
                            <h4 class="banner-subtitle"><a href="#">Women's Collection</a></h4>
                            <h3 class="banner-title">
                                <a href="#"><span>Elegant & Timeless<br>Fashion Styles</span></a>
                            </h3>
                            <a href="{{ url('user/shop') }}" class="btn btn-outline-primary-2 banner-link">
                                Discover Styles <i class="icon-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-4"></div>

    {{-- ── TRENDY PRODUCTS ── --}}
    <div class="container">
        <div class="heading heading-center mb-3">
            <h2 class="title">Trendy Products</h2>
            <ul class="nav nav-pills justify-content-center" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#trendy-all-tab" role="tab">All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#trendy-women-tab" role="tab">Women</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#trendy-men-tab" role="tab">Men</a>
                </li>
                
            </ul>
        </div>

        <div class="tab-content tab-content-carousel">

            {{-- ALL --}}
            <div class="tab-pane p-0 fade show active" id="trendy-all-tab" role="tabpanel">
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow"
                     data-toggle="owl"
                     data-owl-options='{
                         "nav":false,"dots":true,"margin":20,"loop":false,
                         "responsive":{
                             "0":{"items":2},"480":{"items":2},
                             "768":{"items":3},"992":{"items":4},
                             "1200":{"items":4,"nav":true}
                         }
                     }'>
                    @forelse($trendyAll as $product)
                        @php
                            $finalPrice  = $product->discount_price > 0 ? $product->price - $product->discount_price : $product->price;
                            $discountPct = $product->discount_price > 0 ? round(($product->discount_price / $product->price) * 100) : 0;
                        @endphp
                        <div class="product product-2">
                            <figure class="product-media">
                                @if($discountPct > 0)
                                    <span class="product-label label-sale">-{{ $discountPct }}%</span>
                                @endif
                                <a href="{{ route('user.single', $product->proid) }}">
                                    <img src="{{ asset('admin/assets/images/' . $product->proimage) }}"
                                         alt="{{ $product->proname }}"
                                         class="product-image"
                                         style="height:280px; object-fit:cover;">
                                </a>
                                <div class="product-action product-action-transparent">
                                    <a href="{{ route('user.single', $product->proid) }}"
                                       class="btn-product btn-cart">
                                        <span>view product</span>
                                    </a>
                                </div>
                            </figure>
                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">{{ $product->category->name ?? '' }}</a>
                                </div>
                                <h3 class="product-title">
                                    <a href="{{ route('user.single', $product->proid) }}">
                                        {{ $product->proname }}
                                    </a>
                                </h3>
                                <div class="product-price">
                                    @if($product->discount_price > 0)
                                        <span class="new-price">₹{{ number_format($finalPrice, 2) }}</span>
                                        <span class="old-price">₹{{ number_format($product->price, 2) }}</span>
                                    @else
                                        ₹{{ number_format($finalPrice, 2) }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">No products found.</p>
                    @endforelse
                </div>
            </div>

            {{-- WOMEN --}}
            <div class="tab-pane p-0 fade" id="trendy-women-tab" role="tabpanel">
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow"
                     data-toggle="owl"
                     data-owl-options='{
                         "nav":false,"dots":true,"margin":20,"loop":false,
                         "responsive":{
                             "0":{"items":2},"480":{"items":2},
                             "768":{"items":3},"992":{"items":4},
                             "1200":{"items":4,"nav":true}
                         }
                     }'>
                    @forelse($trendyWomen as $product)
                        @php
                            $finalPrice  = $product->discount_price > 0 ? $product->price - $product->discount_price : $product->price;
                            $discountPct = $product->discount_price > 0 ? round(($product->discount_price / $product->price) * 100) : 0;
                        @endphp
                        <div class="product product-2">
                            <figure class="product-media">
                                @if($discountPct > 0)
                                    <span class="product-label label-sale">-{{ $discountPct }}%</span>
                                @endif
                                <a href="{{ route('user.single', $product->proid) }}">
                                    <img src="{{ asset('admin/assets/images/' . $product->proimage) }}"
                                         alt="{{ $product->proname }}"
                                         class="product-image"
                                         style="height:280px; object-fit:cover;">
                                </a>
                                <div class="product-action product-action-transparent">
                                    <a href="{{ route('user.single', $product->proid) }}"
                                       class="btn-product btn-cart">
                                        <span>view product</span>
                                    </a>
                                </div>
                            </figure>
                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">{{ $product->category->name ?? '' }}</a>
                                </div>
                                <h3 class="product-title">
                                    <a href="{{ route('user.single', $product->proid) }}">
                                        {{ $product->proname }}
                                    </a>
                                </h3>
                                <div class="product-price">
                                    @if($product->discount_price > 0)
                                        <span class="new-price">₹{{ number_format($finalPrice, 2) }}</span>
                                        <span class="old-price">₹{{ number_format($product->price, 2) }}</span>
                                    @else
                                        ₹{{ number_format($finalPrice, 2) }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted p-3">No products found.</p>
                    @endforelse
                </div>
            </div>

            {{-- MEN --}}
            <div class="tab-pane p-0 fade" id="trendy-men-tab" role="tabpanel">
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow"
                     data-toggle="owl"
                     data-owl-options='{
                         "nav":false,"dots":true,"margin":20,"loop":false,
                         "responsive":{
                             "0":{"items":2},"480":{"items":2},
                             "768":{"items":3},"992":{"items":4},
                             "1200":{"items":4,"nav":true}
                         }
                     }'>
                    @forelse($trendyMen as $product)
                        @php
                            $finalPrice  = $product->discount_price > 0 ? $product->price - $product->discount_price : $product->price;
                            $discountPct = $product->discount_price > 0 ? round(($product->discount_price / $product->price) * 100) : 0;
                        @endphp
                        <div class="product product-2">
                            <figure class="product-media">
                                @if($discountPct > 0)
                                    <span class="product-label label-sale">-{{ $discountPct }}%</span>
                                @endif
                                <a href="{{ route('user.single', $product->proid) }}">
                                    <img src="{{ asset('admin/assets/images/' . $product->proimage) }}"
                                         alt="{{ $product->proname }}"
                                         class="product-image"
                                         style="height:280px; object-fit:cover;">
                                </a>
                                <div class="product-action product-action-transparent">
                                    <a href="{{ route('user.single', $product->proid) }}"
                                       class="btn-product btn-cart">
                                        <span>view product</span>
                                    </a>
                                </div>
                            </figure>
                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="#">{{ $product->category->name ?? '' }}</a>
                                </div>
                                <h3 class="product-title">
                                    <a href="{{ route('user.single', $product->proid) }}">
                                        {{ $product->proname }}
                                    </a>
                                </h3>
                                <div class="product-price">
                                    @if($product->discount_price > 0)
                                        <span class="new-price">₹{{ number_format($finalPrice, 2) }}</span>
                                        <span class="old-price">₹{{ number_format($product->price, 2) }}</span>
                                    @else
                                        ₹{{ number_format($finalPrice, 2) }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted p-3">No products found.</p>
                    @endforelse
                </div>
            </div>

            {{-- ACCESSORIES --}}
            <div class="tab-pane p-0 fade" id="trendy-access-tab" role="tabpanel">
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow"
                     data-toggle="owl"
                     data-owl-options='{
                         "nav":false,"dots":true,"margin":20,"loop":false,
                         "responsive":{
                             "0":{"items":2},"480":{"items":2},
                             "768":{"items":3},"992":{"items":4},
                             "1200":{"items":4,"nav":true}
                         }
                     }'>
                    
                </div>
            </div>

        </div>
    </div>

    <div class="mb-5"></div>

    {{-- ── SPECIAL BANNER SECTION ── --}}
    <div class="pt-6 pb-6" style="background-color:#fff;">
        <div class="container">
            <div class="banner-set">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="banner-set-content text-center">
                            <div class="set-content-wrapper">
                                <h4>Special</h4>
                                <h2>Refine Your Style.</h2>
                                <p>Get on our exclusive email list and be the first to hear about sales, coupons, new arrivals and more!</p>
                                <div class="banner-set-products">
                                    <div class="row">
                                        <div class="products">
                                            @foreach($newAll->take(2) as $sp)
                                                @php $spPrice = $sp->discount_price > 0 ? $sp->price - $sp->discount_price : $sp->price; @endphp
                                                <div class="col-6">
                                                    <div class="product product-2 text-center">
                                                        <figure class="product-media">
                                                            <a href="{{ route('user.single', $sp->proid) }}">
                                                                <img src="{{ asset('admin/assets/images/' . $sp->proimage) }}"
                                                                     alt="{{ $sp->proname }}"
                                                                     class="product-image"
                                                                     style="height:180px;object-fit:cover;">
                                                            </a>
                                                        </figure>
                                                        <div class="product-body">
                                                            <h3 class="product-title">
                                                                <a href="{{ route('user.single', $sp->proid) }}">
                                                                    {{ $sp->proname }}
                                                                </a>
                                                            </h3>
                                                            <div class="product-price">
                                                                ₹{{ number_format($spPrice, 2) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="banner-set-image banner-border-hover">
                            <a href="{{ url('user/shop') }}">
                                <img src="{{ asset('user/assets/images/demos/demo-5/banners/banner-4.jpg') }}" alt="banner">
                            </a>
                            <div class="banner-content">
                                <h3 class="banner-title">
                                    <a href="#"><span>Casual basics and<br>trendy key pieces.</span></a>
                                </h3>
                                <h4 class="banner-subtitle">in this look</h4>
                                <a href="{{ url('user/shop') }}" class="btn btn-outline-primary-2 banner-link">
                                    shop now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── NEW ARRIVALS ── --}}
    

    <div class="mb-2"></div>

    {{-- ── CTA SECTION ── --}}
    <div class="container">
        <div class="cta cta-separator mb-5">
            <div class="row">
                <div class="col-lg-6">
                    <div class="cta-wrapper cta-text text-center">
                        <h3 class="cta-title">Shop Social</h3>
                        <p class="cta-desc">Follow us on social media for the latest trends and offers.</p>
                        <div class="social-icons social-icons-colored justify-content-center">
                            <a href="#" class="social-icon social-facebook" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                            <a href="#" class="social-icon social-twitter" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                            <a href="#" class="social-icon social-instagram" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                            <a href="#" class="social-icon social-youtube" title="Youtube" target="_blank"><i class="icon-youtube"></i></a>
                            <a href="#" class="social-icon social-pinterest" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="cta-wrapper text-center">
                        <h3 class="cta-title">Get the Latest Deals</h3>
                        <p class="cta-desc">and receive <span class="text-primary">₹200 coupon</span> for first shopping</p>
                        <form action="#">
                            <div class="input-group">
                                <input type="email" class="form-control"
                                       placeholder="Enter your Email Address" required>
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-rounded" type="submit">
                                        <i class="icon-long-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── INSTAGRAM FEED ── --}}
    <div class="bg-lighter pt-7 pb-4" style="background-color:#fafafa;">
        <div class="container">
            <div class="instagram-feed-container">
                <div class="row">
                    @foreach(range(1,9) as $i)
                        @if($i == 3)
                            <div class="feed-col feed-col-title">
                                <div class="instagram-feed-title">
                                    <i class="icon-instagram"></i>
                                    <p>@StyleStudio<br>on instagram</p>
                                    <a href="#">FOLLOW</a>
                                </div>
                            </div>
                        @endif
                        <div class="feed-col">
                            <div class="instagram-feed">
                                <img src="{{ asset('user/assets/images/demos/demo-5/instagram/' . $i . '.jpg') }}"
                                     alt="instagram {{ $i }}">
                                <div class="instagram-feed-content">
                                    <a href="#"><i class="icon-heart-o"></i>{{ rand(50,600) }}</a>
                                    <a href="#"><i class="icon-comments"></i>{{ rand(10,99) }}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</main>

@endsection