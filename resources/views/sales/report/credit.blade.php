<!DOCTYPE html>
<html>
<head>
    <title>Credit Sales Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { text-align: center; margin-top: 20px; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Credit Sales Report</h2>
        <p>Date: {{ $date }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Amount</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($creditSales as $sale)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $sale->customer ? $sale->customer->name : 'Walk-in' }}</td>
                <td>{{ $sale->item }}</td>
                <td>{{ $sale->quantity }}</td>
                <td>{{ $sale->amount }}</td>
                <td>{{ $sale->total_amount }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        74B, block Pak Arab, Housing Block B Society, Lahore, 54840 <br>
        Powered by CodeCousins
    </div>
</body>
</html>