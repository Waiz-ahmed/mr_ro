<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
            line-height: 1.5;
        }
        h2, h3, h4 {
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px 10px;
            text-align: left;
        }
        .summary {
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <h2>Invoice for {{ $customer->name }}</h2>
    <p><strong>Month:</strong> {{ now()->format('F Y') }}</p>
    <p><strong>Date:</strong> {{ $invoiceDate }}</p>

    <h4>Credit Sales</h4>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($credits as $credit)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($credit->credit_date)->format('Y-m-d') }}</td>
                    <td>{{ $credit->dailySale->item ?? 'N/A' }}</td>
                    <td>{{ $credit->dailySale->quantity ?? '-' }}</td>
                    <td>{{ number_format($credit->balance, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>Payments Made</h4>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Method</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') }}</td>
                    <td>{{ ucfirst($payment->payment_method) }}</td>
                    <td>{{ number_format($payment->amount_paid, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No payments made.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <h3>Total Credit: Rs. {{ number_format($totalCredit, 2) }}</h3>
        <h3>Total Paid: Rs. {{ number_format($totalPaid, 2) }}</h3>
        <h3>Outstanding: Rs. {{ number_format($balance, 2) }}</h3>
    </div>

</body>
</html>
