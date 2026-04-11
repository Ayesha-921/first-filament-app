@extends('store.layout')
@section('title', 'All Products — MyShop')

@section('head')
<style>
    .shop-wrap { max-width: 1200px; margin: 0 auto; padding: 20px 16px; display: flex; gap: 20px; align-items: flex-start; }

    /* Sidebar */
    .sidebar { width: 220px; flex-shrink: 0; }
    .sidebar-box { background: #fff; border: 1px solid #ddd; border-radius: 6px; padding: 16px; margin-bottom: 14px; }
    .sidebar-box h4 { font-size: 15px; font-weight: 700; margin: 0 0 12px; border-bottom: 1px solid #eee; padding-bottom: 8px; }
    .filter-label { display: flex; align-items: center; gap: 8px; font-size: 13px; margin-bottom: 8px; cursor: pointer; }
    .filter-label input { accent-color: #FF9900; }
    .price-inputs { display: flex; gap: 8px; margin-top: 8px; }
    .price-inputs input { width: 100%; padding: 5px 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 13px; }
    .btn-filter { width: 100%; background: #FF9900; border: none; padding: 8px; border-radius: 4px; font-size: 13px; cursor: pointer; font-weight: 600; margin-top: 8px; }
    .btn-filter:hover { background: #e88b00; }

    /* Main */
    .shop-main { flex: 1; min-width: 0; }
    .sort-bar { display: flex; align-items: center; justify-content: space-between; background: #f7f8f8; border: 1px solid #ddd; border-radius: 4px; padding: 8px 16px; margin-bottom: 16px; font-size: 13px; flex-wrap: wrap; gap: 8px; }
    .sort-bar span { color: #555; }
    .sort-bar select { border: 1px solid #ccc; border-radius: 4px; padding: 4px 8px; font-size: 13px; background: #fff; cursor: pointer; }
    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: 14px; }
    .product-card { background: #fff; border: 1px solid #ddd; border-radius: 6px; overflow: hidden; display: flex; flex-direction: column; transition: box-shadow .15s; }
    .product-card:hover { box-shadow: 0 4px 14px rgba(0,0,0,.12); }
    .product-card-img { height: 180px; display: flex; align-items: center; justify-content: center; background: #f7f8f8; padding: 10px; }
    .product-card-img img { max-height: 160px; max-width: 100%; object-fit: contain; }
    .product-card-body { padding: 10px 12px 14px; flex: 1; display: flex; flex-direction: column; }
    .product-card-brand { font-size: 12px; color: #007185; }
    .product-card-name { font-size: 13px; color: #0F1111; margin: 3px 0; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.4; flex: 1; }
    .product-card-stars { color: #FF9900; font-size: 12px; }
    .product-card-price { font-size: 16px; font-weight: 700; color: #B12704; margin-top: 4px; }
    .product-card-stock { font-size: 11px; color: #007600; }
    .product-card-stock.out { color: #CC0C39; }
    .btn-add { width: 100%; background: #FFD814; border: 1px solid #FCD200; border-radius: 4px; padding: 6px; font-size: 12px; cursor: pointer; margin-top: 8px; }
    .btn-add:hover { background: #F7CA00; }

    .search-banner { background: #f7f8f8; border: 1px solid #ddd; border-radius: 4px; padding: 10px 16px; margin-bottom: 14px; font-size: 14px; color: #0F1111; }
    .search-banner b { color: #B12704; }
    .empty-state { text-align: center; padding: 60px 20px; color: #555; }
    .empty-state .icon { font-size: 64px; margin-bottom: 16px; }
    .empty-state h3 { font-size: 20px; font-weight: 700; color: #0F1111; margin-bottom: 8px; }

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
                <h4>Category</h4>
                @foreach($categories as $cat)
                    <label class="filter-label">
                        <input type="radio" name="category" value="{{ $cat->id }}"
                            {{ request('category') == $cat->id ? 'checked' : '' }}
                            onchange="document.getElementById('filterForm').submit()">
                        {{ $cat->name }}
                    </label>
                @endforeach
                @if(request('category'))
                    <a href="{{ request()->except('category') ? route('products.index', request()->except('category')) : route('products.index') }}"
                        style="font-size:12px;color:#007185;">Clear</a>
                @endif
            </div>
            @endif

            {{-- Brands --}}
            @if($brands->isNotEmpty())
            <div class="sidebar-box">
                <h4>Brand</h4>
                @foreach($brands as $brand)
                    <label class="filter-label">
                        <input type="radio" name="brand" value="{{ $brand->id }}"
                            {{ request('brand') == $brand->id ? 'checked' : '' }}
                            onchange="document.getElementById('filterForm').submit()">
                        {{ $brand->name }}
                    </label>
                @endforeach
            </div>
            @endif

            {{-- Price --}}
            <div class="sidebar-box">
                <h4>Price</h4>
                <div class="price-inputs">
                    <input type="number" name="min_price" placeholder="Min $" value="{{ request('min_price') }}" min="0" />
                    <input type="number" name="max_price" placeholder="Max $" value="{{ request('max_price') }}" min="0" />
                </div>
                <button type="submit" class="btn-filter">Apply</button>
            </div>
        </form>
    </div>

    {{-- ===== MAIN ===== --}}
    <div class="shop-main">

        {{-- Search banner --}}
        @if(request('q'))
            <div class="search-banner">
                {{ $products->total() }} results for <b>"{{ request('q') }}"</b>
            </div>
        @endif

        {{-- Sort bar --}}
        <div class="sort-bar">
            <span>{{ $products->total() }} products</span>
            <div style="display:flex;align-items:center;gap:8px;">
                <label for="sortSel" style="color:#555;">Sort by:</label>
                <select id="sortSel" onchange="window.location.href=this.value">
                    @php
                        $base = request()->except('sort');
                    @endphp
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
                <div class="icon">🔍</div>
                <h3>No products found</h3>
                <p>Try adjusting your filters or search query.</p>
                <a href="{{ route('products.index') }}" style="color:#007185;text-decoration:underline;font-size:14px;">Clear all filters</a>
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
                                <img src="{{ $thumb }}" alt="{{ $product->name }}" />
                            @else
                                <div style="font-size:48px;color:#ccc;">📦</div>
                            @endif
                        </div>
                        <div class="product-card-body">
                            @if($product->brand)
                                <div class="product-card-brand">{{ $product->brand->name }}</div>
                            @endif
                            <div class="product-card-name">{{ $product->name }}</div>
                            <div class="product-card-stars">★★★★☆</div>
                            <div class="product-card-price">${{ number_format($product->price, 2) }}</div>
                            @if($product->stock > 0)
                                <div class="product-card-stock">In Stock</div>
                            @else
                                <div class="product-card-stock out">Out of Stock</div>
                            @endif
                            <button class="btn-add" onclick="event.preventDefault()">Add to Cart</button>
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
