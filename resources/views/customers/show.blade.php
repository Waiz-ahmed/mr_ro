@extends('layouts.master')

@section('title', 'Vendor Details')

@section('content')
<h2>Vendor: {{ $vendor->name }}</h2>

<p><strong>Contact:</strong> {{ $vendor->contact }}</p>
<p><strong>Created at:</strong> {{ $vendor->created_at->format('Y-m-d') }}</p>

<a href="{{ route('vendors.index') }}" class="btn btn-secondary">Back to List</a>
@endsection
