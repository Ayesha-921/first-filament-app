<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | MyShop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #fff; color: #0F1111; font-size: 14px; }
        a { color: #007185; text-decoration: none; }
        a:hover { color: #C7511F; text-decoration: underline; }

        /* Nav */
        .nav-top { background: #131921; color: #fff; padding: 8px 16px; display: flex; align-items: center; gap: 12px; }
        .nav-logo { font-size: 22px; font-weight: 900; color: #FF9900; letter-spacing: -1px; margin-right: 8px; }
        .nav-search { flex: 1; display: flex; max-width: 700px; }
        .nav-search input { flex: 1; padding: 8px 12px; font-size: 14px; border: none; outline: none; border-radius: 4px 0 0 4px; }
        .nav-search button { background: #FF9900; border: none; padding: 0 14px; cursor: pointer; border-radius: 0 4px 4px 0; font-size: 16px; }
        .nav-search button:hover { background: #e88b00; }
        .nav-links { display: flex; gap: 16px; font-size: 13px; color: #ccc; flex-wrap: wrap; }

        /* Breadcrumb */
        .breadcrumb { padding: 8px 24px; font-size: 13px; color: #555; border-bottom: 1px solid #ddd; background: #fff; }
        .breadcrumb a { color: #007185; }
        .breadcrumb span { color: #555; margin: 0 4px; }

        /* Category strip */
        .cat-strip { background: #232F3E; color: #fff; padding: 6px 16px; font-size: 13px; display: flex; gap: 20px; overflow-x: auto; white-space: nowrap; }
        .cat-strip a { color: #fff; font-size: 13px; }
        .cat-strip a:hover { color: #FF9900; text-decoration: none; }

        /* Main */
        .product-page { max-width: 1200px; margin: 0 auto; padding: 20px 16px; display: flex; gap: 24px; align-items: flex-start; }

        /* LEFT: gallery */
        .gallery { display: flex; gap: 10px; width: 420px; flex-shrink: 0; }
        .thumbs { display: flex; flex-direction: column; gap: 6px; width: 52px; }
        .thumb { width: 50px; height: 50px; border: 1px solid #ddd; border-radius: 4px; overflow: hidden; cursor: pointer; padding: 2px; }
        .thumb img { width: 100%; height: 100%; object-fit: contain; }
        .thumb:hover, .thumb.active { border: 2px solid #e77600; }
        .main-img-wrap { flex: 1; border: 1px solid #ddd; border-radius: 4px; padding: 10px; display: flex; align-items: center; justify-content: center; min-height: 360px; background: #fff; }
        .main-img-wrap img { max-height: 380px; max-width: 100%; object-fit: contain; }

        /* MIDDLE: info */
        .product-info { flex: 1; min-width: 0; }
        .product-title { font-size: 20px; font-weight: 400; line-height: 1.4; margin-bottom: 6px; color: #0F1111; }
        .brand-link { font-size: 13px; }
        .brand-link a { color: #007185; }
        .rating-row { display: flex; align-items: center; gap: 8px; margin: 6px 0 10px; }
        .stars { color: #FF9900; font-size: 15px; letter-spacing: -1px; }
        .rating-count { color: #007185; font-size: 13px; cursor: pointer; }
        .divider { border: none; border-top: 1px solid #e7e7e7; margin: 10px 0; }
        .price-block { margin: 10px 0 14px; }
        .price-block .currency { font-size: 14px; vertical-align: top; margin-top: 4px; display: inline-block; }
        .price-block .whole { font-size: 34px; font-weight: 300; line-height: 1; }
        .price-block .fraction { font-size: 14px; vertical-align: top; margin-top: 4px; display: inline-block; }
        .delivery-line { color: #0F1111; font-size: 14px; margin: 4px 0; }
        .delivery-line .green { color: #007600; font-weight: 700; }
        .stock-line { font-size: 16px; font-weight: 700; margin: 10px 0 6px; }
        .stock-line.in { color: #007600; }
        .stock-line.low { color: #C7511F; }
        .stock-line.out { color: #CC0C39; }

        /* Short description */
        .short-desc { font-size: 14px; line-height: 1.7; color: #0F1111; margin: 10px 0; }
        .short-desc ul { list-style: disc; padding-left: 18px; }
        .short-desc li { margin: 3px 0; }
        .short-desc strong { font-weight: 700; }
        .short-desc em { font-style: italic; }

        /* About this item */
        .about-section { margin-top: 20px; padding-top: 14px; border-top: 1px solid #e7e7e7; }
        .about-section h3 { font-size: 18px; font-weight: 700; margin-bottom: 10px; }
        .about-section .content { font-size: 14px; line-height: 1.75; color: #0F1111; }
        .about-section .content ul { list-style: disc; padding-left: 20px; }
        .about-section .content li { margin: 5px 0; }
        .about-section .content h2 { font-size: 17px; font-weight: 700; margin: 14px 0 6px; }
        .about-section .content h3 { font-size: 15px; font-weight: 700; margin: 12px 0 5px; }
        .about-section .content h4 { font-size: 14px; font-weight: 700; margin: 10px 0 4px; }
        .about-section .content strong { font-weight: 700; }
        .about-section .content em { font-style: italic; }
        .about-section .content p { margin: 6px 0; }

        /* RIGHT: buy box */
        .buy-box { width: 220px; flex-shrink: 0; border: 1px solid #D5D9D9; border-radius: 8px; padding: 16px; background: #fff; }
        .buy-price .currency { font-size: 13px; vertical-align: top; margin-top: 4px; display: inline-block; }
        .buy-price .whole { font-size: 26px; font-weight: 300; line-height: 1; }
        .buy-price .fraction { font-size: 13px; vertical-align: top; margin-top: 4px; display: inline-block; }
        .buy-delivery { color: #007600; font-size: 13px; font-weight: 700; margin: 6px 0 2px; }
        .buy-delivery-sub { font-size: 12px; color: #0F1111; margin-bottom: 8px; }
        .buy-stock { font-size: 16px; font-weight: 700; color: #007600; margin: 8px 0; }
        .buy-stock.low { color: #C7511F; }
        .qty-wrap { margin: 10px 0; }
        .qty-wrap label { font-size: 13px; font-weight: 700; display: block; margin-bottom: 4px; }
        .qty-select { width: 100%; padding: 6px 8px; border: 1px solid #888; border-radius: 6px; font-size: 13px; background: #f7f8f8; cursor: pointer; }
        .btn-cart { display: block; width: 100%; padding: 9px 0; background: #FFD814; border: 1px solid #FCD200; border-radius: 20px; font-size: 13px; font-weight: 400; text-align: center; cursor: pointer; margin: 8px 0 6px; color: #0F1111; }
        .btn-cart:hover { background: #F7CA00; }
        .btn-buy { display: block; width: 100%; padding: 9px 0; background: #FFA41C; border: 1px solid #FF8F00; border-radius: 20px; font-size: 13px; text-align: center; cursor: pointer; color: #0F1111; }
        .btn-buy:hover { background: #FF8F00; }
        .buy-meta { font-size: 12px; margin-top: 12px; line-height: 2; }
        .buy-meta .label { color: #555; }
        .buy-meta .value { color: #007185; margin-left: 4px; }

        /* Responsive */
        @media (max-width: 900px) {
            .product-page { flex-direction: column; }
            .gallery { width: 100%; }
            .buy-box { width: 100%; }
        }
    </style>
</head>
<body>

@php
    $images = collect($product->images ?? [])
        ->filter()
        ->map(fn($img) => \Illuminate\Support\Facades\Storage::url($img))
        ->values();
    if ($images->isEmpty() && $product->image) {
        $images = collect([\Illuminate\Support\Facades\Storage::url($product->image)]);
    }
    $hasImages = $images->isNotEmpty();
    $whole    = number_format((int) $product->price, 0);
    $fraction = str_pad((int) round(($product->price - floor($product->price)) * 100), 2, '0', STR_PAD_LEFT);
@endphp

{{-- ===== TOP NAV ===== --}}
<div class="nav-top">
    <a href="{{ route('products.index') }}" class="nav-logo" style="color:#FF9900;text-decoration:none;">MyShop</a>
    <div class="nav-search">
        <input type="text" placeholder="Search products..." />
        <button>🔍</button>
    </div>
    <div class="nav-links" style="margin-left:auto;">
        <span>Hello, Sign in</span>
        <span>Returns &amp; Orders</span>
        <span>🛒 Cart</span>
    </div>
</div>

{{-- ===== CATEGORY STRIP ===== --}}
<div class="cat-strip">
    <a href="{{ route('products.index') }}">☰ All</a>
    <a href="{{ route('products.index') }}">Today's Deals</a>
    <a href="{{ route('products.index') }}">Electronics</a>
    <a href="{{ route('products.index') }}">New Arrivals</a>
    <a href="{{ route('products.index') }}">Best Sellers</a>
    @if($product->category)
        <a href="{{ route('products.index') }}" style="color:#FF9900;">{{ $product->category->name }}</a>
    @endif
</div>

{{-- ===== BREADCRUMB ===== --}}
<div class="breadcrumb">
    <a href="{{ route('products.index') }}">Home</a>
    @if($product->category)
        <span>›</span>
        <a href="{{ route('products.index') }}">{{ $product->category->name }}</a>
    @endif
    <span>›</span>
    <span style="color:#0F1111;">{{ \Illuminate\Support\Str::limit($product->name, 70) }}</span>
</div>

{{-- ===== MAIN PRODUCT PAGE ===== --}}
<div class="product-page">

    {{-- ===== LEFT: Image Gallery ===== --}}
    <div class="gallery">
        {{-- Thumbnails --}}
        @if($hasImages)
        <div class="thumbs" id="thumbs">
            @foreach($images as $i => $img)
                <div class="thumb {{ $i === 0 ? 'active' : '' }}" onclick="switchImg('{{ $img }}', this)">
                    <img src="{{ $img }}" alt="thumb {{ $i+1 }}" />
                </div>
            @endforeach
        </div>
        @endif

        {{-- Main image --}}
        <div class="main-img-wrap">
            @if($hasImages)
                <img id="mainImg" src="{{ $images->first() }}" alt="{{ $product->name }}" />
            @else
                <div style="font-size:80px;color:#ccc;text-align:center;">📦</div>
            @endif
        </div>
    </div>

    {{-- ===== MIDDLE: Product Info ===== --}}
    <div class="product-info">

        {{-- Title --}}
        <h1 class="product-title">{{ $product->name }}</h1>

        {{-- Brand --}}
        @if($product->brand)
            <div class="brand-link">
                Brand: <a href="#">{{ $product->brand->name }}</a>
            </div>
        @endif

        {{-- Rating --}}
        <div class="rating-row">
            <span class="stars">★★★★☆</span>
            <a href="#" class="rating-count">3.3</a>
            <a href="#" class="rating-count">(14 ratings)</a>
            @if($product->sku)
                <span style="color:#555;font-size:12px;margin-left:8px;">SKU: {{ $product->sku }}</span>
            @endif
        </div>

        <hr class="divider">

        {{-- Price --}}
        <div class="price-block">
            <span class="currency">$</span><span class="whole">{{ $whole }}</span><span class="fraction">{{ $fraction }}</span>
        </div>

        {{-- Delivery --}}
        <div class="delivery-line">
            <span class="green">FREE delivery</span> Mon, May 4 – Wed, Jun 6
        </div>
        <div class="delivery-line" style="margin-top:4px;color:#555;">
            📍 Deliver to your location
        </div>

        <hr class="divider">

        {{-- Short description --}}
        @if($product->short_description)
            <div class="short-desc">{!! $product->short_description !!}</div>
            <hr class="divider">
        @endif

        {{-- Stock --}}
        @if($product->stock > 10)
            <div class="stock-line in">In Stock</div>
        @elseif($product->stock > 0)
            <div class="stock-line low">Only {{ $product->stock }} left in stock – order soon</div>
        @else
            <div class="stock-line out">Currently unavailable</div>
        @endif

        {{-- About this item (long description) --}}
        @if($product->long_description)
            <div class="about-section">
                <h3>About this item</h3>
                <div class="content">{!! $product->long_description !!}</div>
            </div>
        @endif

    </div>

    {{-- ===== RIGHT: Buy Box ===== --}}
    <div class="buy-box">

        {{-- Price --}}
        <div class="buy-price">
            <span class="currency">$</span><span class="whole">{{ $whole }}</span><span class="fraction">{{ $fraction }}</span>
        </div>

        {{-- Delivery --}}
        <div class="buy-delivery">FREE delivery</div>
        <div class="buy-delivery-sub">Mon, May 4 – Wed, Jun 6</div>
        <div style="font-size:12px;color:#007185;margin-bottom:8px;">📍 Deliver to your location</div>

        {{-- Stock --}}
        @if($product->stock > 10)
            <div class="buy-stock">In Stock</div>
        @elseif($product->stock > 0)
            <div class="buy-stock low">Only {{ $product->stock }} left</div>
        @endif

        @if($product->stock > 0)
            {{-- Quantity --}}
            <div class="qty-wrap">
                <label>Quantity:</label>
                <select class="qty-select">
                    @for($q = 1; $q <= min($product->stock, 10); $q++)
                        <option value="{{ $q }}">{{ $q }}</option>
                    @endfor
                </select>
            </div>

            <button class="btn-cart">Add to Cart</button>
            <button class="btn-buy">Buy Now</button>
        @else
            <div style="color:#CC0C39;font-size:14px;font-weight:700;margin:12px 0;">Currently unavailable</div>
        @endif

        <hr style="border:none;border-top:1px solid #e7e7e7;margin:12px 0;">

        {{-- Seller info --}}
        <div class="buy-meta">
            <div><span class="label">Ships from</span><span class="value">MyShop</span></div>
            @if($product->brand)
                <div><span class="label">Sold by</span><span class="value">{{ $product->brand->name }}</span></div>
            @endif
            <div><span class="label">Returns</span><span class="value">30-day refund / replacement</span></div>
            <div><span class="label">Support</span><span class="value">Product support included</span></div>
        </div>
    </div>

</div>{{-- end product-page --}}

<script>
function switchImg(src, el) {
    document.getElementById('mainImg').src = src;
    document.querySelectorAll('#thumbs .thumb').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}
</script>
</body>
</html>
