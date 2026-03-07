<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Daily Sales Report</title>

    <style>
        body {
            font-family: Arial;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
        }

        th {
            background: #f2f2f2;
        }

        h2 {
            margin-bottom: 5px;
        }

        .section {
            margin-top: 20px;
        }
    </style>

</head>

<body>

    <h1>Daily Sales Report</h1>
    <p>Date: {{ $date }}</p>

    <!-- CASH SALES -->
    <div class="section">
        <h2>Cash Sales</h2>

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

        <b>Total Cash Sales: {{ number_format($cashTotal,2) }}</b>

    </div>


    <!-- CREDIT SALES -->

    <div class="section">

        <h2>Credit Sales</h2>

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

        <b>Total Credit Sales: {{ number_format($creditTotal,2) }}</b>

    </div>


    <!-- PAYMENTS RECEIVED -->

    <div class="section">

        <h2>Credit Payments Received</h2>

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

        <b>Total Payments Received: {{ number_format($paymentTotal,2) }}</b>

    </div>

</body>

</html>