@extends('layouts.master')

@section('title', 'Add Customer')

@section('content')
    <h2>Add New Customer</h2>

    <form method="POST" action="{{ route('customers.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input name="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Save</button>
    </form>
@endsection
