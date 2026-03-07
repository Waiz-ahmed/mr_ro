<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Daily Sales Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            width: 100%;
            margin-bottom: 20px;
        }

        .logo {
            width: 120px;
        }

        .title {
            text-align: right;
        }

        .title h1 {
            margin: 0;
            font-size: 22px;
        }

        .title p {
            margin: 2px 0;
        }

        .section {
            margin-top: 25px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
            border-bottom: 2px solid #444;
            padding-bottom: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        th {
            background: #2f4050;
            color: white;
            padding: 7px;
            text-align: left;
            font-size: 12px;
        }

        td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .total {
            text-align: right;
            margin-top: 5px;
            font-weight: bold;
        }

        .summary {
            margin-top: 25px;
            border: 1px solid #ccc;
        }

        .summary td {
            padding: 8px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }
    </style>

</head>

<body>

    <!-- HEADER -->

    <!-- HEADER -->
    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
            <td style="width: 120px; border: none;">
                <img src="{{ public_path('images/logo.png') }}" style="width: 120px;">
            </td>
            <td style="text-align: right; border: none;">
                <h1 style="margin: 0; font-size: 22px;">Daily Sales Report</h1>
                <p style="margin: 2px 0;">Date: {{ $date }}</p>
            </td>
        </tr>
    </table>
    <!-- CASH SALES -->

    <div class="section">

        <div class="section-title">Cash Sales</div>

        <table>

            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Customer</th>
                </tr>
            </thead>

            <tbody>

                @php $cashTotal = 0; @endphp

                @foreach($cashSales as $sale)

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $sale->item }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ number_format($sale->amount,2) }}</td>
                    <td>{{ number_format($sale->total_amount,2) }}</td>
                    <td>{{ $sale->customer?->name ?? 'Walk-in' }}</td>
                </tr>

                @php $cashTotal += $sale->total_amount; @endphp

                @endforeach

            </tbody>

        </table>

        <div class="total">
            Total Cash Sales: {{ number_format($cashTotal,2) }}
        </div>

    </div>



    <!-- CREDIT SALES -->

    <div class="section">

        <div class="section-title">Credit Sales</div>

        <table>

            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Customer</th>
                </tr>
            </thead>

            <tbody>

                @php $creditTotal = 0; @endphp

                @foreach($creditSales as $sale)

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $sale->item }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ number_format($sale->total_amount,2) }}</td>
                    <td>{{ $sale->customer?->name }}</td>
                </tr>

                @php $creditTotal += $sale->total_amount; @endphp

                @endforeach

            </tbody>

        </table>

        <div class="total">
            Total Credit Sales: {{ number_format($creditTotal,2) }}
        </div>

    </div>



    <!-- PAYMENTS -->

    <div class="section">

        <div class="section-title">Credit Payments Received</div>

        <table>

            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Amount Paid</th>
                    <th>Payment Method</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>

                @php $paymentTotal = 0; @endphp

                @foreach($payments as $payment)

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $payment->customer?->name }}</td>
                    <td>{{ number_format($payment->amount_paid,2) }}</td>
                    <td>{{ $payment->payment_method }}</td>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') }}</td>
                </tr>

                @php $paymentTotal += $payment->amount_paid; @endphp

                @endforeach

            </tbody>

        </table>

        <div class="total">
            Total Payments Received: {{ number_format($paymentTotal,2) }}
        </div>

    </div>



    <!-- SUMMARY -->

    <table class="summary">

        <tr>
            <td><strong>Total Cash Sales</strong></td>
            <td>{{ number_format($cashTotal,2) }}</td>
        </tr>

        <tr>
            <td><strong>Total Credit Sales</strong></td>
            <td>{{ number_format($creditTotal,2) }}</td>
        </tr>

        <tr>
            <td><strong>Total Payments Received</strong></td>
            <td>{{ number_format($paymentTotal,2) }}</td>
        </tr>

        <tr>
            <td><strong>Total Business Generated Today</strong></td>
            <td>{{ number_format($cashTotal + $creditTotal,2) }}</td>
        </tr>

    </table>



    <!-- FOOTER -->

    <div class="footer">

        <p>
            74B, block Pak Arab, Housing Block B Society, Lahore, 54840
        </p>

        <p>
            Powered by <a href="https://codecousins.com/" target="_blank">CodeCosuins</a>
        </p>

    </div>

</body>

</html>