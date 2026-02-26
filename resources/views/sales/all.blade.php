@extends('layouts.master')

@section('title', 'All Orders')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Orders</h5>
        </div>

        <div class="card-body">

            <!-- ✅ Filter Row with Date and Search -->
            <form method="GET" class="mb-3">
                <div class="row g-3">
                    <!-- Date Filters -->
                    <div class="col-md-3">
                        <label class="form-label">From Date</label>
                        <input type="date" name="from_date" class="form-control"
                               value="{{ request('from_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">To Date</label>
                        <input type="date" name="to_date" class="form-control"
                               value="{{ request('to_date') }}">
                    </div>

                    <!-- Search Bar -->
                    <div class="col-md-4">
                        <label class="form-label">Search Table</label>
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Search by item, customer, shop, date..." 
                                   value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i> Search
                            </button>
                        </div>
                    </div>

                    <div class="col-md-2 align-self-end">
                        <a href="{{ route('sales.index') }}" class="btn btn-secondary w-100">Reset</a>
                    </div>
                </div>
            </form>

            <!-- Optional: Display search results info -->
            @if(request('search'))
                <div class="alert alert-info py-2 mb-3">
                    <i class="bi bi-info-circle"></i> 
                    Showing results for: <strong>"{{ request('search') }}"</strong>
                    <a href="{{ route('sales.index') }}" class="float-end text-decoration-none">Clear search</a>
                </div>
            @endif

            <!-- ✅ Orders Table -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Amount</th>
                            <th>Total</th>
                            <th>Customer</th>
                            <th>Shop</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($allSales as $sale)
                        <tr>
                            <td>{{ $allSales->firstItem() + $loop->index }}</td>
                            <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d M Y') }}</td>
                            <td>{{ $sale->item }}</td>
                            <td>{{ $sale->quantity }}</td>
                            <td>${{ number_format($sale->amount, 2) }}</td>
                            <td><strong>${{ number_format($sale->total_amount, 2) }}</strong></td>
                            <td>{{ $sale->customer->name ?? 'Walk-in' }}</td>
                            <td>{{ $sale->shop->name ?? 'No Shop' }}</td>
                            <td>
                                @if($sale->status == 'draft')
                                    <span class="badge bg-warning">Draft</span>
                                @else
                                    <span class="badge bg-success">Finalized</span>
                                @endif
                            </td>
                            <td>
                                @if($sale->status == 'draft')
                                <form method="POST" action="{{ route('sales.finalize', $sale->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        Mark as Done
                                    </button>
                                </form>
                                @else
                                    <span class="btn btn-sm btn-secondary disabled">
                                        Finalized
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">
                                No orders found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- ✅ Compact Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted small">
                    Showing {{ $allSales->firstItem() ?? 0 }} to {{ $allSales->lastItem() ?? 0 }} of {{ $allSales->total() }} results
                </div>
                
                <div class="pagination-compact">
                    @if ($allSales->hasPages())
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0">
                                {{-- Previous Page Link --}}
                                @if ($allSales->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">&laquo;</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $allSales->appends(request()->query())->previousPageUrl() }}" rel="prev">&laquo;</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($allSales->getUrlRange(max(1, $allSales->currentPage() - 2), min($allSales->lastPage(), $allSales->currentPage() + 2)) as $page => $url)
                                    @if ($page == $allSales->currentPage())
                                        <li class="page-item active" aria-current="page">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}&{{ http_build_query(request()->except('page')) }}">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($allSales->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $allSales->appends(request()->query())->nextPageUrl() }}" rel="next">&raquo;</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">&raquo;</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>
@endsection