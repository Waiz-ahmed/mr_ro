@extends('layouts.master')

@section('title', 'POS Dashboard')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Welcome back, {{ Auth::user()->name }}!</li>
    </ol>

    <!-- Row 1: KPI Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h5>Today's Sales</h5>
                    <h2>PKR{{ number_format($salesToday, 2) }}</h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('sales.index') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h5>Today's Expenses</h5>
                    <h2>PKR{{ number_format($expensesToday, 2) }}</h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('expenses.index') }}">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <h5>Net Profit (Today)</h5>
                    <h2>PKR{{ number_format($netProfitToday, 2) }}</h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">Profit Analysis</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <h5>Outstanding Credit</h5>
                    <h2>PKR{{ number_format($outstandingCredit, 2) }}</h2>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="{{ route('credits.index') }}">View Credits</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Chart and Quick Stats -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-line me-1"></i>
                    Sales Trend (Last 7 Days)
                </div>
                <div class="card-body" style="height: 400px;">
                    <canvas id="salesChart" style="height: 100%; width: 100%;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Quick Stats (This Month)
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p><strong>Total Sales (Month)</strong><br>PKR{{ number_format($salesMonth, 2) }}</p>
                            <p><strong>Total Expenses (Month)</strong><br>PKR{{ number_format($expensesMonth, 2) }}</p>
                        </div>
                        <div class="col-6">
                            <p><strong>Payments Received (Today)</strong><br>PKR{{ number_format($paymentsToday, 2) }}</p>
                            <p><strong>Customers / Vendors / Shops</strong><br>{{ $customerCount }} / {{ $vendorCount }} / {{ $shopCount }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Sales Table -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Recent Sales
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Shop</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                            <th>Customer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentSales as $sale)
                        <tr>
                            <td>{{ $sale->sale_date->format('Y-m-d') }}</td>
                            <td>{{ $sale->shop->name ?? 'N/A' }}</td>
                            <td>{{ $sale->item }}</td>
                            <td>{{ $sale->quantity }}</td>
                            <td>PKR{{ number_format($sale->amount, 2) }}</td>
                            <td>PKR{{ number_format($sale->total_amount, 2) }}</td>
                            <td>{{ $sale->customer->name ?? 'Walk-in' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No recent sales found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Daily Sales ($)',
                    data: @json($salesData),
                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true, title: { display: true, text: 'Amount ($)' } } }
            }
        });
    });
</script>
@endpush