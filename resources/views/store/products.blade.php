@extends('store.layout')
@section('title', 'All Products — MyShop')

@section('head')
<style>
    /* ── Page shell ─────────────────────────────────── */
    .deals-page { background: #fff; }
    .deals-breadcrumb { max-width: 1340px; margin: 0 auto; padding: 8px 18px; font-size: 13px; color: #555; }
    .deals-breadcrumb a { color: #007185; }
    .deals-breadcrumb a:hover { color: #C7511F; text-decoration: underline; }
    .deals-breadcrumb span { margin: 0 5px; }

    /* ── Horizontal filter chips ─────────────────────── */
    .filter-chips-wrap { background: #fff; border-bottom: 1px solid #e3e6e6; position: relative; }
    .filter-chips-inner { max-width: 1340px; margin: 0 auto; padding: 10px 18px; display: flex; align-items: center; gap: 8px; overflow-x: auto; scrollbar-width: none; }
    .filter-chips-inner::-webkit-scrollbar { display: none; }
    .chip-arrow { position: absolute; top: 50%; transform: translateY(-50%); background: #fff; border: 1px solid #d5d9d9; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 2; box-shadow: 0 2px 6px rgba(0,0,0,.1); flex-shrink: 0; }
    .chip-arrow-left { left: 4px; }
    .chip-arrow-right { right: 4px; }
    .chip-arrow:hover { background: #f7f8f8; border-color: #aaa; }
    .filter-chip { display: inline-flex; align-items: center; gap: 5px; white-space: nowrap; border: 1px solid #d5d9d9; border-radius: 20px; padding: 6px 14px; font-size: 13px; font-weight: 500; color: #0F1111; background: #fff; cursor: pointer; text-decoration: none; transition: border-color .12s, background .12s, box-shadow .12s; flex-shrink: 0; }
    .filter-chip:hover { border-color: #aaa; box-shadow: 0 2px 6px rgba(0,0,0,.08); }
    .filter-chip.active { background: #0F1111; color: #fff; border-color: #0F1111; }
    .filter-chip.active:hover { background: #222; border-color: #222; }

    /* ── Active filter banner ────────────────────────── */
    .filtered-by-bar { max-width: 1340px; margin: 0 auto; padding: 10px 18px 0; }
    .filtered-by-inner { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
    .filtered-by-label { font-size: 13px; font-weight: 700; color: #0F1111; }
    .filtered-tag { display: inline-flex; align-items: center; gap: 5px; background: #0F1111; color: #fff; border-radius: 4px; padding: 5px 10px; font-size: 13px; font-weight: 500; }
    .filtered-tag-remove { background: none; border: none; color: #ccc; cursor: pointer; font-size: 14px; line-height: 1; padding: 0 0 0 4px; }
    .filtered-tag-remove:hover { color: #FF9900; }
    .clear-filters-link { font-size: 13px; color: #007185; margin-left: 4px; }
    .clear-filters-link:hover { color: #C7511F; text-decoration: underline; }

    /* ── Layout ─────────────────────────────────────── */
    .deals-wrap { max-width: 1340px; margin: 0 auto; padding: 14px 18px 30px; display: flex; gap: 18px; align-items: flex-start; }

    /* ── Sidebar ────────────────────────────────────── */
    .deals-sidebar { width: 200px; flex-shrink: 0; }
    .sb-section { margin-bottom: 18px; }
    .sb-title { font-size: 16px; font-weight: 700; color: #0F1111; margin: 0 0 10px; }
    .sb-link { display: block; font-size: 13px; color: #007185; padding: 3px 0; text-decoration: none; }
    .sb-link:hover { color: #C7511F; text-decoration: underline; }
    .sb-link.any { color: #007185; font-weight: 500; }
    .sb-cat-path { font-size: 12px; color: #555; margin: 4px 0 8px; line-height: 1.5; }
    .sb-cat-path a { color: #007185; }
    .sb-cat-path a:hover { text-decoration: underline; }
    .sb-radio-row { display: flex; align-items: center; gap: 8px; padding: 4px 0; cursor: pointer; }
    .sb-radio-row input[type=radio] { accent-color: #FF9900; width: 14px; height: 14px; flex-shrink: 0; cursor: pointer; }
    .sb-radio-label { font-size: 13px; color: #0F1111; cursor: pointer; flex: 1; }
    .sb-radio-row.active .sb-radio-label { font-weight: 700; }
    .sb-radio-row:hover .sb-radio-label { color: #C7511F; }
    .sb-divider { border: none; border-top: 1px solid #e3e6e6; margin: 12px 0; }
    .sb-price-inputs { display: flex; gap: 6px; margin: 8px 0; }
    .sb-price-inputs input { width: 100%; padding: 6px 8px; border: 1px solid #d5d9d9; border-radius: 6px; font-size: 12px; outline: none; color: #0F1111; }
    .sb-price-inputs input:focus { border-color: #FF9900; }
    .sb-apply-btn { width: 100%; background: #FF9900; border: none; padding: 7px; border-radius: 20px; font-size: 12px; cursor: pointer; font-weight: 700; color: #131921; transition: background .12s; }
    .sb-apply-btn:hover { background: #e88b00; }

    /* ── Main grid ──────────────────────────────────── */
    .deals-main { flex: 1; min-width: 0; }
    .deals-topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; flex-wrap: wrap; gap: 8px; }
    .deals-count { font-size: 14px; color: #555; }
    .deals-count b { color: #0F1111; font-size: 16px; }
    .deals-sort { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #555; }
    .deals-sort select { border: 1px solid #d5d9d9; border-radius: 6px; padding: 6px 10px; font-size: 13px; background: #fff; cursor: pointer; outline: none; color: #0F1111; }
    .deals-sort select:focus { border-color: #FF9900; }

    /* ── Deal card grid ─────────────────────────────── */
    .deal-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(185px, 1fr)); gap: 14px; }

    /* ── Single deal card ───────────────────────────── */
    .deal-card { background: #fff; border: 1px solid #ddd; border-radius: 6px; overflow: hidden; display: flex; flex-direction: column; position: relative; text-decoration: none; transition: box-shadow .15s; }
    .deal-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,.14); }

    /* Image area */
    .deal-card-img-wrap { position: relative; background: #f7f8f8; height: 200px; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 10px; }
    .deal-card-img-wrap img { max-height: 180px; max-width: 100%; object-fit: contain; transition: transform .22s; }
    .deal-card:hover .deal-card-img-wrap img { transform: scale(1.05); }
    .deal-card-no-img { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px; width: 100%; }

    /* Discount badge — top-left red pill */
    .deal-disc-badge { position: absolute; top: 0; left: 0; background: #CC0C39; color: #fff; font-size: 11px; font-weight: 800; padding: 4px 8px; border-radius: 0 0 6px 0; line-height: 1.2; }

    /* "Limited time deal" green badge */
    .deal-ltd-badge { position: absolute; bottom: 0; left: 0; right: 0; background: #215732; color: #fff; font-size: 11px; font-weight: 600; padding: 3px 8px; text-align: center; letter-spacing: .2px; }

    /* Yellow "+" add button — bottom-right circle */
    .deal-add-btn { position: absolute; bottom: 28px; right: 8px; width: 34px; height: 34px; border-radius: 50%; background: #FFD814; border: 2px solid #FFC400; display: flex; align-items: center; justify-content: center; cursor: pointer; z-index: 3; box-shadow: 0 2px 8px rgba(0,0,0,.18); transition: background .12s, transform .12s; text-decoration: none; flex-shrink: 0; }
    .deal-add-btn:hover { background: #F7CA00; transform: scale(1.1); }
    .deal-add-btn svg { pointer-events: none; }

    /* Body */
    .deal-card-body { padding: 10px 10px 12px; flex: 1; display: flex; flex-direction: column; }
    .deal-price-row { display: flex; align-items: baseline; gap: 5px; margin-bottom: 4px; flex-wrap: wrap; }
    .deal-price-current { font-size: 16px; font-weight: 800; color: #0F1111; }
    .deal-price-current sup { font-size: 11px; font-weight: 700; vertical-align: super; }
    .deal-price-list { font-size: 12px; color: #555; }
    .deal-price-list s { color: #888; }
    .deal-brand { font-size: 11px; color: #555; font-weight: 600; text-transform: uppercase; letter-spacing: .3px; margin-bottom: 3px; }
    .deal-name { font-size: 13px; color: #0F1111; line-height: 1.4; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; flex: 1; margin-bottom: 6px; }
    .deal-stars { display: flex; align-items: center; gap: 2px; margin-bottom: 5px; }
    .deal-stars span { font-size: 11px; color: #555; margin-left: 3px; }
    .deal-stock-bar-wrap { margin-bottom: 4px; }
    .deal-stock-bar-bg { background: #e7e7e7; border-radius: 3px; height: 4px; width: 100%; overflow: hidden; }
    .deal-stock-bar-fill { background: #CC0C39; height: 4px; border-radius: 3px; transition: width .3s; }
    .deal-stock-label { font-size: 11px; color: #CC0C39; font-weight: 600; margin-top: 2px; }
    .deal-shop-link { font-size: 12px; color: #007185; margin-top: 4px; }
    .deal-shop-link:hover { color: #C7511F; text-decoration: underline; }
    .deal-stock-in { font-size: 11px; color: #007600; font-weight: 600; display: flex; align-items: center; gap: 4px; }
    .deal-stock-in::before { content:''; width:6px; height:6px; border-radius:50%; background:#007600; flex-shrink:0; }
    .deal-stock-out { font-size: 11px; color: #CC0C39; font-weight: 600; }

    /* ── Search result banner ────────────────────────── */
    .search-result-bar { background: #fff8ee; border: 1px solid #FFD580; border-radius: 6px; padding: 10px 14px; margin-bottom: 14px; font-size: 14px; color: #0F1111; display: flex; align-items: center; gap: 8px; }
    .search-result-bar b { color: #B12704; }

    /* ── Empty state ────────────────────────────────── */
    .empty-state { text-align: center; padding: 70px 20px; color: #555; background: #fff; border: 1px solid #e3e6e6; border-radius: 8px; }
    .empty-state svg { margin: 0 auto 20px; display: block; opacity: .3; }
    .empty-state h3 { font-size: 20px; font-weight: 700; color: #0F1111; margin-bottom: 8px; }
    .empty-state p { font-size: 14px; margin-bottom: 16px; }
    .empty-state a { color: #007185; font-size: 14px; }
    .empty-state a:hover { color: #C7511F; text-decoration: underline; }

    @media (max-width: 740px) {
        .deals-wrap { flex-direction: column; }
        .deals-sidebar { width: 100%; }
        .deal-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); }
    }
</style>
@endsection

@section('content')
@php
    $discountPcts = [10,15,20,25,30,35,40,44,50,60];
    $stockPcts    = [15,25,38,52,64,71,80,90];
    $reviewCounts = [12,47,83,124,207,315,498,1024,2387];
    $ratings      = [3.5, 3.8, 4.0, 4.1, 4.2, 4.3, 4.4, 4.5, 4.6, 4.7, 4.8];
    function dealDisc($id, $arr) { return $arr[$id % count($arr)]; }
    function dealStars($rating) {
        $full = floor($rating); $half = ($rating - $full) >= 0.5 ? 1 : 0; $empty = 5 - $full - $half;
        $out = '';
        for($i=0;$i<$full;$i++)  $out .= '<svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        if($half)                 $out .= '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="none"><defs><linearGradient id="h"><stop offset="50%" stop-color="#FF9900"/><stop offset="50%" stop-color="#ddd"/></linearGradient></defs><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" fill="url(#h)"/></svg>';
        for($i=0;$i<$empty;$i++) $out .= '<svg width="12" height="12" viewBox="0 0 24 24" fill="#ddd" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>';
        return $out;
    }
@endphp

<div class="deals-page">

{{-- Breadcrumb --}}
<div class="deals-breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    <span>›</span>
    <a href="{{ route('products.index') }}">All Products</a>
    @if(request('q'))
        <span>›</span>
        <span style="color:#0F1111;">Search: "{{ request('q') }}"</span>
    @elseif(request('category'))
        @php $bcCat = $categories->firstWhere('id', request('category')); @endphp
        @if($bcCat)<span>›</span><span style="color:#0F1111;">{{ $bcCat->name }}</span>@endif
    @endif
</div>

{{-- ── Horizontal filter chips ───────────────────────────── --}}
<div class="filter-chips-wrap">
    <div class="filter-chips-inner" id="chipsRow">
        {{-- Sort chips --}}
        <a href="{{ route('products.index', array_merge(request()->except('sort','page'), ['sort'=>'latest'])) }}"
           class="filter-chip {{ !request('sort') || request('sort')=='latest' ? 'active' : '' }}">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
            Lightning Deals
        </a>
        <a href="{{ route('products.index', array_merge(request()->except('sort','page'), ['sort'=>'price_asc'])) }}"
           class="filter-chip {{ request('sort')=='price_asc' ? 'active' : '' }}">
            Lowest Price in 365 Days
        </a>
        <a href="{{ route('products.index', array_merge(request()->except('sort','page'), ['sort'=>'price_desc'])) }}"
           class="filter-chip {{ request('sort')=='price_desc' ? 'active' : '' }}">
            Premium Brands
        </a>
        <a href="{{ route('products.index', array_merge(request()->except('sort','page'), ['sort'=>'name'])) }}"
           class="filter-chip {{ request('sort')=='name' ? 'active' : '' }}">
            Final Sale
        </a>
        {{-- Category chips --}}
        @foreach($categories->take(10) as $chipCat)
            @php $chipUrl = route('products.index', array_merge(request()->except('category','page'), ['category'=>$chipCat->id])); @endphp
            <a href="{{ $chipUrl }}" class="filter-chip {{ request('category')==$chipCat->id ? 'active' : '' }}">
                {{ $chipCat->name }}
            </a>
        @endforeach
    </div>
</div>

{{-- ── Active filter banner ──────────────────────────────── --}}
@if(request('category') || request('brand') || request('min_price') || request('max_price') || request('q'))
<div class="filtered-by-bar">
    <div class="filtered-by-inner">
        <span class="filtered-by-label">Filtered by</span>
        @if(request('q'))
            <span class="filtered-tag">
                "{{ request('q') }}"
                <a href="{{ route('products.index', request()->except('q')) }}" class="filtered-tag-remove" title="Remove">&#10005;</a>
            </span>
        @endif
        @if(request('category'))
            @php $activeCat = $categories->firstWhere('id', request('category')); @endphp
            @if($activeCat)
            <span class="filtered-tag">
                {{ $activeCat->name }}
                <a href="{{ route('products.index', request()->except('category')) }}" class="filtered-tag-remove" title="Remove">&#10005;</a>
            </span>
            @endif
        @endif
        @if(request('brand'))
            @php $activeBrand = $brands->firstWhere('id', request('brand')); @endphp
            @if($activeBrand)
            <span class="filtered-tag">
                {{ $activeBrand->name }}
                <a href="{{ route('products.index', request()->except('brand')) }}" class="filtered-tag-remove" title="Remove">&#10005;</a>
            </span>
            @endif
        @endif
        @if(request('min_price') || request('max_price'))
            <span class="filtered-tag">
                ${{ request('min_price','0') }} – ${{ request('max_price','∞') }}
                <a href="{{ route('products.index', request()->except('min_price','max_price')) }}" class="filtered-tag-remove" title="Remove">&#10005;</a>
            </span>
        @endif
        <a href="{{ route('products.index') }}" class="clear-filters-link">Clear Filters</a>
    </div>
</div>
@endif

{{-- ── Body ──────────────────────────────────────────────── --}}
<div class="deals-wrap">

    {{-- ===== SIDEBAR ===== --}}
    <div class="deals-sidebar">
        <form method="GET" action="{{ route('products.index') }}" id="filterForm">
            @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}" />@endif
            @if(request('sort'))<input type="hidden" name="sort" value="{{ request('sort') }}" />@endif

            {{-- Department --}}
            <div class="sb-section">
                <div class="sb-title">Department</div>
                <a href="{{ route('products.index', request()->except('category','page')) }}" class="sb-link any">Any</a>

                @if(request('category') && isset($activeCat))
                    <div class="sb-cat-path">
                        Category &rsaquo; <a href="{{ route('products.index', request()->except('category','page')) }}">All</a> &rsaquo; {{ $activeCat->name }}
                    </div>
                @endif

                <label class="sb-radio-row {{ !request('category') ? 'active' : '' }}">
                    <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }}
                        onclick="window.location='{{ route('products.index', request()->except('category','page')) }}'" />
                    <span class="sb-radio-label">All</span>
                </label>

                @foreach($categories as $cat)
                    @php $cUrl = route('products.index', array_merge(request()->except('category','page'), ['category'=>$cat->id])); @endphp
                    <label class="sb-radio-row {{ request('category')==$cat->id ? 'active' : '' }}" onclick="window.location='{{ $cUrl }}'">
                        <input type="radio" name="category" value="{{ $cat->id }}" {{ request('category')==$cat->id ? 'checked' : '' }} />
                        <span class="sb-radio-label">{{ $cat->name }}</span>
                    </label>
                @endforeach
            </div>

            <hr class="sb-divider">

            {{-- Brand --}}
            @if($brands->isNotEmpty())
            <div class="sb-section">
                <div class="sb-title">Brand</div>
                @foreach($brands as $brand)
                    @php $bUrl = route('products.index', array_merge(request()->except('brand','page'), ['brand'=>$brand->id])); @endphp
                    <label class="sb-radio-row {{ request('brand')==$brand->id ? 'active' : '' }}" onclick="window.location='{{ $bUrl }}'">
                        <input type="radio" name="brand" value="{{ $brand->id }}" {{ request('brand')==$brand->id ? 'checked' : '' }} />
                        <span class="sb-radio-label">{{ $brand->name }}</span>
                    </label>
                @endforeach
                @if(request('brand'))
                    <a href="{{ route('products.index', request()->except('brand')) }}" class="sb-link" style="margin-top:4px;color:#CC0C39;">Clear brand</a>
                @endif
            </div>
            <hr class="sb-divider">
            @endif

            {{-- Price --}}
            <div class="sb-section">
                <div class="sb-title">Price</div>
                <div class="sb-price-inputs">
                    <input type="number" name="min_price" placeholder="Min $" value="{{ request('min_price') }}" min="0" />
                    <input type="number" name="max_price" placeholder="Max $" value="{{ request('max_price') }}" min="0" />
                </div>
                <button type="submit" class="sb-apply-btn">Go</button>
            </div>
        </form>
    </div>

    {{-- ===== MAIN ===== --}}
    <div class="deals-main">

        {{-- Search banner --}}
        @if(request('q'))
        <div class="search-result-bar">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#007185" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <span>{{ $products->total() }} results for <b>"{{ request('q') }}"</b></span>
        </div>
        @endif

        {{-- Top bar: count + sort --}}
        <div class="deals-topbar">
            <div class="deals-count"><b>{{ $products->total() }}</b> results</div>
            <div class="deals-sort">
                <label for="sortSel">Sort by:</label>
                <select id="sortSel" onchange="window.location.href=this.value">
                    @php $base = request()->except('sort'); @endphp
                    <option value="{{ route('products.index', array_merge($base, ['sort'=>'latest'])) }}"     {{ !request('sort') || request('sort')=='latest'     ? 'selected' : '' }}>Newest Arrivals</option>
                    <option value="{{ route('products.index', array_merge($base, ['sort'=>'price_asc'])) }}"  {{ request('sort')=='price_asc'  ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="{{ route('products.index', array_merge($base, ['sort'=>'price_desc'])) }}" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="{{ route('products.index', array_merge($base, ['sort'=>'name'])) }}"       {{ request('sort')=='name'       ? 'selected' : '' }}>Name A–Z</option>
                </select>
            </div>
        </div>

        {{-- Products --}}
        @if($products->isEmpty())
            <div class="empty-state">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <h3>No results found</h3>
                <p>Try adjusting your filters or searching for something else.</p>
                <a href="{{ route('products.index') }}">Clear all filters</a>
            </div>
        @else
            <div class="deal-grid">
                @foreach($products as $product)
                @php
                    $imgs   = collect($product->images ?? [])->filter()->values();
                    $thumb  = $imgs->first() ? \Illuminate\Support\Facades\Storage::url($imgs->first()) : null;
                    $disc   = dealDisc($product->id, $discountPcts);
                    $listP  = round($product->price / (1 - $disc/100), 2);
                    $stockP = dealDisc($product->id, $stockPcts);
                    $rating = $ratings[$product->id % count($ratings)];
                    $reviews= $reviewCounts[$product->id % count($reviewCounts)];
                @endphp
                <div class="deal-card" style="cursor:pointer;" onclick="window.location='{{ route('products.show', $product->slug) }}'">

                    {{-- Image area --}}
                    <div class="deal-card-img-wrap">
                        @if($thumb)
                            <img src="{{ $thumb }}" alt="{{ $product->name }}" loading="lazy" />
                        @else
                            <div class="deal-card-no-img">
                                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="#d5d9d9" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                <span style="font-size:11px;color:#bbb;margin-top:4px;">No image</span>
                            </div>
                        @endif

                        {{-- Red discount badge --}}
                        @if($product->stock > 0)
                        <div class="deal-disc-badge">{{ $disc }}% off</div>
                        @endif

                        {{-- Limited time deal strip --}}
                        @if($product->stock > 0)
                        <div class="deal-ltd-badge">Limited time deal</div>
                        @else
                        <div class="deal-ltd-badge" style="background:#888;">Out of stock</div>
                        @endif

                        {{-- Yellow + button --}}
                        <a href="{{ route('products.show', $product->slug) }}" class="deal-add-btn"
                           onclick="event.stopPropagation()" title="View deal">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#131921" stroke-width="3" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        </a>
                    </div>

                    {{-- Body --}}
                    <div class="deal-card-body">
                        {{-- Price row --}}
                        <div class="deal-price-row">
                            <span class="deal-price-current"><sup>$</sup>{{ number_format(floor($product->price), 0) }}<sup style="font-size:11px;vertical-align:super;">{{ substr(number_format($product->price,2), -2) }}</sup></span>
                            <span class="deal-price-list">List: <s>${{ number_format($listP, 2) }}</s></span>
                        </div>

                        {{-- Brand --}}
                        @if($product->brand)
                            <div class="deal-brand">{{ $product->brand->name }}</div>
                        @endif

                        {{-- Name --}}
                        <div class="deal-name">{{ $product->name }}</div>

                        {{-- Stars --}}
                        <div class="deal-stars">
                            {!! dealStars($rating) !!}
                            <span>{{ $rating }} ({{ number_format($reviews) }})</span>
                        </div>

                        {{-- Stock progress bar --}}
                        @if($product->stock > 0)
                            <div class="deal-stock-bar-wrap">
                                <div class="deal-stock-bar-bg">
                                    <div class="deal-stock-bar-fill" style="width:{{ $stockP }}%;"></div>
                                </div>
                                @if($stockP < 30)
                                    <div class="deal-stock-label">{{ $stockP }}% claimed — hurry!</div>
                                @else
                                    <div class="deal-stock-label">{{ $stockP }}% claimed</div>
                                @endif
                            </div>
                            <div class="deal-stock-in">In Stock</div>
                        @else
                            <div class="deal-stock-out">Currently unavailable</div>
                        @endif

                        {{-- Shop link --}}
                        @if($product->brand)
                            <a href="{{ route('products.index', ['brand'=>optional($product->brand)->id]) }}" class="deal-shop-link" onclick="event.stopPropagation()">
                                Shop {{ $product->brand->name }} deals
                            </a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div style="margin-top:28px;">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
</div>
@endsection
