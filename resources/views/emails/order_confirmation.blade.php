<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation - TryMyWatch</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f7f7f7; padding: 20px; }
        .email-container {
            max-width: 600px; background: white; padding: 20px;
            border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center; padding-bottom: 20px; border-bottom: 1px solid #ddd;
        }
        .header h2 { color: #333; }
        .content { padding: 20px 0; }
        .footer { text-align: center; margin-top: 20px; color: #777; }
        .order-box {
            border: 1px solid #ddd; padding: 15px; border-radius: 6px;
            background: #fafafa; margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="email-container">
    <div class="header">
        <h2>🛍️ Thank You for Your Order!</h2>
        <p><strong>TryMyWatch</strong></p>
    </div>

    <div class="content">
        <p>Hello <strong>{{ $order->name }}</strong>,</p>

        <p>We’ve received your order and it is now being processed. Here are your order details:</p>

        <div class="order-box">
            <p><strong>Order ID:</strong> #{{ $order->id }}</p>
            <p><strong>Total Amount:</strong> ${{ number_format($order->total_price, 2) }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
            <p><strong>Shipping Address:</strong><br>{{ $order->address }}</p>
        </div>

        <p>We will notify you when your items have been shipped.</p>

        <p>Thank you for choosing <strong>TryMyWatch</strong>! ⌚</p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} TryMyWatch. All rights reserved.</p>
    </div>
</div>

</body>
</html>
