@extends('store.layout')
@section('title', 'Beauty — Skincare, Makeup & Personal Care')

@section('head')
<style>
    /* ── Page ───────────────────────────────────────── */
    .be-page { background: #EAEDED; min-height: 80vh; }

    /* ── Hero ───────────────────────────────────────── */
    .be-hero { background: linear-gradient(135deg,#8B1E3F 0%,#D4A5A5 50%,#F5E6E8 100%); padding: 32px 20px; position: relative; overflow: hidden; }
    .be-hero::before { content:''; position:absolute; right:-80px; top:-80px; width:320px; height:320px; background:rgba(255,153,0,.1); border-radius:50%; pointer-events:none; }
    .be-hero::after { content:''; position:absolute; left:30%; bottom:-60px; width:250px; height:250px; background:rgba(255,255,255,.2); border-radius:50%; pointer-events:none; }
    .be-hero-inner { max-width:1340px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; gap:24px; flex-wrap:wrap; position:relative; z-index:1; }
    .be-hero-left { flex:1; min-width:300px; }
    .be-hero-eyebrow { display:inline-flex; align-items:center; gap:6px; background:rgba(255,255,255,.25); border:1px solid rgba(255,255,255,.4); border-radius:20px; padding:5px 14px; font-size:12px; color:#8B1E3F; font-weight:700; letter-spacing:.5px; margin-bottom:12px; text-transform:uppercase; }
    .be-hero h1 { font-size:36px; font-weight:900; color:#4A1A2C; margin:0 0 12px; line-height:1.2; }
    .be-hero h1 span { color:#D4A5A5; text-shadow:0 2px 4px rgba(0,0,0,.1); }
    .be-hero p { font-size:14px; color:#6B3A4F; margin:0 0 20px; max-width:450px; line-height:1.6; }
    .be-hero-btns { display:flex; gap:12px; flex-wrap:wrap; }
    .be-hero-btn { display:inline-flex; align-items:center; gap:7px; border-radius:25px; padding:12px 24px; font-size:13px; font-weight:700; cursor:pointer; text-decoration:none; transition:all .15s; }
    .be-hero-btn.primary { background:#FFD814; border:1px solid #FCD200; color:#131921; }
    .be-hero-btn.primary:hover { background:#F7CA00; transform:translateY(-2px); }
    .be-hero-btn.secondary { background:rgba(255,255,255,.35); border:1px solid rgba(255,255,255,.5); color:#4A1A2C; }
    .be-hero-btn.secondary:hover { background:rgba(255,255,255,.5); }
    .be-hero-stats { display:flex; gap:16px; flex-wrap:wrap; }
    .be-stat { text-align:center; background:rgba(255,255,255,.25); border:1px solid rgba(255,255,255,.35); border-radius:12px; padding:16px 20px; min-width:85px; backdrop-filter:blur(4px); }
    .be-stat-num { font-size:24px; font-weight:900; color:#8B1E3F; line-height:1; }
    .be-stat-label { font-size:11px; color:#6B3A4F; text-transform:uppercase; letter-spacing:.5px; margin-top:4px; font-weight:600; }

    /* ── Trend Banner ──────────────────────────────── */
    .be-trend { background:linear-gradient(90deg,#8B1E3F,#A0305C); }
    .be-trend-inner { max-width:1340px; margin:0 auto; padding:12px 20px; display:flex; align-items:center; justify-content:center; gap:20px; flex-wrap:wrap; }
    .be-trend-item { display:flex; align-items:center; gap:6px; font-size:13px; font-weight:700; color:#fff; }

    /* ── Category Pills ─────────────────────────────── */
    .be-pills-bar { background:#fff; border-bottom:2px solid #f0e0e5; }
    .be-pills-inner { max-width:1340px; margin:0 auto; padding:16px 20px; display:flex; gap:10px; overflow-x:auto; scrollbar-width:none; }
    .be-pills-inner::-webkit-scrollbar { display:none; }
    .be-pill { flex-shrink:0; display:flex; align-items:center; gap:6px; padding:10px 18px; border:2px solid #f0e0e5; border-radius:25px; cursor:pointer; text-decoration:none; transition:all .15s; background:#fff; }
    .be-pill:hover { border-color:#D4A5A5; background:#FDF5F7; transform:translateY(-2px); }
    .be-pill.active { border-color:#8B1E3F; background:#FDF5F7; color:#8B1E3F; font-weight:700; }
    .be-pill-icon { font-size:18px; }

    /* ── Breadcrumb ────────────────────────────────── */
    .be-breadcrumb { max-width:1340px; margin:0 auto; padding:12px 20px; font-size:13px; color:#555; }
    .be-breadcrumb a { color:#8B1E3F; }
    .be-breadcrumb a:hover { color:#D4A5A5; text-decoration:underline; }

    /* ── Layout ─────────────────────────────────────── */
    .be-wrap { max-width:1340px; margin:0 auto; padding:24px 20px 60px; display:flex; gap:24px; align-items:flex-start; }

    /* ── Sidebar ────────────────────────────────────── */
    .be-sidebar { width:240px; flex-shrink:0; }
    .be-sb-box { background:#fff; border:1px solid #f0e0e5; border-radius:12px; overflow:hidden; margin-bottom:16px; }
    .be-sb-head { font-size:14px; font-weight:700; color:#4A1A2C; padding:16px; border-bottom:1px solid #f0e0e5; background:#FDF5F7; display:flex; align-items:center; gap:8px; }
    .be-sb-body { padding:10px 0; }
    .be-sb-item { display:flex; align-items:center; gap:10px; padding:10px 16px; font-size:13px; color:#4A1A2C; cursor:pointer; text-decoration:none; transition:all .15s; border-left:3px solid transparent; }
    .be-sb-item:hover { background:#FDF5F7; border-left-color:#D4A5A5; color:#8B1E3F; }
    .be-sb-item.active { background:#F5E6E8; border-left-color:#8B1E3F; font-weight:700; color:#8B1E3F; }
    .be-sb-item input { accent-color:#8B1E3F; width:14px; height:14px; flex-shrink:0; }
    .be-sb-count { margin-left:auto; font-size:11px; color:#888; background:#f0f2f2; border-radius:99px; padding:2px 8px; }

    /* Skin Type Filters */
    .be-skin-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:8px; padding:12px; }
    .be-skin-btn { padding:8px; border:1px solid #f0e0e5; border-radius:8px; font-size:12px; text-align:center; cursor:pointer; background:#fff; transition:all .15s; }
    .be-skin-btn:hover, .be-skin-btn.active { background:#8B1E3F; color:#fff; border-color:#8B1E3F; }

    /* ── Main ─────────────────────────────────────────── */
    .be-main { flex:1; min-width:0; }

    /* Promo Banners */
    .be-promos { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:16px; margin-bottom:24px; }
    .be-promo { border-radius:12px; padding:20px; display:flex; flex-direction:column; gap:8px; position:relative; overflow:hidden; cursor:pointer; transition:all .2s; min-height:140px; }
    .be-promo:hover { transform:translateY(-4px); box-shadow:0 8px 25px rgba(0,0,0,.15); }
    .be-promo h4 { font-size:15px; font-weight:800; margin:0; }
    .be-promo p { font-size:13px; margin:0; opacity:.9; line-height:1.4; }
    .be-promo span { font-size:12px; font-weight:700; margin-top:auto; }
    .be-promo-icon { position:absolute; right:12px; top:12px; font-size:40px; opacity:.3; }
    .be-p1 { background:linear-gradient(135deg,#FCE4EC,#F8BBD9); color:#880E4F; }
    .be-p1 span { color:#C2185B; }
    .be-p2 { background:linear-gradient(135deg,#E8F5E9,#C8E6C9); color:#1B5E20; }
    .be-p2 span { color:#2E7D32; }
    .be-p3 { background:linear-gradient(135deg,#FFF3E0,#FFE0B2); color:#E65100; }
    .be-p3 span { color:#F57C00; }
    .be-p4 { background:linear-gradient(135deg,#E3F2FD,#BBDEFB); color:#0D47A1; }
    .be-p4 span { color:#1976D2; }

    /* Sort Bar */
    .be-sortbar { background:#fff; border-radius:12px; padding:16px 20px; margin-bottom:20px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; }
    .be-sort-left { font-size:14px; color:#555; }
    .be-sort-left b { color:#4A1A2C; font-size:18px; }
    .be-sort-right { display:flex; align-items:center; gap:12px; }
    .be-sort-select { border:1px solid #f0e0e5; border-radius:8px; padding:8px 14px; font-size:13px; background:#fff; cursor:pointer; }

    /* ── Product Grid ────────────────────────────────── */
    .be-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:20px; }

    /* ── Beauty Card ─────────────────────────────────── */
    .be-card { background:#fff; border:1px solid #f0e0e5; border-radius:12px; overflow:hidden; display:flex; flex-direction:column; position:relative; transition:all .2s; }
    .be-card:hover { box-shadow:0 8px 30px rgba(139,30,63,.15); border-color:#D4A5A5; transform:translateY(-4px); }

    /* Badges */
    .be-badge-organic { position:absolute; top:10px; left:10px; background:#4CAF50; color:#fff; font-size:10px; font-weight:800; padding:4px 10px; border-radius:4px; z-index:3; }
    .be-badge-sale { position:absolute; top:10px; right:10px; background:#E91E63; color:#fff; font-size:12px; font-weight:900; padding:6px 12px; border-radius:20px; z-index:3; }
    .be-badge-vegan { position:absolute; bottom:10px; left:10px; background:#8B1E3F; color:#fff; font-size:10px; font-weight:700; padding:4px 10px; border-radius:4px; z-index:3; }

    /* Image */
    .be-card-img { background:#FDF5F7; aspect-ratio:1/1; display:flex; align-items:center; justify-content:center; overflow:hidden; position:relative; }
    .be-card-img img { max-width:80%; max-height:80%; object-fit:contain; transition:transform .3s; }
    .be-card:hover .be-card-img img { transform:scale(1.08); }

    /* Quick Add */
    .be-quick-add { position:absolute; bottom:0; left:0; right:0; background:linear-gradient(to top,rgba(139,30,63,.9),transparent); padding:40px 12px 12px; opacity:0; transition:opacity .2s; display:flex; justify-content:center; }
    .be-card:hover .be-quick-add { opacity:1; }
    .be-quick-btn { background:#FFD814; color:#131921; border:none; border-radius:20px; padding:8px 20px; font-size:12px; font-weight:700; cursor:pointer; display:flex; align-items:center; gap:6px; }

    /* Body */
    .be-card-body { padding:16px; flex:1; display:flex; flex-direction:column; gap:6px; }
    .be-card-brand { font-size:11px; color:#8B1E3F; font-weight:700; text-transform:uppercase; letter-spacing:.5px; }
    .be-card-name { font-size:14px; color:#4A1A2C; font-weight:500; line-height:1.4; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; min-height:40px; }
    .be-card-tags { display:flex; gap:4px; flex-wrap:wrap; }
    .be-card-tag { font-size:10px; background:#F5E6E8; color:#8B1E3F; padding:3px 8px; border-radius:4px; font-weight:600; }

    /* Rating */
    .be-rating { display:flex; align-items:center; gap:6px; margin:4px 0; }
    .be-stars { display:flex; gap:2px; }
    .be-rating-text { font-size:12px; color:#8B1E3F; }

    /* Price */
    .be-price-block { margin-top:auto; padding-top:12px; border-top:1px solid #f0e0e5; }
    .be-price-row { display:flex; align-items:baseline; gap:8px; flex-wrap:wrap; }
    .be-price { font-size:22px; font-weight:900; color:#8B1E3F; }
    .be-price-was { font-size:13px; color:#888; text-decoration:line-through; }
    .be-save { font-size:11px; color:#E91E63; font-weight:700; }

    /* ── Empty ───────────────────────────────────────── */
    .be-empty { text-align:center; padding:80px 20px; background:#fff; border-radius:12px; }

    /* ── Tips Section ─────────────────────────────────── */
    .be-tips { background:linear-gradient(135deg,#FDF5F7,#F5E6E8); border-radius:12px; padding:30px; margin-top:40px; }
    .be-tips h3 { font-size:20px; font-weight:700; color:#4A1A2C; margin:0 0 20px; display:flex; align-items:center; gap:10px; }
    .be-tips-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:16px; }
    .be-tip-card { background:#fff; border-radius:10px; padding:20px; display:flex; gap:12px; align-items:flex-start; box-shadow:0 2px 8px rgba(0,0,0,.05); }
    .be-tip-icon { font-size:32px; flex-shrink:0; }
    .be-tip-card h4 { font-size:13px; font-weight:700; color:#4A1A2C; margin:0 0 4px; }
    .be-tip-card p { font-size:12px; color:#6B3A4F; margin:0; line-height:1.5; }

    @media (max-width:900px) {
        .be-wrap { flex-direction:column; }
        .be-sidebar { width:100%; }
        .be-grid { grid-template-columns:repeat(2,1fr); }
        .be-hero h1 { font-size:28px; }
    }
    @media (max-width:480px) {
        .be-grid { grid-template-columns:1fr; }
    }
</style>
@endsection

@section('content')
@php
    /* ── Helpers ─────────────────────────────────── */
    $discounts = [10,15,20,25,30];
    $ratings   = [4.0,4.2,4.4,4.6,4.8,5.0];
    $reviews   = [24,56,112,234,456,890];

    $beautyCats = [
        ['icon'=>'✨','label'=>'All Beauty','key'=>'all'],
        ['icon'=>'💄','label'=>'Makeup','key'=>'makeup'],
        ['icon'=>'🧴','label'=>'Skincare','key'=>'skincare'],
        ['icon'=>'💇','label'=>'Hair Care','key'=>'hair'],
        ['icon'=>'🌸','label'=>'Fragrance','key'=>'fragrance'],
        ['icon'=>'💅','label'=>'Nails','key'=>'nails'],
        ['icon'=>'🧼','label'=>'Bath & Body','key'=>'bath'],
        ['icon'=>'👁️','label'=>'Eye Care','key'=>'eye'],
    ];

    $skinTypes = ['Normal','Dry','Oily','Combination','Sensitive','All Types'];
    $concerns  = ['Anti-Aging','Acne','Hydration','Brightening','Pores','Dark Spots'];

    function beDisc($id,$arr){ return $arr[$id % count($arr)]; }
    function beStars($r){
        $f=floor($r);$h=($r-$f)>=0.5?1:0;$e=5-$f-$h;$o='';
        for($i=0;$i<$f;$i++)  $o.='<svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        for($i=0;$i<$e;$i++)  $o.='<svg width="12" height="12" viewBox="0 0 24 24" fill="#ddd"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        return $o;
    }

    $activeCat = request('cat','all');
    $activeSkin = request('skin');
    $activeSort = request('sort','featured');
@endphp

<div class="be-page">

{{-- Hero --}}
<div class="be-hero">
    <div class="be-hero-inner">
        <div class="be-hero-left">
            <div class="be-hero-eyebrow">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"/></svg>
                Premium Beauty & Personal Care
            </div>
            <h1>Discover Your <span>Beauty</span></h1>
            <p>Shop skincare, makeup, hair care, and fragrance. Find clean beauty, vegan formulas, and dermatologist-approved products.</p>
            <div class="be-hero-btns">
                <a href="#be-listings" class="be-hero-btn primary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Shop All Beauty
                </a>
                <a href="{{ route('beauty', ['cat'=>'skincare']) }}" class="be-hero-btn secondary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"/></svg>
                    Skincare
                </a>
            </div>
        </div>
        <div class="be-hero-stats">
            <div class="be-stat">
                <div class="be-stat-num">{{ $products->count() }}+</div>
                <div class="be-stat-label">Products</div>
            </div>
            <div class="be-stat">
                <div class="be-stat-num">100%</div>
                <div class="be-stat-label">Authentic</div>
            </div>
            <div class="be-stat">
                <div class="be-stat-num">Clean</div>
                <div class="be-stat-label">Beauty</div>
            </div>
        </div>
    </div>
</div>

{{-- Trend Banner --}}
<div class="be-trend">
    <div class="be-trend-inner">
        <div class="be-trend-item">🌿 Clean Beauty Trending</div>
        <div class="be-trend-item">✨ Korean Skincare</div>
        <div class="be-trend-item">💄 Vegan Makeup</div>
        <div class="be-trend-item">🧴 Cruelty-Free</div>
        <div class="be-trend-item">🌸 New Fragrances</div>
    </div>
</div>

{{-- Category Pills --}}
<div class="be-pills-bar">
    <div class="be-pills-inner">
        @foreach($beautyCats as $cat)
        <a href="{{ route('beauty', array_merge(request()->except('cat'),['cat'=>$cat['key']])) }}" class="be-pill {{ $activeCat==$cat['key'] ? 'active' : '' }}">
            <span class="be-pill-icon">{{ $cat['icon'] }}</span>
            {{ $cat['label'] }}
        </a>
        @endforeach
    </div>
</div>

{{-- Breadcrumb --}}
<div style="background:#fff;border-bottom:1px solid #f0e0e5;">
    <div class="be-breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span>›</span>
        <span style="color:#4A1A2C;font-weight:500;">Beauty</span>
        @if($activeCat!='all')<span>›</span><span style="color:#8B1E3F;text-transform:capitalize;">{{ $activeCat }}</span>@endif
    </div>
</div>

{{-- Body --}}
<div class="be-wrap">

    {{-- Sidebar --}}
    <div class="be-sidebar">

        {{-- Category --}}
        <div class="be-sb-box">
            <div class="be-sb-head">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8B1E3F" stroke-width="2"><path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"/></svg>
                Category
            </div>
            <div class="be-sb-body">
                @foreach($beautyCats as $cat)
                <a href="{{ route('beauty', array_merge(request()->except('cat'),['cat'=>$cat['key']])) }}" class="be-sb-item {{ $activeCat==$cat['key'] ? 'active' : '' }}">
                    <input type="radio" {{ $activeCat==$cat['key'] ? 'checked' : '' }} readonly />
                    {{ $cat['icon'] }} {{ $cat['label'] }}
                    <span class="be-sb-count">{{ rand(8,45) }}</span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Skin Type --}}
        <div class="be-sb-box">
            <div class="be-sb-head">Skin Type</div>
            <div class="be-skin-grid">
                @foreach($skinTypes as $type)
                <button class="be-skin-btn {{ $activeSkin==$type ? 'active' : '' }}" onclick="beSetSkin('{{ $type }}')">{{ $type }}</button>
                @endforeach
            </div>
        </div>

        {{-- Concerns --}}
        <div class="be-sb-box">
            <div class="be-sb-head">Skin Concerns</div>
            <div class="be-sb-body">
                @foreach($concerns as $c)
                <a href="{{ route('beauty', ['concern'=>strtolower($c)]) }}" class="be-sb-item {{ request('concern')==strtolower($c) ? 'active' : '' }}">
                    <input type="radio" {{ request('concern')==strtolower($c) ? 'checked' : '' }} readonly />
                    {{ $c }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Features --}}
        <div class="be-sb-box">
            <div class="be-sb-head">Features</div>
            <div class="be-sb-body">
                @foreach(['Organic','Vegan','Cruelty-Free','Fragrance-Free','Hypoallergenic','Dermatologist Tested'] as $f)
                <a href="{{ route('beauty', ['feature'=>strtolower(str_replace(' ','-',$f))]) }}" class="be-sb-item {{ request('feature')==strtolower(str_replace(' ','-',$f)) ? 'active' : '' }}">
                    <input type="checkbox" {{ request('feature')==strtolower(str_replace(' ','-',$f)) ? 'checked' : '' }} readonly />
                    {{ $f }}
                </a>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Main --}}
    <div class="be-main" id="be-listings">

        {{-- Promo Banners --}}
        <div class="be-promos">
            <div class="be-promo be-p1" onclick="window.location='{{ route('beauty', ['cat'=>'skincare']) }}'">
                <span class="be-promo-icon">🧴</span>
                <h4>Skincare Essentials</h4>
                <p>Serums, moisturizers & cleansers</p>
                <span>Shop Skincare →</span>
            </div>
            <div class="be-promo be-p2" onclick="window.location='{{ route('beauty', ['cat'=>'makeup']) }}'">
                <span class="be-promo-icon">💄</span>
                <h4>Clean Makeup</h4>
                <p>Vegan & cruelty-free cosmetics</p>
                <span>Shop Makeup →</span>
            </div>
            <div class="be-promo be-p3" onclick="window.location='{{ route('beauty', ['cat'=>'hair']) }}'">
                <span class="be-promo-icon">💇</span>
                <h4>Hair Care</h4>
                <p>Shampoos, treatments & styling</p>
                <span>Shop Hair →</span>
            </div>
            <div class="be-promo be-p4" onclick="window.location='{{ route('beauty', ['cat'=>'fragrance']) }}'">
                <span class="be-promo-icon">🌸</span>
                <h4>Fragrances</h4>
                <p>Perfumes & body mists</p>
                <span>Shop Fragrance →</span>
            </div>
        </div>

        {{-- Sort Bar --}}
        <div class="be-sortbar">
            <div class="be-sort-left"><b>{{ $products->count() }}</b> beauty products</div>
            <div class="be-sort-right">
                <span class="be-sort-label">Sort by:</span>
                <select class="be-sort-select" onchange="window.location.href=this.value">
                    <option value="{{ route('beauty', array_merge(request()->all(),['sort'=>'featured'])) }}" {{ $activeSort=='featured' ? 'selected' : '' }}>Featured</option>
                    <option value="{{ route('beauty', array_merge(request()->all(),['sort'=>'newest'])) }}" {{ $activeSort=='newest' ? 'selected' : '' }}>New Arrivals</option>
                    <option value="{{ route('beauty', array_merge(request()->all(),['sort'=>'price_asc'])) }}" {{ $activeSort=='price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="{{ route('beauty', array_merge(request()->all(),['sort'=>'price_desc'])) }}" {{ $activeSort=='price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="{{ route('beauty', array_merge(request()->all(),['sort'=>'rating'])) }}" {{ $activeSort=='rating' ? 'selected' : '' }}>Top Rated</option>
                </select>
            </div>
        </div>

        {{-- Grid --}}
        @if($products->isEmpty())
        <div class="be-empty">
            <div style="font-size:64px;margin-bottom:16px;">💄</div>
            <h3 style="font-size:20px;font-weight:700;margin-bottom:8px;color:#4A1A2C;">No products found</h3>
            <p style="color:#6B3A4F;">Try adjusting your filters or browse all categories.</p>
        </div>
        @else
        <div class="be-grid">
            @foreach($products as $product)
            @php
                $disc = beDisc($product->id, $discounts);
                $wasPrice = round($product->price * 100 / (100 - $disc), 2);
                $pRating = $ratings[$product->id % count($ratings)];
                $pReviews = $reviews[$product->id % count($reviews)];
                $catIdx = $product->id % count($beautyCats);
                $catInfo = $beautyCats[$catIdx];
                $brandName = $product->brand ? $product->brand->name : 'Premium Brand';
                $imgs = collect($product->images ?? [])->filter()->values();
                $thumb = $imgs->first() ? \Illuminate\Support\Facades\Storage::url($imgs->first()) : null;
                $isOrganic = $product->id % 3 == 0;
                $isVegan = $product->id % 4 == 0;
            @endphp
            <div class="be-card" onclick="window.location='{{ route('products.show', $product->slug) }}'">

                @if($isOrganic)<div class="be-badge-organic">🌿 Organic</div>@endif
                <div class="be-badge-sale">-{{ $disc }}%</div>
                @if($isVegan)<div class="be-badge-vegan">🌱 Vegan</div>@endif

                <div class="be-card-img">
                    @if($thumb)
                        <img src="{{ $thumb }}" alt="{{ $product->name }}" loading="lazy" />
                    @else
                        <div style="font-size:48px;opacity:.3;">{{ $catInfo['icon'] }}</div>
                    @endif
                    <div class="be-quick-add">
                        <button class="be-quick-btn" onclick="event.stopPropagation(); beAddToCart()">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            Quick Add
                        </button>
                    </div>
                </div>

                <div class="be-card-body">
                    <div class="be-card-brand">{{ $brandName }}</div>
                    <div class="be-card-name">{{ $product->name }}</div>

                    <div class="be-card-tags">
                        <span class="be-card-tag">{{ $catInfo['label'] }}</span>
                        @if($isOrganic)<span class="be-card-tag">Organic</span>@endif
                    </div>

                    <div class="be-rating">
                        <div class="be-stars">{!! beStars($pRating) !!}</div>
                        <span class="be-rating-text">{{ $pRating }} ({{ $pReviews }})</span>
                    </div>

                    <div class="be-price-block">
                        <div class="be-price-row">
                            <span class="be-price">${{ number_format($product->price, 2) }}</span>
                            <span class="be-price-was">${{ number_format($wasPrice, 2) }}</span>
                        </div>
                        <span class="be-save">Save {{ $disc }}%</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Beauty Tips --}}
        <div class="be-tips">
            <h3>
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#8B1E3F" stroke-width="2"><path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"/></svg>
                Beauty Tips & Advice
            </h3>
            <div class="be-tips-grid">
                <div class="be-tip-card">
                    <div class="be-tip-icon">🧴</div>
                    <div>
                        <h4>Skincare Routine</h4>
                        <p>Cleanse, tone, treat, moisturize, and protect for healthy glowing skin.</p>
                    </div>
                </div>
                <div class="be-tip-card">
                    <div class="be-tip-icon">🌿</div>
                    <div>
                        <h4>Clean Beauty</h4>
                        <p>Look for products free from parabens, sulfates, and artificial fragrances.</p>
                    </div>
                </div>
                <div class="be-tip-card">
                    <div class="be-tip-icon">☀️</div>
                    <div>
                        <h4>Sun Protection</h4>
                        <p>Always wear SPF 30+ daily, even on cloudy days and indoors.</p>
                    </div>
                </div>
                <div class="be-tip-card">
                    <div class="be-tip-icon">💧</div>
                    <div>
                        <h4>Hydration</h4>
                        <p>Drink 8 glasses of water and use hyaluronic acid for plump skin.</p>
                    </div>
                </div>
            </div>
        </div>

        @endif
    </div>
</div>
</div>

<script>
function beSetSkin(skin) {
    const url = new URL(window.location.href);
    url.searchParams.set('skin', skin);
    window.location.href = url.toString();
}

function beAddToCart() {
    let t = document.getElementById('beToast');
    if(!t) {
        t = document.createElement('div');
        t.id = 'beToast';
        t.style.cssText = 'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#8B1E3F;color:#fff;padding:12px 24px;border-radius:20px;font-size:14px;z-index:99999;font-weight:600;box-shadow:0 4px 16px rgba(0,0,0,.3);';
        document.body.appendChild(t);
    }
    t.textContent = '💄 Added to beauty bag!';
    t.style.opacity = '1';
    clearTimeout(t._t);
    t._t = setTimeout(() => { t.style.opacity = '0'; }, 2500);
}
</script>
@endsection
