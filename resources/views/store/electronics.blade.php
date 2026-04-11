@extends('store.layout')
@section('title', 'Electronics — MyShop')

@section('head')
<style>
    /* ── Page ───────────────────────────────────────── */
    .el-page { background: #EAEDED; min-height: 80vh; }

    /* ── Hero ───────────────────────────────────────── */
    .el-hero { background: linear-gradient(115deg,#131921 0%,#1a1a2e 55%,#16213e 100%); padding: 28px 18px; position: relative; overflow: hidden; }
    .el-hero::before { content:''; position:absolute; right:-60px; top:-60px; width:300px; height:300px; background:rgba(255,153,0,.07); border-radius:50%; pointer-events:none; }
    .el-hero::after  { content:''; position:absolute; left:40%; bottom:-80px; width:240px; height:240px; background:rgba(255,153,0,.04); border-radius:50%; pointer-events:none; }
    .el-hero-inner { max-width:1340px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; gap:20px; flex-wrap:wrap; position:relative; z-index:1; }
    .el-hero-eyebrow { display:inline-flex; align-items:center; gap:6px; background:rgba(255,153,0,.15); border:1px solid rgba(255,153,0,.4); border-radius:20px; padding:4px 14px; font-size:12px; color:#FF9900; font-weight:700; letter-spacing:.5px; margin-bottom:10px; text-transform:uppercase; }
    .el-hero-left h1 { font-size:32px; font-weight:900; color:#fff; margin:0 0 8px; line-height:1.15; }
    .el-hero-left h1 span { color:#FF9900; }
    .el-hero-left p { font-size:13px; color:#adbac7; margin:0 0 18px; max-width:480px; line-height:1.6; }
    .el-hero-btns { display:flex; gap:10px; flex-wrap:wrap; }
    .el-hero-btn { display:inline-flex; align-items:center; gap:7px; border-radius:6px; padding:10px 20px; font-size:13px; font-weight:700; cursor:pointer; text-decoration:none; transition:all .12s; }
    .el-hero-btn.primary { background:#FFD814; border:1px solid #FCD200; color:#131921; }
    .el-hero-btn.primary:hover { background:#F7CA00; color:#131921; }
    .el-hero-btn.secondary { background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.25); color:#fff; }
    .el-hero-btn.secondary:hover { background:rgba(255,255,255,.18); color:#fff; }
    .el-hero-stats { display:flex; gap:12px; flex-wrap:wrap; }
    .el-stat { text-align:center; background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.12); border-radius:10px; padding:14px 18px; min-width:76px; }
    .el-stat-num { font-size:22px; font-weight:900; color:#FF9900; line-height:1; }
    .el-stat-label { font-size:10px; color:#adbac7; text-transform:uppercase; letter-spacing:.5px; margin-top:4px; }

    /* ── Subcategory nav ─────────────────────────────── */
    .el-subcat-bar { background:#fff; border-bottom:1px solid #e3e6e6; }
    .el-subcat-inner { max-width:1340px; margin:0 auto; padding:14px 18px; display:flex; gap:10px; overflow-x:auto; scrollbar-width:none; flex-wrap:nowrap; }
    .el-subcat-inner::-webkit-scrollbar { display:none; }
    .el-subcat-chip { flex-shrink:0; display:flex; flex-direction:column; align-items:center; gap:6px; padding:10px 16px; border:1px solid #e3e6e6; border-radius:10px; cursor:pointer; text-decoration:none; transition:all .15s; background:#fff; min-width:80px; }
    .el-subcat-chip:hover { border-color:#FF9900; background:#fff8ee; }
    .el-subcat-chip.active { border-color:#FF9900; background:#fff4e0; box-shadow:0 0 0 2px rgba(255,153,0,.15); }
    .el-subcat-chip-icon { font-size:24px; line-height:1; }
    .el-subcat-chip-label { font-size:11px; font-weight:600; color:#0F1111; white-space:nowrap; }
    .el-subcat-chip.active .el-subcat-chip-label { color:#C7511F; }

    /* ── Breadcrumb ──────────────────────────────────── */
    .el-breadcrumb { max-width:1340px; margin:0 auto; padding:10px 18px; font-size:13px; color:#555; }
    .el-breadcrumb a { color:#007185; }
    .el-breadcrumb a:hover { color:#C7511F; text-decoration:underline; }

    /* ── Featured brands ─────────────────────────────── */
    .el-brands-bar { background:#fff; border-bottom:1px solid #e3e6e6; }
    .el-brands-inner { max-width:1340px; margin:0 auto; padding:12px 18px; display:flex; align-items:center; gap:6px; overflow-x:auto; scrollbar-width:none; }
    .el-brands-inner::-webkit-scrollbar { display:none; }
    .el-brands-label { font-size:12px; font-weight:700; color:#555; white-space:nowrap; flex-shrink:0; margin-right:6px; }
    .el-brand-pill { flex-shrink:0; display:inline-flex; align-items:center; gap:5px; padding:5px 14px; border:1px solid #d5d9d9; border-radius:20px; font-size:12px; font-weight:600; color:#0F1111; cursor:pointer; text-decoration:none; background:#fff; transition:all .12s; }
    .el-brand-pill:hover { border-color:#FF9900; color:#C7511F; background:#fff8ee; }
    .el-brand-pill.active { background:#131921; color:#FF9900; border-color:#131921; }

    /* ── Filter tabs ─────────────────────────────────── */
    .el-tabs-wrap { background:#fff; border-bottom:2px solid #e3e6e6; }
    .el-tabs { max-width:1340px; margin:0 auto; padding:0 18px; display:flex; overflow-x:auto; scrollbar-width:none; }
    .el-tabs::-webkit-scrollbar { display:none; }
    .el-tab { display:inline-flex; align-items:center; gap:6px; padding:12px 18px; font-size:13px; font-weight:500; color:#555; white-space:nowrap; border-bottom:3px solid transparent; cursor:pointer; text-decoration:none; transition:color .12s,border-color .12s; flex-shrink:0; }
    .el-tab:hover { color:#C7511F; border-bottom-color:#FF9900; }
    .el-tab.active { color:#C7511F; border-bottom-color:#FF9900; font-weight:700; }
    .el-tab-count { background:#FF9900; color:#131921; font-size:10px; font-weight:800; border-radius:99px; padding:1px 7px; }

    /* ── Flash deal strip ────────────────────────────── */
    .el-flash { background:linear-gradient(90deg,#CC0C39,#a50a2d); padding:10px 18px; }
    .el-flash-inner { max-width:1340px; margin:0 auto; display:flex; align-items:center; gap:14px; flex-wrap:wrap; }
    .el-flash-label { display:flex; align-items:center; gap:7px; font-size:13px; font-weight:800; color:#fff; white-space:nowrap; }
    .el-flash-timer { display:flex; align-items:center; gap:5px; }
    .el-flash-seg { background:rgba(0,0,0,.3); color:#fff; font-size:14px; font-weight:900; border-radius:4px; padding:4px 8px; min-width:32px; text-align:center; font-family:monospace; }
    .el-flash-sep { color:rgba(255,255,255,.7); font-weight:700; font-size:14px; }
    .el-flash-products { display:flex; gap:8px; overflow-x:auto; scrollbar-width:none; flex:1; }
    .el-flash-products::-webkit-scrollbar { display:none; }
    .el-flash-item { flex-shrink:0; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.2); border-radius:8px; padding:8px 12px; display:flex; align-items:center; gap:8px; cursor:pointer; text-decoration:none; transition:background .12s; }
    .el-flash-item:hover { background:rgba(255,255,255,.2); }
    .el-flash-item-name { font-size:11px; color:#fff; font-weight:600; max-width:100px; overflow:hidden; white-space:nowrap; text-overflow:ellipsis; }
    .el-flash-item-disc { font-size:12px; color:#FFD814; font-weight:900; }

    /* ── Layout ──────────────────────────────────────── */
    .el-wrap { max-width:1340px; margin:0 auto; padding:20px 18px 50px; display:flex; gap:20px; align-items:flex-start; }

    /* ── Sidebar ─────────────────────────────────────── */
    .el-sidebar { width:210px; flex-shrink:0; }
    .el-sb-box { background:#fff; border:1px solid #e3e6e6; border-radius:8px; overflow:hidden; margin-bottom:14px; }
    .el-sb-head { font-size:14px; font-weight:700; color:#0F1111; padding:12px 16px 10px; border-bottom:1px solid #f0f2f2; background:#f7f8f8; display:flex; align-items:center; gap:7px; }
    .el-sb-body { padding:8px 0; }
    .el-sb-item { display:flex; align-items:center; gap:9px; padding:8px 16px; font-size:13px; color:#0F1111; cursor:pointer; text-decoration:none; transition:background .1s; border-left:3px solid transparent; }
    .el-sb-item:hover { background:#fff8ee; border-left-color:#FF9900; color:#C7511F; }
    .el-sb-item.active { background:#fff4e0; border-left-color:#FF9900; font-weight:700; color:#C7511F; }
    .el-sb-item input[type=radio],
    .el-sb-item input[type=checkbox] { accent-color:#FF9900; width:14px; height:14px; flex-shrink:0; }
    .el-sb-item-count { margin-left:auto; font-size:11px; color:#888; background:#f0f2f2; border-radius:99px; padding:1px 7px; }

    /* Price range */
    .el-price-inputs { display:flex; gap:6px; align-items:center; padding:10px 16px; }
    .el-price-inputs input { width:60px; border:1px solid #d5d9d9; border-radius:4px; padding:5px 6px; font-size:12px; outline:none; }
    .el-price-inputs input:focus { border-color:#FF9900; box-shadow:0 0 0 2px rgba(255,153,0,.15); }
    .el-price-inputs span { font-size:12px; color:#555; }
    .el-price-go { background:#FF9900; color:#131921; border:none; border-radius:4px; padding:5px 10px; font-size:12px; font-weight:700; cursor:pointer; }

    /* ── Main ────────────────────────────────────────── */
    .el-main { flex:1; min-width:0; }

    /* Promo banners row */
    .el-promos { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:12px; margin-bottom:20px; }
    .el-promo-card { border-radius:10px; padding:18px; display:flex; flex-direction:column; gap:8px; position:relative; overflow:hidden; cursor:pointer; transition:transform .15s,box-shadow .15s; text-decoration:none; }
    .el-promo-card:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,.15); }
    .el-promo-card h4 { font-size:14px; font-weight:800; margin:0; }
    .el-promo-card p { font-size:12px; margin:0; opacity:.9; line-height:1.4; }
    .el-promo-card span { font-size:11px; font-weight:700; margin-top:4px; }
    .el-promo-1 { background:linear-gradient(135deg,#131921,#1a2a3a); color:#fff; }
    .el-promo-1 h4 { color:#FF9900; }
    .el-promo-1 span { color:#FFD814; }
    .el-promo-2 { background:linear-gradient(135deg,#CC0C39,#a50a2d); color:#fff; }
    .el-promo-2 span { color:#FFD814; }
    .el-promo-3 { background:linear-gradient(135deg,#007185,#005a6a); color:#fff; }
    .el-promo-3 span { color:#FFD814; }
    .el-promo-4 { background:linear-gradient(135deg,#007600,#005a00); color:#fff; }
    .el-promo-4 span { color:#FFD814; }
    .el-promo-icon { position:absolute; right:12px; top:50%; transform:translateY(-50%); font-size:40px; opacity:.25; }

    /* Topbar */
    .el-topbar { display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; flex-wrap:wrap; gap:10px; }
    .el-topbar-left { font-size:14px; color:#555; }
    .el-topbar-left b { color:#0F1111; }
    .el-topbar-right { display:flex; align-items:center; gap:8px; font-size:13px; color:#555; }
    .el-topbar-right select { border:1px solid #d5d9d9; border-radius:6px; padding:6px 10px; font-size:13px; background:#fff; cursor:pointer; outline:none; }

    /* ── Product grid ────────────────────────────────── */
    .el-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(210px,1fr)); gap:14px; }

    /* ── Product card ────────────────────────────────── */
    .el-card { background:#fff; border:1px solid #e3e6e6; border-radius:8px; overflow:hidden; display:flex; flex-direction:column; position:relative; transition:box-shadow .15s,border-color .15s; cursor:pointer; }
    .el-card:hover { box-shadow:0 4px 20px rgba(0,0,0,.12); border-color:#FF9900; }

    /* Badges */
    .el-card-disc { position:absolute; top:8px; left:8px; background:#CC0C39; color:#fff; font-size:12px; font-weight:900; border-radius:4px; padding:3px 8px; z-index:3; }
    .el-card-badge { position:absolute; top:8px; right:8px; border-radius:4px; padding:3px 8px; font-size:10px; font-weight:800; z-index:3; }
    .el-card-badge.deal { background:#131921; color:#FF9900; }
    .el-card-badge.new { background:#007600; color:#fff; }
    .el-card-badge.hot { background:#CC0C39; color:#fff; }
    .el-card-badge.sale { background:#FF9900; color:#131921; }

    /* Image */
    .el-card-img { background:#f7f8f8; aspect-ratio:1/1; display:flex; align-items:center; justify-content:center; overflow:hidden; }
    .el-card-img img { max-width:80%; max-height:80%; object-fit:contain; transition:transform .2s; }
    .el-card:hover .el-card-img img { transform:scale(1.05); }

    /* Wishlist */
    .el-wish-btn { position:absolute; bottom:8px; right:8px; width:28px; height:28px; border-radius:50%; background:rgba(255,255,255,.9); border:1px solid #e3e6e6; display:flex; align-items:center; justify-content:center; z-index:3; cursor:pointer; transition:all .12s; }
    .el-wish-btn:hover { background:#fff; border-color:#CC0C39; }
    .el-wish-btn.saved svg { fill:#CC0C39; stroke:#CC0C39; }

    /* Body */
    .el-card-body { padding:12px 12px 14px; flex:1; display:flex; flex-direction:column; gap:4px; }
    .el-card-brand { font-size:11px; color:#C7511F; font-weight:700; text-transform:uppercase; letter-spacing:.3px; }
    .el-card-name { font-size:13px; color:#0F1111; line-height:1.4; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; }

    /* Stars */
    .el-card-stars { display:flex; align-items:center; gap:2px; }
    .el-card-stars span { font-size:11px; color:#555; margin-left:3px; }

    /* Price */
    .el-card-price-row { display:flex; align-items:baseline; gap:6px; margin-top:4px; flex-wrap:wrap; }
    .el-card-price { font-size:20px; font-weight:900; color:#B12704; }
    .el-card-price sup { font-size:12px; vertical-align:super; }
    .el-card-was { font-size:12px; color:#888; }
    .el-card-was s { color:#aaa; }
    .el-save-pill { font-size:11px; background:#fff4e0; color:#C7511F; border:1px solid #FFD580; border-radius:4px; padding:2px 6px; font-weight:700; display:inline-block; }

    /* Spec tags */
    .el-spec-tags { display:flex; gap:4px; flex-wrap:wrap; margin-top:4px; }
    .el-spec-tag { font-size:10px; background:#f0f2f2; color:#555; border-radius:4px; padding:2px 7px; font-weight:500; }
    .el-spec-tag.prime { background:#fff4e0; color:#C7511F; font-weight:700; }
    .el-spec-tag.free  { background:#F0FFF4; color:#007600; }
    .el-spec-tag.stock { background:#FFF0F0; color:#CC0C39; font-weight:700; }

    /* Stock bar */
    .el-stock-bar-wrap { margin-top:6px; }
    .el-stock-bar-label { font-size:10px; color:#C7511F; font-weight:700; margin-bottom:3px; }
    .el-stock-bar { height:4px; background:#f0f2f2; border-radius:99px; overflow:hidden; }
    .el-stock-fill { height:100%; background:linear-gradient(90deg,#FF9900,#CC0C39); border-radius:99px; }

    /* Add to cart */
    .el-card-actions { display:flex; gap:6px; margin-top:8px; }
    .el-add-btn { flex:1; display:flex; align-items:center; justify-content:center; gap:5px; background:#FFD814; border:1px solid #FCD200; border-radius:20px; padding:8px; font-size:12px; font-weight:700; color:#131921; cursor:pointer; text-decoration:none; transition:background .12s; }
    .el-add-btn:hover { background:#F7CA00; color:#131921; }
    .el-compare-btn { width:36px; flex-shrink:0; display:flex; align-items:center; justify-content:center; background:#fff; border:1px solid #d5d9d9; border-radius:20px; cursor:pointer; color:#555; transition:all .12s; font-size:10px; font-weight:700; }
    .el-compare-btn:hover { border-color:#FF9900; color:#C7511F; background:#fff8ee; }

    /* ── Section heading ─────────────────────────────── */
    .el-section-head { display:flex; align-items:center; justify-content:space-between; margin:24px 0 14px; }
    .el-section-head h3 { font-size:16px; font-weight:700; color:#0F1111; margin:0; display:flex; align-items:center; gap:8px; border-left:4px solid #FF9900; padding-left:10px; }
    .el-section-head a { font-size:13px; color:#007185; text-decoration:none; }
    .el-section-head a:hover { color:#C7511F; text-decoration:underline; }

    /* ── Buying guide ────────────────────────────────── */
    .el-guide { background:#fff; border:1px solid #e3e6e6; border-radius:8px; padding:20px; margin-top:24px; }
    .el-guide h3 { font-size:16px; font-weight:700; color:#0F1111; margin:0 0 16px; border-bottom:2px solid #FF9900; padding-bottom:10px; display:flex; align-items:center; gap:8px; }
    .el-guide-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:12px; }
    .el-guide-card { background:#f7f8f8; border-radius:8px; padding:14px; text-align:center; }
    .el-guide-card-icon { font-size:28px; margin-bottom:8px; }
    .el-guide-card h4 { font-size:12px; font-weight:700; color:#0F1111; margin:0 0 4px; }
    .el-guide-card p { font-size:11px; color:#555; margin:0; line-height:1.5; }

    /* ── Empty ───────────────────────────────────────── */
    .el-empty { text-align:center; padding:60px 20px; background:#fff; border-radius:8px; border:1px solid #e3e6e6; }

    @media (max-width:760px) {
        .el-wrap { flex-direction:column; }
        .el-sidebar { width:100%; }
        .el-grid { grid-template-columns:repeat(2,1fr); }
        .el-hero-inner { flex-direction:column; }
        .el-promos { grid-template-columns:repeat(2,1fr); }
    }
    @media (max-width:480px) {
        .el-grid { grid-template-columns:1fr; }
        .el-promos { grid-template-columns:1fr; }
    }
</style>
@endsection

@section('content')
@php
    /* ── Helpers ─────────────────────────────────── */
    $discounts  = [8,12,15,18,20,22,25,28,30,35,40,45];
    $badgeTypes = ['deal','new','hot','sale','deal','new'];
    $badgeLabels= ['deal'=>'Limited Deal','new'=>'New Arrival','hot'=>'Best Seller','sale'=>'On Sale'];
    $ratings    = [3.8,4.0,4.2,4.4,4.5,4.6,4.7,4.8,4.9,5.0,4.1,4.3];
    $reviews    = [28,56,102,188,320,480,960,1240,72,144,234,410];
    $stockPct   = [85,70,55,40,30,20,15,60,90,45,75,50];
    $isLowStock = [false,false,true,false,true,true,false,false,true,false,false,true];
    $isFreeShip = [true,false,true,true,false,true,true,false,true,false,true,false];
    $isPrime    = [true,true,false,true,true,false,true,false,true,true,false,true];
    $specsTags  = [
        ['4K UHD','HDR10','Smart'],['64MP','5G','128GB'],['i7','16GB RAM','SSD'],
        ['Wireless','ANC','30hr'],['4K@60fps','Stabilized','HDR'],['OLED','120Hz','5G'],
        ['USB-C','Fast Charge','10000mAh'],['Mechanical','RGB','TKL'],
    ];
    $subcats = [
        ['icon'=>'📱','label'=>'Smartphones'],['icon'=>'💻','label'=>'Laptops'],
        ['icon'=>'📺','label'=>'TVs'],['icon'=>'🎧','label'=>'Audio'],
        ['icon'=>'📷','label'=>'Cameras'],['icon'=>'⌨️','label'=>'Gaming'],
        ['icon'=>'⌚','label'=>'Wearables'],['icon'=>'🖨️','label'=>'Printers'],
        ['icon'=>'🔌','label'=>'Accessories'],['icon'=>'🔋','label'=>'Power Banks'],
    ];
    $elBrands = ['Apple','Samsung','Sony','LG','Dell','HP','Bose','Canon','Nikon','Logitech','JBL','Lenovo'];

    function elDisc($id,$arr){ return $arr[$id % count($arr)]; }
    function elStars($r){
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
    $activeSubcat= request('subcat');
@endphp

<div class="el-page">

{{-- Hero --}}
<div class="el-hero">
    <div class="el-hero-inner">
        <div class="el-hero-left">
            <div class="el-hero-eyebrow">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                Tech & Electronics
            </div>
            <h1>Shop <span>Electronics</span></h1>
            <p>Discover the latest smartphones, laptops, TVs, audio, cameras, and more — all with great deals and fast delivery.</p>
            <div class="el-hero-btns">
                <a href="#el-listings" class="el-hero-btn primary">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Browse All Electronics
                </a>
                <a href="{{ route('products.index', ['q'=>'Electronics', 'sort'=>'price_asc']) }}" class="el-hero-btn secondary">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    Today's Best Prices
                </a>
            </div>
        </div>
        <div class="el-hero-stats">
            <div class="el-stat">
                <div class="el-stat-num">{{ $products->count() }}+</div>
                <div class="el-stat-label">Products</div>
            </div>
            <div class="el-stat">
                <div class="el-stat-num">{{ $brands->count() }}</div>
                <div class="el-stat-label">Top Brands</div>
            </div>
            <div class="el-stat">
                <div class="el-stat-num">45%</div>
                <div class="el-stat-label">Max Off</div>
            </div>
            <div class="el-stat">
                <div class="el-stat-num">FREE</div>
                <div class="el-stat-label">Shipping</div>
            </div>
        </div>
    </div>
</div>

{{-- Subcategory chips --}}
<div class="el-subcat-bar">
    <div class="el-subcat-inner">
        <a href="{{ route('electronics') }}" class="el-subcat-chip {{ !$activeSubcat ? 'active' : '' }}">
            <span class="el-subcat-chip-icon">🖥️</span>
            <span class="el-subcat-chip-label">All</span>
        </a>
        @foreach($subcats as $sc)
        <a href="{{ route('electronics', ['subcat'=>strtolower($sc['label'])]) }}" class="el-subcat-chip {{ $activeSubcat==strtolower($sc['label']) ? 'active' : '' }}">
            <span class="el-subcat-chip-icon">{{ $sc['icon'] }}</span>
            <span class="el-subcat-chip-label">{{ $sc['label'] }}</span>
        </a>
        @endforeach
    </div>
</div>

{{-- Featured brands --}}
<div class="el-brands-bar">
    <div class="el-brands-inner">
        <span class="el-brands-label">Top Brands:</span>
        <a href="{{ route('electronics') }}" class="el-brand-pill {{ !$activeBrand ? 'active' : '' }}">All</a>
        @foreach($elBrands as $b)
        <a href="{{ route('electronics', ['brand_name'=>$b]) }}" class="el-brand-pill {{ request('brand_name')==$b ? 'active' : '' }}">{{ $b }}</a>
        @endforeach
        @foreach($brands->take(6) as $brand)
        <a href="{{ route('electronics', array_merge(request()->except('brand'),['brand'=>$brand->id])) }}" class="el-brand-pill {{ $activeBrand==$brand->id ? 'active' : '' }}">{{ $brand->name }}</a>
        @endforeach
    </div>
</div>

{{-- Filter tabs --}}
<div class="el-tabs-wrap">
    <div class="el-tabs">
        <a href="{{ route('electronics') }}" class="el-tab {{ $activeTab=='all' ? 'active' : '' }}">
            All Electronics <span class="el-tab-count">{{ $products->count() }}</span>
        </a>
        <a href="{{ route('electronics', ['tab'=>'deals']) }}" class="el-tab {{ $activeTab=='deals' ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
            Today's Deals
        </a>
        <a href="{{ route('electronics', ['tab'=>'new']) }}" class="el-tab {{ $activeTab=='new' ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            New Arrivals
        </a>
        <a href="{{ route('electronics', ['tab'=>'bestseller']) }}" class="el-tab {{ $activeTab=='bestseller' ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            Best Sellers
        </a>
        <a href="{{ route('electronics', ['tab'=>'toprated']) }}" class="el-tab {{ $activeTab=='toprated' ? 'active' : '' }}">
            Top Rated
        </a>
        <a href="{{ route('electronics', ['tab'=>'prime']) }}" class="el-tab {{ $activeTab=='prime' ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            Prime
        </a>
        @foreach($categories->take(5) as $cat)
        <a href="{{ route('electronics', ['category'=>$cat->id]) }}" class="el-tab {{ $activeCat==$cat->id ? 'active' : '' }}">
            {{ $cat->name }}
        </a>
        @endforeach
    </div>
</div>

{{-- Flash sale strip --}}
<div class="el-flash">
    <div class="el-flash-inner">
        <div class="el-flash-label">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="#FFD814" stroke="none"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
            Flash Sale — Ends in:
        </div>
        <div class="el-flash-timer">
            <span class="el-flash-seg" id="el-h">00</span>
            <span class="el-flash-sep">:</span>
            <span class="el-flash-seg" id="el-m">00</span>
            <span class="el-flash-sep">:</span>
            <span class="el-flash-seg" id="el-s">00</span>
        </div>
        <div class="el-flash-products">
            @foreach($products->take(6) as $fp)
            @php $fd = elDisc($fp->id, $discounts); @endphp
            <a href="{{ route('products.show', $fp->slug) }}" class="el-flash-item">
                <div>
                    <div class="el-flash-item-name">{{ $fp->name }}</div>
                    <div class="el-flash-item-disc">-{{ $fd }}% OFF</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>

{{-- Breadcrumb --}}
<div style="background:#fff;border-bottom:1px solid #e3e6e6;">
    <div class="el-breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span> › </span>
        <span style="color:#0F1111;">Electronics</span>
        @if($activeSubcat)<span> › </span><span style="color:#0F1111;text-transform:capitalize;">{{ $activeSubcat }}</span>@endif
    </div>
</div>

{{-- Body --}}
<div class="el-wrap">

    {{-- SIDEBAR --}}
    <div class="el-sidebar">

        {{-- Subcategory --}}
        <div class="el-sb-box">
            <div class="el-sb-head">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                Category
            </div>
            <div class="el-sb-body">
                <a href="{{ route('electronics') }}" class="el-sb-item {{ !$activeCat && !$activeSubcat ? 'active' : '' }}">
                    <input type="radio" {{ !$activeCat && !$activeSubcat ? 'checked' : '' }} readonly /> All Electronics
                </a>
                @foreach($subcats as $sc)
                <a href="{{ route('electronics', ['subcat'=>strtolower($sc['label'])]) }}" class="el-sb-item {{ $activeSubcat==strtolower($sc['label']) ? 'active' : '' }}">
                    <input type="radio" {{ $activeSubcat==strtolower($sc['label']) ? 'checked' : '' }} readonly />
                    {{ $sc['icon'] }} {{ $sc['label'] }}
                </a>
                @endforeach
                @foreach($categories as $cat)
                <a href="{{ route('electronics', array_merge(request()->except('category'),['category'=>$cat->id])) }}" class="el-sb-item {{ $activeCat==$cat->id ? 'active' : '' }}">
                    <input type="radio" {{ $activeCat==$cat->id ? 'checked' : '' }} readonly />
                    {{ $cat->name }}
                    <span class="el-sb-item-count">{{ rand(2,40) }}</span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Brand --}}
        @if($brands->isNotEmpty())
        <div class="el-sb-box">
            <div class="el-sb-head">Brand</div>
            <div class="el-sb-body">
                <a href="{{ route('electronics', request()->except('brand')) }}" class="el-sb-item {{ !$activeBrand ? 'active' : '' }}">
                    <input type="radio" {{ !$activeBrand ? 'checked' : '' }} readonly /> All Brands
                </a>
                @foreach($brands->take(12) as $brand)
                <a href="{{ route('electronics', array_merge(request()->except('brand'),['brand'=>$brand->id])) }}" class="el-sb-item {{ $activeBrand==$brand->id ? 'active' : '' }}">
                    <input type="radio" {{ $activeBrand==$brand->id ? 'checked' : '' }} readonly />
                    {{ $brand->name }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Customer rating --}}
        <div class="el-sb-box">
            <div class="el-sb-head">Customer Rating</div>
            <div class="el-sb-body">
                @foreach(['4'=>'4★ & above','3'=>'3★ & above','2'=>'2★ & above'] as $v=>$lbl)
                <a href="{{ route('electronics', array_merge(request()->except('rating'),['rating'=>$v])) }}" class="el-sb-item {{ request('rating')==$v ? 'active' : '' }}">
                    <input type="radio" {{ request('rating')==$v ? 'checked' : '' }} readonly />
                    {!! elStars((float)$v) !!}&nbsp;{{ $lbl }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Discount --}}
        <div class="el-sb-box">
            <div class="el-sb-head">Discount</div>
            <div class="el-sb-body">
                @foreach(['10'=>'10% or more','20'=>'20% or more','30'=>'30% or more','40'=>'40% or more'] as $v=>$lbl)
                <a href="{{ route('electronics', array_merge(request()->except('min_disc'),['min_disc'=>$v])) }}" class="el-sb-item {{ request('min_disc')==$v ? 'active' : '' }}">
                    <input type="radio" {{ request('min_disc')==$v ? 'checked' : '' }} readonly /> {{ $lbl }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Availability --}}
        <div class="el-sb-box">
            <div class="el-sb-head">Availability</div>
            <div class="el-sb-body">
                @foreach(['all'=>'Include Out of Stock','instock'=>'In Stock Only','prime'=>'Prime Eligible'] as $k=>$lbl)
                <a href="{{ route('electronics', array_merge(request()->except('avail'),['avail'=>$k])) }}" class="el-sb-item {{ (request('avail','instock'))==$k ? 'active' : '' }}">
                    <input type="radio" {{ (request('avail','instock'))==$k ? 'checked' : '' }} readonly /> {{ $lbl }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Price --}}
        <div class="el-sb-box">
            <div class="el-sb-head">Price Range</div>
            <div class="el-price-inputs">
                <input type="number" placeholder="Min" value="{{ request('min_price') }}" id="el-min" />
                <span>—</span>
                <input type="number" placeholder="Max" value="{{ request('max_price') }}" id="el-max" />
                <button class="el-price-go" onclick="elApplyPrice()">Go</button>
            </div>
        </div>

    </div>

    {{-- MAIN --}}
    <div class="el-main" id="el-listings">

        {{-- Promo banners --}}
        <div class="el-promos">
            <a href="{{ route('electronics', ['tab'=>'deals']) }}" class="el-promo-card el-promo-1">
                <div class="el-promo-icon">⚡</div>
                <h4>Flash Deals</h4>
                <p>Limited-time offers on top electronics</p>
                <span>Up to 45% OFF →</span>
            </a>
            <a href="{{ route('electronics', ['tab'=>'new']) }}" class="el-promo-card el-promo-2">
                <div class="el-promo-icon">🆕</div>
                <h4>New Arrivals</h4>
                <p>Just landed — latest tech gear</p>
                <span>Shop Now →</span>
            </a>
            <a href="{{ route('electronics', ['subcat'=>'smartphones']) }}" class="el-promo-card el-promo-3">
                <div class="el-promo-icon">📱</div>
                <h4>Smartphones</h4>
                <p>Top brands, best prices</p>
                <span>View All →</span>
            </a>
            <a href="{{ route('electronics', ['tab'=>'prime']) }}" class="el-promo-card el-promo-4">
                <div class="el-promo-icon">🎯</div>
                <h4>Free Shipping</h4>
                <p>On thousands of electronics</p>
                <span>Prime Deals →</span>
            </a>
        </div>

        {{-- Topbar --}}
        <div class="el-topbar">
            <div class="el-topbar-left"><b>{{ $products->count() }}</b> results for Electronics</div>
            <div class="el-topbar-right">
                Sort by:
                <select onchange="window.location.href=this.value">
                    <option value="{{ route('electronics', array_merge(request()->all(),['sort'=>'featured'])) }}"    {{ $activeSort=='featured'   ? 'selected':'' }}>Featured</option>
                    <option value="{{ route('electronics', array_merge(request()->all(),['sort'=>'newest'])) }}"     {{ $activeSort=='newest'     ? 'selected':'' }}>Newest Arrivals</option>
                    <option value="{{ route('electronics', array_merge(request()->all(),['sort'=>'price_asc'])) }}"  {{ $activeSort=='price_asc'  ? 'selected':'' }}>Price: Low to High</option>
                    <option value="{{ route('electronics', array_merge(request()->all(),['sort'=>'price_desc'])) }}" {{ $activeSort=='price_desc' ? 'selected':'' }}>Price: High to Low</option>
                    <option value="{{ route('electronics', array_merge(request()->all(),['sort'=>'rating'])) }}"     {{ $activeSort=='rating'     ? 'selected':'' }}>Avg. Customer Review</option>
                    <option value="{{ route('electronics', array_merge(request()->all(),['sort'=>'discount'])) }}"   {{ $activeSort=='discount'   ? 'selected':'' }}>Biggest Discount</option>
                </select>
            </div>
        </div>

        {{-- Grid --}}
        @if($products->isEmpty())
        <div class="el-empty">
            <svg width="72" height="72" viewBox="0 0 24 24" fill="none" stroke="#ddd" stroke-width="1" style="margin:0 auto 16px;display:block;"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
            <h3 style="font-size:18px;font-weight:700;margin-bottom:8px;">No electronics found</h3>
            <p style="font-size:14px;color:#555;margin-bottom:14px;">Try adjusting your filters.</p>
            <a href="{{ route('electronics') }}" style="color:#007185;font-size:13px;">Clear all filters</a>
        </div>
        @else
        <div class="el-grid">
            @foreach($products as $product)
            @php
                $disc      = elDisc($product->id, $discounts);
                $saveAmt   = round($product->price * $disc / 100, 2);
                $afterP    = round($product->price - $saveAmt, 2);
                $badgeType = $badgeTypes[$product->id % count($badgeTypes)];
                $badgeText = $badgeLabels[$badgeType];
                $pRating   = $ratings[$product->id % count($ratings)];
                $pReviews  = $reviews[$product->id % count($reviews)];
                $stock     = $stockPct[$product->id % count($stockPct)];
                $lowStock  = $isLowStock[$product->id % count($isLowStock)];
                $freeShip  = $isFreeShip[$product->id % count($isFreeShip)];
                $prime     = $isPrime[$product->id % count($isPrime)];
                $specs     = $specsTags[$product->id % count($specsTags)];
                $brandName = $product->brand ? $product->brand->name : ($elBrands[$product->id % count($elBrands)]);
                $imgs      = collect($product->images ?? [])->filter()->values();
                $thumb     = $imgs->first() ? \Illuminate\Support\Facades\Storage::url($imgs->first()) : null;
            @endphp
            <div class="el-card" onclick="window.location='{{ route('products.show', $product->slug) }}'">

                {{-- Discount badge --}}
                <div class="el-card-disc">-{{ $disc }}%</div>

                {{-- Type badge --}}
                <div class="el-card-badge {{ $badgeType }}">{{ $badgeText }}</div>

                <div class="el-card-img">
                    @if($thumb)
                        <img src="{{ $thumb }}" alt="{{ $product->name }}" loading="lazy" />
                    @else
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#d5d9d9" stroke-width="1"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    @endif
                </div>

                {{-- Wishlist btn --}}
                <button class="el-wish-btn" onclick="event.stopPropagation(); elToggleWish(this)" title="Add to wishlist">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#CC0C39" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                </button>

                <div class="el-card-body">
                    <div class="el-card-brand">{{ $brandName }}</div>
                    <div class="el-card-name">{{ $product->name }}</div>

                    <div class="el-card-stars">
                        {!! elStars($pRating) !!}
                        <span>{{ $pRating }} ({{ number_format($pReviews) }})</span>
                    </div>

                    <div class="el-card-price-row">
                        <span class="el-card-price"><sup>$</sup>{{ number_format($afterP, 2) }}</span>
                        <span class="el-card-was">List: <s>${{ number_format($product->price, 2) }}</s></span>
                    </div>
                    <span class="el-save-pill">Save ${{ number_format($saveAmt, 2) }} ({{ $disc }}%)</span>

                    {{-- Spec tags --}}
                    <div class="el-spec-tags">
                        @foreach($specs as $s)
                        <span class="el-spec-tag">{{ $s }}</span>
                        @endforeach
                        @if($prime)    <span class="el-spec-tag prime">Prime</span> @endif
                        @if($freeShip) <span class="el-spec-tag free">Free Ship</span> @endif
                        @if($lowStock) <span class="el-spec-tag stock">Low Stock</span> @endif
                    </div>

                    {{-- Stock bar --}}
                    @if($lowStock)
                    <div class="el-stock-bar-wrap">
                        <div class="el-stock-bar-label">{{ $stock }}% claimed</div>
                        <div class="el-stock-bar"><div class="el-stock-fill" style="width:{{ $stock }}%;"></div></div>
                    </div>
                    @endif

                    <div class="el-card-actions">
                        <a href="{{ route('products.show', $product->slug) }}" class="el-add-btn" onclick="event.stopPropagation();">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            Add to Cart
                        </a>
                        <button class="el-compare-btn" onclick="event.stopPropagation();" title="Compare">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 3 21 3 21 8"/><line x1="4" y1="20" x2="21" y2="3"/><polyline points="21 16 21 21 16 21"/><line x1="15" y1="15" x2="21" y2="21"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Top rated section --}}
        @if($products->count() > 8)
        <div class="el-section-head">
            <h3>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                Top Rated in Electronics
            </h3>
            <a href="{{ route('electronics', ['sort'=>'rating']) }}">See all top rated →</a>
        </div>
        <div class="el-grid">
            @foreach($products->sortByDesc(fn($p) => $ratings[$p->id % count($ratings)])->take(4) as $product)
            @php
                $disc      = elDisc($product->id, $discounts);
                $saveAmt   = round($product->price * $disc / 100, 2);
                $afterP    = round($product->price - $saveAmt, 2);
                $pRating   = $ratings[$product->id % count($ratings)];
                $pReviews  = $reviews[$product->id % count($reviews)];
                $stock     = $stockPct[$product->id % count($stockPct)];
                $lowStock  = $isLowStock[$product->id % count($isLowStock)];
                $freeShip  = $isFreeShip[$product->id % count($isFreeShip)];
                $prime     = $isPrime[$product->id % count($isPrime)];
                $specs     = $specsTags[$product->id % count($specsTags)];
                $brandName = $product->brand ? $product->brand->name : ($elBrands[$product->id % count($elBrands)]);
                $imgs      = collect($product->images ?? [])->filter()->values();
                $thumb     = $imgs->first() ? \Illuminate\Support\Facades\Storage::url($imgs->first()) : null;
            @endphp
            <div class="el-card" onclick="window.location='{{ route('products.show', $product->slug) }}'">
                <div class="el-card-disc">-{{ $disc }}%</div>
                <div class="el-card-badge hot">Best Seller</div>
                <div class="el-card-img">
                    @if($thumb)
                        <img src="{{ $thumb }}" alt="{{ $product->name }}" loading="lazy" />
                    @else
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#d5d9d9" stroke-width="1"><rect x="2" y="3" width="20" height="14" rx="2"/></svg>
                    @endif
                </div>
                <button class="el-wish-btn" onclick="event.stopPropagation(); elToggleWish(this)">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#CC0C39" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                </button>
                <div class="el-card-body">
                    <div class="el-card-brand">{{ $brandName }}</div>
                    <div class="el-card-name">{{ $product->name }}</div>
                    <div class="el-card-stars">{!! elStars($pRating) !!}<span>{{ $pRating }} ({{ number_format($pReviews) }})</span></div>
                    <div class="el-card-price-row">
                        <span class="el-card-price"><sup>$</sup>{{ number_format($afterP, 2) }}</span>
                        <span class="el-card-was">List: <s>${{ number_format($product->price, 2) }}</s></span>
                    </div>
                    <span class="el-save-pill">Save {{ $disc }}%</span>
                    <div class="el-spec-tags">
                        @foreach($specs as $s)<span class="el-spec-tag">{{ $s }}</span>@endforeach
                        @if($prime)<span class="el-spec-tag prime">Prime</span>@endif
                    </div>
                    <div class="el-card-actions">
                        <a href="{{ route('products.show', $product->slug) }}" class="el-add-btn" onclick="event.stopPropagation();">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            Add to Cart
                        </a>
                        <button class="el-compare-btn" onclick="event.stopPropagation();">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 3 21 3 21 8"/><line x1="4" y1="20" x2="21" y2="3"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Buying guide --}}
        <div class="el-guide">
            <h3>
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Electronics Buying Guide
            </h3>
            <div class="el-guide-grid">
                <div class="el-guide-card">
                    <div class="el-guide-card-icon">📱</div>
                    <h4>Smartphones</h4>
                    <p>Compare specs like processor, battery, camera, and display resolution before buying.</p>
                </div>
                <div class="el-guide-card">
                    <div class="el-guide-card-icon">💻</div>
                    <h4>Laptops</h4>
                    <p>Choose RAM, storage and GPU based on whether you need it for work, gaming, or school.</p>
                </div>
                <div class="el-guide-card">
                    <div class="el-guide-card-icon">📺</div>
                    <h4>TVs</h4>
                    <p>Look at resolution (4K/8K), refresh rate, HDR support, and smart platform.</p>
                </div>
                <div class="el-guide-card">
                    <div class="el-guide-card-icon">🎧</div>
                    <h4>Audio</h4>
                    <p>Consider ANC, driver size, battery life, and codec support (aptX, LDAC) for headphones.</p>
                </div>
                <div class="el-guide-card">
                    <div class="el-guide-card-icon">📷</div>
                    <h4>Cameras</h4>
                    <p>Sensor size, megapixels, video capability, and lens compatibility matter most.</p>
                </div>
                <div class="el-guide-card">
                    <div class="el-guide-card-icon">⌚</div>
                    <h4>Wearables</h4>
                    <p>Battery life, health tracking accuracy, and OS compatibility are key factors.</p>
                </div>
            </div>
        </div>

        @endif
    </div>
</div>
</div>

<script>
/* Flash sale countdown — 4 hours from page load */
(function(){
    const end = new Date(Date.now() + 4 * 3600 * 1000);
    function tick(){
        const diff = Math.max(0, end - Date.now());
        const h = String(Math.floor(diff/3600000)).padStart(2,'0');
        const m = String(Math.floor((diff%3600000)/60000)).padStart(2,'0');
        const s = String(Math.floor((diff%60000)/1000)).padStart(2,'0');
        const hEl=document.getElementById('el-h'),mEl=document.getElementById('el-m'),sEl=document.getElementById('el-s');
        if(hEl) hEl.textContent=h;
        if(mEl) mEl.textContent=m;
        if(sEl) sEl.textContent=s;
    }
    tick();
    setInterval(tick,1000);
})();

function elToggleWish(btn) {
    btn.classList.toggle('saved');
    const svg = btn.querySelector('svg');
    const saved = btn.classList.contains('saved');
    svg.setAttribute('fill', saved ? '#CC0C39' : 'none');
    elToast(saved ? '❤️ Added to Wishlist' : 'Removed from Wishlist');
}

function elApplyPrice() {
    const min = document.getElementById('el-min').value;
    const max = document.getElementById('el-max').value;
    const url = new URL(window.location.href);
    if (min) url.searchParams.set('min_price', min);
    else url.searchParams.delete('min_price');
    if (max) url.searchParams.set('max_price', max);
    else url.searchParams.delete('max_price');
    window.location.href = url.toString();
}

function elToast(msg) {
    let t = document.getElementById('elToast');
    if (!t) {
        t = document.createElement('div');
        t.id = 'elToast';
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
