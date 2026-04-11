@extends('store.layout')
@section('title', 'Outlet — Clearance & Overstock Deals — MyShop')

@section('head')
<style>
    /* ── Page ───────────────────────────────────────── */
    .ot-page { background: #EAEDED; min-height: 80vh; }

    /* ── Hero ───────────────────────────────────────── */
    .ot-hero { background: linear-gradient(110deg,#1a0a00 0%,#3d1a00 45%,#2a0f00 100%); padding: 32px 18px; position: relative; overflow: hidden; }
    .ot-hero::before { content:'OUTLET'; position:absolute; right:-20px; top:50%; transform:translateY(-50%); font-size:120px; font-weight:900; color:rgba(255,255,255,.04); letter-spacing:-4px; pointer-events:none; white-space:nowrap; }
    .ot-hero-inner { max-width:1340px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; gap:24px; flex-wrap:wrap; position:relative; z-index:1; }
    .ot-hero-eyebrow { display:inline-flex; align-items:center; gap:6px; background:rgba(255,87,34,.15); border:1px solid rgba(255,87,34,.4); border-radius:20px; padding:4px 14px; font-size:12px; color:#ff8a65; font-weight:700; letter-spacing:.5px; margin-bottom:10px; text-transform:uppercase; }
    .ot-hero-left h1 { font-size:34px; font-weight:900; color:#fff; margin:0 0 10px; line-height:1.1; }
    .ot-hero-left h1 span { color:#FF5722; }
    .ot-hero-left p { font-size:14px; color:#ffccbc; margin:0 0 16px; max-width:480px; line-height:1.6; }
    .ot-hero-cta { display:inline-flex; align-items:center; gap:8px; background:#FF5722; color:#fff; border:none; border-radius:6px; padding:10px 22px; font-size:14px; font-weight:700; cursor:pointer; text-decoration:none; transition:background .12s; }
    .ot-hero-cta:hover { background:#e64a19; color:#fff; }
    .ot-hero-stats { display:flex; gap:16px; flex-wrap:wrap; }
    .ot-hero-stat { text-align:center; background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.12); border-radius:10px; padding:16px 20px; min-width:90px; }
    .ot-hero-stat-num { font-size:28px; font-weight:900; color:#FF5722; line-height:1; }
    .ot-hero-stat-label { font-size:11px; color:#ffccbc; text-transform:uppercase; letter-spacing:.5px; margin-top:4px; }

    /* ── Urgency ticker ─────────────────────────────── */
    .ot-ticker { background:#FF5722; overflow:hidden; padding:7px 0; }
    .ot-ticker-inner { display:flex; gap:0; animation:tickerScroll 30s linear infinite; white-space:nowrap; }
    .ot-ticker-inner:hover { animation-play-state:paused; }
    .ot-ticker-item { display:inline-flex; align-items:center; gap:8px; padding:0 32px; font-size:12px; font-weight:700; color:#fff; text-transform:uppercase; letter-spacing:.5px; }
    .ot-ticker-sep { color:rgba(255,255,255,.5); }
    @keyframes tickerScroll { 0%{transform:translateX(0)} 100%{transform:translateX(-50%)} }

    /* ── Breadcrumb ─────────────────────────────────── */
    .ot-breadcrumb { max-width:1340px; margin:0 auto; padding:10px 18px; font-size:13px; color:#555; }
    .ot-breadcrumb a { color:#007185; }
    .ot-breadcrumb a:hover { color:#C7511F; text-decoration:underline; }

    /* ── Category sections / jumps ──────────────────── */
    .ot-cat-jumps { background:#fff; border-bottom:2px solid #e3e6e6; }
    .ot-cat-jumps-inner { max-width:1340px; margin:0 auto; padding:0 18px; display:flex; gap:6px; overflow-x:auto; scrollbar-width:none; padding:10px 18px; align-items:center; }
    .ot-cat-jumps-inner::-webkit-scrollbar { display:none; }
    .ot-cat-jump { display:inline-flex; align-items:center; gap:5px; padding:7px 16px; border-radius:6px; font-size:13px; font-weight:600; white-space:nowrap; cursor:pointer; text-decoration:none; border:1.5px solid #e3e6e6; background:#fff; color:#0F1111; transition:all .12s; flex-shrink:0; }
    .ot-cat-jump:hover { border-color:#FF5722; color:#FF5722; background:#fff5f2; }
    .ot-cat-jump.active { background:#FF5722; color:#fff; border-color:#FF5722; }

    /* ── Body layout ────────────────────────────────── */
    .ot-wrap { max-width:1340px; margin:0 auto; padding:20px 18px 50px; display:flex; gap:20px; align-items:flex-start; }

    /* ── Sidebar ────────────────────────────────────── */
    .ot-sidebar { width:210px; flex-shrink:0; }
    .ot-sb-box { background:#fff; border:1px solid #e3e6e6; border-radius:8px; overflow:hidden; margin-bottom:14px; }
    .ot-sb-head { font-size:14px; font-weight:700; color:#0F1111; padding:12px 16px 10px; border-bottom:1px solid #f0f2f2; background:#f7f8f8; display:flex; align-items:center; gap:7px; }
    .ot-sb-body { padding:8px 0; }
    .ot-sb-item { display:flex; align-items:center; gap:9px; padding:8px 16px; font-size:13px; color:#0F1111; cursor:pointer; text-decoration:none; transition:background .1s; border-left:3px solid transparent; }
    .ot-sb-item:hover { background:#fff5f2; border-left-color:#FF5722; color:#BF360C; }
    .ot-sb-item.active { background:#fff0eb; border-left-color:#FF5722; font-weight:700; color:#BF360C; }
    .ot-sb-item input[type=radio] { accent-color:#FF5722; width:14px; height:14px; flex-shrink:0; }

    /* Countdown timer in sidebar */
    .ot-countdown-box { background:linear-gradient(135deg,#FF5722,#BF360C); border-radius:8px; padding:14px 16px; margin-bottom:14px; text-align:center; }
    .ot-countdown-box h4 { font-size:12px; font-weight:700; color:rgba(255,255,255,.85); text-transform:uppercase; letter-spacing:.5px; margin:0 0 10px; }
    .ot-countdown-dials { display:flex; justify-content:center; gap:8px; }
    .ot-dial { background:rgba(0,0,0,.25); border-radius:6px; padding:6px 8px; min-width:40px; }
    .ot-dial-num { font-size:20px; font-weight:900; color:#fff; line-height:1; font-variant-numeric:tabular-nums; }
    .ot-dial-label { font-size:9px; color:rgba(255,255,255,.7); text-transform:uppercase; margin-top:2px; }
    .ot-dial-sep { font-size:18px; font-weight:900; color:rgba(255,255,255,.6); align-self:center; margin-top:-4px; }

    /* ── Main area ──────────────────────────────────── */
    .ot-main { flex:1; min-width:0; }
    .ot-topbar { display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; flex-wrap:wrap; gap:10px; }
    .ot-topbar-left { font-size:14px; color:#555; }
    .ot-topbar-left b { color:#0F1111; }
    .ot-topbar-right { display:flex; align-items:center; gap:8px; font-size:13px; color:#555; }
    .ot-topbar-right select { border:1px solid #d5d9d9; border-radius:6px; padding:6px 10px; font-size:13px; background:#fff; cursor:pointer; outline:none; }

    /* ── Deal type banner ───────────────────────────── */
    .ot-deal-type-banner { background:#fff; border:1px solid #e3e6e6; border-radius:8px; padding:14px 18px; margin-bottom:18px; display:flex; gap:12px; overflow-x:auto; scrollbar-width:none; }
    .ot-deal-type-banner::-webkit-scrollbar { display:none; }
    .ot-deal-type-pill { display:inline-flex; flex-direction:column; align-items:center; gap:5px; padding:10px 18px; border-radius:8px; border:2px solid #e3e6e6; cursor:pointer; text-decoration:none; transition:all .12s; flex-shrink:0; min-width:90px; }
    .ot-deal-type-pill:hover { border-color:#FF5722; background:#fff5f2; }
    .ot-deal-type-pill.active { border-color:#FF5722; background:#FF5722; }
    .ot-deal-type-pill.active .ot-dtp-icon { color:#fff; }
    .ot-deal-type-pill.active .ot-dtp-label { color:#fff; }
    .ot-dtp-icon { color:#FF5722; }
    .ot-dtp-label { font-size:12px; font-weight:700; color:#0F1111; white-space:nowrap; }
    .ot-dtp-sub { font-size:10px; color:#888; }
    .ot-deal-type-pill.active .ot-dtp-sub { color:rgba(255,255,255,.75); }

    /* ── Product grid ───────────────────────────────── */
    .ot-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:14px; }

    /* ── Product card ───────────────────────────────── */
    .ot-card { background:#fff; border:1px solid #e3e6e6; border-radius:8px; overflow:hidden; display:flex; flex-direction:column; position:relative; transition:box-shadow .15s,border-color .15s; cursor:pointer; }
    .ot-card:hover { box-shadow:0 4px 22px rgba(0,0,0,.13); border-color:#FF5722; }
    .ot-card.urgent { border-color:#FF9800; }
    .ot-card.urgent::before { content:'ALMOST GONE'; position:absolute; top:0; left:0; right:0; background:#FF9800; color:#fff; font-size:10px; font-weight:900; text-align:center; padding:3px; z-index:5; letter-spacing:.8px; }

    /* Image */
    .ot-card-img-wrap { position:relative; background:#f7f8f8; aspect-ratio:1/1; display:flex; align-items:center; justify-content:center; overflow:hidden; }
    .ot-card.urgent .ot-card-img-wrap { padding-top:20px; }
    .ot-card-img-wrap img { max-width:82%; max-height:82%; object-fit:contain; transition:transform .2s; }
    .ot-card:hover .ot-card-img-wrap img { transform:scale(1.05); }

    /* Disc badge */
    .ot-disc-badge { position:absolute; top:8px; left:8px; background:#CC0C39; color:#fff; border-radius:4px; padding:3px 9px; font-size:13px; font-weight:900; z-index:2; }
    .ot-disc-badge.mega { background:linear-gradient(135deg,#CC0C39,#FF5722); font-size:15px; padding:4px 11px; }

    /* Type badge */
    .ot-type-badge { position:absolute; top:8px; right:8px; border-radius:4px; padding:3px 8px; font-size:10px; font-weight:800; z-index:2; text-transform:uppercase; letter-spacing:.3px; }
    .ot-type-badge.clearance { background:#FF5722; color:#fff; }
    .ot-type-badge.overstock { background:#0066c0; color:#fff; }
    .ot-type-badge.final-sale { background:#7B1FA2; color:#fff; }
    .ot-type-badge.open-box { background:#E65100; color:#fff; }

    /* Qty bar */
    .ot-qty-bar-wrap { position:absolute; bottom:0; left:0; right:0; background:rgba(0,0,0,.55); padding:5px 8px; z-index:3; }
    .ot-qty-bar-label { font-size:10px; font-weight:700; color:#fff; margin-bottom:3px; }
    .ot-qty-bar { background:rgba(255,255,255,.25); border-radius:99px; height:4px; overflow:hidden; }
    .ot-qty-bar-fill { background:#FF5722; border-radius:99px; height:100%; }

    /* Body */
    .ot-card-body { padding:12px 12px 14px; flex:1; display:flex; flex-direction:column; gap:4px; }
    .ot-card-brand { font-size:11px; color:#007185; font-weight:700; text-transform:uppercase; letter-spacing:.3px; }
    .ot-card-name { font-size:13px; color:#0F1111; line-height:1.4; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; }

    .ot-stars { display:flex; align-items:center; gap:2px; margin-top:2px; }
    .ot-stars span { font-size:11px; color:#555; margin-left:3px; }

    .ot-price-row { display:flex; align-items:baseline; gap:6px; margin-top:5px; flex-wrap:wrap; }
    .ot-price-now { font-size:22px; font-weight:900; color:#B12704; }
    .ot-price-now sup { font-size:13px; vertical-align:super; }
    .ot-price-now sub { font-size:13px; vertical-align:baseline; }
    .ot-price-was { font-size:12px; color:#888; }
    .ot-price-was s { color:#aaa; }
    .ot-save-pill { font-size:11px; background:#FFF3E0; color:#E65100; border:1px solid #FFCC02; border-radius:4px; padding:2px 7px; font-weight:800; }

    .ot-card-meta { display:flex; align-items:center; gap:8px; margin-top:4px; flex-wrap:wrap; }
    .ot-meta-tag { display:inline-flex; align-items:center; gap:4px; font-size:11px; color:#555; background:#f7f8f8; border-radius:4px; padding:3px 7px; }

    .ot-in-stock { display:flex; align-items:center; gap:4px; font-size:12px; color:#007600; font-weight:600; margin-top:3px; }
    .ot-low-stock { display:flex; align-items:center; gap:4px; font-size:12px; color:#C7511F; font-weight:600; margin-top:3px; }

    .ot-add-btn { display:flex; align-items:center; justify-content:center; gap:6px; width:100%; background:#FFD814; border:1px solid #FCD200; border-radius:20px; padding:9px; font-size:13px; font-weight:700; color:#131921; cursor:pointer; margin-top:8px; text-decoration:none; transition:background .12s,transform .1s; }
    .ot-add-btn:hover { background:#F7CA00; transform:translateY(-1px); color:#131921; }
    .ot-view-link { font-size:12px; color:#007185; text-align:center; display:block; margin-top:5px; }
    .ot-view-link:hover { color:#C7511F; text-decoration:underline; }

    /* ── Clearance corner fold ──────────────────────── */
    .ot-fold { position:absolute; top:0; right:0; width:0; height:0; border-style:solid; border-width:0 44px 44px 0; border-color:transparent #FF5722 transparent transparent; z-index:4; }
    .ot-fold::after { content:'%'; position:absolute; top:4px; right:-36px; color:#fff; font-size:11px; font-weight:900; }

    /* ── Section dividers ───────────────────────────── */
    .ot-section-head { display:flex; align-items:center; gap:12px; margin:28px 0 16px; }
    .ot-section-head h2 { font-size:18px; font-weight:800; color:#0F1111; margin:0; white-space:nowrap; }
    .ot-section-head-line { flex:1; height:2px; background:linear-gradient(90deg,#FF5722,transparent); border-radius:99px; }
    .ot-section-badge { background:#FF5722; color:#fff; font-size:11px; font-weight:800; border-radius:20px; padding:3px 12px; white-space:nowrap; }

    /* ── Bottom info strip ──────────────────────────── */
    .ot-info-strip { background:#fff; border:1px solid #e3e6e6; border-radius:8px; padding:20px; margin-top:28px; display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:20px; }
    .ot-info-item { display:flex; align-items:flex-start; gap:12px; }
    .ot-info-icon { width:38px; height:38px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .ot-info-item h4 { font-size:13px; font-weight:700; color:#0F1111; margin:0 0 3px; }
    .ot-info-item p { font-size:12px; color:#555; margin:0; line-height:1.5; }

    /* ── Empty state ────────────────────────────────── */
    .ot-empty { text-align:center; padding:60px 20px; background:#fff; border-radius:8px; border:1px solid #e3e6e6; }

    @media(max-width:760px){
        .ot-wrap{flex-direction:column;}
        .ot-sidebar{width:100%;}
        .ot-grid{grid-template-columns:repeat(2,1fr);}
        .ot-hero-inner{flex-direction:column;}
        .ot-countdown-box{display:none;}
    }
    @media(max-width:480px){
        .ot-grid{grid-template-columns:1fr;}
    }
</style>
@endsection

@section('content')
@php
    /* ── Helpers ────────────────────────────────── */
    $discounts   = [30,35,40,45,50,55,60,65,70];
    $dealTypes   = ['Clearance','Clearance','Overstock','Final Sale','Open Box','Clearance','Overstock','Final Sale'];
    $typeBadge   = ['Clearance'=>'clearance','Overstock'=>'overstock','Final Sale'=>'final-sale','Open Box'=>'open-box'];
    $qtyPcts     = [12,18,25,35,42,55,68,78,87,92,96];  /* % sold */
    $qtyLeft     = [3,5,8,12,17,24,31,46];
    $ratings     = [3.8,4.0,4.1,4.2,4.3,4.5,4.6,4.8];
    $reviews     = [29,58,103,187,312,478,920,2180];
    $isUrgent    = [true,false,false,true,false,false,true,false,false,true];
    $hasFold     = [true,false,true,false,false,true,false,true];

    function otDisc($id,$arr){ return $arr[$id % count($arr)]; }
    function otStars($r){
        $f=floor($r);$h=($r-$f)>=0.5?1:0;$e=5-$f-$h;$o='';
        for($i=0;$i<$f;$i++) $o.='<svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        if($h) $o.='<svg width="12" height="12" viewBox="0 0 24 24" fill="#ddd" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        for($i=0;$i<$e;$i++) $o.='<svg width="12" height="12" viewBox="0 0 24 24" fill="#ddd" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        return $o;
    }

    $activeType  = request('type');
    $activeCat   = request('category');
    $activeBrand = request('brand');
    $activeSort  = request('sort','featured');
@endphp

<div class="ot-page">

{{-- Hero --}}
<div class="ot-hero">
    <div class="ot-hero-inner">
        <div class="ot-hero-left">
            <div class="ot-hero-eyebrow">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                Clearance Event
            </div>
            <h1>MyShop <span>Outlet</span></h1>
            <p>Deep discounts on clearance, overstock &amp; open-box items. Limited quantities — once they're gone, they're gone!</p>
            <a href="#ot-deals" class="ot-hero-cta">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                Shop Outlet Deals
            </a>
        </div>
        <div class="ot-hero-stats">
            <div class="ot-hero-stat">
                <div class="ot-hero-stat-num">{{ $products->count() }}+</div>
                <div class="ot-hero-stat-label">Items</div>
            </div>
            <div class="ot-hero-stat">
                <div class="ot-hero-stat-num">70%</div>
                <div class="ot-hero-stat-label">Max Off</div>
            </div>
            <div class="ot-hero-stat">
                <div class="ot-hero-stat-num">4</div>
                <div class="ot-hero-stat-label">Categories</div>
            </div>
        </div>
    </div>
</div>

{{-- Urgency ticker --}}
<div class="ot-ticker">
    <div class="ot-ticker-inner">
        @foreach(['Clearance Sale — Up to 70% Off','Final Sale — No Returns','Limited Quantities Left','Overstock Blowout','Open Box — Like New Prices','Ends Soon — Shop Now','Free Shipping on Orders $35+','Clearance Sale — Up to 70% Off','Final Sale — No Returns','Limited Quantities Left','Overstock Blowout','Open Box — Like New Prices','Ends Soon — Shop Now','Free Shipping on Orders $35+'] as $tick)
        <span class="ot-ticker-item">
            <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
            {{ $tick }}
            <span class="ot-ticker-sep">|</span>
        </span>
        @endforeach
    </div>
</div>

{{-- Breadcrumb --}}
<div style="background:#fff;border-bottom:1px solid #e3e6e6;">
    <div class="ot-breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span> › </span>
        <span style="color:#0F1111;">Outlet &amp; Clearance</span>
    </div>
</div>

{{-- Category jumps --}}
<div class="ot-cat-jumps">
    <div class="ot-cat-jumps-inner">
        <a href="{{ route('outlet') }}" class="ot-cat-jump {{ !$activeType && !$activeCat ? 'active' : '' }}">All Outlet</a>
        <a href="{{ route('outlet', ['type'=>'clearance']) }}" class="ot-cat-jump {{ $activeType=='clearance' ? 'active' : '' }}">
            🔴 Clearance
        </a>
        <a href="{{ route('outlet', ['type'=>'overstock']) }}" class="ot-cat-jump {{ $activeType=='overstock' ? 'active' : '' }}">
            🔵 Overstock
        </a>
        <a href="{{ route('outlet', ['type'=>'final-sale']) }}" class="ot-cat-jump {{ $activeType=='final-sale' ? 'active' : '' }}">
            🟣 Final Sale
        </a>
        <a href="{{ route('outlet', ['type'=>'open-box']) }}" class="ot-cat-jump {{ $activeType=='open-box' ? 'active' : '' }}">
            📦 Open Box
        </a>
        <div style="width:1px;height:22px;background:#e3e6e6;flex-shrink:0;margin:0 4px;"></div>
        @foreach($categories->take(8) as $cat)
        <a href="{{ route('outlet', ['category'=>$cat->id]) }}" class="ot-cat-jump {{ $activeCat==$cat->id ? 'active' : '' }}">{{ $cat->name }}</a>
        @endforeach
    </div>
</div>

{{-- Body --}}
<div class="ot-wrap">

    {{-- SIDEBAR --}}
    <div class="ot-sidebar">

        {{-- Countdown timer --}}
        <div class="ot-countdown-box">
            <h4>⚡ Sale Ends In</h4>
            <div class="ot-countdown-dials">
                <div class="ot-dial">
                    <div class="ot-dial-num" id="ot-hours">08</div>
                    <div class="ot-dial-label">Hrs</div>
                </div>
                <div class="ot-dial-sep">:</div>
                <div class="ot-dial">
                    <div class="ot-dial-num" id="ot-mins">34</div>
                    <div class="ot-dial-label">Min</div>
                </div>
                <div class="ot-dial-sep">:</div>
                <div class="ot-dial">
                    <div class="ot-dial-num" id="ot-secs">12</div>
                    <div class="ot-dial-label">Sec</div>
                </div>
            </div>
        </div>

        {{-- Deal type --}}
        <div class="ot-sb-box">
            <div class="ot-sb-head">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#FF5722" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                Deal Type
            </div>
            <div class="ot-sb-body">
                <a href="{{ route('outlet', request()->except('type')) }}" class="ot-sb-item {{ !$activeType ? 'active' : '' }}">
                    <input type="radio" {{ !$activeType ? 'checked' : '' }} readonly /> All Types
                </a>
                @foreach(['clearance'=>'Clearance','overstock'=>'Overstock','final-sale'=>'Final Sale','open-box'=>'Open Box'] as $key=>$lbl)
                <a href="{{ route('outlet', array_merge(request()->except('type'),['type'=>$key])) }}" class="ot-sb-item {{ $activeType==$key ? 'active' : '' }}">
                    <input type="radio" {{ $activeType==$key ? 'checked' : '' }} readonly /> {{ $lbl }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Category --}}
        @if($categories->isNotEmpty())
        <div class="ot-sb-box">
            <div class="ot-sb-head">Department</div>
            <div class="ot-sb-body">
                <a href="{{ route('outlet', request()->except('category')) }}" class="ot-sb-item {{ !$activeCat ? 'active' : '' }}">
                    <input type="radio" {{ !$activeCat ? 'checked' : '' }} readonly /> All
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('outlet', array_merge(request()->except('category'),['category'=>$cat->id])) }}" class="ot-sb-item {{ $activeCat==$cat->id ? 'active' : '' }}">
                    <input type="radio" {{ $activeCat==$cat->id ? 'checked' : '' }} readonly /> {{ $cat->name }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Brand --}}
        @if($brands->isNotEmpty())
        <div class="ot-sb-box">
            <div class="ot-sb-head">Brand</div>
            <div class="ot-sb-body">
                <a href="{{ route('outlet', request()->except('brand')) }}" class="ot-sb-item {{ !$activeBrand ? 'active' : '' }}">
                    <input type="radio" {{ !$activeBrand ? 'checked' : '' }} readonly /> All Brands
                </a>
                @foreach($brands->take(10) as $brand)
                <a href="{{ route('outlet', array_merge(request()->except('brand'),['brand'=>$brand->id])) }}" class="ot-sb-item {{ $activeBrand==$brand->id ? 'active' : '' }}">
                    <input type="radio" {{ $activeBrand==$brand->id ? 'checked' : '' }} readonly /> {{ $brand->name }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Discount --}}
        <div class="ot-sb-box">
            <div class="ot-sb-head">Discount</div>
            <div class="ot-sb-body">
                @foreach(['30'=>'30% & above','40'=>'40% & above','50'=>'50% & above','60'=>'60% & above'] as $val=>$lbl)
                <a href="{{ route('outlet', array_merge(request()->except('min_disc'),['min_disc'=>$val])) }}" class="ot-sb-item {{ request('min_disc')==$val ? 'active' : '' }}">
                    <input type="radio" {{ request('min_disc')==$val ? 'checked' : '' }} readonly /> {{ $lbl }}
                </a>
                @endforeach
            </div>
        </div>

    </div>

    {{-- MAIN --}}
    <div class="ot-main" id="ot-deals">

        {{-- Deal type pills --}}
        <div class="ot-deal-type-banner">
            @foreach([
                ['key'=>'','icon'=>'<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>','label'=>'All Outlet','sub'=>'All deals'],
                ['key'=>'clearance','icon'=>'<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>','label'=>'Clearance','sub'=>'Final stock'],
                ['key'=>'overstock','icon'=>'<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>','label'=>'Overstock','sub'=>'Excess inventory'],
                ['key'=>'final-sale','icon'=>'<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>','label'=>'Final Sale','sub'=>'No returns'],
                ['key'=>'open-box','icon'=>'<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"/><rect x="1" y="3" width="22" height="5"/><line x1="10" y1="12" x2="14" y2="12"/></svg>','label'=>'Open Box','sub'=>'Box opened only'],
            ] as $pill)
            <a href="{{ route('outlet', $pill['key'] ? ['type'=>$pill['key']] : []) }}"
               class="ot-deal-type-pill {{ ($activeType ?? '')==$pill['key'] ? 'active' : '' }}">
                <span class="ot-dtp-icon">{!! $pill['icon'] !!}</span>
                <span class="ot-dtp-label">{{ $pill['label'] }}</span>
                <span class="ot-dtp-sub">{{ $pill['sub'] }}</span>
            </a>
            @endforeach
        </div>

        {{-- Topbar --}}
        <div class="ot-topbar">
            <div class="ot-topbar-left"><b>{{ $products->count() }}</b> outlet items available</div>
            <div class="ot-topbar-right">
                Sort by:
                <select onchange="window.location.href=this.value">
                    <option value="{{ route('outlet', array_merge(request()->all(),['sort'=>'featured'])) }}" {{ $activeSort=='featured' ? 'selected' : '' }}>Featured</option>
                    <option value="{{ route('outlet', array_merge(request()->all(),['sort'=>'discount'])) }}" {{ $activeSort=='discount' ? 'selected' : '' }}>Biggest Discount</option>
                    <option value="{{ route('outlet', array_merge(request()->all(),['sort'=>'ending'])) }}" {{ $activeSort=='ending' ? 'selected' : '' }}>Ending Soon</option>
                    <option value="{{ route('outlet', array_merge(request()->all(),['sort'=>'price_asc'])) }}" {{ $activeSort=='price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="{{ route('outlet', array_merge(request()->all(),['sort'=>'price_desc'])) }}" {{ $activeSort=='price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </div>
        </div>

        {{-- Section head --}}
        @php $sectionLabel = $activeType ? ucwords(str_replace('-',' ',$activeType)) : 'All Outlet'; @endphp
        <div class="ot-section-head">
            <h2>{{ $sectionLabel }} Deals</h2>
            <div class="ot-section-head-line"></div>
            <span class="ot-section-badge">⚡ Limited Stock</span>
        </div>

        {{-- Grid --}}
        @if($products->isEmpty())
            <div class="ot-empty">
                <svg width="72" height="72" viewBox="0 0 24 24" fill="none" stroke="#ddd" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="margin:0 auto 16px;display:block;"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <h3 style="font-size:18px;font-weight:700;color:#0F1111;margin-bottom:8px;">No outlet items found</h3>
                <p style="font-size:14px;color:#555;margin-bottom:12px;">Try adjusting your filters or check back soon for new clearance items.</p>
                <a href="{{ route('outlet') }}" style="color:#007185;font-size:13px;">Clear all filters</a>
            </div>
        @else
        <div class="ot-grid">
            @foreach($products as $product)
            @php
                $imgs      = collect($product->images ?? [])->filter()->values();
                $thumb     = $imgs->first() ? \Illuminate\Support\Facades\Storage::url($imgs->first()) : null;
                $disc      = otDisc($product->id, $discounts);
                $type      = $dealTypes[$product->id % count($dealTypes)];
                $typeCls   = $typeBadge[$type];
                $qtyPct    = $qtyPcts[$product->id % count($qtyPcts)];
                $qtyLeft   = $qtyLeft[$product->id % count($qtyLeft)];
                $urgent    = $isUrgent[$product->id % count($isUrgent)];
                $fold      = $hasFold[$product->id % count($hasFold)];
                $rating    = $ratings[$product->id % count($ratings)];
                $rev       = $reviews[$product->id % count($reviews)];
                $saveAmt   = round($product->price * $disc / 100, 2);
                $afterP    = round($product->price - $saveAmt, 2);
                $intPart   = floor($afterP);
                $decPart   = str_pad((int)(($afterP - $intPart) * 100), 2, '0', STR_PAD_LEFT);
                $isMega    = $disc >= 50;
            @endphp
            <div class="ot-card {{ $urgent ? 'urgent' : '' }}" onclick="window.location='{{ route('products.show', $product->slug) }}'">

                {{-- Image area --}}
                <div class="ot-card-img-wrap">
                    @if($thumb)
                        <img src="{{ $thumb }}" alt="{{ $product->name }}" loading="lazy" />
                    @else
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#d5d9d9" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    @endif

                    {{-- Discount badge --}}
                    <div class="ot-disc-badge {{ $isMega ? 'mega' : '' }}">-{{ $disc }}%</div>

                    {{-- Type badge --}}
                    <div class="ot-type-badge {{ $typeCls }}">{{ $type }}</div>

                    {{-- Clearance corner fold --}}
                    @if($fold)
                    <div class="ot-fold"></div>
                    @endif

                    {{-- Qty bar --}}
                    <div class="ot-qty-bar-wrap">
                        <div class="ot-qty-bar-label">{{ $qtyPct }}% claimed — {{ $qtyLeft }} left</div>
                        <div class="ot-qty-bar">
                            <div class="ot-qty-bar-fill" style="width:{{ $qtyPct }}%;"></div>
                        </div>
                    </div>
                </div>

                {{-- Body --}}
                <div class="ot-card-body">
                    @if($product->brand)
                    <div class="ot-card-brand">{{ $product->brand->name }}</div>
                    @endif
                    <div class="ot-card-name">{{ $product->name }}</div>

                    <div class="ot-stars">
                        {!! otStars($rating) !!}
                        <span>{{ $rating }} ({{ number_format($rev) }})</span>
                    </div>

                    <div class="ot-price-row">
                        <span class="ot-price-now"><sup>$</sup>{{ $intPart }}<sub>{{ $decPart }}</sub></span>
                        <span class="ot-price-was">was <s>${{ number_format($product->price, 2) }}</s></span>
                    </div>
                    <span class="ot-save-pill" style="display:inline-block;margin-top:2px;">
                        Save ${{ number_format($saveAmt, 2) }} ({{ $disc }}% off)
                    </span>

                    <div class="ot-card-meta">
                        @if($product->category)
                        <span class="ot-meta-tag">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/></svg>
                            {{ $product->category->name }}
                        </span>
                        @endif
                        <span class="ot-meta-tag">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="22" height="5"/><polyline points="21 8 21 21 3 21 3 8"/></svg>
                            {{ $type }}
                        </span>
                    </div>

                    @if($urgent)
                    <div class="ot-low-stock">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Only {{ $qtyLeft }} left in stock!
                    </div>
                    @else
                    <div class="ot-in-stock">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        In Stock
                    </div>
                    @endif

                    <a href="{{ route('products.show', $product->slug) }}" class="ot-add-btn" onclick="event.stopPropagation();">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        Add to Cart
                    </a>
                    <a href="{{ route('products.show', $product->slug) }}" class="ot-view-link" onclick="event.stopPropagation();">View outlet deal ›</a>
                </div>

            </div>
            @endforeach
        </div>
        @endif

        {{-- Info strip --}}
        <div class="ot-info-strip">
            <div class="ot-info-item">
                <div class="ot-info-icon" style="background:#FFF3E0;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FF5722" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                </div>
                <div>
                    <h4>Clearance</h4>
                    <p>End-of-line products at the deepest discounts. While stocks last.</p>
                </div>
            </div>
            <div class="ot-info-item">
                <div class="ot-info-icon" style="background:#E3F2FD;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0066c0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                </div>
                <div>
                    <h4>Overstock</h4>
                    <p>Brand new products — excess inventory sold at reduced prices.</p>
                </div>
            </div>
            <div class="ot-info-item">
                <div class="ot-info-icon" style="background:#EDE7F6;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#7B1FA2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                </div>
                <div>
                    <h4>Final Sale</h4>
                    <p>Non-returnable items at the absolute lowest prices. Act fast!</p>
                </div>
            </div>
            <div class="ot-info-item">
                <div class="ot-info-icon" style="background:#FBE9E7;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#E65100" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="21 8 21 21 3 21 3 8"/><rect x="1" y="3" width="22" height="5"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
                </div>
                <div>
                    <h4>Open Box</h4>
                    <p>Box was opened but product is in perfect condition. Big savings!</p>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

<script>
/* ── Countdown timer ──────────────────────────── */
(function(){
    const end = new Date();
    end.setHours(end.getHours() + 8, end.getMinutes() + 34, end.getSeconds() + 12);

    function pad(n){ return String(n).padStart(2,'0'); }
    function tick(){
        const diff = Math.max(0, end - Date.now());
        const h = Math.floor(diff/3600000);
        const m = Math.floor((diff%3600000)/60000);
        const s = Math.floor((diff%60000)/1000);
        const hEl = document.getElementById('ot-hours');
        const mEl = document.getElementById('ot-mins');
        const sEl = document.getElementById('ot-secs');
        if(hEl) hEl.textContent = pad(h);
        if(mEl) mEl.textContent = pad(m);
        if(sEl) sEl.textContent = pad(s);
    }
    tick();
    setInterval(tick, 1000);
})();
</script>
@endsection
