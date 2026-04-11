@extends('store.layout')
@section('title', 'Renewed Deals — Certified Refurbished Products — MyShop')

@section('head')
<style>
    /* ── Page base ──────────────────────────────────── */
    .rd-page { background: #EAEDED; min-height: 80vh; }

    /* ── Hero ────────────────────────────────────────── */
    .rd-hero { background: linear-gradient(110deg,#0a3d2e 0%,#145a3c 50%,#0d4a30 100%); padding: 30px 18px; }
    .rd-hero-inner { max-width: 1340px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap; }
    .rd-hero-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.25); border-radius: 20px; padding: 4px 14px; font-size: 12px; color: #a8f0c6; font-weight: 600; letter-spacing: .4px; margin-bottom: 10px; }
    .rd-hero-left h1 { font-size: 30px; font-weight: 900; color: #fff; margin: 0 0 8px; line-height: 1.2; }
    .rd-hero-left h1 span { color: #4ade80; }
    .rd-hero-left p { font-size: 14px; color: #86efac; margin: 0 0 14px; max-width: 500px; line-height: 1.6; }
    .rd-hero-trust { display: flex; gap: 20px; flex-wrap: wrap; }
    .rd-hero-trust-item { display: flex; align-items: center; gap: 7px; font-size: 12px; color: #a8f0c6; }
    .rd-hero-trust-item svg { flex-shrink: 0; }
    .rd-hero-stats { display: flex; gap: 28px; flex-wrap: wrap; }
    .rd-hero-stat { text-align: center; background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.15); border-radius: 10px; padding: 14px 22px; }
    .rd-hero-stat-num { font-size: 26px; font-weight: 900; color: #4ade80; line-height: 1; }
    .rd-hero-stat-label { font-size: 11px; color: #86efac; text-transform: uppercase; letter-spacing: .5px; margin-top: 4px; }

    /* ── Condition legend bar ───────────────────────── */
    .rd-legend-bar { background: #1a3c2e; border-bottom: 1px solid #1e5a3a; }
    .rd-legend-inner { max-width: 1340px; margin: 0 auto; padding: 10px 18px; display: flex; align-items: center; gap: 24px; flex-wrap: wrap; }
    .rd-legend-title { font-size: 12px; font-weight: 700; color: #86efac; text-transform: uppercase; letter-spacing: .5px; flex-shrink: 0; }
    .rd-legend-item { display: flex; align-items: center; gap: 6px; font-size: 12px; color: #c8e6c9; }
    .rd-legend-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }

    /* ── Breadcrumb ─────────────────────────────────── */
    .rd-breadcrumb { max-width: 1340px; margin: 0 auto; padding: 10px 18px; font-size: 13px; color: #555; background: #fff; border-bottom: 1px solid #e3e6e6; }
    .rd-breadcrumb a { color: #007185; }
    .rd-breadcrumb a:hover { color: #C7511F; text-decoration: underline; }

    /* ── Filter chips ───────────────────────────────── */
    .rd-chips-wrap { background: #fff; border-bottom: 2px solid #e3e6e6; padding: 0 18px; }
    .rd-chips { max-width: 1340px; margin: 0 auto; display: flex; gap: 8px; overflow-x: auto; scrollbar-width: none; padding: 12px 0; align-items: center; }
    .rd-chips::-webkit-scrollbar { display: none; }
    .rd-chip { display: inline-flex; align-items: center; gap: 5px; padding: 7px 16px; border-radius: 20px; font-size: 13px; font-weight: 500; white-space: nowrap; cursor: pointer; text-decoration: none; border: 1.5px solid #d5d9d9; background: #fff; color: #0F1111; transition: all .12s; flex-shrink: 0; }
    .rd-chip:hover { border-color: #FF9900; color: #C7511F; background: #fffbf0; }
    .rd-chip.active { background: #0F1111; color: #fff; border-color: #0F1111; }
    .rd-chip.condition-like-new { border-color: #007600; color: #007600; }
    .rd-chip.condition-like-new.active, .rd-chip.condition-like-new:hover { background: #007600; color: #fff; border-color: #007600; }
    .rd-chip.condition-good { border-color: #0066c0; color: #0066c0; }
    .rd-chip.condition-good.active, .rd-chip.condition-good:hover { background: #0066c0; color: #fff; border-color: #0066c0; }
    .rd-chip.condition-acceptable { border-color: #b45309; color: #b45309; }
    .rd-chip.condition-acceptable.active, .rd-chip.condition-acceptable:hover { background: #b45309; color: #fff; border-color: #b45309; }

    /* ── Layout ─────────────────────────────────────── */
    .rd-wrap { max-width: 1340px; margin: 0 auto; padding: 20px 18px 50px; display: flex; gap: 20px; align-items: flex-start; }

    /* ── Sidebar ────────────────────────────────────── */
    .rd-sidebar { width: 210px; flex-shrink: 0; }
    .rd-sb-box { background: #fff; border: 1px solid #e3e6e6; border-radius: 8px; overflow: hidden; margin-bottom: 14px; }
    .rd-sb-head { font-size: 14px; font-weight: 700; color: #0F1111; padding: 12px 16px 10px; border-bottom: 1px solid #f0f2f2; background: #f7f8f8; }
    .rd-sb-body { padding: 8px 0; }
    .rd-sb-item { display: flex; align-items: center; gap: 9px; padding: 8px 16px; font-size: 13px; color: #0F1111; cursor: pointer; text-decoration: none; transition: background .1s; border-left: 3px solid transparent; }
    .rd-sb-item:hover { background: #f0fff4; border-left-color: #4ade80; color: #155724; }
    .rd-sb-item.active { background: #e8f5e9; border-left-color: #007600; font-weight: 700; color: #007600; }
    .rd-sb-item input[type=radio] { accent-color: #007600; width: 14px; height: 14px; flex-shrink: 0; }
    .rd-cond-swatch { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }

    /* ── Main area ──────────────────────────────────── */
    .rd-main { flex: 1; min-width: 0; }
    .rd-topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; flex-wrap: wrap; gap: 10px; }
    .rd-topbar-left { font-size: 14px; color: #555; }
    .rd-topbar-left b { color: #0F1111; }
    .rd-topbar-right { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #555; }
    .rd-topbar-right select { border: 1px solid #d5d9d9; border-radius: 6px; padding: 6px 10px; font-size: 13px; background: #fff; cursor: pointer; outline: none; }

    /* ── Info banner ────────────────────────────────── */
    .rd-info-banner { background: #f0fff4; border: 1px solid #86efac; border-radius: 8px; padding: 12px 16px; margin-bottom: 18px; display: flex; align-items: flex-start; gap: 10px; font-size: 13px; color: #14532d; }
    .rd-info-banner svg { flex-shrink: 0; margin-top: 1px; }

    /* ── Grid ───────────────────────────────────────── */
    .rd-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 16px; }

    /* ── Product card ───────────────────────────────── */
    .rd-card { background: #fff; border: 1px solid #e3e6e6; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; position: relative; transition: box-shadow .15s, border-color .15s; cursor: pointer; }
    .rd-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.12); border-color: #4ade80; }

    /* Image area */
    .rd-card-img-wrap { position: relative; background: #f7f8f8; aspect-ratio: 1/1; display: flex; align-items: center; justify-content: center; overflow: hidden; }
    .rd-card-img-wrap img { max-width: 85%; max-height: 85%; object-fit: contain; transition: transform .2s; }
    .rd-card:hover .rd-card-img-wrap img { transform: scale(1.04); }

    /* Condition badge top-left */
    .rd-cond-badge { position: absolute; top: 10px; left: 10px; border-radius: 4px; padding: 3px 9px; font-size: 11px; font-weight: 800; z-index: 2; letter-spacing: .2px; }
    .rd-cond-badge.like-new { background: #007600; color: #fff; }
    .rd-cond-badge.good { background: #0066c0; color: #fff; }
    .rd-cond-badge.acceptable { background: #92400e; color: #fff; }

    /* Discount badge top-right */
    .rd-disc-badge { position: absolute; top: 10px; right: 10px; background: #CC0C39; color: #fff; border-radius: 4px; padding: 3px 8px; font-size: 12px; font-weight: 800; z-index: 2; }

    /* Renewed ribbon bottom */
    .rd-renewed-ribbon { position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(90deg,#007600,#00a300); color: #fff; font-size: 11px; font-weight: 700; padding: 5px 10px; display: flex; align-items: center; gap: 5px; z-index: 2; }

    /* Warranty badge */
    .rd-warranty-badge { position: absolute; bottom: 28px; right: 8px; background: rgba(0,0,0,.6); color: #fff; font-size: 10px; font-weight: 700; border-radius: 4px; padding: 3px 7px; z-index: 3; backdrop-filter: blur(2px); }

    /* Card body */
    .rd-card-body { padding: 12px 12px 14px; flex: 1; display: flex; flex-direction: column; gap: 5px; }
    .rd-brand { font-size: 11px; color: #007185; font-weight: 700; text-transform: uppercase; letter-spacing: .3px; }
    .rd-name { font-size: 13px; color: #0F1111; line-height: 1.4; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
    .rd-stars { display: flex; align-items: center; gap: 2px; margin-top: 2px; }
    .rd-stars span { font-size: 11px; color: #555; margin-left: 3px; }

    .rd-price-row { display: flex; align-items: baseline; gap: 6px; margin-top: 4px; flex-wrap: wrap; }
    .rd-price-now { font-size: 20px; font-weight: 900; color: #B12704; }
    .rd-price-now sup { font-size: 13px; vertical-align: super; }
    .rd-price-now sub { font-size: 13px; vertical-align: baseline; }
    .rd-price-list { font-size: 12px; color: #888; }
    .rd-price-list s { color: #aaa; }
    .rd-save-tag { font-size: 11px; background: #F0FFF4; color: #007600; border: 1px solid #86efac; border-radius: 4px; padding: 2px 6px; font-weight: 700; }

    .rd-cond-label { display: flex; align-items: center; gap: 5px; font-size: 12px; color: #555; background: #f7f8f8; border-radius: 4px; padding: 4px 8px; margin-top: 2px; }
    .rd-cond-label .dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }

    .rd-features { display: flex; flex-direction: column; gap: 3px; margin-top: 4px; }
    .rd-feature { display: flex; align-items: center; gap: 5px; font-size: 11px; color: #555; }
    .rd-feature svg { flex-shrink: 0; color: #007600; }

    .rd-stock-bar-wrap { margin-top: 6px; }
    .rd-stock-label { font-size: 11px; color: #B12704; font-weight: 600; margin-bottom: 3px; }
    .rd-stock-bar { background: #e3e6e6; border-radius: 99px; height: 5px; overflow: hidden; }
    .rd-stock-bar-fill { background: linear-gradient(90deg, #CC0C39, #FF6B6B); border-radius: 99px; height: 100%; transition: width .3s; }

    .rd-add-btn { display: flex; align-items: center; justify-content: center; gap: 6px; width: 100%; background: #FFD814; border: 1px solid #FCD200; border-radius: 20px; padding: 9px; font-size: 13px; font-weight: 700; color: #131921; cursor: pointer; margin-top: 8px; text-decoration: none; transition: background .12s, transform .1s; }
    .rd-add-btn:hover { background: #F7CA00; transform: translateY(-1px); color: #131921; }
    .rd-detail-link { font-size: 12px; color: #007185; text-align: center; display: block; margin-top: 6px; }
    .rd-detail-link:hover { color: #C7511F; text-decoration: underline; }

    /* ── Certification section ──────────────────────── */
    .rd-cert-section { background: #fff; border: 1px solid #e3e6e6; border-radius: 8px; padding: 24px; margin-top: 28px; }
    .rd-cert-section h3 { font-size: 18px; font-weight: 700; color: #0F1111; margin: 0 0 8px; display: flex; align-items: center; gap: 8px; }
    .rd-cert-section p { font-size: 13px; color: #555; margin: 0 0 20px; line-height: 1.6; }
    .rd-cert-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; }
    .rd-cert-item { display: flex; align-items: flex-start; gap: 12px; padding: 14px; background: #f7f8f8; border-radius: 8px; border: 1px solid #e3e6e6; }
    .rd-cert-icon { width: 40px; height: 40px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .rd-cert-icon.green { background: #dcfce7; }
    .rd-cert-icon.blue { background: #dbeafe; }
    .rd-cert-icon.amber { background: #fef3c7; }
    .rd-cert-icon.purple { background: #ede9fe; }
    .rd-cert-item h4 { font-size: 13px; font-weight: 700; color: #0F1111; margin: 0 0 4px; }
    .rd-cert-item p { font-size: 12px; color: #555; margin: 0; line-height: 1.5; }

    /* ── Condition guide ────────────────────────────── */
    .rd-cond-guide { background: #fff; border: 1px solid #e3e6e6; border-radius: 8px; overflow: hidden; margin-top: 20px; }
    .rd-cond-guide-head { background: #f7f8f8; border-bottom: 1px solid #e3e6e6; padding: 14px 20px; font-size: 15px; font-weight: 700; color: #0F1111; display: flex; align-items: center; gap: 8px; }
    .rd-cond-table { width: 100%; border-collapse: collapse; }
    .rd-cond-table th { background: #f0f2f2; padding: 10px 16px; font-size: 12px; font-weight: 700; color: #555; text-align: left; border-bottom: 1px solid #e3e6e6; text-transform: uppercase; letter-spacing: .4px; }
    .rd-cond-table td { padding: 12px 16px; font-size: 13px; color: #0F1111; border-bottom: 1px solid #f0f2f2; vertical-align: top; }
    .rd-cond-table tr:last-child td { border-bottom: none; }
    .rd-cond-table tr:hover td { background: #fafafa; }
    .rd-cond-pill { display: inline-flex; align-items: center; gap: 5px; border-radius: 20px; padding: 4px 12px; font-size: 12px; font-weight: 700; }

    @media (max-width: 760px) {
        .rd-wrap { flex-direction: column; }
        .rd-sidebar { width: 100%; }
        .rd-grid { grid-template-columns: repeat(2, 1fr); }
        .rd-hero-inner { flex-direction: column; }
        .rd-cert-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 480px) {
        .rd-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
@php
    /* ── Helpers ─────────────────────────────────── */
    $conditions    = ['Like New', 'Like New', 'Good', 'Good', 'Acceptable'];
    $discounts     = [20, 25, 30, 35, 40, 45, 50, 55, 60];
    $warranties    = ['1-yr warranty', '90-day warranty', '6-mo warranty', '1-yr warranty', '2-yr warranty'];
    $stockPcts     = [22, 35, 48, 60, 72, 85, 91];
    $ratings       = [3.9, 4.0, 4.2, 4.3, 4.5, 4.6, 4.7, 4.8];
    $reviews       = [38, 74, 112, 205, 318, 490, 1034, 2215];
    $featureSets   = [
        ['Tested & certified', 'Original accessories', 'Clean cosmetics'],
        ['Fully functional', 'Inspected by experts', 'Battery 80%+ capacity'],
        ['Minor cosmetic wear', 'All functions tested', 'Cleaned & sanitized'],
        ['Tested & certified', 'Replacement accessories', '180-day guarantee'],
    ];

    $condColors = ['Like New' => '#007600', 'Good' => '#0066c0', 'Acceptable' => '#92400e'];
    $condBg     = ['Like New' => 'like-new', 'Good' => 'good', 'Acceptable' => 'acceptable'];

    function rdDisc($id, $arr) { return $arr[$id % count($arr)]; }
    function rdStars($r) {
        $f=floor($r); $h=($r-$f)>=0.5?1:0; $e=5-$f-$h; $o='';
        for($i=0;$i<$f;$i++)  $o.='<svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        if($h) $o.='<svg width="12" height="12" viewBox="0 0 24 24" fill="#ddd" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        for($i=0;$i<$e;$i++)  $o.='<svg width="12" height="12" viewBox="0 0 24 24" fill="#ddd" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        return $o;
    }

    $activeCondition = request('condition');
    $activeCat       = request('category');
    $activeBrand     = request('brand');
    $activeSort      = request('sort', 'featured');
@endphp

<div class="rd-page">

{{-- Hero --}}
<div class="rd-hero">
    <div class="rd-hero-inner">
        <div class="rd-hero-left">
            <div class="rd-hero-badge">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                MyShop Certified Renewed
            </div>
            <h1>Renewed <span>Deals</span></h1>
            <p>Certified refurbished products, tested to work and look like new. Backed by warranty and our renewed guarantee.</p>
            <div class="rd-hero-trust">
                <div class="rd-hero-trust-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Warranty Included
                </div>
                <div class="rd-hero-trust-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                    Professionally Refurbished
                </div>
                <div class="rd-hero-trust-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    Easy Returns
                </div>
                <div class="rd-hero-trust-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    Up to 60% Savings
                </div>
            </div>
        </div>
        <div class="rd-hero-stats">
            <div class="rd-hero-stat">
                <div class="rd-hero-stat-num">{{ $products->count() }}+</div>
                <div class="rd-hero-stat-label">Renewed Items</div>
            </div>
            <div class="rd-hero-stat">
                <div class="rd-hero-stat-num">60%</div>
                <div class="rd-hero-stat-label">Max Savings</div>
            </div>
            <div class="rd-hero-stat">
                <div class="rd-hero-stat-num">100%</div>
                <div class="rd-hero-stat-label">Tested</div>
            </div>
        </div>
    </div>
</div>

{{-- Condition legend bar --}}
<div class="rd-legend-bar">
    <div class="rd-legend-inner">
        <div class="rd-legend-title">Condition:</div>
        <div class="rd-legend-item"><div class="rd-legend-dot" style="background:#007600;"></div> Like New — No visible wear</div>
        <div class="rd-legend-item"><div class="rd-legend-dot" style="background:#0066c0;"></div> Good — Minor cosmetic wear</div>
        <div class="rd-legend-item"><div class="rd-legend-dot" style="background:#92400e;"></div> Acceptable — Visible wear, fully functional</div>
    </div>
</div>

{{-- Breadcrumb --}}
<div style="background:#fff;border-bottom:1px solid #e3e6e6;">
    <div class="rd-breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span> › </span>
        <span style="color:#0F1111;">Renewed Deals</span>
    </div>
</div>

{{-- Filter chips --}}
<div class="rd-chips-wrap">
    <div class="rd-chips">
        <a href="{{ route('renewed-deals') }}" class="rd-chip {{ !$activeCondition ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            All Renewed
        </a>
        <a href="{{ route('renewed-deals', ['condition'=>'like-new']) }}" class="rd-chip condition-like-new {{ $activeCondition=='like-new' ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            Like New
        </a>
        <a href="{{ route('renewed-deals', ['condition'=>'good']) }}" class="rd-chip condition-good {{ $activeCondition=='good' ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3z"/><path d="M7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"/></svg>
            Good
        </a>
        <a href="{{ route('renewed-deals', ['condition'=>'acceptable']) }}" class="rd-chip condition-acceptable {{ $activeCondition=='acceptable' ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Acceptable
        </a>
        <div style="width:1px;height:22px;background:#e3e6e6;flex-shrink:0;margin:0 4px;"></div>
        <a href="{{ route('renewed-deals', ['sort'=>'discount']) }}" class="rd-chip {{ $activeSort=='discount' ? 'active' : '' }}">Biggest Savings</a>
        <a href="{{ route('renewed-deals', ['sort'=>'newest']) }}" class="rd-chip {{ $activeSort=='newest' ? 'active' : '' }}">Newest First</a>
        <a href="{{ route('renewed-deals', ['sort'=>'price_asc']) }}" class="rd-chip {{ $activeSort=='price_asc' ? 'active' : '' }}">Lowest Price</a>
        @foreach($categories->take(6) as $cat)
        <a href="{{ route('renewed-deals', ['category'=>$cat->id]) }}" class="rd-chip {{ $activeCat==$cat->id ? 'active' : '' }}">{{ $cat->name }}</a>
        @endforeach
    </div>
</div>

{{-- Body --}}
<div class="rd-wrap">

    {{-- SIDEBAR --}}
    <div class="rd-sidebar">

        {{-- Condition --}}
        <div class="rd-sb-box">
            <div class="rd-sb-head">Condition</div>
            <div class="rd-sb-body">
                <a href="{{ route('renewed-deals', request()->except('condition')) }}" class="rd-sb-item {{ !$activeCondition ? 'active' : '' }}">
                    <input type="radio" {{ !$activeCondition ? 'checked' : '' }} readonly /> All Conditions
                </a>
                @foreach(['like-new'=>['label'=>'Like New','color'=>'#007600'],'good'=>['label'=>'Good','color'=>'#0066c0'],'acceptable'=>['label'=>'Acceptable','color'=>'#92400e']] as $key=>$cond)
                <a href="{{ route('renewed-deals', array_merge(request()->except('condition'), ['condition'=>$key])) }}" class="rd-sb-item {{ $activeCondition==$key ? 'active' : '' }}">
                    <input type="radio" {{ $activeCondition==$key ? 'checked' : '' }} readonly />
                    <span class="rd-cond-swatch" style="background:{{ $cond['color'] }};"></span>
                    {{ $cond['label'] }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Category --}}
        @if($categories->isNotEmpty())
        <div class="rd-sb-box">
            <div class="rd-sb-head">Department</div>
            <div class="rd-sb-body">
                <a href="{{ route('renewed-deals', request()->except('category')) }}" class="rd-sb-item {{ !$activeCat ? 'active' : '' }}">
                    <input type="radio" {{ !$activeCat ? 'checked' : '' }} readonly /> All
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('renewed-deals', array_merge(request()->except('category'), ['category'=>$cat->id])) }}" class="rd-sb-item {{ $activeCat==$cat->id ? 'active' : '' }}">
                    <input type="radio" {{ $activeCat==$cat->id ? 'checked' : '' }} readonly /> {{ $cat->name }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Brand --}}
        @if($brands->isNotEmpty())
        <div class="rd-sb-box">
            <div class="rd-sb-head">Brand</div>
            <div class="rd-sb-body">
                <a href="{{ route('renewed-deals', request()->except('brand')) }}" class="rd-sb-item {{ !$activeBrand ? 'active' : '' }}">
                    <input type="radio" {{ !$activeBrand ? 'checked' : '' }} readonly /> All Brands
                </a>
                @foreach($brands->take(10) as $brand)
                <a href="{{ route('renewed-deals', array_merge(request()->except('brand'), ['brand'=>$brand->id])) }}" class="rd-sb-item {{ $activeBrand==$brand->id ? 'active' : '' }}">
                    <input type="radio" {{ $activeBrand==$brand->id ? 'checked' : '' }} readonly /> {{ $brand->name }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Savings range --}}
        <div class="rd-sb-box">
            <div class="rd-sb-head">Savings</div>
            <div class="rd-sb-body">
                @foreach(['20'=>'20% & above','30'=>'30% & above','40'=>'40% & above','50'=>'50% & above'] as $val=>$lbl)
                <a href="{{ route('renewed-deals', array_merge(request()->except('min_disc'), ['min_disc'=>$val])) }}" class="rd-sb-item {{ request('min_disc')==$val ? 'active' : '' }}">
                    <input type="radio" {{ request('min_disc')==$val ? 'checked' : '' }} readonly /> {{ $lbl }}
                </a>
                @endforeach
            </div>
        </div>

    </div>

    {{-- MAIN --}}
    <div class="rd-main">

        {{-- Info banner --}}
        <div class="rd-info-banner">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#007600" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            <span>All renewed products are <b>professionally inspected, tested, and certified</b> to work and look like new. Each item includes a warranty and ships in certified packaging.</span>
        </div>

        {{-- Topbar --}}
        <div class="rd-topbar">
            <div class="rd-topbar-left"><b>{{ $products->count() }}</b> renewed products available</div>
            <div class="rd-topbar-right">
                Sort by:
                <select onchange="window.location.href=this.value">
                    <option value="{{ route('renewed-deals', array_merge(request()->all(), ['sort'=>'featured'])) }}" {{ $activeSort=='featured' ? 'selected' : '' }}>Featured</option>
                    <option value="{{ route('renewed-deals', array_merge(request()->all(), ['sort'=>'discount'])) }}" {{ $activeSort=='discount' ? 'selected' : '' }}>Highest Savings</option>
                    <option value="{{ route('renewed-deals', array_merge(request()->all(), ['sort'=>'price_asc'])) }}" {{ $activeSort=='price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="{{ route('renewed-deals', array_merge(request()->all(), ['sort'=>'price_desc'])) }}" {{ $activeSort=='price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="{{ route('renewed-deals', array_merge(request()->all(), ['sort'=>'newest'])) }}" {{ $activeSort=='newest' ? 'selected' : '' }}>Newest First</option>
                </select>
            </div>
        </div>

        {{-- Grid --}}
        @if($products->isEmpty())
            <div style="text-align:center;padding:60px 20px;background:#fff;border-radius:8px;border:1px solid #e3e6e6;">
                <svg width="72" height="72" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="margin:0 auto 16px;display:block;"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                <h3 style="font-size:18px;font-weight:700;color:#0F1111;margin-bottom:8px;">No renewed products found</h3>
                <p style="font-size:14px;color:#555;">Try adjusting your filters or check back soon.</p>
                <a href="{{ route('renewed-deals') }}" style="color:#007185;font-size:13px;">Clear all filters</a>
            </div>
        @else
        <div class="rd-grid">
            @foreach($products as $product)
            @php
                $imgs      = collect($product->images ?? [])->filter()->values();
                $thumb     = $imgs->first() ? \Illuminate\Support\Facades\Storage::url($imgs->first()) : null;
                $disc      = rdDisc($product->id, $discounts);
                $condition = $conditions[$product->id % count($conditions)];
                $condClass = $condBg[$condition];
                $condColor = $condColors[$condition];
                $warranty  = $warranties[$product->id % count($warranties)];
                $stockPct  = $stockPcts[$product->id % count($stockPcts)];
                $rating    = $ratings[$product->id % count($ratings)];
                $rev       = $reviews[$product->id % count($reviews)];
                $features  = $featureSets[$product->id % count($featureSets)];
                $saveAmt   = round($product->price * $disc / 100, 2);
                $afterP    = round($product->price - $saveAmt, 2);
                $intPart   = floor($afterP);
                $decPart   = str_pad((int)(($afterP - $intPart) * 100), 2, '0', STR_PAD_LEFT);
            @endphp
            <div class="rd-card" onclick="window.location='{{ route('products.show', $product->slug) }}'">

                {{-- Image --}}
                <div class="rd-card-img-wrap">
                    @if($thumb)
                        <img src="{{ $thumb }}" alt="{{ $product->name }}" loading="lazy" />
                    @else
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#d5d9d9" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    @endif

                    {{-- Condition badge --}}
                    <div class="rd-cond-badge {{ $condClass }}">{{ $condition }}</div>

                    {{-- Discount badge --}}
                    <div class="rd-disc-badge">-{{ $disc }}%</div>

                    {{-- Warranty badge --}}
                    <div class="rd-warranty-badge">
                        <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:middle;margin-right:2px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        {{ $warranty }}
                    </div>

                    {{-- Renewed ribbon --}}
                    <div class="rd-renewed-ribbon">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                        MyShop Certified Renewed
                    </div>
                </div>

                {{-- Body --}}
                <div class="rd-card-body">
                    @if($product->brand)
                    <div class="rd-brand">{{ $product->brand->name }}</div>
                    @endif
                    <div class="rd-name">{{ $product->name }}</div>

                    {{-- Stars --}}
                    <div class="rd-stars">
                        {!! rdStars($rating) !!}
                        <span>{{ $rating }} ({{ number_format($rev) }})</span>
                    </div>

                    {{-- Price --}}
                    <div class="rd-price-row">
                        <span class="rd-price-now"><sup>$</sup>{{ $intPart }}<sub>{{ $decPart }}</sub></span>
                        <span class="rd-price-list">List: <s>${{ number_format($product->price, 2) }}</s></span>
                    </div>
                    <span class="rd-save-tag" style="display:inline-block;">Save ${{ number_format($saveAmt, 2) }} ({{ $disc }}% off)</span>

                    {{-- Condition label --}}
                    <div class="rd-cond-label">
                        <span class="dot" style="background:{{ $condColor }};"></span>
                        Condition: <b style="color:{{ $condColor }};">{{ $condition }}</b>
                    </div>

                    {{-- Features --}}
                    <div class="rd-features">
                        @foreach(array_slice($features, 0, 2) as $feat)
                        <div class="rd-feature">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#007600" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            {{ $feat }}
                        </div>
                        @endforeach
                    </div>

                    {{-- Stock bar --}}
                    <div class="rd-stock-bar-wrap">
                        <div class="rd-stock-label">{{ $stockPct }}% claimed</div>
                        <div class="rd-stock-bar">
                            <div class="rd-stock-bar-fill" style="width:{{ $stockPct }}%;"></div>
                        </div>
                    </div>

                    {{-- Add to cart --}}
                    <a href="{{ route('products.show', $product->slug) }}" class="rd-add-btn" onclick="event.stopPropagation();">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        Add to Cart
                    </a>
                    <a href="{{ route('products.show', $product->slug) }}" class="rd-detail-link" onclick="event.stopPropagation();">View renewed product ›</a>
                </div>

            </div>
            @endforeach
        </div>
        @endif

        {{-- Certification section --}}
        <div class="rd-cert-section">
            <h3>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#007600" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                MyShop Renewed Guarantee
            </h3>
            <p>Every renewed product goes through a rigorous inspection and refurbishment process before it reaches you.</p>
            <div class="rd-cert-grid">
                <div class="rd-cert-item">
                    <div class="rd-cert-icon green">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#007600" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    </div>
                    <div>
                        <h4>Rigorous Testing</h4>
                        <p>100+ point inspection by certified technicians to ensure everything works perfectly.</p>
                    </div>
                </div>
                <div class="rd-cert-item">
                    <div class="rd-cert-icon blue">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0066c0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <div>
                        <h4>Warranty Included</h4>
                        <p>Every product comes with a minimum 90-day warranty — some up to 2 years.</p>
                    </div>
                </div>
                <div class="rd-cert-item">
                    <div class="rd-cert-icon amber">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#b45309" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                    </div>
                    <div>
                        <h4>Easy Returns</h4>
                        <p>Not satisfied? Return within 30 days, no questions asked.</p>
                    </div>
                </div>
                <div class="rd-cert-item">
                    <div class="rd-cert-icon purple">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <div>
                        <h4>Big Savings</h4>
                        <p>Save up to 60% compared to buying new, with the same quality and reliability.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Condition Guide --}}
        <div class="rd-cond-guide">
            <div class="rd-cond-guide-head">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Condition Guide
            </div>
            <table class="rd-cond-table">
                <thead>
                    <tr>
                        <th>Condition</th>
                        <th>Cosmetics</th>
                        <th>Functionality</th>
                        <th>Accessories</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="rd-cond-pill" style="background:#dcfce7;color:#007600;">● Like New</span></td>
                        <td>No visible scratches or wear</td>
                        <td>Works perfectly, like brand new</td>
                        <td>All original accessories included</td>
                    </tr>
                    <tr>
                        <td><span class="rd-cond-pill" style="background:#dbeafe;color:#0066c0;">● Good</span></td>
                        <td>Minor cosmetic imperfections only</td>
                        <td>Fully functional, all features work</td>
                        <td>Original or equivalent accessories</td>
                    </tr>
                    <tr>
                        <td><span class="rd-cond-pill" style="background:#fef3c7;color:#92400e;">● Acceptable</span></td>
                        <td>Visible wear, scratches or dents</td>
                        <td>Fully functional, all features work</td>
                        <td>Replacement accessories included</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
</div>
@endsection
