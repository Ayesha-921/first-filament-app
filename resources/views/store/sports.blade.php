@extends('store.layout')
@section('title', 'Sports — Fitness, Gear & Equipment')

@section('head')
<style>
    /* ── Page ───────────────────────────────────────── */
    .sp-page { background: #EAEDED; min-height: 80vh; }

    /* ── Hero ───────────────────────────────────────── */
    .sp-hero { background: linear-gradient(115deg,#131921 0%,#1a2a3a 55%,#131921 100%); padding: 28px 18px; position: relative; overflow: hidden; }
    .sp-hero::before { content:''; position:absolute; right:-60px; top:-60px; width:320px; height:320px; background:rgba(255,153,0,.07); border-radius:50%; pointer-events:none; }
    .sp-hero::after  { content:''; position:absolute; left:38%; bottom:-80px; width:260px; height:260px; background:rgba(255,255,255,.03); border-radius:50%; pointer-events:none; }
    .sp-hero-inner { max-width:1340px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; gap:20px; flex-wrap:wrap; position:relative; z-index:1; }
    .sp-hero-eyebrow { display:inline-flex; align-items:center; gap:6px; background:rgba(255,153,0,.15); border:1px solid rgba(255,153,0,.4); border-radius:20px; padding:4px 14px; font-size:12px; color:#FF9900; font-weight:700; letter-spacing:.5px; margin-bottom:10px; text-transform:uppercase; }
    .sp-hero-left h1 { font-size:32px; font-weight:900; color:#fff; margin:0 0 8px; line-height:1.15; }
    .sp-hero-left h1 span { color:#FF9900; }
    .sp-hero-left p { font-size:13px; color:#adbac7; margin:0 0 18px; max-width:480px; line-height:1.6; }
    .sp-hero-btns { display:flex; gap:10px; flex-wrap:wrap; }
    .sp-hero-btn { display:inline-flex; align-items:center; gap:7px; border-radius:6px; padding:10px 20px; font-size:13px; font-weight:700; cursor:pointer; text-decoration:none; transition:all .12s; }
    .sp-hero-btn.primary { background:#FFD814; border:1px solid #FCD200; color:#131921; }
    .sp-hero-btn.primary:hover { background:#F7CA00; color:#131921; }
    .sp-hero-btn.secondary { background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.25); color:#fff; }
    .sp-hero-btn.secondary:hover { background:rgba(255,255,255,.18); }
    .sp-hero-stats { display:flex; gap:12px; flex-wrap:wrap; }
    .sp-stat { text-align:center; background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.13); border-radius:10px; padding:14px 18px; min-width:76px; }
    .sp-stat-num { font-size:22px; font-weight:900; color:#FF9900; line-height:1; }
    .sp-stat-label { font-size:10px; color:#adbac7; text-transform:uppercase; letter-spacing:.5px; margin-top:4px; }

    /* ── Activity ticker ─────────────────────────────── */
    .sp-ticker { background:linear-gradient(90deg,#007185,#005a6a); overflow:hidden; }
    .sp-ticker-inner { max-width:1340px; margin:0 auto; padding:9px 18px; display:flex; align-items:center; gap:0; }
    .sp-ticker-label { font-size:12px; font-weight:800; color:#fff; white-space:nowrap; flex-shrink:0; display:flex; align-items:center; gap:6px; padding-right:14px; border-right:1px solid rgba(255,255,255,.3); margin-right:14px; }
    .sp-ticker-outer { overflow:hidden; flex:1; }
    .sp-ticker-track { display:flex; gap:28px; width:max-content; }
    .sp-ticker-item { font-size:12px; color:rgba(255,255,255,.9); white-space:nowrap; font-weight:500; }

    /* ── Activity tabs ───────────────────────────────── */
    .sp-activity-bar { background:#fff; border-bottom:2px solid #e3e6e6; }
    .sp-activity-inner { max-width:1340px; margin:0 auto; padding:0 18px; display:flex; overflow-x:auto; scrollbar-width:none; }
    .sp-activity-inner::-webkit-scrollbar { display:none; }
    .sp-activity-tab { display:inline-flex; align-items:center; gap:7px; padding:14px 20px; font-size:14px; font-weight:600; color:#555; white-space:nowrap; border-bottom:3px solid transparent; cursor:pointer; text-decoration:none; transition:color .12s,border-color .12s; flex-shrink:0; }
    .sp-activity-tab:hover { color:#C7511F; border-bottom-color:#FF9900; }
    .sp-activity-tab.active { color:#C7511F; border-bottom-color:#FF9900; font-weight:800; }
    .sp-activity-count { background:#FF9900; color:#131921; font-size:10px; font-weight:800; border-radius:99px; padding:1px 7px; }

    /* ── Category chips ──────────────────────────────── */
    .sp-cats-bar { background:#f7f8f8; border-bottom:1px solid #e3e6e6; }
    .sp-cats-inner { max-width:1340px; margin:0 auto; padding:12px 18px; display:flex; gap:8px; overflow-x:auto; scrollbar-width:none; }
    .sp-cats-inner::-webkit-scrollbar { display:none; }
    .sp-cat-chip { flex-shrink:0; display:flex; flex-direction:column; align-items:center; gap:5px; padding:9px 14px; border:1px solid #e3e6e6; border-radius:10px; cursor:pointer; text-decoration:none; transition:all .15s; background:#fff; min-width:72px; }
    .sp-cat-chip:hover { border-color:#FF9900; background:#fff8ee; }
    .sp-cat-chip.active { border-color:#FF9900; background:#fff4e0; box-shadow:0 0 0 2px rgba(255,153,0,.14); }
    .sp-cat-chip-icon { font-size:22px; line-height:1; }
    .sp-cat-chip-label { font-size:11px; font-weight:600; color:#0F1111; white-space:nowrap; }
    .sp-cat-chip.active .sp-cat-chip-label { color:#C7511F; }

    /* ── Brands bar ──────────────────────────────────── */
    .sp-brands-bar { background:#fff; border-bottom:1px solid #e3e6e6; }
    .sp-brands-inner { max-width:1340px; margin:0 auto; padding:10px 18px; display:flex; align-items:center; gap:6px; overflow-x:auto; scrollbar-width:none; }
    .sp-brands-inner::-webkit-scrollbar { display:none; }
    .sp-brands-label { font-size:12px; font-weight:700; color:#555; white-space:nowrap; flex-shrink:0; margin-right:6px; }
    .sp-brand-pill { flex-shrink:0; padding:5px 14px; border:1px solid #d5d9d9; border-radius:20px; font-size:12px; font-weight:600; color:#0F1111; cursor:pointer; text-decoration:none; background:#fff; transition:all .12s; }
    .sp-brand-pill:hover { border-color:#FF9900; color:#C7511F; background:#fff8ee; }
    .sp-brand-pill.active { background:#131921; color:#FF9900; border-color:#131921; }

    /* ── Breadcrumb ──────────────────────────────────── */
    .sp-breadcrumb { max-width:1340px; margin:0 auto; padding:10px 18px; font-size:13px; color:#555; }
    .sp-breadcrumb a { color:#007185; }
    .sp-breadcrumb a:hover { color:#C7511F; text-decoration:underline; }

    /* ── Layout ──────────────────────────────────────── */
    .sp-wrap { max-width:1340px; margin:0 auto; padding:20px 18px 50px; display:flex; gap:20px; align-items:flex-start; }

    /* ── Sidebar ─────────────────────────────────────── */
    .sp-sidebar { width:210px; flex-shrink:0; }
    .sp-sb-box { background:#fff; border:1px solid #e3e6e6; border-radius:8px; overflow:hidden; margin-bottom:14px; }
    .sp-sb-head { font-size:14px; font-weight:700; color:#0F1111; padding:12px 16px 10px; border-bottom:1px solid #f0f2f2; background:#f7f8f8; display:flex; align-items:center; gap:7px; }
    .sp-sb-body { padding:8px 0; }
    .sp-sb-item { display:flex; align-items:center; gap:9px; padding:8px 16px; font-size:13px; color:#0F1111; cursor:pointer; text-decoration:none; transition:background .1s; border-left:3px solid transparent; }
    .sp-sb-item:hover { background:#fff8ee; border-left-color:#FF9900; color:#C7511F; }
    .sp-sb-item.active { background:#fff4e0; border-left-color:#FF9900; font-weight:700; color:#C7511F; }
    .sp-sb-item input[type=radio] { accent-color:#FF9900; width:14px; height:14px; flex-shrink:0; }
    .sp-sb-item-count { margin-left:auto; font-size:11px; color:#888; background:#f0f2f2; border-radius:99px; padding:1px 7px; }

    /* Size grid */
    .sp-size-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:6px; padding:10px 12px 14px; }
    .sp-size-btn { border:1px solid #d5d9d9; border-radius:4px; padding:6px 4px; font-size:12px; font-weight:600; color:#0F1111; background:#fff; cursor:pointer; text-align:center; transition:all .12s; }
    .sp-size-btn:hover { border-color:#FF9900; color:#C7511F; background:#fff8ee; }
    .sp-size-btn.active { background:#131921; color:#FF9900; border-color:#131921; }

    /* Price range */
    .sp-price-inputs { display:flex; gap:6px; align-items:center; padding:10px 16px; }
    .sp-price-inputs input { width:60px; border:1px solid #d5d9d9; border-radius:4px; padding:5px 6px; font-size:12px; outline:none; }
    .sp-price-inputs input:focus { border-color:#FF9900; box-shadow:0 0 0 2px rgba(255,153,0,.15); }
    .sp-price-inputs span { font-size:12px; color:#555; }
    .sp-price-go { background:#FF9900; color:#131921; border:none; border-radius:4px; padding:5px 10px; font-size:12px; font-weight:700; cursor:pointer; }

    /* ── Main ────────────────────────────────────────── */
    .sp-main { flex:1; min-width:0; }

    /* ── Featured athletes banner ────────────────────── */
    .sp-athletes { background:linear-gradient(135deg,#131921,#1a2a3a); border-radius:8px; padding:20px; margin-bottom:20px; color:#fff; }
    .sp-athletes h3 { font-size:16px; font-weight:700; margin:0 0 14px; display:flex; align-items:center; gap:8px; }
    .sp-athletes h3 span { color:#FF9900; }
    .sp-athletes-row { display:flex; gap:12px; overflow-x:auto; scrollbar-width:none; }
    .sp-athletes-row::-webkit-scrollbar { display:none; }
    .sp-athlete-card { min-width:100px; text-align:center; cursor:pointer; transition:transform .15s; }
    .sp-athlete-card:hover { transform:translateY(-3px); }
    .sp-athlete-img { width:70px; height:70px; border-radius:50%; background:rgba(255,255,255,.1); display:flex; align-items:center; justify-content:center; font-size:32px; margin:0 auto 8px; border:2px solid rgba(255,153,0,.3); }
    .sp-athlete-name { font-size:12px; font-weight:700; }
    .sp-athlete-sport { font-size:10px; color:#FF9900; text-transform:uppercase; }

    /* ── Promo banners ───────────────────────────────── */
    .sp-promos { display:grid; grid-template-columns:repeat(auto-fit,minmax(195px,1fr)); gap:12px; margin-bottom:20px; }
    .sp-promo { border-radius:10px; padding:18px; display:flex; flex-direction:column; gap:7px; position:relative; overflow:hidden; cursor:pointer; transition:transform .15s,box-shadow .15s; text-decoration:none; }
    .sp-promo:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,.15); }
    .sp-promo h4 { font-size:14px; font-weight:800; margin:0; }
    .sp-promo p  { font-size:12px; margin:0; opacity:.9; line-height:1.4; }
    .sp-promo span { font-size:11px; font-weight:700; margin-top:4px; }
    .sp-promo-icon { position:absolute; right:12px; top:50%; transform:translateY(-50%); font-size:42px; opacity:.22; }
    .sp-p1 { background:linear-gradient(135deg,#131921,#1a2a3a); color:#fff; }
    .sp-p1 h4 { color:#FF9900; } .sp-p1 span { color:#FFD814; }
    .sp-p2 { background:linear-gradient(135deg,#007185,#005a6a); color:#fff; }
    .sp-p2 span { color:#FFD814; }
    .sp-p3 { background:linear-gradient(135deg,#CC0C39,#a50a2d); color:#fff; }
    .sp-p3 span { color:#FFD814; }
    .sp-p4 { background:linear-gradient(135deg,#2d5a27,#1a3d1a); color:#fff; }
    .sp-p4 h4 { color:#FF9900; } .sp-p4 span { color:#FFD814; }

    /* Topbar */
    .sp-topbar { display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; flex-wrap:wrap; gap:10px; }
    .sp-topbar-left { font-size:14px; color:#555; }
    .sp-topbar-left b { color:#0F1111; }
    .sp-topbar-right { display:flex; align-items:center; gap:8px; font-size:13px; color:#555; }
    .sp-topbar-right select { border:1px solid #d5d9d9; border-radius:6px; padding:6px 10px; font-size:13px; background:#fff; cursor:pointer; outline:none; }

    /* ── Product grid ────────────────────────────────── */
    .sp-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:14px; }

    /* ── Product card ────────────────────────────────── */
    .sp-card { background:#fff; border:1px solid #e3e6e6; border-radius:8px; overflow:hidden; display:flex; flex-direction:column; position:relative; transition:box-shadow .15s,border-color .15s; cursor:pointer; }
    .sp-card:hover { box-shadow:0 4px 20px rgba(0,0,0,.12); border-color:#FF9900; }

    /* Badges */
    .sp-disc-badge { position:absolute; top:8px; left:8px; background:#CC0C39; color:#fff; font-size:12px; font-weight:900; border-radius:4px; padding:3px 8px; z-index:3; }
    .sp-type-badge { position:absolute; top:8px; right:8px; border-radius:4px; padding:3px 8px; font-size:10px; font-weight:800; z-index:3; }
    .sp-type-badge.new    { background:#007600; color:#fff; }
    .sp-type-badge.hot    { background:#CC0C39; color:#fff; }
    .sp-type-badge.deal   { background:#131921; color:#FF9900; }
    .sp-type-badge.pro    { background:#007185; color:#fff; }
    .sp-type-badge.sale   { background:#FF9900; color:#131921; }

    /* Image */
    .sp-card-img { background:#f7f8f8; aspect-ratio:1/1; display:flex; align-items:center; justify-content:center; overflow:hidden; position:relative; }
    .sp-card-img img { max-width:84%; max-height:84%; object-fit:contain; transition:transform .2s; }
    .sp-card:hover .sp-card-img img { transform:scale(1.04); }

    /* Quick view */
    .sp-quick-view { position:absolute; bottom:0; left:0; right:0; background:rgba(19,25,33,.82); color:#fff; font-size:11px; font-weight:700; text-align:center; padding:8px; z-index:4; opacity:0; transition:opacity .15s; display:flex; align-items:center; justify-content:center; gap:5px; }
    .sp-card:hover .sp-quick-view { opacity:1; }

    /* Wishlist */
    .sp-wish-btn { position:absolute; top:8px; right:48px; width:28px; height:28px; border-radius:50%; background:rgba(255,255,255,.9); border:1px solid #e3e6e6; display:flex; align-items:center; justify-content:center; z-index:4; cursor:pointer; transition:all .12s; }
    .sp-wish-btn:hover { background:#fff; border-color:#CC0C39; }
    .sp-wish-btn.saved svg { fill:#CC0C39; stroke:#CC0C39; }

    /* Body */
    .sp-card-body { padding:12px 12px 14px; flex:1; display:flex; flex-direction:column; gap:4px; }
    .sp-card-sport { font-size:10px; color:#007185; font-weight:700; text-transform:uppercase; letter-spacing:.4px; }
    .sp-card-brand { font-size:11px; color:#C7511F; font-weight:700; text-transform:uppercase; letter-spacing:.3px; }
    .sp-card-name { font-size:13px; color:#0F1111; line-height:1.4; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; }

    /* Stars */
    .sp-stars { display:flex; align-items:center; gap:2px; }
    .sp-stars span { font-size:11px; color:#555; margin-left:3px; }

    /* Price */
    .sp-price-row { display:flex; align-items:baseline; gap:6px; margin-top:4px; flex-wrap:wrap; }
    .sp-price { font-size:20px; font-weight:900; color:#B12704; }
    .sp-price sup { font-size:12px; vertical-align:super; }
    .sp-was { font-size:12px; color:#888; }
    .sp-was s { color:#aaa; }
    .sp-save-pill { font-size:11px; background:#fff4e0; color:#C7511F; border:1px solid #FFD580; border-radius:4px; padding:2px 6px; font-weight:700; display:inline-block; }

    /* Tags */
    .sp-spec-tags { display:flex; gap:4px; flex-wrap:wrap; margin-top:4px; }
    .sp-spec-tag { font-size:10px; background:#f0f2f2; color:#555; border-radius:4px; padding:2px 7px; }
    .sp-spec-tag.pro    { background:#e6f3f5; color:#007185; font-weight:700; }
    .sp-spec-tag.prime  { background:#fff4e0; color:#C7511F; font-weight:700; }
    .sp-spec-tag.free   { background:#F0FFF4; color:#007600; }
    .sp-spec-tag.low    { background:#FFF0F0; color:#CC0C39; font-weight:700; }

    /* Actions */
    .sp-card-actions { display:flex; gap:6px; margin-top:8px; }
    .sp-add-btn { flex:1; display:flex; align-items:center; justify-content:center; gap:5px; background:#FFD814; border:1px solid #FCD200; border-radius:20px; padding:8px; font-size:12px; font-weight:700; color:#131921; cursor:pointer; text-decoration:none; transition:background .12s; }
    .sp-add-btn:hover { background:#F7CA00; color:#131921; }
    .sp-save-btn { width:36px; flex-shrink:0; display:flex; align-items:center; justify-content:center; background:#fff; border:1px solid #d5d9d9; border-radius:20px; cursor:pointer; color:#555; transition:all .12s; }
    .sp-save-btn:hover { border-color:#FF9900; color:#C7511F; background:#fff8ee; }

    /* ── Empty ───────────────────────────────────────── */
    .sp-empty { text-align:center; padding:60px 20px; background:#fff; border-radius:8px; border:1px solid #e3e6e6; }

    @media (max-width:760px) {
        .sp-wrap { flex-direction:column; }
        .sp-sidebar { width:100%; }
        .sp-grid { grid-template-columns:repeat(2,1fr); }
        .sp-hero-inner { flex-direction:column; }
        .sp-promos { grid-template-columns:repeat(2,1fr); }
    }
    @media (max-width:480px) {
        .sp-grid { grid-template-columns:1fr; }
        .sp-promos { grid-template-columns:1fr; }
    }
</style>
@endsection

@section('content')
@php
    /* ── Helpers ─────────────────────────────────── */
    $discounts   = [8,10,12,15,18,20,25,30,35,40,45];
    $badgeTypes  = ['pro','new','hot','deal','sale','pro','new'];
    $badgeLabels = ['pro'=>'Pro Choice','new'=>'New Arrival','hot'=>'Best Seller','deal'=>'Deal','sale'=>'Sale'];
    $ratings     = [3.8,4.0,4.2,4.4,4.5,4.6,4.7,4.8,4.9,5.0,4.1,4.3];
    $reviews     = [28,58,110,195,340,520,950,1280,85,175,290,420];
    $isFreeShip  = [true,false,true,true,false,true,true,false,true,false,true,false];
    $isPrime     = [true,true,false,true,true,false,true,false,true,true,false,true];
    $isPro       = [true,false,true,false,false,true,false,true,false,false,true,false];
    $isLowStock  = [false,false,true,false,true,false,false,true,false,false,true,false];
    $apparelSizes= ['XS','S','M','L','XL','XXL'];
    $shoeSizes   = ['6','7','8','9','10','11','12'];
    
    $activities  = [
        ['key'=>'all','label'=>'All Sports','icon'=>'🏆'],
        ['key'=>'running','label'=>'Running','icon'=>'🏃'],
        ['key'=>'fitness','label'=>'Fitness','icon'=>'💪'],
        ['key'=>'soccer','label'=>'Soccer','icon'=>'⚽'],
        ['key'=>'basketball','label'=>'Basketball','icon'=>'🏀'],
        ['key'=>'tennis','label'=>'Tennis','icon'=>'🎾'],
        ['key'=>'swimming','label'=>'Swimming','icon'=>'🏊'],
        ['key'=>'cycling','label'=>'Cycling','icon'=>'🚴'],
        ['key'=>'yoga','label'=>'Yoga','icon'=>'🧘'],
        ['key'=>'hiking','label'=>'Hiking','icon'=>'🥾'],
        ['key'=>'golf','label'=>'Golf','icon'=>'⛳'],
        ['key'=>'outdoor','label'=>'Outdoor','icon'=>'🏕️'],
    ];
    
    $gearCategories = [
        ['icon'=>'👟','label'=>'Footwear','sub'=>'Shoes'],
        ['icon'=>'👕','label'=>'Apparel','sub'=>'Clothing'],
        ['icon'=>'🎒','label'=>'Bags','sub'=>'Gear'],
        ['icon'=>'⌚','label'=>'Watches','sub'=>'Tech'],
        ['icon'=>'🧤','label'=>'Gloves','sub'=>'Accessories'],
        ['icon'=>'🧢','label'=>'Headwear','sub'=>'Caps'],
        ['icon'=>'🥤','label'=>'Bottles','sub'=>'Hydration'],
        ['icon'=>'🏋️','label'=>'Equipment','sub'=>'Training'],
    ];
    
    $sportsBrands = ['Nike','Adidas','Under Armour','Puma','New Balance','Asics','Reebok','Fila','Skechers','Champion'];
    $athletes = [
        ['emoji'=>'🏃','name'=>'Bolt','sport'=>'Track'],
        ['emoji'=>'⚽','name'=>'Ronaldo','sport'=>'Soccer'],
        ['emoji'=>'🏀','name'=>'Jordan','sport'=>'Basketball'],
        ['emoji'=>'🎾','name'=>'Williams','sport'=>'Tennis'],
        ['emoji'=>'🏊','name'=>'Phelps','sport'=>'Swimming'],
        ['emoji'=>'🚴','name'=>'Froome','sport'=>'Cycling'],
    ];

    function spDisc($id,$arr){ return $arr[$id % count($arr)]; }
    function spStars($r){
        $f=floor($r);$h=($r-$f)>=0.5?1:0;$e=5-$f-$h;$o='';
        for($i=0;$i<$f;$i++)  $o.='<svg width="11" height="11" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        if($h) $o.='<svg width="11" height="11" viewBox="0 0 24 24" fill="#ddd" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        for($i=0;$i<$e;$i++)  $o.='<svg width="11" height="11" viewBox="0 0 24 24" fill="#ddd" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        return $o;
    }

    $activeActivity = request('activity','all');
    $activeCat      = request('category');
    $activeBrand    = request('brand');
    $activeSort     = request('sort','featured');
    $activeGear     = request('gear');
@endphp

<div class="sp-page">

{{-- Hero --}}
<div class="sp-hero">
    <div class="sp-hero-inner">
        <div class="sp-hero-left">
            <div class="sp-hero-eyebrow">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>
                Fitness & Sports Gear
            </div>
            <h1>Sports &amp; <span>Outdoors</span></h1>
            <p>Find the best gear for your active lifestyle — running, fitness, team sports, outdoor adventures, and professional equipment.</p>
            <div class="sp-hero-btns">
                <a href="#sp-listings" class="sp-hero-btn primary">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Shop All Sports
                </a>
                <a href="{{ route('sports', ['activity'=>'fitness']) }}" class="sp-hero-btn secondary">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6.5 6.5h11M6.5 17.5h11M6 12h12"/><circle cx="12" cy="12" r="3"/></svg>
                    Fitness Gear
                </a>
            </div>
        </div>
        <div class="sp-hero-stats">
            <div class="sp-stat">
                <div class="sp-stat-num">{{ $products->count() }}+</div>
                <div class="sp-stat-label">Products</div>
            </div>
            <div class="sp-stat">
                <div class="sp-stat-num">{{ count($activities)-1 }}</div>
                <div class="sp-stat-label">Activities</div>
            </div>
            <div class="sp-stat">
                <div class="sp-stat-num">45%</div>
                <div class="sp-stat-label">Max Off</div>
            </div>
            <div class="sp-stat">
                <div class="sp-stat-num">FREE</div>
                <div class="sp-stat-label">Shipping</div>
            </div>
        </div>
    </div>
</div>

{{-- Activity ticker --}}
<div class="sp-ticker">
    <div class="sp-ticker-inner">
        <div class="sp-ticker-label">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="#FFD814" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            Live Active:
        </div>
        <div class="sp-ticker-outer">
            <div class="sp-ticker-track" id="sp-ticker-track">
                @foreach(['Running Shoes Sale 🏃','Yoga Mats 30% Off 🧘','Soccer Gear In Stock ⚽','New Tennis Rackets 🎾','Cycling Essentials 🚴','Hiking Boots New 🥾','Pro Basketball Shoes 🏀','Swimwear Collection 🏊'] as $t)
                <span class="sp-ticker-item">{{ $t }}</span>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Activity tabs --}}
<div class="sp-activity-bar">
    <div class="sp-activity-inner">
        @foreach($activities as $act)
        <a href="{{ route('sports', array_merge(request()->except('activity'),['activity'=>$act['key']])) }}" class="sp-activity-tab {{ $activeActivity==$act['key'] ? 'active' : '' }}">
            {{ $act['icon'] }} {{ $act['label'] }}
            @if($act['key']=='all') <span class="sp-activity-count">{{ $products->count() }}</span> @endif
        </a>
        @endforeach
    </div>
</div>

{{-- Gear category chips --}}
<div class="sp-cats-bar">
    <div class="sp-cats-inner">
        <a href="{{ route('sports', request()->except('gear')) }}" class="sp-cat-chip {{ !$activeGear ? 'active' : '' }}">
            <span class="sp-cat-chip-icon">🏆</span>
            <span class="sp-cat-chip-label">All Gear</span>
        </a>
        @foreach($gearCategories as $gear)
        <a href="{{ route('sports', array_merge(request()->except('gear'),['gear'=>strtolower($gear['label'])])) }}" class="sp-cat-chip {{ $activeGear==strtolower($gear['label']) ? 'active' : '' }}">
            <span class="sp-cat-chip-icon">{{ $gear['icon'] }}</span>
            <span class="sp-cat-chip-label">{{ $gear['label'] }}</span>
        </a>
        @endforeach
    </div>
</div>

{{-- Brands bar --}}
<div class="sp-brands-bar">
    <div class="sp-brands-inner">
        <span class="sp-brands-label">Top Brands:</span>
        <a href="{{ route('sports') }}" class="sp-brand-pill {{ !$activeBrand ? 'active' : '' }}">All</a>
        @foreach($sportsBrands as $b)
        <a href="{{ route('sports', ['brand_name'=>$b]) }}" class="sp-brand-pill {{ request('brand_name')==$b ? 'active' : '' }}">{{ $b }}</a>
        @endforeach
        @foreach($brands->take(4) as $brand)
        <a href="{{ route('sports', array_merge(request()->except('brand'),['brand'=>$brand->id])) }}" class="sp-brand-pill {{ $activeBrand==$brand->id ? 'active' : '' }}">{{ $brand->name }}</a>
        @endforeach
    </div>
</div>

{{-- Breadcrumb --}}
<div style="background:#fff;border-bottom:1px solid #e3e6e6;">
    <div class="sp-breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span> › </span>
        <span style="color:#0F1111;">Sports & Outdoors</span>
        @if($activeActivity && $activeActivity!='all')<span> › </span><span style="color:#0F1111;text-transform:capitalize;">{{ $activeActivity }}</span>@endif
    </div>
</div>

{{-- Body --}}
<div class="sp-wrap">

    {{-- SIDEBAR --}}
    <div class="sp-sidebar">

        {{-- Activity --}}
        <div class="sp-sb-box">
            <div class="sp-sb-head">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>
                Activity
            </div>
            <div class="sp-sb-body">
                @foreach($activities as $act)
                <a href="{{ route('sports', array_merge(request()->except('activity'),['activity'=>$act['key']])) }}" class="sp-sb-item {{ $activeActivity==$act['key'] ? 'active' : '' }}">
                    <input type="radio" {{ $activeActivity==$act['key'] ? 'checked' : '' }} readonly /> {{ $act['icon'] }} {{ $act['label'] }}
                    @if($act['key']!='all')<span class="sp-sb-item-count">{{ rand(5,40) }}</span>@endif
                </a>
                @endforeach
            </div>
        </div>

        {{-- Gear Category --}}
        <div class="sp-sb-box">
            <div class="sp-sb-head">Gear Category</div>
            <div class="sp-sb-body">
                <a href="{{ route('sports', request()->except('gear')) }}" class="sp-sb-item {{ !$activeGear ? 'active' : '' }}">
                    <input type="radio" {{ !$activeGear ? 'checked' : '' }} readonly /> 🏆 All Gear
                </a>
                @foreach($gearCategories as $gear)
                <a href="{{ route('sports', array_merge(request()->except('gear'),['gear'=>strtolower($gear['label'])])) }}" class="sp-sb-item {{ $activeGear==strtolower($gear['label']) ? 'active' : '' }}">
                    <input type="radio" {{ $activeGear==strtolower($gear['label']) ? 'checked' : '' }} readonly />
                    {{ $gear['icon'] }} {{ $gear['label'] }}
                    <span class="sp-sb-item-count">{{ rand(3,35) }}</span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Brand --}}
        @if($brands->isNotEmpty())
        <div class="sp-sb-box">
            <div class="sp-sb-head">Brand</div>
            <div class="sp-sb-body">
                <a href="{{ route('sports', request()->except('brand')) }}" class="sp-sb-item {{ !$activeBrand ? 'active' : '' }}">
                    <input type="radio" {{ !$activeBrand ? 'checked' : '' }} readonly /> All Brands
                </a>
                @foreach($brands->take(10) as $brand)
                <a href="{{ route('sports', array_merge(request()->except('brand'),['brand'=>$brand->id])) }}" class="sp-sb-item {{ $activeBrand==$brand->id ? 'active' : '' }}">
                    <input type="radio" {{ $activeBrand==$brand->id ? 'checked' : '' }} readonly /> {{ $brand->name }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Size --}}
        <div class="sp-sb-box">
            <div class="sp-sb-head">Apparel Size</div>
            <div class="sp-size-grid">
                @foreach($apparelSizes as $sz)
                <button class="sp-size-btn {{ request('size')==$sz ? 'active' : '' }}" onclick="spSetSize('{{ $sz }}')">{{ $sz }}</button>
                @endforeach
            </div>
        </div>

        {{-- Shoe Size --}}
        <div class="sp-sb-box">
            <div class="sp-sb-head">Shoe Size</div>
            <div class="sp-size-grid">
                @foreach($shoeSizes as $sz)
                <button class="sp-size-btn {{ request('shoe_size')==$sz ? 'active' : '' }}" onclick="spSetShoeSize('{{ $sz }}')">{{ $sz }}</button>
                @endforeach
            </div>
        </div>

        {{-- Discount --}}
        <div class="sp-sb-box">
            <div class="sp-sb-head">Discount</div>
            <div class="sp-sb-body">
                @foreach(['10'=>'10% or more','20'=>'20% or more','30'=>'30% or more','40'=>'40% or more'] as $v=>$lbl)
                <a href="{{ route('sports', array_merge(request()->except('min_disc'),['min_disc'=>$v])) }}" class="sp-sb-item {{ request('min_disc')==$v ? 'active' : '' }}">
                    <input type="radio" {{ request('min_disc')==$v ? 'checked' : '' }} readonly /> {{ $lbl }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Price --}}
        <div class="sp-sb-box">
            <div class="sp-sb-head">Price Range</div>
            <div class="sp-price-inputs">
                <input type="number" placeholder="Min" value="{{ request('min_price') }}" id="sp-min" />
                <span>—</span>
                <input type="number" placeholder="Max" value="{{ request('max_price') }}" id="sp-max" />
                <button class="sp-price-go" onclick="spApplyPrice()">Go</button>
            </div>
        </div>

    </div>

    {{-- MAIN --}}
    <div class="sp-main" id="sp-listings">

        {{-- Featured athletes --}}
        <div class="sp-athletes">
            <h3><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg> Shop by <span>Athlete</span></h3>
            <div class="sp-athletes-row">
                @foreach($athletes as $ath)
                <div class="sp-athlete-card" onclick="window.location='{{ route('sports', ['athlete'=>strtolower($ath['name'])]) }}'">
                    <div class="sp-athlete-img">{{ $ath['emoji'] }}</div>
                    <div class="sp-athlete-name">{{ $ath['name'] }}</div>
                    <div class="sp-athlete-sport">{{ $ath['sport'] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Promo banners --}}
        <div class="sp-promos">
            <a href="{{ route('sports', ['activity'=>'running']) }}" class="sp-promo sp-p1">
                <div class="sp-promo-icon">🏃</div>
                <h4>Running</h4>
                <p>Shoes, apparel & accessories</p>
                <span>Shop Running →</span>
            </a>
            <a href="{{ route('sports', ['activity'=>'fitness']) }}" class="sp-promo sp-p2">
                <div class="sp-promo-icon">💪</div>
                <h4>Fitness</h4>
                <p>Equipment & training gear</p>
                <span>Shop Fitness →</span>
            </a>
            <a href="{{ route('sports', ['activity'=>'outdoor']) }}" class="sp-promo sp-p3">
                <div class="sp-promo-icon">🏕️</div>
                <h4>Outdoor</h4>
                <p>Hiking, camping & adventure</p>
                <span>Explore →</span>
            </a>
            <a href="{{ route('sports', ['gear'=>'footwear']) }}" class="sp-promo sp-p4">
                <div class="sp-promo-icon">👟</div>
                <h4>Footwear</h4>
                <p>All sports shoes</p>
                <span>Browse →</span>
            </a>
        </div>

        {{-- Topbar --}}
        <div class="sp-topbar">
            <div class="sp-topbar-left"><b>{{ $products->count() }}</b> sports products found</div>
            <div class="sp-topbar-right">
                Sort by:
                <select onchange="window.location.href=this.value">
                    <option value="{{ route('sports', array_merge(request()->all(),['sort'=>'featured'])) }}"    {{ $activeSort=='featured'   ? 'selected':'' }}>Featured</option>
                    <option value="{{ route('sports', array_merge(request()->all(),['sort'=>'newest'])) }}"     {{ $activeSort=='newest'     ? 'selected':'' }}>New Arrivals</option>
                    <option value="{{ route('sports', array_merge(request()->all(),['sort'=>'price_asc'])) }}"  {{ $activeSort=='price_asc'  ? 'selected':'' }}>Price: Low to High</option>
                    <option value="{{ route('sports', array_merge(request()->all(),['sort'=>'price_desc'])) }}" {{ $activeSort=='price_desc' ? 'selected':'' }}>Price: High to Low</option>
                    <option value="{{ route('sports', array_merge(request()->all(),['sort'=>'rating'])) }}"     {{ $activeSort=='rating'     ? 'selected':'' }}>Best Reviewed</option>
                    <option value="{{ route('sports', array_merge(request()->all(),['sort'=>'discount'])) }}"   {{ $activeSort=='discount'   ? 'selected':'' }}>Biggest Discount</option>
                </select>
            </div>
        </div>

        {{-- Grid --}}
        @if($products->isEmpty())
        <div class="sp-empty">
            <div style="font-size:64px;margin-bottom:14px;">🏆</div>
            <h3 style="font-size:18px;font-weight:700;margin-bottom:8px;">No sports products found</h3>
            <p style="font-size:14px;color:#555;margin-bottom:14px;">Try adjusting your filters or browse all activities.</p>
            <a href="{{ route('sports') }}" style="color:#007185;font-size:13px;">Clear all filters</a>
        </div>
        @else
        <div class="sp-grid" id="sp-grid">
            @foreach($products as $product)
            @php
                $disc      = spDisc($product->id, $discounts);
                $saveAmt   = round($product->price * $disc / 100, 2);
                $afterP    = round($product->price - $saveAmt, 2);
                $badgeType = $badgeTypes[$product->id % count($badgeTypes)];
                $badgeText = $badgeLabels[$badgeType];
                $pRating   = $ratings[$product->id % count($ratings)];
                $pReviews  = $reviews[$product->id % count($reviews)];
                $freeShip  = $isFreeShip[$product->id % count($isFreeShip)];
                $prime     = $isPrime[$product->id % count($isPrime)];
                $pro       = $isPro[$product->id % count($isPro)];
                $lowStock  = $isLowStock[$product->id % count($isLowStock)];
                $activityIdx = $product->id % (count($activities)-1) + 1;
                $activity    = $activities[$activityIdx];
                $gearIdx     = $product->id % count($gearCategories);
                $gear        = $gearCategories[$gearIdx];
                $brandName   = $product->brand ? $product->brand->name : ($sportsBrands[$product->id % count($sportsBrands)]);
                $imgs        = collect($product->images ?? [])->filter()->values();
                $thumb       = $imgs->first() ? \Illuminate\Support\Facades\Storage::url($imgs->first()) : null;
            @endphp
            <div class="sp-card" onclick="window.location='{{ route('products.show', $product->slug) }}'">

                <div class="sp-disc-badge">-{{ $disc }}%</div>
                <div class="sp-type-badge {{ $badgeType }}">{{ $badgeText }}</div>

                <button class="sp-wish-btn" onclick="event.stopPropagation(); spToggleWish(this)" title="Save">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#CC0C39" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                </button>

                <div class="sp-card-img">
                    @if($thumb)
                        <img src="{{ $thumb }}" alt="{{ $product->name }}" loading="lazy" />
                    @else
                        <div style="font-size:52px;opacity:.25;">{{ $activity['icon'] }}</div>
                    @endif
                    <div class="sp-quick-view">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Quick View
                    </div>
                </div>

                <div class="sp-card-body">
                    <div class="sp-card-sport">{{ $activity['icon'] }} {{ $activity['label'] }} · {{ $gear['label'] }}</div>
                    <div class="sp-card-brand">{{ $brandName }}</div>
                    <div class="sp-card-name">{{ $product->name }}</div>

                    <div class="sp-stars">
                        {!! spStars($pRating) !!}
                        <span>{{ $pRating }} ({{ number_format($pReviews) }})</span>
                    </div>

                    <div class="sp-price-row">
                        <span class="sp-price"><sup>$</sup>{{ number_format($afterP, 2) }}</span>
                        <span class="sp-was">Was: <s>${{ number_format($product->price, 2) }}</s></span>
                    </div>
                    <span class="sp-save-pill">Save ${{ number_format($saveAmt, 2) }} ({{ $disc }}%)</span>

                    <div class="sp-spec-tags">
                        @if($pro)      <span class="sp-spec-tag pro">⭐ Pro Choice</span> @endif
                        @if($prime)    <span class="sp-spec-tag prime">Prime</span> @endif
                        @if($freeShip)  <span class="sp-spec-tag free">Free Ship</span> @endif
                        @if($lowStock) <span class="sp-spec-tag low">Low Stock</span> @endif
                    </div>

                    <div class="sp-card-actions">
                        <a href="{{ route('products.show', $product->slug) }}" class="sp-add-btn" onclick="event.stopPropagation();">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            Add to Cart
                        </a>
                        <button class="sp-save-btn" onclick="event.stopPropagation(); spToggleWish(this)" title="Save to list">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @endif
    </div>
</div>
</div>

<script>
function spToggleWish(btn) {
    btn.classList.toggle('saved');
    const svg = btn.querySelector('svg');
    const saved = btn.classList.contains('saved');
    svg.setAttribute('fill', saved ? '#CC0C39' : 'none');
    spToast(saved ? '❤️ Saved to Wish List' : 'Removed from Wish List');
}

function spSetSize(sz) {
    const url = new URL(window.location.href);
    url.searchParams.set('size', sz);
    window.location.href = url.toString();
}

function spSetShoeSize(sz) {
    const url = new URL(window.location.href);
    url.searchParams.set('shoe_size', sz);
    window.location.href = url.toString();
}

function spApplyPrice() {
    const min = document.getElementById('sp-min').value;
    const max = document.getElementById('sp-max').value;
    const url = new URL(window.location.href);
    if (min) url.searchParams.set('min_price', min); else url.searchParams.delete('min_price');
    if (max) url.searchParams.set('max_price', max); else url.searchParams.delete('max_price');
    window.location.href = url.toString();
}

function spToast(msg) {
    let t = document.getElementById('spToast');
    if (!t) {
        t = document.createElement('div');
        t.id = 'spToast';
        t.style.cssText = 'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#131921;color:#FF9900;padding:11px 22px;border-radius:6px;font-size:13px;z-index:99999;box-shadow:0 4px 16px rgba(0,0,0,.3);transition:opacity .3s;white-space:nowrap;font-weight:600;';
        document.body.appendChild(t);
    }
    t.textContent = msg;
    t.style.opacity = '1';
    clearTimeout(t._t);
    t._t = setTimeout(() => { t.style.opacity = '0'; }, 2500);
}

/* Ticker animation */
(function(){
    const track = document.getElementById('sp-ticker-track');
    if (!track) return;
    let x = 0;
    setInterval(() => {
        x -= 1;
        if (x < -track.scrollWidth / 2) x = 0;
        track.style.transform = 'translateX(' + x + 'px)';
    }, 30);
})();
</script>
@endsection
