@extends('store.layout')
@section('title', 'Shopping Cart')

@section('head')
<style>
    .cart-page { background: #EAEDED; min-height: 80vh; padding: 20px 0 60px; }
    .cart-container { max-width: 1340px; margin: 0 auto; padding: 0 20px; display: flex; gap: 20px; }
    .cart-main { flex: 1; }
    .cart-sidebar { width: 300px; }

    .cart-box { background: #fff; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,.1); }
    .cart-box h2 { font-size: 24px; font-weight: 700; margin: 0 0 16px; color: #0F1111; }
    .cart-empty { text-align: center; padding: 60px 20px; }
    .cart-empty-icon { font-size: 64px; margin-bottom: 16px; }
    .cart-empty h3 { font-size: 20px; font-weight: 700; margin-bottom: 8px; }
    .cart-empty p { color: #555; margin-bottom: 20px; }
    .cart-btn { display: inline-block; background: #FFD814; border: 1px solid #FCD200; border-radius: 8px; padding: 12px 24px; font-size: 14px; font-weight: 700; color: #131921; text-decoration: none; }
    .cart-btn:hover { background: #F7CA00; }

    .cart-item { display: flex; gap: 16px; padding: 16px 0; border-bottom: 1px solid #e3e6e6; }
    .cart-item:last-child { border-bottom: none; }
    .cart-item-img { width: 100px; height: 100px; background: #f7f8f8; display: flex; align-items: center; justify-content: center; border-radius: 4px; flex-shrink: 0; }
    .cart-item-img img { max-width: 80%; max-height: 80%; object-fit: contain; }
    .cart-item-details { flex: 1; }
    .cart-item-brand { font-size: 12px; color: #FF9900; font-weight: 700; text-transform: uppercase; margin-bottom: 2px; }
    .cart-item-name { font-size: 16px; font-weight: 500; color: #0F1111; margin-bottom: 4px; }
    .cart-item-stock { font-size: 12px; color: #007600; margin-bottom: 6px; }
    .cart-item-price { font-size: 18px; font-weight: 700; color: #B12704; }
    .cart-item-actions { display: flex; gap: 12px; margin-top: 8px; align-items: center; }

    .qty-selector { display: flex; align-items: center; border: 1px solid #d5d9d9; border-radius: 6px; overflow: hidden; }
    .qty-selector button { background: #f7f8f8; border: none; padding: 6px 12px; cursor: pointer; font-size: 14px; color: #555; }
    .qty-selector button:hover { background: #e3e6e6; }
    .qty-selector span { padding: 6px 16px; font-size: 14px; font-weight: 600; min-width: 40px; text-align: center; }

    .cart-item-delete { color: #007185; font-size: 13px; text-decoration: none; cursor: pointer; }
    .cart-item-delete:hover { color: #C7511F; text-decoration: underline; }

    .cart-summary { background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,.1); }
    .cart-summary h3 { font-size: 18px; font-weight: 700; margin: 0 0 16px; }
    .cart-summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: #555; }
    .cart-summary-row.total { font-size: 18px; font-weight: 700; border-top: 1px solid #e3e6e6; padding-top: 12px; margin-top: 12px; color: #0F1111; }
    .cart-checkout-btn { display: block; width: 100%; background: #FFD814; border: 1px solid #FCD200; border-radius: 8px; padding: 12px; font-size: 14px; font-weight: 700; color: #131921; text-align: center; text-decoration: none; margin-top: 16px; cursor: pointer; }
    .cart-checkout-btn:hover { background: #F7CA00; }
    .cart-clear-btn { display: block; width: 100%; background: #fff; border: 1px solid #d5d9d9; border-radius: 8px; padding: 8px; font-size: 12px; color: #555; text-align: center; text-decoration: none; margin-top: 8px; cursor: pointer; }
    .cart-clear-btn:hover { background: #f7f8f8; color: #C7511F; border-color: #C7511F; }

    .cart-message { background: #fff8ee; border: 1px solid #FF9900; border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; display: flex; align-items: center; gap: 10px; }
    .cart-message.success { background: #f0fff4; border-color: #007600; }
    .cart-message.error { background: #fff0f0; border-color: #CC0C39; }
</style>
@endsection

@section('content')
<div class="cart-page">
    <div class="cart-container">
        <div class="cart-main">
            <div class="cart-box">
                <h2>Shopping Cart</h2>

                @if(session('success'))
                <div class="cart-message success">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#007600" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="cart-message error">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#CC0C39" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    {{ session('error') }}
                </div>
                @endif

                @if(count($cart) > 0)
                    @foreach($cart as $id => $item)
                    <div class="cart-item" id="cart-item-{{ $id }}">
                        <div class="cart-item-img">
                            @if(isset($item['image']))
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}">
                            @else
                                <span style="font-size:32px;">📦</span>
                            @endif
                        </div>
                        <div class="cart-item-details">
                            @if(isset($item['brand']))
                            <div class="cart-item-brand">{{ $item['brand'] }}</div>
                            @endif
                            <div class="cart-item-name">{{ $item['name'] ?? 'Product' }}</div>
                            <div class="cart-item-stock">In Stock</div>
                            <div class="cart-item-price">${{ number_format($item['price'] ?? 0, 2) }}</div>
                            <div class="cart-item-actions">
                                <div class="qty-selector">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" style="display:flex;">
                                        @csrf
                                        <button type="submit" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}">−</button>
                                    </form>
                                    <span>{{ $item['quantity'] }}</span>
                                    <form action="{{ route('cart.update', $id) }}" method="POST" style="display:flex;">
                                        @csrf
                                        <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}">+</button>
                                    </form>
                                </div>
                                <form action="{{ route('cart.remove', $id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="cart-item-delete">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="cart-empty">
                        <div class="cart-empty-icon">🛒</div>
                        <h3>Your cart is empty</h3>
                        <p>Looks like you haven't added anything to your cart yet.</p>
                        <a href="{{ route('products.index') }}" class="cart-btn">Continue Shopping</a>
                    </div>
                @endif
            </div>
        </div>

        @if(count($cart) > 0)
        <div class="cart-sidebar">
            <div class="cart-summary">
                <h3>Subtotal ({{ $count }} item{{ $count > 1 ? 's' : '' }})</h3>
                <div class="cart-summary-row">
                    <span>Items ({{ $count }})</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
                <div class="cart-summary-row">
                    <span>Shipping</span>
                    <span style="color:#007600;">FREE</span>
                </div>
                <div class="cart-summary-row total">
                    <span>Total</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
                <a href="{{ route('checkout') }}" class="cart-checkout-btn">Proceed to Checkout</a>
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="cart-clear-btn">Clear Cart</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
