@extends('store.layout')
@section('title', $product->name . ' — MyShop')

@section('head')
<style>
    /* ── Page Layout ──────────────────────────────────── */
    .pd-page { background: #EAEDED; min-height: 100vh; padding-bottom: 40px; }
    .pd-container { max-width: 1400px; margin: 0 auto; padding: 16px; }

    /* ── Breadcrumb ───────────────────────────────────── */
    .pd-breadcrumb { background: #fff; border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; font-size: 13px; color: #555; display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .pd-breadcrumb a { color: #007185; text-decoration: none; }
    .pd-breadcrumb a:hover { color: #C7511F; text-decoration: underline; }
    .pd-breadcrumb .sep { color: #888; }
    .pd-breadcrumb .current { color: #0F1111; font-weight: 500; }

    /* ── Main Product Area ──────────────────────────────── */
    .pd-main { display: grid; grid-template-columns: 500px 1fr 280px; gap: 24px; align-items: start; }

    /* ── Gallery ───────────────────────────────────────── */
    .pd-gallery { background: #fff; border-radius: 12px; padding: 20px; position: sticky; top: 20px; }
    .pd-gallery-wrap { display: flex; gap: 16px; }
    .pd-thumbs { display: flex; flex-direction: column; gap: 10px; width: 64px; }
    .pd-thumb { width: 64px; height: 64px; border: 2px solid #e3e6e6; border-radius: 8px; overflow: hidden; cursor: pointer; padding: 4px; background: #fff; transition: all .15s; }
    .pd-thumb img { width: 100%; height: 100%; object-fit: contain; }
    .pd-thumb:hover { border-color: #FF9900; }
    .pd-thumb.active { border-color: #FF9900; background: #fff8ee; }
    .pd-main-img-wrap { flex: 1; min-height: 420px; display: flex; align-items: center; justify-content: center; position: relative; background: #f7f8f8; border-radius: 8px; cursor: zoom-in; overflow: hidden; }
    .pd-main-img-wrap img { max-height: 400px; max-width: 100%; object-fit: contain; transition: transform .3s; }
    .pd-main-img-wrap:hover img { transform: scale(1.05); }
    .pd-zoom-hint { position: absolute; bottom: 10px; right: 10px; background: rgba(19,25,33,.7); color: #fff; padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; display: flex; align-items: center; gap: 4px; opacity: 0; transition: opacity .2s; }
    .pd-main-img-wrap:hover .pd-zoom-hint { opacity: 1; }
    .pd-gallery-actions { display: flex; gap: 10px; margin-top: 16px; justify-content: center; }
    .pd-gallery-btn { padding: 8px 16px; border: 1px solid #d5d9d9; border-radius: 20px; background: #fff; font-size: 12px; font-weight: 600; color: #555; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all .15s; }
    .pd-gallery-btn:hover { border-color: #FF9900; color: #C7511F; background: #fff8ee; }

    /* ── Product Info ───────────────────────────────────── */
    .pd-info { background: #fff; border-radius: 12px; padding: 24px; }
    .pd-brand-row { display: flex; align-items: center; gap: 12px; margin-bottom: 8px; }
    .pd-brand { font-size: 13px; color: #007185; font-weight: 600; }
    .pd-brand a { color: #007185; text-decoration: none; }
    .pd-brand a:hover { color: #C7511F; text-decoration: underline; }
    .pd-badge { background: #FF9900; color: #131921; font-size: 10px; font-weight: 800; padding: 3px 10px; border-radius: 4px; text-transform: uppercase; }
    .pd-title { font-size: 24px; font-weight: 500; line-height: 1.35; color: #0F1111; margin-bottom: 12px; }

    /* Rating */
    .pd-rating-row { display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid #f0f2f2; }
    .pd-stars { display: flex; gap: 2px; }
    .pd-rating-text { font-size: 14px; color: #007185; cursor: pointer; }
    .pd-rating-text:hover { color: #C7511F; text-decoration: underline; }
    .pd-sku { font-size: 12px; color: #888; margin-left: auto; }

    /* Price Block */
    .pd-price-block { padding: 20px 0; border-bottom: 1px solid #f0f2f2; }
    .pd-price-row { display: flex; align-items: baseline; gap: 12px; flex-wrap: wrap; }
    .pd-price-main { display: flex; align-items: baseline; color: #B12704; }
    .pd-price-currency { font-size: 16px; font-weight: 400; vertical-align: top; }
    .pd-price-whole { font-size: 32px; font-weight: 600; line-height: 1; }
    .pd-price-fraction { font-size: 16px; font-weight: 400; vertical-align: top; }
    .pd-price-was { font-size: 14px; color: #888; text-decoration: line-through; }
    .pd-save-badge { background: #CC0C39; color: #fff; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 4px; }
    .pd-tax-note { font-size: 13px; color: #555; margin-top: 6px; }

    /* Delivery */
    .pd-delivery-block { padding: 20px 0; border-bottom: 1px solid #f0f2f2; }
    .pd-delivery-row { display: flex; align-items: center; gap: 10px; margin: 8px 0; font-size: 14px; }
    .pd-delivery-icon { width: 20px; height: 20px; flex-shrink: 0; }
    .pd-delivery-green { color: #007600; font-weight: 700; }
    .pd-delivery-link { color: #007185; cursor: pointer; }
    .pd-delivery-link:hover { color: #C7511F; text-decoration: underline; }

    /* Stock Status */
    .pd-stock-block { padding: 16px 0; }
    .pd-stock { display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 700; }
    .pd-stock.in { color: #007600; }
    .pd-stock.low { color: #C7511F; }
    .pd-stock.out { color: #CC0C39; }

    /* ── Buy Box ─────────────────────────────────────────── */
    .pd-buybox { background: #fff; border-radius: 12px; padding: 20px; border: 1px solid #e3e6e6; box-shadow: 0 2px 8px rgba(0,0,0,.06); position: sticky; top: 20px; }
    .pd-buybox-price { display: flex; align-items: baseline; color: #B12704; margin-bottom: 12px; }
    .pd-buybox-currency { font-size: 13px; }
    .pd-buybox-whole { font-size: 26px; font-weight: 600; }
    .pd-buybox-fraction { font-size: 13px; }
    .pd-buybox-delivery { font-size: 13px; color: #007600; font-weight: 600; margin-bottom: 4px; display: flex; align-items: center; gap: 6px; }
    .pd-buybox-date { font-size: 12px; color: #555; margin-bottom: 12px; }
    .pd-buybox-location { font-size: 12px; color: #007185; margin-bottom: 12px; display: flex; align-items: center; gap: 4px; cursor: pointer; }
    .pd-buybox-location:hover { color: #C7511F; }
    .pd-buybox-stock { font-size: 16px; font-weight: 700; color: #007600; margin-bottom: 12px; }
    .pd-buybox-stock.low { color: #C7511F; }

    /* Quantity */
    .pd-qty-wrap { margin-bottom: 12px; }
    .pd-qty-label { font-size: 12px; font-weight: 700; color: #0F1111; margin-bottom: 6px; }
    .pd-qty-select { width: 100%; padding: 10px; border: 1px solid #888C8C; border-radius: 8px; font-size: 13px; background: #f7f8f8; cursor: pointer; }
    .pd-qty-select:focus { border-color: #FF9900; outline: none; box-shadow: 0 0 0 3px rgba(255,153,0,.15); }

    /* Buttons */
    .pd-btn-cart { display: block; width: 100%; padding: 12px; background: #FFD814; border: 1px solid #FCD200; border-radius: 20px; font-size: 14px; font-weight: 600; text-align: center; cursor: pointer; margin-bottom: 10px; color: #131921; transition: all .15s; }
    .pd-btn-cart:hover { background: #F7CA00; transform: translateY(-1px); }
    .pd-btn-buy { display: block; width: 100%; padding: 12px; background: #FFA41C; border: 1px solid #FF8F00; border-radius: 20px; font-size: 14px; font-weight: 600; text-align: center; cursor: pointer; color: #131921; transition: all .15s; }
    .pd-btn-buy:hover { background: #FF8F00; transform: translateY(-1px); }
    .pd-btn-wish { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 10px; background: #fff; border: 1px solid #d5d9d9; border-radius: 20px; font-size: 13px; font-weight: 500; color: #555; cursor: pointer; margin-top: 12px; transition: all .15s; }
    .pd-btn-wish:hover { border-color: #FF9900; color: #C7511F; background: #fff8ee; }
    .pd-btn-wish.saved { background: #FFF0F0; border-color: #CC0C39; color: #CC0C39; }

    /* Buybox Meta */
    .pd-buybox-meta { margin-top: 16px; padding-top: 16px; border-top: 1px solid #f0f2f2; }
    .pd-meta-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 12px; }
    .pd-meta-label { color: #555; }
    .pd-meta-value { color: #007185; font-weight: 500; }

    /* ── Product Details Tabs ───────────────────────────── */
    .pd-details { background: #fff; border-radius: 12px; margin-top: 24px; overflow: hidden; }
    .pd-tabs { display: flex; border-bottom: 1px solid #e3e6e6; background: #f7f8f8; }
    .pd-tab { padding: 16px 24px; font-size: 14px; font-weight: 600; color: #555; cursor: pointer; border-bottom: 3px solid transparent; transition: all .15s; white-space: nowrap; }
    .pd-tab:hover { color: #C7511F; background: #fff; }
    .pd-tab.active { color: #0F1111; border-bottom-color: #FF9900; background: #fff; }
    .pd-tab-content { padding: 24px; }
    .pd-tab-pane { display: none; }
    .pd-tab-pane.active { display: block; }

    /* Description */
    .pd-desc-content { font-size: 14px; line-height: 1.8; color: #0F1111; }
    .pd-desc-content h2, .pd-desc-content h3 { font-size: 16px; font-weight: 700; margin: 20px 0 12px; color: #0F1111; }
    .pd-desc-content ul { list-style: disc; padding-left: 24px; margin: 12px 0; }
    .pd-desc-content li { margin: 8px 0; }
    .pd-desc-content strong { font-weight: 700; }

    /* Specs Table */
    .pd-specs-table { width: 100%; border-collapse: collapse; }
    .pd-specs-table tr:nth-child(odd) { background: #f7f8f8; }
    .pd-specs-table td { padding: 14px 16px; font-size: 14px; }
    .pd-specs-table td:first-child { font-weight: 600; color: #0F1111; width: 30%; }
    .pd-specs-table td:last-child { color: #555; }

    /* ── Related Products ──────────────────────────────── */
    .pd-related { margin-top: 32px; }
    .pd-section-title { font-size: 20px; font-weight: 700; color: #0F1111; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; border-left: 4px solid #FF9900; padding-left: 12px; }
    .pd-related-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
    .pd-related-card { background: #fff; border: 1px solid #e3e6e6; border-radius: 8px; overflow: hidden; transition: all .15s; text-decoration: none; color: inherit; }
    .pd-related-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.12); border-color: #FF9900; transform: translateY(-2px); }
    .pd-related-img { height: 160px; display: flex; align-items: center; justify-content: center; background: #f7f8f8; padding: 12px; }
    .pd-related-img img { max-height: 140px; max-width: 100%; object-fit: contain; }
    .pd-related-body { padding: 12px; }
    .pd-related-brand { font-size: 11px; color: #C7511F; font-weight: 700; text-transform: uppercase; margin-bottom: 4px; }
    .pd-related-name { font-size: 13px; color: #0F1111; line-height: 1.4; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; margin-bottom: 8px; min-height: 36px; }
    .pd-related-rating { display: flex; align-items: center; gap: 4px; margin-bottom: 6px; }
    .pd-related-price { font-size: 16px; font-weight: 700; color: #B12704; }
    .pd-related-prime { font-size: 11px; color: #007185; margin-top: 4px; }

    /* ── Responsive ─────────────────────────────────────── */
    @media (max-width: 1100px) {
        .pd-main { grid-template-columns: 400px 1fr; }
        .pd-buybox { position: static; grid-column: 1 / -1; }
    }
    @media (max-width: 768px) {
        .pd-main { grid-template-columns: 1fr; }
        .pd-gallery { position: static; }
        .pd-gallery-wrap { flex-direction: column-reverse; }
        .pd-thumbs { flex-direction: row; overflow-x: auto; width: 100%; }
        .pd-tabs { overflow-x: auto; }
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

<div class="pd-page">
<div class="pd-container">

{{-- Breadcrumb --}}
<div class="pd-breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    @if($product->category)
        <span class="sep">›</span>
        <a href="{{ route('products.index', ['category' => $product->category_id]) }}">{{ $product->category->name }}</a>
    @endif
    <span class="sep">›</span>
    <span class="current">{{ \Illuminate\Support\Str::limit($product->name, 60) }}</span>
</div>

{{-- Main Product Grid --}}
<div class="pd-main">

    {{-- Gallery --}}
    <div class="pd-gallery">
        <div class="pd-gallery-wrap">
            @if($hasImages)
            <div class="pd-thumbs" id="pd-thumbs">
                @foreach($images as $i => $img)
                    <div class="pd-thumb {{ $i === 0 ? 'active' : '' }}" onclick="pdSwitchImg('{{ $img }}', this)">
                        <img src="{{ $img }}" alt="{{ $i+1 }}" />
                    </div>
                @endforeach
            </div>
            @endif
            <div class="pd-main-img-wrap" id="pd-img-wrap">
                @if($hasImages)
                    <img id="pd-main-img" src="{{ $images->first() }}" alt="{{ $product->name }}" />
                    <div class="pd-zoom-hint">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                        Roll over to zoom
                    </div>
                @else
                    <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;color:#ccc;">
                        <svg width="90" height="90" viewBox="0 0 24 24" fill="none" stroke="#d5d9d9" stroke-width="0.8"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/></svg>
                        <span style="font-size:13px;color:#aaa;">No image available</span>
                    </div>
                @endif
            </div>
        </div>
        @if($hasImages)
        <div class="pd-gallery-actions">
            <button class="pd-gallery-btn" onclick="pdExpandGallery()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/></svg>
                Expand
            </button>
            <button class="pd-gallery-btn" onclick="pdToggleWish()" id="pd-gallery-wish">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                Add to List
            </button>
        </div>
        @endif
    </div>

    {{-- Product Info --}}
    <div class="pd-info">
        <div class="pd-brand-row">
            @if($product->brand)
                <div class="pd-brand">Brand: <a href="{{ route('products.index', ['brand' => $product->brand_id]) }}">{{ $product->brand->name }}</a></div>
            @endif
            <span class="pd-badge">Best Seller</span>
        </div>

        <h1 class="pd-title">{{ $product->name }}</h1>

        <div class="pd-rating-row">
            <div class="pd-stars">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            </div>
            <span class="pd-rating-text">4.5</span>
            <span class="pd-rating-text">(128 ratings)</span>
            @if($product->sku)
                <span class="pd-sku">SKU: {{ $product->sku }}</span>
            @endif
        </div>

        <div class="pd-price-block">
            <div class="pd-price-row">
                <div class="pd-price-main">
                    <span class="pd-price-currency">$</span>
                    <span class="pd-price-whole">{{ $whole }}</span>
                    <span class="pd-price-fraction">{{ $fraction }}</span>
                </div>
                <span class="pd-price-was">${{ number_format($product->price * 1.2, 2) }}</span>
                <span class="pd-save-badge">Save 20%</span>
            </div>
            <div class="pd-tax-note">Prices include VAT. No additional import charges.</div>
        </div>

        <div class="pd-delivery-block">
            <div class="pd-delivery-row">
                <svg class="pd-delivery-icon" viewBox="0 0 24 24" fill="none" stroke="#007600" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                <span class="pd-delivery-green">FREE delivery</span>
                <span>Tomorrow, May 12</span>
            </div>
            <div class="pd-delivery-row">
                <svg class="pd-delivery-icon" viewBox="0 0 24 24" fill="none" stroke="#007185" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                <span class="pd-delivery-link">Deliver to your location — Update</span>
            </div>
        </div>

        <div class="pd-stock-block">
            @if($product->stock > 10)
                <div class="pd-stock in">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#007600" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    In Stock
                </div>
            @elseif($product->stock > 0)
                <div class="pd-stock low">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C7511F" stroke-width="2.5"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Only {{ $product->stock }} left in stock — order soon
                </div>
            @else
                <div class="pd-stock out">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#CC0C39" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    Currently unavailable
                </div>
            @endif
        </div>
    </div>

    {{-- Buy Box --}}
    <div class="pd-buybox">
        <div class="pd-buybox-price">
            <span class="pd-buybox-currency">$</span>
            <span class="pd-buybox-whole">{{ $whole }}</span>
            <span class="pd-buybox-fraction">{{ $fraction }}</span>
        </div>

        <div class="pd-buybox-delivery">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#007600" stroke-width="2"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
            FREE delivery Tomorrow
        </div>
        <div class="pd-buybox-date">Order within 4 hrs 12 mins</div>

        <div class="pd-buybox-location">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#007185" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            Deliver to your location
        </div>

        @if($product->stock > 10)
            <div class="pd-buybox-stock">In Stock</div>
        @elseif($product->stock > 0)
            <div class="pd-buybox-stock low">Only {{ $product->stock }} left</div>
        @endif

        @if($product->stock > 0)
            <form action="{{ route('cart.add', $product->id) }}" method="POST" id="addToCartForm">
                @csrf
                <div class="pd-qty-wrap">
                    <div class="pd-qty-label">Quantity:</div>
                    <select class="pd-qty-select" name="quantity" id="qtySelect">
                        @for($q = 1; $q <= min($product->stock, 10); $q++)
                            <option value="{{ $q }}">{{ $q }}</option>
                        @endfor
                    </select>
                </div>

                <button type="button" class="pd-btn-cart" id="addToCartBtn" onclick="pdAddToCart()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    <span id="cartBtnText">Add to Cart</span>
                </button>
            </form>

            <form action="{{ route('cart.add', $product->id) }}" method="POST" id="buyNowForm">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="redirect" value="checkout">
                <button type="submit" class="pd-btn-buy">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    Buy Now
                </button>
            </form>
        @endif

        <button class="pd-btn-wish" id="pd-wish-btn" onclick="pdToggleWishList()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            Add to Wish List
        </button>

        <div class="pd-buybox-meta">
            <div class="pd-meta-row"><span class="pd-meta-label">Ships from</span><span class="pd-meta-value">MyShop</span></div>
            @if($product->brand)
                <div class="pd-meta-row"><span class="pd-meta-label">Sold by</span><span class="pd-meta-value">{{ $product->brand->name }}</span></div>
            @endif
            <div class="pd-meta-row"><span class="pd-meta-label">Returns</span><span class="pd-meta-value">30-day refund/replacement</span></div>
            <div class="pd-meta-row"><span class="pd-meta-label">Payment</span><span class="pd-meta-value">Secure transaction</span></div>
        </div>
    </div>
</div>

{{-- Product Details Tabs --}}
<div class="pd-details">
    <div class="pd-tabs">
        <div class="pd-tab active" onclick="pdSwitchTab(this, 'desc')">Description</div>
        <div class="pd-tab" onclick="pdSwitchTab(this, 'specs')">Specifications</div>
        <div class="pd-tab" onclick="pdSwitchTab(this, 'reviews')">Customer Reviews</div>
    </div>
    <div class="pd-tab-content">
        <div class="pd-tab-pane active" id="tab-desc">
            <div class="pd-desc-content">
                @if($product->long_description)
                    {!! $product->long_description !!}
                @elseif($product->short_description)
                    {!! $product->short_description !!}
                @else
                    <p>No detailed description available for this product.</p>
                @endif
            </div>
        </div>
        <div class="pd-tab-pane" id="tab-specs">
            <table class="pd-specs-table">
                <tr><td>Brand</td><td>{{ $product->brand ? $product->brand->name : 'N/A' }}</td></tr>
                <tr><td>Category</td><td>{{ $product->category ? $product->category->name : 'N/A' }}</td></tr>
                <tr><td>SKU</td><td>{{ $product->sku ?? 'N/A' }}</td></tr>
                <tr><td>Stock Status</td><td>{{ $product->stock > 0 ? 'In Stock (' . $product->stock . ' available)' : 'Out of Stock' }}</td></tr>
                <tr><td>Price</td><td>${{ number_format($product->price, 2) }}</td></tr>
            </table>
        </div>
        <div class="pd-tab-pane" id="tab-reviews">
            <div style="text-align:center;padding:40px 20px;">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="1.5" style="margin-bottom:16px;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <h4 style="font-size:16px;font-weight:700;margin-bottom:8px;">Customer Reviews</h4>
                <p style="color:#555;font-size:14px;">Be the first to review this product!</p>
            </div>
        </div>
    </div>
</div>

{{-- Related Products --}}
@if($related->isNotEmpty())
<div class="pd-related">
    <div class="pd-section-title">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        Customers also bought
    </div>
    <div class="pd-related-grid">
        @foreach($related as $rel)
            @php
                $rimgs = collect($rel->images ?? [])->filter()->values();
                $rthumb = $rimgs->first() ? \Illuminate\Support\Facades\Storage::url($rimgs->first()) : null;
                $rwhole = number_format((int) $rel->price, 0);
                $rfrac  = str_pad((int) round(($rel->price - floor($rel->price)) * 100), 2, '0', STR_PAD_LEFT);
            @endphp
            <a href="{{ route('products.show', $rel->slug) }}" class="pd-related-card">
                <div class="pd-related-img">
                    @if($rthumb)
                        <img src="{{ $rthumb }}" alt="{{ $rel->name }}" />
                    @else
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#d5d9d9" stroke-width="1"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/></svg>
                    @endif
                </div>
                <div class="pd-related-body">
                    @if($rel->brand)
                        <div class="pd-related-brand">{{ $rel->brand->name }}</div>
                    @endif
                    <div class="pd-related-name">{{ $rel->name }}</div>
                    <div class="pd-related-rating">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <div class="pd-related-price">${{ $rwhole }}.{{ $rfrac }}</div>
                    <div class="pd-related-prime">✓ Prime</div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endif

</div>{{-- /pd-container --}}
</div>{{-- /pd-page --}}

@endsection

@section('scripts')
<script>
function pdSwitchImg(src, el) {
    document.getElementById('pd-main-img').src = src;
    document.querySelectorAll('#pd-thumbs .pd-thumb').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
}

function pdSwitchTab(el, tabId) {
    document.querySelectorAll('.pd-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    document.querySelectorAll('.pd-tab-pane').forEach(p => p.classList.remove('active'));
    document.getElementById('tab-' + tabId).classList.add('active');
}

function pdToggleWishList() {
    const btn = document.getElementById('pd-wish-btn');
    const isSaved = btn.classList.toggle('saved');
    const svg = btn.querySelector('svg');
    svg.setAttribute('fill', isSaved ? '#CC0C39' : 'none');
    btn.innerHTML = isSaved 
        ? '<svg width="16" height="16" viewBox="0 0 24 24" fill="#CC0C39" stroke="#CC0C39" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg> Saved to List'
        : '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg> Add to Wish List';
    pdToast(isSaved ? '❤️ Added to Wish List' : 'Removed from Wish List');
}

function pdAddToCart() {
    const form = document.getElementById('addToCartForm');
    const formData = new FormData(form);
    const btn = document.getElementById('addToCartBtn');
    const btnText = document.getElementById('cartBtnText');

    btn.disabled = true;
    btnText.textContent = 'Adding...';

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            pdToast('🛒 ' + data.message);
            // Update cart count in header
            const cartCount = document.getElementById('cartCount');
            if (cartCount) {
                cartCount.textContent = data.cart_count;
            }
        } else {
            pdToast('❌ Failed to add to cart');
        }
        btn.disabled = false;
        btnText.textContent = 'Add to Cart';
    })
    .catch(error => {
        // Fallback: submit form normally
        form.submit();
    });

    return false;
}

function pdBuyNow() {
    pdToast('⚡ Proceeding to checkout...');
}

function pdExpandGallery() {
    pdToast('🔍 Gallery expanded');
}

function pdToggleWish() {
    pdToggleWishList();
}

function pdToast(msg) {
    let t = document.getElementById('pdToast');
    if (!t) {
        t = document.createElement('div');
        t.id = 'pdToast';
        t.style.cssText = 'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#131921;color:#FF9900;padding:12px 24px;border-radius:8px;font-size:14px;z-index:99999;box-shadow:0 4px 16px rgba(0,0,0,.3);transition:opacity .3s;font-weight:600;';
        document.body.appendChild(t);
    }
    t.textContent = msg;
    t.style.opacity = '1';
    clearTimeout(t._t);
    t._t = setTimeout(() => { t.style.opacity = '0'; }, 2500);
}
</script>
@endsection
