@extends('layouts.master')

@section('title', 'Customer List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Customer List</h2>
    <a href="{{ route('customers.create') }}" class="btn btn-success">Add Customer</a>
</div>

{{-- Success Message --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Error Message --}}
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- Excel Import Form --}}
<form action="{{ route('customers.import') }}" method="POST" enctype="multipart/form-data" class="mb-4">
    @csrf
    <div class="row g-2 align-items-center">
        <div class="col-md-6">
            <input type="file" name="file" class="form-control" required>
        </div>
        <div class="col-md-auto">
            <button type="submit" class="btn btn-primary">Import Excel</button>
        </div>
    </div>
</form>

{{-- Customer Table --}}
<table class="table table-bordered table-striped">
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
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->address }}</td>
                <td>{{ $customer->created_at ? $customer->created_at->format('Y-m-d') : '-' }}</td>
                <td>
                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure to delete this customer?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No customers found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
