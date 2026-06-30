@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold text-dark mb-4">Dashboard</h4>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4 text-center">
                    <div class="mb-3">
                        <i class="fa fa-users" style="font-size: 2.5rem; color: #0d6efd;"></i>
                    </div>
                    <h2 class="fw-bold mb-1">{{ $totalCustomers }}</h2>
                    <p class="text-muted mb-0">Total Customers</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection