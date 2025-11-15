@extends('master')

@section('content')
<div class="container mt-4">
    <h2>Purchase Item List</h2>
    <a href="{{ route('purchase_items.create') }}" class="btn btn-success mb-3">+ New Purchase Item</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Purchase ID</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Line Discount</th>
                <th>Line Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->purchase_id }}</td>
                    <td>{{ $item->product->name ?? '-' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price,2) }}</td>
                    <td>{{ number_format($item->line_discount,2) }}</td>
                    <td>{{ number_format($item->line_total,2) }}</td>
                    <td>
<a href="{{ route('purchase_items.show', $item->id) }}">View</a>
                        <a href="{{ route('purchase_items.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('purchase_items.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this item?');">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No purchase items found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $items->links() ?? '' }}
    </div>
</div>
@endsection
