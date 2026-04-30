@extends('store.layout')
@section('title', 'MyShop Resale — Buy & Sell Pre-Owned Items')

@section('head')
<style>
    /* ── Page ───────────────────────────────────────── */
    .mr-page { background: #EAEDED; min-height: 80vh; }

    /* ── Hero ───────────────────────────────────────── */
    .mr-hero { background: linear-gradient(115deg,#131921 0%,#1a2a3a 50%,#0d1f2d 100%); padding: 32px 18px; position: relative; overflow: hidden; }
    .mr-hero::after { content: ''; position: absolute; right: -60px; top: -60px; width: 320px; height: 320px; background: rgba(255,255,255,.05); border-radius: 50%; pointer-events: none; }
    .mr-hero::before { content: ''; position: absolute; right: 80px; bottom: -80px; width: 200px; height: 200px; background: rgba(255,255,255,.04); border-radius: 50%; pointer-events: none; }
    .mr-hero-inner { max-width: 1340px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap; position: relative; z-index: 1; }
    .mr-hero-eyebrow { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,153,0,.15); border: 1px solid rgba(255,153,0,.4); border-radius: 20px; padding: 4px 14px; font-size: 12px; color: #FF9900; font-weight: 700; letter-spacing: .5px; margin-bottom: 10px; text-transform: uppercase; }
    .mr-hero-left h1 { font-size: 32px; font-weight: 900; color: #fff; margin: 0 0 10px; line-height: 1.15; }
    .mr-hero-left h1 span { color: #FF9900; }
    .mr-hero-left p { font-size: 14px; color: #adbac7; margin: 0 0 16px; max-width: 500px; line-height: 1.6; }
    .mr-hero-btns { display: flex; gap: 10px; flex-wrap: wrap; }
    .mr-hero-btn { display: inline-flex; align-items: center; gap: 7px; border-radius: 6px; padding: 10px 20px; font-size: 13px; font-weight: 700; cursor: pointer; text-decoration: none; transition: all .12s; }
    .mr-hero-btn.primary { background: #FFD814; border: 1px solid #FCD200; color: #131921; }
    .mr-hero-btn.primary:hover { background: #F7CA00; color: #131921; }
    .mr-hero-btn.secondary { background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.3); color: #fff; }
    .mr-hero-btn.secondary:hover { background: rgba(255,255,255,.2); color: #fff; }
    .mr-hero-stats { display: flex; gap: 14px; flex-wrap: wrap; }
    .mr-hero-stat { text-align: center; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.15); border-radius: 10px; padding: 14px 18px; min-width: 80px; }
    .mr-hero-stat-num { font-size: 26px; font-weight: 900; color: #FF9900; line-height: 1; }
    .mr-hero-stat-label { font-size: 11px; color: #adbac7; text-transform: uppercase; letter-spacing: .5px; margin-top: 4px; }

    /* ── Trust bar ──────────────────────────────────── */
    .mr-trust-bar { background: #1a2a3a; border-bottom: 1px solid rgba(255,153,0,.2); }
    .mr-trust-inner { max-width: 1340px; margin: 0 auto; padding: 10px 18px; display: flex; align-items: center; gap: 28px; flex-wrap: wrap; justify-content: center; }
    .mr-trust-item { display: flex; align-items: center; gap: 7px; font-size: 12px; color: #adbac7; font-weight: 500; white-space: nowrap; }
    .mr-trust-item svg { flex-shrink: 0; color: #FF9900; }

    /* ── Breadcrumb ─────────────────────────────────── */
    .mr-breadcrumb { max-width: 1340px; margin: 0 auto; padding: 10px 18px; font-size: 13px; color: #555; }
    .mr-breadcrumb a { color: #007185; }
    .mr-breadcrumb a:hover { color: #C7511F; text-decoration: underline; }

    /* ── Filter tabs ────────────────────────────────── */
    .mr-tabs-wrap { background: #fff; border-bottom: 2px solid #e3e6e6; }
    .mr-tabs { max-width: 1340px; margin: 0 auto; padding: 0 18px; display: flex; gap: 0; overflow-x: auto; scrollbar-width: none; }
    .mr-tabs::-webkit-scrollbar { display: none; }
    .mr-tab { display: inline-flex; align-items: center; gap: 6px; padding: 13px 18px; font-size: 13px; font-weight: 500; color: #555; white-space: nowrap; border-bottom: 3px solid transparent; cursor: pointer; text-decoration: none; transition: color .12s, border-color .12s; flex-shrink: 0; }
    .mr-tab:hover { color: #C7511F; border-bottom-color: #FF9900; }
    .mr-tab.active { color: #C7511F; border-bottom-color: #FF9900; font-weight: 700; }
    .mr-tab-count { background: #FF9900; color: #131921; font-size: 10px; font-weight: 800; border-radius: 99px; padding: 1px 7px; }
    .mr-tab.active .mr-tab-count { background: #FF9900; }

    /* ── Layout ─────────────────────────────────────── */
    .mr-wrap { max-width: 1340px; margin: 0 auto; padding: 20px 18px 50px; display: flex; gap: 20px; align-items: flex-start; }

    /* ── Sidebar ────────────────────────────────────── */
    .mr-sidebar { width: 210px; flex-shrink: 0; }
    .mr-sb-box { background: #fff; border: 1px solid #e3e6e6; border-radius: 8px; overflow: hidden; margin-bottom: 14px; }
    .mr-sb-head { font-size: 14px; font-weight: 700; color: #0F1111; padding: 12px 16px 10px; border-bottom: 1px solid #f0f2f2; background: #f7f8f8; display: flex; align-items: center; gap: 7px; }
    .mr-sb-body { padding: 8px 0; }
    .mr-sb-item { display: flex; align-items: center; gap: 9px; padding: 8px 16px; font-size: 13px; color: #0F1111; cursor: pointer; text-decoration: none; transition: background .1s; border-left: 3px solid transparent; }
    .mr-sb-item:hover { background: #fff8ee; border-left-color: #FF9900; color: #C7511F; }
    .mr-sb-item.active { background: #fff4e0; border-left-color: #FF9900; font-weight: 700; color: #C7511F; }
    .mr-sb-item input[type=radio] { accent-color: #FF9900; width: 14px; height: 14px; flex-shrink: 0; }

    /* Sell CTA in sidebar */
    .mr-sell-cta { background: linear-gradient(135deg,#131921,#1a2a3a); border-radius: 8px; padding: 16px; margin-bottom: 14px; text-align: center; }
    .mr-sell-cta h4 { font-size: 14px; font-weight: 800; color: #fff; margin: 0 0 6px; }
    .mr-sell-cta p { font-size: 12px; color: #adbac7; margin: 0 0 12px; line-height: 1.5; }
    .mr-sell-cta-btn { display: block; background: #FFD814; border: 1px solid #FCD200; border-radius: 20px; padding: 9px; font-size: 13px; font-weight: 700; color: #131921; text-decoration: none; transition: background .12s; }
    .mr-sell-cta-btn:hover { background: #F7CA00; color: #131921; }

    /* Price range in sidebar */
    .mr-price-inputs { display: flex; gap: 6px; align-items: center; padding: 10px 16px; }
    .mr-price-inputs input { width: 60px; border: 1px solid #d5d9d9; border-radius: 4px; padding: 5px 6px; font-size: 12px; outline: none; }
    .mr-price-inputs input:focus { border-color: #FF9900; box-shadow: 0 0 0 2px rgba(255,153,0,.15); }
    .mr-price-inputs span { font-size: 12px; color: #555; }
    .mr-price-go { background: #FF9900; color: #131921; border: none; border-radius: 4px; padding: 5px 10px; font-size: 12px; font-weight: 700; cursor: pointer; }

    /* ── Main area ──────────────────────────────────── */
    .mr-main { flex: 1; min-width: 0; }
    .mr-topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-wrap: wrap; gap: 10px; }
    .mr-topbar-left { font-size: 14px; color: #555; }
    .mr-topbar-left b { color: #0F1111; }
    .mr-topbar-right { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #555; }
    .mr-topbar-right select { border: 1px solid #d5d9d9; border-radius: 6px; padding: 6px 10px; font-size: 13px; background: #fff; cursor: pointer; outline: none; }

    /* View toggle */
    .mr-view-toggle { display: flex; border: 1px solid #d5d9d9; border-radius: 6px; overflow: hidden; }
    .mr-view-btn { background: #fff; border: none; padding: 6px 10px; cursor: pointer; color: #555; display: flex; align-items: center; transition: background .1s; }
    .mr-view-btn.active { background: #131921; color: #fff; }
    .mr-view-btn:hover:not(.active) { background: #f0f2f2; }

    /* ── Product grid ───────────────────────────────── */
    .mr-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 14px; }
    .mr-list-view .mr-grid { grid-template-columns: 1fr; }

    /* ── Product card — grid view ───────────────────── */
    .mr-card { background: #fff; border: 1px solid #e3e6e6; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; position: relative; transition: box-shadow .15s, border-color .15s; cursor: pointer; }
    .mr-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.12); border-color: #FF9900; }

    /* Verified seller ribbon */
    .mr-verified-ribbon { position: absolute; top: 0; left: 0; right: 0; background: linear-gradient(90deg,#131921,#1a2a3a); color: #FF9900; font-size: 10px; font-weight: 700; text-align: center; padding: 3px; z-index: 5; letter-spacing: .5px; display: flex; align-items: center; justify-content: center; gap: 4px; }

    /* Image */
    .mr-card-img-wrap { position: relative; background: #f7f8f8; aspect-ratio: 1/1; display: flex; align-items: center; justify-content: center; overflow: hidden; }
    .mr-card.has-ribbon .mr-card-img-wrap { padding-top: 20px; }
    .mr-card-img-wrap img { max-width: 82%; max-height: 82%; object-fit: contain; transition: transform .2s; }
    .mr-card:hover .mr-card-img-wrap img { transform: scale(1.04); }

    /* Condition badge */
    .mr-cond-badge { position: absolute; top: 8px; left: 8px; border-radius: 4px; padding: 3px 9px; font-size: 11px; font-weight: 800; z-index: 2; }
    .mr-cond-badge.like-new { background: #007600; color: #fff; }
    .mr-cond-badge.good { background: #007185; color: #fff; }
    .mr-cond-badge.fair { background: #E65100; color: #fff; }
    .mr-cond-badge.for-parts { background: #444; color: #fff; }

    /* Saves / hearts */
    .mr-save-btn { position: absolute; top: 8px; right: 8px; width: 30px; height: 30px; border-radius: 50%; background: rgba(255,255,255,.9); display: flex; align-items: center; justify-content: center; z-index: 3; cursor: pointer; border: 1px solid #e3e6e6; transition: all .12s; }
    .mr-save-btn:hover { background: #fff; border-color: #CC0C39; }
    .mr-save-btn svg { transition: fill .12s; }
    .mr-save-btn.saved svg { fill: #CC0C39; stroke: #CC0C39; }

    /* Time posted overlay */
    .mr-time-overlay { position: absolute; bottom: 8px; left: 8px; background: rgba(0,0,0,.6); color: #fff; font-size: 10px; font-weight: 600; border-radius: 4px; padding: 2px 7px; z-index: 3; backdrop-filter: blur(2px); }

    /* Body */
    .mr-card-body { padding: 12px 12px 14px; flex: 1; display: flex; flex-direction: column; gap: 5px; }

    /* Seller info row */
    .mr-seller-row { display: flex; align-items: center; gap: 7px; }
    .mr-seller-avatar { width: 22px; height: 22px; border-radius: 50%; background: linear-gradient(135deg,#131921,#FF9900); display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 800; color: #fff; flex-shrink: 0; }
    .mr-seller-name { font-size: 11px; color: #C7511F; font-weight: 700; }
    .mr-seller-rating { display: flex; align-items: center; gap: 3px; font-size: 11px; color: #555; margin-left: auto; }
    .mr-seller-rating svg { fill: #FF9900; }
    .mr-verified-icon { color: #FF9900; }

    .mr-card-name { font-size: 13px; color: #0F1111; line-height: 1.4; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }

    /* Product stars */
    .mr-prod-stars { display: flex; align-items: center; gap: 2px; }
    .mr-prod-stars span { font-size: 11px; color: #555; margin-left: 3px; }

    /* Price */
    .mr-price-row { display: flex; align-items: baseline; gap: 6px; margin-top: 4px; flex-wrap: wrap; }
    .mr-price-now { font-size: 20px; font-weight: 900; color: #B12704; }
    .mr-price-now sup { font-size: 12px; vertical-align: super; }
    .mr-price-retail { font-size: 12px; color: #888; }
    .mr-price-retail s { color: #aaa; }
    .mr-save-tag { font-size: 11px; background: #fff4e0; color: #C7511F; border: 1px solid #FFD580; border-radius: 4px; padding: 2px 6px; font-weight: 700; }

    /* Condition label */
    .mr-cond-label { display: flex; align-items: center; gap: 5px; font-size: 12px; background: #f7f8f8; border-radius: 4px; padding: 4px 8px; }
    .mr-cond-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }

    /* Tags */
    .mr-tags { display: flex; gap: 5px; flex-wrap: wrap; margin-top: 3px; }
    .mr-tag { font-size: 10px; background: #f0f2f2; color: #555; border-radius: 4px; padding: 2px 7px; font-weight: 500; }
    .mr-tag.free-ship { background: #fff4e0; color: #C7511F; }
    .mr-tag.returns { background: #F0FFF4; color: #007600; }
    .mr-tag.hot { background: #FFF0F0; color: #CC0C39; font-weight: 700; }

    /* Actions */
    .mr-card-actions { display: flex; gap: 6px; margin-top: 8px; }
    .mr-buy-btn { flex: 1; display: flex; align-items: center; justify-content: center; gap: 5px; background: #FFD814; border: 1px solid #FCD200; border-radius: 20px; padding: 8px; font-size: 12px; font-weight: 700; color: #131921; cursor: pointer; text-decoration: none; transition: background .12s; }
    .mr-buy-btn:hover { background: #F7CA00; color: #131921; }
    .mr-msg-btn { width: 36px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; background: #fff; border: 1px solid #d5d9d9; border-radius: 20px; cursor: pointer; color: #555; transition: all .12s; }
    .mr-msg-btn:hover { border-color: #FF9900; color: #C7511F; background: #fff8ee; }

    /* ── List view card ─────────────────────────────── */
    .mr-list-view .mr-card { flex-direction: row; }
    .mr-list-view .mr-card-img-wrap { width: 160px; flex-shrink: 0; aspect-ratio: auto; height: 160px; }
    .mr-list-view .mr-card-body { padding: 14px 16px; }
    .mr-list-view .mr-card-actions { margin-top: auto; }

    /* ── Featured sellers ───────────────────────────── */
    .mr-sellers-section { background: #fff; border: 1px solid #e3e6e6; border-radius: 8px; padding: 18px; margin-bottom: 20px; }
    .mr-sellers-section h3 { font-size: 15px; font-weight: 700; color: #0F1111; margin: 0 0 14px; display: flex; align-items: center; gap: 7px; border-bottom: 2px solid #FF9900; padding-bottom: 10px; }
    .mr-sellers-row { display: flex; gap: 12px; overflow-x: auto; scrollbar-width: none; padding-bottom: 4px; }
    .mr-sellers-row::-webkit-scrollbar { display: none; }
    .mr-seller-card { flex-shrink: 0; background: #f7f8f8; border: 1px solid #e3e6e6; border-radius: 8px; padding: 14px 16px; min-width: 150px; text-align: center; text-decoration: none; transition: all .12s; cursor: pointer; }
    .mr-seller-card:hover { border-color: #FF9900; background: #fff8ee; }
    .mr-seller-card-avatar { width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg,#131921,#FF9900); display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 900; color: #fff; margin: 0 auto 8px; }
    .mr-seller-card-name { font-size: 13px; font-weight: 700; color: #0F1111; margin-bottom: 3px; }
    .mr-seller-card-meta { font-size: 11px; color: #555; }
    .mr-seller-card-stars { display: flex; align-items: center; justify-content: center; gap: 2px; margin-top: 4px; }
    .mr-seller-verified { display: inline-flex; align-items: center; gap: 3px; font-size: 10px; color: #C7511F; font-weight: 700; margin-top: 4px; }

    /* ── How it works ───────────────────────────────── */
    .mr-how-section { background: #fff; border: 1px solid #e3e6e6; border-radius: 8px; padding: 20px; margin-top: 24px; }
    .mr-how-section h3 { font-size: 16px; font-weight: 700; color: #0F1111; margin: 0 0 18px; display: flex; align-items: center; gap: 8px; border-bottom: 2px solid #FF9900; padding-bottom: 10px; }
    .mr-how-steps { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 14px; }
    .mr-how-step { position: relative; display: flex; flex-direction: column; align-items: center; text-align: center; gap: 8px; padding: 14px; background: #f7f8f8; border-radius: 8px; }
    .mr-how-step-num { width: 36px; height: 36px; border-radius: 50%; background: #FF9900; color: #131921; font-size: 16px; font-weight: 900; display: flex; align-items: center; justify-content: center; }
    .mr-how-step h4 { font-size: 13px; font-weight: 700; color: #0F1111; margin: 0; }
    .mr-how-step p { font-size: 12px; color: #555; margin: 0; line-height: 1.5; }

    /* ── Empty state ────────────────────────────────── */
    .mr-empty { text-align: center; padding: 60px 20px; background: #fff; border-radius: 8px; border: 1px solid #e3e6e6; }

    @media (max-width: 760px) {
        .mr-wrap { flex-direction: column; }
        .mr-sidebar { width: 100%; }
        .mr-grid { grid-template-columns: repeat(2, 1fr); }
        .mr-hero-inner { flex-direction: column; }
        .mr-list-view .mr-card { flex-direction: column; }
        .mr-list-view .mr-card-img-wrap { width: 100%; height: auto; aspect-ratio: 1/1; }
    }
    @media (max-width: 480px) {
        .mr-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
@php
    /* ── Helpers ─────────────────────────────────── */
    $conditions   = ['Like New', 'Like New', 'Good', 'Good', 'Fair', 'Good'];
    $condClass    = ['Like New'=>'like-new','Good'=>'good','Fair'=>'fair','For Parts'=>'for-parts'];
    $condColor    = ['Like New'=>'#007600','Good'=>'#1565C0','Fair'=>'#E65100','For Parts'=>'#444'];
    $discounts    = [10,15,18,22,25,28,32,35,40,45];
    $sellerNames  = ['TechReseller','GadgetHub','QuickFlips','DealFinder','ProSeller','ItemKing','BargainBox','FastShip'];
    $sellerRatings= [4.5,4.6,4.7,4.8,4.9,5.0,4.3,4.4];
    $sellerSales  = [124,267,89,512,1043,78,345,210];
    $isVerified   = [true,false,true,true,false,true,false,true];
    $timePosted   = ['2 min ago','15 min ago','1 hr ago','3 hrs ago','Yesterday','2 days ago','Just now','30 min ago'];
    $isFreeShip   = [true,false,true,true,false,false,true,false];
    $isReturns    = [true,true,false,true,true,false,false,true];
    $isHot        = [false,false,true,false,false,true,false,true];
    $prodRatings  = [3.9,4.1,4.3,4.5,4.6,4.7,4.8,4.2];
    $prodReviews  = [34,78,120,204,389,512,1024,87];

    function mrDisc($id,$arr){ return $arr[$id % count($arr)]; }
    function mrSellerInitials($name){ $w=explode(' ',$name); return count($w)>=2 ? strtoupper(substr($w[0],0,1).substr($w[1],0,1)) : strtoupper(substr($name,0,2)); }
    function mrStars($r){
        $f=floor($r);$h=($r-$f)>=0.5?1:0;$e=5-$f-$h;$o='';
        for($i=0;$i<$f;$i++)  $o.='<svg width="11" height="11" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        if($h) $o.='<svg width="11" height="11" viewBox="0 0 24 24" fill="#ddd" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        for($i=0;$i<$e;$i++)  $o.='<svg width="11" height="11" viewBox="0 0 24 24" fill="#ddd" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        return $o;
    }

    $activeTab  = request('tab', 'all');
    $activeCond = request('condition');
    $activeCat  = request('category');
    $activeBrand= request('brand');
    $activeSort = request('sort', 'newest');
    $viewMode   = request('view', 'grid');
@endphp

<div class="mr-page">

{{-- Hero --}}
<div class="mr-hero">
    <div class="mr-hero-inner">
        <div class="mr-hero-left">
            <div class="mr-hero-eyebrow">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Peer-to-Peer Marketplace
            </div>
            <h1>MyShop <span>Resale Products</span></h1>
            <p>Buy and sell pre-owned items directly from trusted sellers in our community. Great prices, verified sellers, buyer protection guaranteed.</p>
            <div class="mr-hero-btns">
                <a href="#mr-listings" class="mr-hero-btn primary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Browse Listings
                </a>
                <a href="#" class="mr-hero-btn secondary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    List an Item
                </a>
            </div>
        </div>
        <div class="mr-hero-stats">
            <div class="mr-hero-stat">
                <div class="mr-hero-stat-num">{{ $products->count() }}+</div>
                <div class="mr-hero-stat-label">Listings</div>
            </div>
            <div class="mr-hero-stat">
                <div class="mr-hero-stat-num">{{ min($products->count(), 8) }}+</div>
                <div class="mr-hero-stat-label">Sellers</div>
            </div>
            <div class="mr-hero-stat">
                <div class="mr-hero-stat-num">100%</div>
                <div class="mr-hero-stat-label">Protected</div>
            </div>
        </div>
    </div>
</div>

{{-- Trust bar --}}
<div class="mr-trust-bar">
    <div class="mr-trust-inner">
        <div class="mr-trust-item">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Buyer Protection
        </div>
        <div class="mr-trust-item">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            Verified Sellers
        </div>
        <div class="mr-trust-item">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            Secure Payments
        </div>
        <div class="mr-trust-item">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
            Easy Returns
        </div>
        <div class="mr-trust-item">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            Chat with Sellers
        </div>
        <div class="mr-trust-item">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Fast Shipping
        </div>
    </div>
</div>

{{-- Breadcrumb --}}
<div style="background:#fff;border-bottom:1px solid #e3e6e6;">
    <div class="mr-breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span> › </span>
        <span style="color:#0F1111;">MyShop Resale</span>
    </div>
</div>

{{-- Tabs --}}
<div class="mr-tabs-wrap">
    <div class="mr-tabs">
        <a href="{{ route('myshop-resale') }}" class="mr-tab {{ $activeTab=='all' ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            All Listings
            <span class="mr-tab-count">{{ $products->count() }}</span>
        </a>
        <a href="{{ route('myshop-resale', ['tab'=>'new']) }}" class="mr-tab {{ $activeTab=='new' ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Newly Listed
        </a>
        <a href="{{ route('myshop-resale', ['tab'=>'verified']) }}" class="mr-tab {{ $activeTab=='verified' ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Verified Sellers
        </a>
        <a href="{{ route('myshop-resale', ['tab'=>'liked']) }}" class="mr-tab {{ $activeTab=='liked' ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            Saved Listings
        </a>
        @foreach($categories->take(6) as $cat)
        <a href="{{ route('myshop-resale', ['category'=>$cat->id]) }}" class="mr-tab {{ $activeCat==$cat->id ? 'active' : '' }}">
            {{ $cat->name }}
        </a>
        @endforeach
    </div>
</div>

{{-- Body --}}
<div class="mr-wrap">

    {{-- SIDEBAR --}}
    <div class="mr-sidebar">

        {{-- Sell CTA --}}
        <div class="mr-sell-cta">
            <h4>Sell Your Items</h4>
            <p>List in minutes, reach thousands of buyers, get paid fast.</p>
            <a href="#" class="mr-sell-cta-btn">
                + Start Selling
            </a>
        </div>

        {{-- Condition --}}
        <div class="mr-sb-box">
            <div class="mr-sb-head">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#1565C0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Condition
            </div>
            <div class="mr-sb-body">
                <a href="{{ route('myshop-resale', request()->except('condition')) }}" class="mr-sb-item {{ !$activeCond ? 'active' : '' }}">
                    <input type="radio" {{ !$activeCond ? 'checked' : '' }} readonly /> All Conditions
                </a>
                @foreach(['like-new'=>['label'=>'Like New','color'=>'#007600'],'good'=>['label'=>'Good','color'=>'#1565C0'],'fair'=>['label'=>'Fair','color'=>'#E65100'],'for-parts'=>['label'=>'For Parts','color'=>'#444']] as $k=>$c)
                <a href="{{ route('myshop-resale', array_merge(request()->except('condition'),['condition'=>$k])) }}" class="mr-sb-item {{ $activeCond==$k ? 'active' : '' }}">
                    <input type="radio" {{ $activeCond==$k ? 'checked' : '' }} readonly />
                    <span style="width:9px;height:9px;border-radius:50%;background:{{ $c['color'] }};display:inline-block;flex-shrink:0;"></span>
                    {{ $c['label'] }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Category --}}
        @if($categories->isNotEmpty())
        <div class="mr-sb-box">
            <div class="mr-sb-head">Category</div>
            <div class="mr-sb-body">
                <a href="{{ route('myshop-resale', request()->except('category')) }}" class="mr-sb-item {{ !$activeCat ? 'active' : '' }}">
                    <input type="radio" {{ !$activeCat ? 'checked' : '' }} readonly /> All Categories
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('myshop-resale', array_merge(request()->except('category'),['category'=>$cat->id])) }}" class="mr-sb-item {{ $activeCat==$cat->id ? 'active' : '' }}">
                    <input type="radio" {{ $activeCat==$cat->id ? 'checked' : '' }} readonly /> {{ $cat->name }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Brand --}}
        @if($brands->isNotEmpty())
        <div class="mr-sb-box">
            <div class="mr-sb-head">Brand</div>
            <div class="mr-sb-body">
                <a href="{{ route('myshop-resale', request()->except('brand')) }}" class="mr-sb-item {{ !$activeBrand ? 'active' : '' }}">
                    <input type="radio" {{ !$activeBrand ? 'checked' : '' }} readonly /> All Brands
                </a>
                @foreach($brands->take(10) as $brand)
                <a href="{{ route('myshop-resale', array_merge(request()->except('brand'),['brand'=>$brand->id])) }}" class="mr-sb-item {{ $activeBrand==$brand->id ? 'active' : '' }}">
                    <input type="radio" {{ $activeBrand==$brand->id ? 'checked' : '' }} readonly /> {{ $brand->name }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Seller type --}}
        <div class="mr-sb-box">
            <div class="mr-sb-head">Seller Type</div>
            <div class="mr-sb-body">
                @foreach(['all'=>'All Sellers','verified'=>'Verified Only','top'=>'Top Rated','new'=>'New Sellers'] as $k=>$lbl)
                <a href="{{ route('myshop-resale', array_merge(request()->except('seller'),['seller'=>$k])) }}" class="mr-sb-item {{ (request('seller',$k=='all'?'all':''))==$k ? 'active' : '' }}">
                    <input type="radio" {{ (request('seller','all'))==$k ? 'checked' : '' }} readonly /> {{ $lbl }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Price range --}}
        <div class="mr-sb-box">
            <div class="mr-sb-head">Price Range</div>
            <div class="mr-price-inputs">
                <input type="number" placeholder="Min" value="{{ request('min_price') }}" id="mr-min-price" />
                <span>—</span>
                <input type="number" placeholder="Max" value="{{ request('max_price') }}" id="mr-max-price" />
                <button class="mr-price-go" onclick="mrApplyPrice()">Go</button>
            </div>
        </div>

    </div>

    {{-- MAIN --}}
    <div class="mr-main" id="mr-listings">

        {{-- Featured sellers --}}
        <div class="mr-sellers-section">
            <h3>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1565C0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Top Resellers
            </h3>
            <div class="mr-sellers-row">
                @foreach($sellerNames as $idx => $sName)
                <div class="mr-seller-card">
                    <div class="mr-seller-card-avatar">{{ mrSellerInitials($sName) }}</div>
                    <div class="mr-seller-card-name">{{ $sName }}</div>
                    <div class="mr-seller-card-meta">{{ $sellerSales[$idx % count($sellerSales)] }} sales</div>
                    <div class="mr-seller-card-stars">
                        {!! mrStars($sellerRatings[$idx % count($sellerRatings)]) !!}
                    </div>
                    @if($isVerified[$idx % count($isVerified)])
                    <div class="mr-seller-verified">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Verified
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        {{-- Topbar --}}
        <div class="mr-topbar">
            <div class="mr-topbar-left"><b>{{ $products->count() }}</b> listings available</div>
            <div class="mr-topbar-right">
                {{-- View toggle --}}
                <div class="mr-view-toggle">
                    <button class="mr-view-btn {{ $viewMode=='grid' ? 'active' : '' }}" onclick="setView('grid')" title="Grid view">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    </button>
                    <button class="mr-view-btn {{ $viewMode=='list' ? 'active' : '' }}" onclick="setView('list')" title="List view">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    </button>
                </div>
                Sort by:
                <select onchange="window.location.href=this.value">
                    <option value="{{ route('myshop-resale', array_merge(request()->all(),['sort'=>'newest'])) }}" {{ $activeSort=='newest' ? 'selected' : '' }}>Newest First</option>
                    <option value="{{ route('myshop-resale', array_merge(request()->all(),['sort'=>'price_asc'])) }}" {{ $activeSort=='price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="{{ route('myshop-resale', array_merge(request()->all(),['sort'=>'price_desc'])) }}" {{ $activeSort=='price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="{{ route('myshop-resale', array_merge(request()->all(),['sort'=>'rating'])) }}" {{ $activeSort=='rating' ? 'selected' : '' }}>Seller Rating</option>
                    <option value="{{ route('myshop-resale', array_merge(request()->all(),['sort'=>'discount'])) }}" {{ $activeSort=='discount' ? 'selected' : '' }}>Best Value</option>
                </select>
            </div>
        </div>

        {{-- Grid --}}
        @if($products->isEmpty())
            <div class="mr-empty">
                <svg width="72" height="72" viewBox="0 0 24 24" fill="none" stroke="#ddd" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="margin:0 auto 16px;display:block;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                <h3 style="font-size:18px;font-weight:700;color:#0F1111;margin-bottom:8px;">No listings found</h3>
                <p style="font-size:14px;color:#555;margin-bottom:14px;">Be the first to list an item or check back soon.</p>
                <a href="{{ route('myshop-resale') }}" style="color:#007185;font-size:13px;display:block;margin-bottom:8px;">Clear all filters</a>
                <a href="#" class="mr-hero-btn primary" style="display:inline-flex;margin-top:8px;">+ List an Item</a>
            </div>
        @else
        <div id="mr-grid-container" class="{{ $viewMode=='list' ? 'mr-list-view' : '' }}">
        <div class="mr-grid">
            @foreach($products as $product)
            @php
                $imgs       = collect($product->images ?? [])->filter()->values();
                $thumb      = $imgs->first() ? \Illuminate\Support\Facades\Storage::url($imgs->first()) : null;
                $disc       = mrDisc($product->id, $discounts);
                $condition  = $conditions[$product->id % count($conditions)];
                $condCls    = $condClass[$condition];
                $condClr    = $condColor[$condition];
                $sellerIdx  = $product->id % count($sellerNames);
                $seller     = $sellerNames[$sellerIdx];
                $sellerRate = $sellerRatings[$sellerIdx];
                $sellerSale = $sellerSales[$sellerIdx];
                $verified   = $isVerified[$product->id % count($isVerified)];
                $posted     = $timePosted[$product->id % count($timePosted)];
                $freeShip   = $isFreeShip[$product->id % count($isFreeShip)];
                $returns    = $isReturns[$product->id % count($isReturns)];
                $hot        = $isHot[$product->id % count($isHot)];
                $pRating    = $prodRatings[$product->id % count($prodRatings)];
                $pReviews   = $prodReviews[$product->id % count($prodReviews)];
                $saveAmt    = round($product->price * $disc / 100, 2);
                $afterP     = round($product->price - $saveAmt, 2);
            @endphp
            <div class="mr-card {{ $verified ? 'has-ribbon' : '' }}" onclick="window.location='{{ route('products.show', $product->slug) }}'">

                @if($verified)
                <div class="mr-verified-ribbon">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Verified Seller
                </div>
                @endif

                <div class="mr-card-img-wrap">
                    @if($thumb)
                        <img src="{{ $thumb }}" alt="{{ $product->name }}" loading="lazy" />
                    @else
                        <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#d5d9d9" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    @endif

                    <div class="mr-cond-badge {{ $condCls }}">{{ $condition }}</div>

                    <button class="mr-save-btn" onclick="event.stopPropagation(); toggleSave(this)" title="Save listing">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#CC0C39" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    </button>

                    <div class="mr-time-overlay">{{ $posted }}</div>
                </div>

                <div class="mr-card-body">
                    {{-- Seller row --}}
                    <div class="mr-seller-row">
                        <div class="mr-seller-avatar">{{ mrSellerInitials($seller) }}</div>
                        <span class="mr-seller-name">{{ $seller }}</span>
                        @if($verified)
                        <svg class="mr-verified-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        @endif
                        <span class="mr-seller-rating">
                            <svg width="10" height="10" viewBox="0 0 24 24" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            {{ $sellerRate }}
                        </span>
                    </div>

                    <div class="mr-card-name">{{ $product->name }}</div>

                    {{-- Product stars --}}
                    <div class="mr-prod-stars">
                        {!! mrStars($pRating) !!}
                        <span>{{ $pRating }} ({{ number_format($pReviews) }})</span>
                    </div>

                    {{-- Price --}}
                    <div class="mr-price-row">
                        <span class="mr-price-now"><sup>$</sup>{{ number_format($afterP, 2) }}</span>
                        <span class="mr-price-retail">Retail: <s>${{ number_format($product->price, 2) }}</s></span>
                    </div>
                    <span class="mr-save-tag" style="display:inline-block;">{{ $disc }}% below retail</span>

                    {{-- Condition --}}
                    <div class="mr-cond-label">
                        <span class="mr-cond-dot" style="background:{{ $condClr }};"></span>
                        Condition: <b style="color:{{ $condClr }}; margin-left:3px;">{{ $condition }}</b>
                    </div>

                    {{-- Tags --}}
                    <div class="mr-tags">
                        @if($freeShip) <span class="mr-tag free-ship">Free Shipping</span> @endif
                        @if($returns)  <span class="mr-tag returns">Returns OK</span> @endif
                        @if($hot)      <span class="mr-tag hot">🔥 Hot</span> @endif
                        @if($product->category) <span class="mr-tag">{{ $product->category->name }}</span> @endif
                    </div>

                    {{-- Actions --}}
                    <div class="mr-card-actions">
                        <a href="{{ route('products.show', $product->slug) }}" class="mr-buy-btn" onclick="event.stopPropagation();">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            Buy Now
                        </a>
                        <button class="mr-msg-btn" onclick="event.stopPropagation();" title="Message seller">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        </button>
                    </div>
                </div>

            </div>
            @endforeach
        </div>
        </div>
        @endif

        {{-- How it works --}}
        <div class="mr-how-section">
            <h3>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1565C0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                How MyShop Resale Works
            </h3>
            <div class="mr-how-steps">
                <div class="mr-how-step">
                    <div class="mr-how-step-num">1</div>
                    <h4>Browse Listings</h4>
                    <p>Search thousands of pre-owned items listed by verified sellers in your community.</p>
                </div>
                <div class="mr-how-step">
                    <div class="mr-how-step-num">2</div>
                    <h4>Buy or Make Offer</h4>
                    <p>Buy instantly at listed price or send an offer — sellers can accept, decline, or counter.</p>
                </div>
                <div class="mr-how-step">
                    <div class="mr-how-step-num">3</div>
                    <h4>Secure Checkout</h4>
                    <p>Pay securely through MyShop. Payment is held until you confirm receipt of your item.</p>
                </div>
                <div class="mr-how-step">
                    <div class="mr-how-step-num">4</div>
                    <h4>Receive & Review</h4>
                    <p>Get your item, confirm it matches the listing, and leave a review for the seller.</p>
                </div>
                <div class="mr-how-step">
                    <div class="mr-how-step-num">5</div>
                    <h4>Sell Your Items</h4>
                    <p>List your own pre-owned items for free and reach thousands of buyers instantly.</p>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

<script>
function setView(mode) {
    const container = document.getElementById('mr-grid-container');
    if (!container) return;
    if (mode === 'list') {
        container.classList.add('mr-list-view');
    } else {
        container.classList.remove('mr-list-view');
    }
    document.querySelectorAll('.mr-view-btn').forEach(b => b.classList.remove('active'));
    event.currentTarget.classList.add('active');
}

function toggleSave(btn) {
    btn.classList.toggle('saved');
    const isSaved = btn.classList.contains('saved');
    const svg = btn.querySelector('svg');
    if (isSaved) {
        svg.setAttribute('fill', '#CC0C39');
        showMrToast('Listing saved!');
    } else {
        svg.setAttribute('fill', 'none');
        showMrToast('Listing removed from saved');
    }
}

function mrApplyPrice() {
    const min = document.getElementById('mr-min-price').value;
    const max = document.getElementById('mr-max-price').value;
    const url = new URL(window.location.href);
    if (min) url.searchParams.set('min_price', min);
    else url.searchParams.delete('min_price');
    if (max) url.searchParams.set('max_price', max);
    else url.searchParams.delete('max_price');
    window.location.href = url.toString();
}

function showMrToast(msg) {
    let t = document.getElementById('mrToast');
    if (!t) {
        t = document.createElement('div');
        t.id = 'mrToast';
        t.style.cssText = 'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#131921;color:#FF9900;padding:11px 22px;border-radius:6px;font-size:13px;z-index:99999;box-shadow:0 4px 16px rgba(0,0,0,.3);transition:opacity .3s;white-space:nowrap;';
        document.body.appendChild(t);
    }
    t.textContent = msg;
    t.style.opacity = '1';
    clearTimeout(t._timer);
    t._timer = setTimeout(() => { t.style.opacity = '0'; }, 2500);
}
</script>
@endsection
