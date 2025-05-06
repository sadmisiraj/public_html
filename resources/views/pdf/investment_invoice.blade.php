<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investment Invoice</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #000;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 200px;
            margin-bottom: 10px;
        }
        .invoice-title {
            font-size: 32px;
            font-weight: bold;
            color: #001254;
            margin: 20px 0;
            text-align: center;
        }
        .invoice-number {
            font-size: 24px;
            color: #001254;
            margin-left: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .item-table th {
            background-color: #000;
            color: #fff;
            text-align: left;
            padding: 10px;
            font-size: 22px;
        }
        .item-table td {
            padding: 15px 10px;
            font-size: 20px;
            border-bottom: 1px solid #ddd;
        }
        .client-info {
            margin: 30px 0;
            font-size: 20px;
        }
        .client-info p {
            margin: 10px 0;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 18px;
            padding: 10px;
            background-color: #000;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('assets/images/logo.png') }}" alt="Reino Gold Logo" class="logo">
        </div>
        <h1 class="invoice-title">INVOICE #{{ $investment->trx }}</h1>

        <table class="item-table">
            <thead>
                <tr>
                    <th>ITEM</th>
                    <th>PRICE</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        {{ optional($investment->plan)->name ?? 'Gold Advance' }}<br>
                        Purchase
                    </td>
                    <td>
                        Rs {{ number_format($investment->amount, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="client-info">
            <p>Client Name: {{ $user->firstname }} {{ $user->lastname }}</p>
            <p>Mobile Number: {{ $user->phone_code ?? '+91' }}{{ $user->phone }}</p>
            <p>Date: {{ dateTime($investment->created_at) }}</p>
        </div>

        <div class="footer">
            {{ $basicControl->site_url ?? 'www.reinogold.in' }}
        </div>
    </div>
</body>
</html> 