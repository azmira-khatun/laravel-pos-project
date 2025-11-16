@extends('master')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h2>Sales Items List</h2>
        <a href="{{ route('salesitems.create') }}" class="btn btn-primary">+ Add Sales Item</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Sale ID</th>
                <th>Product</th>
                <th>Unit</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Discount</th>
                <th>Line Total</th>
                <th width="130">Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>#{{ $item->sale_id }}</td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->unit->unit_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->unit_price, 2) }}</td>
                <td>{{ number_format($item->discount_amount, 2) }}</td>
                <td>{{ number_format($item->line_total, 2) }}</td>
                <td>
                    <a href="{{ route('salesitems.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('salesitems.destroy', $item->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button onclick="return confirm('Delete this item?')" class="btn btn-sm btn-danger">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $items->links() }}

</div>
@endsection
