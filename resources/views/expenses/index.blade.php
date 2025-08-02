@extends('layouts.master')

@section('title', 'Expenses List')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>All Expenses</h4>
        <a href="{{ route('expenses.create') }}" class="btn btn-primary">Add New Expense</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($expenses->count())
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Vendor</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
            <tr>
                <td>{{ $expense->expense_date }}</td>
                <td>{{ $expense->vendor->name ?? 'N/A' }}</td>
                <td>{{ $expense->description }}</td>
                <td>${{ number_format($expense->amount, 2) }}</td>
                <td>
                    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Delete this expense?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No expenses found.</p>
    @endif
</div>
@endsection
@push('scripts')
<script>
    document.getElementById('expenseForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Redirect to the given URL
                    window.location.href = data.redirect;
                } else {
                    alert('Failed to save expense.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving expense.');
            });
    });
</script>

@endpush