@extends('layouts.master')

@section('title', 'Product Categories')

@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Product Categories</h4>
            <small class="text-muted">{{ $categories->total() }} categories found</small>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
            <i class="fa fa-plus me-1"></i> Add Category
        </button>
    </div>

    {{-- Categories Table --}}
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th class="px-4 py-3">#</th>
                            <th class="py-3">Category Name</th>
                            <th class="py-3">Parent Category</th>
                            <th class="py-3">Description</th>
                            <th class="py-3">Products</th>
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
                                @if($category->parent)
                                    <span class="badge bg-light text-dark border">{{ $category->parent->name }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="py-3 text-muted" style="max-width: 200px;">
                                {{ Str::limit($category->description, 50) ?? '—' }}
                            </td>
                            <td class="py-3">
                                <span class="badge bg-primary rounded-pill">{{ $category->templates_count }}</span>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-success">Active</span>
                            </td>
                            <td class="py-3 text-end pe-4">
                                <button class="btn btn-sm btn-outline-primary me-1"
                                    onclick="editCategory({{ $category->id }}, '{{ addslashes($category->name) }}', '{{ $category->parent_id }}', '{{ addslashes($category->description) }}')">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <form method="POST" action="{{ route('product-categories.destroy', $category) }}" class="d-inline"
                                    onsubmit="return confirm('Delete this category?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa fa-tags fa-2x mb-2 d-block opacity-50"></i>
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

{{-- Create Category Modal --}}
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('product-categories.store') }}">
            @csrf
            <div class="modal-content border-0" style="border-radius: 16px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Add Product Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Category Name *</label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. Electronics">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Parent Category</label>
                        <select name="parent_id" class="form-select">
                            <option value="">None (Top Level)</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Description</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Optional description"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Category</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Edit Category Modal --}}
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" id="editCategoryForm">
            @csrf @method('PUT')
            <div class="modal-content border-0" style="border-radius: 16px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Category Name *</label>
                        <input type="text" name="name" id="editCategoryName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Parent Category</label>
                        <select name="parent_id" id="editCategoryParent" class="form-select">
                            <option value="">None (Top Level)</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Description</label>
                        <textarea name="description" id="editCategoryDesc" class="form-control" rows="2"></textarea>
                    </div>
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
function editCategory(id, name, parentId, description) {
    document.getElementById('editCategoryName').value = name;
    document.getElementById('editCategoryDesc').value = description;
    document.getElementById('editCategoryParent').value = parentId || '';
    document.getElementById('editCategoryForm').action = `/product-categories/${id}`;
    new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
}
</script>
@endpush
@endsection