@extends('user.layout')

@section('content')

<style>
    .category-hero {
        background: linear-gradient(135deg, #1a1a1a 0%, #3a3a3a 100%);
        padding: 60px 0 40px;
        text-align: center;
        color: #fff;
    }
    .category-hero h1 {
        font-size: 38px;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 10px;
    }
    .category-hero p {
        font-size: 15px;
        opacity: 0.7;
        margin: 0;
    }

    .cat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 28px;
        padding: 50px 0;
    }

    .cat-card {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        cursor: pointer;
        text-decoration: none;
        display: block;
        box-shadow: 0 4px 20px rgba(0,0,0,0.10);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #111;
    }

    .cat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(0,0,0,0.18);
        text-decoration: none;
    }

    .cat-card img {
        width: 100%;
        height: 260px;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease, filter 0.4s ease;
        filter: brightness(0.78);
    }

    .cat-card:hover img {
        transform: scale(1.07);
        filter: brightness(0.60);
    }

    .cat-card-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.72) 0%, rgba(0,0,0,0.10) 60%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 22px 20px;
        transition: background 0.3s ease;
    }

    .cat-card:hover .cat-card-overlay {
        background: linear-gradient(to top, rgba(0,0,0,0.82) 0%, rgba(0,0,0,0.20) 60%);
    }

    .cat-card-name {
        color: #fff;
        font-size: 20px;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin: 0 0 6px;
        line-height: 1.2;
    }

    .cat-card-count {
        color: rgba(255,255,255,0.75);
        font-size: 13px;
        font-weight: 500;
        margin: 0 0 12px;
    }

    .cat-card-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fff;
        color: #1a1a1a;
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 8px 16px;
        border-radius: 30px;
        width: fit-content;
        transition: background 0.25s ease, color 0.25s ease;
    }

    .cat-card:hover .cat-card-btn {
        background: #e63946;
        color: #fff;
    }

    /* No image fallback */
    .cat-card-placeholder {
        width: 100%;
        height: 260px;
        background: linear-gradient(135deg, #e0e0e0, #f5f5f5);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 52px;
    }

    /* Breadcrumb */
    .breadcrumb-nav { background: #f8f8f8; border-bottom: 1px solid #eee; }
    .breadcrumb     { margin: 0; padding: 12px 0; background: transparent; }
</style>

<main class="main">

    {{-- ── Hero ── --}}
    <div class="category-hero">
        <h1>Shop by Category</h1>
        <p>Explore our {{ $categories->count() }} collections and find your style</p>
    </div>

    {{-- ── Breadcrumb ── --}}
    <nav class="breadcrumb-nav">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Categories</li>
            </ol>
        </div>
    </nav>

    {{-- ── Category Grid ── --}}
    <div class="container">
        @if($categories->count())
            <div class="cat-grid">
                @foreach($categories as $c)
                    <a href="{{ route('user.category', $c->slug) }}" class="cat-card">

                        {{-- Image or placeholder --}}
                        @if($c->image)
                            <img src="{{ asset('admin/assets/images/' . $c->image) }}"
                                 alt="{{ $c->name }}">
                        @else
                            <div class="cat-card-placeholder">👗</div>
                        @endif

                        {{-- Overlay --}}
                        <div class="cat-card-overlay">
                            <h3 class="cat-card-name">{{ $c->name }}</h3>
                            <p class="cat-card-count">
                                {{ $c->product_count }} {{ Str::plural('Product', $c->product_count) }}
                            </p>
                            <span class="cat-card-btn">
                                Shop Now <i class="icon-long-arrow-right"></i>
                            </span>
                        </div>

                    </a>
                @endforeach
            </div>
        @else
            <div style="text-align:center; padding:100px 20px;">
                <span style="font-size:52px;">😢</span>
                <h2 style="margin-top:16px; font-weight:700;">No Categories Found</h2>
                <p style="color:#999;">Check back soon for new collections.</p>
                <a href="{{ url('/') }}" class="btn btn-primary mt-3">Go Home</a>
            </div>
        @endif
    </div>

</main>

@endsection