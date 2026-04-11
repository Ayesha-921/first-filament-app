@extends('store.layout')
@section('title', 'Best Price — Lowest Prices Guaranteed')

@section('head')
<style>
    /* ── Page ───────────────────────────────────────── */
    .bp-page { background: #EAEDED; min-height: 80vh; }

    /* ── Hero ───────────────────────────────────────── */
    .bp-hero { background: linear-gradient(135deg,#131921 0%,#232f3e 50%,#131921 100%); padding: 40px 20px; position: relative; overflow: hidden; }
    .bp-hero::before { content:''; position:absolute; right:-80px; top:-80px; width:350px; height:350px; background:rgba(255,153,0,.1); border-radius:50%; pointer-events:none; }
    .bp-hero::after { content:''; position:absolute; left:30%; bottom:-100px; width:280px; height:280px; background:rgba(255,214,20,.05); border-radius:50%; pointer-events:none; }
    .bp-hero-inner { max-width:1340px; margin:0 auto; text-align:center; position:relative; z-index:1; }
    .bp-hero-badge { display:inline-flex; align-items:center; gap:6px; background:#FFD814; color:#131921; font-size:12px; font-weight:800; padding:6px 16px; border-radius:20px; margin-bottom:16px; text-transform:uppercase; letter-spacing:1px; }
    .bp-hero h1 { font-size:42px; font-weight:900; color:#fff; margin:0 0 16px; line-height:1.2; }
    .bp-hero h1 span { color:#FF9900; }
    .bp-hero p { font-size:16px; color:#adbac7; margin:0 auto 24px; max-width:600px; line-height:1.6; }
    .bp-hero-stats { display:flex; justify-content:center; gap:40px; flex-wrap:wrap; margin-top:32px; }
    .bp-stat { text-align:center; }
    .bp-stat-num { font-size:36px; font-weight:900; color:#FFD814; line-height:1; }
    .bp-stat-label { font-size:12px; color:#adbac7; text-transform:uppercase; letter-spacing:1px; margin-top:6px; }

    /* ── Price Promise Banner ───────────────────────── */
    .bp-promise { background: linear-gradient(90deg,#131921,#232f3e); }
    .bp-promise-inner { max-width:1340px; margin:0 auto; padding:14px 20px; display:flex; align-items:center; justify-content:center; gap:24px; flex-wrap:wrap; }
    .bp-promise-item { display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; color:#fff; }

    /* ── Value Tiers ─────────────────────────────────── */
    .bp-tiers-bar { background:#fff; border-bottom:2px solid #e3e6e6; }
    .bp-tiers-inner { max-width:1340px; margin:0 auto; padding:0 20px; display:flex; overflow-x:auto; scrollbar-width:none; }
    .bp-tiers-inner::-webkit-scrollbar { display:none; }
    .bp-tier-tab { display:flex; align-items:center; gap:8px; padding:16px 24px; font-size:14px; font-weight:600; color:#555; white-space:nowrap; border-bottom:3px solid transparent; cursor:pointer; text-decoration:none; transition:all .15s; }
    .bp-tier-tab:hover { color:#FF9900; border-bottom-color:#FF9900; }
    .bp-tier-tab.active { color:#FF9900; border-bottom-color:#FF9900; font-weight:700; }
    .bp-tier-icon { font-size:18px; }

    /* ── Category Deals Chips ─────────────────────────── */
    .bp-deals-bar { background:#fff8ee; border-bottom:1px solid #ffe0b2; }
    .bp-deals-inner { max-width:1340px; margin:0 auto; padding:14px 20px; display:flex; gap:10px; overflow-x:auto; scrollbar-width:none; }
    .bp-deals-inner::-webkit-scrollbar { display:none; }
    .bp-deal-chip { flex-shrink:0; display:flex; align-items:center; gap:6px; padding:8px 16px; background:#fff; border:2px solid #FF9900; border-radius:20px; font-size:13px; font-weight:700; color:#FF9900; cursor:pointer; text-decoration:none; transition:all .15s; }
    .bp-deal-chip:hover { background:#FF9900; color:#131921; transform:translateY(-2px); }
    .bp-deal-chip.active { background:#FF9900; color:#131921; }

    /* ── Breadcrumb ───────────────────────────────────── */
    .bp-breadcrumb { max-width:1340px; margin:0 auto; padding:12px 20px; font-size:13px; color:#555; }
    .bp-breadcrumb a { color:#FF9900; }
    .bp-breadcrumb a:hover { color:#C7511F; text-decoration:underline; }

    /* ── Layout ────────────────────────────────────────── */
    .bp-wrap { max-width:1340px; margin:0 auto; padding:24px 20px 60px; display:flex; gap:24px; align-items:flex-start; }

    /* ── Sidebar ───────────────────────────────────────── */
    .bp-sidebar { width:240px; flex-shrink:0; }
    .bp-sb-box { background:#fff; border:1px solid #e3e6e6; border-radius:12px; overflow:hidden; margin-bottom:16px; box-shadow:0 2px 8px rgba(0,0,0,.04); }
    .bp-sb-head { font-size:14px; font-weight:700; color:#0F1111; padding:16px; border-bottom:1px solid #f0f2f2; background:#f7f8f8; display:flex; align-items:center; gap:8px; }
    .bp-sb-body { padding:10px 0; }
    .bp-sb-item { display:flex; align-items:center; gap:10px; padding:10px 16px; font-size:13px; color:#0F1111; cursor:pointer; text-decoration:none; transition:all .15s; border-left:3px solid transparent; }
    .bp-sb-item:hover { background:#fff8ee; border-left-color:#FF9900; color:#C7511F; }
    .bp-sb-item.active { background:#fff4e0; border-left-color:#FF9900; font-weight:700; color:#C7511F; }
    .bp-sb-item input { accent-color:#FF9900; width:14px; height:14px; flex-shrink:0; }
    .bp-sb-count { margin-left:auto; font-size:11px; color:#888; background:#f0f2f2; border-radius:99px; padding:2px 8px; }

    /* Price Range Slider */
    .bp-price-slider { padding:16px; }
    .bp-price-inputs { display:flex; gap:8px; align-items:center; margin-bottom:12px; }
    .bp-price-inputs input { flex:1; min-width:60px; border:1px solid #d5d9d9; border-radius:6px; padding:8px; font-size:13px; }
    .bp-price-inputs input:focus { border-color:#FF9900; outline:none; }
    .bp-price-inputs span { font-size:13px; color:#555; font-weight:500; padding:0 4px; }
    .bp-price-btn { background:#FFD814; color:#131921; border:1px solid #FCD200; border-radius:6px; padding:8px 16px; font-size:12px; font-weight:700; cursor:pointer; }
    .bp-price-btn:hover { background:#F7CA00; }

    /* ── Main ──────────────────────────────────────────── */
    .bp-main { flex:1; min-width:0; }

    /* Sort Bar */
    .bp-sortbar { background:#fff; border-radius:12px; padding:16px 20px; margin-bottom:20px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; box-shadow:0 2px 8px rgba(0,0,0,.04); }
    .bp-sort-left { font-size:14px; color:#555; }
    .bp-sort-left b { color:#0F1111; font-size:18px; }
    .bp-sort-right { display:flex; align-items:center; gap:12px; }
    .bp-sort-label { font-size:13px; color:#555; }
    .bp-sort-select { border:1px solid #d5d9d9; border-radius:8px; padding:8px 14px; font-size:13px; background:#fff; cursor:pointer; }
    .bp-sort-select:focus { border-color:#FF9900; outline:none; }

    /* Savings Banner */
    .bp-savings-banner { background:linear-gradient(135deg,#131921,#232f3e); border-radius:12px; padding:20px; margin-bottom:24px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px; }
    .bp-savings-text { color:#fff; }
    .bp-savings-text h3 { font-size:20px; font-weight:800; margin:0 0 4px; }
    .bp-savings-text p { font-size:14px; margin:0; opacity:.9; }
    .bp-savings-btn { background:#FFD814; color:#131921; border:none; border-radius:20px; padding:10px 24px; font-size:14px; font-weight:700; cursor:pointer; }
    .bp-savings-btn:hover { background:#F7CA00; }

    /* ── Product Grid ───────────────────────────────────── */
    .bp-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:20px; }

    /* ── Best Price Card ───────────────────────────────── */
    .bp-card { background:#fff; border:2px solid #e3e6e6; border-radius:12px; overflow:hidden; display:flex; flex-direction:column; position:relative; transition:all .2s; }
    .bp-card:hover { box-shadow:0 8px 30px rgba(0,0,0,.12); border-color:#FF9900; transform:translateY(-4px); }

    /* Badges */
    .bp-best-badge { position:absolute; top:12px; left:12px; background:#FF9900; color:#131921; font-size:11px; font-weight:900; padding:4px 10px; border-radius:4px; text-transform:uppercase; z-index:3; display:flex; align-items:center; gap:4px; }
    .bp-save-badge { position:absolute; top:12px; right:12px; background:#CC0C39; color:#fff; font-size:13px; font-weight:900; padding:6px 12px; border-radius:20px; z-index:3; }
    .bp-compare-badge { position:absolute; bottom:12px; left:12px; background:rgba(19,25,33,.9); color:#fff; font-size:11px; font-weight:600; padding:6px 12px; border-radius:6px; z-index:3; }

    /* Image */
    .bp-card-img { background:#f7f8f8; aspect-ratio:1/1; display:flex; align-items:center; justify-content:center; overflow:hidden; position:relative; }
    .bp-card-img img { max-width:80%; max-height:80%; object-fit:contain; transition:transform .3s; }
    .bp-card:hover .bp-card-img img { transform:scale(1.08); }

    /* Body */
    .bp-card-body { padding:16px; flex:1; display:flex; flex-direction:column; gap:6px; }
    .bp-card-brand { font-size:12px; color:#FF9900; font-weight:700; text-transform:uppercase; }
    .bp-card-name { font-size:14px; color:#0F1111; font-weight:500; line-height:1.4; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; min-height:40px; }

    /* Price Block */
    .bp-price-block { margin-top:auto; padding-top:12px; border-top:1px solid #f0f2f2; }
    .bp-price-row { display:flex; align-items:baseline; gap:8px; flex-wrap:wrap; margin-bottom:4px; }
    .bp-price-current { font-size:24px; font-weight:900; color:#B12704; }
    .bp-price-was { font-size:13px; color:#888; text-decoration:line-through; }
    .bp-price-save { font-size:11px; color:#CC0C39; font-weight:700; background:#FFF0F0; padding:2px 8px; border-radius:4px; display:inline-block; }

    /* Comparison */
    .bp-compare-row { display:flex; align-items:center; gap:8px; font-size:12px; color:#555; margin-top:8px; padding-top:8px; border-top:1px dashed #e3e6e6; }
    .bp-compare-dot { width:8px; height:8px; background:#FF9900; border-radius:50%; }
    .bp-compare-price { text-decoration:line-through; color:#888; }

    /* Rating */
    .bp-rating { display:flex; align-items:center; gap:6px; margin:4px 0; }
    .bp-stars { display:flex; gap:1px; }
    .bp-rating-text { font-size:12px; color:#007185; }

    /* Features */
    .bp-features { display:flex; gap:6px; flex-wrap:wrap; margin-top:8px; }
    .bp-feature { font-size:10px; background:#fff4e0; color:#FF9900; padding:3px 8px; border-radius:4px; font-weight:600; }

    /* Actions */
    .bp-card-actions { display:flex; gap:8px; margin-top:12px; }
    .bp-btn-cart { flex:1; display:flex; align-items:center; justify-content:center; gap:6px; background:#FFD814; border:1px solid #FCD200; border-radius:20px; padding:10px; font-size:13px; font-weight:700; color:#131921; cursor:pointer; text-decoration:none; transition:all .15s; }
    .bp-btn-cart:hover { background:#F7CA00; }
    .bp-btn-compare { width:40px; display:flex; align-items:center; justify-content:center; background:#fff; border:1px solid #d5d9d9; border-radius:20px; cursor:pointer; color:#555; }
    .bp-btn-compare:hover { border-color:#FF9900; color:#FF9900; }

    /* ── Empty ─────────────────────────────────────────── */
    .bp-empty { text-align:center; padding:80px 20px; background:#fff; border-radius:12px; }

    /* ── Price Match Banner ─────────────────────────────── */
    .bp-match-banner { background:linear-gradient(135deg,#131921,#1a2a3a); border-radius:12px; padding:30px; margin-top:40px; text-align:center; color:#fff; }
    .bp-match-banner h3 { font-size:24px; font-weight:800; margin:0 0 12px; }
    .bp-match-banner h3 span { color:#FF9900; }
    .bp-match-banner p { font-size:15px; color:#adbac7; margin:0 auto 20px; max-width:500px; }
    .bp-match-btn { display:inline-flex; align-items:center; gap:8px; background:#FFD814; color:#131921; border:none; border-radius:20px; padding:12px 28px; font-size:14px; font-weight:700; cursor:pointer; text-decoration:none; }
    .bp-match-btn:hover { background:#F7CA00; }

    @media (max-width:900px) {
        .bp-wrap { flex-direction:column; }
        .bp-sidebar { width:100%; }
        .bp-grid { grid-template-columns:repeat(2,1fr); }
    }
    @media (max-width:480px) {
        .bp-grid { grid-template-columns:1fr; }
        .bp-hero h1 { font-size:28px; }
    }
</style>
@endsection

@section('content')
@php
    /* ── Helpers ─────────────────────────────────── */
    $discounts    = [10,15,20,25,30,35,40,45,50];
    $savings      = ['Under $25','$25-$50','$50-$100','$100-$200','$200+'];
    $valueTiers   = [
        ['key'=>'all','label'=>'All Deals','icon'=>'🏷️'],
        ['key'=>'clearance','label'=>'Clearance','icon'=>'🏷️'],
        ['key'=>'bundle','label'=>'Bundle & Save','icon'=>'📦'],
        ['key'=>'openbox','label'=>'Open Box','icon'=>'📦'],
        ['key'=>'refurb','label'=>'Refurbished','icon'=>'♻️'],
    ];
    $compares     = ['Amazon','Walmart','Target','Best Buy'];
    $ratings      = [3.5,4.0,4.2,4.4,4.6,4.8,5.0];
    $reviews      = [12,28,45,78,120,200,350];

    function bpDisc($id,$arr){ return $arr[$id % count($arr)]; }
    function bpStars($r){
        $f=floor($r);$h=($r-$f)>=0.5?1:0;$e=5-$f-$h;$o='';
        for($i=0;$i<$f;$i++)  $o.='<svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        if($h) $o.='<svg width="12" height="12" viewBox="0 0 24 24" fill="#ddd"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        for($i=0;$i<$e;$i++)  $o.='<svg width="12" height="12" viewBox="0 0 24 24" fill="#ddd"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        return $o;
    }

    $activeTier   = request('tier','all');
    $activeCat    = request('category');
    $activeBrand  = request('brand');
    $activeSort   = request('sort','price_asc');
    $activeRange  = request('range');
@endphp

<div class="bp-page">

{{-- Hero --}}
<div class="bp-hero">
    <div class="bp-hero-inner">
        <div class="bp-hero-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            Price Match Guaranteed
        </div>
        <h1>Best <span>Price</span> Promise</h1>
        <p>Find the lowest prices on thousands of products. We match any price + give you an extra 5% off. Guaranteed best deals every day.</p>
        <div class="bp-hero-stats">
            <div class="bp-stat">
                <div class="bp-stat-num">{{ $products->count() }}+</div>
                <div class="bp-stat-label">Low Price Items</div>
            </div>
            <div class="bp-stat">
                <div class="bp-stat-num">50%</div>
                <div class="bp-stat-label">Max Savings</div>
            </div>
            <div class="bp-stat">
                <div class="bp-stat-num">5%</div>
                <div class="bp-stat-label">Extra Off</div>
            </div>
        </div>
    </div>
</div>

{{-- Promise Banner --}}
<div class="bp-promise">
    <div class="bp-promise-inner">
        <div class="bp-promise-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Lowest Price Guarantee
        </div>
        <div class="bp-promise-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
            30-Day Price Protection
        </div>
        <div class="bp-promise-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            Free Shipping $25+
        </div>
    </div>
</div>

{{-- Value Tiers --}}
<div class="bp-tiers-bar">
    <div class="bp-tiers-inner">
        @foreach($valueTiers as $tier)
        <a href="{{ route('best-price', array_merge(request()->except('tier'),['tier'=>$tier['key']])) }}" class="bp-tier-tab {{ $activeTier==$tier['key'] ? 'active' : '' }}">
            <span class="bp-tier-icon">{{ $tier['icon'] }}</span>
            {{ $tier['label'] }}
        </a>
        @endforeach
    </div>
</div>

{{-- Deals Chips --}}
<div class="bp-deals-bar">
    <div class="bp-deals-inner">
        <a href="{{ route('best-price') }}" class="bp-deal-chip active">🔥 All Best Prices</a>
        @foreach($categories->take(6) as $cat)
        <a href="{{ route('best-price', array_merge(request()->except('category'),['category'=>$cat->id])) }}" class="bp-deal-chip {{ $activeCat==$cat->id ? 'active' : '' }}">
            💰 {{ $cat->name }} Deals
        </a>
        @endforeach
    </div>
</div>

{{-- Breadcrumb --}}
<div style="background:#fff;border-bottom:1px solid #e3e6e6;">
    <div class="bp-breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span>›</span>
        <span style="color:#0F1111;font-weight:500;">Best Price</span>
        @if($activeTier!='all')<span>›</span><span style="color:#007600;text-transform:capitalize;">{{ $activeTier }}</span>@endif
    </div>
</div>

{{-- Body --}}
<div class="bp-wrap">

    {{-- SIDEBAR --}}
    <div class="bp-sidebar">

        {{-- Savings Range --}}
        <div class="bp-sb-box">
            <div class="bp-sb-head">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                Savings Amount
            </div>
            <div class="bp-sb-body">
                @foreach($savings as $i => $range)
                <a href="{{ route('best-price', array_merge(request()->all(),['range'=>$i])) }}" class="bp-sb-item {{ $activeRange==$i ? 'active' : '' }}">
                    <input type="radio" {{ $activeRange==$i ? 'checked' : '' }} readonly />
                    {{ $range }}
                    <span class="bp-sb-count">{{ rand(5,50) }}</span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Category --}}
        <div class="bp-sb-box">
            <div class="bp-sb-head">Department</div>
            <div class="bp-sb-body">
                <a href="{{ route('best-price', request()->except('category')) }}" class="bp-sb-item {{ !$activeCat ? 'active' : '' }}">
                    <input type="radio" {{ !$activeCat ? 'checked' : '' }} readonly /> All Departments
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('best-price', array_merge(request()->except('category'),['category'=>$cat->id])) }}" class="bp-sb-item {{ $activeCat==$cat->id ? 'active' : '' }}">
                    <input type="radio" {{ $activeCat==$cat->id ? 'checked' : '' }} readonly />
                    {{ $cat->name }}
                    <span class="bp-sb-count">{{ rand(3,40) }}</span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Brand --}}
        <div class="bp-sb-box">
            <div class="bp-sb-head">Brand</div>
            <div class="bp-sb-body">
                <a href="{{ route('best-price', request()->except('brand')) }}" class="bp-sb-item {{ !$activeBrand ? 'active' : '' }}">
                    <input type="radio" {{ !$activeBrand ? 'checked' : '' }} readonly /> All Brands
                </a>
                @foreach($brands->take(8) as $brand)
                <a href="{{ route('best-price', array_merge(request()->except('brand'),['brand'=>$brand->id])) }}" class="bp-sb-item {{ $activeBrand==$brand->id ? 'active' : '' }}">
                    <input type="radio" {{ $activeBrand==$brand->id ? 'checked' : '' }} readonly /> {{ $brand->name }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Price Range --}}
        <div class="bp-sb-box">
            <div class="bp-sb-head">Price Range</div>
            <div class="bp-price-slider">
                <div class="bp-price-inputs">
                    <input type="number" placeholder="Min" value="{{ request('min_price') }}" id="bp-min" />
                    <span>to</span>
                    <input type="number" placeholder="Max" value="{{ request('max_price') }}" id="bp-max" />
                </div>
                <button class="bp-price-btn" onclick="bpApplyPrice()">Apply</button>
            </div>
        </div>

    </div>

    {{-- MAIN --}}
    <div class="bp-main">

        {{-- Sort Bar --}}
        <div class="bp-sortbar">
            <div class="bp-sort-left"><b>{{ $products->count() }}</b> best price deals found</div>
            <div class="bp-sort-right">
                <span class="bp-sort-label">Sort by:</span>
                <select class="bp-sort-select" onchange="window.location.href=this.value">
                    <option value="{{ route('best-price', array_merge(request()->all(),['sort'=>'price_asc'])) }}" {{ $activeSort=='price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="{{ route('best-price', array_merge(request()->all(),['sort'=>'price_desc'])) }}" {{ $activeSort=='price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="{{ route('best-price', array_merge(request()->all(),['sort'=>'savings'])) }}" {{ $activeSort=='savings' ? 'selected' : '' }}>Biggest Savings</option>
                    <option value="{{ route('best-price', array_merge(request()->all(),['sort'=>'rating'])) }}" {{ $activeSort=='rating' ? 'selected' : '' }}>Best Rated</option>
                    <option value="{{ route('best-price', array_merge(request()->all(),['sort'=>'popular'])) }}" {{ $activeSort=='popular' ? 'selected' : '' }}>Most Popular</option>
                </select>
            </div>
        </div>

        {{-- Savings Banner --}}
        <div class="bp-savings-banner">
            <div class="bp-savings-text">
                <h3>💰 Save More Today</h3>
                <p>Extra 5% off when you buy 2+ items. Auto-applied at checkout.</p>
            </div>
            <button class="bp-savings-btn">Shop Now</button>
        </div>

        {{-- Product Grid --}}
        @if($products->isEmpty())
        <div class="bp-empty">
            <div style="font-size:64px;margin-bottom:16px;">🏷️</div>
            <h3 style="font-size:20px;font-weight:700;margin-bottom:8px;">No deals found</h3>
            <p style="color:#555;margin-bottom:16px;">Try adjusting your filters or browse all departments.</p>
            <a href="{{ route('best-price') }}" style="color:#007600;font-weight:600;">Clear all filters</a>
        </div>
        @else
        <div class="bp-grid">
            @foreach($products as $product)
            @php
                $disc        = bpDisc($product->id, $discounts);
                $wasPrice    = round($product->price * (100 + $disc) / 100, 2);
                $saveAmt     = round($wasPrice - $product->price, 2);
                $comparePrice= round($product->price * 1.15, 2);
                $pRating     = $ratings[$product->id % count($ratings)];
                $pReviews    = $reviews[$product->id % count($reviews)];
                $compareStore= $compares[$product->id % count($compares)];
                $brandName   = $product->brand ? $product->brand->name : 'Top Brand';
                $imgs        = collect($product->images ?? [])->filter()->values();
                $thumb       = $imgs->first() ? \Illuminate\Support\Facades\Storage::url($imgs->first()) : null;
            @endphp
            <div class="bp-card" onclick="window.location='{{ route('products.show', $product->slug) }}'">

                <div class="bp-best-badge">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    Best Price
                </div>
                <div class="bp-save-badge">-{{ $disc }}%</div>

                <div class="bp-card-img">
                    @if($thumb)
                        <img src="{{ $thumb }}" alt="{{ $product->name }}" loading="lazy" />
                    @else
                        <div style="font-size:60px;opacity:.2;">🏷️</div>
                    @endif
                    <div class="bp-compare-badge">vs {{ $compareStore }}: ${{ number_format($comparePrice, 2) }}</div>
                </div>

                <div class="bp-card-body">
                    <div class="bp-card-brand">{{ $brandName }}</div>
                    <div class="bp-card-name">{{ $product->name }}</div>

                    <div class="bp-rating">
                        <div class="bp-stars">{!! bpStars($pRating) !!}</div>
                        <span class="bp-rating-text">{{ $pRating }} ({{ $pReviews }})</span>
                    </div>

                    <div class="bp-price-block">
                        <div class="bp-price-row">
                            <span class="bp-price-current">${{ number_format($product->price, 2) }}</span>
                            <span class="bp-price-was">${{ number_format($wasPrice, 2) }}</span>
                        </div>
                        <span class="bp-price-save">Save ${{ number_format($saveAmt, 2) }}</span>
                    </div>

                    <div class="bp-compare-row">
                        <span class="bp-compare-dot"></span>
                        <span>Lowest price vs</span>
                        <span class="bp-compare-price">${{ number_format($comparePrice, 2) }} at {{ $compareStore }}</span>
                    </div>

                    <div class="bp-features">
                        <span class="bp-feature">✓ Price Match</span>
                        <span class="bp-feature">✓ Free Returns</span>
                    </div>

                    <div class="bp-card-actions">
                        <a href="{{ route('products.show', $product->slug) }}" class="bp-btn-cart" onclick="event.stopPropagation();">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            Add to Cart
                        </a>
                        <button class="bp-btn-compare" onclick="event.stopPropagation(); bpAddToCompare(this)" title="Compare">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Price Match Banner --}}
        <div class="bp-match-banner">
            <h3>Found a Lower <span>Price?</span></h3>
            <p>We'll match any verified competitor price and give you an extra 5% off. That's our Best Price Promise.</p>
            <button class="bp-match-btn" onclick="bpShowPriceMatch()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                Request Price Match
            </button>
        </div>

        @endif
    </div>
</div>
</div>

<script>
function bpApplyPrice() {
    const min = document.getElementById('bp-min').value;
    const max = document.getElementById('bp-max').value;
    const url = new URL(window.location.href);
    if(min) url.searchParams.set('min_price', min); else url.searchParams.delete('min_price');
    if(max) url.searchParams.set('max_price', max); else url.searchParams.delete('max_price');
    window.location.href = url.toString();
}

function bpAddToCompare(btn) {
    btn.classList.toggle('active');
    btn.style.background = btn.classList.contains('active') ? '#007600' : '#fff';
    btn.style.color = btn.classList.contains('active') ? '#fff' : '#555';
    bpToast(btn.classList.contains('active') ? 'Added to compare' : 'Removed from compare');
}

function bpShowPriceMatch() {
    bpToast('💰 Price match form coming soon!');
}

function bpToast(msg) {
    let t = document.getElementById('bpToast');
    if(!t) {
        t = document.createElement('div');
        t.id = 'bpToast';
        t.style.cssText = 'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#007600;color:#fff;padding:12px 24px;border-radius:8px;font-size:14px;z-index:99999;box-shadow:0 4px 16px rgba(0,0,0,.3);font-weight:600;';
        document.body.appendChild(t);
    }
    t.textContent = msg;
    t.style.opacity = '1';
    clearTimeout(t._t);
    t._t = setTimeout(() => { t.style.opacity = '0'; }, 2500);
}
</script>
@endsection
