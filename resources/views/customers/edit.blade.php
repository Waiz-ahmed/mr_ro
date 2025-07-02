@extends('layouts.master')

@section('title', 'Edit Vendor')

@section('content')
<h2>Edit Vendor</h2>

<form action="{{ route('vendors.update', $vendor) }}" method="POST">
    @csrf @method('PUT')

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="{{ $vendor->name }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Contact</label>
        <input type="text" name="contact" value="{{ $vendor->contact }}" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('vendors.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
