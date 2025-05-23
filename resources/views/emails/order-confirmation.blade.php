<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f5ff;
            margin: 0;
            padding: 0;
            color: #343a40;
        }

        .email-container {
            max-width: 700px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(147, 112, 219, 0.1);
        }

        .email-header {
            background: linear-gradient(135deg, #9370db, #d8bfd8);
            padding: 2rem;
            text-align: center;
            color: white;
        }

        .email-logo {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .email-title {
            font-size: 1.6rem;
            font-weight: 600;
            margin: 0.5rem 0 0;
        }

        .email-content {
            padding: 2rem;
        }

        .order-summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .order-summary-table th,
        .order-summary-table td {
            border: 1px solid #e6e6fa;
            padding: 10px;
            text-align: left;
        }

        .order-summary-table th {
            background-color: #f3f0ff;
            color: #9370db;
        }

        .total-row td {
            font-weight: bold;
            background-color: #f8f5ff;
        }

        .cta-button {
            display: inline-block;
            background-color: #9370db;
            color: white !important;
            text-decoration: none;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 500;
            margin-top: 2rem;
            text-align: center;
        }

        .email-footer {
            background-color: #f8f5ff;
            padding: 1.5rem;
            text-align: center;
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="email-logo">SOAP HAVEN</div>
            <div class="email-title">Order Confirmation #{{ $order->id }}</div>
        </div>

        <div class="email-content">
            <p>Hi {{ $order->user->name }},</p>
            <p>Thank you for your order! We're preparing your items and will notify you when they ship.</p>

            <h3>Order Summary</h3>
            <table class="order-summary-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="3">Total</td>
                        <td>${{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>


            <div style="text-align: center;">
                <a href="{{ route('orders.show', $order) }}" class="cta-button">View Your Order</a>
            </div>
        </div>

        <div class="email-footer">
            &copy; {{ date('Y') }} Soap Haven. All rights reserved.
        </div>
    </div>
</body>
</html>
