@extends('layouts.master')

@section('title', 'All Orders')

@section('content')
<div class="container mt-4">
    <h1>All Orders</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Qty</th>
                <th>Amount</th>
                <th>Total</th>
                <th>Customer</th>
                <th>Shop</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($allSales as $sale)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $sale->item }}</td>
                <td>{{ $sale->quantity }}</td>
                <td>${{ number_format($sale->amount, 2) }}</td>
                <td>${{ number_format($sale->total_amount, 2) }}</td>
                <td>{{ $sale->customer->name ?? 'Walk-in' }}</td>
                <td>{{ $sale->shop->name ?? 'No Shop' }}</td>
                <td>{{ ucfirst($sale->status) }}</td>
                <td>
                    @if($sale->status == 'draft')
                    <form method="POST" action="{{ route('sales.finalize', $sale->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">Mark as Done</button>
                    </form>
                    @elseif($sale->status == 'finalized')
                    <span class="btn btn-sm btn-secondary">Finalized</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection