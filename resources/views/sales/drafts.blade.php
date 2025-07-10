@extends('layouts.master')

@section('title', 'Draft Sales')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Today's Draft Sales</h2>

    @if($draftSales->isEmpty())
        <p>No draft sales found for today.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Amount</th>
                    <th>Total</th>
                    <th>Customer</th>
                    <th>Credit</th>
                    <th>Time</th>
                    <th>Action</th> {{-- ✅ New Column --}}
                </tr>
            </thead>
            <tbody>
                @foreach($draftSales as $index => $sale)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $sale->item }}</td>
                        <td>{{ $sale->quantity }}</td>
                        <td>${{ number_format($sale->amount, 2) }}</td>
                        <td>${{ number_format($sale->total_amount, 2) }}</td>
                        <td>{{ $sale->customer->name ?? 'Walk-in' }}</td>
                        <td>{{ $sale->is_credit ? 'Yes' : 'No' }}</td>
                        <td>{{ $sale->created_at->format('h:i A') }}</td>
                        <td>
                            <form method="POST" action="{{ route('sales.finalize', $sale->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Done</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
