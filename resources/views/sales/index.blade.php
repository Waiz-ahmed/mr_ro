@extends('layouts.master')

@section('title', 'Daily POS Sale')

@section('content')
<h2 class="mb-4">POS Checkout</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('sales.store') }}" method="POST">
    @csrf

    {{-- Product Info --}}
    <div class="mb-3">
        <label class="form-label">Item Name</label>
        <input type="text" name="item" value="Bottle" class="form-control" readonly>
    </div>

    <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number" name="amount" value="80" class="form-control" readonly>
    </div>

    {{-- Quantity --}}
    <div class="mb-3">
        <label class="form-label">Quantity</label>
        <input type="number" name="quantity" value="1" class="form-control" min="1" required>
    </div>

    {{-- Customer (Optional) --}}
    <div class="mb-3">
        <label class="form-label">Credit Customer (optional)</label>
        <select name="customer_id" class="form-select">
            <option value="">-- Walk-in Customer --</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phone }})</option>
            @endforeach
        </select>
    </div>

    {{-- Credit Checkbox --}}
    <div class="form-check mb-3">
        <input type="checkbox" name="is_credit" value="1" class="form-check-input" id="is_credit">
        <label for="is_credit" class="form-check-label">Mark as Credit Sale</label>
    </div>

    <button type="submit" class="btn btn-success">Checkout</button>
</form>
@endsection
