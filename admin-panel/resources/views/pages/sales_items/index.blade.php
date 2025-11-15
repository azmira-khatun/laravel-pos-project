@extends('master')


@section('content')
<div class="container mt-4">
    <h2>Sales Item List</h2>
    <a href="{{ route('salesItems.create') }}" class="btn btn-success mb-3">+ New Sales Item</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Sale ID</th>
                <th>Product</th>
                <th>Unit</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Discount Amount</th>
                <th>Line Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->sale_id }}</td>
                    <td>{{ $item->product->name ?? '-' }}</td>
                    <td>{{ $item->productUnit->name ?? '-' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price,2) }}</td>
                    <td>{{ number_format($item->discount_amount,2) }}</td>
                    <td>{{ number_format($item->line_total,2) }}</td>
                    <td>
                        <a href="{{ route('salesItems.show', $item->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('salesItems.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('salesItems.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this item?');">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No sales items found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $items->links() }}
    </div>
</div>
@endsection
