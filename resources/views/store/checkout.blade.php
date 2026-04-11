@extends('store.layout')
@section('title', 'Checkout')

@section('head')
<style>
    .checkout-page { background: #EAEDED; min-height: 80vh; padding: 20px 0 60px; }
    .checkout-container { max-width: 1000px; margin: 0 auto; padding: 0 20px; }
    .checkout-header { font-size: 28px; font-weight: 700; margin-bottom: 24px; color: #0F1111; }
    
    .checkout-form { background: #fff; border-radius: 8px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,.1); }
    .checkout-form h3 { font-size: 18px; font-weight: 700; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid #e3e6e6; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
    .form-group { margin-bottom: 16px; }
    .form-group.full { grid-column: 1 / -1; }
    .form-group label { display: block; font-size: 13px; font-weight: 600; color: #0F1111; margin-bottom: 6px; }
    .form-group input { width: 100%; padding: 12px; border: 1px solid #d5d9d9; border-radius: 6px; font-size: 14px; }
    .form-group input:focus { border-color: #FF9900; outline: none; box-shadow: 0 0 0 3px rgba(255,153,0,.15); }
    .form-group input::placeholder { color: #888; }
    
    .checkout-summary { background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,.1); }
    .checkout-summary h3 { font-size: 18px; font-weight: 700; margin-bottom: 16px; }
    .summary-item { display: flex; justify-content: space-between; padding: 8px 0; font-size: 14px; color: #555; border-bottom: 1px solid #f0f2f2; }
    .summary-item:last-child { border-bottom: none; }
    .summary-total { display: flex; justify-content: space-between; padding-top: 16px; margin-top: 8px; border-top: 2px solid #e3e6e6; font-size: 18px; font-weight: 700; }
    
    .checkout-btn { display: block; width: 100%; background: #FFD814; border: 1px solid #FCD200; border-radius: 8px; padding: 14px; font-size: 15px; font-weight: 700; color: #131921; text-align: center; cursor: pointer; margin-top: 20px; }
    .checkout-btn:hover { background: #F7CA00; }
    
    .cart-mini { margin-top: 20px; }
    .cart-mini h4 { font-size: 14px; font-weight: 700; margin-bottom: 12px; }
    .mini-item { display: flex; gap: 10px; padding: 10px 0; border-bottom: 1px solid #f0f2f2; font-size: 13px; }
    .mini-item:last-child { border-bottom: none; }
    .mini-qty { color: #888; }
    .mini-price { margin-left: auto; font-weight: 600; }
    
    .secure-badge { display: flex; align-items: center; gap: 8px; font-size: 12px; color: #555; margin-top: 16px; }
    
    .error-msg { color: #CC0C39; font-size: 12px; margin-top: 4px; }
</style>
@endsection

@section('content')
<div class="checkout-page">
    <div class="checkout-container">
        <h1 class="checkout-header">Checkout</h1>
        
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            
            <div class="checkout-form">
                <h3>Shipping Address</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" placeholder="your@email.com" required>
                        @error('email')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="John" required>
                        @error('first_name')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Doe" required>
                        @error('last_name')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group full">
                        <label>Street Address</label>
                        <input type="text" name="address" value="{{ old('address') }}" placeholder="123 Main Street, Apt 4B" required>
                        @error('address')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="city" value="{{ old('city') }}" placeholder="New York" required>
                        @error('city')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Postal Code</label>
                        <input type="text" name="postal_code" value="{{ old('postal_code') }}" placeholder="10001" required>
                        @error('postal_code')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+1 (555) 123-4567" required>
                        @error('phone')<div class="error-msg">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            
            <div class="checkout-summary">
                <h3>Order Summary</h3>
                
                <div class="cart-mini">
                    @foreach($cart as $item)
                    <div class="mini-item">
                        <span class="mini-qty">{{ $item['quantity'] }}x</span>
                        <span>{{ Str::limit($item['name'], 40) }}</span>
                        <span class="mini-price">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                    @endforeach
                </div>
                
                <div class="summary-item">
                    <span>Subtotal</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
                <div class="summary-item">
                    <span>Shipping</span>
                    <span style="color:#007600;">FREE</span>
                </div>
                <div class="summary-item">
                    <span>Tax</span>
                    <span>Calculated at payment</span>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
                
                <button type="submit" class="checkout-btn">Continue to Payment</button>
                
                <div class="secure-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#007600" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    Secure checkout. Your information is protected.
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
