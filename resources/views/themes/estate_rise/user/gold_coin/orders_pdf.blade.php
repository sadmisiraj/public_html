<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $pageTitle }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 14px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 5px 0;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .user-info {
            margin-bottom: 20px;
        }
        .user-info p {
            margin: 5px 0;
        }
        .status-pending {
            color: #ff9800;
        }
        .status-processing {
            color: #2196F3;
        }
        .status-completed {
            color: #4CAF50;
        }
        .status-cancelled {
            color: #f44336;
        }
        .status-refunded {
            color: #607D8B;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $basic->site_title }}</h2>
        <p>{{ $pageTitle }}</p>
        <p>Generated on: {{ date('d M, Y H:i:s') }}</p>
    </div>

    <div class="user-info">
        <p><strong>User:</strong> {{ $user->username }} ({{ $user->email }})</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>TRX ID</th>
                <th>Gold Coin</th>
                <th>Weight</th>
                <th>Total Price</th>
                <th>Payment Source</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->trx_id }}</td>
                    <td>{{ $order->goldCoin->name }} ({{ $order->goldCoin->karat }})</td>
                    <td>{{ $order->weight_in_grams }} g</td>
                    <td>{{ currencyPosition($order->total_price) }}</td>
                    <td>{{ ucfirst($order->payment_source) }}</td>
                    <td class="status-{{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </td>
                    <td>{{ $order->created_at->format('d M, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">No orders found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ $basic->site_title }}. All rights reserved.</p>
    </div>
</body>
</html> 