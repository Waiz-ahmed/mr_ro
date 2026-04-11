@extends('layouts.master')

@section('title', 'Add Vendor')

@section('content')
<div class="container py-2">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold" style="color: #212529;">Add New Vendor</h4>
        <a href="{{ route('vendors.index') }}" class="btn" style="background-color: #6c757d; color: white; border: none; border-radius: 12px; padding: 0.5rem 1.5rem; font-weight: 500; transition: all 0.2s;">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <!-- Add Form Card -->
    <div class="card border-0 shadow-sm" style="background-color: white; border-radius: 16px; overflow: hidden;">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('vendors.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="form-label text-muted small fw-semibold mb-2">Vendor Name <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0" style="border-radius: 12px 0 0 12px;">
                            <i class="bi bi-building" style="color: #0d6efd;"></i>
                        </span>
                        <input type="text" name="name" class="form-control border-0 bg-light" value="{{ old('name') }}" required style="padding: 0.75rem 1rem; border-radius: 0 12px 12px 0;" placeholder="Enter vendor name">
                    </div>
                    @error('name')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted small fw-semibold mb-2">Phone Number</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0" style="border-radius: 12px 0 0 12px;">
                            <i class="bi bi-telephone" style="color: #0d6efd;"></i>
                        </span>
                        <input type="text" name="phone" class="form-control border-0 bg-light" value="{{ old('phone') }}" style="padding: 0.75rem 1rem; border-radius: 0 12px 12px 0;" placeholder="Enter phone number">
                    </div>
                    @error('phone')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted small fw-semibold mb-2">Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0" style="border-radius: 12px 0 0 12px;">
                            <i class="bi bi-geo-alt" style="color: #0d6efd;"></i>
                        </span>
                        <textarea name="address" class="form-control border-0 bg-light" rows="3" style="padding: 0.75rem 1rem; border-radius: 0 12px 12px 0;" placeholder="Enter address">{{ old('address') }}</textarea>
                    </div>
                    @error('address')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="btn" style="background-color: #0d6efd; color: white; border: none; border-radius: 12px; padding: 0.75rem 2rem; font-weight: 500; transition: all 0.2s;">
                        <i class="bi bi-save me-1"></i>Save Vendor
                    </button>
                    <a href="{{ route('vendors.index') }}" class="btn" style="background-color: #6c757d; color: white; border: none; border-radius: 12px; padding: 0.75rem 2rem; font-weight: 500; transition: all 0.2s;">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
    }
    .input-group:focus-within {
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        border-radius: 12px;
    }
    .input-group .form-control:focus {
        box-shadow: none;
        background-color: #f8f9fa !important;
    }
    .form-label {
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }
</style>

@endsection