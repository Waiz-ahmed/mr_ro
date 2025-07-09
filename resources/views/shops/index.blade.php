@extends('layouts.master')

@section('title', 'My Shops')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>My Shops</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addShopModal">Add Shop</button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Created At</th>
                        <!-- <th>Action</th> 👈 New column -->
                    </tr>
                </thead>
                <tbody>
                    @forelse($shops as $shop)
                        <tr>
                            <td>{{ $shop->name }}</td>
                            <td>{{ $shop->location ?? '-' }}</td>
                            <td>{{ $shop->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">No shops found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addShopModal" tabindex="-1" aria-labelledby="addShopModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('shops.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add New Shop</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="shopName" class="form-label">Shop Name</label>
                    <input type="text" class="form-control" id="shopName" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="shopLocation" class="form-label">Location (Optional)</label>
                    <input type="text" class="form-control" id="shopLocation" name="location">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Create Shop</button>
            </div>
        </form>
    </div>
</div>
@endsection
