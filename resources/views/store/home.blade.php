@extends('store.layout')
@section('title', 'MyShop — Online Shopping for Electronics, Clothing & More')

@section('head')
<style>
    .hero { position: relative; overflow: hidden; background: linear-gradient(135deg, #131921 0%, #1a2533 50%, #232F3E 100%); padding: 60px 24px; text-align: center; color: #fff; }
    .hero h1 { font-size: 36px; font-weight: 700; margin-bottom: 12px; }
    .hero p { font-size: 16px; color: #ccc; margin-bottom: 24px; }
    .hero-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
    .btn-primary { background: #FF9900; color: #131921; padding: 12px 28px; border-radius: 4px; font-size: 14px; font-weight: 700; border: none; cursor: pointer; }
    .btn-primary:hover { background: #e88b00; }
    .btn-outline { background: transparent; color: #fff; padding: 11px 28px; border-radius: 4px; font-size: 14px; font-weight: 700; border: 2px solid #fff; cursor: pointer; }
    .btn-outline:hover { background: rgba(255,255,255,0.1); }

    /* Categories strip */
    .section { max-width: 1200px; margin: 0 auto; padding: 24px 16px; }
    .section-title { font-size: 22px; font-weight: 700; color: #0F1111; margin-bottom: 16px; border-left: 4px solid #FF9900; padding-left: 10px; }
    .cat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 12px; }
    .cat-card { background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 16px 12px; text-align: center; cursor: pointer; transition: box-shadow .15s, transform .15s; }
    .cat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.12); transform: translateY(-2px); }
    .cat-card .icon { font-size: 32px; margin-bottom: 8px; }
    .cat-card .name { font-size: 13px; font-weight: 600; color: #0F1111; }

    /* Product grid */
    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
    .product-card { background: #fff; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; cursor: pointer; transition: box-shadow .15s; display: flex; flex-direction: column; }
    .product-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.15); }
    .product-card-img { height: 180px; display: flex; align-items: center; justify-content: center; background: #f7f8f8; padding: 12px; overflow: hidden; }
    .product-card-img img { max-height: 156px; max-width: 100%; object-fit: contain; }
    .product-card-body { padding: 10px 12px 14px; flex: 1; display: flex; flex-direction: column; }
    .product-card-name { font-size: 13px; color: #0F1111; margin-bottom: 4px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.4; flex: 1; }
    .product-card-brand { font-size: 12px; color: #007185; margin-bottom: 4px; }
    .product-card-stars { color: #FF9900; font-size: 13px; margin-bottom: 4px; }
    .product-card-price { font-size: 16px; font-weight: 700; color: #B12704; }
    .product-card-stock { font-size: 12px; color: #007600; margin-top: 3px; }
    .product-card-stock.out { color: #CC0C39; }
    .btn-add { width: 100%; background: #FFD814; border: 1px solid #FCD200; border-radius: 4px; padding: 7px; font-size: 13px; cursor: pointer; margin-top: 8px; font-weight: 500; }
    .btn-add:hover { background: #F7CA00; }

    /* Brands */
    .brand-grid { display: flex; gap: 16px; flex-wrap: wrap; }
    .brand-chip { background: #fff; border: 1px solid #ddd; border-radius: 20px; padding: 6px 16px; font-size: 13px; font-weight: 600; color: #0F1111; cursor: pointer; }
    .brand-chip:hover { background: #FF9900; border-color: #FF9900; color: #fff; }

    /* Deal banner */
    .deal-banner { background: linear-gradient(90deg, #FF9900, #FF6600); color: #fff; border-radius: 8px; padding: 20px 24px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
    .deal-banner h2 { font-size: 22px; font-weight: 700; margin: 0; }
    .deal-banner p { font-size: 14px; margin: 4px 0 0; opacity: .9; }
</style>
@endsection

@section('content')

{{-- Hero --}}
<div class="hero">
    <h1>Welcome to MyShop</h1>
    <p>Discover millions of products at unbeatable prices. Fast delivery, easy returns.</p>
    <div class="hero-btns">
        <a href="{{ route('products.index') }}" class="btn-primary">Shop Now</a>
        @guest
            <a href="{{ route('store.register') }}" class="btn-outline">Create Account</a>
        @endguest
    </div>
</div>

{{-- Categories --}}
@if($categories->isNotEmpty())
<div class="section">
    <div class="section-title">Shop by Category</div>
    <div class="cat-grid">
        @php $icons = ['Electronics'=>'💻','Clothing'=>'👗','Footwear'=>'👟','Accessories'=>'👜','Home & Garden'=>'🏠','Sports'=>'⚽','Toys'=>'🧸','Beauty'=>'💄']; @endphp
        @foreach($categories as $cat)
            <a href="{{ route('products.index', ['category' => $cat->id]) }}" class="cat-card">
                <div class="icon">{{ $icons[$cat->name] ?? '🛒' }}</div>
                <div class="name">{{ $cat->name }}</div>
            </a>
        @endforeach
    </div>
</div>
@endif

{{-- Featured Products --}}
@if($featured->isNotEmpty())
<div class="section" style="background:#fff8f0;padding-top:28px;padding-bottom:28px;max-width:100%;margin:0;">
    <div style="max-width:1200px;margin:0 auto;padding:0 16px;">
        <div class="deal-banner">
            <div>
                <h2>⚡ Featured Deals</h2>
                <p>Hand-picked products just for you</p>
            </div>
            <a href="{{ route('products.index') }}" style="background:#fff;color:#FF6600;padding:8px 20px;border-radius:4px;font-size:13px;font-weight:700;">See all deals</a>
        </div>
        <div class="product-grid">
            @foreach($featured as $product)
                @php
                    $imgs = collect($product->images ?? [])->filter()->values();
                    $thumb = $imgs->first() ? \Illuminate\Support\Facades\Storage::url($imgs->first()) : null;
                @endphp
                <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                    <div class="product-card-img">
                        @if($thumb)
                            <img src="{{ $thumb }}" alt="{{ $product->name }}" />
                        @else
                            <div style="font-size:48px;color:#ddd;">📦</div>
                        @endif
                    </div>
                    <div class="product-card-body">
                        @if($product->brand)
                            <div class="product-card-brand">{{ $product->brand->name }}</div>
                        @endif
                        <div class="product-card-name">{{ $product->name }}</div>
                        <div class="product-card-stars">★★★★☆ <span style="color:#555;font-size:11px;">(14)</span></div>
                        <div class="product-card-price">${{ number_format($product->price, 2) }}</div>
                        @if($product->stock > 0)
                            <div class="product-card-stock">In Stock</div>
                        @else
                            <div class="product-card-stock out">Out of Stock</div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Latest Products --}}
@if($latest->isNotEmpty())
<div class="section">
    <div class="section-title">New Arrivals</div>
    <div class="product-grid">
        @foreach($latest as $product)
            @php
                $imgs = collect($product->images ?? [])->filter()->values();
                $thumb = $imgs->first() ? \Illuminate\Support\Facades\Storage::url($imgs->first()) : null;
            @endphp
            <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                <div class="product-card-img">
                    @if($thumb)
                        <img src="{{ $thumb }}" alt="{{ $product->name }}" />
                    @else
                        <div style="font-size:48px;color:#ddd;">📦</div>
                    @endif
                </div>
                <div class="product-card-body">
                    @if($product->brand)
                        <div class="product-card-brand">{{ $product->brand->name }}</div>
                    @endif
                    <div class="product-card-name">{{ $product->name }}</div>
                    <div class="product-card-stars">★★★★☆</div>
                    <div class="product-card-price">${{ number_format($product->price, 2) }}</div>
                    @if($product->stock > 0)
                        <div class="product-card-stock">In Stock</div>
                    @else
                        <div class="product-card-stock out">Out of Stock</div>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
</div>
@endif

{{-- Brands --}}
@if($brands->isNotEmpty())
<div class="section" style="border-top:1px solid #eee;padding-top:20px;">
    <div class="section-title">Top Brands</div>
    <div class="brand-grid">
        @foreach($brands as $brand)
            <a href="{{ route('products.index', ['brand' => $brand->id]) }}" class="brand-chip">{{ $brand->name }}</a>
        @endforeach
    </div>
</div>
@endif

@endsection
