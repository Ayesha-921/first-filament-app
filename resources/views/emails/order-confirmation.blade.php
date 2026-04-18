<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4a5568; color: white; padding: 20px; text-align: center; }
        .content { background: #f7fafc; padding: 20px; border: 1px solid #e2e8f0; }
        .order-info { margin: 20px 0; }
        .order-info table { width: 100%; border-collapse: collapse; }
        .order-info td { padding: 10px; border-bottom: 1px solid #e2e8f0; }
        .order-info td:first-child { font-weight: bold; width: 40%; }
        .footer { text-align: center; margin-top: 20px; color: #718096; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Confirmation</h1>
            <p>Order #{{ $order->order_number }}</p>
        </div>

        <div class="content">
            <p>Hello {{ $order->first_name }} {{ $order->last_name }},</p>

            <p>Thank you for your order! We've received your order and will process it shortly.</p>

            <div class="order-info">
                <h3>Order Details</h3>
                <table>
                    <tr>
                        <td>Order Number:</td>
                        <td>{{ $order->order_number }}</td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td>{{ $order->email }}</td>
                    </tr>
                    <tr>
                        <td>Total:</td>
                        <td>${{ number_format($order->total, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Status:</td>
                        <td>{{ ucfirst($order->status) }}</td>
                    </tr>
                    <tr>
                        <td>Payment Status:</td>
                        <td>{{ ucfirst($order->payment_status) }}</td>
                    </tr>
                </table>
            </div>

            <p>We'll notify you once your order has been shipped.</p>

            <p>Thank you for shopping with us!</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
