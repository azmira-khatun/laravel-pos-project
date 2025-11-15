@extends('master')

@section('content')
<div class="container mt-4">
    <h2>Sale Items List</h2>
    <a href="{{ route('sales.create') }}" class="btn btn-success mb-3">+ New Sale</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Sale Invoice</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($saleItems as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->sale->invoice_no ?? '-' }}</td>
                    <td>{{ $item->product->name ?? $item->product_id }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ number_format($item->total_price, 2) }}</td>
                    <td>
                        <a href="{{ route('sales.items.show', $item->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('sales.items.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('sales.items.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure to delete this item?');">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No sale items found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $saleItems->links() }}
    </div>
</div>
@endsection
