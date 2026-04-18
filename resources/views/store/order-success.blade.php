@extends('store.layout')
@section('title', 'Order Confirmed - Thank You!')

@section('head')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .success-wrapper {
        min-height: 100vh;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 60px 20px;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    .success-card {
        max-width: 800px;
        margin: 0 auto;
        background: #ffffff;
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Header Section */
    .success-header {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        padding: 48px 40px;
        text-align: center;
        color: white;
    }

    .success-icon-wrapper {
        width: 90px;
        height: 90px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        backdrop-filter: blur(10px);
        animation: scaleIn 0.5s ease-out 0.3s both;
    }

    @keyframes scaleIn {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
        }
    }

    .success-icon {
        width: 45px;
        height: 45px;
        stroke: white;
        stroke-width: 3;
        fill: none;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .success-title {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .success-subtitle {
        font-size: 16px;
        opacity: 0.9;
        font-weight: 500;
    }

    /* Order Number Badge */
    .order-badge {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        margin: -30px 40px 0;
        padding: 24px 32px;
        border-radius: 16px;
        text-align: center;
        box-shadow: 0 10px 25px -5px rgba(251, 191, 36, 0.3);
        position: relative;
        z-index: 10;
    }

    .order-badge-label {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #92400e;
        margin-bottom: 6px;
    }

    .order-badge-value {
        font-size: 24px;
        font-weight: 800;
        color: #78350f;
        font-family: 'SF Mono', monospace;
    }

    /* Content Sections */
    .content-sections {
        padding: 40px;
        display: grid;
        gap: 24px;
    }

    .info-section {
        background: #f8fafc;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #e2e8f0;
    }

    .section-title {
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-icon {
        width: 20px;
        height: 20px;
        color: #64748b;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .info-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
    }

    .info-value {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }

    .status-paid {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #dcfce7;
        color: #166534;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        background: #22c55e;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Address Section */
    .address-box {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border-radius: 12px;
        padding: 20px;
        margin-top: 12px;
    }

    .address-text {
        font-size: 14px;
        line-height: 1.8;
        color: #1e40af;
    }

    .address-name {
        font-weight: 700;
        color: #1e3a8a;
    }

    /* Delivery Estimate */
    .delivery-box {
        background: linear-gradient(135deg, #f0fdf4 0%, #bbf7d0 100%);
        border-radius: 12px;
        padding: 20px;
        margin-top: 16px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .delivery-icon {
        width: 48px;
        height: 48px;
        background: #22c55e;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .delivery-icon svg {
        width: 24px;
        height: 24px;
        stroke: white;
        stroke-width: 2;
    }

    .delivery-content h4 {
        font-size: 14px;
        font-weight: 700;
        color: #166534;
        margin-bottom: 4px;
    }

    .delivery-content p {
        font-size: 13px;
        color: #15803d;
    }

    /* Items Table */
    .items-list {
        margin-top: 16px;
    }

    .item-card {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: white;
        border-radius: 12px;
        margin-bottom: 12px;
        border: 1px solid #e2e8f0;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .item-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .item-image {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .item-image svg {
        width: 28px;
        height: 28px;
        color: #94a3b8;
    }

    .item-details {
        flex: 1;
    }

    .item-name {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .item-meta {
        font-size: 12px;
        color: #64748b;
    }

    .item-price {
        font-size: 16px;
        font-weight: 700;
        color: #059669;
    }

    /* Total Section */
    .total-section {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        border-radius: 16px;
        padding: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 8px;
    }

    .total-label {
        font-size: 14px;
        color: #94a3b8;
        font-weight: 500;
    }

    .total-value {
        font-size: 28px;
        font-weight: 800;
        color: white;
    }

    /* Action Buttons */
    .action-bar {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 16px;
        padding: 0 40px 40px;
    }

    .btn-continue {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 18px 32px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: transform 0.2s, box-shadow 0.2s;
        border: none;
        cursor: pointer;
    }

    .btn-continue:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4);
        color: white;
    }

    .btn-orders {
        background: #f1f5f9;
        color: #475569;
        padding: 18px 32px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        border: 2px solid #e2e8f0;
    }

    .btn-orders:hover {
        background: #e2e8f0;
        color: #334155;
    }

    /* Responsive */
    @media (max-width: 640px) {
        .success-wrapper {
            padding: 20px 16px;
        }

        .success-header {
            padding: 32px 24px;
        }

        .success-title {
            font-size: 24px;
        }

        .order-badge {
            margin: -20px 20px 0;
            padding: 20px;
        }

        .content-sections {
            padding: 24px;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .action-bar {
            grid-template-columns: 1fr;
            padding: 0 24px 24px;
        }

        .total-section {
            flex-direction: column;
            gap: 8px;
            text-align: center;
        }
    }
</style>
@endsection

@section('content')
<div class="success-wrapper">
    <div class="success-card">
        <!-- Header -->
        <div class="success-header">
            <div class="success-icon-wrapper">
                <svg class="success-icon" viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <h1 class="success-title">Order Confirmed!</h1>
            <p class="success-subtitle">Thank you for your purchase. We've sent a confirmation email.</p>
        </div>

        <!-- Order Number Badge -->
        <div class="order-badge">
            <div class="order-badge-label">Order Number</div>
            <div class="order-badge-value">#{{ $order->order_number }}</div>
        </div>

        <!-- Content Sections -->
        <div class="content-sections">
            <!-- Order Details -->
            <div class="info-section">
                <div class="section-title">
                    <svg class="section-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                    Order Details
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Order Date</span>
                        <span class="info-value">{{ $order->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $order->email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Payment</span>
                        <span class="info-value">Credit Card</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status</span>
                        <span class="status-paid">
                            <span class="status-dot"></span>
                            Paid
                        </span>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="info-section">
                <div class="section-title">
                    <svg class="section-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                        <circle cx="12" cy="10" r="3"/>
                    </svg>
                    Shipping Address
                </div>
                <div class="address-box">
                    <p class="address-text">
                        <span class="address-name">{{ $order->first_name }} {{ $order->last_name }}</span><br>
                        {{ $order->address }}<br>
                        {{ $order->city }}, {{ $order->postal_code }}<br>
                        <span style="color: #3b82f6; font-weight: 500;">📞 {{ $order->phone }}</span>
                    </p>
                </div>

                <!-- Delivery Estimate -->
                <div class="delivery-box">
                    <div class="delivery-icon">
                        <svg viewBox="0 0 24 24" fill="none">
                            <rect x="1" y="3" width="15" height="13"/>
                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/>
                            <circle cx="5.5" cy="18.5" r="2.5"/>
                            <circle cx="18.5" cy="18.5" r="2.5"/>
                        </svg>
                    </div>
                    <div class="delivery-content">
                        <h4>Estimated Delivery</h4>
                        <p>{{ now()->addDays(3)->format('l, F j') }} - {{ now()->addDays(5)->format('l, F j') }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="info-section">
                <div class="section-title">
                    <svg class="section-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <path d="M16 10a4 4 0 0 1-8 0"/>
                    </svg>
                    Order Items ({{ $order->items->count() }})
                </div>
                <div class="items-list">
                    @foreach($order->items as $item)
                    <div class="item-card">
                        <div class="item-image">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <path d="M21 15l-5-5L5 21"/>
                            </svg>
                        </div>
                        <div class="item-details">
                            <div class="item-name">{{ $item->name }}</div>
                            <div class="item-meta">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</div>
                        </div>
                        <div class="item-price">${{ number_format($item->price * $item->quantity, 2) }}</div>
                    </div>
                    @endforeach
                </div>

                <!-- Total -->
                <div class="total-section">
                    <span class="total-label">Order Total</span>
                    <span class="total-value">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-bar">
            <a href="{{ route('products.index') }}" class="btn-continue">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
                Continue Shopping
            </a>
            <a href="{{ route('orders.index') }}" class="btn-orders">
                View Orders
            </a>
        </div>
    </div>
</div>
@endsection
