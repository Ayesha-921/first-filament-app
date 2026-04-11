@extends('store.layout')
@section('title', 'Home & Garden — MyShop')

@section('head')
<style>
    /* ── Page ───────────────────────────────────────── */
    .hg-page { background: #EAEDED; min-height: 80vh; }

    /* ── Hero ───────────────────────────────────────── */
    .hg-hero { background: linear-gradient(115deg,#1b3a1b 0%,#2d5a27 55%,#1a3d1a 100%); padding: 28px 18px; position: relative; overflow: hidden; }
    .hg-hero::before { content:''; position:absolute; right:-60px; top:-60px; width:300px; height:300px; background:rgba(255,153,0,.08); border-radius:50%; pointer-events:none; }
    .hg-hero::after  { content:''; position:absolute; left:35%; bottom:-80px; width:260px; height:260px; background:rgba(255,255,255,.03); border-radius:50%; pointer-events:none; }
    .hg-hero-inner { max-width:1340px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; gap:20px; flex-wrap:wrap; position:relative; z-index:1; }
    .hg-hero-eyebrow { display:inline-flex; align-items:center; gap:6px; background:rgba(255,153,0,.15); border:1px solid rgba(255,153,0,.4); border-radius:20px; padding:4px 14px; font-size:12px; color:#FF9900; font-weight:700; letter-spacing:.5px; margin-bottom:10px; text-transform:uppercase; }
    .hg-hero-left h1 { font-size:32px; font-weight:900; color:#fff; margin:0 0 8px; line-height:1.15; }
    .hg-hero-left h1 span { color:#FF9900; }
    .hg-hero-left p { font-size:13px; color:#c5d9c0; margin:0 0 18px; max-width:480px; line-height:1.6; }
    .hg-hero-btns { display:flex; gap:10px; flex-wrap:wrap; }
    .hg-hero-btn { display:inline-flex; align-items:center; gap:7px; border-radius:6px; padding:10px 20px; font-size:13px; font-weight:700; cursor:pointer; text-decoration:none; transition:all .12s; }
    .hg-hero-btn.primary { background:#FFD814; border:1px solid #FCD200; color:#131921; }
    .hg-hero-btn.primary:hover { background:#F7CA00; color:#131921; }
    .hg-hero-btn.secondary { background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.25); color:#fff; }
    .hg-hero-btn.secondary:hover { background:rgba(255,255,255,.18); color:#fff; }
    .hg-hero-stats { display:flex; gap:12px; flex-wrap:wrap; }
    .hg-stat { text-align:center; background:rgba(255,255,255,.08); border:1px solid rgba(255,255,255,.14); border-radius:10px; padding:14px 18px; min-width:76px; }
    .hg-stat-num { font-size:22px; font-weight:900; color:#FF9900; line-height:1; }
    .hg-stat-label { font-size:10px; color:#c5d9c0; text-transform:uppercase; letter-spacing:.5px; margin-top:4px; }

    /* ── Season banner ───────────────────────────────── */
    .hg-season { background: linear-gradient(90deg,#FF9900,#e88b00); }
    .hg-season-inner { max-width:1340px; margin:0 auto; padding:10px 18px; display:flex; align-items:center; gap:14px; flex-wrap:wrap; justify-content:center; }
    .hg-season-item { display:flex; align-items:center; gap:6px; font-size:13px; font-weight:700; color:#131921; white-space:nowrap; }
    .hg-season-sep { color:rgba(19,25,33,.4); font-size:18px; }

    /* ── Room nav chips ──────────────────────────────── */
    .hg-rooms-bar { background:#fff; border-bottom:1px solid #e3e6e6; }
    .hg-rooms-inner { max-width:1340px; margin:0 auto; padding:14px 18px; display:flex; gap:10px; overflow-x:auto; scrollbar-width:none; }
    .hg-rooms-inner::-webkit-scrollbar { display:none; }
    .hg-room-chip { flex-shrink:0; display:flex; flex-direction:column; align-items:center; gap:6px; padding:10px 16px; border:1px solid #e3e6e6; border-radius:10px; cursor:pointer; text-decoration:none; transition:all .15s; background:#fff; min-width:80px; }
    .hg-room-chip:hover { border-color:#FF9900; background:#fff8ee; }
    .hg-room-chip.active { border-color:#FF9900; background:#fff4e0; box-shadow:0 0 0 2px rgba(255,153,0,.15); }
    .hg-room-chip-icon { font-size:24px; line-height:1; }
    .hg-room-chip-label { font-size:11px; font-weight:600; color:#0F1111; white-space:nowrap; }
    .hg-room-chip.active .hg-room-chip-label { color:#C7511F; }

    /* ── Brands bar ──────────────────────────────────── */
    .hg-brands-bar { background:#fff; border-bottom:1px solid #e3e6e6; }
    .hg-brands-inner { max-width:1340px; margin:0 auto; padding:10px 18px; display:flex; align-items:center; gap:6px; overflow-x:auto; scrollbar-width:none; }
    .hg-brands-inner::-webkit-scrollbar { display:none; }
    .hg-brands-label { font-size:12px; font-weight:700; color:#555; white-space:nowrap; flex-shrink:0; margin-right:6px; }
    .hg-brand-pill { flex-shrink:0; padding:5px 14px; border:1px solid #d5d9d9; border-radius:20px; font-size:12px; font-weight:600; color:#0F1111; cursor:pointer; text-decoration:none; background:#fff; transition:all .12s; }
    .hg-brand-pill:hover { border-color:#FF9900; color:#C7511F; background:#fff8ee; }
    .hg-brand-pill.active { background:#131921; color:#FF9900; border-color:#131921; }

    /* ── Filter tabs ─────────────────────────────────── */
    .hg-tabs-wrap { background:#fff; border-bottom:2px solid #e3e6e6; }
    .hg-tabs { max-width:1340px; margin:0 auto; padding:0 18px; display:flex; overflow-x:auto; scrollbar-width:none; }
    .hg-tabs::-webkit-scrollbar { display:none; }
    .hg-tab { display:inline-flex; align-items:center; gap:6px; padding:12px 18px; font-size:13px; font-weight:500; color:#555; white-space:nowrap; border-bottom:3px solid transparent; cursor:pointer; text-decoration:none; transition:color .12s,border-color .12s; flex-shrink:0; }
    .hg-tab:hover { color:#C7511F; border-bottom-color:#FF9900; }
    .hg-tab.active { color:#C7511F; border-bottom-color:#FF9900; font-weight:700; }
    .hg-tab-count { background:#FF9900; color:#131921; font-size:10px; font-weight:800; border-radius:99px; padding:1px 7px; }

    /* ── Breadcrumb ──────────────────────────────────── */
    .hg-breadcrumb { max-width:1340px; margin:0 auto; padding:10px 18px; font-size:13px; color:#555; }
    .hg-breadcrumb a { color:#007185; }
    .hg-breadcrumb a:hover { color:#C7511F; text-decoration:underline; }

    /* ── Layout ──────────────────────────────────────── */
    .hg-wrap { max-width:1340px; margin:0 auto; padding:20px 18px 50px; display:flex; gap:20px; align-items:flex-start; }

    /* ── Sidebar ─────────────────────────────────────── */
    .hg-sidebar { width:210px; flex-shrink:0; }
    .hg-sb-box { background:#fff; border:1px solid #e3e6e6; border-radius:8px; overflow:hidden; margin-bottom:14px; }
    .hg-sb-head { font-size:14px; font-weight:700; color:#0F1111; padding:12px 16px 10px; border-bottom:1px solid #f0f2f2; background:#f7f8f8; display:flex; align-items:center; gap:7px; }
    .hg-sb-body { padding:8px 0; }
    .hg-sb-item { display:flex; align-items:center; gap:9px; padding:8px 16px; font-size:13px; color:#0F1111; cursor:pointer; text-decoration:none; transition:background .1s; border-left:3px solid transparent; }
    .hg-sb-item:hover { background:#fff8ee; border-left-color:#FF9900; color:#C7511F; }
    .hg-sb-item.active { background:#fff4e0; border-left-color:#FF9900; font-weight:700; color:#C7511F; }
    .hg-sb-item input[type=radio] { accent-color:#FF9900; width:14px; height:14px; flex-shrink:0; }
    .hg-sb-item-count { margin-left:auto; font-size:11px; color:#888; background:#f0f2f2; border-radius:99px; padding:1px 7px; }
    .hg-price-inputs { display:flex; gap:6px; align-items:center; padding:10px 16px; }
    .hg-price-inputs input { width:60px; border:1px solid #d5d9d9; border-radius:4px; padding:5px 6px; font-size:12px; outline:none; }
    .hg-price-inputs input:focus { border-color:#FF9900; box-shadow:0 0 0 2px rgba(255,153,0,.15); }
    .hg-price-inputs span { font-size:12px; color:#555; }
    .hg-price-go { background:#FF9900; color:#131921; border:none; border-radius:4px; padding:5px 10px; font-size:12px; font-weight:700; cursor:pointer; }

    /* Inspiration CTA */
    .hg-inspo-cta { background:linear-gradient(135deg,#1b3a1b,#2d5a27); border-radius:8px; padding:16px; margin-bottom:14px; text-align:center; }
    .hg-inspo-cta h4 { font-size:14px; font-weight:800; color:#fff; margin:0 0 6px; }
    .hg-inspo-cta p { font-size:12px; color:#c5d9c0; margin:0 0 12px; line-height:1.5; }
    .hg-inspo-btn { display:block; background:#FFD814; border:1px solid #FCD200; border-radius:20px; padding:9px; font-size:13px; font-weight:700; color:#131921; text-decoration:none; transition:background .12s; }
    .hg-inspo-btn:hover { background:#F7CA00; color:#131921; }

    /* ── Main ────────────────────────────────────────── */
    .hg-main { flex:1; min-width:0; }

    /* Promo banners */
    .hg-promos { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:12px; margin-bottom:20px; }
    .hg-promo { border-radius:10px; padding:18px; display:flex; flex-direction:column; gap:8px; position:relative; overflow:hidden; cursor:pointer; transition:transform .15s,box-shadow .15s; text-decoration:none; }
    .hg-promo:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,.15); }
    .hg-promo h4 { font-size:14px; font-weight:800; margin:0; }
    .hg-promo p { font-size:12px; margin:0; opacity:.9; line-height:1.4; }
    .hg-promo span { font-size:11px; font-weight:700; margin-top:4px; }
    .hg-promo-icon { position:absolute; right:12px; top:50%; transform:translateY(-50%); font-size:42px; opacity:.22; }
    .hg-p1 { background:linear-gradient(135deg,#1b3a1b,#2d5a27); color:#fff; }
    .hg-p1 h4 { color:#FF9900; } .hg-p1 span { color:#FFD814; }
    .hg-p2 { background:linear-gradient(135deg,#7b3f00,#a05200); color:#fff; }
    .hg-p2 span { color:#FFD814; }
    .hg-p3 { background:linear-gradient(135deg,#0d4f0d,#1a7a1a); color:#fff; }
    .hg-p3 span { color:#FFD814; }
    .hg-p4 { background:linear-gradient(135deg,#131921,#1a2a3a); color:#fff; }
    .hg-p4 h4 { color:#FF9900; } .hg-p4 span { color:#FFD814; }

    /* Topbar */
    .hg-topbar { display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; flex-wrap:wrap; gap:10px; }
    .hg-topbar-left { font-size:14px; color:#555; }
    .hg-topbar-left b { color:#0F1111; }
    .hg-topbar-right { display:flex; align-items:center; gap:8px; font-size:13px; color:#555; }
    .hg-topbar-right select { border:1px solid #d5d9d9; border-radius:6px; padding:6px 10px; font-size:13px; background:#fff; cursor:pointer; outline:none; }

    /* ── Product grid ────────────────────────────────── */
    .hg-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(210px,1fr)); gap:14px; }

    /* ── Product card ────────────────────────────────── */
    .hg-card { background:#fff; border:1px solid #e3e6e6; border-radius:8px; overflow:hidden; display:flex; flex-direction:column; position:relative; transition:box-shadow .15s,border-color .15s; cursor:pointer; }
    .hg-card:hover { box-shadow:0 4px 20px rgba(0,0,0,.12); border-color:#FF9900; }

    /* Badges */
    .hg-disc-badge { position:absolute; top:8px; left:8px; background:#CC0C39; color:#fff; font-size:12px; font-weight:900; border-radius:4px; padding:3px 8px; z-index:3; }
    .hg-type-badge { position:absolute; top:8px; right:8px; border-radius:4px; padding:3px 8px; font-size:10px; font-weight:800; z-index:3; }
    .hg-type-badge.new-arrival { background:#007600; color:#fff; }
    .hg-type-badge.bestseller  { background:#CC0C39; color:#fff; }
    .hg-type-badge.deal        { background:#131921; color:#FF9900; }
    .hg-type-badge.seasonal    { background:#2d5a27; color:#fff; }
    .hg-type-badge.eco         { background:#007185; color:#fff; }

    /* Eco ribbon */
    .hg-eco-ribbon { position:absolute; top:0; left:0; right:0; background:linear-gradient(90deg,#0d4f0d,#1a7a1a); color:#fff; font-size:10px; font-weight:700; text-align:center; padding:3px; z-index:5; display:flex; align-items:center; justify-content:center; gap:4px; }

    /* Image */
    .hg-card-img { background:#f7f8f8; aspect-ratio:1/1; display:flex; align-items:center; justify-content:center; overflow:hidden; }
    .hg-card.has-ribbon .hg-card-img { padding-top:20px; }
    .hg-card-img img { max-width:80%; max-height:80%; object-fit:contain; transition:transform .2s; }
    .hg-card:hover .hg-card-img img { transform:scale(1.05); }

    /* Wishlist */
    .hg-wish-btn { position:absolute; bottom:calc(100% - 100% + 8px); right:8px; width:28px; height:28px; border-radius:50%; background:rgba(255,255,255,.9); border:1px solid #e3e6e6; display:flex; align-items:center; justify-content:center; z-index:4; cursor:pointer; transition:all .12s; top:auto; bottom:8px; }
    .hg-wish-btn:hover { background:#fff; border-color:#CC0C39; }
    .hg-wish-btn.saved svg { fill:#CC0C39; stroke:#CC0C39; }

    /* Body */
    .hg-card-body { padding:12px 12px 14px; flex:1; display:flex; flex-direction:column; gap:4px; }
    .hg-card-room { font-size:10px; color:#007185; font-weight:700; text-transform:uppercase; letter-spacing:.4px; display:flex; align-items:center; gap:4px; }
    .hg-card-brand { font-size:11px; color:#C7511F; font-weight:700; text-transform:uppercase; letter-spacing:.3px; }
    .hg-card-name { font-size:13px; color:#0F1111; line-height:1.4; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; }

    /* Stars */
    .hg-stars { display:flex; align-items:center; gap:2px; }
    .hg-stars span { font-size:11px; color:#555; margin-left:3px; }

    /* Price */
    .hg-price-row { display:flex; align-items:baseline; gap:6px; margin-top:4px; flex-wrap:wrap; }
    .hg-price { font-size:20px; font-weight:900; color:#B12704; }
    .hg-price sup { font-size:12px; vertical-align:super; }
    .hg-was { font-size:12px; color:#888; }
    .hg-was s { color:#aaa; }
    .hg-save-pill { font-size:11px; background:#fff4e0; color:#C7511F; border:1px solid #FFD580; border-radius:4px; padding:2px 6px; font-weight:700; display:inline-block; }

    /* Spec tags */
    .hg-spec-tags { display:flex; gap:4px; flex-wrap:wrap; margin-top:4px; }
    .hg-spec-tag { font-size:10px; background:#f0f2f2; color:#555; border-radius:4px; padding:2px 7px; }
    .hg-spec-tag.eco   { background:#F0FFF4; color:#007600; font-weight:700; }
    .hg-spec-tag.prime { background:#fff4e0; color:#C7511F; font-weight:700; }
    .hg-spec-tag.free  { background:#F0FFF4; color:#007600; }
    .hg-spec-tag.low   { background:#FFF0F0; color:#CC0C39; font-weight:700; }

    /* Actions */
    .hg-card-actions { display:flex; gap:6px; margin-top:8px; }
    .hg-add-btn { flex:1; display:flex; align-items:center; justify-content:center; gap:5px; background:#FFD814; border:1px solid #FCD200; border-radius:20px; padding:8px; font-size:12px; font-weight:700; color:#131921; cursor:pointer; text-decoration:none; transition:background .12s; }
    .hg-add-btn:hover { background:#F7CA00; color:#131921; }
    .hg-wish-btn2 { width:36px; flex-shrink:0; display:flex; align-items:center; justify-content:center; background:#fff; border:1px solid #d5d9d9; border-radius:20px; cursor:pointer; color:#555; transition:all .12s; }
    .hg-wish-btn2:hover { border-color:#FF9900; color:#C7511F; background:#fff8ee; }

    /* ── Section head ────────────────────────────────── */
    .hg-section-head { display:flex; align-items:center; justify-content:space-between; margin:24px 0 14px; }
    .hg-section-head h3 { font-size:16px; font-weight:700; color:#0F1111; margin:0; display:flex; align-items:center; gap:8px; border-left:4px solid #FF9900; padding-left:10px; }
    .hg-section-head a { font-size:13px; color:#007185; text-decoration:none; }
    .hg-section-head a:hover { color:#C7511F; text-decoration:underline; }

    /* ── Room inspiration ────────────────────────────── */
    .hg-room-inspiration { background:#fff; border:1px solid #e3e6e6; border-radius:8px; padding:20px; margin-top:24px; }
    .hg-room-inspiration h3 { font-size:16px; font-weight:700; color:#0F1111; margin:0 0 16px; border-bottom:2px solid #FF9900; padding-bottom:10px; display:flex; align-items:center; gap:8px; }
    .hg-inspo-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(150px,1fr)); gap:12px; }
    .hg-inspo-room { position:relative; border-radius:10px; overflow:hidden; aspect-ratio:4/3; cursor:pointer; transition:transform .15s; }
    .hg-inspo-room:hover { transform:scale(1.02); }
    .hg-inspo-room-bg { width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:48px; }
    .hg-inspo-room-label { position:absolute; bottom:0; left:0; right:0; background:linear-gradient(to top,rgba(19,25,33,.8),transparent); padding:14px 12px 10px; }
    .hg-inspo-room-label h4 { font-size:13px; font-weight:700; color:#fff; margin:0; }
    .hg-inspo-room-label span { font-size:11px; color:#FFD814; }

    /* ── Seasonal tips ───────────────────────────────── */
    .hg-tips { background:#fff; border:1px solid #e3e6e6; border-radius:8px; padding:20px; margin-top:24px; }
    .hg-tips h3 { font-size:16px; font-weight:700; color:#0F1111; margin:0 0 16px; border-bottom:2px solid #FF9900; padding-bottom:10px; display:flex; align-items:center; gap:8px; }
    .hg-tips-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:12px; }
    .hg-tip-card { background:#f7f8f8; border-radius:8px; padding:14px; display:flex; gap:10px; align-items:flex-start; }
    .hg-tip-icon { font-size:24px; flex-shrink:0; }
    .hg-tip-card h4 { font-size:12px; font-weight:700; color:#0F1111; margin:0 0 4px; }
    .hg-tip-card p { font-size:11px; color:#555; margin:0; line-height:1.5; }

    /* ── Empty ───────────────────────────────────────── */
    .hg-empty { text-align:center; padding:60px 20px; background:#fff; border-radius:8px; border:1px solid #e3e6e6; }

    @media (max-width:760px) {
        .hg-wrap { flex-direction:column; }
        .hg-sidebar { width:100%; }
        .hg-grid { grid-template-columns:repeat(2,1fr); }
        .hg-hero-inner { flex-direction:column; }
        .hg-promos { grid-template-columns:repeat(2,1fr); }
    }
    @media (max-width:480px) {
        .hg-grid { grid-template-columns:1fr; }
        .hg-promos { grid-template-columns:1fr; }
    }
</style>
@endsection

@section('content')
@php
    /* ── Helpers ─────────────────────────────────── */
    $discounts   = [8,10,12,15,18,20,22,25,28,30,35,40];
    $badgeTypes  = ['deal','new-arrival','bestseller','seasonal','eco','deal','new-arrival'];
    $badgeLabels = ['deal'=>'Deal','new-arrival'=>'New Arrival','bestseller'=>'Best Seller','seasonal'=>'Seasonal','eco'=>'Eco Choice'];
    $ratings     = [3.8,4.0,4.2,4.4,4.5,4.6,4.7,4.8,4.9,5.0,4.1,4.3];
    $reviews     = [22,45,88,160,280,420,840,1100,64,130,210,370];
    $isFreeShip  = [true,false,true,true,false,true,true,false,true,false,true,false];
    $isPrime     = [true,true,false,true,true,false,true,false,true,true,false,true];
    $isEco       = [false,true,false,false,true,false,true,false,false,true,false,false];
    $isLowStock  = [false,false,true,false,true,false,false,true,false,false,true,false];
    $rooms       = ['Living Room','Kitchen','Bedroom','Bathroom','Garden','Office','Dining Room','Garage'];
    $roomEmojis  = ['🛋️','🍳','🛏️','🚿','🌿','💼','🍽️','🔧'];
    $hgBrands    = ['IKEA','Dyson','KitchenAid','Weber','Philips','Bissell','Cuisinart','Black+Decker','Shark','Rubbermaid'];
    $specsByRoom = [
        ['Indoor','Washable','Anti-slip'],['Non-stick','Oven-safe','BPA Free'],['King Size','Breathable','Hypoallergenic'],
        ['Waterproof','Rust-proof','UV-resistant'],['Perennial','Low-maintenance','Pet-safe'],
        ['Ergonomic','Height-adj.','Foldable'],['Stain-resist','Microwave-safe','Dishwasher-safe'],['Heavy-duty','Weatherproof','Lockable'],
    ];

    function hgDisc($id,$arr){ return $arr[$id % count($arr)]; }
    function hgStars($r){
        $f=floor($r);$h=($r-$f)>=0.5?1:0;$e=5-$f-$h;$o='';
        for($i=0;$i<$f;$i++)  $o.='<svg width="11" height="11" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        if($h) $o.='<svg width="11" height="11" viewBox="0 0 24 24" fill="#ddd" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        for($i=0;$i<$e;$i++)  $o.='<svg width="11" height="11" viewBox="0 0 24 24" fill="#ddd" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        return $o;
    }

    $activeTab   = request('tab','all');
    $activeCat   = request('category');
    $activeBrand = request('brand');
    $activeSort  = request('sort','featured');
    $activeRoom  = request('room');
@endphp

<div class="hg-page">

{{-- Hero --}}
<div class="hg-hero">
    <div class="hg-hero-inner">
        <div class="hg-hero-left">
            <div class="hg-hero-eyebrow">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Home Essentials & Garden
            </div>
            <h1>Home &amp; <span>Garden</span></h1>
            <p>Transform your living spaces with quality furniture, décor, appliances, outdoor essentials, and garden supplies — all at great prices.</p>
            <div class="hg-hero-btns">
                <a href="#hg-listings" class="hg-hero-btn primary">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Shop All Home & Garden
                </a>
                <a href="{{ route('home-garden', ['room'=>'garden']) }}" class="hg-hero-btn secondary">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22V12M12 12C12 12 7 8 7 4a5 5 0 0 1 10 0c0 4-5 8-5 8z"/></svg>
                    Garden & Outdoor
                </a>
            </div>
        </div>
        <div class="hg-hero-stats">
            <div class="hg-stat">
                <div class="hg-stat-num">{{ $products->count() }}+</div>
                <div class="hg-stat-label">Products</div>
            </div>
            <div class="hg-stat">
                <div class="hg-stat-num">{{ count($rooms) }}</div>
                <div class="hg-stat-label">Room Types</div>
            </div>
            <div class="hg-stat">
                <div class="hg-stat-num">40%</div>
                <div class="hg-stat-label">Max Off</div>
            </div>
            <div class="hg-stat">
                <div class="hg-stat-num">FREE</div>
                <div class="hg-stat-label">Delivery</div>
            </div>
        </div>
    </div>
</div>

{{-- Season banner --}}
<div class="hg-season">
    <div class="hg-season-inner">
        <div class="hg-season-item">🌸 Spring Sale — Up to 40% off garden essentials</div>
        <div class="hg-season-sep">·</div>
        <div class="hg-season-item">🛋️ Living Room Refresh — New arrivals</div>
        <div class="hg-season-sep">·</div>
        <div class="hg-season-item">🌿 Eco-Friendly Picks — Shop sustainable home</div>
        <div class="hg-season-sep">·</div>
        <div class="hg-season-item">🚚 Free delivery on orders $49+</div>
    </div>
</div>

{{-- Room chips --}}
<div class="hg-rooms-bar">
    <div class="hg-rooms-inner">
        <a href="{{ route('home-garden') }}" class="hg-room-chip {{ !$activeRoom ? 'active' : '' }}">
            <span class="hg-room-chip-icon">🏠</span>
            <span class="hg-room-chip-label">All Rooms</span>
        </a>
        @foreach($rooms as $i => $room)
        <a href="{{ route('home-garden', ['room'=>strtolower(str_replace(' ','-',$room))]) }}" class="hg-room-chip {{ $activeRoom==strtolower(str_replace(' ','-',$room)) ? 'active' : '' }}">
            <span class="hg-room-chip-icon">{{ $roomEmojis[$i] }}</span>
            <span class="hg-room-chip-label">{{ $room }}</span>
        </a>
        @endforeach
    </div>
</div>

{{-- Brands bar --}}
<div class="hg-brands-bar">
    <div class="hg-brands-inner">
        <span class="hg-brands-label">Top Brands:</span>
        <a href="{{ route('home-garden') }}" class="hg-brand-pill {{ !$activeBrand ? 'active' : '' }}">All</a>
        @foreach($hgBrands as $b)
        <a href="{{ route('home-garden', ['brand_name'=>$b]) }}" class="hg-brand-pill {{ request('brand_name')==$b ? 'active' : '' }}">{{ $b }}</a>
        @endforeach
        @foreach($brands->take(5) as $brand)
        <a href="{{ route('home-garden', array_merge(request()->except('brand'),['brand'=>$brand->id])) }}" class="hg-brand-pill {{ $activeBrand==$brand->id ? 'active' : '' }}">{{ $brand->name }}</a>
        @endforeach
    </div>
</div>

{{-- Filter tabs --}}
<div class="hg-tabs-wrap">
    <div class="hg-tabs">
        <a href="{{ route('home-garden') }}" class="hg-tab {{ $activeTab=='all' ? 'active' : '' }}">
            All Home &amp; Garden <span class="hg-tab-count">{{ $products->count() }}</span>
        </a>
        <a href="{{ route('home-garden',['tab'=>'deals']) }}" class="hg-tab {{ $activeTab=='deals' ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
            Today's Deals
        </a>
        <a href="{{ route('home-garden',['tab'=>'new']) }}" class="hg-tab {{ $activeTab=='new' ? 'active' : '' }}">New Arrivals</a>
        <a href="{{ route('home-garden',['tab'=>'bestseller']) }}" class="hg-tab {{ $activeTab=='bestseller' ? 'active' : '' }}">Best Sellers</a>
        <a href="{{ route('home-garden',['tab'=>'eco']) }}" class="hg-tab {{ $activeTab=='eco' ? 'active' : '' }}">
            🌿 Eco-Friendly
        </a>
        <a href="{{ route('home-garden',['tab'=>'seasonal']) }}" class="hg-tab {{ $activeTab=='seasonal' ? 'active' : '' }}">
            🌸 Seasonal Picks
        </a>
        @foreach($categories->take(5) as $cat)
        <a href="{{ route('home-garden',['category'=>$cat->id]) }}" class="hg-tab {{ $activeCat==$cat->id ? 'active' : '' }}">{{ $cat->name }}</a>
        @endforeach
    </div>
</div>

{{-- Breadcrumb --}}
<div style="background:#fff;border-bottom:1px solid #e3e6e6;">
    <div class="hg-breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span> › </span>
        <span style="color:#0F1111;">Home &amp; Garden</span>
        @if($activeRoom)<span> › </span><span style="color:#0F1111;text-transform:capitalize;">{{ str_replace('-',' ',$activeRoom) }}</span>@endif
    </div>
</div>

{{-- Body --}}
<div class="hg-wrap">

    {{-- SIDEBAR --}}
    <div class="hg-sidebar">

        {{-- Inspiration CTA --}}
        <div class="hg-inspo-cta">
            <h4>🏡 Room Ideas</h4>
            <p>Get inspired with curated room designs and product bundles.</p>
            <a href="#hg-inspiration" class="hg-inspo-btn">Browse Room Looks</a>
        </div>

        {{-- Room/Category --}}
        <div class="hg-sb-box">
            <div class="hg-sb-head">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Shop by Room
            </div>
            <div class="hg-sb-body">
                <a href="{{ route('home-garden') }}" class="hg-sb-item {{ !$activeRoom && !$activeCat ? 'active' : '' }}">
                    <input type="radio" {{ !$activeRoom && !$activeCat ? 'checked' : '' }} readonly /> 🏠 All Rooms
                </a>
                @foreach($rooms as $i => $room)
                <a href="{{ route('home-garden',['room'=>strtolower(str_replace(' ','-',$room))]) }}" class="hg-sb-item {{ $activeRoom==strtolower(str_replace(' ','-',$room)) ? 'active' : '' }}">
                    <input type="radio" {{ $activeRoom==strtolower(str_replace(' ','-',$room)) ? 'checked' : '' }} readonly />
                    {{ $roomEmojis[$i] }} {{ $room }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Department --}}
        @if($categories->isNotEmpty())
        <div class="hg-sb-box">
            <div class="hg-sb-head">Department</div>
            <div class="hg-sb-body">
                <a href="{{ route('home-garden', request()->except('category')) }}" class="hg-sb-item {{ !$activeCat ? 'active' : '' }}">
                    <input type="radio" {{ !$activeCat ? 'checked' : '' }} readonly /> All Departments
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('home-garden', array_merge(request()->except('category'),['category'=>$cat->id])) }}" class="hg-sb-item {{ $activeCat==$cat->id ? 'active' : '' }}">
                    <input type="radio" {{ $activeCat==$cat->id ? 'checked' : '' }} readonly />
                    {{ $cat->name }}
                    <span class="hg-sb-item-count">{{ rand(3,45) }}</span>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Brand --}}
        @if($brands->isNotEmpty())
        <div class="hg-sb-box">
            <div class="hg-sb-head">Brand</div>
            <div class="hg-sb-body">
                <a href="{{ route('home-garden', request()->except('brand')) }}" class="hg-sb-item {{ !$activeBrand ? 'active' : '' }}">
                    <input type="radio" {{ !$activeBrand ? 'checked' : '' }} readonly /> All Brands
                </a>
                @foreach($brands->take(10) as $brand)
                <a href="{{ route('home-garden', array_merge(request()->except('brand'),['brand'=>$brand->id])) }}" class="hg-sb-item {{ $activeBrand==$brand->id ? 'active' : '' }}">
                    <input type="radio" {{ $activeBrand==$brand->id ? 'checked' : '' }} readonly /> {{ $brand->name }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Feature filters --}}
        <div class="hg-sb-box">
            <div class="hg-sb-head">Features</div>
            <div class="hg-sb-body">
                @foreach(['eco'=>'🌿 Eco-Friendly','freeship'=>'🚚 Free Shipping','prime'=>'⭐ Prime','instock'=>'✅ In Stock'] as $k=>$lbl)
                <a href="{{ route('home-garden', array_merge(request()->all(),['feature'=>$k])) }}" class="hg-sb-item {{ request('feature')==$k ? 'active' : '' }}">
                    <input type="radio" {{ request('feature')==$k ? 'checked' : '' }} readonly /> {{ $lbl }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Discount --}}
        <div class="hg-sb-box">
            <div class="hg-sb-head">Discount</div>
            <div class="hg-sb-body">
                @foreach(['10'=>'10% or more','20'=>'20% or more','30'=>'30% or more','40'=>'40% or more'] as $v=>$lbl)
                <a href="{{ route('home-garden', array_merge(request()->except('min_disc'),['min_disc'=>$v])) }}" class="hg-sb-item {{ request('min_disc')==$v ? 'active' : '' }}">
                    <input type="radio" {{ request('min_disc')==$v ? 'checked' : '' }} readonly /> {{ $lbl }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Price --}}
        <div class="hg-sb-box">
            <div class="hg-sb-head">Price Range</div>
            <div class="hg-price-inputs">
                <input type="number" placeholder="Min" value="{{ request('min_price') }}" id="hg-min" />
                <span>—</span>
                <input type="number" placeholder="Max" value="{{ request('max_price') }}" id="hg-max" />
                <button class="hg-price-go" onclick="hgApplyPrice()">Go</button>
            </div>
        </div>

    </div>

    {{-- MAIN --}}
    <div class="hg-main" id="hg-listings">

        {{-- Promo banners --}}
        <div class="hg-promos">
            <a href="{{ route('home-garden',['tab'=>'deals']) }}" class="hg-promo hg-p1">
                <div class="hg-promo-icon">🏡</div>
                <h4>Home Deals</h4>
                <p>Up to 40% off furniture & décor</p>
                <span>Shop Now →</span>
            </a>
            <a href="{{ route('home-garden',['room'=>'garden']) }}" class="hg-promo hg-p3">
                <div class="hg-promo-icon">🌿</div>
                <h4>Garden & Outdoor</h4>
                <p>Everything for your outdoor space</p>
                <span>Explore →</span>
            </a>
            <a href="{{ route('home-garden',['tab'=>'eco']) }}" class="hg-promo hg-p2">
                <div class="hg-promo-icon">♻️</div>
                <h4>Eco-Friendly</h4>
                <p>Sustainable home & garden picks</p>
                <span>Go Green →</span>
            </a>
            <a href="{{ route('home-garden',['tab'=>'new']) }}" class="hg-promo hg-p4">
                <div class="hg-promo-icon">✨</div>
                <h4>New Arrivals</h4>
                <p>Fresh styles just added</p>
                <span>Browse →</span>
            </a>
        </div>

        {{-- Topbar --}}
        <div class="hg-topbar">
            <div class="hg-topbar-left"><b>{{ $products->count() }}</b> products in Home &amp; Garden</div>
            <div class="hg-topbar-right">
                Sort by:
                <select onchange="window.location.href=this.value">
                    <option value="{{ route('home-garden', array_merge(request()->all(),['sort'=>'featured'])) }}"    {{ $activeSort=='featured'   ? 'selected':'' }}>Featured</option>
                    <option value="{{ route('home-garden', array_merge(request()->all(),['sort'=>'newest'])) }}"     {{ $activeSort=='newest'     ? 'selected':'' }}>Newest Arrivals</option>
                    <option value="{{ route('home-garden', array_merge(request()->all(),['sort'=>'price_asc'])) }}"  {{ $activeSort=='price_asc'  ? 'selected':'' }}>Price: Low to High</option>
                    <option value="{{ route('home-garden', array_merge(request()->all(),['sort'=>'price_desc'])) }}" {{ $activeSort=='price_desc' ? 'selected':'' }}>Price: High to Low</option>
                    <option value="{{ route('home-garden', array_merge(request()->all(),['sort'=>'rating'])) }}"     {{ $activeSort=='rating'     ? 'selected':'' }}>Avg. Customer Review</option>
                    <option value="{{ route('home-garden', array_merge(request()->all(),['sort'=>'discount'])) }}"   {{ $activeSort=='discount'   ? 'selected':'' }}>Biggest Discount</option>
                </select>
            </div>
        </div>

        {{-- Grid --}}
        @if($products->isEmpty())
        <div class="hg-empty">
            <div style="font-size:64px;margin-bottom:14px;">🏡</div>
            <h3 style="font-size:18px;font-weight:700;margin-bottom:8px;">No products found</h3>
            <p style="font-size:14px;color:#555;margin-bottom:14px;">Try adjusting your filters or browse all rooms.</p>
            <a href="{{ route('home-garden') }}" style="color:#007185;font-size:13px;">Clear all filters</a>
        </div>
        @else
        <div class="hg-grid">
            @foreach($products as $product)
            @php
                $disc      = hgDisc($product->id, $discounts);
                $saveAmt   = round($product->price * $disc / 100, 2);
                $afterP    = round($product->price - $saveAmt, 2);
                $badgeType = $badgeTypes[$product->id % count($badgeTypes)];
                $badgeText = $badgeLabels[$badgeType];
                $pRating   = $ratings[$product->id % count($ratings)];
                $pReviews  = $reviews[$product->id % count($reviews)];
                $freeShip  = $isFreeShip[$product->id % count($isFreeShip)];
                $prime     = $isPrime[$product->id % count($isPrime)];
                $eco       = $isEco[$product->id % count($isEco)];
                $lowStock  = $isLowStock[$product->id % count($isLowStock)];
                $roomIdx   = $product->id % count($rooms);
                $roomName  = $rooms[$roomIdx];
                $roomEmoji = $roomEmojis[$roomIdx];
                $specs     = $specsByRoom[$roomIdx];
                $brandName = $product->brand ? $product->brand->name : ($hgBrands[$product->id % count($hgBrands)]);
                $imgs      = collect($product->images ?? [])->filter()->values();
                $thumb     = $imgs->first() ? \Illuminate\Support\Facades\Storage::url($imgs->first()) : null;
            @endphp
            <div class="hg-card {{ $eco ? 'has-ribbon' : '' }}" onclick="window.location='{{ route('products.show', $product->slug) }}'">

                @if($eco)
                <div class="hg-eco-ribbon">
                    🌿 Eco-Friendly Choice
                </div>
                @endif

                <div class="hg-disc-badge">-{{ $disc }}%</div>
                <div class="hg-type-badge {{ $badgeType }}">{{ $badgeText }}</div>

                <div class="hg-card-img">
                    @if($thumb)
                        <img src="{{ $thumb }}" alt="{{ $product->name }}" loading="lazy" />
                    @else
                        <div style="font-size:52px;opacity:.3;">{{ $roomEmoji }}</div>
                    @endif
                </div>

                <button class="hg-wish-btn" onclick="event.stopPropagation(); hgToggleWish(this)" title="Save">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#CC0C39" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                </button>

                <div class="hg-card-body">
                    <div class="hg-card-room">{{ $roomEmoji }} {{ $roomName }}</div>
                    <div class="hg-card-brand">{{ $brandName }}</div>
                    <div class="hg-card-name">{{ $product->name }}</div>

                    <div class="hg-stars">
                        {!! hgStars($pRating) !!}
                        <span>{{ $pRating }} ({{ number_format($pReviews) }})</span>
                    </div>

                    <div class="hg-price-row">
                        <span class="hg-price"><sup>$</sup>{{ number_format($afterP, 2) }}</span>
                        <span class="hg-was">Was: <s>${{ number_format($product->price, 2) }}</s></span>
                    </div>
                    <span class="hg-save-pill">Save ${{ number_format($saveAmt, 2) }} ({{ $disc }}%)</span>

                    <div class="hg-spec-tags">
                        @foreach($specs as $s) <span class="hg-spec-tag">{{ $s }}</span> @endforeach
                        @if($eco)      <span class="hg-spec-tag eco">🌿 Eco</span> @endif
                        @if($prime)    <span class="hg-spec-tag prime">Prime</span> @endif
                        @if($freeShip) <span class="hg-spec-tag free">Free Ship</span> @endif
                        @if($lowStock) <span class="hg-spec-tag low">Low Stock</span> @endif
                    </div>

                    <div class="hg-card-actions">
                        <a href="{{ route('products.show', $product->slug) }}" class="hg-add-btn" onclick="event.stopPropagation();">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            Add to Cart
                        </a>
                        <button class="hg-wish-btn2" onclick="event.stopPropagation(); hgToggleWish(this)" title="Save to list">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Room inspiration section --}}
        <div class="hg-room-inspiration" id="hg-inspiration">
            <h3>
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Shop by Room
            </h3>
            <div class="hg-inspo-grid">
                @foreach($rooms as $i => $room)
                @php
                    $colors = ['#fff4e0','#f0fff4','#fff0f8','#f0f8ff','#f5fff0','#f8f0ff','#fff8f0','#f0f0ff'];
                @endphp
                <a href="{{ route('home-garden',['room'=>strtolower(str_replace(' ','-',$room))]) }}" class="hg-inspo-room">
                    <div class="hg-inspo-room-bg" style="background:{{ $colors[$i % count($colors)] }};">
                        {{ $roomEmojis[$i] }}
                    </div>
                    <div class="hg-inspo-room-label">
                        <h4>{{ $room }}</h4>
                        <span>Shop {{ $room }} →</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Seasonal tips --}}
        <div class="hg-tips">
            <h3>
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Home & Garden Tips
            </h3>
            <div class="hg-tips-grid">
                <div class="hg-tip-card">
                    <div class="hg-tip-icon">🌱</div>
                    <div>
                        <h4>Spring Planting</h4>
                        <p>Start seeds indoors 6–8 weeks before the last frost. Use quality potting soil and good drainage.</p>
                    </div>
                </div>
                <div class="hg-tip-card">
                    <div class="hg-tip-icon">🛋️</div>
                    <div>
                        <h4>Furniture Care</h4>
                        <p>Protect wood furniture with wax or oil treatments every 6 months to preserve finish and extend life.</p>
                    </div>
                </div>
                <div class="hg-tip-card">
                    <div class="hg-tip-icon">💡</div>
                    <div>
                        <h4>Lighting Tips</h4>
                        <p>Layer lighting with ambient, task and accent sources for a cosy and functional room atmosphere.</p>
                    </div>
                </div>
                <div class="hg-tip-card">
                    <div class="hg-tip-icon">🌿</div>
                    <div>
                        <h4>Indoor Plants</h4>
                        <p>Snake plants and pothos thrive in low light and are near-impossible to over-water — perfect for beginners.</p>
                    </div>
                </div>
                <div class="hg-tip-card">
                    <div class="hg-tip-icon">🔧</div>
                    <div>
                        <h4>DIY Maintenance</h4>
                        <p>Check weather stripping on doors and windows every spring to improve insulation and reduce energy bills.</p>
                    </div>
                </div>
                <div class="hg-tip-card">
                    <div class="hg-tip-icon">♻️</div>
                    <div>
                        <h4>Go Eco</h4>
                        <p>Choose products with recycled materials or sustainable certifications to reduce your home's carbon footprint.</p>
                    </div>
                </div>
            </div>
        </div>

        @endif
    </div>
</div>
</div>

<script>
function hgToggleWish(btn) {
    btn.classList.toggle('saved');
    const svg = btn.querySelector('svg');
    const saved = btn.classList.contains('saved');
    svg.setAttribute('fill', saved ? '#CC0C39' : 'none');
    hgToast(saved ? '❤️ Saved to Wish List' : 'Removed from Wish List');
}

function hgApplyPrice() {
    const min = document.getElementById('hg-min').value;
    const max = document.getElementById('hg-max').value;
    const url = new URL(window.location.href);
    if (min) url.searchParams.set('min_price', min);
    else url.searchParams.delete('min_price');
    if (max) url.searchParams.set('max_price', max);
    else url.searchParams.delete('max_price');
    window.location.href = url.toString();
}

function hgToast(msg) {
    let t = document.getElementById('hgToast');
    if (!t) {
        t = document.createElement('div');
        t.id = 'hgToast';
        t.style.cssText = 'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#131921;color:#FF9900;padding:11px 22px;border-radius:6px;font-size:13px;z-index:99999;box-shadow:0 4px 16px rgba(0,0,0,.3);transition:opacity .3s;white-space:nowrap;font-weight:600;';
        document.body.appendChild(t);
    }
    t.textContent = msg;
    t.style.opacity = '1';
    clearTimeout(t._t);
    t._t = setTimeout(() => { t.style.opacity = '0'; }, 2500);
}
</script>
@endsection
