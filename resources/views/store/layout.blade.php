<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MyShop') — Professional Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #fff; color: #0F1111; margin: 0; }
        a { text-decoration: none; }

        /* NAV */
        .nav-top { background: #131921; color: #fff; display: flex; align-items: center; padding: 8px 16px; gap: 12px; flex-wrap: nowrap; min-height: 56px; }
        .nav-logo { font-size: 20px; font-weight: 900; color: #FF9900; white-space: nowrap; flex-shrink: 0; }
        .nav-logo:hover { color: #fff; }
        .nav-deliver { font-size: 11px; color: #ccc; white-space: nowrap; flex-shrink: 0; cursor: pointer; padding: 4px 6px; border: 1px solid transparent; }
        .nav-deliver:hover { border-color: #fff; border-radius: 2px; }
        .nav-deliver b { font-size: 13px; color: #fff; display: block; }

        /* Search */
        .nav-search { flex: 1; display: flex; max-width: 680px; position: relative; }
        .nav-search-cat { background: #e3e6e6; border: 1px solid #ccc; border-right: none; padding: 0 8px; font-size: 12px; color: #333; cursor: pointer; white-space: nowrap; border-radius: 4px 0 0 4px; }
        .nav-search input { flex: 1; padding: 8px 12px; font-size: 14px; border: 1px solid #ccc; border-right: none; border-left: none; outline: none; color: #0F1111; }
        .nav-search input:focus { border-color: #e77600; }
        .nav-search button { background: #FF9900; border: 1px solid #e88b00; padding: 0 16px; cursor: pointer; font-size: 18px; color: #333; flex-shrink: 0; border-radius: 0 4px 4px 0; }
        .nav-search button:hover { background: #e88b00; }
        .search-dropdown { position: absolute; top: calc(100% + 2px); left: 0; right: 0; background: #fff; border: 1px solid #ccc; z-index: 9999; max-height: 420px; overflow-y: auto; border-radius: 4px; box-shadow: 0 6px 20px rgba(0,0,0,0.18); }
        .search-item { display: flex; align-items: center; gap: 10px; padding: 8px 12px; cursor: pointer; border-bottom: 1px solid #f5f5f5; color: #0F1111; }
        .search-item:hover { background: #f7f8f8; }
        .search-item img { width: 44px; height: 44px; object-fit: contain; border: 1px solid #eee; border-radius: 3px; flex-shrink: 0; background: #fff; }
        .search-item-name { font-size: 13px; flex: 1; line-height: 1.3; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
        .search-item-price { font-size: 13px; font-weight: 700; color: #B12704; white-space: nowrap; }
        .search-loading { padding: 12px; text-align: center; color: #888; font-size: 13px; }
        .search-noresult { padding: 12px; color: #555; font-size: 13px; }

        /* Nav right */
        .nav-right { display: flex; align-items: center; gap: 4px; margin-left: auto; flex-shrink: 0; }
        .nav-btn { color: #fff; padding: 4px 8px; font-size: 12px; cursor: pointer; border: 1px solid transparent; border-radius: 2px; white-space: nowrap; line-height: 1.4; }
        .nav-btn:hover { border-color: #fff; }
        .nav-btn b { font-size: 13px; display: block; }
        .nav-cart { display: flex; align-items: center; gap: 4px; color: #fff; font-size: 13px; font-weight: 700; padding: 4px 8px; border: 1px solid transparent; border-radius: 2px; cursor: pointer; }
        .nav-cart:hover { border-color: #fff; }
        .nav-cart-count { background: #FF9900; color: #131921; font-size: 13px; font-weight: 700; border-radius: 50%; width: 20px; height: 20px; display: inline-flex; align-items: center; justify-content: center; }

        /* Category strip */
        .cat-strip { background: #232F3E; color: #fff; display: flex; align-items: center; padding: 6px 16px; gap: 0; overflow-x: auto; font-size: 13px; white-space: nowrap; }
        .cat-strip a { color: #fff; padding: 5px 10px; border: 1px solid transparent; border-radius: 2px; display: inline-block; }
        .cat-strip a:hover { border-color: #fff; }
        .cat-strip a.active { border-color: #fff; }

        /* Breadcrumb */
        .breadcrumb { padding: 8px 24px; font-size: 13px; background: #fff; display: flex; align-items: center; flex-wrap: wrap; gap: 2px; }
        .breadcrumb a { color: #007185; }
        .breadcrumb a:hover { color: #C7511F; text-decoration: underline; }
        .breadcrumb span.sep { color: #888; margin: 0 3px; }

        /* Footer */
        footer { background: #232F3E; color: #ccc; margin-top: 40px; }
        .footer-top { background: #37475A; padding: 14px; text-align: center; color: #fff; font-size: 13px; cursor: pointer; }
        .footer-top:hover { background: #485769; }
        .footer-mid { display: flex; justify-content: center; gap: 60px; padding: 30px 20px; flex-wrap: wrap; }
        .footer-col h4 { color: #fff; font-size: 14px; font-weight: 700; margin-bottom: 10px; }
        .footer-col a { display: block; color: #ccc; font-size: 13px; margin-bottom: 6px; }
        .footer-col a:hover { color: #fff; text-decoration: underline; }
        .footer-bot { background: #131921; padding: 16px; text-align: center; font-size: 12px; color: #777; }

        /* Promo bar */
        .promo-bar { background: #CC0C39; color: #fff; text-align: center; padding: 6px; font-size: 13px; font-weight: 700; letter-spacing: 1px; }
    </style>
    @yield('head')
</head>
<body>

{{-- Promo bar --}}
<div class="promo-bar">🔥 FREE SHIPPING on orders over $50 | Shop now and save!</div>

{{-- Top Nav --}}
<div class="nav-top">
    {{-- Logo --}}
    <a href="{{ route('home') }}" class="nav-logo">MyShop</a>

    {{-- Deliver to --}}
    <div class="nav-deliver">
        <span style="font-size:11px;">📍 Deliver to</span>
        <b>Your Location</b>
    </div>

    {{-- Search bar --}}
    <div class="nav-search" id="searchWrap">
        <select class="nav-search-cat" id="searchCat">
            <option value="">All</option>
            @foreach(\App\Models\Category::where('type','shop')->where('is_active',true)->take(10)->get() as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
        <input type="text" id="searchInput" placeholder="Search products, brands and more..." autocomplete="off" />
        <button type="button" id="searchBtn">🔍</button>
        <div class="search-dropdown" id="searchDropdown" style="display:none;"></div>
    </div>

    {{-- Right nav --}}
    <div class="nav-right">
        @auth
            <div class="nav-btn">
                <span style="font-size:11px;color:#ccc;">Hello, {{ auth()->user()->name }}</span>
                <b>Account</b>
            </div>
            <form method="POST" action="{{ route('store.logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="nav-btn" style="background:none;border:1px solid #ccc;padding:4px 8px;color:#fff;cursor:pointer;border-radius:2px;font-size:12px;">Sign Out</button>
            </form>
        @else
            <a href="{{ route('store.login') }}" class="nav-btn">
                <span style="font-size:11px;color:#ccc;">Hello, Sign in</span>
                <b>Account &amp; Lists</b>
            </a>
        @endauth
        <a href="{{ route('products.index') }}" class="nav-btn">
            <span style="font-size:11px;color:#ccc;">&nbsp;</span>
            <b>Returns &amp; Orders</b>
        </a>
        <a href="#" class="nav-cart">
            <span class="nav-cart-count">0</span>
            <span style="font-size:13px;font-weight:700;">Cart</span>
        </a>
    </div>
</div>

{{-- Category strip --}}
<div class="cat-strip">
    <a href="{{ route('home') }}">☰ All</a>
    <a href="{{ route('products.index') }}">Today's Deals</a>
    <a href="{{ route('products.index') }}">Electronics</a>
    <a href="{{ route('products.index') }}">New Arrivals</a>
    <a href="{{ route('products.index') }}">Best Sellers</a>
    <a href="{{ route('products.index') }}">Customer Service</a>
    <a href="{{ route('products.index') }}" style="color:#FF9900;font-weight:700;">Prime</a>
</div>

{{-- Content --}}
@yield('content')

{{-- Footer --}}
<footer>
    <div class="footer-top" onclick="window.scrollTo({top:0,behavior:'smooth'})">Back to top</div>
    <div class="footer-mid">
        <div class="footer-col">
            <h4>Get to Know Us</h4>
            <a href="#">About MyShop</a>
            <a href="#">Careers</a>
            <a href="#">Press Releases</a>
            <a href="#">MyShop Cares</a>
        </div>
        <div class="footer-col">
            <h4>Make Money with Us</h4>
            <a href="#">Sell on MyShop</a>
            <a href="#">Become an Affiliate</a>
            <a href="#">Advertise Your Products</a>
        </div>
        <div class="footer-col">
            <h4>Let Us Help You</h4>
            <a href="#">Your Account</a>
            <a href="#">Your Orders</a>
            <a href="#">Shipping Rates</a>
            <a href="#">Returns &amp; Replacements</a>
            <a href="#">Help</a>
        </div>
    </div>
    <div class="footer-bot">
        &copy; {{ date('Y') }} MyShop, Inc. All rights reserved.
        &nbsp;|&nbsp; <a href="#" style="color:#999;">Privacy</a>
        &nbsp;|&nbsp; <a href="#" style="color:#999;">Terms</a>
        &nbsp;|&nbsp; <a href="#" style="color:#999;">Cookies</a>
    </div>
</footer>

<script>
// ===== LIVE SEARCH =====
(function() {
    const input    = document.getElementById('searchInput');
    const dropdown = document.getElementById('searchDropdown');
    const searchBtn= document.getElementById('searchBtn');
    let timer;

    input.addEventListener('input', function() {
        clearTimeout(timer);
        const q = this.value.trim();
        if (q.length < 1) { dropdown.style.display = 'none'; return; }
        dropdown.style.display = 'block';
        dropdown.innerHTML = '<div class="search-loading">Searching...</div>';
        timer = setTimeout(() => doSearch(q), 250);
    });

    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            dropdown.style.display = 'none';
            window.location.href = '/products?q=' + encodeURIComponent(this.value.trim());
        }
    });

    searchBtn.addEventListener('click', function() {
        const q = input.value.trim();
        if (q) window.location.href = '/products?q=' + encodeURIComponent(q);
    });

    document.addEventListener('click', function(e) {
        if (!document.getElementById('searchWrap').contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });

    function doSearch(q) {
        fetch('/api/search?q=' + encodeURIComponent(q))
            .then(r => r.json())
            .then(data => {
                if (!data.length) {
                    dropdown.innerHTML = '<div class="search-noresult">No products found for "<b>' + q + '</b>"</div>';
                    return;
                }
                dropdown.innerHTML = data.map(p => `
                    <a class="search-item" href="${p.url}">
                        ${p.image
                            ? `<img src="${p.image}" alt="${p.name}" />`
                            : `<div style="width:44px;height:44px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">📦</div>`
                        }
                        <span class="search-item-name">${p.name}</span>
                        <span class="search-item-price">$${p.price}</span>
                    </a>
                `).join('');
            })
            .catch(() => {
                dropdown.innerHTML = '<div class="search-noresult">Search unavailable.</div>';
            });
    }
})();
</script>

@yield('scripts')
</body>
</html>
