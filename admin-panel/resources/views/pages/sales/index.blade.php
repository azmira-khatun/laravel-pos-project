@extends('master')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Sales List</h2>
        <a href="{{ route('sales.create') }}" class="btn btn-primary">➕ Create New Sale</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($sales->isEmpty())
        <div class="alert alert-info">No sales found.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total Cost</th>
                        <th>Paid Amount</th>
                        <th>Due Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                        <tr>
                            <td>{{ $sale->id }}</td>
                            <td>{{ $sale->customer->name ?? 'N/A' }}</td>
                            <td>{{ $sale->sell_date ? \Carbon\Carbon::parse($sale->sell_date)->format('Y-m-d') : 'N/A' }}</td>
                            <td>${{ number_format($sale->total_cost, 2) }}</td>
                            <td>${{ number_format($sale->paid_amount, 2) }}</td>
                            <td>${{ number_format($sale->due_amount, 2) }}</td>
                            <td>
                                <span class="badge {{ $sale->payment_status == 'Paid' ? 'bg-success' : ($sale->payment_status == 'Due' ? 'bg-warning' : 'bg-info') }}">
                                    {{ $sale->payment_status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('sales.destroy', $sale) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this sale?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        <div class="d-flex justify-content-center">
            {{ $sales->links() }}
        </div>
    @endif
</div>
@endsection
