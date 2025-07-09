@extends('layouts.master')

@section('title', 'My Shops')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>My Shops</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addShopModal">Add Shop</button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($shops as $shop)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $shop->name }}</h5>
                        <p class="card-text text-muted">{{ $shop->location ?? 'No location' }}</p>
                        <p class="small text-end text-secondary">{{ $shop->created_at->diffForHumans() }}</p>
                        <a href="{{ route('shops.pos', $shop->id) }}">Go to POS</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">No shops found.</div>
        @endforelse
    </div>
</div>

<!-- Add Shop Modal -->
<div class="modal fade" id="addShopModal" tabindex="-1" aria-labelledby="addShopModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('shops.cards.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add New Shop</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="shopName" class="form-label">Shop Name</label>
                    <input type="text" name="name" id="shopName" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="shopLocation" class="form-label">Location</label>
                    <input type="text" name="location" id="shopLocation" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Create Shop</button>
            </div>
        </form>
    </div>
</div>
@endsection
