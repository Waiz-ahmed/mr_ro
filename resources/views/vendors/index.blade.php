@extends('layouts.master')

@section('title', 'Vendors')

@section('content')
    <div class="container py-2">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h4 class="fw-bold" style="color: #212529;">Vendors List</h4>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert"
                style="border-radius: 12px; border: none; box-shadow: 0 4px 10px rgba(40, 167, 69, 0.1);">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                style="border-radius: 12px; border: none; box-shadow: 0 4px 10px rgba(220, 53, 69, 0.1);">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Excel Import Card (same as customers) -->
        <div class="card border-0 shadow-sm mb-4" style="background-color: white; border-radius: 16px;">
            <div class="card-body p-4">
                <form action="{{ route('vendors.import') }}" method="POST" enctype="multipart/form-data"
                    class="row g-3 align-items-center">
                    @csrf
                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-semibold mb-1">Import Excel File</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0" style="border-radius: 12px 0 0 12px;">
                                <i class="bi bi-file-excel" style="color: #0d6efd;"></i>
                            </span>
                            <input type="file" name="file" class="form-control border-0 bg-light" required
                                style="padding: 0.75rem 1rem; border-radius: 0 12px 12px 0;">
                        </div>
                    </div>
                    <div class="col-md-auto d-flex align-items-end">
                        <button type="submit" class="btn flex-grow-1"
                            style="background-color: #0d6efd; color: white; border: none; border-radius: 12px; padding: 0.75rem 1.5rem; font-weight: 500; transition: all 0.2s;">
                            <i class="bi bi-upload me-1"></i>Import Excel
                        </button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('vendors.create') }}" class="btn"
                            style="background-color: #28a745; color: white; border: none; border-radius: 12px; padding: 0.75rem 1.5rem; font-weight: 500; transition: all 0.2s;">
                            <i class="bi bi-plus-circle me-1"></i>Add Vendor
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Vendors Table Card -->
        <div class="card border-0 shadow-sm" style="background-color: white; border-radius: 16px; overflow: hidden;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="min-width: 800px;">
                    <thead style="background-color: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                        <tr>
                            <th class="px-4 py-3" style="color: #495057; font-weight: 600; font-size: 0.9rem;">#</th>
                            <th class="px-4 py-3" style="color: #495057; font-weight: 600; font-size: 0.9rem;">Vendor</th>
                            <th class="px-4 py-3" style="color: #495057; font-weight: 600; font-size: 0.9rem;">Phone</th>
                            <th class="px-4 py-3" style="color: #495057; font-weight: 600; font-size: 0.9rem;">Address</th>
                            <th class="px-4 py-3" style="color: #495057; font-weight: 600; font-size: 0.9rem;">Created</th>
                            <th class="px-4 py-3" style="color: #495057; font-weight: 600; font-size: 0.9rem;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vendors as $vendor)
                            <tr style="border-bottom: 1px solid #f1f1f1;">
                                <td class="px-4 py-3" style="color: #6c757d;">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <div
                                                style="width: 40px; height: 40px; background-color: #e7f1ff; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-building" style="color: #0d6efd; font-size: 1.2rem;"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="fw-semibold" style="color: #212529;">{{ $vendor->name ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-telephone-fill me-2" style="color: #0d6efd;"></i>
                                        <span style="color: #212529;">{{ $vendor->phone ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($vendor->address)
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-geo-alt-fill me-2" style="color: #0d6efd;"></i>
                                            <span style="color: #212529;">{{ Str::limit($vendor->address, 50) }}</span>
                                        </div>
                                    @else
                                        <span style="color: #adb5bd;">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calendar-check me-2" style="color: #0d6efd;"></i>
                                        <span
                                            style="color: #212529;">{{ $vendor->created_at ? $vendor->created_at->format('d M, Y') : '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('vendors.edit', $vendor->id) }}" class="btn"
                                            style="background-color: #ffc107; color: #212529; border: none; border-radius: 10px; padding: 0.4rem 1rem; font-size: 0.85rem; font-weight: 500; transition: all 0.2s;">
                                            <i class="bi bi-pencil me-1"></i>Edit
                                        </a>
                                        <form action="{{ route('vendors.destroy', $vendor->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this vendor?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn"
                                                style="background-color: #dc3545; color: white; border: none; border-radius: 10px; padding: 0.4rem 1rem; font-size: 0.85rem; font-weight: 500; transition: all 0.2s;">
                                                <i class="bi bi-trash me-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5" style="color: #6c757d;">
                                    <div class="text-center">
                                        <i class="bi bi-building" style="font-size: 3rem; color: #0d6efd;"></i>
                                        <p class="mt-3 mb-0">No vendors found.</p>
                                        <small>Click "Add Vendor" to get started.</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($vendors instanceof \Illuminate\Pagination\LengthAwarePaginator && $vendors->hasPages())
            <div class="d-flex justify-content-end mt-4">
                {{ $vendors->withQueryString()->links() }}
            </div>
        @endif
    </div>

    <style>
        .table tbody tr:hover {
            background-color: #f8f9fa;
            transition: background-color 0.2s;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08) !important;
        }

        .table> :not(:last-child)> :last-child>* {
            border-bottom-color: #f1f1f1;
        }

        .alert {
            transition: opacity 0.3s ease;
        }
    </style>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @endpush

@endsection
