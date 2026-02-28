@extends('layouts.master')

@section('title', 'Payments')

@section('content')
<div class="container py-2">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="fw-bold" style="color: #212529;">Customer Payments</h4>
        <!-- <span class="badge" style="background-color: #e7f1ff; color: #0d6efd; font-size: 0.9rem; padding: 0.5rem 1rem; border-radius: 20px;">
            <i class="bi bi-cash-stack me-1"></i> {{ $payments->total() }} Payments
        </span> -->
    </div>

    <!-- Summary Cards -->
    @if($payments->count() > 0)
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="background-color: white; border-radius: 16px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div style="width: 48px; height: 48px; background-color: #e7f1ff; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                            <i class="bi bi-cash-stack" style="color: #0d6efd; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <small class="text-muted">Total Payments</small>
                            <h5 class="fw-bold mb-0" style="color: #212529;">{{ $payments->total() }}</h5>
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
                            <small class="text-muted">Total Amount</small>
                            <h5 class="fw-bold mb-0" style="color: #28a745;">
                                Rs. {{ number_format($payments->sum('amount_paid'), 0) }}
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
                            <i class="bi bi-calendar-check" style="color: #0d6efd; font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <small class="text-muted">This Month</small>
                            <h5 class="fw-bold mb-0" style="color: #212529;">
                                Rs. {{ number_format($payments->whereBetween('payment_date', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount_paid'), 0) }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; box-shadow: 0 4px 10px rgba(40, 167, 69, 0.1);">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; box-shadow: 0 4px 10px rgba(220, 53, 69, 0.1);">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Search Form Card -->
    <div class="card border-0 shadow-sm mb-4" style="background-color: white; border-radius: 16px;">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('payments.index') }}" class="row g-3">
                <div class="col-md-5">
                    <label class="form-label text-muted small fw-semibold mb-1">Customer Name</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0" style="border-radius: 12px 0 0 12px;">
                            <i class="bi bi-person" style="color: #0d6efd;"></i>
                        </span>
                        <input type="text" name="customer_name" class="form-control border-0 bg-light" placeholder="Search by customer name..." value="{{ request('customer_name') }}" style="padding: 0.75rem 1rem; border-radius: 0 12px 12px 0;">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small fw-semibold mb-1">Payment Date</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0" style="border-radius: 12px 0 0 12px;">
                            <i class="bi bi-calendar" style="color: #0d6efd;"></i>
                        </span>
                        <input type="date" name="payment_date" class="form-control border-0 bg-light" value="{{ request('payment_date') }}" style="padding: 0.75rem 1rem; border-radius: 0 12px 12px 0;">
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <div class="d-flex gap-2 w-100">
                        <button type="submit" class="btn flex-grow-1" style="background-color: #0d6efd; color: white; border: none; border-radius: 12px; padding: 0.75rem 1.5rem; font-weight: 500; transition: all 0.2s;">
                            <i class="bi bi-search me-1"></i>Search
                        </button>
                        <a href="{{ route('payments.index') }}" class="btn flex-grow-1" style="background-color: #6c757d; color: white; border: none; border-radius: 12px; padding: 0.75rem 1.5rem; font-weight: 500; transition: all 0.2s;">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Payments Table Card -->
    <div class="card border-0 shadow-sm" style="background-color: white; border-radius: 16px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="min-width: 800px;">
                <thead style="background-color: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                    <tr>
                        <th class="px-4 py-3" style="color: #495057; font-weight: 600; font-size: 0.9rem;">#</th>
                        <th class="px-4 py-3" style="color: #495057; font-weight: 600; font-size: 0.9rem;">Customer</th>
                        <th class="px-4 py-3" style="color: #495057; font-weight: 600; font-size: 0.9rem;">Payment Date</th>
                        <th class="px-4 py-3" style="color: #495057; font-weight: 600; font-size: 0.9rem;">Amount Paid</th>
                        <th class="px-4 py-3" style="color: #495057; font-weight: 600; font-size: 0.9rem;">Method</th>
                        <th class="px-4 py-3" style="color: #495057; font-weight: 600; font-size: 0.9rem;">Note</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $payment)
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
                                    <div class="fw-semibold" style="color: #212529;">{{ $payment->customer->name ?? 'N/A' }}</div>
                                    <small style="color: #6c757d;">
                                        <i class="bi bi-telephone-fill me-1" style="font-size: 0.75rem; color: #0d6efd;"></i>
                                        {{ $payment->customer->phone ?? 'No phone' }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar-check me-2" style="color: #0d6efd;"></i>
                                <span style="color: #212529;">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M, Y') }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="fw-bold" style="color: #28a745; font-size: 1.1rem;">
                                Rs. {{ number_format($payment->amount_paid, 2) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $methodColors = [
                                    'cash' => ['bg' => '#e7f1ff', 'text' => '#0d6efd'],
                                    'card' => ['bg' => '#e6f7e6', 'text' => '#28a745'],
                                    'bank' => ['bg' => '#fff3cd', 'text' => '#ffc107'],
                                    'cheque' => ['bg' => '#e2d9f3', 'text' => '#6f42c1'],
                                ];
                                $color = $methodColors[$payment->payment_method] ?? ['bg' => '#e9ecef', 'text' => '#6c757d'];
                            @endphp
                            <span class="badge" style="background-color: #e9ecef; color: #6c757d; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 500;">
                                <i class="bi bi-{{ $payment->payment_method == 'cash' ? 'cash' : ($payment->payment_method == 'card' ? 'credit-card' : 'bank') }} me-1"></i>
                                {{ ucfirst($payment->payment_method) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($payment->note)
                                <span class="badge bg-light text-dark" style="padding: 0.5rem 1rem; border-radius: 20px; font-weight: 400;">
                                    <i class="bi bi-chat-dots me-1" style="color: #0d6efd;"></i>
                                    {{ $payment->note }}
                                </span>
                            @else
                                <span style="color: #adb5bd;">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5" style="color: #6c757d;">
                            <div class="text-center">
                                <i class="bi bi-cash-stack" style="font-size: 3rem; color: #0d6efd;"></i>
                                <p class="mt-3 mb-0">No payments found.</p>
                                <small>Try adjusting your search filters or add a new payment.</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($payments->hasPages())
    <div class="d-flex justify-content-end mt-4">
        {{ $payments->withQueryString()->links() }}
    </div>
    @endif
</div>

<style>
    /* Custom hover effects */
    .table tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s;
    }
    
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    
    .btn-primary:hover {
        background-color: #0b5ed7 !important;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2);
    }
    
    .btn-secondary:hover {
        background-color: #5a6268 !important;
        box-shadow: 0 4px 10px rgba(108, 117, 125, 0.2);
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
    
    /* Input group styling */
    .input-group:focus-within {
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
        border-radius: 12px;
    }
    
    .input-group .form-control:focus {
        box-shadow: none;
    }
    
    /* Alert styling */
    .alert {
        transition: opacity 0.3s ease;
    }
    
    /* Pagination styling */
    .pagination {
        gap: 5px;
    }
    
    .page-link {
        border-radius: 8px !important;
        border: none;
        padding: 0.5rem 1rem;
        color: #0d6efd;
        background-color: white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    .page-item.active .page-link {
        background-color: #0d6efd;
        color: white;
    }
    
    .page-item.disabled .page-link {
        color: #adb5bd;
        background-color: white;
    }
</style>

<!-- Add Bootstrap Icons if not already included in master layout -->
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endpush

@endsection