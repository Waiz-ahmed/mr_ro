@extends('layouts.master')

@section('title', 'Credit Customers')

@section('content')
<h2 class="mb-4">Outstanding Balances</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Customer</th>
            <th>Total Outstanding</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($groupedCredits as $credit)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $credit->customer->name }} ({{ $credit->customer->phone }})</td>
                <td><strong>Rs. {{ number_format($credit->total_balance, 0) }}</strong></td>
                <td>
                    <a href="{{ route('credits.invoice', $credit->customer_id) }}" class="btn btn-sm btn-info">Create Invoice</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center text-muted">No outstanding credits found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
