<!DOCTYPE html>
<html>
<head>
    <title>Order Status Update #{{ $order->id }}</title>
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

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            color: white;
            margin: 0.5rem 0;
        }

        .status-pending {
            background-color: #FFC107;
        }

        .status-shipping {
            background-color: #2196F3;
        }

        .status-completed {
            background-color: #4CAF50;
        }

        .status-cancelled {
            background-color: #F44336;
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

        .admin-note {
            background-color: #f3f0ff;
            border-left: 4px solid #9370db;
            padding: 1rem;
            margin: 1.5rem 0;
            border-radius: 0 4px 4px 0;
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
            <div class="email-title">Order Status Update #{{ $order->id }}</div>
        </div>

        <div class="email-content">
            <p>Hi {{ $order->user->name }},</p>
            <p>Your order status has been updated:</p>

            <div class="status-badge status-{{ $order->status }}">
                {{ ucfirst($order->status) }}
            </div>

            @if(isset($adminNote) && $adminNote)
                <div class="admin-note">
                    <strong>Admin Note:</strong>
                    <p>{{ $adminNote }}</p>
                </div>
            @endif

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

            @if($order->status == 'shipping')
                <p>Your order is on its way! We'll notify you when it's out for delivery.</p>
            @elseif($order->status == 'completed')
                <p>We hope you're enjoying your Soap Haven products! Please consider leaving a review.</p>
            @elseif($order->status == 'cancelled')
                <p>If you didn't request this cancellation or have any questions, please contact our support team.</p>
            @endif

            <div style="text-align: center;">
                <a href="{{ route('orders.show', $order) }}" class="cta-button">
                    @if($order->status == 'completed')
                        Leave a Review
                    @else
                        View Order Details
                    @endif
                </a>
            </div>
        </div>

        <div class="email-footer">
            &copy; {{ date('Y') }} Soap Haven. All rights reserved.
        </div>
    </div>
</body>
</html>
