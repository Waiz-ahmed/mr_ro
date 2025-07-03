@extends('layouts.master')

@section('title', 'Customer List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Customer List</h2>
    <a href="{{ route('customers.create') }}" class="btn btn-success">Add Customer</a>
</div>

{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Excel Import Form --}}
<form action="{{ route('customers.import') }}" method="POST" enctype="multipart/form-data" class="row g-3 align-items-center mb-4">
    @csrf
    <div class="col-md-6">
        <input type="file" name="file" class="form-control" required>
    </div>
    <div class="col-md-auto">
        <button type="submit" class="btn btn-primary">Import Excel</button>
    </div>
</form>

{{-- Customer Table --}}
<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customers as $customer)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $customer->name ?? '-' }}</td>
                    <td>{{ $customer->phone ?? '-' }}</td>
                    <td>{{ $customer->address ?? '-' }}</td>
                    <td>{{ $customer->created_at ? $customer->created_at->format('Y-m-d') : '-' }}</td>
                    <td>
                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure to delete this customer?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No customers found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Optional Pagination --}}
{{-- <div class="mt-3">{{ $customers->links() }}</div> --}}
@endsection
