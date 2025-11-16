@extends('master')

@section('content')
<div class="container mt-5">
    <h2>Sales List</h2>
    <a href="{{ route('sales.create') }}" class="btn btn-success mb-3">+ Add Sale</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Product</th>
                <th>Unit</th>
                <th>Payment Method</th>
                <th>Payment Status</th>
                <th>Paid Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->customer->name }}</td>
                    <td>{{ $sale->product->name }}</td>
                    <td>{{ $sale->productUnit->unit_name }}</td>
                    <td>{{ $sale->paymentMethod->method_name }}</td>
                    <td>{{ $sale->payment_status }}</td>
                    <td>{{ $sale->paid_amount }}</td>
                    <td>
                        <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this sale?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $sales->links() }}
</div>
@endsection
