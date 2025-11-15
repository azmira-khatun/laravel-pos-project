@extends('master')

@section('content')
<div class="container mt-4">
    <h2>Sales List</h2>

    <a href="{{ route('sales.create') }}" class="btn btn-success mb-3">+ New Sale</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Invoice No</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Total Amount</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->invoice_no }}</td>
                    <td>{{ $sale->customer->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($sale->sell_date)->format('Y‑m‑d') }}</td>
                    <td>{{ number_format($sale->paid_amount, 2) }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $sale->payment_status)) }}</td>
                    <td>
                        <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST"
                              style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this sale?');">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No sales found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $sales->links() }}
    </div>
</div>
@endsection
