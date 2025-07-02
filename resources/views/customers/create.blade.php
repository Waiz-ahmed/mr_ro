@extends('layouts.master')

@section('title', 'Add Vendor')

@section('content')
<h2>Add Vendor</h2>

<form action="{{ route('vendors.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Contact</label>
        <input type="text" name="contact" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Save</button>
    <a href="{{ route('vendors.index') }}" class="btn btn-secondary">Back</a>
</form>
@endsection
