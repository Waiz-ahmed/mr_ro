@extends('layouts.master')

@section('title', 'UOM Categories')
@section('page-title', 'UOM Categories')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">UOM Categories</h4>
            <small class="text-muted">{{ $categories->total() }} categories found</small>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUomCategoryModal">
            <i class="fa fa-plus me-1"></i> Add Category
        </button>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="py-3">Category Name</th>
                            <th class="py-3">Units Count</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr>
                            <td class="px-4 py-3 text-muted">{{ $loop->iteration }}</td>
                            <td class="py-3 fw-semibold">{{ $category->name }}</td>
                            <td class="py-3">
                                <span class="badge bg-primary rounded-pill">{{ $category->uoms_count }}</span>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td class="py-3 text-end pe-4">
                                <button class="btn btn-sm btn-outline-primary me-1"
                                    onclick="editUomCategory({{ $category->id }}, '{{ addslashes($category->name) }}')">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <form method="POST" action="{{ route('uom-categories.destroy', $category) }}" class="d-inline"
                                    onsubmit="return confirm('Delete this category?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa fa-layer-group fa-2x mb-2 d-block opacity-50"></i>
                                No categories found. Click "Add Category" to create one.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($categories->hasPages())
        <div class="card-footer bg-white border-top d-flex justify-content-end">
            {{ $categories->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Create Modal --}}
<div class="modal fade" id="createUomCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <form method="POST" action="{{ route('uom-categories.store') }}">
            @csrf
            <div class="modal-content border-0" style="border-radius: 16px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Add UOM Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label fw-medium">Category Name *</label>
                    <input type="text" name="name" class="form-control" required placeholder="e.g. Weight, Volume, Length">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Category</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editUomCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <form method="POST" id="editUomCategoryForm">
            @csrf @method('PUT')
            <div class="modal-content border-0" style="border-radius: 16px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Edit UOM Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label fw-medium">Category Name *</label>
                    <input type="text" name="name" id="editUomCategoryName" class="form-control" required>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function editUomCategory(id, name) {
    document.getElementById('editUomCategoryName').value  = name;
    document.getElementById('editUomCategoryForm').action = `/uom-categories/${id}`;
    new bootstrap.Modal(document.getElementById('editUomCategoryModal')).show();
}
</script>
@endpush
@endsection