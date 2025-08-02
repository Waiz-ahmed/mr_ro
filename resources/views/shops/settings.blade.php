@extends('layouts.master')

@section('title', 'Manage Shops')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Manage Shops</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addShopModal">Add New Shop</button>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Location</th>
                <th>Created</th>
                <th>Actions</th>
                <th>FBR Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($shops as $shop)
            <tr>
                <td>{{ $shop->name }}</td>
                <td>{{ $shop->location ?? '—' }}</td>
                <td>{{ $shop->created_at->diffForHumans() }}</td>
                <td>
                    @if($shop->fbrSetting?->enabled)
                        <a href="{{ route('settings.general', $shop->id) }}" class="btn btn-sm btn-outline-primary">
                            Edit FBR Settings
                        </a>
                    @else
                        <a href="{{ route('settings.general', $shop->id) }}" class="btn btn-sm btn-outline-secondary">
                            Manage FBR
                        </a>
                    @endif
                </td>
                <td>
                    @if($shop->fbrSetting?->enabled)
                    <span class="badge bg-success">FBR Enabled</span>
                    @else
                    <span class="badge bg-secondary">FBR Disabled</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center">No shops found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal: Add Shop -->
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