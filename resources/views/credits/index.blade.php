@extends('layouts.master')

@section('title', 'Credit Customers')

@section('content')
<h2 class="mb-4">Credit Customers</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Credit Sales Table --}}
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Customer</th>
            <th>Item</th>
            <th>Qty</th>
            <th>Unit Price</th>
            <th>Total</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($credits as $credit)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $credit->customer->name }} ({{ $credit->customer->phone }})</td>
                <td>{{ $credit->dailySale->item ?? '-' }}</td>
                <td>{{ $credit->dailySale->quantity ?? 1 }}</td>
                <td>Rs. {{ number_format($credit->dailySale->amount, 0) }}</td>
                <td><strong>Rs. {{ number_format($credit->balance, 0) }}</strong></td>
                <td>{{ $credit->created_at->format('d M, Y h:i A') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted">No credit records found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
