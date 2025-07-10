@extends('layouts.master')

@section('title', 'Daily POS Sale - ' . ($shop->name ?? ''))

@section('content')
<style>
    body {
        background-color: #f7f7f7;
    }

    .card {
        border-radius: 12px;
    }

    .card-header {
        font-weight: bold;
    }

    .product-button {
        max-width: 250px;
    }
</style>

<div class="container-fluid min-vh-100 py-4">
    <div class="row">
        {{-- Left Side: Single Product UI --}}
        <div class="col-md-6 mb-4 d-flex align-items-center">
            <div class="flex-wrap gap-3">
                <button class="add-to-cart product-button border-0 bg-transparent" data-name="Bottle" data-price="80">
                    <div class="card shadow-sm">
                        <img src="/images/bottle.jpg" class="card-img-top p-2" alt="Bottle">
                    </div>
                </button>
                {{-- Add more products here as needed --}}
            </div>

            <div class="d-flex flex-wrap gap-3">
                <div class="card shadow-sm">
                    <button class="btn btn-warning product-button" data-bs-toggle="modal" data-bs-target="#outstandingModal">
                        Outstanding Balance
                    </button>
                </div>
                {{-- Add more products here as needed --}}
            </div>
        </div>

        {{-- Right Side: Cart Summary --}}
        <div class="col-md-6">
            <form method="POST" action="{{ route('sales.store') }}">
                @csrf

                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">Cart</div>
                    <div class="card-body">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody id="cart-body"></tbody>
                        </table>

                        <div class="mb-2" id="discount-section" style="display: none;">
                            <label for="discountInput" class="form-label">Discount per Bottle</label>
                            <input type="number" id="discountInput" name="discount_per_bottle" class="form-control" min="0" value="0">
                        </div>

                        <p class="mb-1">Subtotal: $<span id="subtotal">0.00</span></p>
                        <p class="mb-1">Discount: $<span id="discount">0.00</span></p>
                        <p class="mb-1">VAT (10%): $<span id="vat">0.00</span></p>
                        <h5>Total: $<span id="total">0.00</span></h5>

                        <input type="hidden" name="quantity" id="formQuantity">
                        <input type="hidden" name="total_amount" id="formTotal">
                        <input type="hidden" name="item" value="Bottle">
                        <input type="hidden" name="amount" value="80">
                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">

                        <div class="mb-3 mt-3">
                            <label for="customer_id_modal" class="form-label">Customer</label>
                            <div class="input-group">
                                <select name="customer_id" id="customer_id_modal" class="form-select">
                                    <option value="">Walk-in Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phone }})</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">+</button>
                            </div>
                        </div>

                        <div class="form-check mb-4">
                            <input type="checkbox" name="is_credit" value="1" class="form-check-input" id="is_credit">
                            <label for="is_credit" class="form-check-label">Credit Sale</label>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Checkout</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal: Add Customer --}}
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('customers.store') }}" id="addCustomerForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="customerName" class="form-label">Name</label>
                        <input type="text" name="name" id="customerName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="customerPhone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="customerPhone" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Customer</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="outstandingModal" tabindex="-1" aria-labelledby="outstandingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('payments.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pay Outstanding Balance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="customerSelectOutstanding" class="form-label">Select Customer</label>
                        <select name="customer_id" id="customerSelectOutstanding" class="form-select" required>
                            <option value="">Select a customer</option>
                            @foreach(\App\Models\Customer::whereHas('creditCustomers', function ($q) {
                                $q->where('balance', '>', 0);
                            })->get() as $customer)
                                <option value="{{ $customer->id }}">
                                    {{ $customer->name }} - (Outstanding: {{ number_format($customer->creditCustomers->sum('balance'), 2) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="amount_paid" class="form-label">Amount</label>
                        <input type="number" class="form-control" name="amount_paid" id="amount_paid" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <input type="text" class="form-control" name="payment_method" id="payment_method" placeholder="Cash / Bank" required>
                    </div>

                    <div class="mb-3">
                        <label for="note" class="form-label">Note (optional)</label>
                        <textarea name="note" class="form-control" id="note" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Pay Now</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const cart = [];

    function updateCart() {
        let cartBody = document.getElementById('cart-body');
        let subtotal = 0;
        cartBody.innerHTML = '';

        cart.forEach((item, index) => {
            subtotal += item.price * item.qty;
            cartBody.innerHTML += `
                <tr>
                    <td>${item.name}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" onclick="changeQty(${index}, -1)">-</button>
                        ${item.qty}
                        <button class="btn btn-sm btn-success" onclick="changeQty(${index}, 1)">+</button>
                    </td>
                    <td>$${(item.price * item.qty).toFixed(2)}</td>
                </tr>`;
        });

        const discountPerBottle = parseFloat(document.getElementById('discountInput')?.value) || 0;
        const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);
        const discount = discountPerBottle * totalQty;
        const vat = (subtotal - discount) * 0.10;
        const total = subtotal - discount + vat;

        document.getElementById('subtotal').textContent = subtotal.toFixed(2);
        document.getElementById('discount').textContent = discount.toFixed(2);
        document.getElementById('vat').textContent = vat.toFixed(2);
        document.getElementById('total').textContent = total.toFixed(2);

        document.getElementById('formQuantity').value = totalQty;
        document.getElementById('formTotal').value = total.toFixed(2);
    }

    function changeQty(index, delta) {
        cart[index].qty += delta;
        if (cart[index].qty <= 0) cart.splice(index, 1);
        updateCart();
    }

    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', () => {
            const name = button.dataset.name;
            const price = parseFloat(button.dataset.price);
            const existing = cart.find(p => p.name === name);
            if (existing) {
                existing.qty++;
            } else {
                cart.push({ name, price, qty: 1 });
            }
            updateCart();
        });
    });

    document.getElementById('customer_id_modal').addEventListener('change', function() {
        const discountSection = document.getElementById('discount-section');
        if (this.value) {
            discountSection.style.display = 'block';
        } else {
            discountSection.style.display = 'none';
            document.getElementById('discountInput').value = 0;
        }
        updateCart();
    });

    document.getElementById('discountInput').addEventListener('input', updateCart);

    // Handle AJAX customer creation and auto-select
    document.getElementById('addCustomerForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.id && data.name) {
                const option = new Option(`${data.name} (${data.phone})`, data.id, true, true);
                document.getElementById('customer_id_modal').append(option).value = data.id;
                document.getElementById('customer_id_modal').dispatchEvent(new Event('change'));
                document.getElementById('addCustomerModal').querySelector('.btn-close').click();
                form.reset();
            }
        })
        .catch(err => alert("Error adding customer."));
    });
</script>
@endpush
