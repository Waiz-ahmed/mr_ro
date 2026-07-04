@extends('layouts.master')

@section('title', 'Units of Measure')
@section('page-title', 'Units of Measure')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Units of Measure</h4>
            <small class="text-muted">{{ $uoms->total() }} units found</small>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUomModal">
            <i class="fa fa-plus me-1"></i> Add UOM
        </button>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="py-3">Name</th>
                            <th class="py-3">Category</th>
                            <th class="py-3">Ratio</th>
                            <th class="py-3">Rounding</th>
                            <th class="py-3">Base Unit</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($uoms as $uom)
                        <tr>
                            <td class="px-4 py-3 text-muted">{{ ($uoms->currentPage() - 1) * $uoms->perPage() + $loop->iteration }}</td>
                            <td class="py-3 fw-semibold">{{ $uom->name }}</td>
                            <td class="py-3">
                                <span class="badge bg-light text-dark border">{{ $uom->category->name ?? '—' }}</span>
                            </td>
                            <td class="py-3">{{ $uom->ratio }}</td>
                            <td class="py-3">{{ $uom->rounding }}</td>
                            <td class="py-3">
                                @if($uom->is_base)
                                    <i class="fa fa-check-circle text-success"></i>
                                @else
                                    <i class="fa fa-times-circle text-muted"></i>
                                @endif
                            </td>
                            <td class="py-3 text-end pe-4">
                                <button class="btn btn-sm btn-outline-primary me-1"
                                    onclick="editUom({{ $uom->id }}, {{ $uom->toJson() }})">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <form method="POST" action="{{ route('uoms.destroy', $uom) }}" class="d-inline"
                                    onsubmit="return confirm('Delete this UOM?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa fa-ruler fa-2x mb-2 d-block opacity-50"></i>
                                No units found. Click "Add UOM" to create one.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($uoms->hasPages())
        <div class="card-footer bg-white border-top d-flex justify-content-end">
            {{ $uoms->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Create Modal --}}
<div class="modal fade" id="createUomModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('uoms.store') }}">
            @csrf
            <div class="modal-content border-0" style="border-radius: 16px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Add Unit of Measure</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Name *</label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. Kilogram">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Category *</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Select category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-medium">Ratio *</label>
                            <input type="number" name="ratio" class="form-control" step="0.000001" min="0" value="1.000000" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-medium">Rounding</label>
                            <input type="number" name="rounding" class="form-control" step="0.000001" min="0" value="0.010000">
                        </div>
                    </div>
                    <div class="mt-3 form-check">
                        <input type="checkbox" name="is_base" class="form-check-input" id="isBase">
                        <label class="form-check-label" for="isBase">This is the base unit for its category</label>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create UOM</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editUomModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="editUomForm">
            @csrf @method('PUT')
            <div class="modal-content border-0" style="border-radius: 16px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Edit Unit of Measure</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Name *</label>
                        <input type="text" name="name" id="editUomName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Category *</label>
                        <select name="category_id" id="editUomCategory" class="form-select" required>
                            <option value="">Select category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-medium">Ratio *</label>
                            <input type="number" name="ratio" id="editUomRatio" class="form-control" step="0.000001" min="0" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-medium">Rounding</label>
                            <input type="number" name="rounding" id="editUomRounding" class="form-control" step="0.000001" min="0">
                        </div>
                    </div>
                    <div class="mt-3 form-check">
                        <input type="checkbox" name="is_base" class="form-check-input" id="editUomIsBase">
                        <label class="form-check-label" for="editUomIsBase">This is the base unit for its category</label>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update UOM</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function editUom(id, data) {
    document.getElementById('editUomName').value         = data.name;
    document.getElementById('editUomCategory').value     = data.category_id;
    document.getElementById('editUomRatio').value        = data.ratio;
    document.getElementById('editUomRounding').value     = data.rounding;
    document.getElementById('editUomIsBase').checked     = data.is_base == 1;
    document.getElementById('editUomForm').action        = `/uoms/${id}`;
    new bootstrap.Modal(document.getElementById('editUomModal')).show();
}
</script>
@endpush
@endsection