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
        <label class="form-label">Price (per unit)</label>
        <input type="number" id="unitPrice" name="amount" value="80" class="form-control" readonly>
    </div>

    {{-- Quantity --}}
    <div class="mb-3">
        <label class="form-label">Quantity</label>
        <input type="number" id="quantity" name="quantity" value="1" class="form-control" min="1" required>
    </div>

    {{-- Total --}}
    <div class="mb-3">
        <label class="form-label">Total Amount</label>
        <input type="number" id="totalAmount" class="form-control" value="80" readonly>
        <input type="hidden" name="total_amount" id="hiddenTotal">
    </div>

    {{-- Sale Date --}}
    <div class="mb-3">
        <label class="form-label">Sale Date</label>
        <input type="date" name="sale_date" class="form-control" value="{{ date('Y-m-d') }}">
    </div>

    {{-- Credit Customer --}}
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
    <div class="form-check mb-4">
        <input type="checkbox" name="is_credit" value="1" class="form-check-input" id="is_credit">
        <label for="is_credit" class="form-check-label">Mark as Credit Sale</label>
    </div>

    <button type="submit" class="btn btn-success">Checkout</button>

    {{-- Payment Button --}}
    <button type="button" class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#paymentModal">
        💵 Make Payment
    </button>
</form>

{{-- Payment Modal --}}
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('payments.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Make Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {{-- Customer --}}
                    <div class="mb-3">
                        <label for="customer_id_modal" class="form-label">Customer</label>
                        <select name="customer_id" id="customer_id_modal" class="form-select" required>
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phone }})</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Amount --}}
                    <div class="mb-3">
                        <label for="payment_amount" class="form-label">Amount</label>
                        <input type="number" id="payment_amount" name="amount" class="form-control" required min="1">
                    </div>

                    {{-- Payment Method --}}
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="form-select" required>
                            <option value="cash">Cash</option>
                            <option value="bank">Bank</option>
                            <option value="easypaisa">EasyPaisa</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit Payment</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const priceInput = document.getElementById('unitPrice');
    const quantityInput = document.getElementById('quantity');
    const totalInput = document.getElementById('totalAmount');
    const hiddenTotal = document.getElementById('hiddenTotal');

    function calculateTotal() {
        const qty = parseInt(quantityInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        const total = qty * price;
        totalInput.value = total;
        hiddenTotal.value = total;
    }

    quantityInput.addEventListener('input', calculateTotal);
    window.addEventListener('load', calculateTotal);
</script>
@endpush
