@extends('layouts.master')

@section('title', 'Products')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Products</h4>
            <small class="text-muted">{{ $products->total() }} products found</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('product-categories.index') }}" class="btn btn-outline-secondary">
                <i class="fa fa-tags me-1"></i> Categories
            </a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProductModal">
                <i class="fa fa-plus me-1"></i> Add Product
            </button>
        </div>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('products.index') }}" class="card border-0 shadow-sm mb-4 p-3" style="border-radius: 12px;">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label small fw-medium">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Name, SKU, Barcode...">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-medium">Category</label>
                <select name="category_id" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-medium">Type</label>
                <select name="type" class="form-select">
                    <option value="">All Types</option>
                    <option value="storable" {{ request('type') == 'storable' ? 'selected' : '' }}>Storable</option>
                    <option value="consumable" {{ request('type') == 'consumable' ? 'selected' : '' }}>Consumable</option>
                    <option value="service" {{ request('type') == 'service' ? 'selected' : '' }}>Service</option>
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fa fa-search me-1"></i> Filter
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="fa fa-times"></i>
                </a>
            </div>
        </div>
    </form>

    {{-- Products Table --}}
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="py-3">Product Name</th>
                            <th class="py-3">Category</th>
                            <th class="py-3">Internal Ref</th>
                            <th class="py-3">Type</th>
                            <th class="py-3">Sale Price</th>
                            <th class="py-3">Cost Price</th>
                            <th class="py-3">Sale</th>
                            <th class="py-3">Purchase</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td class="px-4 py-3 text-muted">{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
                            <td class="py-3">
                                <div class="fw-semibold">{{ $product->name }}</div>
                                @if($product->barcode)
                                    <small class="text-muted"><i class="fa fa-barcode me-1"></i>{{ $product->barcode }}</small>
                                @endif
                            </td>
                            <td class="py-3">
                                @if($product->category)
                                    <span class="badge bg-light text-dark border">{{ $product->category->name }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="py-3 text-muted">{{ $product->internal_ref ?? '—' }}</td>
                            <td class="py-3">
                                @php
                                    $typeColors = ['storable' => 'primary', 'consumable' => 'warning', 'service' => 'info'];
                                @endphp
                                <span class="badge bg-{{ $typeColors[$product->type] ?? 'secondary' }}">
                                    {{ ucfirst($product->type) }}
                                </span>
                            </td>
                            <td class="py-3 fw-semibold text-success">
                                Rs. {{ number_format($product->sale_price, 2) }}
                            </td>
                            <td class="py-3 text-muted">
                                Rs. {{ number_format($product->cost_price, 2) }}
                            </td>
                            <td class="py-3">
                                @if($product->sale_ok)
                                    <i class="fa fa-check-circle text-success"></i>
                                @else
                                    <i class="fa fa-times-circle text-danger"></i>
                                @endif
                            </td>
                            <td class="py-3">
                                @if($product->purchase_ok)
                                    <i class="fa fa-check-circle text-success"></i>
                                @else
                                    <i class="fa fa-times-circle text-danger"></i>
                                @endif
                            </td>
                            <td class="py-3">
                                <span class="badge bg-{{ $product->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td class="py-3 text-end pe-4">
                                <button class="btn btn-sm btn-outline-primary me-1"
                                    onclick="editProduct({{ $product->id }}, {{ $product->toJson() }})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline"
                                    onsubmit="return confirm('Delete this product?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-5 text-muted">
                                <i class="fa fa-box-open fa-2x mb-2 d-block opacity-50"></i>
                                No products found. Click "Add Product" to create one.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($products->hasPages())
        <div class="card-footer bg-white border-top d-flex justify-content-end">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Create Product Modal --}}
<div class="modal fade" id="createProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form method="POST" action="{{ route('products.store') }}">
            @csrf
            <div class="modal-content border-0" style="border-radius: 16px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-medium">Product Name *</label>
                            <input type="text" name="name" class="form-control" required placeholder="e.g. Mineral Water 500ml">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Type *</label>
                            <select name="type" class="form-select" required>
                                <option value="storable">Storable</option>
                                <option value="consumable">Consumable</option>
                                <option value="service">Service</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Category</label>
                            <select name="category_id" class="form-select">
                                <option value="">No Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Unit of Measure *</label>
                            <select name="uom_id" class="form-select" required>
                                @foreach(\App\Models\Uom::where('status', 'active')->get() as $uom)
                                    <option value="{{ $uom->id }}">{{ $uom->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Internal Reference</label>
                            <input type="text" name="internal_ref" class="form-control" placeholder="Optional SKU or reference">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Barcode</label>
                            <input type="text" name="barcode" class="form-control" placeholder="Scan or type barcode">
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Sale Price *</label>
                            <div class="input-group">
                                <span class="input-group-text">Rs.</span>
                                <input type="number" name="sale_price" class="form-control" step="0.01" min="0" value="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Cost Price</label>
                            <div class="input-group">
                                <span class="input-group-text">Rs.</span>
                                <input type="number" name="cost_price" class="form-control" step="0.01" min="0" value="0">
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium">Description</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Optional product description"></textarea>
                        </div>
                        <div class="col-12">
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input type="checkbox" name="sale_ok" class="form-check-input" id="sale_ok" checked>
                                    <label class="form-check-label" for="sale_ok">Can be Sold</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="purchase_ok" class="form-check-input" id="purchase_ok" checked>
                                    <label class="form-check-label" for="purchase_ok">Can be Purchased</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="track_inventory" class="form-check-input" id="track_inventory" checked>
                                    <label class="form-check-label" for="track_inventory">Track Inventory</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Product</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Edit Product Modal --}}
<div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form method="POST" id="editProductForm">
            @csrf @method('PUT')
            <div class="modal-content border-0" style="border-radius: 16px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-medium">Product Name *</label>
                            <input type="text" name="name" id="editName" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Type *</label>
                            <select name="type" id="editType" class="form-select" required>
                                <option value="storable">Storable</option>
                                <option value="consumable">Consumable</option>
                                <option value="service">Service</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Category</label>
                            <select name="category_id" id="editCategory" class="form-select">
                                <option value="">No Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium">Internal Reference</label>
                            <input type="text" name="internal_ref" id="editRef" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-medium">Barcode</label>
                            <input type="text" name="barcode" id="editBarcode" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Sale Price *</label>
                            <div class="input-group">
                                <span class="input-group-text">Rs.</span>
                                <input type="number" name="sale_price" id="editSalePrice" class="form-control" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Cost Price</label>
                            <div class="input-group">
                                <span class="input-group-text">Rs.</span>
                                <input type="number" name="cost_price" id="editCostPrice" class="form-control" step="0.01" min="0">
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium">Description</label>
                            <textarea name="description" id="editDesc" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-12">
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input type="checkbox" name="sale_ok" class="form-check-input" id="editSaleOk">
                                    <label class="form-check-label" for="editSaleOk">Can be Sold</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="purchase_ok" class="form-check-input" id="editPurchaseOk">
                                    <label class="form-check-label" for="editPurchaseOk">Can be Purchased</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" name="track_inventory" class="form-check-input" id="editTrackInventory">
                                    <label class="form-check-label" for="editTrackInventory">Track Inventory</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function editProduct(id, data) {
    document.getElementById('editName').value        = data.name;
    document.getElementById('editType').value        = data.type;
    document.getElementById('editCategory').value    = data.category_id || '';
    document.getElementById('editRef').value         = data.internal_ref || '';
    document.getElementById('editBarcode').value     = data.barcode || '';
    document.getElementById('editSalePrice').value   = data.sale_price;
    document.getElementById('editCostPrice').value   = data.cost_price;
    document.getElementById('editDesc').value        = data.description || '';
    document.getElementById('editSaleOk').checked       = data.sale_ok == 1;
    document.getElementById('editPurchaseOk').checked   = data.purchase_ok == 1;
    document.getElementById('editTrackInventory').checked = data.track_inventory == 1;
    document.getElementById('editProductForm').action = `/products/${id}`;
    new bootstrap.Modal(document.getElementById('editProductModal')).show();
}
</script>
@endpush
@endsection