@extends('layouts.master')

@section('title', 'POS — ' . ($shop->name ?? 'Sale'))

@section('content')
<style>
/* ── Reset for full-height POS ── */
.app-content { padding: 0 !important; overflow: hidden; }

/* ── Shell ── */
.pos-shell {
    display: flex;
    flex-direction: column;
    height: calc(84vh);
    background: #f0f2f5;
    font-family: 'Segoe UI', system-ui, sans-serif;
}

/* ── Top Bar ── */
.pos-topbar {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 16px;
    background: #1e293b;
    flex-shrink: 0;
    flex-wrap: wrap;
}

.pos-shop-name {
    font-size: 16px;
    font-weight: 700;
    color: #fff;
    letter-spacing: 0.02em;
    margin-right: 8px;
}

.pos-topbar .tbtn {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    font-size: 16px;
    font-weight: 500;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    white-space: nowrap;
    transition: filter 0.15s;
}
.pos-topbar .tbtn:hover { filter: brightness(1.1); text-decoration: none; }
.tbtn-blue   { background: #3b82f6; color: #fff; }
.tbtn-slate  { background: #475569; color: #fff; }
.tbtn-amber  { background: #f59e0b; color: #1e293b; }

.outstanding-pill {
    margin-left: auto;
    background: rgba(239,68,68,0.15);
    border: 1px solid rgba(239,68,68,0.35);
    color: #fca5a5;
    border-radius: 20px;
    padding: 4px 14px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
}

/* ── Main Body ── */
.pos-body {
    display: flex;
    flex: 1;
    overflow: hidden;
    gap: 0;
}

/* ── Left: Products ── */
.pos-products {
    display: flex;
    flex-direction: column;
    width: 55%;
    min-width: 0;
    background: #f0f2f5;
    overflow: hidden;
}

/* Search bar */
.pos-search {
    padding: 10px 14px 6px;
    flex-shrink: 0;
}

.pos-search input {
    width: 100%;
    padding: 7px 12px 7px 34px;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    font-size: 16px;
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E") no-repeat 10px center;
    outline: none;
    transition: border-color 0.15s;
}
.pos-search input:focus { border-color: #3b82f6; }

/* Category chips */
.cat-strip {
    display: flex;
    gap: 6px;
    padding: 6px 14px;
    overflow-x: auto;
    flex-shrink: 0;
    scrollbar-width: none;
}
.cat-strip::-webkit-scrollbar { display: none; }

.cat-chip {
    padding: 4px 14px;
    font-size: 16px;
    font-weight: 500;
    border-radius: 20px;
    background: #fff;
    border: 1.5px solid #e2e8f0;
    color: #64748b;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.15s;
    flex-shrink: 0;
}
.cat-chip:hover  { border-color: #3b82f6; color: #3b82f6; }
.cat-chip.active { background: #3b82f6; border-color: #3b82f6; color: #fff; }

/* Product grid */
.prod-grid {
    flex: 1;
    overflow-y: auto;
    padding: 6px 14px 14px;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 10px;
    align-content: start;
}

.prod-card {
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px 8px;
    text-align: center;
    cursor: pointer;
    transition: all 0.18s;
    user-select: none;
}
.prod-card:hover {
    border-color: #3b82f6;
    box-shadow: 0 4px 12px rgba(59,130,246,0.15);
    transform: translateY(-2px);
}
.prod-card:active { transform: scale(0.96); }

.prod-card .p-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: #eff6ff;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 7px;
    font-size: 18px;
    color: #3b82f6;
}

.prod-card .p-name {
    font-size: 16px;
    font-weight: 600;
    color: #1e293b;
    line-height: 1.3;
    margin-bottom: 4px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.prod-card .p-price {
    font-size: 16px;
    font-weight: 700;
    color: #059669;
}

.prod-empty {
    grid-column: 1/-1;
    text-align: center;
    padding: 40px 0;
    color: #94a3b8;
    font-size: 16px;
}

/* ── Right: Cart ── */
.pos-cart {
    width: 45%;
    min-width: 300px;
    display: flex;
    flex-direction: column;
    background: #fff;
    border-left: 1px solid #e2e8f0;
    overflow: hidden;
}

.cart-head {
    padding: 12px 16px;
    background: #1e293b;
    color: #fff;
    font-size: 16px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}

.cart-count {
    background: #3b82f6;
    color: #fff;
    font-size: 16px;
    font-weight: 700;
    border-radius: 10px;
    padding: 1px 7px;
}

/* Customer strip */
.customer-strip {
    padding: 10px 14px;
    background: #f8fafc;
    border-bottom: 1px solid #f1f5f9;
    flex-shrink: 0;
    display: flex;
    gap: 8px;
    align-items: center;
}

.customer-strip select {
    flex: 1;
    font-size: 16px;
    padding: 5px 8px;
    border: 1.5px solid #e2e8f0;
    border-radius: 7px;
    outline: none;
    background: #fff;
}
.customer-strip select:focus { border-color: #3b82f6; }

.add-cust-btn {
    width: 30px;
    height: 30px;
    border-radius: 7px;
    background: #eff6ff;
    border: 1.5px solid #bfdbfe;
    color: #3b82f6;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    flex-shrink: 0;
}

/* Outstanding badge inside cart */
.cust-balance-bar {
    display: none;
    padding: 6px 14px;
    background: #fef2f2;
    border-bottom: 1px solid #fee2e2;
    font-size: 16px;
    color: #b91c1c;
    flex-shrink: 0;
}

/* Cart items list */
.cart-items {
    flex: 1;
    overflow-y: auto;
    padding: 10px 14px;
}

.cart-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #94a3b8;
    font-size: 16px;
    gap: 8px;
}

.cart-row {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 0;
    border-bottom: 1px solid #f1f5f9;
}
.cart-row:last-child { border-bottom: none; }

.cart-row-name {
    flex: 1;
    font-size: 16px;
    font-weight: 600;
    color: #1e293b;
    min-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.qty-ctrl {
    display: flex;
    align-items: center;
    gap: 4px;
    flex-shrink: 0;
}

.qty-btn {
    width: 24px;
    height: 24px;
    border-radius: 6px;
    font-size: 16px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
}
.qty-btn.minus { background: #fee2e2; color: #dc2626; }
.qty-btn.plus  { background: #dcfce7; color: #16a34a; }
.qty-val { font-size: 16px; font-weight: 700; width: 22px; text-align: center; }

.cart-row-price {
    font-size: 16px;
    font-weight: 700;
    color: #059669;
    flex-shrink: 0;
    width: 68px;
    text-align: right;
}

.rm-btn {
    background: none;
    border: none;
    color: #cbd5e1;
    font-size: 16px;
    cursor: pointer;
    padding: 0 2px;
    flex-shrink: 0;
}
.rm-btn:hover { color: #ef4444; }

/* Summary panel */
.cart-summary {
    padding: 12px 14px;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    flex-shrink: 0;
}

.sum-row {
    display: flex;
    justify-content: space-between;
    font-size: 16px;
    color: #64748b;
    margin-bottom: 4px;
}

.sum-row.total {
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    margin-top: 6px;
    padding-top: 8px;
    border-top: 2px solid #e2e8f0;
}

.discount-row {
    display: none;
    align-items: center;
    gap: 8px;
    margin: 6px 0;
}
.discount-row label { font-size: 16px; color: #64748b; white-space: nowrap; }
.discount-row input {
    flex: 1;
    padding: 4px 8px;
    font-size: 16px;
    border: 1.5px solid #e2e8f0;
    border-radius: 6px;
    outline: none;
}
.discount-row input:focus { border-color: #f59e0b; }

.credit-check {
    display: flex;
    align-items: center;
    gap: 6px;
    margin: 6px 0 8px;
    font-size: 16px;
    color: #475569;
    cursor: pointer;
}
.credit-check input { cursor: pointer; }

/* Checkout button */
.checkout-btn {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #fff;
    font-size: 16px;
    font-weight: 700;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: opacity 0.15s, transform 0.1s;
    letter-spacing: 0.02em;
}
.checkout-btn:hover   { opacity: 0.92; }
.checkout-btn:active  { transform: scale(0.98); }
.checkout-btn:disabled { opacity: 0.5; cursor: not-allowed; }

/* ── Responsive ── */
@media (max-width: 768px) {
    .pos-shell  { height: auto; min-height: calc(100vh - 54px); }
    .pos-body   { flex-direction: column; overflow: auto; }
    .pos-products { width: 100%; height: 55vh; }
    .pos-cart   { width: 100%; min-width: 0; border-left: none; border-top: 2px solid #e2e8f0; height: auto; }
    .outstanding-pill { margin-left: 0; margin-top: 4px; }
    .pos-topbar { gap: 6px; }
}

@media (max-width: 480px) {
    .pos-products { height: 50vh; }
    .prod-grid { grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 8px; }
}
</style>

<div class="pos-shell">

    {{-- ── Top Bar ── --}}
    <div class="pos-topbar">
        <span class="pos-shop-name">
            <i class="fa fa-store me-1" style="color:#60a5fa"></i>
            {{ $shop->name ?? 'POS' }}
        </span>

        <a href="{{ route('credits.index') }}" class="tbtn tbtn-slate">
            <i class="fa fa-credit-card"></i> Credits
        </a>

        <a href="{{ route('sales.index') }}" class="tbtn tbtn-slate">
            <i class="fa fa-list"></i> All Orders
        </a>

        <button class="tbtn tbtn-blue" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
            <i class="fa fa-receipt"></i> Expense
        </button>

        <button class="outstanding-pill" data-bs-toggle="modal" data-bs-target="#outstandingModal">
            <i class="fa fa-exclamation-circle me-1"></i>
            Outstanding: Rs. {{ number_format(\App\Models\CreditCustomer::sum('balance'), 0) }}
        </button>
    </div>

    {{-- ── Body ── --}}
    <div class="pos-body">

        {{-- ── Products Panel ── --}}
        <div class="pos-products">

            {{-- Search --}}
            <div class="pos-search">
                <input type="text" id="prodSearch" placeholder="Search products…" autocomplete="off">
            </div>

            {{-- Category chips --}}
            <div class="cat-strip">
                <button class="cat-chip active" data-cat="all">All</button>
                @foreach($categories as $cat)
                    @if($cat->templates->count() > 0)
                    <button class="cat-chip" data-cat="{{ $cat->id }}">{{ $cat->name }}</button>
                    @endif
                @endforeach
            </div>

            {{-- Grid --}}
            <div class="prod-grid" id="prodGrid">
                @forelse($allProducts as $product)
                <div class="prod-card"
                     data-cat="{{ $product->category_id ?? 'none' }}"
                     data-id="{{ $product->id }}"
                     data-name="{{ $product->name }}"
                     data-price="{{ $product->sale_price }}"
                     data-search="{{ strtolower($product->name . ' ' . $product->internal_ref) }}"
                     onclick="addToCart(this)">
                    <div class="p-icon"><i class="fa fa-box"></i></div>
                    <div class="p-name">{{ $product->name }}</div>
                    <div class="p-price">Rs. {{ number_format($product->sale_price, 0) }}</div>
                </div>
                @empty
                <div class="prod-empty">
                    <i class="fa fa-box-open fa-2x mb-2 d-block"></i>
                    No products yet. Add products from the Products menu.
                </div>
                @endforelse
            </div>
        </div>

        {{-- ── Cart Panel ── --}}
        <div class="pos-cart">

            <div class="cart-head">
                <i class="fa fa-shopping-cart"></i>
                Cart
                <span class="cart-count" id="cartCount">0</span>
            </div>

            {{-- Customer --}}
            <div class="customer-strip">
                <select id="customerSelect" name="customer_id">
                    <option value="">Walk-in Customer</option>
                    @foreach($customers as $c)
                    <option value="{{ $c->id }}"
                            data-balance="{{ $c->creditCustomers->sum('balance') }}">
                        {{ $c->name }} ({{ $c->phone }})
                    </option>
                    @endforeach
                </select>
                <button class="add-cust-btn" type="button"
                    data-bs-toggle="modal" data-bs-target="#addCustomerModal"
                    title="Add customer">+</button>
            </div>

            {{-- Balance bar (shown when customer has outstanding) --}}
            <div class="cust-balance-bar" id="custBalanceBar">
                <i class="fa fa-exclamation-triangle me-1"></i>
                Outstanding: Rs. <strong id="custBalanceAmt">0</strong>
            </div>

            {{-- Items --}}
            <div class="cart-items" id="cartItems">
                <div class="cart-empty" id="cartEmpty">
                    <i class="fa fa-shopping-basket fa-2x" style="color:#e2e8f0"></i>
                    <span>Cart is empty</span>
                    <small style="color:#cbd5e1">Tap a product to add it</small>
                </div>
            </div>

            {{-- Summary + Checkout --}}
            <div class="cart-summary">
                <div class="sum-row">
                    <span>Subtotal</span>
                    <span>Rs. <span id="subtotal">0</span></span>
                </div>

                <div class="discount-row" id="discountRow">
                    <label>Discount</label>
                    <input type="number" id="discountInput" min="0" value="0" placeholder="0">
                </div>

                <div class="sum-row" id="discountDisplay" style="display:none;">
                    <span>Discount</span>
                    <span style="color:#ef4444">− Rs. <span id="discountAmt">0</span></span>
                </div>

                <div class="sum-row total">
                    <span>Total</span>
                    <span>Rs. <span id="totalAmt">0</span></span>
                </div>

                <label class="credit-check">
                    <input type="checkbox" id="isCreditCheck">
                    Mark as Credit Sale
                </label>

                <form method="POST" action="{{ route('sales.store') }}" id="posForm">
                    @csrf
                    <input type="hidden" name="customer_id"   id="fCustomer">
                    <input type="hidden" name="is_credit"     id="fIsCredit"  value="0">
                    <input type="hidden" name="discount"      id="fDiscount"  value="0">
                    <input type="hidden" name="quantity"      id="fQty"       value="0">
                    <input type="hidden" name="total_amount"  id="fTotal"     value="0">
                    <input type="hidden" name="items_json"    id="fItems"     value="[]">
                    <input type="hidden" name="shop_id"       value="{{ $shop->id }}">

                    <button type="submit" class="checkout-btn" id="checkoutBtn" disabled>
                        <i class="fa fa-check me-1"></i>
                        Checkout &nbsp;·&nbsp; Rs. <span id="checkoutTotal">0</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ── Add Customer Modal ── --}}
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:380px">
        <form method="POST" action="{{ route('customers.store') }}" id="addCustomerForm">
            @csrf
            <div class="modal-content border-0" style="border-radius:16px">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold"><i class="fa fa-user-plus me-2 text-primary"></i>New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Full Name *</label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. Ahmed Khan">
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-medium">Phone *</label>
                        <input type="text" name="phone" class="form-control" required placeholder="03xx-xxxxxxx">
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Customer</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ── Outstanding Payment Modal ── --}}
<div class="modal fade" id="outstandingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px">
        <form method="POST" action="{{ route('payments.store') }}">
            @csrf
            <div class="modal-content border-0" style="border-radius:16px">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold"><i class="fa fa-money-bill me-2 text-success"></i>Collect Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="shop_id" value="{{ $shop->id ?? '' }}">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Customer *</label>
                        <select name="customer_id" class="form-select" required>
                            <option value="">Select customer</option>
                            @foreach(\App\Models\Customer::whereHas('creditCustomers', fn($q) => $q->where('balance', '>', 0))->get() as $c)
                            <option value="{{ $c->id }}">
                                {{ $c->name }} — Rs. {{ number_format($c->creditCustomers->sum('balance'), 0) }} due
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Amount (Rs.) *</label>
                        <input type="number" class="form-control" name="amount_paid" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Payment Method *</label>
                        <input type="text" class="form-control" name="payment_method" placeholder="Cash / Bank Transfer / Cheque" required>
                    </div>
                    <div class="mb-1">
                        <label class="form-label fw-medium">Note</label>
                        <textarea name="note" class="form-control" rows="2" placeholder="Optional"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Collect Payment</button>
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

// ── Add / Update cart ─────────────────────────────────────
function addToCart(el) {
    const id    = el.dataset.id;
    const name  = el.dataset.name;
    const price = parseFloat(el.dataset.price);

    const existing = cart.find(i => i.id === id);
    if (existing) {
        existing.qty++;
    } else {
        cart.push({ id, name, price, qty: 1 });
    }

    // Flash animation on card
    el.style.background = '#eff6ff';
    el.style.borderColor = '#3b82f6';
    setTimeout(() => { el.style.background = ''; el.style.borderColor = ''; }, 250);

    renderCart();
}

function changeQty(index, delta) {
    cart[index].qty += delta;
    if (cart[index].qty <= 0) cart.splice(index, 1);
    renderCart();
}

// ── Render cart ───────────────────────────────────────────
function renderCart() {
    const container = document.getElementById('cartItems');
    const isEmpty   = cart.length === 0;
    const discount  = parseFloat(document.getElementById('discountInput').value) || 0;
    let subtotal = 0;
    let totalQty = 0;

    document.getElementById('cartEmpty').style.display = isEmpty ? 'flex' : 'none';

    // Remove old rows
    container.querySelectorAll('.cart-row').forEach(r => r.remove());

    cart.forEach((item, i) => {
        const line = item.price * item.qty;
        subtotal  += line;
        totalQty  += item.qty;

        const row = document.createElement('div');
        row.className = 'cart-row';
        row.innerHTML = `
            <div class="cart-row-name" title="${item.name}">${item.name}</div>
            <div class="qty-ctrl">
                <button type="button" class="qty-btn minus" onclick="changeQty(${i},-1)">−</button>
                <span class="qty-val">${item.qty}</span>
                <button type="button" class="qty-btn plus"  onclick="changeQty(${i}, 1)">+</button>
            </div>
            <div class="cart-row-price">Rs.&nbsp;${line.toLocaleString()}</div>
            <button type="button" class="rm-btn" onclick="changeQty(${i},${-item.qty})">
                <i class="fa fa-times"></i>
            </button>`;
        container.appendChild(row);
    });

    const total = Math.max(0, subtotal - discount);

    document.getElementById('subtotal').textContent      = subtotal.toLocaleString();
    document.getElementById('discountAmt').textContent   = discount.toLocaleString();
    document.getElementById('totalAmt').textContent      = total.toLocaleString();
    document.getElementById('checkoutTotal').textContent = total.toLocaleString();
    document.getElementById('cartCount').textContent     = totalQty;

    // Show/hide discount display line
    document.getElementById('discountDisplay').style.display = discount > 0 ? '' : 'none';

    // Sync hidden form fields
    document.getElementById('fQty').value   = totalQty;
    document.getElementById('fTotal').value = total.toFixed(2);
    document.getElementById('fItems').value = JSON.stringify(cart);

    // Checkout button
    document.getElementById('checkoutBtn').disabled = isEmpty;
}

// ── Category filter ───────────────────────────────────────
document.querySelectorAll('.cat-chip').forEach(chip => {
    chip.addEventListener('click', function () {
        document.querySelectorAll('.cat-chip').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        filterProducts();
    });
});

// ── Product search ────────────────────────────────────────
document.getElementById('prodSearch').addEventListener('input', filterProducts);

function filterProducts() {
    const cat    = document.querySelector('.cat-chip.active')?.dataset.cat ?? 'all';
    const search = document.getElementById('prodSearch').value.toLowerCase().trim();

    let visible = 0;
    document.querySelectorAll('#prodGrid .prod-card').forEach(card => {
        const catMatch    = cat === 'all' || card.dataset.cat == cat;
        const searchMatch = !search || card.dataset.search.includes(search);
        const show        = catMatch && searchMatch;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    // Empty message
    let emptyEl = document.getElementById('prodGridEmpty');
    if (visible === 0) {
        if (!emptyEl) {
            emptyEl = document.createElement('div');
            emptyEl.id = 'prodGridEmpty';
            emptyEl.className = 'prod-empty';
            emptyEl.innerHTML = '<i class="fa fa-search fa-2x mb-2 d-block"></i>No products match.';
            document.getElementById('prodGrid').appendChild(emptyEl);
        }
        emptyEl.style.display = '';
    } else if (emptyEl) {
        emptyEl.style.display = 'none';
    }
}

// ── Customer change ───────────────────────────────────────
document.getElementById('customerSelect').addEventListener('change', function () {
    const sel     = this;
    const hasVal  = !!sel.value;
    const balance = hasVal ? parseFloat(sel.options[sel.selectedIndex].dataset.balance || 0) : 0;

    // Discount row toggle
    document.getElementById('discountRow').style.display = hasVal ? 'flex' : 'none';
    if (!hasVal) {
        document.getElementById('discountInput').value = 0;
        renderCart();
    }

    // Balance bar
    const bar = document.getElementById('custBalanceBar');
    if (hasVal && balance > 0) {
        document.getElementById('custBalanceAmt').textContent = balance.toLocaleString();
        bar.style.display = '';
    } else {
        bar.style.display = 'none';
    }

    document.getElementById('fCustomer').value = sel.value;
});

// ── Credit checkbox ───────────────────────────────────────
document.getElementById('isCreditCheck').addEventListener('change', function () {
    document.getElementById('fIsCredit').value = this.checked ? '1' : '0';
});

// ── Discount input ────────────────────────────────────────
document.getElementById('discountInput').addEventListener('input', function () {
    document.getElementById('fDiscount').value = this.value;
    renderCart();
});

// ── AJAX add customer ─────────────────────────────────────
document.getElementById('addCustomerForm').addEventListener('submit', function (e) {
    e.preventDefault();
    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new FormData(this)
    })
    .then(r => r.json())
    .then(data => {
        if (data.id) {
            const sel = document.getElementById('customerSelect');
            const opt = new Option(`${data.name} (${data.phone})`, data.id, true, true);
            opt.dataset.balance = 0;
            sel.appendChild(opt);
            sel.value = data.id;
            sel.dispatchEvent(new Event('change'));
            bootstrap.Modal.getInstance(document.getElementById('addCustomerModal')).hide();
            this.reset();
        }
    })
    .catch(() => alert('Error adding customer.'));
});

// Initialise
renderCart();
</script>
@endpush