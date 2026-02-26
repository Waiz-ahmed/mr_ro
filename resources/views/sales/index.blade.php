@extends('layouts.master')

@section('title', 'Daily POS Sale - ' . ($shop->name ?? ''))

@section('content')
<style>
    body {
        background-color: #f7f7f7;
        overflow: hidden;
    }

    .pos-container {
        height: calc(100vh - 120px);
        max-height: 500px;
        overflow: hidden;
        padding: 12px;
    }

    .pos-row {
        height: 100%;
        display: flex;
        gap: 15px;
    }

    .pos-left-panel {
        width: 40%;
        display: flex;
        flex-direction: column;
        gap: 12px;
        height: 83%;
        overflow: hidden;
    }

    .pos-right-panel {
        width: 60%;
        height: 100%;
        overflow: hidden;
    }

    /* Action Buttons Bar */
    .action-bar {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        padding: 8px 12px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .action-btn {
        padding: 6px 12px;
        font-size: 13px;
        border-radius: 6px;
        white-space: nowrap;
    }

    /* Products Grid */
    .products-grid {
        background: white;
        border-radius: 8px;
        padding: 12px;
        height: calc(100% - 120px);
        overflow-y: auto;
    }

    .products-grid .d-flex {
        gap: 12px;
    }

    .product-button {
        width: 110px;
        flex-shrink: 0;
    }

    .product-button .card {
        transition: transform 0.2s;
        cursor: pointer;
    }

    .product-button .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15) !important;
    }

    .product-button img {
        height: 80px;
        object-fit: contain;
    }

    /* Summary Card */
    .summary-card {
        background: white;
        border-radius: 8px;
        padding: 12px;
        flex-shrink: 0;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        margin-bottom: 4px;
    }

    /* Cart Section */
    .cart-card {
        background: white;
        border-radius: 8px;
        height: 85%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .cart-header {
        padding: 12px;
        background: #2c3e50;
        color: white;
        font-weight: 600;
        font-size: 14px;
    }

    .cart-body {
        flex: 1;
        overflow-y: auto;
        padding: 12px;
    }

    .cart-table {
        width: 100%;
        font-size: 13px;
    }

    .cart-table th {
        background: #f8f9fa;
        padding: 8px;
        font-weight: 600;
    }

    .cart-table td {
        padding: 8px;
        vertical-align: middle;
    }

    .qty-btn {
        padding: 2px 8px;
        font-size: 12px;
        line-height: 1;
    }

    .cart-footer {
        padding: 12px;
        background: #f8f9fa;
        border-top: 1px solid #dee2e6;
    }

    /* Form Elements */
    .form-control-sm-custom {
        height: 32px;
        font-size: 13px;
    }

    .discount-section {
        background: #fff3cd;
        padding: 10px;
        border-radius: 6px;
        margin-bottom: 12px;
    }

    /* Modals - ensure they don't affect main container height */
    .modal-content {
        max-height: 80vh;
        overflow-y: auto;
    }
</style>

<div class="pos-container">
    <!-- Action Buttons -->
    <div class="action-bar mb-2 align-items-center">
        <a href="{{ route('credits.index') }}" class="btn btn-primary action-btn">
            Credit Customers
        </a>
        <button class="btn btn-primary action-btn" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
            Add Expense
        </button>
        <a href="{{ route('sales.index') }}" class="btn btn-primary action-btn">
            All Orders
        </a>
        <button class="btn btn-warning action-btn" data-bs-toggle="modal" data-bs-target="#outstandingModal">
            Outstanding Balance: ({{ number_format(\App\Models\CreditCustomer::sum('balance'), 0) }})
        </button>

        <div id="selectedCustomerBalanceBox"
            class="px-3 py-2 bg-light border rounded"
            style="min-width:200px;">
            <small class="text-muted">Customer Outstanding</small>
            <div class="fw-bold text-danger">
                Rs. <span id="selectedCustomerBalance">0</span>
            </div>
        </div>
    </div>

    <!-- Main POS Row -->
    <div class="pos-row">
        <!-- Left Panel - Products & Summary -->
        <div class="pos-left-panel">
            <!-- Products Grid -->
            <div class="products-grid">
                <h6 class="mb-2" style="font-size: 14px;">Products</h6>
                <div class="d-flex flex-wrap">
                    <button class="add-to-cart product-button border-0 bg-transparent" data-name="Bottle" data-price="80">
                        <div class="card shadow-sm">
                            <img src="/images/bottle.jpg" class="card-img-top p-2" alt="Bottle">
                            <div class="card-body p-2 text-center">
                                <small>Bottle</small>
                                <strong>$80</strong>
                            </div>
                        </div>
                    </button>
                    <!-- Add more products here -->
                </div>
            </div>

            <!-- Summary Card -->
            <div class="summary-card">
                <h6 class="mb-2" style="font-size: 14px;">Order Summary</h6>
                <div class="summary-row">
                    <span>Subtotal:</span>
                    <span>$<span id="subtotal">0.00</span></span>
                </div>
                <div class="summary-row">
                    <span>Discount:</span>
                    <span>$<span id="discount">0.00</span></span>
                </div>
                <!-- <div class="summary-row">
                    <span>VAT (10%):</span>
                    <span>$<span id="vat">0.00</span></span>
                </div> -->
                <hr class="my-1">
                <div class="summary-row fw-bold">
                    <span>Total:</span>
                    <span>$<span id="total">0.00</span></span>
                </div>
            </div>
        </div>

        <!-- Right Panel - Cart -->
        <div class="pos-right-panel">
            <div class="cart-card">
                <div class="cart-header">
                    Shopping Cart
                </div>
                
                <div class="cart-body">
                    <form method="POST" action="{{ route('sales.store') }}" id="posForm">
                        @csrf
                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th style="width: 100px;">Quantity</th>
                                    <th style="width: 80px;">Price</th>
                                </tr>
                            </thead>
                            <tbody id="cart-body"></tbody>
                        </table>

                        <!-- Discount Section (shown when customer selected) -->
                        <div id="discount-section" style="display: none;" class="discount-section mt-2">
                            <label for="discountInput" class="form-label small mb-1">Discount Amount</label>
                            <input type="number" id="discountInput" name="discount" class="form-control form-control-sm-custom" min="0" value="0">
                        </div>

                        <!-- Hidden Inputs -->
                        <input type="hidden" name="quantity" id="formQuantity">
                        <input type="hidden" name="total_amount" id="formTotal">
                        <input type="hidden" name="item" value="Bottle">
                        <input type="hidden" name="amount" value="80">
                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">

                        <!-- Customer Selection -->
                        <div class="mb-2 mt-3">
                            <label for="customer_id_modal" class="form-label small">Customer</label>
                            <div class="input-group input-group-sm">
                                <select name="customer_id" id="customer_id_modal" class="form-select form-select-sm">
                                    <option value="">Walk-in Customer</option>
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                            data-balance="{{ $customer->creditCustomers->sum('balance') }}">
                                        {{ $customer->name }} ({{ $customer->phone }})
                                    </option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#addCustomerModal">+</button>
                            </div>
                        </div>

                        <!-- Credit Sale Checkbox -->
                        <div class="form-check mb-3">
                            <input type="checkbox" name="is_credit" value="1" class="form-check-input" id="is_credit">
                            <label for="is_credit" class="form-check-label small">Credit Sale</label>
                        </div>
                    </form>
                </div>

                <div class="cart-footer">
                    <button type="submit" form="posForm" class="btn btn-success w-100">
                        Checkout ($<span id="total-display">0.00</span>)
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modals (unchanged) --}}
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <!-- Modal content unchanged -->
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
    <!-- Modal content unchanged -->
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

@include('expenses.partials.expense_modal')
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
                        <div class="d-flex align-items-center gap-1">
                            <button class="btn btn-danger qty-btn" onclick="changeQty(${index}, -1)">-</button>
                            <span class="mx-1">${item.qty}</span>
                            <button class="btn btn-success qty-btn" onclick="changeQty(${index}, 1)">+</button>
                        </div>
                    </td>
                    <td>$${(item.price * item.qty).toFixed(2)}</td>
                </tr>`;
        });

        const discount = parseFloat(document.getElementById('discountInput')?.value) || 0;
        const totalQty = cart.reduce((sum, item) => sum + item.qty, 0);

        // Remove VAT calculation
        const total = subtotal - discount;

        document.getElementById('subtotal').textContent = subtotal.toFixed(2);
        document.getElementById('discount').textContent = discount.toFixed(2);

        document.getElementById('total').textContent = total.toFixed(2);
        document.getElementById('total-display').textContent = total.toFixed(2);

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
                cart.push({
                    name,
                    price,
                    qty: 1
                });
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
                    
                    // Close modal and reset form
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addCustomerModal'));
                    modal.hide();
                    form.reset();
                }
            })
            .catch(err => alert("Error adding customer."));
    });

    document.getElementById('customer_id_modal').addEventListener('change', function () {

        const balanceText = document.getElementById('selectedCustomerBalance');

        if (this.value) {
            const selectedOption = this.options[this.selectedIndex];
            const balance = parseFloat(selectedOption.dataset.balance || 0);
            balanceText.textContent = balance.toLocaleString();
        } else {
            balanceText.textContent = "0";
        }

    });
</script>
@endpush