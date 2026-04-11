@extends('store.layout')
@section('title', 'Fashion — Clothing, Shoes & Accessories')

@section('head')
<style>
    /* ── Page ───────────────────────────────────────── */
    .fa-page { background: #EAEDED; min-height: 80vh; }

    /* ── Hero ───────────────────────────────────────── */
    .fa-hero { background: linear-gradient(115deg,#131921 0%,#1a1a2e 55%,#131921 100%); padding: 28px 18px; position: relative; overflow: hidden; }
    .fa-hero::before { content:''; position:absolute; right:-60px; top:-60px; width:320px; height:320px; background:rgba(255,153,0,.07); border-radius:50%; pointer-events:none; }
    .fa-hero::after  { content:''; position:absolute; left:38%; bottom:-80px; width:260px; height:260px; background:rgba(255,255,255,.03); border-radius:50%; pointer-events:none; }
    .fa-hero-inner { max-width:1340px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; gap:20px; flex-wrap:wrap; position:relative; z-index:1; }
    .fa-hero-eyebrow { display:inline-flex; align-items:center; gap:6px; background:rgba(255,153,0,.15); border:1px solid rgba(255,153,0,.4); border-radius:20px; padding:4px 14px; font-size:12px; color:#FF9900; font-weight:700; letter-spacing:.5px; margin-bottom:10px; text-transform:uppercase; }
    .fa-hero-left h1 { font-size:32px; font-weight:900; color:#fff; margin:0 0 8px; line-height:1.15; }
    .fa-hero-left h1 span { color:#FF9900; }
    .fa-hero-left p { font-size:13px; color:#adbac7; margin:0 0 18px; max-width:480px; line-height:1.6; }
    .fa-hero-btns { display:flex; gap:10px; flex-wrap:wrap; }
    .fa-hero-btn { display:inline-flex; align-items:center; gap:7px; border-radius:6px; padding:10px 20px; font-size:13px; font-weight:700; cursor:pointer; text-decoration:none; transition:all .12s; }
    .fa-hero-btn.primary { background:#FFD814; border:1px solid #FCD200; color:#131921; }
    .fa-hero-btn.primary:hover { background:#F7CA00; color:#131921; }
    .fa-hero-btn.secondary { background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.25); color:#fff; }
    .fa-hero-btn.secondary:hover { background:rgba(255,255,255,.18); }
    .fa-hero-stats { display:flex; gap:12px; flex-wrap:wrap; }
    .fa-stat { text-align:center; background:rgba(255,255,255,.07); border:1px solid rgba(255,255,255,.13); border-radius:10px; padding:14px 18px; min-width:76px; }
    .fa-stat-num { font-size:22px; font-weight:900; color:#FF9900; line-height:1; }
    .fa-stat-label { font-size:10px; color:#adbac7; text-transform:uppercase; letter-spacing:.5px; margin-top:4px; }

    /* ── Trend ticker ────────────────────────────────── */
    .fa-ticker { background:linear-gradient(90deg,#C7511F,#a03d10); overflow:hidden; }
    .fa-ticker-inner { max-width:1340px; margin:0 auto; padding:9px 18px; display:flex; align-items:center; gap:0; }
    .fa-ticker-label { font-size:12px; font-weight:800; color:#fff; white-space:nowrap; flex-shrink:0; display:flex; align-items:center; gap:6px; padding-right:14px; border-right:1px solid rgba(255,255,255,.3); margin-right:14px; }
    .fa-ticker-outer { overflow:hidden; flex:1; }
    .fa-ticker-track { display:flex; gap:28px; width:max-content; }
    .fa-ticker-item { font-size:12px; color:rgba(255,255,255,.9); white-space:nowrap; font-weight:500; }

    /* ── Gender/style tabs (top strip) ───────────────── */
    .fa-gender-bar { background:#fff; border-bottom:2px solid #e3e6e6; }
    .fa-gender-inner { max-width:1340px; margin:0 auto; padding:0 18px; display:flex; overflow-x:auto; scrollbar-width:none; }
    .fa-gender-inner::-webkit-scrollbar { display:none; }
    .fa-gender-tab { display:inline-flex; align-items:center; gap:7px; padding:14px 22px; font-size:14px; font-weight:600; color:#555; white-space:nowrap; border-bottom:3px solid transparent; cursor:pointer; text-decoration:none; transition:color .12s,border-color .12s; flex-shrink:0; }
    .fa-gender-tab:hover { color:#C7511F; border-bottom-color:#FF9900; }
    .fa-gender-tab.active { color:#C7511F; border-bottom-color:#FF9900; font-weight:800; }
    .fa-gender-tab-count { background:#FF9900; color:#131921; font-size:10px; font-weight:800; border-radius:99px; padding:1px 7px; }

    /* ── Category chips ──────────────────────────────── */
    .fa-cats-bar { background:#f7f8f8; border-bottom:1px solid #e3e6e6; }
    .fa-cats-inner { max-width:1340px; margin:0 auto; padding:12px 18px; display:flex; gap:8px; overflow-x:auto; scrollbar-width:none; }
    .fa-cats-inner::-webkit-scrollbar { display:none; }
    .fa-cat-chip { flex-shrink:0; display:flex; flex-direction:column; align-items:center; gap:5px; padding:9px 14px; border:1px solid #e3e6e6; border-radius:10px; cursor:pointer; text-decoration:none; transition:all .15s; background:#fff; min-width:72px; }
    .fa-cat-chip:hover { border-color:#FF9900; background:#fff8ee; }
    .fa-cat-chip.active { border-color:#FF9900; background:#fff4e0; box-shadow:0 0 0 2px rgba(255,153,0,.14); }
    .fa-cat-chip-icon { font-size:22px; line-height:1; }
    .fa-cat-chip-label { font-size:11px; font-weight:600; color:#0F1111; white-space:nowrap; }
    .fa-cat-chip.active .fa-cat-chip-label { color:#C7511F; }

    /* ── Brands bar ──────────────────────────────────── */
    .fa-brands-bar { background:#fff; border-bottom:1px solid #e3e6e6; }
    .fa-brands-inner { max-width:1340px; margin:0 auto; padding:10px 18px; display:flex; align-items:center; gap:6px; overflow-x:auto; scrollbar-width:none; }
    .fa-brands-inner::-webkit-scrollbar { display:none; }
    .fa-brands-label { font-size:12px; font-weight:700; color:#555; white-space:nowrap; flex-shrink:0; margin-right:6px; }
    .fa-brand-pill { flex-shrink:0; padding:5px 14px; border:1px solid #d5d9d9; border-radius:20px; font-size:12px; font-weight:600; color:#0F1111; cursor:pointer; text-decoration:none; background:#fff; transition:all .12s; }
    .fa-brand-pill:hover { border-color:#FF9900; color:#C7511F; background:#fff8ee; }
    .fa-brand-pill.active { background:#131921; color:#FF9900; border-color:#131921; }

    /* ── Breadcrumb ──────────────────────────────────── */
    .fa-breadcrumb { max-width:1340px; margin:0 auto; padding:10px 18px; font-size:13px; color:#555; }
    .fa-breadcrumb a { color:#007185; }
    .fa-breadcrumb a:hover { color:#C7511F; text-decoration:underline; }

    /* ── Layout ──────────────────────────────────────── */
    .fa-wrap { max-width:1340px; margin:0 auto; padding:20px 18px 50px; display:flex; gap:20px; align-items:flex-start; }

    /* ── Sidebar ─────────────────────────────────────── */
    .fa-sidebar { width:210px; flex-shrink:0; }
    .fa-sb-box { background:#fff; border:1px solid #e3e6e6; border-radius:8px; overflow:hidden; margin-bottom:14px; }
    .fa-sb-head { font-size:14px; font-weight:700; color:#0F1111; padding:12px 16px 10px; border-bottom:1px solid #f0f2f2; background:#f7f8f8; display:flex; align-items:center; gap:7px; }
    .fa-sb-body { padding:8px 0; }
    .fa-sb-item { display:flex; align-items:center; gap:9px; padding:8px 16px; font-size:13px; color:#0F1111; cursor:pointer; text-decoration:none; transition:background .1s; border-left:3px solid transparent; }
    .fa-sb-item:hover { background:#fff8ee; border-left-color:#FF9900; color:#C7511F; }
    .fa-sb-item.active { background:#fff4e0; border-left-color:#FF9900; font-weight:700; color:#C7511F; }
    .fa-sb-item input[type=radio],
    .fa-sb-item input[type=checkbox] { accent-color:#FF9900; width:14px; height:14px; flex-shrink:0; }
    .fa-sb-item-count { margin-left:auto; font-size:11px; color:#888; background:#f0f2f2; border-radius:99px; padding:1px 7px; }

    /* Size grid */
    .fa-size-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:6px; padding:10px 12px 14px; }
    .fa-size-btn { border:1px solid #d5d9d9; border-radius:4px; padding:6px 4px; font-size:12px; font-weight:600; color:#0F1111; background:#fff; cursor:pointer; text-align:center; transition:all .12s; }
    .fa-size-btn:hover { border-color:#FF9900; color:#C7511F; background:#fff8ee; }
    .fa-size-btn.active { background:#131921; color:#FF9900; border-color:#131921; }

    /* Color swatches */
    .fa-color-grid { display:flex; gap:7px; flex-wrap:wrap; padding:10px 12px 14px; }
    .fa-swatch { width:26px; height:26px; border-radius:50%; cursor:pointer; border:2px solid transparent; transition:all .12s; position:relative; }
    .fa-swatch:hover, .fa-swatch.active { border-color:#FF9900; transform:scale(1.15); }
    .fa-swatch.active::after { content:'✓'; position:absolute; inset:0; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:900; color:#fff; text-shadow:0 0 3px rgba(0,0,0,.5); }

    /* Price range */
    .fa-price-inputs { display:flex; gap:6px; align-items:center; padding:10px 16px; }
    .fa-price-inputs input { width:60px; border:1px solid #d5d9d9; border-radius:4px; padding:5px 6px; font-size:12px; outline:none; }
    .fa-price-inputs input:focus { border-color:#FF9900; box-shadow:0 0 0 2px rgba(255,153,0,.15); }
    .fa-price-inputs span { font-size:12px; color:#555; }
    .fa-price-go { background:#FF9900; color:#131921; border:none; border-radius:4px; padding:5px 10px; font-size:12px; font-weight:700; cursor:pointer; }

    /* ── Main ────────────────────────────────────────── */
    .fa-main { flex:1; min-width:0; }

    /* ── Trending looks carousel ─────────────────────── */
    .fa-trends { background:#fff; border:1px solid #e3e6e6; border-radius:8px; padding:18px; margin-bottom:20px; }
    .fa-trends h3 { font-size:15px; font-weight:700; color:#0F1111; margin:0 0 14px; display:flex; align-items:center; gap:7px; border-bottom:2px solid #FF9900; padding-bottom:10px; }
    .fa-trends-row { display:flex; gap:10px; overflow-x:auto; scrollbar-width:none; }
    .fa-trends-row::-webkit-scrollbar { display:none; }
    .fa-trend-card { flex-shrink:0; min-width:120px; max-width:120px; border-radius:10px; overflow:hidden; cursor:pointer; transition:transform .15s; text-decoration:none; }
    .fa-trend-card:hover { transform:scale(1.03); }
    .fa-trend-img { aspect-ratio:3/4; display:flex; align-items:center; justify-content:center; font-size:48px; border-radius:10px 10px 0 0; }
    .fa-trend-lbl { padding:6px 8px; font-size:11px; font-weight:700; color:#0F1111; text-align:center; background:#f7f8f8; border-radius:0 0 10px 10px; }
    .fa-trend-sub { font-size:10px; color:#C7511F; font-weight:600; }

    /* ── Promo banners ───────────────────────────────── */
    .fa-promos { display:grid; grid-template-columns:repeat(auto-fit,minmax(195px,1fr)); gap:12px; margin-bottom:20px; }
    .fa-promo { border-radius:10px; padding:18px; display:flex; flex-direction:column; gap:7px; position:relative; overflow:hidden; cursor:pointer; transition:transform .15s,box-shadow .15s; text-decoration:none; }
    .fa-promo:hover { transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,.15); }
    .fa-promo h4 { font-size:14px; font-weight:800; margin:0; }
    .fa-promo p  { font-size:12px; margin:0; opacity:.9; line-height:1.4; }
    .fa-promo span { font-size:11px; font-weight:700; margin-top:4px; }
    .fa-promo-icon { position:absolute; right:12px; top:50%; transform:translateY(-50%); font-size:42px; opacity:.22; }
    .fa-p1 { background:linear-gradient(135deg,#131921,#1a2a3a); color:#fff; }
    .fa-p1 h4 { color:#FF9900; } .fa-p1 span { color:#FFD814; }
    .fa-p2 { background:linear-gradient(135deg,#CC0C39,#a50a2d); color:#fff; }
    .fa-p2 span { color:#FFD814; }
    .fa-p3 { background:linear-gradient(135deg,#007185,#005a6a); color:#fff; }
    .fa-p3 span { color:#FFD814; }
    .fa-p4 { background:linear-gradient(135deg,#131921,#1a2a3a); color:#fff; }
    .fa-p4 h4 { color:#FF9900; } .fa-p4 span { color:#FFD814; }

    /* Topbar */
    .fa-topbar { display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; flex-wrap:wrap; gap:10px; }
    .fa-topbar-left { font-size:14px; color:#555; }
    .fa-topbar-left b { color:#0F1111; }
    .fa-topbar-right { display:flex; align-items:center; gap:8px; font-size:13px; color:#555; }
    .fa-topbar-right select { border:1px solid #d5d9d9; border-radius:6px; padding:6px 10px; font-size:13px; background:#fff; cursor:pointer; outline:none; }
    /* View toggle */
    .fa-view-btns { display:flex; gap:0; border:1px solid #d5d9d9; border-radius:6px; overflow:hidden; }
    .fa-view-btn { padding:6px 10px; background:#fff; border:none; cursor:pointer; color:#555; display:flex; align-items:center; transition:background .1s; }
    .fa-view-btn:first-child { border-right:1px solid #d5d9d9; }
    .fa-view-btn.active { background:#131921; color:#fff; }

    /* ── Product grids ───────────────────────────────── */
    .fa-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:14px; }
    .fa-grid.list { grid-template-columns:1fr; }

    /* ── Product card ────────────────────────────────── */
    .fa-card { background:#fff; border:1px solid #e3e6e6; border-radius:8px; overflow:hidden; display:flex; flex-direction:column; position:relative; transition:box-shadow .15s,border-color .15s; cursor:pointer; }
    .fa-card:hover { box-shadow:0 4px 20px rgba(0,0,0,.12); border-color:#FF9900; }
    .fa-grid.list .fa-card { flex-direction:row; }
    .fa-grid.list .fa-card-img { width:160px; flex-shrink:0; aspect-ratio:auto; height:200px; }
    .fa-grid.list .fa-card-body { flex:1; }

    /* Badges */
    .fa-disc-badge { position:absolute; top:8px; left:8px; background:#CC0C39; color:#fff; font-size:12px; font-weight:900; border-radius:4px; padding:3px 8px; z-index:3; }
    .fa-type-badge { position:absolute; top:8px; right:8px; border-radius:4px; padding:3px 8px; font-size:10px; font-weight:800; z-index:3; }
    .fa-type-badge.new    { background:#007600; color:#fff; }
    .fa-type-badge.hot    { background:#CC0C39; color:#fff; }
    .fa-type-badge.deal   { background:#131921; color:#FF9900; }
    .fa-type-badge.trend  { background:#131921; color:#FF9900; }
    .fa-type-badge.sale   { background:#FF9900; color:#131921; }

    /* Image */
    .fa-card-img { background:#f7f8f8; aspect-ratio:3/4; display:flex; align-items:center; justify-content:center; overflow:hidden; position:relative; }
    .fa-card-img img { max-width:84%; max-height:84%; object-fit:contain; transition:transform .2s; }
    .fa-card:hover .fa-card-img img { transform:scale(1.04); }

    /* Quick view overlay */
    .fa-quick-view { position:absolute; bottom:0; left:0; right:0; background:rgba(19,25,33,.82); color:#fff; font-size:11px; font-weight:700; text-align:center; padding:8px; z-index:4; opacity:0; transition:opacity .15s; display:flex; align-items:center; justify-content:center; gap:5px; }
    .fa-card:hover .fa-quick-view { opacity:1; }

    /* Wishlist */
    .fa-wish-btn { position:absolute; top:8px; right:48px; width:28px; height:28px; border-radius:50%; background:rgba(255,255,255,.9); border:1px solid #e3e6e6; display:flex; align-items:center; justify-content:center; z-index:4; cursor:pointer; transition:all .12s; }
    .fa-wish-btn:hover { background:#fff; border-color:#CC0C39; }
    .fa-wish-btn.saved svg { fill:#CC0C39; stroke:#CC0C39; }

    /* Body */
    .fa-card-body { padding:12px 12px 14px; flex:1; display:flex; flex-direction:column; gap:4px; }
    .fa-card-style { font-size:10px; color:#007185; font-weight:700; text-transform:uppercase; letter-spacing:.4px; }
    .fa-card-brand { font-size:11px; color:#C7511F; font-weight:700; text-transform:uppercase; letter-spacing:.3px; }
    .fa-card-name { font-size:13px; color:#0F1111; line-height:1.4; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; }

    /* Stars */
    .fa-stars { display:flex; align-items:center; gap:2px; }
    .fa-stars span { font-size:11px; color:#555; margin-left:3px; }

    /* Size preview */
    .fa-size-preview { display:flex; gap:4px; flex-wrap:wrap; margin-top:3px; }
    .fa-size-dot { font-size:10px; color:#555; background:#f0f2f2; border-radius:3px; padding:2px 6px; }
    .fa-size-dot.available { color:#0F1111; }

    /* Price */
    .fa-price-row { display:flex; align-items:baseline; gap:6px; margin-top:4px; flex-wrap:wrap; }
    .fa-price { font-size:20px; font-weight:900; color:#B12704; }
    .fa-price sup { font-size:12px; vertical-align:super; }
    .fa-was { font-size:12px; color:#888; }
    .fa-was s { color:#aaa; }
    .fa-save-pill { font-size:11px; background:#fff4e0; color:#C7511F; border:1px solid #FFD580; border-radius:4px; padding:2px 6px; font-weight:700; display:inline-block; }

    /* Tags */
    .fa-spec-tags { display:flex; gap:4px; flex-wrap:wrap; margin-top:4px; }
    .fa-spec-tag { font-size:10px; background:#f0f2f2; color:#555; border-radius:4px; padding:2px 7px; }
    .fa-spec-tag.prime  { background:#fff4e0; color:#C7511F; font-weight:700; }
    .fa-spec-tag.free   { background:#F0FFF4; color:#007600; }
    .fa-spec-tag.low    { background:#FFF0F0; color:#CC0C39; font-weight:700; }
    .fa-spec-tag.trend  { background:#fff4e0; color:#C7511F; font-weight:700; }

    /* Actions */
    .fa-card-actions { display:flex; gap:6px; margin-top:8px; }
    .fa-add-btn { flex:1; display:flex; align-items:center; justify-content:center; gap:5px; background:#FFD814; border:1px solid #FCD200; border-radius:20px; padding:8px; font-size:12px; font-weight:700; color:#131921; cursor:pointer; text-decoration:none; transition:background .12s; }
    .fa-add-btn:hover { background:#F7CA00; color:#131921; }
    .fa-save-btn { width:36px; flex-shrink:0; display:flex; align-items:center; justify-content:center; background:#fff; border:1px solid #d5d9d9; border-radius:20px; cursor:pointer; color:#555; transition:all .12s; }
    .fa-save-btn:hover { border-color:#FF9900; color:#C7511F; background:#fff8ee; }

    /* ── Section head ────────────────────────────────── */
    .fa-section-head { display:flex; align-items:center; justify-content:space-between; margin:24px 0 14px; }
    .fa-section-head h3 { font-size:16px; font-weight:700; color:#0F1111; margin:0; display:flex; align-items:center; gap:8px; border-left:4px solid #FF9900; padding-left:10px; }
    .fa-section-head a { font-size:13px; color:#007185; text-decoration:none; }
    .fa-section-head a:hover { color:#C7511F; text-decoration:underline; }

    /* ── Style guide ─────────────────────────────────── */
    .fa-style-guide { background:#fff; border:1px solid #e3e6e6; border-radius:8px; padding:20px; margin-top:24px; }
    .fa-style-guide h3 { font-size:16px; font-weight:700; color:#0F1111; margin:0 0 16px; border-bottom:2px solid #FF9900; padding-bottom:10px; display:flex; align-items:center; gap:8px; }
    .fa-style-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(150px,1fr)); gap:12px; }
    .fa-style-card { background:#f7f8f8; border-radius:8px; padding:14px; text-align:center; cursor:pointer; border:1px solid #e3e6e6; transition:all .12s; text-decoration:none; }
    .fa-style-card:hover { border-color:#FF9900; background:#fff8ee; }
    .fa-style-card-icon { font-size:30px; margin-bottom:8px; }
    .fa-style-card h4 { font-size:12px; font-weight:700; color:#0F1111; margin:0 0 3px; }
    .fa-style-card span { font-size:11px; color:#C7511F; font-weight:600; }

    /* ── Empty ───────────────────────────────────────── */
    .fa-empty { text-align:center; padding:60px 20px; background:#fff; border-radius:8px; border:1px solid #e3e6e6; }

    @media (max-width:760px) {
        .fa-wrap { flex-direction:column; }
        .fa-sidebar { width:100%; }
        .fa-grid { grid-template-columns:repeat(2,1fr); }
        .fa-hero-inner { flex-direction:column; }
        .fa-promos { grid-template-columns:repeat(2,1fr); }
    }
    @media (max-width:480px) {
        .fa-grid { grid-template-columns:1fr; }
        .fa-promos { grid-template-columns:1fr; }
    }
</style>
@endsection

@section('content')
@php
    /* ── Helpers ─────────────────────────────────── */
    $discounts   = [8,10,12,15,18,20,22,25,30,35,40,45];
    $badgeTypes  = ['trend','new','hot','deal','sale','trend','new'];
    $badgeLabels = ['trend'=>'Trending','new'=>'New Arrival','hot'=>'Best Seller','deal'=>'Deal','sale'=>'On Sale'];
    $ratings     = [3.8,4.0,4.2,4.4,4.5,4.6,4.7,4.8,4.9,5.0,4.1,4.3];
    $reviews     = [24,52,98,172,295,440,880,1180,68,138,220,380];
    $isFreeShip  = [true,false,true,true,false,true,true,false,true,false,true,false];
    $isPrime     = [true,true,false,true,true,false,true,false,true,true,false,true];
    $isTrending  = [true,false,true,false,false,true,false,true,false,false,true,false];
    $isLowStock  = [false,false,true,false,true,false,false,true,false,false,true,false];
    $sizes       = [
        ['XS','S','M','L','XL'],['S','M','L','XL','XXL'],['6','7','8','9','10','11'],
        ['XS','S','M'],['One Size'],['28','30','32','34','36'],['S','M','L','XL'],
        ['36','38','40','42','44'],
    ];
    $styleCategories = [
        ['icon'=>'👗','label'=>'Dresses','sub'=>'Women'],
        ['icon'=>'👔','label'=>'Shirts','sub'=>'Men'],
        ['icon'=>'👖','label'=>'Jeans','sub'=>'Unisex'],
        ['icon'=>'👟','label'=>'Sneakers','sub'=>'Footwear'],
        ['icon'=>'👜','label'=>'Bags','sub'=>'Accessories'],
        ['icon'=>'🧥','label'=>'Jackets','sub'=>'Outerwear'],
        ['icon'=>'🩱','label'=>'Swimwear','sub'=>'Seasonal'],
        ['icon'=>'🧢','label'=>'Caps & Hats','sub'=>'Accessories'],
        ['icon'=>'💍','label'=>'Jewellery','sub'=>'Accessories'],
        ['icon'=>'🩴','label'=>'Sandals','sub'=>'Footwear'],
    ];
    $genderTabs  = ['all'=>'All Fashion','women'=>'Women','men'=>'Men','kids'=>'Kids','unisex'=>'Unisex'];
    $fashionBrands = ['Zara','H&M','Nike','Adidas','Levi\'s','Forever 21','Gucci','Prada','Calvin Klein','Tommy Hilfiger'];
    $trendLooks  = [
        ['emoji'=>'🌸','label'=>'Spring Florals','sub'=>'New Season'],
        ['emoji'=>'🖤','label'=>'All Black','sub'=>'Trending'],
        ['emoji'=>'🌊','label'=>'Beach Vibes','sub'=>'Summer'],
        ['emoji'=>'🍂','label'=>'Fall Layers','sub'=>'Autumn'],
        ['emoji'=>'💼','label'=>'Work Wear','sub'=>'Smart Casual'],
        ['emoji'=>'🎉','label'=>'Party Look','sub'=>'Night Out'],
        ['emoji'=>'🏃','label'=>'Athleisure','sub'=>'Active Wear'],
        ['emoji'=>'🌿','label'=>'Boho Style','sub'=>'Earthy Tones'],
    ];
    $colorSwatches = [
        ['color'=>'#000','name'=>'Black'],['color'=>'#fff','name'=>'White'],['color'=>'#CC0C39','name'=>'Red'],
        ['color'=>'#007185','name'=>'Teal'],['color'=>'#1565C0','name'=>'Blue'],['color'=>'#2d5a27','name'=>'Green'],
        ['color'=>'#FF9900','name'=>'Orange'],['color'=>'#FFD814','name'=>'Yellow'],['color'=>'#C7511F','name'=>'Brown'],
        ['color'=>'#888','name'=>'Grey'],['color'=>'#FFB6C1','name'=>'Pink'],['color'=>'#800080','name'=>'Purple'],
    ];

    function faDisc($id,$arr){ return $arr[$id % count($arr)]; }
    function faStars($r){
        $f=floor($r);$h=($r-$f)>=0.5?1:0;$e=5-$f-$h;$o='';
        for($i=0;$i<$f;$i++)  $o.='<svg width="11" height="11" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        if($h) $o.='<svg width="11" height="11" viewBox="0 0 24 24" fill="#ddd" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        for($i=0;$i<$e;$i++)  $o.='<svg width="11" height="11" viewBox="0 0 24 24" fill="#ddd" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        return $o;
    }

    $activeGender = request('gender','all');
    $activeCatSlug= request('cat');
    $activeCat    = request('category');
    $activeBrand  = request('brand');
    $activeSort   = request('sort','featured');
    $activeSize   = request('size');
    $activeColor  = request('color');
    $activeView   = request('view','grid');
@endphp

<div class="fa-page">

{{-- Hero --}}
<div class="fa-hero">
    <div class="fa-hero-inner">
        <div class="fa-hero-left">
            <div class="fa-hero-eyebrow">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/></svg>
                Clothing, Shoes & Accessories
            </div>
            <h1>Shop <span>Fashion</span></h1>
            <p>Discover the latest trends in clothing, footwear, and accessories for men, women & kids — updated daily with new arrivals.</p>
            <div class="fa-hero-btns">
                <a href="#fa-listings" class="fa-hero-btn primary">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Browse All Fashion
                </a>
                <a href="{{ route('fashion', ['tab'=>'deals']) }}" class="fa-hero-btn secondary">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                    Fashion Deals
                </a>
            </div>
        </div>
        <div class="fa-hero-stats">
            <div class="fa-stat">
                <div class="fa-stat-num">{{ $products->count() }}+</div>
                <div class="fa-stat-label">Styles</div>
            </div>
            <div class="fa-stat">
                <div class="fa-stat-num">{{ $brands->count() }}</div>
                <div class="fa-stat-label">Brands</div>
            </div>
            <div class="fa-stat">
                <div class="fa-stat-num">45%</div>
                <div class="fa-stat-label">Max Off</div>
            </div>
            <div class="fa-stat">
                <div class="fa-stat-num">FREE</div>
                <div class="fa-stat-label">Returns</div>
            </div>
        </div>
    </div>
</div>

{{-- Trend ticker --}}
<div class="fa-ticker">
    <div class="fa-ticker-inner">
        <div class="fa-ticker-label">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="#FFD814" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            Trending Now:
        </div>
        <div class="fa-ticker-outer">
            <div class="fa-ticker-track" id="fa-ticker-track">
                @foreach(['Spring Florals 🌸','All-Black Sets 🖤','Oversized Hoodies 🧥','Wide-Leg Trousers 👖','Platform Sneakers 👟','Midi Dresses 👗','Denim on Denim 🤍','Boho Accessories 💍'] as $t)
                <span class="fa-ticker-item">{{ $t }}</span>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Gender tabs --}}
<div class="fa-gender-bar">
    <div class="fa-gender-inner">
        @foreach($genderTabs as $k=>$lbl)
        <a href="{{ route('fashion', array_merge(request()->except('gender'),['gender'=>$k])) }}" class="fa-gender-tab {{ $activeGender==$k ? 'active' : '' }}">
            {{ $lbl }}
            @if($k=='all') <span class="fa-gender-tab-count">{{ $products->count() }}</span> @endif
        </a>
        @endforeach
    </div>
</div>

{{-- Category chips --}}
<div class="fa-cats-bar">
    <div class="fa-cats-inner">
        <a href="{{ route('fashion', request()->except('cat')) }}" class="fa-cat-chip {{ !$activeCatSlug ? 'active' : '' }}">
            <span class="fa-cat-chip-icon">✨</span>
            <span class="fa-cat-chip-label">All</span>
        </a>
        @foreach($styleCategories as $sc)
        <a href="{{ route('fashion', array_merge(request()->except('cat'),['cat'=>strtolower($sc['label'])])) }}" class="fa-cat-chip {{ $activeCatSlug==strtolower($sc['label']) ? 'active' : '' }}">
            <span class="fa-cat-chip-icon">{{ $sc['icon'] }}</span>
            <span class="fa-cat-chip-label">{{ $sc['label'] }}</span>
        </a>
        @endforeach
    </div>
</div>

{{-- Brands bar --}}
<div class="fa-brands-bar">
    <div class="fa-brands-inner">
        <span class="fa-brands-label">Top Brands:</span>
        <a href="{{ route('fashion') }}" class="fa-brand-pill {{ !$activeBrand ? 'active' : '' }}">All</a>
        @foreach($fashionBrands as $b)
        <a href="{{ route('fashion', ['brand_name'=>$b]) }}" class="fa-brand-pill {{ request('brand_name')==$b ? 'active' : '' }}">{{ $b }}</a>
        @endforeach
        @foreach($brands->take(4) as $brand)
        <a href="{{ route('fashion', array_merge(request()->except('brand'),['brand'=>$brand->id])) }}" class="fa-brand-pill {{ $activeBrand==$brand->id ? 'active' : '' }}">{{ $brand->name }}</a>
        @endforeach
    </div>
</div>

{{-- Breadcrumb --}}
<div style="background:#fff;border-bottom:1px solid #e3e6e6;">
    <div class="fa-breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span> › </span>
        <span style="color:#0F1111;">Fashion</span>
        @if($activeGender && $activeGender!='all')<span> › </span><span style="color:#0F1111;text-transform:capitalize;">{{ $activeGender }}</span>@endif
        @if($activeCatSlug)<span> › </span><span style="color:#0F1111;text-transform:capitalize;">{{ $activeCatSlug }}</span>@endif
    </div>
</div>

{{-- Body --}}
<div class="fa-wrap">

    {{-- SIDEBAR --}}
    <div class="fa-sidebar">

        {{-- Gender --}}
        <div class="fa-sb-box">
            <div class="fa-sb-head">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/></svg>
                Gender
            </div>
            <div class="fa-sb-body">
                @foreach($genderTabs as $k=>$lbl)
                <a href="{{ route('fashion', array_merge(request()->except('gender'),['gender'=>$k])) }}" class="fa-sb-item {{ $activeGender==$k ? 'active' : '' }}">
                    <input type="radio" {{ $activeGender==$k ? 'checked' : '' }} readonly /> {{ $lbl }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Style Category --}}
        <div class="fa-sb-box">
            <div class="fa-sb-head">Style Category</div>
            <div class="fa-sb-body">
                <a href="{{ route('fashion', request()->except('cat')) }}" class="fa-sb-item {{ !$activeCatSlug ? 'active' : '' }}">
                    <input type="radio" {{ !$activeCatSlug ? 'checked' : '' }} readonly /> ✨ All Styles
                </a>
                @foreach($styleCategories as $sc)
                <a href="{{ route('fashion', array_merge(request()->except('cat'),['cat'=>strtolower($sc['label'])])) }}" class="fa-sb-item {{ $activeCatSlug==strtolower($sc['label']) ? 'active' : '' }}">
                    <input type="radio" {{ $activeCatSlug==strtolower($sc['label']) ? 'checked' : '' }} readonly />
                    {{ $sc['icon'] }} {{ $sc['label'] }}
                    <span class="fa-sb-item-count">{{ rand(3,50) }}</span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Brand --}}
        @if($brands->isNotEmpty())
        <div class="fa-sb-box">
            <div class="fa-sb-head">Brand</div>
            <div class="fa-sb-body">
                <a href="{{ route('fashion', request()->except('brand')) }}" class="fa-sb-item {{ !$activeBrand ? 'active' : '' }}">
                    <input type="radio" {{ !$activeBrand ? 'checked' : '' }} readonly /> All Brands
                </a>
                @foreach($brands->take(10) as $brand)
                <a href="{{ route('fashion', array_merge(request()->except('brand'),['brand'=>$brand->id])) }}" class="fa-sb-item {{ $activeBrand==$brand->id ? 'active' : '' }}">
                    <input type="radio" {{ $activeBrand==$brand->id ? 'checked' : '' }} readonly /> {{ $brand->name }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Size --}}
        <div class="fa-sb-box">
            <div class="fa-sb-head">Size</div>
            <div class="fa-size-grid">
                @foreach(['XS','S','M','L','XL','XXL','6','7','8','9','10','11','28','30','32','34'] as $sz)
                <button class="fa-size-btn {{ $activeSize==$sz ? 'active' : '' }}" onclick="faSetSize('{{ $sz }}')">{{ $sz }}</button>
                @endforeach
            </div>
        </div>

        {{-- Color --}}
        <div class="fa-sb-box">
            <div class="fa-sb-head">Colour</div>
            <div class="fa-color-grid">
                @foreach($colorSwatches as $sw)
                <div class="fa-swatch {{ $activeColor==$sw['name'] ? 'active' : '' }}"
                     style="background:{{ $sw['color'] }};{{ $sw['name']=='White' ? 'border:2px solid #d5d9d9;' : '' }}"
                     onclick="faSetColor('{{ $sw['name'] }}')"
                     title="{{ $sw['name'] }}"></div>
                @endforeach
            </div>
        </div>

        {{-- Discount --}}
        <div class="fa-sb-box">
            <div class="fa-sb-head">Discount</div>
            <div class="fa-sb-body">
                @foreach(['10'=>'10% or more','20'=>'20% or more','30'=>'30% or more','40'=>'40% or more'] as $v=>$lbl)
                <a href="{{ route('fashion', array_merge(request()->except('min_disc'),['min_disc'=>$v])) }}" class="fa-sb-item {{ request('min_disc')==$v ? 'active' : '' }}">
                    <input type="radio" {{ request('min_disc')==$v ? 'checked' : '' }} readonly /> {{ $lbl }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Price --}}
        <div class="fa-sb-box">
            <div class="fa-sb-head">Price Range</div>
            <div class="fa-price-inputs">
                <input type="number" placeholder="Min" value="{{ request('min_price') }}" id="fa-min" />
                <span>—</span>
                <input type="number" placeholder="Max" value="{{ request('max_price') }}" id="fa-max" />
                <button class="fa-price-go" onclick="faApplyPrice()">Go</button>
            </div>
        </div>

    </div>

    {{-- MAIN --}}
    <div class="fa-main" id="fa-listings">

        {{-- Trending looks --}}
        <div class="fa-trends">
            <h3>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                Trending Looks
            </h3>
            <div class="fa-trends-row">
                @foreach($trendLooks as $look)
                <a href="{{ route('fashion', ['style'=>strtolower(str_replace(' ','-',$look['label']))]) }}" class="fa-trend-card">
                    <div class="fa-trend-img" style="background:{{ ['#fff4e0','#f3f0ff','#f0fff4','#fff0f0','#f0f8ff','#fff8f0','#f5f0ff','#f0fff8'][$loop->index % 8] }};">
                        {{ $look['emoji'] }}
                    </div>
                    <div class="fa-trend-lbl">
                        {{ $look['label'] }}<br>
                        <span class="fa-trend-sub">{{ $look['sub'] }}</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Promo banners --}}
        <div class="fa-promos">
            <a href="{{ route('fashion', ['gender'=>'women']) }}" class="fa-promo fa-p1">
                <div class="fa-promo-icon">👗</div>
                <h4>Women's Fashion</h4>
                <p>Dresses, tops & accessories</p>
                <span>Up to 45% OFF →</span>
            </a>
            <a href="{{ route('fashion', ['gender'=>'men']) }}" class="fa-promo fa-p2">
                <div class="fa-promo-icon">👔</div>
                <h4>Men's Style</h4>
                <p>Shirts, trousers & shoes</p>
                <span>Shop Now →</span>
            </a>
            <a href="{{ route('fashion', ['cat'=>'sneakers']) }}" class="fa-promo fa-p3">
                <div class="fa-promo-icon">👟</div>
                <h4>Footwear</h4>
                <p>Sneakers, heels & sandals</p>
                <span>Explore →</span>
            </a>
            <a href="{{ route('fashion', ['cat'=>'bags']) }}" class="fa-promo fa-p4">
                <div class="fa-promo-icon">👜</div>
                <h4>Accessories</h4>
                <p>Bags, jewellery & more</p>
                <span>Browse →</span>
            </a>
        </div>

        {{-- Topbar --}}
        <div class="fa-topbar">
            <div class="fa-topbar-left"><b>{{ $products->count() }}</b> fashion items found</div>
            <div class="fa-topbar-right">
                <div class="fa-view-btns">
                    <button class="fa-view-btn {{ $activeView=='grid' ? 'active' : '' }}" onclick="faSetView('grid')" title="Grid view">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    </button>
                    <button class="fa-view-btn {{ $activeView=='list' ? 'active' : '' }}" onclick="faSetView('list')" title="List view">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    </button>
                </div>
                Sort by:
                <select onchange="window.location.href=this.value">
                    <option value="{{ route('fashion', array_merge(request()->all(),['sort'=>'featured'])) }}"    {{ $activeSort=='featured'   ? 'selected':'' }}>Featured</option>
                    <option value="{{ route('fashion', array_merge(request()->all(),['sort'=>'newest'])) }}"     {{ $activeSort=='newest'     ? 'selected':'' }}>New Arrivals</option>
                    <option value="{{ route('fashion', array_merge(request()->all(),['sort'=>'price_asc'])) }}"  {{ $activeSort=='price_asc'  ? 'selected':'' }}>Price: Low to High</option>
                    <option value="{{ route('fashion', array_merge(request()->all(),['sort'=>'price_desc'])) }}" {{ $activeSort=='price_desc' ? 'selected':'' }}>Price: High to Low</option>
                    <option value="{{ route('fashion', array_merge(request()->all(),['sort'=>'rating'])) }}"     {{ $activeSort=='rating'     ? 'selected':'' }}>Best Reviewed</option>
                    <option value="{{ route('fashion', array_merge(request()->all(),['sort'=>'discount'])) }}"   {{ $activeSort=='discount'   ? 'selected':'' }}>Biggest Discount</option>
                    <option value="{{ route('fashion', array_merge(request()->all(),['sort'=>'trending'])) }}"   {{ $activeSort=='trending'   ? 'selected':'' }}>Trending</option>
                </select>
            </div>
        </div>

        {{-- Grid --}}
        @if($products->isEmpty())
        <div class="fa-empty">
            <div style="font-size:64px;margin-bottom:14px;">👗</div>
            <h3 style="font-size:18px;font-weight:700;margin-bottom:8px;">No fashion items found</h3>
            <p style="font-size:14px;color:#555;margin-bottom:14px;">Try adjusting your filters or explore a different style.</p>
            <a href="{{ route('fashion') }}" style="color:#007185;font-size:13px;">Clear all filters</a>
        </div>
        @else
        <div class="fa-grid {{ $activeView=='list' ? 'list' : '' }}" id="fa-grid">
            @foreach($products as $product)
            @php
                $disc      = faDisc($product->id, $discounts);
                $saveAmt   = round($product->price * $disc / 100, 2);
                $afterP    = round($product->price - $saveAmt, 2);
                $badgeType = $badgeTypes[$product->id % count($badgeTypes)];
                $badgeText = $badgeLabels[$badgeType];
                $pRating   = $ratings[$product->id % count($ratings)];
                $pReviews  = $reviews[$product->id % count($reviews)];
                $freeShip  = $isFreeShip[$product->id % count($isFreeShip)];
                $prime     = $isPrime[$product->id % count($isPrime)];
                $trending  = $isTrending[$product->id % count($isTrending)];
                $lowStock  = $isLowStock[$product->id % count($isLowStock)];
                $pSizes    = $sizes[$product->id % count($sizes)];
                $styleCat  = $styleCategories[$product->id % count($styleCategories)];
                $brandName = $product->brand ? $product->brand->name : ($fashionBrands[$product->id % count($fashionBrands)]);
                $imgs      = collect($product->images ?? [])->filter()->values();
                $thumb     = $imgs->first() ? \Illuminate\Support\Facades\Storage::url($imgs->first()) : null;
            @endphp
            <div class="fa-card" onclick="window.location='{{ route('products.show', $product->slug) }}'">

                <div class="fa-disc-badge">-{{ $disc }}%</div>
                <div class="fa-type-badge {{ $badgeType }}">{{ $badgeText }}</div>

                <button class="fa-wish-btn" onclick="event.stopPropagation(); faToggleWish(this)" title="Save">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#CC0C39" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                </button>

                <div class="fa-card-img">
                    @if($thumb)
                        <img src="{{ $thumb }}" alt="{{ $product->name }}" loading="lazy" />
                    @else
                        <div style="font-size:52px;opacity:.25;">{{ $styleCat['icon'] }}</div>
                    @endif
                    <div class="fa-quick-view">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Quick View
                    </div>
                </div>

                <div class="fa-card-body">
                    <div class="fa-card-style">{{ $styleCat['icon'] }} {{ $styleCat['label'] }} · {{ $styleCat['sub'] }}</div>
                    <div class="fa-card-brand">{{ $brandName }}</div>
                    <div class="fa-card-name">{{ $product->name }}</div>

                    <div class="fa-stars">
                        {!! faStars($pRating) !!}
                        <span>{{ $pRating }} ({{ number_format($pReviews) }})</span>
                    </div>

                    {{-- Available sizes preview --}}
                    <div class="fa-size-preview">
                        @foreach(array_slice($pSizes, 0, 5) as $sz)
                        <span class="fa-size-dot available">{{ $sz }}</span>
                        @endforeach
                        @if(count($pSizes) > 5)<span class="fa-size-dot">+{{ count($pSizes)-5 }}</span>@endif
                    </div>

                    <div class="fa-price-row">
                        <span class="fa-price"><sup>$</sup>{{ number_format($afterP, 2) }}</span>
                        <span class="fa-was">Was: <s>${{ number_format($product->price, 2) }}</s></span>
                    </div>
                    <span class="fa-save-pill">Save ${{ number_format($saveAmt, 2) }} ({{ $disc }}%)</span>

                    <div class="fa-spec-tags">
                        @if($trending)  <span class="fa-spec-tag trend">🔥 Trending</span> @endif
                        @if($prime)     <span class="fa-spec-tag prime">Prime</span> @endif
                        @if($freeShip)  <span class="fa-spec-tag free">Free Returns</span> @endif
                        @if($lowStock)  <span class="fa-spec-tag low">Low Stock</span> @endif
                    </div>

                    <div class="fa-card-actions">
                        <a href="{{ route('products.show', $product->slug) }}" class="fa-add-btn" onclick="event.stopPropagation();">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            Add to Cart
                        </a>
                        <button class="fa-save-btn" onclick="event.stopPropagation(); faToggleWish(this)" title="Save to list">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Style guide --}}
        <div class="fa-style-guide">
            <h3>
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/></svg>
                Shop by Style
            </h3>
            <div class="fa-style-grid">
                @foreach($styleCategories as $sc)
                <a href="{{ route('fashion', ['cat'=>strtolower($sc['label'])]) }}" class="fa-style-card">
                    <div class="fa-style-card-icon">{{ $sc['icon'] }}</div>
                    <h4>{{ $sc['label'] }}</h4>
                    <span>{{ $sc['sub'] }}</span>
                </a>
                @endforeach
            </div>
        </div>

        @endif
    </div>
</div>
</div>

<script>
function faToggleWish(btn) {
    btn.classList.toggle('saved');
    const svg = btn.querySelector('svg');
    const saved = btn.classList.contains('saved');
    svg.setAttribute('fill', saved ? '#CC0C39' : 'none');
    svg.setAttribute('stroke', '#CC0C39');
    faToast(saved ? '❤️ Saved to Wish List' : 'Removed from Wish List');
}

function faSetView(v) {
    const grid = document.getElementById('fa-grid');
    if (!grid) return;
    if (v === 'list') grid.classList.add('list');
    else grid.classList.remove('list');
    document.querySelectorAll('.fa-view-btn').forEach(b => b.classList.toggle('active', b.getAttribute('onclick')?.includes(v)));
    const url = new URL(window.location.href);
    url.searchParams.set('view', v);
    history.replaceState(null, '', url.toString());
}

function faSetSize(sz) {
    const url = new URL(window.location.href);
    url.searchParams.set('size', sz);
    window.location.href = url.toString();
}

function faSetColor(c) {
    const url = new URL(window.location.href);
    url.searchParams.set('color', c);
    window.location.href = url.toString();
}

function faApplyPrice() {
    const min = document.getElementById('fa-min').value;
    const max = document.getElementById('fa-max').value;
    const url = new URL(window.location.href);
    if (min) url.searchParams.set('min_price', min); else url.searchParams.delete('min_price');
    if (max) url.searchParams.set('max_price', max); else url.searchParams.delete('max_price');
    window.location.href = url.toString();
}

function faToast(msg) {
    let t = document.getElementById('faToast');
    if (!t) {
        t = document.createElement('div');
        t.id = 'faToast';
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
    const track = document.getElementById('fa-ticker-track');
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
