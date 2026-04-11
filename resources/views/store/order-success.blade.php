@extends('store.layout')
@section('title', 'Order Confirmed')

@section('head')
<style>
    .success-page { background: #EAEDED; min-height: 80vh; padding: 40px 0 60px; }
    .success-container { max-width: 700px; margin: 0 auto; padding: 0 20px; }
    
    .success-header { text-align: center; margin-bottom: 32px; }
    .success-icon { width: 80px; height: 80px; background: linear-gradient(135deg, #007600, #00a000); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
    .success-icon svg { width: 40px; height: 40px; stroke: #fff; }
    .success-title { font-size: 28px; font-weight: 700; color: #0F1111; margin-bottom: 8px; }
    .success-subtitle { font-size: 16px; color: #555; }
    
    .success-box { background: #fff; border-radius: 8px; padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,.1); }
    .success-box h3 { font-size: 18px; font-weight: 700; margin-bottom: 16px; }
    
    .order-number { background: #fff8ee; border: 2px solid #FF9900; border-radius: 8px; padding: 16px; text-align: center; margin-bottom: 24px; }
    .order-number-label { font-size: 13px; color: #555; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px; }
    .order-number-value { font-size: 20px; font-weight: 700; color: #0F1111; }
    
    .info-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f0f2f2; font-size: 14px; }
    .info-row:last-child { border-bottom: none; }
    .info-label { color: #555; }
    .info-value { font-weight: 600; color: #0F1111; }
    
    .item-list { margin-top: 16px; }
    .item-row { display: flex; gap: 12px; padding: 12px 0; border-bottom: 1px solid #f0f2f2; }
    .item-row:last-child { border-bottom: none; }
    .item-qty { color: #888; font-size: 13px; min-width: 30px; }
    .item-name { flex: 1; font-size: 14px; }
    .item-price { font-weight: 600; font-size: 14px; }
    
    .total-row { display: flex; justify-content: space-between; padding-top: 16px; margin-top: 8px; border-top: 2px solid #e3e6e6; font-size: 18px; font-weight: 700; }
    
    .success-actions { display: flex; gap: 12px; margin-top: 24px; }
    .btn-primary { flex: 1; background: #FFD814; border: 1px solid #FCD200; border-radius: 8px; padding: 14px; font-size: 14px; font-weight: 700; color: #131921; text-align: center; text-decoration: none; }
    .btn-primary:hover { background: #F7CA00; }
    .btn-secondary { flex: 1; background: #fff; border: 1px solid #d5d9d9; border-radius: 8px; padding: 14px; font-size: 14px; font-weight: 700; color: #0F1111; text-align: center; text-decoration: none; }
    .btn-secondary:hover { background: #f7f8f8; }
    
    .delivery-est { background: #f0fff4; border-left: 4px solid #007600; padding: 16px; border-radius: 4px; margin-top: 16px; }
    .delivery-est-title { font-weight: 700; color: #007600; margin-bottom: 4px; }
    .delivery-est-text { font-size: 14px; color: #555; }
</style>
@endsection

@section('content')
<div class="success-page">
    <div class="success-container">
        <div class="success-header">
            <div class="success-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <h1 class="success-title">Order Confirmed!</h1>
            <p class="success-subtitle">Thank you for your purchase. We've received your order.</p>
        </div>
        
        <div class="order-number">
            <div class="order-number-label">Order Number</div>
            <div class="order-number-value">{{ $order->order_number }}</div>
        </div>
        
        <div class="success-box">
            <h3>Order Details</h3>
            <div class="info-row">
                <span class="info-label">Order Date</span>
                <span class="info-value">{{ $order->created_at->format('F j, Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $order->email }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Payment Method</span>
                <span class="info-value">Credit Card (Stripe)</span>
            </div>
            <div class="info-row">
                <span class="info-label">Payment Status</span>
                <span class="info-value" style="color: #007600;">Paid</span>
            </div>
        </div>
        
        <div class="success-box">
            <h3>Shipping Address</h3>
            <div style="font-size: 14px; line-height: 1.6;">
                <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                {{ $order->address }}<br>
                {{ $order->city }}, {{ $order->postal_code }}<br>
                Phone: {{ $order->phone }}
            </div>
            
            <div class="delivery-est">
                <div class="delivery-est-title">Estimated Delivery</div>
                <div class="delivery-est-text">{{ now()->addDays(3)->format('l, F j') }} - {{ now()->addDays(5)->format('l, F j') }}</div>
            </div>
        </div>
        
        <div class="success-box">
            <h3>Items Ordered</h3>
            <div class="item-list">
                @foreach($order->items as $item)
                <div class="item-row">
                    <span class="item-qty">{{ $item->quantity }}x</span>
                    <span class="item-name">{{ $item->name }}</span>
                    <span class="item-price">${{ number_format($item->price * $item->quantity, 2) }}</span>
                </div>
                @endforeach
            </div>
            <div class="total-row">
                <span>Total</span>
                <span>${{ number_format($order->total, 2) }}</span>
            </div>
        </div>
        
        <div class="success-actions">
            <a href="{{ route('products.index') }}" class="btn-primary">Continue Shopping</a>
            <a href="{{ route('orders.index') }}" class="btn-secondary">View Orders</a>
        </div>
    </div>
</div>
@endsection
