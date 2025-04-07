<!DOCTYPE html>
<html>
<head>
    <title>Order Receipt</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f5ff;
            margin: 0;
            padding: 20px;
            color: #343a40;
        }

        .receipt-container {
            max-width: 700px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(147, 112, 219, 0.1);
        }

        .receipt-header {
            background: linear-gradient(135deg, #9370db, #d8bfd8);
            padding: 2rem;
            text-align: center;
            color: white;
        }

        .receipt-logo {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #9370db;
        }

        .receipt-title {
            font-size: 1.6rem;
            font-weight: 600;
            margin: 0.5rem 0 0;
            color: #9370db;

        }

        .receipt-date {
            font-size: 1rem;
            opacity: 0.9;
            margin-top: 0.5rem;
            color: #9370db;
        }


        .receipt-content {
            padding: 2rem;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
        }

        .order-table th,
        .order-table td {
            border: 1px solid #e6e6fa;
            padding: 12px 15px;
            text-align: left;
        }

        .order-table th {
            background-color: #f3f0ff;
            color: #9370db;
            font-weight: 600;
        }

        .order-table tr:nth-child(even) {
            background-color: #fbfaff;
        }

        .total-row td {
            font-weight: bold;
            background-color: #f8f5ff;
            font-size: 1.1rem;
        }

        .thank-you {
            text-align: center;
            margin-top: 2rem;
            font-size: 1.1rem;
            color: #9370db;
            font-weight: 500;
        }

        .receipt-footer {
            background-color: #f8f5ff;
            padding: 1.5rem;
            text-align: center;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .highlight {
            color: #9370db;
            font-weight: 600;
        }
    </style>
</head>


<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <div class="receipt-logo">Soap Haven</div>
            <h2 class="receipt-title">Order Receipt #{{ $order->id }}</h2>
            <p class="receipt-date">{{ $order->created_at->format('F j, Y') }}</p>
        </div>

        <div class="receipt-content">
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="3">Total</td>
                        <td>${{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            <p class="thank-you">Thank you for your purchase! We appreciate your business.</p>
        </div>

        <div class="receipt-footer">
            <p>Soap Haven &copy; {{ date('Y') }} | All rights reserved</p>

        </div>
    </div>
</body>
</html>
