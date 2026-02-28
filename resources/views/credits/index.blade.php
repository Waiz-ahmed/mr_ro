@extends('layouts.master')

@section('title', 'Credit Customers')

@section('content')
<div class="container py-2">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="fw-bold" style="color: #212529;">Outstanding Balances</h4>
        <!-- <span class="badge" style="background-color: #e7f1ff; color: #0d6efd; font-size: 0.9rem; padding: 0.5rem 1rem; border-radius: 20px;">
            <i class="bi bi-people-fill me-1"></i> {{ $groupedCredits->count() }} Customers
        </span> -->
    </div>

<!-- Summary Cards -->
    @if($groupedCredits->count() > 0)
    <div class="row g-3 mb-2">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="background-color: white; border-radius: 16px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div style="width: 48px; height: 48px; background-color: #e7f1ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                            <i class="bi bi-people" style="color: #0d6efd; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <small class="text-muted">Total Customers</small>
                            <h5 class="fw-bold mb-0" style="color: #212529;">{{ $groupedCredits->count() }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="background-color: white; border-radius: 16px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div style="width: 48px; height: 48px; background-color: #e7f1ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                            <i class="bi bi-currency-rupee" style="color: #0d6efd; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <small class="text-muted">Total Outstanding</small>
                            <h5 class="fw-bold mb-0" style="color: #dc3545;">
                                Rs. {{ number_format($groupedCredits->sum('total_balance'), 0) }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="background-color: white; border-radius: 16px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div style="width: 48px; height: 48px; background-color: #e7f1ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                            <i class="bi bi-file-text" style="color: #0d6efd; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <small class="text-muted">Pending Invoices</small>
                            <h5 class="fw-bold mb-0" style="color: #212529;">{{ $groupedCredits->count() }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Header Section -->

    <!-- Credits Table -->
    <div class="card border-0 shadow-sm" style="background-color: white; border-radius: 16px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="min-width: 600px;">
                <thead style="background-color: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                    <tr>
                        <th class="px-4 py-3" style="color: #495057; font-weight: 600; font-size: 0.9rem;">#</th>
                        <th class="px-4 py-3" style="color: #495057; font-weight: 600; font-size: 0.9rem;">Customer</th>
                        <th class="px-4 py-3" style="color: #495057; font-weight: 600; font-size: 0.9rem;">Total Outstanding</th>
                        <th class="px-4 py-3" style="color: #495057; font-weight: 600; font-size: 0.9rem;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($groupedCredits as $credit)
                    <tr style="border-bottom: 1px solid #f1f1f1;">
                        <td class="px-4 py-3" style="color: #6c757d;">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div style="width: 40px; height: 40px; background-color: #e7f1ff; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-person-fill" style="color: #0d6efd; font-size: 1.2rem;"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fw-semibold" style="color: #212529;">{{ $credit->customer->name }}</div>
                                    <small style="color: #6c757d;">
                                        <i class="bi bi-telephone-fill me-1" style="font-size: 0.75rem; color: #0d6efd;"></i>
                                        {{ $credit->customer->phone }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="fw-bold" style="color: #dc3545; font-size: 1.1rem;">
                                Rs. {{ number_format($credit->total_balance, 0) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('credits.invoice', $credit->customer_id) }}" style="text-decoration: none;">
                                <button class="btn btn-sm" style="background-color: #0d6efd; color: white; border: none; border-radius: 8px; padding: 0.5rem 1.2rem; font-weight: 500; transition: all 0.2s;">
                                    <i class="bi bi-file-text me-1"></i>Create Invoice
                                </button>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5" style="color: #6c757d;">
                            <div class="text-center">
                                <i class="bi bi-credit-card-2-front" style="font-size: 3rem; color: #0d6efd;"></i>
                                <p class="mt-3 mb-0">No outstanding credits found.</p>
                                <small>All customer balances are settled.</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    
</div>

<style>
    /* Custom hover effects */
    .table tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s;
    }
    
    .btn:hover {
        background-color: #0b5ed7 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2);
    }
    
    /* Card hover effect */
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
    }
    
    /* Table cell borders */
    .table > :not(:last-child) > :last-child > * {
        border-bottom-color: #f1f1f1;
    }
    
    /* Customer avatar styling */
    .customer-avatar {
        transition: transform 0.2s;
    }
    
    .customer-avatar:hover {
        transform: scale(1.05);
    }
</style>

<!-- Add Bootstrap Icons if not already included in master layout -->
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endpush

@endsection