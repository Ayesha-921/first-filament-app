@extends('store.layout')
@section('title', $product->name . ' — MyShop')

@section('head')
<style>
    .product-page { max-width: 1200px; margin: 0 auto; padding: 20px 16px; display: flex; gap: 24px; align-items: flex-start; }

    /* Gallery */
    .gallery { display: flex; gap: 10px; width: 420px; flex-shrink: 0; }
    .thumbs { display: flex; flex-direction: column; gap: 6px; width: 54px; }
    .thumb { width: 52px; height: 52px; border: 1px solid #ddd; border-radius: 4px; overflow: hidden; cursor: pointer; padding: 2px; background: #fff; }
    .thumb img { width: 100%; height: 100%; object-fit: contain; }
    .thumb:hover, .thumb.active { border: 2px solid #e77600; }
    .main-img-wrap { flex: 1; border: 1px solid #ddd; border-radius: 4px; padding: 12px; display: flex; align-items: center; justify-content: center; min-height: 380px; background: #fff; }
    .main-img-wrap img { max-height: 400px; max-width: 100%; object-fit: contain; }

    /* Info */
    .product-info { flex: 1; min-width: 0; }
    .product-title { font-size: 20px; font-weight: 400; line-height: 1.4; margin-bottom: 6px; }
    .brand-link { font-size: 13px; margin-bottom: 6px; }
    .brand-link a { color: #007185; }
    .rating-row { display: flex; align-items: center; gap: 8px; margin: 6px 0 12px; font-size: 13px; }
    .stars { color: #FF9900; font-size: 15px; }
    .rating-link { color: #007185; cursor: pointer; }
    .divider { border: none; border-top: 1px solid #e7e7e7; margin: 12px 0; }
    .price-block { margin: 10px 0; }
    .price-block .currency { font-size: 14px; vertical-align: top; margin-top: 4px; display: inline-block; }
    .price-block .whole { font-size: 36px; font-weight: 300; line-height: 1; }
    .price-block .fraction { font-size: 14px; vertical-align: top; margin-top: 4px; display: inline-block; }
    .delivery-line { font-size: 14px; margin: 4px 0; }
    .delivery-line .green { color: #007600; font-weight: 700; }
    .stock-tag { font-size: 18px; font-weight: 700; margin: 10px 0; }
    .stock-tag.in { color: #007600; }
    .stock-tag.low { color: #C7511F; }
    .stock-tag.out { color: #CC0C39; }
    .short-desc { font-size: 14px; line-height: 1.7; }
    .short-desc ul { list-style: disc; padding-left: 18px; }
    .short-desc strong { font-weight: 700; }
    .about-section { margin-top: 20px; border-top: 1px solid #e7e7e7; padding-top: 14px; }
    .about-section h3 { font-size: 18px; font-weight: 700; margin-bottom: 10px; }
    .about-content { font-size: 14px; line-height: 1.75; }
    .about-content ul { list-style: disc; padding-left: 20px; }
    .about-content li { margin: 5px 0; }
    .about-content h2 { font-size: 17px; font-weight: 700; margin: 14px 0 6px; }
    .about-content h3 { font-size: 15px; font-weight: 700; margin: 12px 0 5px; }
    .about-content strong { font-weight: 700; }

    /* Buy box */
    .buy-box { width: 230px; flex-shrink: 0; border: 1px solid #D5D9D9; border-radius: 8px; padding: 18px; background: #fff; box-shadow: 0 2px 5px rgba(0,0,0,.08); }
    .buy-price .currency { font-size: 13px; vertical-align: top; margin-top: 4px; display: inline-block; }
    .buy-price .whole { font-size: 28px; font-weight: 300; }
    .buy-price .fraction { font-size: 13px; vertical-align: top; margin-top: 4px; display: inline-block; }
    .buy-green { color: #007600; font-size: 13px; font-weight: 700; margin: 6px 0 2px; }
    .buy-sub { font-size: 12px; color: #0F1111; margin-bottom: 6px; }
    .buy-stock { font-size: 17px; font-weight: 700; color: #007600; margin: 10px 0 6px; }
    .buy-stock.low { color: #C7511F; }
    .qty-label { font-size: 13px; font-weight: 700; margin-bottom: 4px; }
    .qty-sel { width: 100%; padding: 7px 10px; border: 1px solid #888; border-radius: 6px; font-size: 13px; background: #f7f8f8; cursor: pointer; }
    .btn-cart { display: block; width: 100%; padding: 10px; background: #FFD814; border: 1px solid #FCD200; border-radius: 20px; font-size: 14px; text-align: center; cursor: pointer; margin: 10px 0 6px; color: #0F1111; font-weight: 500; }
    .btn-cart:hover { background: #F7CA00; }
    .btn-buy { display: block; width: 100%; padding: 10px; background: #FFA41C; border: 1px solid #FF8F00; border-radius: 20px; font-size: 14px; text-align: center; cursor: pointer; color: #0F1111; }
    .btn-buy:hover { background: #FF8F00; }
    .buy-meta { font-size: 12px; margin-top: 14px; }
    .buy-meta-row { display: flex; justify-content: space-between; padding: 4px 0; border-bottom: 1px solid #f5f5f5; }
    .buy-meta-label { color: #555; }
    .buy-meta-val { color: #007185; font-weight: 500; }

    /* Related */
    .related-section { max-width: 1200px; margin: 0 auto; padding: 20px 16px 40px; }
    .section-title { font-size: 20px; font-weight: 700; margin-bottom: 16px; border-left: 4px solid #FF9900; padding-left: 10px; }
    .related-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(170px, 1fr)); gap: 14px; }
    .rel-card { background: #fff; border: 1px solid #ddd; border-radius: 6px; overflow: hidden; transition: box-shadow .15s; }
    .rel-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,.1); }
    .rel-img { height: 140px; display: flex; align-items: center; justify-content: center; background: #f7f8f8; padding: 8px; }
    .rel-img img { max-height: 130px; max-width: 100%; object-fit: contain; }
    .rel-body { padding: 8px 10px 12px; }
    .rel-name { font-size: 12px; color: #0F1111; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.4; margin-bottom: 4px; }
    .rel-price { font-size: 14px; font-weight: 700; color: #B12704; }

    @media (max-width: 900px) {
        .product-page { flex-direction: column; }
        .gallery { width: 100%; }
        .buy-box { width: 100%; }
    }
</style>
@endsection

@section('content')

@php
    $images = collect($product->images ?? [])->filter()->map(fn($img) => \Illuminate\Support\Facades\Storage::url($img))->values();
    if ($images->isEmpty() && $product->image) {
        $images = collect([\Illuminate\Support\Facades\Storage::url($product->image)]);
    }
    $hasImages = $images->isNotEmpty();
    $whole    = number_format((int) $product->price, 0);
    $fraction = str_pad((int) round(($product->price - floor($product->price)) * 100), 2, '0', STR_PAD_LEFT);
@endphp

{{-- Breadcrumb --}}
<div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    @if($product->category)
        <span class="sep">›</span>
        <a href="{{ route('products.index', ['category' => $product->category_id]) }}">{{ $product->category->name }}</a>
    @endif
    <span class="sep">›</span>
    <span>{{ \Illuminate\Support\Str::limit($product->name, 70) }}</span>
</div>

{{-- Main product layout --}}
<div class="product-page">

    {{-- Gallery --}}
    <div class="gallery">
        @if($hasImages)
        <div class="thumbs" id="thumbs">
            @foreach($images as $i => $img)
                <div class="thumb {{ $i === 0 ? 'active' : '' }}" onclick="switchImg('{{ $img }}', this)">
                    <img src="{{ $img }}" alt="{{ $i+1 }}" />
                </div>
            @endforeach
        </div>
        @endif
        <div class="main-img-wrap">
            @if($hasImages)
                <img id="mainImg" src="{{ $images->first() }}" alt="{{ $product->name }}" />
            @else
                <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;color:#ccc;">
                    <svg width="90" height="90" viewBox="0 0 24 24" fill="none" stroke="#d5d9d9" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/></svg>
                    <span style="font-size:13px;color:#aaa;">No image available</span>
                </div>
            @endif
        </div>
    </div>

    {{-- Product info --}}
    <div class="product-info">
        <h1 class="product-title">{{ $product->name }}</h1>
        @if($product->brand)
            <div class="brand-link">Brand: <a href="{{ route('products.index', ['brand' => $product->brand_id]) }}">{{ $product->brand->name }}</a></div>
        @endif
        <div class="rating-row">
            <span class="stars" style="display:inline-flex;gap:2px;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            </span>
            <a href="#" class="rating-link">4.0</a>
            <a href="#" class="rating-link">(14 ratings)</a>
            @if($product->sku)
                <span style="color:#888;font-size:12px;margin-left:8px;">| SKU: {{ $product->sku }}</span>
            @endif
        </div>
        <hr class="divider">
        <div class="price-block">
            <span class="currency">$</span><span class="whole">{{ $whole }}</span><span class="fraction">{{ $fraction }}</span>
        </div>
        <div class="delivery-line" style="display:flex;align-items:center;gap:6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#007600" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
            <span class="green">FREE delivery</span> Mon, May 4 – Wed, Jun 6
        </div>
        <div class="delivery-line" style="color:#555;margin-top:6px;display:flex;align-items:center;gap:6px;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#007185" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <span style="color:#007185;">Deliver to your location</span>
        </div>
        <hr class="divider">
        @if($product->short_description)
            <div class="short-desc">{!! $product->short_description !!}</div>
            <hr class="divider">
        @endif
        @if($product->stock > 10)
            <div class="stock-tag in">In Stock</div>
        @elseif($product->stock > 0)
            <div class="stock-tag low">Only {{ $product->stock }} left in stock – order soon</div>
        @else
            <div class="stock-tag out">Currently unavailable</div>
        @endif
        @if($product->long_description)
            <div class="about-section">
                <h3>About this item</h3>
                <div class="about-content">{!! $product->long_description !!}</div>
            </div>
        @endif
    </div>

    {{-- Buy box --}}
    <div class="buy-box">
        <div class="buy-price">
            <span class="currency">$</span><span class="whole">{{ $whole }}</span><span class="fraction">{{ $fraction }}</span>
        </div>
        <div class="buy-green" style="display:flex;align-items:center;gap:5px;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#007600" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
            FREE delivery
        </div>
        <div class="buy-sub">Mon, May 4 – Wed, Jun 6</div>
        <div style="font-size:12px;color:#007185;margin-bottom:10px;display:flex;align-items:center;gap:4px;">
            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#007185" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            Deliver to your location
        </div>
        @if($product->stock > 10)
            <div class="buy-stock">In Stock</div>
        @elseif($product->stock > 0)
            <div class="buy-stock low">Only {{ $product->stock }} left</div>
        @endif
        @if($product->stock > 0)
            <div style="margin: 10px 0;">
                <div class="qty-label">Quantity:</div>
                <select class="qty-sel">
                    @for($q = 1; $q <= min($product->stock, 10); $q++)
                        <option>{{ $q }}</option>
                    @endfor
                </select>
            </div>
            <button class="btn-cart">Add to Cart</button>
            <button class="btn-buy">Buy Now</button>
        @else
            <div style="color:#CC0C39;font-size:14px;font-weight:700;margin:12px 0;">Currently unavailable</div>
        @endif
        <hr style="border:none;border-top:1px solid #e7e7e7;margin:12px 0;">
        <div class="buy-meta">
            <div class="buy-meta-row"><span class="buy-meta-label">Ships from</span><span class="buy-meta-val">MyShop</span></div>
            @if($product->brand)
                <div class="buy-meta-row"><span class="buy-meta-label">Sold by</span><span class="buy-meta-val">{{ $product->brand->name }}</span></div>
            @endif
            <div class="buy-meta-row"><span class="buy-meta-label">Returns</span><span class="buy-meta-val">30-day refund</span></div>
            <div class="buy-meta-row"><span class="buy-meta-label">Support</span><span class="buy-meta-val">Included</span></div>
        </div>
    </div>
</div>

{{-- Related Products --}}
@if($related->isNotEmpty())
<div class="related-section">
    <div class="section-title">Customers also bought</div>
    <div class="related-grid">
        @foreach($related as $rel)
            @php
                $rimgs = collect($rel->images ?? [])->filter()->values();
                $rthumb = $rimgs->first() ? \Illuminate\Support\Facades\Storage::url($rimgs->first()) : null;
            @endphp
            <a href="{{ route('products.show', $rel->slug) }}" class="rel-card">
                <div class="rel-img">
                    @if($rthumb)
                        <img src="{{ $rthumb }}" alt="{{ $rel->name }}" />
                    @else
                        <div style="display:flex;align-items:center;justify-content:center;">
                                    <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#d5d9d9" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/></svg>
                                </div>
                    @endif
                </div>
                <div class="rel-body">
                    <div class="rel-name">{{ $rel->name }}</div>
                    <div style="display:flex;gap:2px;margin:3px 0;">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                </div>
                    <div class="rel-price">${{ number_format($rel->price, 2) }}</div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
function switchImg(src, el) {
    document.getElementById('mainImg').src = src;
    document.querySelectorAll('#thumbs .thumb').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}
</script>
@endsection
