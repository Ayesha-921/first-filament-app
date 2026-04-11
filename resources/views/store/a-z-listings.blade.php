@extends('store.layout')
@section('title', 'A–Z Listings — Browse All Products Alphabetically')

@section('head')
<style>
    /* ── Page ─────────────────────────────────────────── */
    .az-page { background: #EAEDED; min-height: 80vh; padding-bottom: 60px; }

    /* ── Hero ─────────────────────────────────────────── */
    .az-hero { background: linear-gradient(135deg,#131921 0%,#2a2a4a 50%,#131921 100%); padding: 40px 20px; position: relative; overflow: hidden; }
    .az-hero::before { content:''; position:absolute; right:-60px; top:-60px; width:300px; height:300px; background:rgba(255,153,0,.08); border-radius:50%; pointer-events:none; }
    .az-hero::after { content:''; position:absolute; left:25%; bottom:-80px; width:250px; height:250px; background:rgba(255,255,255,.03); border-radius:50%; pointer-events:none; }
    .az-hero-inner { max-width:1340px; margin:0 auto; text-align:center; position:relative; z-index:1; }
    .az-hero-eyebrow { display:inline-flex; align-items:center; gap:6px; background:rgba(255,153,0,.15); border:1px solid rgba(255,153,0,.4); border-radius:20px; padding:5px 16px; font-size:12px; color:#FF9900; font-weight:700; letter-spacing:.5px; margin-bottom:16px; text-transform:uppercase; }
    .az-hero h1 { font-size:40px; font-weight:900; color:#fff; margin:0 0 16px; line-height:1.2; }
    .az-hero h1 span { color:#FF9900; }
    .az-hero p { font-size:15px; color:#adbac7; margin:0 auto 24px; max-width:550px; line-height:1.6; }

    /* Alphabet Navigation */
    .az-alpha-nav { display:flex; justify-content:center; gap:4px; flex-wrap:wrap; margin-top:28px; }
    .az-alpha-btn { min-width:36px; height:36px; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.2); border-radius:6px; font-size:14px; font-weight:700; color:#fff; cursor:pointer; text-decoration:none; transition:all .15s; }
    .az-alpha-btn:hover { background:#FF9900; border-color:#FF9900; color:#131921; }
    .az-alpha-btn.active { background:#FFD814; border-color:#FFD814; color:#131921; }

    /* ── Quick Links Bar ─────────────────────────────────── */
    .az-quick-bar { background:#fff; border-bottom:2px solid #e3e6e6; }
    .az-quick-inner { max-width:1340px; margin:0 auto; padding:12px 20px; display:flex; gap:24px; overflow-x:auto; scrollbar-width:none; }
    .az-quick-inner::-webkit-scrollbar { display:none; }
    .az-quick-link { display:flex; align-items:center; gap:8px; font-size:14px; font-weight:600; color:#555; white-space:nowrap; cursor:pointer; text-decoration:none; transition:color .15s; }
    .az-quick-link:hover { color:#C7511F; }
    .az-quick-link svg { color:#FF9900; }

    /* ── Breadcrumb ──────────────────────────────────────── */
    .az-breadcrumb { max-width:1340px; margin:0 auto; padding:12px 20px; font-size:13px; color:#555; }
    .az-breadcrumb a { color:#007185; }
    .az-breadcrumb a:hover { color:#C7511F; text-decoration:underline; }

    /* ── Container ──────────────────────────────────────── */
    .az-container { max-width:1340px; margin:0 auto; padding:24px 20px; display:flex; gap:24px; align-items:flex-start; }

    /* ── Sidebar ────────────────────────────────────────── */
    .az-sidebar { width:260px; flex-shrink:0; }
    .az-sb-box { background:#fff; border:1px solid #e3e6e6; border-radius:12px; overflow:hidden; margin-bottom:16px; box-shadow:0 2px 8px rgba(0,0,0,.04); }
    .az-sb-head { font-size:14px; font-weight:700; color:#0F1111; padding:16px; border-bottom:1px solid #f0f2f2; background:#f7f8f8; display:flex; align-items:center; gap:8px; }
    .az-sb-body { padding:10px 0; }
    .az-sb-item { display:flex; align-items:center; gap:10px; padding:10px 16px; font-size:13px; color:#0F1111; cursor:pointer; text-decoration:none; transition:all .15s; border-left:3px solid transparent; }
    .az-sb-item:hover { background:#fff8ee; border-left-color:#FF9900; color:#C7511F; }
    .az-sb-item.active { background:#fff4e0; border-left-color:#FF9900; font-weight:700; color:#C7511F; }
    .az-sb-item input { accent-color:#FF9900; width:14px; height:14px; flex-shrink:0; }
    .az-sb-count { margin-left:auto; font-size:11px; color:#888; background:#f0f2f2; border-radius:99px; padding:2px 8px; }

    /* Jump Links */
    .az-jump-list { padding:12px; }
    .az-jump-item { display:flex; align-items:center; justify-content:space-between; padding:8px 12px; font-size:13px; color:#0F1111; text-decoration:none; border-radius:6px; transition:all .15s; }
    .az-jump-item:hover { background:#fff8ee; color:#C7511F; }
    .az-jump-letter { font-weight:700; color:#FF9900; width:24px; }

    /* ── Main ───────────────────────────────────────────── */
    .az-main { flex:1; min-width:0; }

    /* Section Header */
    .az-section-header { background:#fff; border-radius:12px; padding:20px; margin-bottom:24px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px; box-shadow:0 2px 8px rgba(0,0,0,.04); }
    .az-section-title { display:flex; align-items:center; gap:12px; }
    .az-section-title h2 { font-size:22px; font-weight:700; color:#0F1111; margin:0; }
    .az-section-title span { font-size:14px; color:#555; }
    .az-sort-wrap { display:flex; align-items:center; gap:12px; }
    .az-sort-label { font-size:13px; color:#555; }
    .az-sort-select { border:1px solid #d5d9d9; border-radius:8px; padding:8px 14px; font-size:13px; background:#fff; cursor:pointer; }

    /* Letter Section */
    .az-letter-section { margin-bottom:40px; }
    .az-letter-header { display:flex; align-items:center; gap:16px; margin-bottom:20px; padding-bottom:12px; border-bottom:2px solid #FF9900; }
    .az-letter-badge { width:48px; height:48px; background:#131921; color:#FF9900; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:24px; font-weight:900; }
    .az-letter-info { flex:1; }
    .az-letter-info h3 { font-size:18px; font-weight:700; color:#0F1111; margin:0 0 4px; }
    .az-letter-info p { font-size:13px; color:#555; margin:0; }
    .az-letter-count { font-size:14px; font-weight:700; color:#007185; }

    /* Product Grid */
    .az-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:20px; }

    /* Product Card */
    .az-card { background:#fff; border:1px solid #e3e6e6; border-radius:12px; overflow:hidden; display:flex; transition:all .2s; }
    .az-card:hover { box-shadow:0 8px 30px rgba(0,0,0,.12); border-color:#FF9900; transform:translateY(-3px); }
    .az-card-img { width:100px; height:100px; flex-shrink:0; background:#f7f8f8; display:flex; align-items:center; justify-content:center; padding:12px; }
    .az-card-img img { max-width:100%; max-height:100%; object-fit:contain; }
    .az-card-body { flex:1; padding:14px; display:flex; flex-direction:column; gap:4px; }
    .az-card-brand { font-size:11px; color:#C7511F; font-weight:700; text-transform:uppercase; }
    .az-card-name { font-size:14px; color:#0F1111; font-weight:500; line-height:1.4; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; }
    .az-card-category { font-size:12px; color:#007185; }
    .az-card-bottom { display:flex; align-items:center; justify-content:space-between; margin-top:auto; padding-top:10px; }
    .az-card-price { font-size:18px; font-weight:700; color:#B12704; }
    .az-card-btn { display:flex; align-items:center; justify-content:center; width:32px; height:32px; background:#FFD814; border:none; border-radius:50%; cursor:pointer; transition:all .15s; }
    .az-card-btn:hover { background:#F7CA00; transform:scale(1.1); }

    /* Brand Directory */
    .az-brands-section { background:#fff; border-radius:12px; padding:24px; margin-top:40px; }
    .az-brands-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
    .az-brands-header h3 { font-size:18px; font-weight:700; margin:0; display:flex; align-items:center; gap:8px; border-left:4px solid #FF9900; padding-left:12px; }
    .az-brands-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:12px; }
    .az-brand-card { display:flex; align-items:center; gap:10px; padding:12px 16px; background:#f7f8f8; border:1px solid #e3e6e6; border-radius:8px; text-decoration:none; color:#0F1111; font-size:13px; font-weight:500; transition:all .15s; }
    .az-brand-card:hover { background:#fff8ee; border-color:#FF9900; color:#C7511F; }
    .az-brand-letter { width:28px; height:28px; background:#131921; color:#FF9900; border-radius:6px; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; flex-shrink:0; }

    /* Empty State */
    .az-empty { text-align:center; padding:80px 20px; background:#fff; border-radius:12px; }

    @media (max-width:900px) {
        .az-container { flex-direction:column; }
        .az-sidebar { width:100%; }
        .az-grid { grid-template-columns:1fr; }
        .az-hero h1 { font-size:28px; }
    }
</style>
@endsection

@section('content')
@php
    $alphabet = range('A', 'Z');
    $numbers  = ['0-9'];
    $allChars = array_merge($numbers, $alphabet);
    
    // Group products by first letter
    $grouped = $products->groupBy(function($p) {
        $first = strtoupper(substr($p->name, 0, 1));
        return is_numeric($first) ? '0-9' : $first;
    })->sortKeys();
    
    $activeLetter = request('letter', 'A');
@endphp

<div class="az-page">

{{-- Hero --}}
<div class="az-hero">
    <div class="az-hero-inner">
        <div class="az-hero-eyebrow">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><line x1="8" y1="7" x2="16" y2="7"/><line x1="8" y1="11" x2="12" y2="11"/></svg>
            Complete Product Directory
        </div>
        <h1>A–Z <span>Listings</span></h1>
        <p>Browse our entire catalog alphabetically. Find any product quickly with our organized A–Z directory.</p>

        {{-- Alphabet Navigation --}}
        <div class="az-alpha-nav">
            @foreach($allChars as $char)
            <a href="#letter-{{ $char }}" class="az-alpha-btn {{ $char==$activeLetter ? 'active' : '' }}" data-letter="{{ $char }}">{{ $char }}</a>
            @endforeach
        </div>
    </div>
</div>

{{-- Quick Links --}}
<div class="az-quick-bar">
    <div class="az-quick-inner">
        <a href="#brands" class="az-quick-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            Browse by Brand
        </a>
        <a href="#categories" class="az-quick-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Browse by Category
        </a>
        <a href="{{ route('best-price') }}" class="az-quick-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            Best Price Deals
        </a>
        <a href="{{ route('products.index', ['sort'=>'newest']) }}" class="az-quick-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            New Arrivals
        </a>
    </div>
</div>

{{-- Breadcrumb --}}
<div style="background:#fff;border-bottom:1px solid #e3e6e6;">
    <div class="az-breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span>›</span>
        <span style="color:#0F1111;font-weight:500;">A–Z Listings</span>
        @if($activeLetter)<span>›</span><span style="color:#FF9900;font-weight:700;">{{ $activeLetter }}</span>@endif
    </div>
</div>

{{-- Main Content --}}
<div class="az-container">

    {{-- Sidebar --}}
    <div class="az-sidebar">

        {{-- Jump to Letter --}}
        <div class="az-sb-box">
            <div class="az-sb-head">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                Jump to Letter
            </div>
            <div class="az-jump-list">
                @foreach($allChars as $char)
                <a href="#letter-{{ $char }}" class="az-jump-item">
                    <span class="az-jump-letter">{{ $char }}</span>
                    <span>{{ $grouped->has($char) ? $grouped[$char]->count() . ' items' : '0 items' }}</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Categories --}}
        <div class="az-sb-box" id="categories">
            <div class="az-sb-head">Browse by Category</div>
            <div class="az-sb-body">
                <a href="{{ route('a-z-listings') }}" class="az-sb-item {{ !request('category') ? 'active' : '' }}">
                    <input type="radio" {{ !request('category') ? 'checked' : '' }} readonly /> All Categories
                </a>
                @foreach($categories->take(10) as $cat)
                <a href="{{ route('a-z-listings', ['category'=>$cat->id]) }}" class="az-sb-item {{ request('category')==$cat->id ? 'active' : '' }}">
                    <input type="radio" {{ request('category')==$cat->id ? 'checked' : '' }} readonly />
                    {{ $cat->name }}
                    <span class="az-sb-count">{{ rand(5,40) }}</span>
                </a>
                @endforeach
            </div>
        </div>

        {{-- Filter by Price --}}
        <div class="az-sb-box">
            <div class="az-sb-head">Price Range</div>
            <div class="az-sb-body" style="padding:12px;">
                @foreach(['Under $25','$25-$50','$50-$100','$100-$200','$200+'] as $range)
                <a href="{{ route('a-z-listings', ['price_range'=>$loop->index]) }}" class="az-sb-item {{ request('price_range')==$loop->index ? 'active' : '' }}" style="padding:8px 0;">
                    <input type="radio" {{ request('price_range')==$loop->index ? 'checked' : '' }} readonly />
                    {{ $range }}
                </a>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Main --}}
    <div class="az-main">

        {{-- Section Header --}}
        <div class="az-section-header">
            <div class="az-section-title">
                <h2>Products A–Z</h2>
                <span>{{ $products->count() }} products available</span>
            </div>
            <div class="az-sort-wrap">
                <span class="az-sort-label">Sort:</span>
                <select class="az-sort-select" onchange="window.location.href=this.value">
                    <option value="{{ route('a-z-listings', array_merge(request()->all(),['sort'=>'name_asc'])) }}" {{ request('sort','name_asc')=='name_asc' ? 'selected' : '' }}>A to Z</option>
                    <option value="{{ route('a-z-listings', array_merge(request()->all(),['sort'=>'name_desc'])) }}" {{ request('sort')=='name_desc' ? 'selected' : '' }}>Z to A</option>
                    <option value="{{ route('a-z-listings', array_merge(request()->all(),['sort'=>'price_asc'])) }}" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="{{ route('a-z-listings', array_merge(request()->all(),['sort'=>'price_desc'])) }}" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </div>
        </div>

        {{-- Letter Sections --}}
        @forelse($grouped as $letter => $items)
        <div class="az-letter-section" id="letter-{{ $letter }}">
            <div class="az-letter-header">
                <div class="az-letter-badge">{{ $letter }}</div>
                <div class="az-letter-info">
                    <h3>Starting with {{ $letter }}</h3>
                    <p>{{ $items->count() }} products found</p>
                </div>
                <span class="az-letter-count">View All →</span>
            </div>

            <div class="az-grid">
                @foreach($items as $product)
                @php
                    $imgs = collect($product->images ?? [])->filter()->values();
                    $thumb = $imgs->first() ? \Illuminate\Support\Facades\Storage::url($imgs->first()) : null;
                @endphp
                <div class="az-card" onclick="window.location='{{ route('products.show', $product->slug) }}'">
                    <div class="az-card-img">
                        @if($thumb)
                            <img src="{{ $thumb }}" alt="{{ $product->name }}" />
                        @else
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d5d9d9" stroke-width="1"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/></svg>
                        @endif
                    </div>
                    <div class="az-card-body">
                        <div class="az-card-brand">{{ $product->brand ? $product->brand->name : 'MyShop' }}</div>
                        <div class="az-card-name">{{ $product->name }}</div>
                        @if($product->category)
                            <div class="az-card-category">{{ $product->category->name }}</div>
                        @endif
                        <div class="az-card-bottom">
                            <span class="az-card-price">${{ number_format($product->price, 2) }}</span>
                            <button class="az-card-btn" onclick="event.stopPropagation(); azAddToCart()">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#131921" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div class="az-empty">
            <div style="font-size:64px;margin-bottom:16px;">📚</div>
            <h3 style="font-size:20px;font-weight:700;margin-bottom:8px;">No products found</h3>
            <p style="color:#555;">Try adjusting your filters or check back later.</p>
        </div>
        @endforelse

        {{-- Brand Directory --}}
        <div class="az-brands-section" id="brands">
            <div class="az-brands-header">
                <h3>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    Browse by Brand A–Z
                </h3>
                <a href="{{ route('products.index') }}" style="color:#007185;font-size:14px;">View All Brands →</a>
            </div>
            <div class="az-brands-grid">
                @foreach($brands->take(12) as $brand)
                @php $letter = strtoupper(substr($brand->name, 0, 1)); @endphp
                <a href="{{ route('products.index', ['brand'=>$brand->id]) }}" class="az-brand-card">
                    <span class="az-brand-letter">{{ $letter }}</span>
                    <span>{{ \Illuminate\Support\Str::limit($brand->name, 15) }}</span>
                </a>
                @endforeach
            </div>
        </div>

    </div>
</div>

</div>

<script>
function azAddToCart() {
    let t = document.getElementById('azToast');
    if(!t) {
        t = document.createElement('div');
        t.id = 'azToast';
        t.style.cssText = 'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);background:#131921;color:#FF9900;padding:12px 24px;border-radius:8px;font-size:14px;z-index:99999;font-weight:600;box-shadow:0 4px 16px rgba(0,0,0,.3);';
        document.body.appendChild(t);
    }
    t.textContent = '🛒 Added to cart!';
    t.style.opacity = '1';
    clearTimeout(t._t);
    t._t = setTimeout(() => { t.style.opacity = '0'; }, 2500);
}

// Smooth scroll for alphabet navigation
document.querySelectorAll('.az-alpha-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const letter = this.getAttribute('data-letter');
        const target = document.getElementById('letter-' + letter);
        if(target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});
</script>
@endsection
