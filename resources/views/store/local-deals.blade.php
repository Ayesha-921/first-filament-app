@extends('store.layout')
@section('title', 'Local Deals — Deals Near You')

@section('head')
<style>
    /* ── Page ───────────────────────────────────────── */
    .ld-page { background: #EAEDED; min-height: 80vh; }

    /* ── Hero ───────────────────────────────────────── */
    .ld-hero { background: linear-gradient(115deg,#131921 0%,#1a2a1a 60%,#0d1f0d 100%); padding: 28px 18px; position: relative; overflow: hidden; }
    .ld-hero::before { content:''; position:absolute; right:-80px; top:-80px; width:340px; height:340px; background:rgba(255,153,0,.06); border-radius:50%; pointer-events:none; }
    .ld-hero::after  { content:''; position:absolute; left:30%; bottom:-60px; width:200px; height:200px; background:rgba(255,153,0,.04); border-radius:50%; pointer-events:none; }
    .ld-hero-inner { max-width:1340px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; gap:20px; flex-wrap:wrap; position:relative; z-index:1; }

    .ld-hero-eyebrow { display:inline-flex; align-items:center; gap:6px; background:rgba(255,153,0,.15); border:1px solid rgba(255,153,0,.4); border-radius:20px; padding:4px 14px; font-size:12px; color:#FF9900; font-weight:700; letter-spacing:.5px; margin-bottom:10px; text-transform:uppercase; }
    .ld-hero-left h1 { font-size:30px; font-weight:900; color:#fff; margin:0 0 8px; line-height:1.15; }
    .ld-hero-left h1 span { color:#FF9900; }
    .ld-hero-left p { font-size:13px; color:#adbac7; margin:0 0 16px; max-width:460px; line-height:1.6; }

    /* Location input in hero */
    .ld-loc-bar { display:flex; gap:0; max-width:420px; border-radius:6px; overflow:hidden; border:2px solid #FF9900; }
    .ld-loc-bar input { flex:1; padding:10px 14px; font-size:13px; border:none; outline:none; color:#0F1111; background:#fff; }
    .ld-loc-bar-btn { background:#FF9900; border:none; padding:0 18px; cursor:pointer; display:flex; align-items:center; gap:6px; font-size:13px; font-weight:700; color:#131921; white-space:nowrap; transition:background .12s; }
    .ld-loc-bar-btn:hover { background:#e88b00; }

    .ld-hero-stats { display:flex; gap:14px; flex-wrap:wrap; }
    .ld-stat { text-align:center; background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.12); border-radius:10px; padding:14px 18px; min-width:80px; }
    .ld-stat-num { font-size:24px; font-weight:900; color:#FF9900; line-height:1; }
    .ld-stat-label { font-size:11px; color:#adbac7; text-transform:uppercase; letter-spacing:.5px; margin-top:4px; }

    /* ── Location banner ─────────────────────────────── */
    .ld-loc-banner { background:#fff; border-bottom:1px solid #e3e6e6; }
    .ld-loc-banner-inner { max-width:1340px; margin:0 auto; padding:10px 18px; display:flex; align-items:center; gap:14px; flex-wrap:wrap; }
    .ld-loc-pill { display:inline-flex; align-items:center; gap:6px; background:#fff4e0; border:1px solid #FFD580; border-radius:20px; padding:5px 14px; font-size:12px; font-weight:600; color:#C7511F; cursor:pointer; transition:all .12s; }
    .ld-loc-pill:hover { background:#FFD814; border-color:#FCD200; color:#131921; }
    .ld-loc-pill svg { color:#FF9900; }
    .ld-radius-btns { display:flex; gap:6px; flex-wrap:wrap; }
    .ld-radius-btn { border:1px solid #d5d9d9; background:#fff; border-radius:20px; padding:5px 14px; font-size:12px; font-weight:500; color:#555; cursor:pointer; transition:all .12s; }
    .ld-radius-btn.active, .ld-radius-btn:hover { background:#131921; color:#fff; border-color:#131921; }
    .ld-loc-banner-right { margin-left:auto; font-size:12px; color:#555; display:flex; align-items:center; gap:6px; }
    .ld-loc-banner-right svg { color:#FF9900; }

    /* ── Breadcrumb ─────────────────────────────────── */
    .ld-breadcrumb { max-width:1340px; margin:0 auto; padding:10px 18px; font-size:13px; color:#555; }
    .ld-breadcrumb a { color:#007185; }
    .ld-breadcrumb a:hover { color:#C7511F; text-decoration:underline; }

    /* ── Filter tabs ─────────────────────────────────── */
    .ld-tabs-wrap { background:#fff; border-bottom:2px solid #e3e6e6; }
    .ld-tabs { max-width:1340px; margin:0 auto; padding:0 18px; display:flex; overflow-x:auto; scrollbar-width:none; }
    .ld-tabs::-webkit-scrollbar { display:none; }
    .ld-tab { display:inline-flex; align-items:center; gap:6px; padding:13px 18px; font-size:13px; font-weight:500; color:#555; white-space:nowrap; border-bottom:3px solid transparent; cursor:pointer; text-decoration:none; transition:color .12s, border-color .12s; flex-shrink:0; }
    .ld-tab:hover { color:#C7511F; border-bottom-color:#FF9900; }
    .ld-tab.active { color:#C7511F; border-bottom-color:#FF9900; font-weight:700; }
    .ld-tab-badge { background:#FF9900; color:#131921; font-size:10px; font-weight:800; border-radius:99px; padding:1px 7px; }

    /* ── Layout ──────────────────────────────────────── */
    .ld-wrap { max-width:1340px; margin:0 auto; padding:20px 18px 50px; display:flex; gap:20px; align-items:flex-start; }

    /* ── Sidebar ─────────────────────────────────────── */
    .ld-sidebar { width:210px; flex-shrink:0; }
    .ld-sb-box { background:#fff; border:1px solid #e3e6e6; border-radius:8px; overflow:hidden; margin-bottom:14px; }
    .ld-sb-head { font-size:14px; font-weight:700; color:#0F1111; padding:12px 16px 10px; border-bottom:1px solid #f0f2f2; background:#f7f8f8; display:flex; align-items:center; gap:7px; }
    .ld-sb-body { padding:8px 0; }
    .ld-sb-item { display:flex; align-items:center; gap:9px; padding:8px 16px; font-size:13px; color:#0F1111; cursor:pointer; text-decoration:none; transition:background .1s; border-left:3px solid transparent; }
    .ld-sb-item:hover { background:#fff8ee; border-left-color:#FF9900; color:#C7511F; }
    .ld-sb-item.active { background:#fff4e0; border-left-color:#FF9900; font-weight:700; color:#C7511F; }
    .ld-sb-item input[type=radio] { accent-color:#FF9900; width:14px; height:14px; flex-shrink:0; }

    /* Map preview box */
    .ld-map-box { background:#fff; border:1px solid #e3e6e6; border-radius:8px; overflow:hidden; margin-bottom:14px; }
    .ld-map-preview { background:linear-gradient(135deg,#e8f4e8 0%,#d4edda 50%,#c3e6cb 100%); height:160px; position:relative; display:flex; align-items:center; justify-content:center; flex-direction:column; gap:8px; cursor:pointer; }
    .ld-map-preview::before { content:''; position:absolute; inset:0; background-image: repeating-linear-gradient(0deg,rgba(0,0,0,.04) 0px,rgba(0,0,0,.04) 1px,transparent 1px,transparent 28px), repeating-linear-gradient(90deg,rgba(0,0,0,.04) 0px,rgba(0,0,0,.04) 1px,transparent 1px,transparent 28px); }
    .ld-map-pin { width:36px; height:36px; background:#FF9900; border-radius:50% 50% 50% 0; transform:rotate(-45deg); display:flex; align-items:center; justify-content:center; box-shadow:0 3px 10px rgba(0,0,0,.3); position:relative; z-index:1; }
    .ld-map-pin svg { transform:rotate(45deg); color:#fff; }
    .ld-map-preview p { font-size:12px; color:#0F1111; font-weight:600; position:relative; z-index:1; margin:0; }
    .ld-map-open-btn { width:100%; background:#131921; color:#FF9900; border:none; padding:10px; font-size:12px; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px; transition:background .12s; }
    .ld-map-open-btn:hover { background:#1a2a3a; }

    /* Price range */
    .ld-price-inputs { display:flex; gap:6px; align-items:center; padding:10px 16px; }
    .ld-price-inputs input { width:60px; border:1px solid #d5d9d9; border-radius:4px; padding:5px 6px; font-size:12px; outline:none; }
    .ld-price-inputs input:focus { border-color:#FF9900; box-shadow:0 0 0 2px rgba(255,153,0,.15); }
    .ld-price-inputs span { font-size:12px; color:#555; }
    .ld-price-go { background:#FF9900; color:#131921; border:none; border-radius:4px; padding:5px 10px; font-size:12px; font-weight:700; cursor:pointer; }

    /* ── Main ────────────────────────────────────────── */
    .ld-main { flex:1; min-width:0; }

    /* Info banner */
    .ld-info-banner { background:#fff8ee; border:1px solid #FFD580; border-radius:8px; padding:12px 16px; margin-bottom:16px; display:flex; align-items:flex-start; gap:10px; font-size:13px; color:#555; line-height:1.6; }
    .ld-info-banner svg { flex-shrink:0; margin-top:1px; color:#FF9900; }
    .ld-info-banner b { color:#C7511F; }

    /* Featured stores row */
    .ld-stores-section { background:#fff; border:1px solid #e3e6e6; border-radius:8px; padding:18px; margin-bottom:20px; }
    .ld-stores-section h3 { font-size:15px; font-weight:700; color:#0F1111; margin:0 0 4px; display:flex; align-items:center; gap:7px; border-bottom:2px solid #FF9900; padding-bottom:10px; }
    .ld-stores-row { display:flex; gap:10px; overflow-x:auto; scrollbar-width:none; padding:12px 0 4px; }
    .ld-stores-row::-webkit-scrollbar { display:none; }
    .ld-store-card { flex-shrink:0; background:#f7f8f8; border:1px solid #e3e6e6; border-radius:8px; padding:14px; min-width:140px; max-width:140px; text-align:center; cursor:pointer; transition:all .12s; text-decoration:none; }
    .ld-store-card:hover { border-color:#FF9900; background:#fff8ee; box-shadow:0 2px 10px rgba(255,153,0,.15); }
    .ld-store-icon { width:46px; height:46px; border-radius:10px; margin:0 auto 8px; display:flex; align-items:center; justify-content:center; font-size:22px; }
    .ld-store-name { font-size:12px; font-weight:700; color:#0F1111; margin-bottom:2px; }
    .ld-store-dist { font-size:11px; color:#007185; font-weight:600; }
    .ld-store-deals { font-size:11px; color:#C7511F; font-weight:600; margin-top:2px; }
    .ld-store-open { display:inline-block; font-size:10px; font-weight:700; border-radius:99px; padding:2px 8px; margin-top:4px; }
    .ld-store-open.open { background:#F0FFF4; color:#007600; }
    .ld-store-open.closed { background:#FFF0F0; color:#CC0C39; }

    /* Topbar */
    .ld-topbar { display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; flex-wrap:wrap; gap:10px; }
    .ld-topbar-left { font-size:14px; color:#555; }
    .ld-topbar-left b { color:#0F1111; }
    .ld-topbar-right { display:flex; align-items:center; gap:8px; font-size:13px; color:#555; }
    .ld-topbar-right select { border:1px solid #d5d9d9; border-radius:6px; padding:6px 10px; font-size:13px; background:#fff; cursor:pointer; outline:none; }

    /* ── Deal cards grid ─────────────────────────────── */
    .ld-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:14px; }

    .ld-card { background:#fff; border:1px solid #e3e6e6; border-radius:8px; overflow:hidden; display:flex; flex-direction:column; position:relative; transition:box-shadow .15s, border-color .15s; cursor:pointer; }
    .ld-card:hover { box-shadow:0 4px 20px rgba(0,0,0,.12); border-color:#FF9900; }

    /* Store ribbon */
    .ld-store-ribbon { position:absolute; top:0; left:0; right:0; background:linear-gradient(90deg,#131921,#1a2a1a); color:#FF9900; font-size:10px; font-weight:700; text-align:center; padding:3px 8px; z-index:5; letter-spacing:.5px; display:flex; align-items:center; justify-content:center; gap:5px; white-space:nowrap; overflow:hidden; }

    /* Discount badge */
    .ld-disc-badge { position:absolute; top:26px; left:8px; background:#CC0C39; color:#fff; font-size:12px; font-weight:900; border-radius:4px; padding:3px 8px; z-index:4; }

    /* Deal type badge */
    .ld-deal-type { position:absolute; top:26px; right:8px; border-radius:4px; padding:3px 8px; font-size:10px; font-weight:800; z-index:4; }
    .ld-deal-type.instore { background:#131921; color:#FF9900; }
    .ld-deal-type.online { background:#007185; color:#fff; }
    .ld-deal-type.both { background:#FF9900; color:#131921; }

    /* Image */
    .ld-card-img { background:#f7f8f8; aspect-ratio:1/1; display:flex; align-items:center; justify-content:center; overflow:hidden; padding-top:20px; }
    .ld-card-img img { max-width:78%; max-height:78%; object-fit:contain; transition:transform .2s; }
    .ld-card:hover .ld-card-img img { transform:scale(1.04); }

    /* Distance overlay */
    .ld-dist-overlay { position:absolute; bottom:8px; left:8px; background:rgba(0,0,0,.65); color:#fff; font-size:10px; font-weight:700; border-radius:4px; padding:2px 8px; z-index:4; display:flex; align-items:center; gap:4px; backdrop-filter:blur(2px); }
    .ld-dist-overlay svg { color:#FF9900; }

    /* In-store availability bar */
    .ld-avail-bar { position:absolute; bottom:0; left:0; right:0; background:rgba(0,118,0,.85); color:#fff; font-size:10px; font-weight:700; text-align:center; padding:3px; z-index:4; display:flex; align-items:center; justify-content:center; gap:4px; backdrop-filter:blur(2px); }

    /* Body */
    .ld-card-body { padding:12px 12px 14px; flex:1; display:flex; flex-direction:column; gap:5px; }

    /* Store meta */
    .ld-card-store { display:flex; align-items:center; gap:6px; font-size:11px; }
    .ld-card-store-dot { width:8px; height:8px; border-radius:50%; background:#007600; flex-shrink:0; }
    .ld-card-store-name { color:#C7511F; font-weight:700; }
    .ld-card-store-dist { color:#007185; margin-left:auto; font-size:10px; font-weight:600; }

    .ld-card-name { font-size:13px; color:#0F1111; line-height:1.4; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; }

    /* Stars */
    .ld-stars { display:flex; align-items:center; gap:2px; }
    .ld-stars span { font-size:11px; color:#555; margin-left:3px; }

    /* Price */
    .ld-price-row { display:flex; align-items:baseline; gap:6px; margin-top:4px; flex-wrap:wrap; }
    .ld-price-now { font-size:20px; font-weight:900; color:#B12704; }
    .ld-price-now sup { font-size:12px; vertical-align:super; }
    .ld-price-was { font-size:12px; color:#888; }
    .ld-price-was s { color:#aaa; }
    .ld-save-pill { font-size:11px; background:#fff4e0; color:#C7511F; border:1px solid #FFD580; border-radius:4px; padding:2px 6px; font-weight:700; display:inline-block; }

    /* Hours */
    .ld-hours { display:flex; align-items:center; gap:5px; font-size:11px; background:#f7f8f8; border-radius:4px; padding:4px 8px; }
    .ld-hours-dot { width:7px; height:7px; border-radius:50%; flex-shrink:0; }

    /* Tags */
    .ld-tags { display:flex; gap:5px; flex-wrap:wrap; }
    .ld-tag { font-size:10px; border-radius:4px; padding:2px 7px; font-weight:500; }
    .ld-tag.pickup   { background:#F0FFF4; color:#007600; }
    .ld-tag.delivery { background:#fff4e0; color:#C7511F; }
    .ld-tag.exclusive{ background:#FFF0F0; color:#CC0C39; font-weight:700; }
    .ld-tag.limited  { background:#fff4e0; color:#C7511F; font-weight:700; }
    .ld-tag.cat      { background:#f0f2f2; color:#555; }

    /* Actions */
    .ld-card-actions { display:flex; gap:6px; margin-top:8px; }
    .ld-buy-btn { flex:1; display:flex; align-items:center; justify-content:center; gap:5px; background:#FFD814; border:1px solid #FCD200; border-radius:20px; padding:8px; font-size:12px; font-weight:700; color:#131921; cursor:pointer; text-decoration:none; transition:background .12s; }
    .ld-buy-btn:hover { background:#F7CA00; color:#131921; }
    .ld-dir-btn { width:36px; flex-shrink:0; display:flex; align-items:center; justify-content:center; background:#fff; border:1px solid #d5d9d9; border-radius:20px; cursor:pointer; color:#555; transition:all .12s; }
    .ld-dir-btn:hover { border-color:#FF9900; color:#C7511F; background:#fff8ee; }

    /* ── Neighborhood deals sections ─────────────────── */
    .ld-neighborhood { margin-top:28px; }
    .ld-nbhd-head { display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; }
    .ld-nbhd-head h3 { font-size:16px; font-weight:700; color:#0F1111; margin:0; display:flex; align-items:center; gap:8px; border-left:4px solid #FF9900; padding-left:10px; }
    .ld-nbhd-head a { font-size:13px; color:#007185; text-decoration:none; }
    .ld-nbhd-head a:hover { color:#C7511F; text-decoration:underline; }

    /* ── Empty ───────────────────────────────────────── */
    .ld-empty { text-align:center; padding:60px 20px; background:#fff; border-radius:8px; border:1px solid #e3e6e6; }

    @media (max-width:760px) {
        .ld-wrap { flex-direction:column; }
        .ld-sidebar { width:100%; }
        .ld-grid { grid-template-columns:repeat(2,1fr); }
        .ld-hero-inner { flex-direction:column; }
    }
    @media (max-width:480px) {
        .ld-grid { grid-template-columns:1fr; }
    }
</style>
@endsection

@section('content')
@php
    /* ── Helpers ─────────────────────────────────── */
    $discounts   = [10,15,20,25,30,35,40,45,50,55,60];
    $storeNames  = ['TechZone','MegaMart','FreshMarket','CityElectronics','HomeWorld','SportsPro','FashionHub','GadgetGuru'];
    $storeEmojis = ['🖥️','🛒','🛍️','📱','🏠','⚽','👗','🎮'];
    $storeDists  = ['0.3 mi','0.6 mi','0.9 mi','1.2 mi','1.5 mi','2.1 mi','2.4 mi','3.0 mi'];
    $storeOpen   = [true,true,false,true,true,false,true,true];
    $dealTypes   = ['instore','online','both','instore','both','online','instore','both'];
    $dealLabels  = ['In-Store','Online','In-Store + Online'];
    $dealTypeMap = ['instore'=>'In-Store','online'=>'Online','both'=>'In-Store + Online'];
    $storeDeals  = [12,7,24,9,18,5,31,14];
    $storeHours  = ['9am–9pm','8am–10pm','7am–11pm','10am–8pm','9am–9pm','10am–7pm','10am–9pm','9am–10pm'];
    $ratings     = [3.9,4.1,4.3,4.5,4.6,4.7,4.8,4.2];
    $reviews     = [34,78,120,204,389,512,1024,87];
    $hasPickup   = [true,false,true,true,false,true,true,false];
    $hasDelivery = [false,true,true,false,true,false,true,true];
    $isExclusive = [false,true,false,false,true,false,false,true];
    $isLimited   = [true,false,false,true,false,true,false,false];
    $neighborhoods = ['Downtown','Westside','Eastside','Midtown'];

    function ldDisc($id,$arr){ return $arr[$id % count($arr)]; }
    function ldStars($r){
        $f=floor($r);$h=($r-$f)>=0.5?1:0;$e=5-$f-$h;$o='';
        for($i=0;$i<$f;$i++)  $o.='<svg width="11" height="11" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        if($h) $o.='<svg width="11" height="11" viewBox="0 0 24 24" fill="#ddd" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        for($i=0;$i<$e;$i++)  $o.='<svg width="11" height="11" viewBox="0 0 24 24" fill="#ddd" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        return $o;
    }

    $activeTab  = request('tab','all');
    $activeCat  = request('category');
    $activeBrand= request('brand');
    $activeSort = request('sort','distance');
    $activeRadius = request('radius','5');
@endphp

<div class="ld-page">

{{-- Hero --}}
<div class="ld-hero">
    <div class="ld-hero-inner">
        <div class="ld-hero-left">
            <div class="ld-hero-eyebrow">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                Near You
            </div>
            <h1><span>Local</span> Deals</h1>
            <p>Find exclusive deals from stores near you. Save in-store, pick up today, or get same-day delivery from local merchants.</p>
            <div class="ld-loc-bar">
                <input type="text" placeholder="Enter your zip code or city…" id="ld-zip-input" />
                <button class="ld-loc-bar-btn" onclick="ldDetectLocation()">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Find Deals
                </button>
            </div>
        </div>
        <div class="ld-hero-stats">
            <div class="ld-stat">
                <div class="ld-stat-num">{{ $products->count() }}+</div>
                <div class="ld-stat-label">Local Deals</div>
            </div>
            <div class="ld-stat">
                <div class="ld-stat-num">{{ min($products->count(), 8) }}</div>
                <div class="ld-stat-label">Stores Near You</div>
            </div>
            <div class="ld-stat">
                <div class="ld-stat-num">60%</div>
                <div class="ld-stat-label">Max Savings</div>
            </div>
            <div class="ld-stat">
                <div class="ld-stat-num">Same</div>
                <div class="ld-stat-label">Day Pickup</div>
            </div>
        </div>
    </div>
</div>

{{-- Location bar --}}
<div class="ld-loc-banner">
    <div class="ld-loc-banner-inner">
        <span style="font-size:13px;font-weight:600;color:#0F1111;">Search radius:</span>
        <div class="ld-radius-btns">
            @foreach(['1'=>'1 mi','2'=>'2 mi','5'=>'5 mi','10'=>'10 mi','25'=>'25 mi'] as $r=>$lbl)
            <button class="ld-radius-btn {{ $activeRadius==$r ? 'active' : '' }}" onclick="ldSetRadius('{{ $r }}')">{{ $lbl }}</button>
            @endforeach
        </div>
        <div class="ld-loc-pill" onclick="ldDetectLocation()">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            Use My Location
        </div>
        <div class="ld-loc-banner-right">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Showing deals within <b id="ld-radius-display" style="margin:0 3px;color:#C7511F;">{{ $activeRadius }} mi</b> of your location
        </div>
    </div>
</div>

{{-- Breadcrumb --}}
<div style="background:#fff;border-bottom:1px solid #e3e6e6;">
    <div class="ld-breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span> › </span>
        <span style="color:#0F1111;">Local Deals</span>
    </div>
</div>

{{-- Tabs --}}
<div class="ld-tabs-wrap">
    <div class="ld-tabs">
        <a href="{{ route('local-deals') }}" class="ld-tab {{ $activeTab=='all' ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            All Local Deals
            <span class="ld-tab-badge">{{ $products->count() }}</span>
        </a>
        <a href="{{ route('local-deals',['tab'=>'instore']) }}" class="ld-tab {{ $activeTab=='instore' ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
            In-Store Only
        </a>
        <a href="{{ route('local-deals',['tab'=>'pickup']) }}" class="ld-tab {{ $activeTab=='pickup' ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12H3l9-9 9 9h-2"/><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-7"/></svg>
            Curbside Pickup
        </a>
        <a href="{{ route('local-deals',['tab'=>'sameday']) }}" class="ld-tab {{ $activeTab=='sameday' ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Same-Day Delivery
        </a>
        <a href="{{ route('local-deals',['tab'=>'exclusive']) }}" class="ld-tab {{ $activeTab=='exclusive' ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            Local Exclusives
        </a>
        @foreach($categories->take(5) as $cat)
        <a href="{{ route('local-deals',['category'=>$cat->id]) }}" class="ld-tab {{ $activeCat==$cat->id ? 'active' : '' }}">
            {{ $cat->name }}
        </a>
        @endforeach
    </div>
</div>

{{-- Body --}}
<div class="ld-wrap">

    {{-- SIDEBAR --}}
    <div class="ld-sidebar">

        {{-- Map --}}
        <div class="ld-map-box">
            <div class="ld-map-preview" onclick="ldDetectLocation()">
                <div class="ld-map-pin">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <p>Your Location</p>
            </div>
            <button class="ld-map-open-btn">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                Open Full Map View
            </button>
        </div>

        {{-- Deal Type --}}
        <div class="ld-sb-box">
            <div class="ld-sb-head">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                Deal Type
            </div>
            <div class="ld-sb-body">
                @foreach(['all'=>'All Deals','instore'=>'In-Store Only','online'=>'Online Only','both'=>'In-Store + Online'] as $k=>$lbl)
                <a href="{{ route('local-deals', array_merge(request()->except('type'),['type'=>$k])) }}" class="ld-sb-item {{ (request('type','all'))==$k ? 'active' : '' }}">
                    <input type="radio" {{ (request('type','all'))==$k ? 'checked' : '' }} readonly /> {{ $lbl }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Category --}}
        @if($categories->isNotEmpty())
        <div class="ld-sb-box">
            <div class="ld-sb-head">Category</div>
            <div class="ld-sb-body">
                <a href="{{ route('local-deals', request()->except('category')) }}" class="ld-sb-item {{ !$activeCat ? 'active' : '' }}">
                    <input type="radio" {{ !$activeCat ? 'checked' : '' }} readonly /> All Categories
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('local-deals', array_merge(request()->except('category'),['category'=>$cat->id])) }}" class="ld-sb-item {{ $activeCat==$cat->id ? 'active' : '' }}">
                    <input type="radio" {{ $activeCat==$cat->id ? 'checked' : '' }} readonly /> {{ $cat->name }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Brand --}}
        @if($brands->isNotEmpty())
        <div class="ld-sb-box">
            <div class="ld-sb-head">Brand</div>
            <div class="ld-sb-body">
                <a href="{{ route('local-deals', request()->except('brand')) }}" class="ld-sb-item {{ !$activeBrand ? 'active' : '' }}">
                    <input type="radio" {{ !$activeBrand ? 'checked' : '' }} readonly /> All Brands
                </a>
                @foreach($brands->take(10) as $brand)
                <a href="{{ route('local-deals', array_merge(request()->except('brand'),['brand'=>$brand->id])) }}" class="ld-sb-item {{ $activeBrand==$brand->id ? 'active' : '' }}">
                    <input type="radio" {{ $activeBrand==$brand->id ? 'checked' : '' }} readonly /> {{ $brand->name }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Discount --}}
        <div class="ld-sb-box">
            <div class="ld-sb-head">Min Discount</div>
            <div class="ld-sb-body">
                @foreach(['0'=>'Any Discount','10'=>'10% or more','25'=>'25% or more','40'=>'40% or more','50'=>'50% or more'] as $v=>$lbl)
                <a href="{{ route('local-deals', array_merge(request()->except('min_disc'),['min_disc'=>$v])) }}" class="ld-sb-item {{ (request('min_disc','0'))==$v ? 'active' : '' }}">
                    <input type="radio" {{ (request('min_disc','0'))==$v ? 'checked' : '' }} readonly /> {{ $lbl }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Price range --}}
        <div class="ld-sb-box">
            <div class="ld-sb-head">Price Range</div>
            <div class="ld-price-inputs">
                <input type="number" placeholder="Min" value="{{ request('min_price') }}" id="ld-min-price" />
                <span>—</span>
                <input type="number" placeholder="Max" value="{{ request('max_price') }}" id="ld-max-price" />
                <button class="ld-price-go" onclick="ldApplyPrice()">Go</button>
            </div>
        </div>

    </div>

    {{-- MAIN --}}
    <div class="ld-main">

        {{-- Info banner --}}
        <div class="ld-info-banner">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span>These are <b>local deals</b> available at stores near you. Select <b>"In-Store"</b> to shop at the store or <b>"Online"</b> to order for same-day pickup or delivery. Prices and availability may vary by location.</span>
        </div>

        {{-- Featured stores --}}
        <div class="ld-stores-section">
            <h3>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Stores Near You
            </h3>
            <div class="ld-stores-row">
                @foreach($storeNames as $idx => $sName)
                <div class="ld-store-card">
                    <div class="ld-store-icon" style="background:{{ ['#fff4e0','#f0fff4','#fff0f0','#f0f8ff','#fff8ee','#f0f0ff','#fff4e8','#f0fff8'][$idx % 8] }};">
                        {{ $storeEmojis[$idx] }}
                    </div>
                    <div class="ld-store-name">{{ $sName }}</div>
                    <div class="ld-store-dist">📍 {{ $storeDists[$idx] }} away</div>
                    <div class="ld-store-deals">{{ $storeDeals[$idx] }} deals</div>
                    <span class="ld-store-open {{ $storeOpen[$idx] ? 'open' : 'closed' }}">
                        {{ $storeOpen[$idx] ? '● Open Now' : '● Closed' }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Topbar --}}
        <div class="ld-topbar">
            <div class="ld-topbar-left"><b>{{ $products->count() }}</b> local deals found near you</div>
            <div class="ld-topbar-right">
                Sort by:
                <select onchange="window.location.href=this.value">
                    <option value="{{ route('local-deals', array_merge(request()->all(),['sort'=>'distance'])) }}" {{ $activeSort=='distance' ? 'selected' : '' }}>Nearest First</option>
                    <option value="{{ route('local-deals', array_merge(request()->all(),['sort'=>'discount'])) }}" {{ $activeSort=='discount' ? 'selected' : '' }}>Biggest Discount</option>
                    <option value="{{ route('local-deals', array_merge(request()->all(),['sort'=>'price_asc'])) }}" {{ $activeSort=='price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="{{ route('local-deals', array_merge(request()->all(),['sort'=>'price_desc'])) }}" {{ $activeSort=='price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="{{ route('local-deals', array_merge(request()->all(),['sort'=>'newest'])) }}" {{ $activeSort=='newest' ? 'selected' : '' }}>Newest</option>
                </select>
            </div>
        </div>

        {{-- Grid --}}
        @if($products->isEmpty())
        <div class="ld-empty">
            <svg width="72" height="72" viewBox="0 0 24 24" fill="none" stroke="#ddd" stroke-width="1" style="margin:0 auto 16px;display:block;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            <h3 style="font-size:18px;font-weight:700;margin-bottom:8px;">No local deals found</h3>
            <p style="font-size:14px;color:#555;margin-bottom:14px;">Try expanding your radius or changing your location.</p>
            <a href="{{ route('local-deals') }}" style="color:#007185;font-size:13px;">Clear all filters</a>
        </div>
        @else
        <div class="ld-grid">
            @foreach($products as $product)
            @php
                $idx        = $product->id % count($storeNames);
                $disc       = ldDisc($product->id, $discounts);
                $saveAmt    = round($product->price * $disc / 100, 2);
                $afterP     = round($product->price - $saveAmt, 2);
                $storeName  = $storeNames[$idx];
                $storeDist  = $storeDists[$idx];
                $isOpen     = $storeOpen[$idx];
                $dealType   = $dealTypes[$idx];
                $dealLabel  = $dealTypeMap[$dealType];
                $hours      = $storeHours[$idx];
                $pRating    = $ratings[$idx];
                $pReviews   = $reviews[$idx];
                $pickup     = $hasPickup[$product->id % count($hasPickup)];
                $delivery   = $hasDelivery[$product->id % count($hasDelivery)];
                $exclusive  = $isExclusive[$product->id % count($isExclusive)];
                $limited    = $isLimited[$product->id % count($isLimited)];
                $imgs       = collect($product->images ?? [])->filter()->values();
                $thumb      = $imgs->first() ? \Illuminate\Support\Facades\Storage::url($imgs->first()) : null;
            @endphp
            <div class="ld-card" onclick="window.location='{{ route('products.show', $product->slug) }}'">

                {{-- Store ribbon --}}
                <div class="ld-store-ribbon">
                    <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    {{ $storeName }} · {{ $storeDist }}
                </div>

                <div class="ld-card-img" style="position:relative;">
                    {{-- Discount badge --}}
                    <div class="ld-disc-badge">-{{ $disc }}%</div>

                    {{-- Deal type badge --}}
                    <div class="ld-deal-type {{ $dealType }}">{{ $dealLabel }}</div>

                    @if($thumb)
                        <img src="{{ $thumb }}" alt="{{ $product->name }}" loading="lazy" />
                    @else
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#d5d9d9" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    @endif

                    {{-- Distance overlay --}}
                    <div class="ld-dist-overlay">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        {{ $storeDist }}
                    </div>

                    {{-- In-store availability --}}
                    @if($isOpen)
                    <div class="ld-avail-bar">
                        <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        In Stock at {{ $storeName }}
                    </div>
                    @endif
                </div>

                <div class="ld-card-body">
                    {{-- Store info --}}
                    <div class="ld-card-store">
                        <span class="ld-card-store-dot" style="background:{{ $isOpen ? '#007600' : '#aaa' }};"></span>
                        <span class="ld-card-store-name">{{ $storeName }}</span>
                        <span class="ld-card-store-dist">{{ $storeDist }}</span>
                    </div>

                    <div class="ld-card-name">{{ $product->name }}</div>

                    {{-- Stars --}}
                    <div class="ld-stars">
                        {!! ldStars($pRating) !!}
                        <span>{{ $pRating }} ({{ number_format($pReviews) }})</span>
                    </div>

                    {{-- Price --}}
                    <div class="ld-price-row">
                        <span class="ld-price-now"><sup>$</sup>{{ number_format($afterP, 2) }}</span>
                        <span class="ld-price-was">Was: <s>${{ number_format($product->price, 2) }}</s></span>
                    </div>
                    <span class="ld-save-pill">Save ${{ number_format($saveAmt, 2) }} ({{ $disc }}% off)</span>

                    {{-- Store hours --}}
                    <div class="ld-hours">
                        <span class="ld-hours-dot" style="background:{{ $isOpen ? '#007600' : '#aaa' }};"></span>
                        <span style="font-size:11px;color:{{ $isOpen ? '#007600' : '#888' }};font-weight:600;">{{ $isOpen ? 'Open Now' : 'Closed' }}</span>
                        <span style="font-size:11px;color:#555;margin-left:2px;">· {{ $hours }}</span>
                    </div>

                    {{-- Tags --}}
                    <div class="ld-tags">
                        @if($pickup)    <span class="ld-tag pickup">Free Pickup</span> @endif
                        @if($delivery)  <span class="ld-tag delivery">Same-Day Delivery</span> @endif
                        @if($exclusive) <span class="ld-tag exclusive">🏆 Local Exclusive</span> @endif
                        @if($limited)   <span class="ld-tag limited">⚡ Limited Qty</span> @endif
                        @if($product->category) <span class="ld-tag cat">{{ $product->category->name }}</span> @endif
                    </div>

                    {{-- Actions --}}
                    <div class="ld-card-actions">
                        <a href="{{ route('products.show', $product->slug) }}" class="ld-buy-btn" onclick="event.stopPropagation();">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            Shop This Deal
                        </a>
                        <button class="ld-dir-btn" onclick="event.stopPropagation(); ldGetDirections('{{ $storeName }}')" title="Get directions">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
                        </button>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        {{-- Neighborhood sections --}}
        @foreach($neighborhoods as $nbhd)
        @php $nbhdProducts = $products->skip(($loop->index * 4))->take(4); @endphp
        @if($nbhdProducts->isNotEmpty())
        <div class="ld-neighborhood">
            <div class="ld-nbhd-head">
                <h3>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    {{ $nbhd }} Deals
                </h3>
                <a href="{{ route('local-deals', ['neighborhood'=>strtolower($nbhd)]) }}">See all {{ $nbhd }} deals →</a>
            </div>
            <div class="ld-grid">
                @foreach($nbhdProducts as $product)
                @php
                    $idx       = $product->id % count($storeNames);
                    $disc      = ldDisc($product->id, $discounts);
                    $saveAmt   = round($product->price * $disc / 100, 2);
                    $afterP    = round($product->price - $saveAmt, 2);
                    $storeName = $storeNames[$idx];
                    $storeDist = $storeDists[$idx];
                    $isOpen    = $storeOpen[$idx];
                    $dealType  = $dealTypes[$idx];
                    $dealLabel = $dealTypeMap[$dealType];
                    $hours     = $storeHours[$idx];
                    $pRating   = $ratings[$idx];
                    $pReviews  = $reviews[$idx];
                    $pickup    = $hasPickup[$product->id % count($hasPickup)];
                    $delivery  = $hasDelivery[$product->id % count($hasDelivery)];
                    $exclusive = $isExclusive[$product->id % count($isExclusive)];
                    $limited   = $isLimited[$product->id % count($isLimited)];
                    $imgs      = collect($product->images ?? [])->filter()->values();
                    $thumb     = $imgs->first() ? \Illuminate\Support\Facades\Storage::url($imgs->first()) : null;
                @endphp
                <div class="ld-card" onclick="window.location='{{ route('products.show', $product->slug) }}'">
                    <div class="ld-store-ribbon">
                        <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        {{ $storeName }} · {{ $storeDist }}
                    </div>
                    <div class="ld-card-img" style="position:relative;">
                        <div class="ld-disc-badge">-{{ $disc }}%</div>
                        <div class="ld-deal-type {{ $dealType }}">{{ $dealLabel }}</div>
                        @if($thumb)
                            <img src="{{ $thumb }}" alt="{{ $product->name }}" loading="lazy" />
                        @else
                            <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#d5d9d9" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        @endif
                        <div class="ld-dist-overlay">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            {{ $storeDist }}
                        </div>
                        @if($isOpen)
                        <div class="ld-avail-bar">
                            <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            In Stock at {{ $storeName }}
                        </div>
                        @endif
                    </div>
                    <div class="ld-card-body">
                        <div class="ld-card-store">
                            <span class="ld-card-store-dot" style="background:{{ $isOpen ? '#007600' : '#aaa' }};"></span>
                            <span class="ld-card-store-name">{{ $storeName }}</span>
                            <span class="ld-card-store-dist">{{ $storeDist }}</span>
                        </div>
                        <div class="ld-card-name">{{ $product->name }}</div>
                        <div class="ld-stars">{!! ldStars($pRating) !!}<span>{{ $pRating }} ({{ number_format($pReviews) }})</span></div>
                        <div class="ld-price-row">
                            <span class="ld-price-now"><sup>$</sup>{{ number_format($afterP, 2) }}</span>
                            <span class="ld-price-was">Was: <s>${{ number_format($product->price, 2) }}</s></span>
                        </div>
                        <span class="ld-save-pill">Save ${{ number_format($saveAmt, 2) }} ({{ $disc }}% off)</span>
                        <div class="ld-hours">
                            <span class="ld-hours-dot" style="background:{{ $isOpen ? '#007600' : '#aaa' }};"></span>
                            <span style="font-size:11px;color:{{ $isOpen ? '#007600' : '#888' }};font-weight:600;">{{ $isOpen ? 'Open Now' : 'Closed' }}</span>
                            <span style="font-size:11px;color:#555;margin-left:2px;">· {{ $hours }}</span>
                        </div>
                        <div class="ld-tags">
                            @if($pickup)    <span class="ld-tag pickup">Free Pickup</span> @endif
                            @if($delivery)  <span class="ld-tag delivery">Same-Day Delivery</span> @endif
                            @if($exclusive) <span class="ld-tag exclusive">🏆 Local Exclusive</span> @endif
                        </div>
                        <div class="ld-card-actions">
                            <a href="{{ route('products.show', $product->slug) }}" class="ld-buy-btn" onclick="event.stopPropagation();">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                                Shop This Deal
                            </a>
                            <button class="ld-dir-btn" onclick="event.stopPropagation(); ldGetDirections('{{ $storeName }}')" title="Get directions">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @endforeach

        @endif

    </div>
</div>
</div>

<script>
function ldDetectLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            const input = document.getElementById('ld-zip-input');
            if (input) input.placeholder = 'Location detected ✓';
            ldShowToast('Location detected! Showing deals near you.');
        }, function() {
            ldShowToast('Could not detect location. Please enter your zip code.');
        });
    } else {
        ldShowToast('Geolocation not supported. Please enter your zip code.');
    }
}

function ldSetRadius(r) {
    const url = new URL(window.location.href);
    url.searchParams.set('radius', r);
    const display = document.getElementById('ld-radius-display');
    if (display) display.textContent = r + ' mi';
    document.querySelectorAll('.ld-radius-btn').forEach(b => {
        b.classList.toggle('active', b.textContent.trim().startsWith(r + ' '));
    });
    window.location.href = url.toString();
}

function ldApplyPrice() {
    const min = document.getElementById('ld-min-price').value;
    const max = document.getElementById('ld-max-price').value;
    const url = new URL(window.location.href);
    if (min) url.searchParams.set('min_price', min);
    else url.searchParams.delete('min_price');
    if (max) url.searchParams.set('max_price', max);
    else url.searchParams.delete('max_price');
    window.location.href = url.toString();
}

function ldGetDirections(storeName) {
    const query = encodeURIComponent(storeName);
    window.open('https://www.google.com/maps/search/' + query, '_blank');
}

function ldShowToast(msg) {
    let t = document.getElementById('ldToast');
    if (!t) {
        t = document.createElement('div');
        t.id = 'ldToast';
        t.style.cssText = 'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#131921;color:#FF9900;padding:11px 22px;border-radius:6px;font-size:13px;z-index:99999;box-shadow:0 4px 16px rgba(0,0,0,.3);transition:opacity .3s;white-space:nowrap;font-weight:600;';
        document.body.appendChild(t);
    }
    t.textContent = msg;
    t.style.opacity = '1';
    clearTimeout(t._timer);
    t._timer = setTimeout(() => { t.style.opacity = '0'; }, 3000);
}
</script>
@endsection
