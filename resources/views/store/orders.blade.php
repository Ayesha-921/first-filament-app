@extends('store.layout')
@section('title', 'My Orders')

@section('head')
<style>
    .orders-page { background: #EAEDED; min-height: 80vh; padding: 20px 0 60px; }
    .orders-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
    .orders-header { font-size: 28px; font-weight: 700; margin-bottom: 24px; color: #0F1111; }
    
    .order-card { background: #fff; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,.1); overflow: hidden; }
    .order-header { background: #f7f8f8; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; border-bottom: 1px solid #e3e6e6; }
    .order-meta { display: flex; gap: 24px; flex-wrap: wrap; }
    .order-meta-item { font-size: 13px; }
    .order-meta-label { color: #555; margin-bottom: 2px; }
    .order-meta-value { font-weight: 600; color: #0F1111; }
    .order-status { padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; }
    .status-processing { background: #fff8ee; color: #FF9900; }
    .status-shipped { background: #f0f7ff; color: #007185; }
    .status-delivered { background: #f0fff4; color: #007600; }
    .status-cancelled { background: #fff0f0; color: #CC0C39; }
    
    .order-body { padding: 20px; }
    .order-item { display: flex; gap: 16px; padding: 16px 0; border-bottom: 1px solid #f0f2f2; }
    .order-item:last-child { border-bottom: none; }
    .order-item-img { width: 80px; height: 80px; background: #f7f8f8; display: flex; align-items: center; justify-content: center; border-radius: 4px; flex-shrink: 0; }
    .order-item-img img { max-width: 70%; max-height: 70%; object-fit: contain; }
    .order-item-details { flex: 1; }
    .order-item-name { font-size: 14px; font-weight: 500; color: #0F1111; margin-bottom: 4px; }
    .order-item-brand { font-size: 12px; color: #FF9900; font-weight: 600; text-transform: uppercase; margin-bottom: 4px; }
    .order-item-price { font-size: 14px; font-weight: 700; color: #B12704; }
    .order-item-qty { font-size: 13px; color: #555; margin-top: 4px; }
    
    .order-footer { background: #f7f8f8; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; }
    .order-total { font-size: 16px; }
    .order-total-label { color: #555; margin-right: 8px; }
    .order-total-value { font-weight: 700; color: #0F1111; }
    .order-actions { display: flex; gap: 10px; }
    .order-btn { padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 600; text-decoration: none; cursor: pointer; }
    .btn-track { background: #FFD814; border: 1px solid #FCD200; color: #131921; }
    .btn-track:hover { background: #F7CA00; }
    .btn-invoice { background: #fff; border: 1px solid #d5d9d9; color: #555; }
    .btn-invoice:hover { background: #f7f8f8; border-color: #FF9900; color: #C7511F; }
    
    .empty-orders { text-align: center; padding: 80px 20px; background: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,.1); }
    .empty-icon { font-size: 64px; margin-bottom: 16px; }
    .empty-title { font-size: 20px; font-weight: 700; margin-bottom: 8px; }
    .empty-text { color: #555; margin-bottom: 20px; }
    .empty-btn { display: inline-block; background: #FFD814; border: 1px solid #FCD200; border-radius: 8px; padding: 12px 24px; font-size: 14px; font-weight: 700; color: #131921; text-decoration: none; }
    .empty-btn:hover { background: #F7CA00; }
    
    .pagination { margin-top: 24px; }
    .pagination nav { display: flex; justify-content: center; }
    .pagination svg { width: 20px; height: 20px; }
</style>
@endsection

@section('content')
<div class="orders-page">
    <div class="orders-container">
        <h1 class="orders-header">My Orders</h1>
        
        @if($orders->isNotEmpty())
            @foreach($orders as $order)
            <div class="order-card">
                <div class="order-header">
                    <div class="order-meta">
                        <div class="order-meta-item">
                            <div class="order-meta-label">Order Number</div>
                            <div class="order-meta-value">{{ $order->order_number }}</div>
                        </div>
                        <div class="order-meta-item">
                            <div class="order-meta-label">Order Date</div>
                            <div class="order-meta-value">{{ $order->created_at->format('M d, Y') }}</div>
                        </div>
                        <div class="order-meta-item">
                            <div class="order-meta-label">Total</div>
                            <div class="order-meta-value">${{ number_format($order->total, 2) }}</div>
                        </div>
                    </div>
                    <span class="order-status status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                </div>
                
                <div class="order-body">
                    @foreach($order->items as $item)
                    <div class="order-item">
                        <div class="order-item-img">
                            @if(isset($item->product) && $item->product->image)
                                <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->name }}">
                            @else
                                <span style="font-size:24px;">📦</span>
                            @endif
                        </div>
                        <div class="order-item-details">
                            @if(isset($item->product) && $item->product->brand)
                            <div class="order-item-brand">{{ $item->product->brand->name }}</div>
                            @endif
                            <div class="order-item-name">{{ $item->name }}</div>
                            <div class="order-item-price">${{ number_format($item->price, 2) }}</div>
                            <div class="order-item-qty">Qty: {{ $item->quantity }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="order-footer">
                    <div class="order-total">
                        <span class="order-total-label">Order Total:</span>
                        <span class="order-total-value">${{ number_format($order->total, 2) }}</span>
                    </div>
                    <div class="order-actions">
                        <a href="#" class="order-btn btn-track">Track Package</a>
                        <a href="#" class="order-btn btn-invoice">View Invoice</a>
                    </div>
                </div>
            </div>
            @endforeach
            
            <div class="pagination">
                {{ $orders->links() }}
            </div>
        @else
            <div class="empty-orders">
                <div class="empty-icon">📦</div>
                <h3 class="empty-title">No orders yet</h3>
                <p class="empty-text">You haven't placed any orders. Start shopping to see your orders here.</p>
                <a href="{{ route('products.index') }}" class="empty-btn">Start Shopping</a>
            </div>
        @endif
    </div>
</div>
@endsection
