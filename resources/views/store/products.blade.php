@extends('store.layout')
@section('title', 'All Products — MyShop')

@section('head')
<style>
    .shop-wrap { max-width: 1240px; margin: 0 auto; padding: 20px 16px; display: flex; gap: 20px; align-items: flex-start; }

    /* Sidebar */
    .sidebar { width: 228px; flex-shrink: 0; }
    .sidebar-box { background: #fff; border: 1px solid #e3e6e6; border-radius: 8px; padding: 16px; margin-bottom: 12px; }
    .sidebar-box-header { display: flex; align-items: center; gap: 7px; font-size: 15px; font-weight: 700; margin: 0 0 12px; border-bottom: 1px solid #f0f2f2; padding-bottom: 10px; color: #0F1111; }
    .sidebar-box-header svg { flex-shrink: 0; }
    .filter-label { display: flex; align-items: center; gap: 9px; font-size: 13px; margin-bottom: 9px; cursor: pointer; color: #0F1111; }
    .filter-label:hover { color: #C7511F; }
    .filter-label input { accent-color: #FF9900; width: 15px; height: 15px; flex-shrink: 0; }
    .filter-clear { display: inline-flex; align-items: center; gap: 4px; font-size: 12px; color: #007185; margin-top: 4px; }
    .filter-clear:hover { color: #C7511F; text-decoration: underline; }
    .price-inputs { display: flex; gap: 8px; margin-top: 8px; }
    .price-inputs input { width: 100%; padding: 7px 8px; border: 1px solid #d5d9d9; border-radius: 6px; font-size: 13px; outline: none; }
    .price-inputs input:focus { border-color: #FF9900; box-shadow: 0 0 0 2px rgba(255,153,0,.15); }
    .btn-filter { width: 100%; background: #FF9900; border: none; padding: 9px; border-radius: 20px; font-size: 13px; cursor: pointer; font-weight: 700; margin-top: 10px; display: flex; align-items: center; justify-content: center; gap: 6px; transition: background .12s; }
    .btn-filter:hover { background: #e88b00; }

    /* Main */
    .shop-main { flex: 1; min-width: 0; }
    .sort-bar { display: flex; align-items: center; justify-content: space-between; background: #f7f8f8; border: 1px solid #e3e6e6; border-radius: 6px; padding: 9px 16px; margin-bottom: 16px; font-size: 13px; flex-wrap: wrap; gap: 8px; }
    .sort-bar-left { display: flex; align-items: center; gap: 6px; color: #555; }
    .sort-bar-right { display: flex; align-items: center; gap: 8px; }
    .sort-bar select { border: 1px solid #d5d9d9; border-radius: 6px; padding: 5px 10px; font-size: 13px; background: #fff; cursor: pointer; outline: none; }
    .sort-bar select:focus { border-color: #FF9900; }

    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: 14px; }
    .product-card { background: #fff; border: 1px solid #e3e6e6; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; transition: box-shadow .15s, border-color .15s; }
    .product-card:hover { box-shadow: 0 4px 18px rgba(0,0,0,.12); border-color: #FF9900; }
    .product-card-img { height: 180px; display: flex; align-items: center; justify-content: center; background: #f7f8f8; padding: 10px; }
    .product-card-img img { max-height: 160px; max-width: 100%; object-fit: contain; }
    .product-card-no-img { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px; }
    .product-card-body { padding: 10px 12px 14px; flex: 1; display: flex; flex-direction: column; }
    .product-card-brand { font-size: 12px; color: #007185; font-weight: 600; }
    .product-card-name { font-size: 13px; color: #0F1111; margin: 3px 0 5px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.4; flex: 1; }
    .product-card-stars { display: flex; align-items: center; gap: 2px; margin-bottom: 4px; }
    .product-card-price { font-size: 16px; font-weight: 700; color: #B12704; margin-top: 2px; }
    .product-card-stock { font-size: 11px; color: #007600; font-weight: 500; margin-top: 2px; }
    .product-card-stock.out { color: #CC0C39; }
    .btn-add { width: 100%; background: #FFD814; border: 1px solid #FCD200; border-radius: 20px; padding: 7px; font-size: 12px; cursor: pointer; margin-top: 9px; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 5px; transition: background .12s; }
    .btn-add:hover { background: #F7CA00; }

    .search-banner { background: #fff; border: 1px solid #e3e6e6; border-radius: 6px; padding: 10px 16px; margin-bottom: 14px; font-size: 14px; color: #0F1111; display: flex; align-items: center; gap: 8px; }
    .search-banner b { color: #B12704; }

    .empty-state { text-align: center; padding: 70px 20px; color: #555; background: #fff; border: 1px solid #e3e6e6; border-radius: 8px; }
    .empty-state svg { margin: 0 auto 20px; display: block; opacity: .35; }
    .empty-state h3 { font-size: 20px; font-weight: 700; color: #0F1111; margin-bottom: 8px; }
    .empty-state p { font-size: 14px; margin-bottom: 16px; }
    .empty-state-link { display: inline-flex; align-items: center; gap: 5px; color: #007185; font-size: 14px; }
    .empty-state-link:hover { color: #C7511F; text-decoration: underline; }

    @media (max-width: 700px) {
        .shop-wrap { flex-direction: column; }
        .sidebar { width: 100%; }
    }
</style>
@endsection

@section('content')

{{-- Breadcrumb --}}
<div class="breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    <span class="sep">›</span>
    <span>Products</span>
    @if(request('q'))
        <span class="sep">›</span>
        <span>Search: "{{ request('q') }}"</span>
    @endif
</div>

<div class="shop-wrap">

    {{-- ===== SIDEBAR ===== --}}
    <div class="sidebar">
        <form method="GET" action="{{ route('products.index') }}" id="filterForm">
            @if(request('q'))
                <input type="hidden" name="q" value="{{ request('q') }}" />
            @endif

            {{-- Categories --}}
            @if($categories->isNotEmpty())
            <div class="sidebar-box">
                <div class="sidebar-box-header">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Category
                </div>
                @foreach($categories as $cat)
                    <label class="filter-label">
                        <input type="radio" name="category" value="{{ $cat->id }}"
                            {{ request('category') == $cat->id ? 'checked' : '' }}
                            onchange="document.getElementById('filterForm').submit()">
                        {{ $cat->name }}
                    </label>
                @endforeach
                @if(request('category'))
                    <a href="{{ request()->except('category') ? route('products.index', request()->except('category')) : route('products.index') }}" class="filter-clear">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Clear
                    </a>
                @endif
            </div>
            @endif

            {{-- Brands --}}
            @if($brands->isNotEmpty())
            <div class="sidebar-box">
                <div class="sidebar-box-header">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                    Brand
                </div>
                @foreach($brands as $brand)
                    <label class="filter-label">
                        <input type="radio" name="brand" value="{{ $brand->id }}"
                            {{ request('brand') == $brand->id ? 'checked' : '' }}
                            onchange="document.getElementById('filterForm').submit()">
                        {{ $brand->name }}
                    </label>
                @endforeach
                @if(request('brand'))
                    <a href="{{ request()->except('brand') ? route('products.index', request()->except('brand')) : route('products.index') }}" class="filter-clear">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Clear
                    </a>
                @endif
            </div>
            @endif

            {{-- Price --}}
            <div class="sidebar-box">
                <div class="sidebar-box-header">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    Price Range
                </div>
                <div class="price-inputs">
                    <input type="number" name="min_price" placeholder="Min $" value="{{ request('min_price') }}" min="0" />
                    <input type="number" name="max_price" placeholder="Max $" value="{{ request('max_price') }}" min="0" />
                </div>
                <button type="submit" class="btn-filter">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                    Apply Filter
                </button>
            </div>
        </form>
    </div>

    {{-- ===== MAIN ===== --}}
    <div class="shop-main">

        {{-- Search banner --}}
        @if(request('q'))
            <div class="search-banner">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#007185" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                {{ $products->total() }} results for <b>"{{ request('q') }}"</b>
            </div>
        @endif

        {{-- Sort bar --}}
        <div class="sort-bar">
            <div class="sort-bar-left">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                <span><b style="color:#0F1111;">{{ $products->total() }}</b> products</span>
            </div>
            <div class="sort-bar-right">
                <label for="sortSel" style="color:#555;font-size:13px;">Sort by:</label>
                <select id="sortSel" onchange="window.location.href=this.value">
                    @php $base = request()->except('sort'); @endphp
                    <option value="{{ route('products.index', array_merge($base, ['sort'=>'latest'])) }}" {{ request('sort','latest')=='latest' ? 'selected' : '' }}>Newest Arrivals</option>
                    <option value="{{ route('products.index', array_merge($base, ['sort'=>'price_asc'])) }}" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="{{ route('products.index', array_merge($base, ['sort'=>'price_desc'])) }}" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="{{ route('products.index', array_merge($base, ['sort'=>'name'])) }}" {{ request('sort')=='name' ? 'selected' : '' }}>Name A–Z</option>
                </select>
            </div>
        </div>

        {{-- Products --}}
        @if($products->isEmpty())
            <div class="empty-state">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <h3>No products found</h3>
                <p>Try adjusting your filters or search query.</p>
                <a href="{{ route('products.index') }}" class="empty-state-link">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Clear all filters
                </a>
            </div>
        @else
            <div class="product-grid">
                @foreach($products as $product)
                    @php
                        $imgs = collect($product->images ?? [])->filter()->values();
                        $thumb = $imgs->first() ? \Illuminate\Support\Facades\Storage::url($imgs->first()) : null;
                    @endphp
                    <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                        <div class="product-card-img">
                            @if($thumb)
                                <img src="{{ $thumb }}" alt="{{ $product->name }}" loading="lazy" />
                            @else
                                <div class="product-card-no-img">
                                    <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#d5d9d9" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/></svg>
                                </div>
                            @endif
                        </div>
                        <div class="product-card-body">
                            @if($product->brand)
                                <div class="product-card-brand">{{ $product->brand->name }}</div>
                            @endif
                            <div class="product-card-name">{{ $product->name }}</div>
                            <div class="product-card-stars">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            </div>
                            <div class="product-card-price">${{ number_format($product->price, 2) }}</div>
                            @if($product->stock > 0)
                                <div class="product-card-stock">In Stock</div>
                            @else
                                <div class="product-card-stock out">Out of Stock</div>
                            @endif
                            <button class="btn-add" onclick="event.preventDefault()">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                                Add to Cart
                            </button>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div style="margin-top:24px;">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
