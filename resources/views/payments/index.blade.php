@extends('layouts.master')

@section('title', 'Payments')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Customer Payments</h2>
        <!-- <a href="{{ route('payments.create') }}" class="btn btn-success">Add Payment</a> -->
    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="GET" action="{{ route('payments.index') }}" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="customer_name" class="form-control" placeholder="Search by Customer Name" value="{{ request('customer_name') }}">
        </div>
        <div class="col-md-3">
            <input type="date" name="payment_date" class="form-control" value="{{ request('payment_date') }}">
        </div>
        <div class="col-md-auto">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="{{ route('payments.index') }}" class="btn btn-secondary">Reset</a>
        </div>
    </form>


    {{-- Payments Table --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Payment Date</th>
                <th>Amount Paid</th>
                <th>Method</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $payment->customer->name ?? 'N/A' }}</td>
                <td>{{ $payment->payment_date }}</td>
                <td>{{ number_format($payment->amount_paid, 2) }}</td>
                <td>{{ ucfirst($payment->payment_method) }}</td>
                <td>{{ $payment->note ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No payments found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $payments->withQueryString()->links() }}
</div>
@endsection