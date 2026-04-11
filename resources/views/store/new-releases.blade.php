@extends('store.layout')
@section('title', 'New Releases — Latest Arrivals & Fresh Drops')

@section('head')
<style>
    /* ── Page ───────────────────────────────────────── */
    .nr-page { background: #EAEDED; min-height: 80vh; }

    /* ── Hero ───────────────────────────────────────── */
    .nr-hero { background: linear-gradient(135deg,#131921 0%,#1a2a3a 50%,#131921 100%); padding: 40px 20px; position: relative; overflow: hidden; }
    .nr-hero::before { content:''; position:absolute; right:-60px; top:-60px; width:300px; height:300px; background:rgba(255,153,0,.08); border-radius:50%; pointer-events:none; }
    .nr-hero::after { content:''; position:absolute; left:25%; bottom:-80px; width:260px; height:260px; background:rgba(255,255,255,.03); border-radius:50%; pointer-events:none; }
    .nr-hero-inner { max-width:1340px; margin:0 auto; text-align:center; position:relative; z-index:1; }
    .nr-hero-badge { display:inline-flex; align-items:center; gap:6px; background:#FFD814; color:#131921; font-size:12px; font-weight:800; padding:6px 16px; border-radius:20px; margin-bottom:16px; text-transform:uppercase; letter-spacing:1px; }
    .nr-hero h1 { font-size:44px; font-weight:900; color:#fff; margin:0 0 16px; line-height:1.2; }
    .nr-hero h1 span { color:#FF9900; }
    .nr-hero p { font-size:16px; color:#adbac7; margin:0 auto 28px; max-width:550px; line-height:1.6; }

    /* New Badge Pulse */
    .nr-new-pulse { display:inline-flex; align-items:center; gap:8px; background:rgba(0,118,0,.2); border:1px solid #007600; border-radius:20px; padding:8px 18px; color:#00FF00; font-size:13px; font-weight:700; animation:pulse 2s infinite; }
    @keyframes pulse { 0%,100% { opacity:1; } 50% { opacity:.7; } }

    /* Stats Row */
    .nr-stats { display:flex; justify-content:center; gap:48px; flex-wrap:wrap; margin-top:32px; }
    .nr-stat { text-align:center; }
    .nr-stat-num { font-size:32px; font-weight:900; color:#FF9900; line-height:1; }
    .nr-stat-label { font-size:12px; color:#adbac7; text-transform:uppercase; letter-spacing:.5px; margin-top:6px; }

    /* ── Launch Banner ──────────────────────────────── */
    .nr-launch { background:linear-gradient(90deg,#FFD814,#FFA41C); }
    .nr-launch-inner { max-width:1340px; margin:0 auto; padding:14px 20px; display:flex; align-items:center; justify-content:center; gap:32px; flex-wrap:wrap; }
    .nr-launch-item { display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; color:#131921; }

    /* ── Category Pills ───────────────────────────── */
    .nr-pills-bar { background:#fff; border-bottom:2px solid #e3e6e6; }
    .nr-pills-inner { max-width:1340px; margin:0 auto; padding:16px 20px; display:flex; gap:12px; overflow-x:auto; scrollbar-width:none; }
    .nr-pills-inner::-webkit-scrollbar { display:none; }
    .nr-pill { flex-shrink:0; display:flex; align-items:center; gap:8px; padding:10px 20px; border:2px solid #e3e6e6; border-radius:25px; cursor:pointer; text-decoration:none; transition:all .15s; background:#fff; font-size:14px; font-weight:600; color:#0F1111; }
    .nr-pill:hover { border-color:#FF9900; background:#fff8ee; transform:translateY(-2px); }
    .nr-pill.active { border-color:#FF9900; background:#FFD814; color:#131921; }
    .nr-pill-new { background:#CC0C39; color:#fff; font-size:10px; font-weight:800; padding:2px 8px; border-radius:99px; margin-left:-4px; }

    /* ── Breadcrumb ────────────────────────────────── */
    .nr-breadcrumb { max-width:1340px; margin:0 auto; padding:12px 20px; font-size:13px; color:#555; }
    .nr-breadcrumb a { color:#007185; }
    .nr-breadcrumb a:hover { color:#C7511F; text-decoration:underline; }

    /* ── Layout ─────────────────────────────────────── */
    .nr-wrap { max-width:1340px; margin:0 auto; padding:24px 20px 60px; display:flex; gap:24px; align-items:flex-start; }

    /* ── Sidebar ───────────────────────────────────── */
    .nr-sidebar { width:240px; flex-shrink:0; }
    .nr-sb-box { background:#fff; border:1px solid #e3e6e6; border-radius:12px; overflow:hidden; margin-bottom:16px; box-shadow:0 2px 8px rgba(0,0,0,.04); }
    .nr-sb-head { font-size:14px; font-weight:700; color:#0F1111; padding:16px; border-bottom:1px solid #f0f2f2; background:#f7f8f8; display:flex; align-items:center; gap:8px; }
    .nr-sb-body { padding:10px 0; }
    .nr-sb-item { display:flex; align-items:center; gap:10px; padding:10px 16px; font-size:13px; color:#0F1111; cursor:pointer; text-decoration:none; transition:all .15s; border-left:3px solid transparent; }
    .nr-sb-item:hover { background:#fff8ee; border-left-color:#FF9900; color:#C7511F; }
    .nr-sb-item.active { background:#fff4e0; border-left-color:#FF9900; font-weight:700; color:#C7511F; }
    .nr-sb-item input { accent-color:#FF9900; width:14px; height:14px; flex-shrink:0; }
    .nr-sb-count { margin-left:auto; font-size:11px; color:#888; background:#f0f2f2; border-radius:99px; padding:2px 8px; }

    /* Time Filter */
    .nr-time-filters { padding:12px 16px; }
    .nr-time-btn { display:block; width:100%; text-align:left; padding:10px 12px; margin:4px 0; border:1px solid #e3e6e6; border-radius:8px; background:#fff; font-size:13px; cursor:pointer; transition:all .15s; }
    .nr-time-btn:hover, .nr-time-btn.active { background:#FFD814; border-color:#FFD814; color:#131921; font-weight:600; }

    /* ── Main ───────────────────────────────────────── */
    .nr-main { flex:1; min-width:0; }

    /* Featured New Arrivals Banner */
    .nr-featured { background:linear-gradient(135deg,#131921,#1a2a3a); border-radius:16px; padding:30px; margin-bottom:28px; position:relative; overflow:hidden; }
    .nr-featured::before { content:'✨'; position:absolute; right:30px; top:20px; font-size:80px; opacity:.15; }
    .nr-featured h2 { font-size:24px; font-weight:800; color:#fff; margin:0 0 8px; }
    .nr-featured p { color:#adbac7; font-size:14px; margin:0 0 20px; }
    .nr-featured-btn { display:inline-flex; align-items:center; gap:8px; background:#FFD814; color:#131921; border:none; border-radius:25px; padding:12px 24px; font-size:14px; font-weight:700; cursor:pointer; text-decoration:none; }
    .nr-featured-btn:hover { background:#F7CA00; }

    /* Sort Bar */
    .nr-sortbar { background:#fff; border-radius:12px; padding:16px 20px; margin-bottom:20px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; box-shadow:0 2px 8px rgba(0,0,0,.04); }
    .nr-sort-left { display:flex; align-items:center; gap:12px; }
    .nr-sort-left b { font-size:20px; color:#0F1111; }
    .nr-sort-left span { font-size:14px; color:#555; }
    .nr-sort-right { display:flex; align-items:center; gap:12px; }
    .nr-sort-label { font-size:13px; color:#555; }
    .nr-sort-select { border:1px solid #d5d9d9; border-radius:8px; padding:8px 14px; font-size:13px; background:#fff; cursor:pointer; }

    /* ── Product Grid ───────────────────────────────── */
    .nr-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:20px; }

    /* ── New Release Card ───────────────────────────── */
    .nr-card { background:#fff; border:1px solid #e3e6e6; border-radius:12px; overflow:hidden; display:flex; flex-direction:column; position:relative; transition:all .2s; }
    .nr-card:hover { box-shadow:0 8px 30px rgba(0,0,0,.15); border-color:#FF9900; transform:translateY(-4px); }

    /* New Badge */
    .nr-new-badge { position:absolute; top:12px; left:12px; background:#00FF00; color:#131921; font-size:11px; font-weight:900; padding:5px 12px; border-radius:4px; z-index:3; text-transform:uppercase; }
    .nr-launch-badge { position:absolute; top:12px; right:12px; background:#CC0C39; color:#fff; font-size:11px; font-weight:800; padding:5px 12px; border-radius:20px; z-index:3; }

    /* Image */
    .nr-card-img { background:#f7f8f8; aspect-ratio:1/1; display:flex; align-items:center; justify-content:center; overflow:hidden; position:relative; }
    .nr-card-img img { max-width:82%; max-height:82%; object-fit:contain; transition:transform .3s; }
    .nr-card:hover .nr-card-img img { transform:scale(1.08); }

    /* Quick View Overlay */
    .nr-quick-view { position:absolute; bottom:0; left:0; right:0; background:linear-gradient(to top,rgba(19,25,33,.9),transparent); padding:40px 12px 12px; opacity:0; transition:opacity .2s; }
    .nr-card:hover .nr-quick-view { opacity:1; }
    .nr-quick-btn { width:100%; background:#FFD814; color:#131921; border:none; border-radius:20px; padding:10px; font-size:12px; font-weight:700; cursor:pointer; }

    /* Body */
    .nr-card-body { padding:16px; flex:1; display:flex; flex-direction:column; gap:6px; }
    .nr-card-date { font-size:11px; color:#007600; font-weight:700; text-transform:uppercase; }
    .nr-card-brand { font-size:12px; color:#C7511F; font-weight:700; text-transform:uppercase; }
    .nr-card-name { font-size:14px; color:#0F1111; font-weight:500; line-height:1.4; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; min-height:40px; }

    /* Tags */
    .nr-card-tags { display:flex; gap:6px; flex-wrap:wrap; }
    .nr-card-tag { font-size:10px; background:#fff4e0; color:#C7511F; padding:3px 8px; border-radius:4px; font-weight:600; }
    .nr-card-tag.new-tech { background:#E3F2FD; color:#1565C0; }
    .nr-card-tag.trending { background:#F3E5F5; color:#7B1FA2; }

    /* Rating */
    .nr-rating { display:flex; align-items:center; gap:6px; margin:4px 0; }
    .nr-stars { display:flex; gap:2px; }
    .nr-rating-text { font-size:12px; color:#007185; }

    /* Price */
    .nr-price-block { margin-top:auto; padding-top:12px; border-top:1px solid #f0f2f2; }
    .nr-price-row { display:flex; align-items:baseline; gap:10px; flex-wrap:wrap; }
    .nr-price { font-size:22px; font-weight:900; color:#B12704; }
    .nr-price-was { font-size:13px; color:#888; text-decoration:line-through; }
    .nr-save { font-size:11px; color:#CC0C39; font-weight:700; }

    /* Actions */
    .nr-card-actions { display:flex; gap:8px; margin-top:12px; }
    .nr-btn-cart { flex:1; display:flex; align-items:center; justify-content:center; gap:6px; background:#FFD814; border:1px solid #FCD200; border-radius:20px; padding:10px; font-size:13px; font-weight:700; color:#131921; cursor:pointer; text-decoration:none; }
    .nr-btn-cart:hover { background:#F7CA00; }
    .nr-btn-wish { width:40px; display:flex; align-items:center; justify-content:center; background:#fff; border:1px solid #d5d9d9; border-radius:20px; cursor:pointer; color:#555; }
    .nr-btn-wish:hover { border-color:#CC0C39; color:#CC0C39; }

    /* ── Empty ──────────────────────────────────────── */
    .nr-empty { text-align:center; padding:80px 20px; background:#fff; border-radius:12px; }

    /* ── Coming Soon Banner ────────────────────────── */
    .nr-coming { background:linear-gradient(135deg,#1a237e,#283593); border-radius:12px; padding:24px; margin-top:40px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px; }
    .nr-coming-text { color:#fff; }
    .nr-coming-text h3 { font-size:20px; font-weight:800; margin:0 0 4px; }
    .nr-coming-text p { font-size:14px; opacity:.9; margin:0; }
    .nr-coming-btn { background:#FFD814; color:#131921; border:none; border-radius:20px; padding:10px 24px; font-size:14px; font-weight:700; cursor:pointer; }

    @media (max-width:900px) {
        .nr-wrap { flex-direction:column; }
        .nr-sidebar { width:100%; }
        .nr-grid { grid-template-columns:repeat(2,1fr); }
        .nr-hero h1 { font-size:32px; }
    }
    @media (max-width:480px) {
        .nr-grid { grid-template-columns:1fr; }
    }
</style>
@endsection

@section('content')
@php
    /* ── Helpers ─────────────────────────────────── */
    $discounts = [10,15,20,25,30];
    $ratings   = [4.2,4.4,4.6,4.8,5.0];
    $reviews   = [12,28,45,78,120];

    $newCategories = [
        ['icon'=>'✨','label'=>'All New','key'=>'all'],
        ['icon'=>'📱','label'=>'Tech','key'=>'tech'],
        ['icon'=>'👕','label'=>'Fashion','key'=>'fashion'],
        ['icon'=>'🏠','label'=>'Home','key'=>'home'],
        ['icon'=>'💄','label'=>'Beauty','key'=>'beauty'],
        ['icon'=>'⚽','label'=>'Sports','key'=>'sports'],
        ['icon'=>'📚','label'=>'Books','key'=>'books'],
        ['icon'=>'🎮','label'=>'Gaming','key'=>'gaming'],
    ];

    $timeFilters = [
        ['label'=>'Just Dropped','days'=>1],
        ['label'=>'This Week','days'=>7],
        ['label'=>'Last 30 Days','days'=>30],
        ['label'=>'Last 90 Days','days'=>90],
    ];

    function nrDisc($id,$arr){ return $arr[$id % count($arr)]; }
    function nrStars($r){
        $f=floor($r);$h=($r-$f)>=0.5?1:0;$e=5-$f-$h;$o='';
        for($i=0;$i<$f;$i++)  $o.='<svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        for($i=0;$i<$e;$i++)  $o.='<svg width="12" height="12" viewBox="0 0 24 24" fill="#ddd"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        return $o;
    }

    $activeCat = request('cat','all');
    $activeTime = request('time',7);
    $activeSort = request('sort','newest');
@endphp

<div class="nr-page">

{{-- Hero --}}
<div class="nr-hero">
    <div class="nr-hero-inner">
        <div class="nr-hero-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3z"/></svg>
            This Week's Drops
        </div>
        <h1>New <span>Releases</span></h1>
        <p>Be the first to shop the latest arrivals. Fresh drops added daily from top brands and trending categories.</p>

        <div class="nr-new-pulse">
            <span style="font-size:16px;">🔥</span>
            {{ $products->count() }}+ New Items Added Today
        </div>

        <div class="nr-stats">
            <div class="nr-stat">
                <div class="nr-stat-num">{{ $products->count() }}+</div>
                <div class="nr-stat-label">New Arrivals</div>
            </div>
            <div class="nr-stat">
                <div class="nr-stat-num">24h</div>
                <div class="nr-stat-label">Daily Updates</div>
            </div>
            <div class="nr-stat">
                <div class="nr-stat-num">Early</div>
                <div class="nr-stat-label">Access</div>
            </div>
        </div>
    </div>
</div>

{{-- Launch Banner --}}
<div class="nr-launch">
    <div class="nr-launch-inner">
        <div class="nr-launch-item">🚀 Launch Day Exclusives</div>
        <div class="nr-launch-item">⭐ First Access</div>
        <div class="nr-launch-item">🎁 Launch Bundles</div>
        <div class="nr-launch-item">⏰ Limited Stock</div>
    </div>
</div>

{{-- Category Pills --}}
<div class="nr-pills-bar">
    <div class="nr-pills-inner">
        @foreach($newCategories as $cat)
        <a href="{{ route('new-releases', array_merge(request()->except('cat'),['cat'=>$cat['key']])) }}" class="nr-pill {{ $activeCat==$cat['key'] ? 'active' : '' }}">
            <span>{{ $cat['icon'] }}</span>
            {{ $cat['label'] }}
            @if($cat['key']=='all')<span class="nr-pill-new">NEW</span>@endif
        </a>
        @endforeach
    </div>
</div>

{{-- Breadcrumb --}}
<div style="background:#fff;border-bottom:1px solid #e3e6e6;">
    <div class="nr-breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span>›</span>
        <span style="color:#0F1111;font-weight:500;">New Releases</span>
        @if($activeCat!='all')<span>›</span><span style="color:#FF9900;text-transform:capitalize;">{{ $activeCat }}</span>@endif
    </div>
</div>

{{-- Body --}}
<div class="nr-wrap">

    {{-- Sidebar --}}
    <div class="nr-sidebar">

        {{-- Time Filter --}}
        <div class="nr-sb-box">
            <div class="nr-sb-head">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                When Added
            </div>
            <div class="nr-time-filters">
                @foreach($timeFilters as $filter)
                <button class="nr-time-btn {{ $activeTime==$filter['days'] ? 'active' : '' }}" onclick="nrSetTime({{ $filter['days'] }})">
                    {{ $filter['label'] }}
                </button>
                @endforeach
            </div>
        </div>

        {{-- Category --}}
        <div class="nr-sb-box">
            <div class="nr-sb-head">Category</div>
            <div class="nr-sb-body">
                <a href="{{ route('new-releases', request()->except('cat')) }}" class="nr-sb-item {{ !$activeCat || $activeCat=='all' ? 'active' : '' }}">
                    <input type="radio" {{ !$activeCat || $activeCat=='all' ? 'checked' : '' }} readonly />
                    ✨ All Categories
                </a>
                @foreach($categories->take(8) as $cat)
                <a href="{{ route('new-releases', array_merge(request()->except('cat'),['cat'=>strtolower($cat->name)])) }}" class="nr-sb-item {{ $activeCat==strtolower($cat->name) ? 'active' : '' }}">
                    <input type="radio" {{ $activeCat==strtolower($cat->name) ? 'checked' : '' }} readonly />
                    {{ $cat->name }}
                    <span class="nr-sb-count">{{ rand(2,15) }}</span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Brand --}}
        <div class="nr-sb-box">
            <div class="nr-sb-head">Brand</div>
            <div class="nr-sb-body">
                @foreach($brands->take(6) as $brand)
                <a href="{{ route('new-releases', ['brand'=>$brand->id]) }}" class="nr-sb-item {{ request('brand')==$brand->id ? 'active' : '' }}">
                    <input type="radio" {{ request('brand')==$brand->id ? 'checked' : '' }} readonly />
                    {{ $brand->name }}
                    <span class="nr-sb-count">NEW</span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Price --}}
        <div class="nr-sb-box">
            <div class="nr-sb-head">Price Range</div>
            <div class="nr-sb-body">
                @foreach(['Under $25','$25-$50','$50-$100','$100-$200','$200+'] as $range)
                <a href="{{ route('new-releases', ['price_range'=>$loop->index]) }}" class="nr-sb-item {{ request('price_range')==$loop->index ? 'active' : '' }}">
                    <input type="radio" {{ request('price_range')==$loop->index ? 'checked' : '' }} readonly />
                    {{ $range }}
                </a>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Main --}}
    <div class="nr-main">

        {{-- Featured Banner --}}
        <div class="nr-featured">
            <h2>🔥 Trending This Week</h2>
            <p>Discover what's hot right now. These new arrivals are already customer favorites.</p>
            <button class="nr-featured-btn" onclick="document.getElementById('nr-grid').scrollIntoView({behavior:'smooth'})">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12l7 7 7-7"/></svg>
                View Trending
            </button>
        </div>

        {{-- Sort Bar --}}
        <div class="nr-sortbar">
            <div class="nr-sort-left">
                <b>{{ $products->count() }}</b>
                <span>new arrivals found</span>
            </div>
            <div class="nr-sort-right">
                <span class="nr-sort-label">Sort by:</span>
                <select class="nr-sort-select" onchange="window.location.href=this.value">
                    <option value="{{ route('new-releases', array_merge(request()->all(),['sort'=>'newest'])) }}" {{ $activeSort=='newest' ? 'selected' : '' }}>Newest First</option>
                    <option value="{{ route('new-releases', array_merge(request()->all(),['sort'=>'price_asc'])) }}" {{ $activeSort=='price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="{{ route('new-releases', array_merge(request()->all(),['sort'=>'price_desc'])) }}" {{ $activeSort=='price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="{{ route('new-releases', array_merge(request()->all(),['sort'=>'trending'])) }}" {{ $activeSort=='trending' ? 'selected' : '' }}>Trending</option>
                </select>
            </div>
        </div>

        {{-- Grid --}}
        @if($products->isEmpty())
        <div class="nr-empty">
            <div style="font-size:64px;margin-bottom:16px;">📦</div>
            <h3 style="font-size:20px;font-weight:700;margin-bottom:8px;">No new releases found</h3>
            <p style="color:#555;">Check back soon for fresh arrivals!</p>
        </div>
        @else
        <div class="nr-grid" id="nr-grid">
            @foreach($products as $product)
            @php
                $disc = nrDisc($product->id, $discounts);
                $wasPrice = round($product->price * 100 / (100 - $disc), 2);
                $pRating = $ratings[$product->id % count($ratings)];
                $pReviews = $reviews[$product->id % count($reviews)];
                $catIdx = $product->id % count($newCategories);
                $catInfo = $newCategories[$catIdx];
                $brandName = $product->brand ? $product->brand->name : 'New Brand';
                $imgs = collect($product->images ?? [])->filter()->values();
                $thumb = $imgs->first() ? \Illuminate\Support\Facades\Storage::url($imgs->first()) : null;
                $isLaunch = $product->id % 5 == 0;
                $isTrending = $product->id % 3 == 0;
            @endphp
            <div class="nr-card" onclick="window.location='{{ route('products.show', $product->slug) }}'">

                <div class="nr-new-badge">✨ New</div>
                @if($isLaunch)<div class="nr-launch-badge">🚀 Launch</div>@endif

                <div class="nr-card-img">
                    @if($thumb)
                        <img src="{{ $thumb }}" alt="{{ $product->name }}" loading="lazy" />
                    @else
                        <div style="font-size:52px;opacity:.25;">📦</div>
                    @endif
                    <div class="nr-quick-view">
                        <button class="nr-quick-btn" onclick="event.stopPropagation(); nrQuickAdd()">Quick View</button>
                    </div>
                </div>

                <div class="nr-card-body">
                    <div class="nr-card-date">📅 Added {{ rand(1,7) }} days ago</div>
                    <div class="nr-card-brand">{{ $brandName }}</div>
                    <div class="nr-card-name">{{ $product->name }}</div>

                    <div class="nr-card-tags">
                        <span class="nr-card-tag {{ $isTrending ? 'trending' : '' }}">{{ $isTrending ? '🔥 Trending' : $catInfo['label'] }}</span>
                        @if($isLaunch)<span class="nr-card-tag new-tech">🚀 Launch Day</span>@endif
                    </div>

                    <div class="nr-rating">
                        <div class="nr-stars">{!! nrStars($pRating) !!}</div>
                        <span class="nr-rating-text">{{ $pRating }} ({{ $pReviews }})</span>
                    </div>

                    <div class="nr-price-block">
                        <div class="nr-price-row">
                            <span class="nr-price">${{ number_format($product->price, 2) }}</span>
                            @if($disc > 0)
                                <span class="nr-price-was">${{ number_format($wasPrice, 2) }}</span>
                                <span class="nr-save">Save {{ $disc }}%</span>
                            @endif
                        </div>
                    </div>

                    <div class="nr-card-actions">
                        <a href="{{ route('products.show', $product->slug) }}" class="nr-btn-cart" onclick="event.stopPropagation();">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            Add to Cart
                        </a>
                        <button class="nr-btn-wish" onclick="event.stopPropagation(); nrToggleWish(this)">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Coming Soon Banner --}}
        <div class="nr-coming">
            <div class="nr-coming-text">
                <h3>📅 Coming Soon</h3>
                <p>Get notified when hot new products drop. Be the first to know.</p>
            </div>
            <button class="nr-coming-btn" onclick="nrNotifyMe()">Notify Me</button>
        </div>

        @endif
    </div>
</div>
</div>

<script>
function nrSetTime(days) {
    const url = new URL(window.location.href);
    url.searchParams.set('time', days);
    window.location.href = url.toString();
}

function nrQuickAdd() {
    nrToast('👁️ Quick view opened');
}

function nrToggleWish(btn) {
    btn.classList.toggle('saved');
    const saved = btn.classList.contains('saved');
    btn.style.background = saved ? '#FFF0F0' : '#fff';
    btn.style.borderColor = saved ? '#CC0C39' : '#d5d9d9';
    btn.style.color = saved ? '#CC0C39' : '#555';
    nrToast(saved ? '❤️ Saved to wishlist' : 'Removed from wishlist');
}

function nrNotifyMe() {
    nrToast('🔔 You\'ll be notified of new drops!');
}

function nrToast(msg) {
    let t = document.getElementById('nrToast');
    if(!t) {
        t = document.createElement('div');
        t.id = 'nrToast';
        t.style.cssText = 'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#131921;color:#FF9900;padding:12px 24px;border-radius:8px;font-size:14px;z-index:99999;font-weight:600;box-shadow:0 4px 16px rgba(0,0,0,.3);';
        document.body.appendChild(t);
    }
    t.textContent = msg;
    t.style.opacity = '1';
    clearTimeout(t._t);
    t._t = setTimeout(() => { t.style.opacity = '0'; }, 2500);
}
</script>
@endsection
