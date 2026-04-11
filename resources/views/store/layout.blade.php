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
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif; background: #EAEDED; color: #0F1111; margin: 0; }
        a { text-decoration: none; }

        /* NAV */
        .nav-top { background: #131921; color: #fff; display: flex; align-items: center; padding: 8px 18px; gap: 14px; flex-wrap: nowrap; min-height: 60px; }
        .nav-logo { font-size: 22px; font-weight: 900; color: #FF9900; white-space: nowrap; flex-shrink: 0; letter-spacing: -0.5px; }
        .nav-logo:hover { color: #fff; }
        .nav-logo span { color: #fff; }

        .nav-deliver { display: flex; align-items: center; gap: 5px; font-size: 11px; color: #ccc; white-space: nowrap; flex-shrink: 0; cursor: pointer; padding: 5px 7px; border: 1px solid transparent; border-radius: 2px; }
        .nav-deliver:hover { border-color: #fff; }
        .nav-deliver svg { flex-shrink: 0; }
        .nav-deliver-text { display: flex; flex-direction: column; }
        .nav-deliver-text span { font-size: 11px; color: #ccc; }
        .nav-deliver-text b { font-size: 13px; color: #fff; }

        /* Search */
        .nav-search { flex: 1; display: flex; max-width: 700px; position: relative; border-radius: 4px; overflow: visible; }
        .nav-search-cat { background: #e3e6e6; border: none; padding: 0 10px; font-size: 12px; color: #333; cursor: pointer; white-space: nowrap; border-radius: 4px 0 0 4px; min-width: 60px; font-weight: 500; outline: none; }
        .nav-search-cat:hover { background: #d5d9d9; }
        .nav-search input { flex: 1; padding: 9px 14px; font-size: 14px; border: none; outline: none; color: #0F1111; min-width: 0; }
        .nav-search-btn { background: #FF9900; border: none; padding: 0 18px; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border-radius: 0 4px 4px 0; transition: background .15s; }
        .nav-search-btn:hover { background: #e88b00; }
        .nav-search-btn svg { display: block; }
        .search-dropdown { position: absolute; top: calc(100% + 3px); left: 0; right: 0; background: #fff; border: 1px solid #d5d9d9; z-index: 9999; max-height: 440px; overflow-y: auto; border-radius: 4px; box-shadow: 0 8px 24px rgba(0,0,0,0.15); }
        .search-item { display: flex; align-items: center; gap: 12px; padding: 9px 14px; cursor: pointer; border-bottom: 1px solid #f5f5f5; color: #0F1111; }
        .search-item:hover { background: #f7f8f8; }
        .search-item img { width: 46px; height: 46px; object-fit: contain; border: 1px solid #eee; border-radius: 3px; flex-shrink: 0; background: #fff; }
        .search-item-name { font-size: 13px; flex: 1; line-height: 1.35; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
        .search-item-price { font-size: 13px; font-weight: 700; color: #B12704; white-space: nowrap; }
        .search-loading { padding: 14px; text-align: center; color: #888; font-size: 13px; }
        .search-noresult { padding: 14px; color: #555; font-size: 13px; }
        .search-no-img { width: 46px; height: 46px; background: #f0f2f2; display: flex; align-items: center; justify-content: center; border-radius: 3px; flex-shrink: 0; }

        /* Nav right */
        .nav-right { display: flex; align-items: center; gap: 2px; margin-left: auto; flex-shrink: 0; }
        .nav-btn { color: #fff; padding: 5px 9px; font-size: 12px; cursor: pointer; border: 1px solid transparent; border-radius: 2px; white-space: nowrap; line-height: 1.4; display: flex; align-items: center; gap: 5px; }
        .nav-btn:hover { border-color: #fff; }
        .nav-btn-text { display: flex; flex-direction: column; }
        .nav-btn-text span { font-size: 11px; color: #ccc; }
        .nav-btn-text b { font-size: 13px; color: #fff; }
        .nav-cart { display: flex; align-items: center; gap: 6px; color: #fff; font-size: 13px; font-weight: 700; padding: 5px 9px; border: 1px solid transparent; border-radius: 2px; cursor: pointer; }
        .nav-cart:hover { border-color: #fff; }
        .nav-cart-count { background: #FF9900; color: #131921; font-size: 13px; font-weight: 700; border-radius: 50%; width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center; line-height: 1; }

        /* Language selector */
        .nav-lang { display: flex; align-items: center; gap: 4px; color: #fff; padding: 5px 9px; border: 1px solid transparent; border-radius: 2px; cursor: pointer; font-size: 13px; font-weight: 500; white-space: nowrap; position: relative; flex-shrink: 0; }
        .nav-lang:hover { border-color: #fff; }
        .nav-lang-flag { width: 22px; height: 15px; border-radius: 2px; object-fit: cover; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .nav-lang-dropdown { position: absolute; top: calc(100% + 6px); right: 0; background: #fff; border: 1px solid #d5d9d9; border-radius: 6px; box-shadow: 0 8px 24px rgba(0,0,0,.18); z-index: 9999; min-width: 180px; padding: 6px 0; display: none; }
        .nav-lang-dropdown.open { display: block; }
        .nav-lang-option { display: flex; align-items: center; gap: 10px; padding: 9px 14px; font-size: 13px; color: #0F1111; cursor: pointer; }
        .nav-lang-option:hover { background: #f7f8f8; }
        .nav-lang-option.selected { font-weight: 700; color: #C7511F; }
        .nav-lang-option .lang-code { font-size: 11px; color: #888; margin-left: auto; }

        /* Category strip */
        .cat-strip { background: #232F3E; color: #fff; display: flex; align-items: center; padding: 0 18px; gap: 0; overflow-x: auto; font-size: 13px; white-space: nowrap; scrollbar-width: none; }
        .cat-strip::-webkit-scrollbar { display: none; }
        .cat-strip a { color: #fff; padding: 8px 11px; border: 1px solid transparent; border-radius: 2px; display: inline-flex; align-items: center; gap: 5px; font-weight: 400; }
        .cat-strip a:hover { border-color: #fff; }
        .cat-strip a.active { border-color: #fff; }
        .cat-strip a.prime { color: #00A8E0; font-weight: 700; }

        /* Deals strip */
        .deals-strip { background: #fff; border-bottom: 1px solid #e7e7e7; display: flex; align-items: center; padding: 0 18px; overflow-x: auto; white-space: nowrap; scrollbar-width: none; gap: 0; }
        .deals-strip::-webkit-scrollbar { display: none; }
        .deals-strip a { color: #0F1111; font-size: 13px; padding: 9px 13px; border-bottom: 3px solid transparent; display: inline-flex; align-items: center; gap: 5px; font-weight: 400; white-space: nowrap; transition: border-color .15s, color .15s; }
        .deals-strip a:hover { border-bottom-color: #FF9900; color: #C7511F; }
        .deals-strip a.active { border-bottom-color: #FF9900; font-weight: 700; color: #C7511F; }

        /* Breadcrumb */
        .breadcrumb { padding: 8px 24px; font-size: 13px; background: #fff; display: flex; align-items: center; flex-wrap: wrap; gap: 2px; border-bottom: 1px solid #e7e7e7; }
        .breadcrumb a { color: #007185; }
        .breadcrumb a:hover { color: #C7511F; text-decoration: underline; }
        .breadcrumb span.sep { color: #aaa; margin: 0 4px; }

        /* Promo bar */
        .promo-bar { background: linear-gradient(90deg, #c0392b 0%, #CC0C39 50%, #c0392b 100%); color: #fff; text-align: center; padding: 7px 16px; font-size: 13px; font-weight: 700; letter-spacing: .5px; display: flex; align-items: center; justify-content: center; gap: 8px; }

        /* Footer */
        footer { background: #232F3E; color: #ccc; margin-top: 0; }
        .footer-back-top { background: #37475A; padding: 15px; text-align: center; color: #fff; font-size: 13px; cursor: pointer; transition: background .15s; }
        .footer-back-top:hover { background: #485769; }
        .footer-mid { display: flex; justify-content: center; gap: 56px; padding: 36px 24px 28px; flex-wrap: wrap; border-bottom: 1px solid #3a4553; }
        .footer-col h4 { color: #fff; font-size: 14px; font-weight: 700; margin: 0 0 12px; }
        .footer-col a { display: block; color: #ccc; font-size: 13px; margin-bottom: 7px; }
        .footer-col a:hover { color: #fff; text-decoration: underline; }
        .footer-social { display: flex; gap: 12px; margin-top: 4px; }
        .footer-social a { display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: #3a4553; border-radius: 50%; transition: background .15s; color: #ccc; }
        .footer-social a:hover { background: #FF9900; color: #131921; }
        .footer-bot { background: #131921; padding: 18px; text-align: center; font-size: 12px; color: #777; display: flex; flex-direction: column; align-items: center; gap: 8px; }
        .footer-bot-links { display: flex; gap: 16px; flex-wrap: wrap; justify-content: center; }
        .footer-bot-links a { color: #888; }
        .footer-bot-links a:hover { color: #ccc; text-decoration: underline; }
        .footer-logo-bot { font-size: 18px; font-weight: 900; color: #FF9900; margin-bottom: 4px; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #bbb; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #999; }
    </style>
    @yield('head')
</head>
<body>

{{-- Promo bar --}}
<div class="promo-bar">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
    FREE SHIPPING on orders over $50 &nbsp;|&nbsp; Shop now and save!
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
</div>

{{-- Top Nav --}}
<div class="nav-top">
    {{-- Logo --}}
    <a href="{{ route('home') }}" class="nav-logo">My<span>Shop</span></a>

    {{-- Deliver to --}}
    <div class="nav-deliver">
        <svg width="16" height="20" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        <div class="nav-deliver-text">
            <span>Deliver to</span>
            <b>Your Location</b>
        </div>
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
        <button type="button" class="nav-search-btn" id="searchBtn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </button>
        <div class="search-dropdown" id="searchDropdown" style="display:none;"></div>
    </div>

    {{-- Right nav --}}
    <div class="nav-right">
        {{-- Language selector --}}
        <div class="nav-lang" id="langBtn" onclick="toggleLangDropdown()">
            <svg width="22" height="15" viewBox="0 0 22 15" fill="none" xmlns="http://www.w3.org/2000/svg" style="border-radius:2px;flex-shrink:0;">
                <rect width="22" height="15" fill="#B22234"/>
                <rect y="1.15" width="22" height="1.15" fill="white"/>
                <rect y="3.46" width="22" height="1.15" fill="white"/>
                <rect y="5.77" width="22" height="1.15" fill="white"/>
                <rect y="8.08" width="22" height="1.15" fill="white"/>
                <rect y="10.38" width="22" height="1.15" fill="white"/>
                <rect y="12.69" width="22" height="1.15" fill="white"/>
                <rect width="9" height="8" fill="#3C3B6E"/>
            </svg>
            <span id="langLabel" style="font-size:13px;font-weight:700;">EN</span>
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
            <div class="nav-lang-dropdown" id="langDropdown">
                <div class="nav-lang-option selected" onclick="selectLang('EN','English')" data-lang="EN">
                    <svg width="22" height="15" viewBox="0 0 22 15" fill="none" style="border-radius:2px;flex-shrink:0;"><rect width="22" height="15" fill="#B22234"/><rect y="1.15" width="22" height="1.15" fill="white"/><rect y="3.46" width="22" height="1.15" fill="white"/><rect y="5.77" width="22" height="1.15" fill="white"/><rect y="8.08" width="22" height="1.15" fill="white"/><rect y="10.38" width="22" height="1.15" fill="white"/><rect y="12.69" width="22" height="1.15" fill="white"/><rect width="9" height="8" fill="#3C3B6E"/></svg>
                    English <span class="lang-code">EN</span>
                </div>
                <div class="nav-lang-option" onclick="selectLang('ES','Español')" data-lang="ES">
                    <svg width="22" height="15" viewBox="0 0 22 15" fill="none" style="border-radius:2px;flex-shrink:0;"><rect width="22" height="15" fill="#c60b1e"/><rect y="3.75" width="22" height="7.5" fill="#ffc400"/></svg>
                    Español <span class="lang-code">ES</span>
                </div>
                <div class="nav-lang-option" onclick="selectLang('FR','Français')" data-lang="FR">
                    <svg width="22" height="15" viewBox="0 0 22 15" fill="none" style="border-radius:2px;flex-shrink:0;"><rect width="7.33" height="15" fill="#002395"/><rect x="7.33" width="7.33" height="15" fill="white"/><rect x="14.67" width="7.33" height="15" fill="#ED2939"/></svg>
                    Français <span class="lang-code">FR</span>
                </div>
                <div class="nav-lang-option" onclick="selectLang('DE','Deutsch')" data-lang="DE">
                    <svg width="22" height="15" viewBox="0 0 22 15" fill="none" style="border-radius:2px;flex-shrink:0;"><rect width="22" height="5" fill="#000"/><rect y="5" width="22" height="5" fill="#D00"/><rect y="10" width="22" height="5" fill="#FFCE00"/></svg>
                    Deutsch <span class="lang-code">DE</span>
                </div>
                <div class="nav-lang-option" onclick="selectLang('AR','العربية')" data-lang="AR">
                    <svg width="22" height="15" viewBox="0 0 22 15" fill="none" style="border-radius:2px;flex-shrink:0;"><rect width="22" height="5" fill="#006233"/><rect y="5" width="22" height="5" fill="white"/><rect y="10" width="22" height="5" fill="#006233"/></svg>
                    العربية <span class="lang-code">AR</span>
                </div>
                <div class="nav-lang-option" onclick="selectLang('ZH','中文')" data-lang="ZH">
                    <svg width="22" height="15" viewBox="0 0 22 15" fill="none" style="border-radius:2px;flex-shrink:0;"><rect width="22" height="15" fill="#DE2910"/><polygon points="4,2 5,5 8,5 5.5,7 6.5,10 4,8 1.5,10 2.5,7 0,5 3,5" fill="#FFDE00"/></svg>
                    中文 <span class="lang-code">ZH</span>
                </div>
            </div>
        </div>
        @auth
            <a href="#" class="nav-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <div class="nav-btn-text">
                    <span>Hello, {{ auth()->user()->name }}</span>
                    <b>Account</b>
                </div>
            </a>
            <form method="POST" action="{{ route('store.logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="nav-btn" style="background:none;border:1px solid #555;cursor:pointer;">
                    <div class="nav-btn-text"><span>&nbsp;</span><b>Sign Out</b></div>
                </button>
            </form>
        @else
            <a href="{{ route('store.login') }}" class="nav-btn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <div class="nav-btn-text">
                    <span>Hello, Sign in</span>
                    <b>Account &amp; Lists</b>
                </div>
            </a>
        @endauth
        <a href="{{ route('products.index') }}" class="nav-btn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
            <div class="nav-btn-text">
                <span>&nbsp;</span>
                <b>Returns &amp; Orders</b>
            </div>
        </a>
        <a href="#" class="nav-cart">
            <svg width="24" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            <span class="nav-cart-count" id="cartCount">0</span>
            <span style="font-size:14px;font-weight:700;">Cart</span>
        </a>
    </div>
</div>

{{-- Category strip --}}
<div class="cat-strip" id="catStripMain">
    <a href="{{ route('home') }}">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        All
    </a>
    <a href="{{ route('products.index') }}">Today's Deals</a>
    <a href="{{ route('products.index') }}">Electronics</a>
    <a href="{{ route('products.index') }}">New Arrivals</a>
    <a href="{{ route('products.index') }}">Best Sellers</a>
    <a href="{{ route('products.index') }}">Customer Service</a>
    <a href="{{ route('products.index') }}" class="prime">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        Prime
    </a>
</div>

{{-- Deals strip --}}
<div class="deals-strip">
    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.index') && !request()->anyFilled(['category','brand','q']) ? 'active' : '' }}">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
        Today's Deals
    </a>
    <a href="{{ route('products.index', ['sort'=>'latest']) }}">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        Coupons
    </a>
    <a href="{{ route('products.index') }}">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
        Renewed Deals
    </a>
    <a href="{{ route('products.index') }}">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
        Outlet
    </a>
    <a href="{{ route('products.index') }}">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        MyShop Resale
    </a>
    <a href="{{ route('products.index') }}">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        Local Deals
    </a>
    <a href="{{ route('products.index') }}">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        Electronics
    </a>
    <a href="{{ route('products.index') }}">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        Home &amp; Garden
    </a>
    <a href="{{ route('products.index') }}">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/></svg>
        Fashion
    </a>
    <a href="{{ route('products.index') }}">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>
        Sports
    </a>
    <a href="{{ route('products.index') }}">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"/></svg>
        Beauty
    </a>
    <a href="{{ route('products.index') }}">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3z"/></svg>
        New Releases
    </a>
    <a href="{{ route('products.index', ['sort'=>'price_asc']) }}">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        Best Price
    </a>
    <a href="{{ route('products.index', ['sort'=>'name']) }}">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
        A–Z Listings
    </a>
</div>

{{-- Content --}}
@yield('content')

{{-- Footer --}}
<footer>
    <div class="footer-back-top" onclick="window.scrollTo({top:0,behavior:'smooth'})">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:middle;margin-right:6px;"><polyline points="18 15 12 9 6 15"/></svg>
        Back to top
    </div>
    <div class="footer-mid">
        <div class="footer-col">
            <h4>Get to Know Us</h4>
            <a href="#">About MyShop</a>
            <a href="#">Careers</a>
            <a href="#">Press Releases</a>
            <a href="#">MyShop Cares</a>
            <a href="#">Investor Relations</a>
        </div>
        <div class="footer-col">
            <h4>Make Money with Us</h4>
            <a href="#">Sell on MyShop</a>
            <a href="#">Become an Affiliate</a>
            <a href="#">Advertise Your Products</a>
            <a href="#">Self-Publish with Us</a>
        </div>
        <div class="footer-col">
            <h4>Let Us Help You</h4>
            <a href="#">Your Account</a>
            <a href="#">Your Orders</a>
            <a href="#">Shipping Rates &amp; Policies</a>
            <a href="#">Returns &amp; Replacements</a>
            <a href="#">Help Center</a>
        </div>
        <div class="footer-col">
            <h4>Follow Us</h4>
            <div class="footer-social">
                <a href="#" title="Facebook">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                </a>
                <a href="#" title="Twitter/X">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M4 4l16 16M4 20L20 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                </a>
                <a href="#" title="Instagram">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                </a>
                <a href="#" title="YouTube">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 0 0 1.46 6.42 29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58 2.78 2.78 0 0 0 1.95 1.96C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.96-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="#232F3E"/></svg>
                </a>
            </div>
        </div>
    </div>
    <div class="footer-bot">
        <div class="footer-logo-bot">MyShop</div>
        <div class="footer-bot-links">
            <a href="#">Conditions of Use</a>
            <a href="#">Privacy Notice</a>
            <a href="#">Your Ads Privacy Choices</a>
            <a href="#">Cookie Preferences</a>
            <a href="#">Terms &amp; Conditions</a>
        </div>
        <div>&copy; {{ date('Y') }} MyShop, Inc. All rights reserved.</div>
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
                            : `<div class="search-no-img"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#bbb" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg></div>`
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
<script>
// ===== LANGUAGE SELECTOR =====
function toggleLangDropdown() {
    const dd = document.getElementById('langDropdown');
    dd.classList.toggle('open');
}
function selectLang(code, label) {
    document.getElementById('langLabel').textContent = code;
    document.querySelectorAll('.nav-lang-option').forEach(el => {
        el.classList.toggle('selected', el.dataset.lang === code);
    });
    document.getElementById('langDropdown').classList.remove('open');
    localStorage.setItem('myshop_lang', code);
    event.stopPropagation();
}
document.addEventListener('click', function(e) {
    const btn = document.getElementById('langBtn');
    if (btn && !btn.contains(e.target)) {
        const dd = document.getElementById('langDropdown');
        if (dd) dd.classList.remove('open');
    }
});
(function(){
    const saved = localStorage.getItem('myshop_lang');
    if (saved && saved !== 'EN') {
        const names = {ES:'Español',FR:'Français',DE:'Deutsch',AR:'العربية',ZH:'中文'};
        if (names[saved]) selectLang(saved, names[saved]);
    }
})();
</script>
</body>
</html>
