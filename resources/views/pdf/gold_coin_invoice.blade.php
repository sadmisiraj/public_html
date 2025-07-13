<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gold Coin Invoice</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #222; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
        .no-border { border: none !important; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .header { font-size: 18px; font-weight: bold; }
        .section-title { font-weight: bold; margin-top: 10px; }
        .mb-2 { margin-bottom: 8px; }
        .mb-1 { margin-bottom: 4px; }
        .mt-2 { margin-top: 8px; }
        .mt-4 { margin-top: 16px; }
    </style>
</head>
<body>
    <table class="no-border">
        <tr>
            <td class="no-border" colspan="2">
                <div class="header">REINOGOLD</div>
                <div>NO 39A, 1ST FLOOR, KRISHNASAMY MUDALIAR ROAD,<br>COIMBATORE, 641001<br>Contact: +91-9025107649<br>E-Mail: mail@reinogold.in</div>
            </td>
            <td class="no-border text-right" colspan="2">
                <div class="header">INVOICE</div>
                <div>Invoice No.: {{ $order->trx_id }}</div>
                <div>Dated: {{ $order->created_at->format('d-M-Y') }}</div>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <th>Consignee (Ship to)</th>
            <th>Buyer (Bill to)</th>
            <th>Payment Method</th>
            <th>Order Date</th>
        </tr>
        <tr>
            <td>{{ $user->name }}<br>{{ $order->address }}</td>
            <td>{{ $user->name }}<br>{{ $order->address }}</td>
            <td>{{ ucfirst($order->payment_source) }} Balance</td>
            <td>{{ $order->created_at->format('d-M-Y') }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <th>Sl No</th>
            <th>Description of Goods</th>
            <th>Quantity</th>
            <th>Rate</th>
            <th>per</th>
            <th>Amount</th>
        </tr>
        <tr>
            <td>1</td>
            <td>{{ $order->goldCoin->name }} {{ $order->goldCoin->karat }}</td>
            <td>{{ number_format($order->weight_in_grams, 2) }} GM</td>
            <td>{{ number_format($order->price_per_gram, 2) }}</td>
            <td>GM</td>
            <td>{{ number_format($order->subtotal, 2) }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <td class="no-border text-right" colspan="5"><strong>Subtotal</strong></td>
            <td>{{ number_format($order->subtotal, 2) }}</td>
        </tr>
        @foreach($order->getChargesBreakdown() as $charge)
        <tr>
            <td class="no-border text-right" colspan="5">{{ $charge['label'] }} @if($charge['type'] == 'percentage') ({{ $charge['value'] }}%) @endif</td>
            <td>{{ number_format($charge['amount'], 2) }}</td>
        </tr>
        @endforeach
        <tr>
            <td class="no-border text-right" colspan="5"><strong>Total</strong></td>
            <td><strong>{{ number_format($order->total_price, 2) }}</strong></td>
        </tr>
    </table>
    <div class="mt-4">
        <strong>Amount Chargeable (in words):</strong><br>
        INR {{ number_format($order->total_price, 2) }} Only<br>
        {{-- If you have a helper for amount in words, use it here. Example: --}}
        {{-- INR {{ amountInWords($order->total_price) }} Only --}}
    </div>
    <div class="mt-4">
        <strong>Declaration</strong><br>
        We declare that this invoice shows the actual price of the goods described and that all particulars are true and correct.
    </div>
    <div class="mt-4 text-right">
        <strong>for REINOGOLD</strong><br><br><br>
        Authorised Signatory
    </div>
    <div class="mt-2 text-center">
        <small>This is a Computer Generated Invoice</small>
    </div>
</body>
</html> 