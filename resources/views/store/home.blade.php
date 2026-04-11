@extends('store.layout')
@section('title', 'MyShop — Online Shopping for Electronics, Clothing & More')

@section('head')
<style>
    /* Hero Slider */
    .hero-slider { position: relative; overflow: hidden; height: 480px; background: #0a1628; }
    .hero-slide { position: absolute; inset: 0; display: flex; align-items: center; opacity: 0; transition: opacity .7s ease; pointer-events: none; }
    .hero-slide.active { opacity: 1; pointer-events: auto; }

    /* Slide backgrounds with real images */
    .hero-slide-1 {
        background: url('https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=1400&q=80&auto=format&fit=crop') center/cover no-repeat;
    }
    .hero-slide-1::before {
        content:''; position:absolute; inset:0;
        background: linear-gradient(100deg, rgba(10,22,40,.92) 0%, rgba(19,25,33,.80) 50%, rgba(10,22,40,.55) 100%);
        pointer-events:none;
    }

    .hero-slide-2 {
        background: url('https://images.unsplash.com/photo-1498049794561-7780e7231661?w=1400&q=80&auto=format&fit=crop') center/cover no-repeat;
    }
    .hero-slide-2::before {
        content:''; position:absolute; inset:0;
        background: linear-gradient(100deg, rgba(13,27,75,.93) 0%, rgba(26,45,107,.82) 50%, rgba(10,22,40,.55) 100%);
        pointer-events:none;
    }

    .hero-slide-3 {
        background: url('https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=1400&q=80&auto=format&fit=crop') center/cover no-repeat;
    }
    .hero-slide-3::before {
        content:''; position:absolute; inset:0;
        background: linear-gradient(100deg, rgba(10,32,24,.93) 0%, rgba(13,45,32,.82) 50%, rgba(10,22,40,.55) 100%);
        pointer-events:none;
    }

    /* Slide 4 — Home & Living (warm amber) */
    .hero-slide-4 {
        background: url('https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=1400&q=80&auto=format&fit=crop') center/cover no-repeat;
    }
    .hero-slide-4::before {
        content:''; position:absolute; inset:0;
        background: linear-gradient(100deg, rgba(40,20,5,.93) 0%, rgba(70,35,5,.82) 50%, rgba(20,12,0,.55) 100%);
        pointer-events:none;
    }

    /* Slide 5 — Sports & Fitness (dark red) */
    .hero-slide-5 {
        background: url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=1400&q=80&auto=format&fit=crop') center/cover no-repeat;
    }
    .hero-slide-5::before {
        content:''; position:absolute; inset:0;
        background: linear-gradient(100deg, rgba(40,5,5,.93) 0%, rgba(80,10,10,.82) 50%, rgba(20,5,5,.55) 100%);
        pointer-events:none;
    }

    .hero-content { position: relative; z-index: 2; max-width: 1240px; margin: 0 auto; padding: 0 48px; display: flex; align-items: center; justify-content: space-between; width: 100%; gap: 32px; }
    .hero-text { flex: 1; max-width: 560px; }
    .hero-badge { display: inline-flex; align-items: center; gap: 7px; background: rgba(255,153,0,.15); border: 1px solid rgba(255,153,0,.35); border-radius: 20px; padding: 5px 14px; font-size: 12px; font-weight: 700; color: #FF9900; letter-spacing: .5px; margin-bottom: 18px; text-transform: uppercase; }
    .hero-title { font-size: 42px; font-weight: 900; color: #fff; line-height: 1.1; margin: 0 0 16px; letter-spacing: -1px; }
    .hero-title .accent { color: #FF9900; position: relative; }
    .hero-title .accent-blue { color: #4db8ff; }
    .hero-title .accent-green { color: #00e096; }
    .hero-subtitle { font-size: 16px; color: #99a8bb; line-height: 1.65; margin: 0 0 28px; max-width: 460px; }
    .hero-btns { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
    .btn-primary { background: #FF9900; color: #131921; padding: 14px 32px; border-radius: 6px; font-size: 15px; font-weight: 800; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: background .15s, transform .1s, box-shadow .15s; box-shadow: 0 4px 20px rgba(255,153,0,.35); }
    .btn-primary:hover { background: #e88b00; transform: translateY(-2px); box-shadow: 0 6px 24px rgba(255,153,0,.45); }
    .btn-outline { background: transparent; color: #fff; padding: 13px 28px; border-radius: 6px; font-size: 15px; font-weight: 700; border: 1.5px solid rgba(255,255,255,.35); cursor: pointer; display: inline-flex; align-items: center; gap: 7px; transition: border-color .15s, background .15s; }
    .btn-outline:hover { border-color: #fff; background: rgba(255,255,255,.08); }

    /* Hero stats */
    .hero-stats { display: flex; gap: 28px; margin-top: 36px; flex-wrap: wrap; }
    .hero-stat { text-align: left; }
    .hero-stat-num { font-size: 24px; font-weight: 900; color: #fff; line-height: 1; }
    .hero-stat-num span { color: #FF9900; }
    .hero-stat-label { font-size: 11px; color: #667; margin-top: 3px; text-transform: uppercase; letter-spacing: .5px; }

    /* Hero visual panel */
    .hero-visual { flex-shrink: 0; width: 320px; position: relative; display: flex; flex-direction: column; gap: 10px; }
    .hero-main-img { position: relative; border-radius: 16px; overflow: hidden; height: 210px; box-shadow: 0 20px 60px rgba(0,0,0,.5); }
    .hero-main-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .hero-main-img-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,.55) 0%, transparent 55%); }
    .hero-main-img-label { position: absolute; bottom: 12px; left: 14px; right: 14px; display: flex; align-items: flex-end; justify-content: space-between; }
    .hero-main-img-label span { font-size: 13px; font-weight: 700; color: #fff; text-shadow: 0 1px 4px rgba(0,0,0,.5); }
    .hero-main-img-price { background: #FF9900; color: #131921; font-size: 13px; font-weight: 800; border-radius: 8px; padding: 4px 10px; }
    .hero-discount-badge { position: absolute; top: 12px; left: 12px; background: #CC0C39; color: #fff; font-size: 11px; font-weight: 800; border-radius: 6px; padding: 3px 9px; letter-spacing: .3px; }
    .hero-thumbs { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; }
    .hero-thumb { border-radius: 10px; overflow: hidden; height: 80px; position: relative; cursor: pointer; box-shadow: 0 4px 16px rgba(0,0,0,.35); transition: transform .15s; }
    .hero-thumb:hover { transform: scale(1.04); }
    .hero-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .hero-thumb-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,.5) 0%, transparent 60%); }
    .hero-thumb-label { position: absolute; bottom: 6px; left: 6px; right: 6px; font-size: 10px; font-weight: 700; color: #fff; text-shadow: 0 1px 3px rgba(0,0,0,.6); line-height: 1.2; }

    /* Hero feature cards (small) */
    .hero-card { background: rgba(255,255,255,.07); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,.1); border-radius: 14px; padding: 12px 14px; display: flex; align-items: center; gap: 12px; }
    .hero-card-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .hero-card-icon.orange { background: rgba(255,153,0,.2); }
    .hero-card-icon.blue { background: rgba(77,184,255,.2); }
    .hero-card-icon.green { background: rgba(0,224,150,.2); }
    .hero-card-text strong { display: block; font-size: 13px; font-weight: 700; color: #fff; }
    .hero-card-text span { font-size: 11px; color: #99a8bb; }
    .hero-card-badge { margin-left: auto; background: #FF9900; color: #131921; font-size: 10px; font-weight: 800; border-radius: 10px; padding: 3px 9px; white-space: nowrap; flex-shrink: 0; }
    .hero-card-badge.blue-badge { background: #4db8ff; color: #0a1628; }
    .hero-card-badge.green-badge { background: #00e096; color: #0a2018; }

    /* Floating dot decorations */
    .hero-dots { position: absolute; top: 24px; right: 24px; display: grid; grid-template-columns: repeat(5,8px); gap: 6px; opacity: .18; }
    .hero-dots span { width: 8px; height: 8px; border-radius: 50%; background: #fff; display: block; }

    /* Slider nav */
    .hero-nav { position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); display: flex; gap: 8px; z-index: 10; }
    .hero-dot { width: 8px; height: 8px; border-radius: 4px; background: rgba(255,255,255,.35); cursor: pointer; transition: background .2s, width .2s; border: none; padding: 0; }
    .hero-dot.active { background: #FF9900; width: 24px; }
    .hero-arrow { position: absolute; top: 50%; transform: translateY(-50%); z-index: 10; background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2); color: #fff; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background .15s; backdrop-filter: blur(6px); }
    .hero-arrow:hover { background: rgba(255,255,255,.2); }
    .hero-arrow-left { left: 16px; }
    .hero-arrow-right { right: 16px; }

    @media (max-width: 768px) {
        .hero-slider { height: auto; min-height: 400px; }
        .hero-content { flex-direction: column; padding: 40px 20px 60px; text-align: center; }
        .hero-visual { display: none; }
        .hero-title { font-size: 30px; }
        .hero-btns { justify-content: center; }
        .hero-stats { justify-content: center; }
    }

    /* Sections */
    .section { max-width: 1240px; margin: 0 auto; padding: 28px 16px; }
    .section-header { display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 18px; }
    .section-title { font-size: 22px; font-weight: 700; color: #0F1111; border-left: 4px solid #FF9900; padding-left: 10px; margin: 0; }
    .section-link { font-size: 13px; color: #007185; white-space: nowrap; }
    .section-link:hover { color: #C7511F; text-decoration: underline; }

    /* Category grid */
    .cat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 12px; }
    .cat-card { background: #fff; border: 1px solid #e3e6e6; border-radius: 10px; padding: 20px 12px 16px; text-align: center; cursor: pointer; transition: box-shadow .15s, transform .15s, border-color .15s; }
    .cat-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,.1); transform: translateY(-3px); border-color: #FF9900; }
    .cat-card .cat-icon { width: 52px; height: 52px; margin: 0 auto 10px; background: #fff8ee; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
    .cat-card .name { font-size: 13px; font-weight: 600; color: #0F1111; }

    /* Product grid */
    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
    .product-card { background: #fff; border: 1px solid #e3e6e6; border-radius: 8px; overflow: hidden; cursor: pointer; transition: box-shadow .15s; display: flex; flex-direction: column; }
    .product-card:hover { box-shadow: 0 4px 18px rgba(0,0,0,.13); }
    .product-card-img { height: 185px; display: flex; align-items: center; justify-content: center; background: #f7f8f8; padding: 12px; overflow: hidden; position: relative; }
    .product-card-img img { max-height: 161px; max-width: 100%; object-fit: contain; }
    .product-card-no-img { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px; color: #ccc; }
    .product-card-body { padding: 10px 12px 14px; flex: 1; display: flex; flex-direction: column; }
    .product-card-name { font-size: 13px; color: #0F1111; margin-bottom: 4px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.4; flex: 1; }
    .product-card-brand { font-size: 12px; color: #007185; margin-bottom: 4px; font-weight: 600; }
    .product-card-stars { display: flex; align-items: center; gap: 3px; margin-bottom: 5px; }
    .star-filled { color: #FF9900; }
    .product-card-price { font-size: 16px; font-weight: 700; color: #B12704; }
    .product-card-stock { font-size: 12px; color: #007600; margin-top: 3px; font-weight: 500; }
    .product-card-stock.out { color: #CC0C39; }
    .btn-add { width: 100%; background: #FFD814; border: 1px solid #FCD200; border-radius: 20px; padding: 7px; font-size: 13px; cursor: pointer; margin-top: 10px; font-weight: 600; transition: background .12s; display: flex; align-items: center; justify-content: center; gap: 5px; }
    .btn-add:hover { background: #F7CA00; }

    /* Deal section */
    .deal-wrap { background: linear-gradient(135deg, #fff8ec 0%, #fff3dc 100%); border-top: 3px solid #FF9900; padding: 28px 0; }
    .deal-banner { background: linear-gradient(90deg, #FF9900 0%, #FF6600 100%); color: #fff; border-radius: 10px; padding: 20px 26px; margin-bottom: 22px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; box-shadow: 0 4px 16px rgba(255,102,0,.2); }
    .deal-banner-left { display: flex; align-items: center; gap: 14px; }
    .deal-banner h2 { font-size: 22px; font-weight: 800; margin: 0; }
    .deal-banner p { font-size: 14px; margin: 3px 0 0; opacity: .9; }
    .deal-banner-btn { background: #fff; color: #FF6600; padding: 9px 22px; border-radius: 6px; font-size: 13px; font-weight: 700; white-space: nowrap; transition: background .12s; }
    .deal-banner-btn:hover { background: #f7f8f8; }

    /* Brands */
    .brand-grid { display: flex; gap: 12px; flex-wrap: wrap; }
    .brand-chip { background: #fff; border: 1px solid #e3e6e6; border-radius: 24px; padding: 8px 20px; font-size: 13px; font-weight: 600; color: #0F1111; cursor: pointer; transition: background .12s, border-color .12s, color .12s; }
    .brand-chip:hover { background: #FF9900; border-color: #FF9900; color: #fff; }

    /* Trust bar */
    .trust-bar { background: #fff; border-top: 1px solid #e7e7e7; border-bottom: 1px solid #e7e7e7; padding: 20px 16px; }
    .trust-bar-inner { max-width: 1240px; margin: 0 auto; display: flex; justify-content: center; gap: 48px; flex-wrap: wrap; }
    .trust-item { display: flex; align-items: center; gap: 10px; }
    .trust-item-icon { width: 40px; height: 40px; background: #fff8ee; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .trust-item-text strong { display: block; font-size: 13px; font-weight: 700; color: #0F1111; }
    .trust-item-text span { font-size: 12px; color: #666; }
</style>
@endsection

@section('content')

{{-- Hero Slider --}}
<div class="hero-slider" id="heroSlider">

    {{-- Slide 1: Welcome / General --}}
    <div class="hero-slide hero-slide-1 active">
        <div class="hero-dots">
            @for($d=0;$d<25;$d++)<span></span>@endfor
        </div>
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-badge">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    Limited Time Offers
                </div>
                <h1 class="hero-title">Welcome to<br><span class="accent">MyShop</span> Store</h1>
                <p class="hero-subtitle">Discover millions of products at unbeatable prices. Fast delivery, easy returns, and world-class customer support.</p>
                <div class="hero-btns">
                    <a href="{{ route('products.index') }}" class="btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        Shop Now
                    </a>
                    @guest
                    <a href="{{ route('store.register') }}" class="btn-outline">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                        Create Account
                    </a>
                    @endguest
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-num">2M<span>+</span></div>
                        <div class="hero-stat-label">Products</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-num">500K<span>+</span></div>
                        <div class="hero-stat-label">Happy Customers</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-num">50<span>+</span></div>
                        <div class="hero-stat-label">Top Brands</div>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-main-img">
                    <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?w=700&q=85&auto=format&fit=crop" alt="Shopping" />
                    <div class="hero-main-img-overlay"></div>
                    <div class="hero-discount-badge">UP TO 60% OFF</div>
                    <div class="hero-main-img-label">
                        <span>Top Deals Today</span>
                        <span class="hero-main-img-price">From $9.99</span>
                    </div>
                </div>
                <div class="hero-thumbs">
                    <a href="{{ route('products.index') }}" class="hero-thumb">
                        <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=300&q=80&auto=format&fit=crop" alt="Camera" />
                        <div class="hero-thumb-overlay"></div>
                        <div class="hero-thumb-label">Electronics</div>
                    </a>
                    <a href="{{ route('products.index') }}" class="hero-thumb">
                        <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=300&q=80&auto=format&fit=crop" alt="Shoes" />
                        <div class="hero-thumb-overlay"></div>
                        <div class="hero-thumb-label">Footwear</div>
                    </a>
                    <a href="{{ route('products.index') }}" class="hero-thumb">
                        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=300&q=80&auto=format&fit=crop" alt="Watch" />
                        <div class="hero-thumb-overlay"></div>
                        <div class="hero-thumb-label">Accessories</div>
                    </a>
                    <a href="{{ route('products.index') }}" class="hero-thumb">
                        <img src="https://images.unsplash.com/photo-1586495777744-4e6232bf2177?w=300&q=80&auto=format&fit=crop" alt="Beauty" />
                        <div class="hero-thumb-overlay"></div>
                        <div class="hero-thumb-label">Beauty</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Slide 2: Electronics / Tech --}}
    <div class="hero-slide hero-slide-2">
        <div class="hero-dots">
            @for($d=0;$d<25;$d++)<span></span>@endfor
        </div>
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-badge" style="background:rgba(77,184,255,.15);border-color:rgba(77,184,255,.35);color:#4db8ff;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#4db8ff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    New Tech Arrivals
                </div>
                <h1 class="hero-title">Shop the Latest<br><span class="accent-blue">Electronics</span><br>&amp; Gadgets</h1>
                <p class="hero-subtitle">From laptops to smartphones — explore cutting-edge technology at prices that won't break the bank.</p>
                <div class="hero-btns">
                    <a href="{{ route('products.index') }}" class="btn-primary" style="background:#4db8ff;box-shadow:0 4px 20px rgba(77,184,255,.35);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                        Explore Electronics
                    </a>
                    <a href="{{ route('products.index', ['sort'=>'latest']) }}" class="btn-outline">
                        New Arrivals &rsaquo;
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-num" style="color:#4db8ff;">100K<span style="color:#4db8ff;">+</span></div>
                        <div class="hero-stat-label">Tech Products</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-num" style="color:#4db8ff;">Up to <span style="color:#4db8ff;">60%</span></div>
                        <div class="hero-stat-label">Off Retail Price</div>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-main-img">
                    <img src="https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?w=700&q=85&auto=format&fit=crop" alt="Laptop" />
                    <div class="hero-main-img-overlay"></div>
                    <div class="hero-discount-badge">NEW ARRIVALS</div>
                    <div class="hero-main-img-label">
                        <span>Latest Laptops</span>
                        <span class="hero-main-img-price" style="background:#4db8ff;color:#0a1628;">From $499</span>
                    </div>
                </div>
                <div class="hero-thumbs">
                    <a href="{{ route('products.index') }}" class="hero-thumb">
                        <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=300&q=80&auto=format&fit=crop" alt="Phone" />
                        <div class="hero-thumb-overlay"></div>
                        <div class="hero-thumb-label">Smartphones</div>
                    </a>
                    <a href="{{ route('products.index') }}" class="hero-thumb">
                        <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=300&q=80&auto=format&fit=crop" alt="Headphones" />
                        <div class="hero-thumb-overlay"></div>
                        <div class="hero-thumb-label">Headphones</div>
                    </a>
                    <a href="{{ route('products.index') }}" class="hero-thumb">
                        <img src="https://images.unsplash.com/photo-1585386959984-a4155224a1ad?w=300&q=80&auto=format&fit=crop" alt="Gadgets" />
                        <div class="hero-thumb-overlay"></div>
                        <div class="hero-thumb-label">Gadgets</div>
                    </a>
                    <a href="{{ route('products.index') }}" class="hero-thumb">
                        <img src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=300&q=80&auto=format&fit=crop" alt="Smartwatch" />
                        <div class="hero-thumb-overlay"></div>
                        <div class="hero-thumb-label">Smartwatches</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Slide 3: Fashion / Style --}}
    <div class="hero-slide hero-slide-3">
        <div class="hero-dots">
            @for($d=0;$d<25;$d++)<span></span>@endfor
        </div>
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-badge" style="background:rgba(0,224,150,.12);border-color:rgba(0,224,150,.3);color:#00e096;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#00e096" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/></svg>
                    New Season Collection
                </div>
                <h1 class="hero-title">Upgrade Your<br><span class="accent-green">Style</span> with<br>Top Brands</h1>
                <p class="hero-subtitle">Explore the latest fashion trends — clothing, footwear, and accessories from the world's best brands, delivered to your door.</p>
                <div class="hero-btns">
                    <a href="{{ route('products.index') }}" class="btn-primary" style="background:#00e096;color:#0a2018;box-shadow:0 4px 20px rgba(0,224,150,.3);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/></svg>
                        Shop Fashion
                    </a>
                    <a href="{{ route('products.index') }}" class="btn-outline">
                        View Lookbook &rsaquo;
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-num" style="color:#00e096;">5K<span style="color:#00e096;">+</span></div>
                        <div class="hero-stat-label">Style Items</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-num" style="color:#00e096;">200<span style="color:#00e096;">+</span></div>
                        <div class="hero-stat-label">Fashion Brands</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-num" style="color:#00e096;">New<span style="color:#00e096;"> Daily</span></div>
                        <div class="hero-stat-label">Arrivals</div>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-main-img">
                    <img src="https://images.unsplash.com/photo-1469334031218-e382a71b716b?w=700&q=85&auto=format&fit=crop" alt="Fashion" />
                    <div class="hero-main-img-overlay"></div>
                    <div class="hero-discount-badge">NEW SEASON</div>
                    <div class="hero-main-img-label">
                        <span>Women's Collection</span>
                        <span class="hero-main-img-price" style="background:#00e096;color:#0a2018;">From $29.99</span>
                    </div>
                </div>
                <div class="hero-thumbs">
                    <a href="{{ route('products.index') }}" class="hero-thumb">
                        <img src="https://images.unsplash.com/photo-1490578474895-699cd4e2cf59?w=300&q=80&auto=format&fit=crop" alt="Men Fashion" />
                        <div class="hero-thumb-overlay"></div>
                        <div class="hero-thumb-label">Men's Style</div>
                    </a>
                    <a href="{{ route('products.index') }}" class="hero-thumb">
                        <img src="https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=300&q=80&auto=format&fit=crop" alt="Sneakers" />
                        <div class="hero-thumb-overlay"></div>
                        <div class="hero-thumb-label">Footwear</div>
                    </a>
                    <a href="{{ route('products.index') }}" class="hero-thumb">
                        <img src="https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=300&q=80&auto=format&fit=crop" alt="Bags" />
                        <div class="hero-thumb-overlay"></div>
                        <div class="hero-thumb-label">Handbags</div>
                    </a>
                    <a href="{{ route('products.index') }}" class="hero-thumb">
                        <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?w=300&q=80&auto=format&fit=crop" alt="Dresses" />
                        <div class="hero-thumb-overlay"></div>
                        <div class="hero-thumb-label">Dresses</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Slide 4: Home & Living --}}
    <div class="hero-slide hero-slide-4">
        <div class="hero-dots">
            @for($d=0;$d<25;$d++)<span></span>@endfor
        </div>
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-badge" style="background:rgba(255,180,0,.15);border-color:rgba(255,180,0,.4);color:#ffb400;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#ffb400" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Home &amp; Living
                </div>
                <h1 class="hero-title">Transform Your<br><span style="color:#ffb400;">Home</span> with<br>Premium Décor</h1>
                <p class="hero-subtitle">Furniture, lighting, kitchen essentials and home décor — everything you need to make your space beautiful.</p>
                <div class="hero-btns">
                    <a href="{{ route('products.index') }}" class="btn-primary" style="background:#ffb400;color:#1a0f00;box-shadow:0 4px 20px rgba(255,180,0,.35);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        Shop Home
                    </a>
                    <a href="{{ route('products.index') }}" class="btn-outline">View Collections &rsaquo;</a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-num" style="color:#ffb400;">8K<span style="color:#ffb400;">+</span></div>
                        <div class="hero-stat-label">Home Products</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-num" style="color:#ffb400;">Up to <span style="color:#ffb400;">40%</span></div>
                        <div class="hero-stat-label">Off This Week</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-num" style="color:#ffb400;">Free<span style="color:#ffb400;"> Assembly</span></div>
                        <div class="hero-stat-label">On Furniture</div>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-main-img">
                    <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=700&q=85&auto=format&fit=crop" alt="Sofa" />
                    <div class="hero-main-img-overlay"></div>
                    <div class="hero-discount-badge" style="background:#ffb400;color:#1a0f00;">40% OFF</div>
                    <div class="hero-main-img-label">
                        <span>Premium Furniture</span>
                        <span class="hero-main-img-price" style="background:#ffb400;color:#1a0f00;">From $199</span>
                    </div>
                </div>
                <div class="hero-thumbs">
                    <a href="{{ route('products.index') }}" class="hero-thumb">
                        <img src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?w=300&q=80&auto=format&fit=crop" alt="Bedroom" />
                        <div class="hero-thumb-overlay"></div>
                        <div class="hero-thumb-label">Bedroom</div>
                    </a>
                    <a href="{{ route('products.index') }}" class="hero-thumb">
                        <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=300&q=80&auto=format&fit=crop" alt="Kitchen" />
                        <div class="hero-thumb-overlay"></div>
                        <div class="hero-thumb-label">Kitchen</div>
                    </a>
                    <a href="{{ route('products.index') }}" class="hero-thumb">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&q=80&auto=format&fit=crop" alt="Lighting" />
                        <div class="hero-thumb-overlay"></div>
                        <div class="hero-thumb-label">Lighting</div>
                    </a>
                    <a href="{{ route('products.index') }}" class="hero-thumb">
                        <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=300&q=80&auto=format&fit=crop" alt="Garden" />
                        <div class="hero-thumb-overlay"></div>
                        <div class="hero-thumb-label">Garden</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Slide 5: Sports & Fitness --}}
    <div class="hero-slide hero-slide-5">
        <div class="hero-dots">
            @for($d=0;$d<25;$d++)<span></span>@endfor
        </div>
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-badge" style="background:rgba(255,60,60,.15);border-color:rgba(255,60,60,.4);color:#ff4444;">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#ff4444" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                    Sports &amp; Fitness
                </div>
                <h1 class="hero-title">Gear Up &amp;<br><span style="color:#ff4444;">Train Hard</span><br>with Top Gear</h1>
                <p class="hero-subtitle">Professional sports equipment, gym wear, and fitness accessories — everything to power your active lifestyle.</p>
                <div class="hero-btns">
                    <a href="{{ route('products.index') }}" class="btn-primary" style="background:#ff4444;color:#fff;box-shadow:0 4px 20px rgba(255,60,60,.35);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                        Shop Sports
                    </a>
                    <a href="{{ route('products.index') }}" class="btn-outline">View All Gear &rsaquo;</a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-num" style="color:#ff4444;">12K<span style="color:#ff4444;">+</span></div>
                        <div class="hero-stat-label">Sports Items</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-num" style="color:#ff4444;">Pro<span style="color:#ff4444;"> Brands</span></div>
                        <div class="hero-stat-label">Nike · Adidas · more</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-num" style="color:#ff4444;">Same<span style="color:#ff4444;"> Day</span></div>
                        <div class="hero-stat-label">Dispatch Available</div>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-main-img">
                    <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?w=700&q=85&auto=format&fit=crop" alt="Gym" />
                    <div class="hero-main-img-overlay"></div>
                    <div class="hero-discount-badge" style="background:#ff4444;">BEST SELLERS</div>
                    <div class="hero-main-img-label">
                        <span>Fitness Equipment</span>
                        <span class="hero-main-img-price" style="background:#ff4444;">From $24.99</span>
                    </div>
                </div>
                <div class="hero-thumbs">
                    <a href="{{ route('products.index') }}" class="hero-thumb">
                        <img src="https://images.unsplash.com/photo-1539794830467-1f1755804d13?w=300&q=80&auto=format&fit=crop" alt="Running" />
                        <div class="hero-thumb-overlay"></div>
                        <div class="hero-thumb-label">Running</div>
                    </a>
                    <a href="{{ route('products.index') }}" class="hero-thumb">
                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=300&q=80&auto=format&fit=crop" alt="Gym Wear" />
                        <div class="hero-thumb-overlay"></div>
                        <div class="hero-thumb-label">Gym Wear</div>
                    </a>
                    <a href="{{ route('products.index') }}" class="hero-thumb">
                        <img src="https://images.unsplash.com/photo-1576678927484-cc907957088c?w=300&q=80&auto=format&fit=crop" alt="Yoga" />
                        <div class="hero-thumb-overlay"></div>
                        <div class="hero-thumb-label">Yoga</div>
                    </a>
                    <a href="{{ route('products.index') }}" class="hero-thumb">
                        <img src="https://images.unsplash.com/photo-1490646268468-4b5248f9f47c?w=300&q=80&auto=format&fit=crop" alt="Cycling" />
                        <div class="hero-thumb-overlay"></div>
                        <div class="hero-thumb-label">Cycling</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Left / Right arrows --}}
    <button class="hero-arrow hero-arrow-left" onclick="heroGo(-1)" aria-label="Previous">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
    </button>
    <button class="hero-arrow hero-arrow-right" onclick="heroGo(1)" aria-label="Next">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
    </button>

    {{-- Dot nav --}}
    <div class="hero-nav">
        <button class="hero-dot active" onclick="heroGoTo(0)"></button>
        <button class="hero-dot" onclick="heroGoTo(1)"></button>
        <button class="hero-dot" onclick="heroGoTo(2)"></button>
        <button class="hero-dot" onclick="heroGoTo(3)"></button>
        <button class="hero-dot" onclick="heroGoTo(4)"></button>
    </div>
</div>

@section('scripts')
<script>
(function(){
    const slides = document.querySelectorAll('.hero-slide');
    const dots   = document.querySelectorAll('.hero-dot');
    let current  = 0, timer;

    function goTo(n) {
        slides[current].classList.remove('active');
        dots[current].classList.remove('active');
        current = (n + slides.length) % slides.length;
        slides[current].classList.add('active');
        dots[current].classList.add('active');
        resetTimer();
    }

    function resetTimer() {
        clearInterval(timer);
        timer = setInterval(() => goTo(current + 1), 5000);
    }

    window.heroGo   = (dir) => goTo(current + dir);
    window.heroGoTo = (n)   => goTo(n);

    resetTimer();
})();
</script>
@endsection

{{-- Trust bar --}}
<div class="trust-bar">
    <div class="trust-bar-inner">
        <div class="trust-item">
            <div class="trust-item-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
            </div>
            <div class="trust-item-text"><strong>Free Shipping</strong><span>On orders over $50</span></div>
        </div>
        <div class="trust-item">
            <div class="trust-item-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
            </div>
            <div class="trust-item-text"><strong>Easy Returns</strong><span>30-day return policy</span></div>
        </div>
        <div class="trust-item">
            <div class="trust-item-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div class="trust-item-text"><strong>Secure Payment</strong><span>256-bit SSL encryption</span></div>
        </div>
        <div class="trust-item">
            <div class="trust-item-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.61 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.69a16 16 0 0 0 6.29 6.29l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            </div>
            <div class="trust-item-text"><strong>24/7 Support</strong><span>Always here to help</span></div>
        </div>
    </div>
</div>

{{-- Categories --}}
@if($categories->isNotEmpty())
<div class="section">
    <div class="section-header">
        <h2 class="section-title">Shop by Category</h2>
        <a href="{{ route('products.index') }}" class="section-link">See all categories &rsaquo;</a>
    </div>
    <div class="cat-grid">
        @php
        $catSvgs = [
            'Electronics' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>',
            'Clothing'    => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/></svg>',
            'Footwear'    => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 18v-5l7-7 4 4 4-4 3 3v9H2z"/><line x1="2" y1="18" x2="22" y2="18"/></svg>',
            'Accessories' => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>',
            'Home & Garden'=> '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>',
            'Sports'      => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v8M8 12h8"/></svg>',
            'Toys'        => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3z"/></svg>',
            'Beauty'      => '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"/></svg>',
        ];
        $defaultSvg = '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>';
        @endphp
        @foreach($categories as $cat)
            <a href="{{ route('products.index', ['category' => $cat->id]) }}" class="cat-card">
                <div class="cat-icon">{!! $catSvgs[$cat->name] ?? $defaultSvg !!}</div>
                <div class="name">{{ $cat->name }}</div>
            </a>
        @endforeach
    </div>
</div>
@endif

{{-- Featured Products --}}
@if($featured->isNotEmpty())
<div class="deal-wrap">
    <div style="max-width:1240px;margin:0 auto;padding:0 16px;">
        <div class="deal-banner">
            <div class="deal-banner-left">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                <div>
                    <h2>Featured Deals</h2>
                    <p>Hand-picked products just for you</p>
                </div>
            </div>
            <a href="{{ route('products.index') }}" class="deal-banner-btn">See all deals &rsaquo;</a>
        </div>
        <div class="product-grid">
            @foreach($featured as $product)
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
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#d5d9d9" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="product-card-body">
                        @if($product->brand)
                            <div class="product-card-brand">{{ $product->brand->name }}</div>
                        @endif
                        <div class="product-card-name">{{ $product->name }}</div>
                        <div class="product-card-stars">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <span style="color:#555;font-size:11px;margin-left:2px;">(14)</span>
                        </div>
                        <div class="product-card-price">${{ number_format($product->price, 2) }}</div>
                        @if($product->stock > 0)
                            <div class="product-card-stock">In Stock</div>
                        @else
                            <div class="product-card-stock out">Out of Stock</div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Latest Products --}}
@if($latest->isNotEmpty())
<div class="section">
    <div class="section-header">
        <h2 class="section-title">New Arrivals</h2>
        <a href="{{ route('products.index') }}" class="section-link">See all &rsaquo;</a>
    </div>
    <div class="product-grid">
        @foreach($latest as $product)
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
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#d5d9d9" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><line x1="12" y1="12" x2="12" y2="16"/><line x1="10" y1="14" x2="14" y2="14"/></svg>
                        </div>
                    @endif
                </div>
                <div class="product-card-body">
                    @if($product->brand)
                        <div class="product-card-brand">{{ $product->brand->name }}</div>
                    @endif
                    <div class="product-card-name">{{ $product->name }}</div>
                    <div class="product-card-stars">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="#FF9900" stroke="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <div class="product-card-price">${{ number_format($product->price, 2) }}</div>
                    @if($product->stock > 0)
                        <div class="product-card-stock">In Stock</div>
                    @else
                        <div class="product-card-stock out">Out of Stock</div>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
</div>
@endif

{{-- Brands --}}
@if($brands->isNotEmpty())
<div class="section" style="border-top:1px solid #e7e7e7; background:#fff; max-width:100%; padding:24px 0;">
    <div style="max-width:1240px;margin:0 auto;padding:0 16px;">
        <div class="section-header">
            <h2 class="section-title">Top Brands</h2>
        </div>
        <div class="brand-grid">
            @foreach($brands as $brand)
                <a href="{{ route('products.index', ['brand' => $brand->id]) }}" class="brand-chip">{{ $brand->name }}</a>
            @endforeach
        </div>
    </div>
</div>
@endif

@endsection
