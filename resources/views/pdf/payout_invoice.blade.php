<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sale Letter</title>
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
                <div class="header">SALE LETTER</div>
                <div>Transaction ID: {{ $payout->trx_id }}</div>
                <div>Dated: {{ $payout->created_at->format('d-M-Y') }}</div>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <th>User Name</th>
            <th>Mobile Number</th>
            <th>Payment Method</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->mobile ?? '-' }}</td>
            <td>{{ optional($payout->method)->name ?? '-' }}</td>
            <td>
                @if($payout->status == 0)
                    Pending
                @elseif($payout->status == 1)
                    Generated
                @elseif($payout->status == 2)
                    Complete
                @elseif($payout->status == 3)
                    Cancelled
                @endif
            </td>
            <td>{{ $payout->created_at->format('d-M-Y') }}</td>
        </tr>
    </table>
    <table>
        <tr>
            <th>Description</th>
            <th>Amount</th>
        </tr>
        <tr>
            <td>Requested Amount</td>
            <td>{{ number_format($payout->amount, 2) }} {{ $payout->payout_currency_code }}</td>
        </tr>
        <tr>
            <td>Fee</td>
            <td>{{ number_format($payout->charge, 2) }} {{ $payout->payout_currency_code }}</td>
        </tr>
        <tr>
            <td>Net Payout</td>
            <td>{{ number_format($payout->net_amount, 2) }} {{ $payout->payout_currency_code }}</td>
        </tr>
        <tr>
            <td>Gold Sold (g)</td>
            <td>
                @php
                    // Try to get today's gold rate from config or fallback
                    $goldRate = (float) (App\Models\Config::getConfig('config_3') ?? 0);
                    $goldSold = $goldRate > 0 ? $payout->net_amount / $goldRate : 0;
                @endphp
                {{ $goldSold > 0 ? number_format($goldSold, 4) : '-' }} g
            </td>
        </tr>
    </table>
    @if($payout->information)
    <table>
        <tr>
            <th colspan="2">Payment Details</th>
        </tr>
        @foreach($payout->getInformation() as $info)
        <tr>
            <td>{{ ucwords(str_replace('_', ' ', $info['field_name'])) }}</td>
            <td>{{ $info['field_value'] }}</td>
        </tr>
        @endforeach
    </table>
    @endif
    <div class="mt-4">
        <strong>Amount Chargeable (in words):</strong><br>
        INR {{ number_format($payout->net_amount, 2) }} Only<br>
        {{-- If you have a helper for amount in words, use it here. Example: --}}
        {{-- INR {{ amountInWords($payout->net_amount) }} Only --}}<br>
        <strong>Gold Sold:</strong> {{ $goldSold > 0 ? number_format($goldSold, 4) : '-' }} g
    </div>
    <div class="mt-4">
        <strong>Declaration</strong><br>
        We declare that this invoice shows the actual payout details and that all particulars are true and correct.
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