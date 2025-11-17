@extends('master')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>Purchases</h2>
    <a href="{{ route('purchases.create') }}" class="btn btn-primary">Create Purchase</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Vendor</th>
            <th>Product</th>
            <th>Total Cost</th>
            <th>Paid Amount</th>
            <th>Due Amount</th>
            <th>Purchase Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($purchases as $purchase)
        <tr>
            <td>{{ $purchase->id }}</td>
            <td>{{ $purchase->vendor->name ?? '-' }}</td>
            <td>{{ $purchase->product->name ?? '-' }}</td>
            <td>{{ number_format($purchase->total_cost, 2) }}</td>
            <td>{{ number_format($purchase->paid_amount, 2) }}</td>
            <td>{{ number_format($purchase->due_amount, 2) }}</td>
            <td>{{ $purchase->purchase_date->format('Y-m-d H:i') }}</td>
            <td>
                <a href="{{ route('purchases.show', $purchase) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('purchases.edit', $purchase) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('purchases.destroy', $purchase) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure to delete this purchase?')">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{-- Pagination --}}
<div class="mt-3">
    {{ $purchases->links() }}
</div>
@endsection
