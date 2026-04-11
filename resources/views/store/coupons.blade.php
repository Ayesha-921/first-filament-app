@extends('store.layout')
@section('title', 'Coupons & Promo Codes — MyShop')

@section('head')
<style>
    /* ── Page ───────────────────────────────────────── */
    .cp-page { background: #EAEDED; min-height: 80vh; }

    /* ── Hero banner ────────────────────────────────── */
    .cp-hero { background: linear-gradient(100deg,#131921 0%,#1a2a40 60%,#0d2137 100%); padding: 28px 18px; }
    .cp-hero-inner { max-width: 1340px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap; }
    .cp-hero-left h1 { font-size: 28px; font-weight: 900; color: #fff; margin: 0 0 8px; }
    .cp-hero-left h1 span { color: #FF9900; }
    .cp-hero-left p { font-size: 14px; color: #99a8bb; margin: 0; }
    .cp-hero-stats { display: flex; gap: 28px; flex-wrap: wrap; }
    .cp-hero-stat { text-align: center; }
    .cp-hero-stat-num { font-size: 26px; font-weight: 900; color: #FF9900; line-height: 1; }
    .cp-hero-stat-label { font-size: 11px; color: #99a8bb; text-transform: uppercase; letter-spacing: .5px; margin-top: 3px; }

    /* ── Breadcrumb ─────────────────────────────────── */
    .cp-breadcrumb { max-width: 1340px; margin: 0 auto; padding: 10px 18px; font-size: 13px; color: #555; background: #fff; border-bottom: 1px solid #e3e6e6; }
    .cp-breadcrumb a { color: #007185; }
    .cp-breadcrumb a:hover { color: #C7511F; text-decoration: underline; }

    /* ── Category tabs ──────────────────────────────── */
    .cp-tabs-wrap { background: #fff; border-bottom: 1px solid #e3e6e6; }
    .cp-tabs { max-width: 1340px; margin: 0 auto; padding: 0 18px; display: flex; gap: 0; overflow-x: auto; scrollbar-width: none; }
    .cp-tabs::-webkit-scrollbar { display: none; }
    .cp-tab { display: inline-flex; align-items: center; gap: 6px; padding: 13px 18px; font-size: 13px; font-weight: 500; color: #555; white-space: nowrap; border-bottom: 3px solid transparent; cursor: pointer; text-decoration: none; transition: color .12s, border-color .12s; flex-shrink: 0; }
    .cp-tab:hover { color: #C7511F; border-bottom-color: #FF9900; }
    .cp-tab.active { color: #C7511F; border-bottom-color: #FF9900; font-weight: 700; }

    /* ── Layout ─────────────────────────────────────── */
    .cp-wrap { max-width: 1340px; margin: 0 auto; padding: 20px 18px 40px; display: flex; gap: 20px; align-items: flex-start; }

    /* ── Sidebar ────────────────────────────────────── */
    .cp-sidebar { width: 210px; flex-shrink: 0; }
    .cp-sb-box { background: #fff; border: 1px solid #e3e6e6; border-radius: 8px; padding: 0; margin-bottom: 14px; overflow: hidden; }
    .cp-sb-head { font-size: 14px; font-weight: 700; color: #0F1111; padding: 12px 16px 10px; border-bottom: 1px solid #f0f2f2; background: #f7f8f8; }
    .cp-sb-body { padding: 8px 0; }
    .cp-sb-item { display: flex; align-items: center; gap: 9px; padding: 8px 16px; font-size: 13px; color: #0F1111; cursor: pointer; text-decoration: none; transition: background .1s; border-left: 3px solid transparent; }
    .cp-sb-item:hover { background: #fff8ee; border-left-color: #FF9900; color: #C7511F; }
    .cp-sb-item.active { background: #fff4e0; border-left-color: #FF9900; font-weight: 700; color: #C7511F; }
    .cp-sb-item input[type=radio] { accent-color: #FF9900; width: 14px; height: 14px; flex-shrink: 0; }
    .cp-sb-divider { border: none; border-top: 1px solid #f0f2f2; margin: 4px 0; }

    /* ── Main area ──────────────────────────────────── */
    .cp-main { flex: 1; min-width: 0; }
    .cp-topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-wrap: wrap; gap: 10px; }
    .cp-topbar-left { font-size: 14px; color: #555; }
    .cp-topbar-left b { color: #0F1111; }
    .cp-topbar-right { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #555; }
    .cp-topbar-right select { border: 1px solid #d5d9d9; border-radius: 6px; padding: 6px 10px; font-size: 13px; background: #fff; cursor: pointer; outline: none; }

    /* ── Coupon grid ────────────────────────────────── */
    .cp-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px; }

    /* ── Coupon card ────────────────────────────────── */
    .coupon-card { background: #fff; border: 1px solid #e3e6e6; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; position: relative; transition: box-shadow .15s, border-color .15s; }
    .coupon-card:hover { box-shadow: 0 4px 18px rgba(0,0,0,.12); border-color: #FF9900; }
    .coupon-card.clipped { border-color: #007600; }
    .coupon-card.clipped .coupon-card-header { background: linear-gradient(135deg,#007600,#00a300); }

    /* Card header with discount */
    .coupon-card-header { background: linear-gradient(135deg,#CC0C39,#e8003d); color: #fff; padding: 14px 16px 12px; position: relative; overflow: hidden; }
    .coupon-card-header::after { content:''; position:absolute; right:-20px; top:-20px; width:80px; height:80px; background:rgba(255,255,255,.08); border-radius:50%; }
    .coupon-card-header::before { content:''; position:absolute; right:10px; bottom:-15px; width:50px; height:50px; background:rgba(255,255,255,.06); border-radius:50%; }
    .coupon-discount { font-size: 32px; font-weight: 900; line-height: 1; letter-spacing: -1px; }
    .coupon-discount span { font-size: 15px; font-weight: 600; vertical-align: super; }
    .coupon-type { font-size: 12px; opacity: .85; margin-top: 2px; }
    .coupon-badge { position: absolute; top: 12px; right: 14px; background: rgba(255,255,255,.2); border: 1px solid rgba(255,255,255,.3); border-radius: 20px; padding: 3px 10px; font-size: 11px; font-weight: 700; }
    .coupon-badge.exclusive { background: #FFD814; color: #131921; border-color: #FFC400; }

    /* Notch effect — dashed separator */
    .coupon-notch { display: flex; align-items: center; gap: 0; background: #f7f8f8; border-top: 1px dashed #d5d9d9; border-bottom: 1px dashed #d5d9d9; }
    .coupon-notch-circle { width: 20px; height: 20px; border-radius: 50%; background: #EAEDED; flex-shrink: 0; }
    .coupon-notch-circle.left { margin-left: -10px; border: 1px solid #e3e6e6; }
    .coupon-notch-circle.right { margin-right: -10px; border: 1px solid #e3e6e6; margin-left: auto; }
    .coupon-code-wrap { flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 9px 10px; }
    .coupon-code { font-family: 'Courier New', monospace; font-size: 14px; font-weight: 800; color: #0F1111; letter-spacing: 2px; background: #fff; border: 1px dashed #aaa; border-radius: 5px; padding: 4px 12px; }
    .coupon-copy-btn { background: none; border: none; cursor: pointer; color: #007185; padding: 4px; border-radius: 4px; display: flex; align-items: center; transition: color .12s; }
    .coupon-copy-btn:hover { color: #C7511F; }

    /* Body */
    .coupon-card-body { padding: 12px 14px 14px; flex: 1; display: flex; flex-direction: column; gap: 8px; }
    .coupon-product-row { display: flex; align-items: center; gap: 10px; }
    .coupon-product-img { width: 52px; height: 52px; background: #f7f8f8; border: 1px solid #e3e6e6; border-radius: 6px; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0; }
    .coupon-product-img img { max-width: 46px; max-height: 46px; object-fit: contain; }
    .coupon-product-info { flex: 1; min-width: 0; }
    .coupon-brand { font-size: 11px; color: #007185; font-weight: 700; text-transform: uppercase; letter-spacing: .3px; }
    .coupon-product-name { font-size: 13px; color: #0F1111; line-height: 1.4; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; margin-top: 2px; }

    .coupon-stars { display: flex; align-items: center; gap: 2px; }
    .coupon-stars span { font-size: 11px; color: #555; margin-left: 3px; }

    .coupon-price-row { display: flex; align-items: baseline; gap: 7px; }
    .coupon-price-after { font-size: 18px; font-weight: 800; color: #B12704; }
    .coupon-price-before { font-size: 13px; color: #888; }
    .coupon-price-before s { color: #aaa; }
    .coupon-save-badge { background: #FF9900; color: #131921; font-size: 11px; font-weight: 800; border-radius: 4px; padding: 2px 7px; }

    .coupon-expiry { display: flex; align-items: center; gap: 5px; font-size: 11px; color: #888; }
    .coupon-expiry.urgent { color: #CC0C39; font-weight: 600; }
    .coupon-expiry svg { flex-shrink: 0; }

    .coupon-min-spend { font-size: 11px; color: #555; background: #f7f8f8; border-radius: 4px; padding: 4px 8px; }

    /* Clip button */
    .coupon-clip-btn { width: 100%; background: #FFD814; border: 1px solid #FCD200; border-radius: 20px; padding: 9px; font-size: 13px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 7px; transition: background .12s, transform .1s; color: #131921; margin-top: 4px; }
    .coupon-clip-btn:hover { background: #F7CA00; transform: translateY(-1px); }
    .coupon-clip-btn.clipped-state { background: #007600; border-color: #005a00; color: #fff; }
    .coupon-clip-btn.clipped-state:hover { background: #006400; }

    /* ── Info banner ────────────────────────────────── */
    .cp-info-banner { background: #fff8ee; border: 1px solid #FFD580; border-radius: 8px; padding: 12px 16px; margin-bottom: 18px; display: flex; align-items: flex-start; gap: 10px; font-size: 13px; color: #6a3e00; }
    .cp-info-banner svg { flex-shrink: 0; margin-top: 1px; }

    /* ── How it works ───────────────────────────────── */
    .cp-how { background: #fff; border: 1px solid #e3e6e6; border-radius: 8px; padding: 20px; margin-top: 28px; }
    .cp-how h3 { font-size: 16px; font-weight: 700; color: #0F1111; margin: 0 0 16px; display: flex; align-items: center; gap: 8px; }
    .cp-how-steps { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; }
    .cp-how-step { display: flex; flex-direction: column; align-items: center; text-align: center; gap: 8px; }
    .cp-how-step-num { width: 36px; height: 36px; border-radius: 50%; background: #FF9900; color: #131921; font-size: 16px; font-weight: 900; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .cp-how-step h4 { font-size: 13px; font-weight: 700; color: #0F1111; margin: 0; }
    .cp-how-step p { font-size: 12px; color: #555; margin: 0; line-height: 1.5; }

    @media (max-width: 740px) {
        .cp-wrap { flex-direction: column; }
        .cp-sidebar { width: 100%; }
        .cp-grid { grid-template-columns: 1fr; }
        .cp-hero-inner { flex-direction: column; }
    }
</style>
@endsection

@section('content')
@php
    /* helpers */
    $discounts   = [5,10,15,20,25,30,40,50];
    $minSpends   = [0, 25, 50, 75, 100, 150, 200];
    $codeWords   = ['SAVE','DEAL','OFF','MYSHOP','CLIP','FLASH','MEGA','SUPER'];
    $couponTypes = ['% off product','$ off order','Free shipping','Buy 1 get 1'];
    $daysLeft    = [1,2,3,5,7,10,14,30];
    $ratings     = [3.8,4.0,4.1,4.2,4.3,4.5,4.6,4.7,4.8];
    $reviews     = [47,83,124,207,315,498,1024,2387];
    $isExclusive = [true,false,false,true,false,false,true,false];
    $isClipped   = [false,false,true,false,true,false,false,false];

    function cpDisc($id,$arr) { return $arr[$id % count($arr)]; }
    function cpCode($id,$words,$disc) {
        return $words[$id % count($words)] . $disc;
    }
    function cpStars($r) {
        $f=floor($r);$h=($r-$f)>=0.5?1:0;$e=5-$f-$h;
        $o='';
        for($i=0;$i<$f;$i++) $o.='<svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        if($h) $o.='<svg width="12" height="12" viewBox="0 0 24 24" fill="#ddd" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        for($i=0;$i<$e;$i++) $o.='<svg width="12" height="12" viewBox="0 0 24 24" fill="#ddd" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        return $o;
    }
    $activeFilter = request('filter', 'all');
    $activeCat    = request('category');
@endphp

<div class="cp-page">

{{-- Hero --}}
<div class="cp-hero">
    <div class="cp-hero-inner">
        <div class="cp-hero-left">
            <h1><span>Coupons</span> &amp; Promo Codes</h1>
            <p>Clip coupons, save instantly at checkout. New deals added every day.</p>
        </div>
        <div class="cp-hero-stats">
            <div class="cp-hero-stat">
                <div class="cp-hero-stat-num">{{ $products->count() }}+</div>
                <div class="cp-hero-stat-label">Active Coupons</div>
            </div>
            <div class="cp-hero-stat">
                <div class="cp-hero-stat-num">60%</div>
                <div class="cp-hero-stat-label">Max Savings</div>
            </div>
            <div class="cp-hero-stat">
                <div class="cp-hero-stat-num">Free</div>
                <div class="cp-hero-stat-label">Shipping Deals</div>
            </div>
        </div>
    </div>
</div>

{{-- Breadcrumb --}}
<div style="background:#fff;border-bottom:1px solid #e3e6e6;">
    <div class="cp-breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span>›</span>
        <span style="color:#0F1111;">Coupons &amp; Promo Codes</span>
    </div>
</div>

{{-- Category tabs --}}
<div class="cp-tabs-wrap">
    <div class="cp-tabs">
        <a href="{{ route('coupons') }}" class="cp-tab {{ $activeFilter=='all' && !$activeCat ? 'active' : '' }}">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
            All Coupons
        </a>
        <a href="{{ route('coupons', ['filter'=>'clipped']) }}" class="cp-tab {{ $activeFilter=='clipped' ? 'active' : '' }}">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            My Clipped Coupons
        </a>
        <a href="{{ route('coupons', ['filter'=>'expiring']) }}" class="cp-tab {{ $activeFilter=='expiring' ? 'active' : '' }}">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Expiring Soon
        </a>
        <a href="{{ route('coupons', ['filter'=>'exclusive']) }}" class="cp-tab {{ $activeFilter=='exclusive' ? 'active' : '' }}">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            Exclusive Deals
        </a>
        @foreach($categories->take(8) as $cat)
        <a href="{{ route('coupons', ['category'=>$cat->id]) }}" class="cp-tab {{ $activeCat==$cat->id ? 'active' : '' }}">
            {{ $cat->name }}
        </a>
        @endforeach
    </div>
</div>

{{-- Body --}}
<div class="cp-wrap">

    {{-- SIDEBAR --}}
    <div class="cp-sidebar">

        {{-- Filter type --}}
        <div class="cp-sb-box">
            <div class="cp-sb-head">Coupon Type</div>
            <div class="cp-sb-body">
                <a href="{{ route('coupons', array_merge(request()->except('type'), [])) }}" class="cp-sb-item {{ !request('type') ? 'active' : '' }}">
                    <input type="radio" {{ !request('type') ? 'checked' : '' }} readonly /> All Types
                </a>
                @foreach(['percentage'=>'% Off Products','fixed'=>'$ Off Order','shipping'=>'Free Shipping','bogo'=>'Buy 1 Get 1'] as $key=>$label)
                <a href="{{ route('coupons', array_merge(request()->except('type'), ['type'=>$key])) }}" class="cp-sb-item {{ request('type')==$key ? 'active' : '' }}">
                    <input type="radio" {{ request('type')==$key ? 'checked' : '' }} readonly /> {{ $label }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Category --}}
        @if($categories->isNotEmpty())
        <div class="cp-sb-box">
            <div class="cp-sb-head">Category</div>
            <div class="cp-sb-body">
                <a href="{{ route('coupons', request()->except('category')) }}" class="cp-sb-item {{ !$activeCat ? 'active' : '' }}">
                    <input type="radio" {{ !$activeCat ? 'checked' : '' }} readonly /> All Categories
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('coupons', array_merge(request()->except('category'), ['category'=>$cat->id])) }}" class="cp-sb-item {{ $activeCat==$cat->id ? 'active' : '' }}">
                    <input type="radio" {{ $activeCat==$cat->id ? 'checked' : '' }} readonly /> {{ $cat->name }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Brand --}}
        @if($brands->isNotEmpty())
        <div class="cp-sb-box">
            <div class="cp-sb-head">Brand</div>
            <div class="cp-sb-body">
                @foreach($brands->take(10) as $brand)
                <a href="{{ route('coupons', array_merge(request()->except('brand'), ['brand'=>$brand->id])) }}" class="cp-sb-item {{ request('brand')==$brand->id ? 'active' : '' }}">
                    <input type="radio" {{ request('brand')==$brand->id ? 'checked' : '' }} readonly /> {{ $brand->name }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Discount range --}}
        <div class="cp-sb-box">
            <div class="cp-sb-head">Discount</div>
            <div class="cp-sb-body">
                @foreach(['10'=>'10% & above','25'=>'25% & above','40'=>'40% & above','50'=>'50% & above'] as $val=>$label)
                <a href="{{ route('coupons', array_merge(request()->except('min_disc'), ['min_disc'=>$val])) }}" class="cp-sb-item {{ request('min_disc')==$val ? 'active' : '' }}">
                    <input type="radio" {{ request('min_disc')==$val ? 'checked' : '' }} readonly /> {{ $label }}
                </a>
                @endforeach
            </div>
        </div>

    </div>

    {{-- MAIN --}}
    <div class="cp-main">

        {{-- Info banner --}}
        <div class="cp-info-banner">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span>Click <b>"Clip Coupon"</b> to save the coupon. Discount is automatically applied at checkout when the coupon is clipped. One coupon per order per product.</span>
        </div>

        {{-- Topbar --}}
        <div class="cp-topbar">
            <div class="cp-topbar-left"><b>{{ $products->count() }}</b> coupons available</div>
            <div class="cp-topbar-right">
                Sort by:
                <select onchange="window.location.href=this.value">
                    <option value="{{ route('coupons', array_merge(request()->all(), ['sort'=>'featured'])) }}" {{ request('sort','featured')=='featured' ? 'selected' : '' }}>Featured</option>
                    <option value="{{ route('coupons', array_merge(request()->all(), ['sort'=>'discount'])) }}" {{ request('sort')=='discount' ? 'selected' : '' }}>Highest Discount</option>
                    <option value="{{ route('coupons', array_merge(request()->all(), ['sort'=>'expiry'])) }}" {{ request('sort')=='expiry' ? 'selected' : '' }}>Expiring Soon</option>
                    <option value="{{ route('coupons', array_merge(request()->all(), ['sort'=>'newest'])) }}" {{ request('sort')=='newest' ? 'selected' : '' }}>Newest First</option>
                </select>
            </div>
        </div>

        {{-- Coupon grid --}}
        @if($products->isEmpty())
            <div style="text-align:center;padding:60px 20px;background:#fff;border-radius:8px;border:1px solid #e3e6e6;">
                <svg width="72" height="72" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="margin:0 auto 16px;display:block;"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                <h3 style="font-size:18px;font-weight:700;color:#0F1111;margin-bottom:8px;">No coupons available</h3>
                <p style="font-size:14px;color:#555;">Check back soon — new coupons are added daily.</p>
            </div>
        @else
        <div class="cp-grid">
            @foreach($products as $product)
            @php
                $imgs     = collect($product->images ?? [])->filter()->values();
                $thumb    = $imgs->first() ? \Illuminate\Support\Facades\Storage::url($imgs->first()) : null;
                $disc     = cpDisc($product->id, $discounts);
                $code     = cpCode($product->id, $codeWords, $disc);
                $minSpend = cpDisc($product->id, $minSpends);
                $days     = cpDisc($product->id, $daysLeft);
                $exclusive= $isExclusive[$product->id % count($isExclusive)];
                $clipped  = $isClipped[$product->id % count($isClipped)];
                $type     = $couponTypes[$product->id % count($couponTypes)];
                $rating   = $ratings[$product->id % count($ratings)];
                $rev      = $reviews[$product->id % count($reviews)];
                $saveAmt  = round($product->price * $disc / 100, 2);
                $afterP   = round($product->price - $saveAmt, 2);
            @endphp
            <div class="coupon-card {{ $clipped ? 'clipped' : '' }}">

                {{-- Header --}}
                <div class="coupon-card-header">
                    <div class="coupon-discount"><span>{{ $disc > 0 ? ($type == '% off product' ? '' : '$') : '' }}</span>{{ $disc }}{{ $type == '% off product' ? '%' : '' }}</div>
                    <div class="coupon-type">{{ $type }}</div>
                    @if($exclusive)
                        <div class="coupon-badge exclusive">
                            <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            Exclusive
                        </div>
                    @else
                        <div class="coupon-badge">Limited</div>
                    @endif
                </div>

                {{-- Coupon code notch --}}
                <div class="coupon-notch">
                    <div class="coupon-notch-circle left"></div>
                    <div class="coupon-code-wrap">
                        <span class="coupon-code" id="code-{{ $product->id }}">{{ $code }}</span>
                        <button class="coupon-copy-btn" onclick="copyCode('{{ $code }}', this)" title="Copy code">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                        </button>
                    </div>
                    <div class="coupon-notch-circle right"></div>
                </div>

                {{-- Body --}}
                <div class="coupon-card-body">
                    {{-- Product --}}
                    <div class="coupon-product-row">
                        <div class="coupon-product-img">
                            @if($thumb)
                                <img src="{{ $thumb }}" alt="{{ $product->name }}" />
                            @else
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#d5d9d9" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            @endif
                        </div>
                        <div class="coupon-product-info">
                            @if($product->brand)
                                <div class="coupon-brand">{{ $product->brand->name }}</div>
                            @endif
                            <div class="coupon-product-name">{{ $product->name }}</div>
                        </div>
                    </div>

                    {{-- Stars --}}
                    <div class="coupon-stars">
                        {!! cpStars($rating) !!}
                        <span>{{ $rating }} ({{ number_format($rev) }})</span>
                    </div>

                    {{-- Price --}}
                    <div class="coupon-price-row">
                        <span class="coupon-price-after">${{ number_format($afterP, 2) }}</span>
                        <span class="coupon-price-before">was <s>${{ number_format($product->price, 2) }}</s></span>
                        <span class="coupon-save-badge">Save ${{ number_format($saveAmt, 2) }}</span>
                    </div>

                    {{-- Min spend --}}
                    @if($minSpend > 0)
                    <div class="coupon-min-spend">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:middle;margin-right:3px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Min. spend ${{ $minSpend }}
                    </div>
                    @endif

                    {{-- Expiry --}}
                    <div class="coupon-expiry {{ $days <= 3 ? 'urgent' : '' }}">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        @if($days <= 3)
                            Expires in {{ $days }} day{{ $days > 1 ? 's' : '' }} — Act fast!
                        @else
                            Valid for {{ $days }} more days
                        @endif
                    </div>

                    {{-- Clip button --}}
                    <button class="coupon-clip-btn {{ $clipped ? 'clipped-state' : '' }}"
                            onclick="clipCoupon(this, '{{ $code }}')"
                            id="clip-{{ $product->id }}">
                        @if($clipped)
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Coupon Clipped
                        @else
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                            Clip Coupon
                        @endif
                    </button>

                    {{-- View product link --}}
                    <a href="{{ route('products.show', $product->slug) }}" style="font-size:12px;color:#007185;text-align:center;display:block;margin-top:6px;">
                        View product &rsaquo;
                    </a>
                </div>

            </div>
            @endforeach
        </div>
        @endif

        {{-- How it works --}}
        <div class="cp-how">
            <h3>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                How Coupons Work
            </h3>
            <div class="cp-how-steps">
                <div class="cp-how-step">
                    <div class="cp-how-step-num">1</div>
                    <h4>Browse &amp; Clip</h4>
                    <p>Find a coupon you like and click "Clip Coupon" to save it to your account.</p>
                </div>
                <div class="cp-how-step">
                    <div class="cp-how-step-num">2</div>
                    <h4>Shop the Product</h4>
                    <p>Add the eligible product to your cart. The discount appears automatically.</p>
                </div>
                <div class="cp-how-step">
                    <div class="cp-how-step-num">3</div>
                    <h4>Save at Checkout</h4>
                    <p>Your savings are applied at checkout — no code entry needed once clipped.</p>
                </div>
                <div class="cp-how-step">
                    <div class="cp-how-step-num">4</div>
                    <h4>Or Use the Code</h4>
                    <p>Copy the promo code and enter it in the "Promo code" field at checkout.</p>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

<script>
function clipCoupon(btn, code) {
    const isClipped = btn.classList.contains('clipped-state');
    if (!isClipped) {
        btn.classList.add('clipped-state');
        btn.innerHTML = `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Coupon Clipped`;
        btn.closest('.coupon-card').classList.add('clipped');
        btn.closest('.coupon-card').querySelector('.coupon-card-header').style.background = 'linear-gradient(135deg,#007600,#00a300)';
        showToast('Coupon clipped! Discount will be applied at checkout.', 'success');
        let clipped = JSON.parse(localStorage.getItem('clippedCoupons') || '[]');
        if (!clipped.includes(code)) { clipped.push(code); localStorage.setItem('clippedCoupons', JSON.stringify(clipped)); }
    } else {
        btn.classList.remove('clipped-state');
        btn.innerHTML = `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg> Clip Coupon`;
        btn.closest('.coupon-card').classList.remove('clipped');
        btn.closest('.coupon-card').querySelector('.coupon-card-header').style.background = '';
        let clipped = JSON.parse(localStorage.getItem('clippedCoupons') || '[]');
        localStorage.setItem('clippedCoupons', JSON.stringify(clipped.filter(c => c !== code)));
    }
}

function copyCode(code, btn) {
    navigator.clipboard.writeText(code).then(() => {
        btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#007600" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
        showToast('Code "' + code + '" copied to clipboard!', 'success');
        setTimeout(() => {
            btn.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>';
        }, 2000);
    });
}

function showToast(msg, type) {
    let t = document.getElementById('cpToast');
    if (!t) {
        t = document.createElement('div');
        t.id = 'cpToast';
        t.style.cssText = 'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#222;color:#fff;padding:11px 22px;border-radius:6px;font-size:13px;z-index:99999;box-shadow:0 4px 16px rgba(0,0,0,.3);transition:opacity .3s;white-space:nowrap;';
        document.body.appendChild(t);
    }
    if (type === 'success') t.style.background = '#007600';
    t.textContent = msg;
    t.style.opacity = '1';
    clearTimeout(t._timer);
    t._timer = setTimeout(() => { t.style.opacity = '0'; }, 3000);
}

/* Restore clipped state from localStorage */
document.addEventListener('DOMContentLoaded', () => {
    const clipped = JSON.parse(localStorage.getItem('clippedCoupons') || '[]');
    document.querySelectorAll('.coupon-clip-btn').forEach(btn => {
        const card = btn.closest('.coupon-card');
        const codeEl = card.querySelector('.coupon-code');
        if (codeEl && clipped.includes(codeEl.textContent.trim())) {
            btn.classList.add('clipped-state');
            btn.innerHTML = `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Coupon Clipped`;
            card.classList.add('clipped');
            card.querySelector('.coupon-card-header').style.background = 'linear-gradient(135deg,#007600,#00a300)';
        }
    });
});
</script>
@endsection
