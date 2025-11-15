@extends('master')

@section('content')
<div class="container mt-4">
    <h2>Sale Details</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr><th>ID</th><td>{{ $sale->id }}</td></tr>
        <tr><th>Invoice No</th><td>{{ $sale->invoice_no }}</td></tr>
        <tr><th>Customer</th><td>{{ $sale->customer->name ?? '-' }}</td></tr>
        <tr><th>Date</th><td>{{ $sale->sale_date }}</td></tr>
        <tr><th>Type</th><td>{{ ucfirst(str_replace('_',' ', $sale->type)) }}</td></tr>
        <tr><th>Total Amount</th><td>{{ number_format($sale->total_amount, 2) }}</td></tr>
        <tr><th>Payment Status</th><td>{{ ucfirst($sale->payment_status) }}</td></tr>
        <tr><th>Payment Method</th><td>{{ $sale->payment_method ?? '-' }}</td></tr>
        <tr><th>Note</th><td>{{ $sale->note ?? '-' }}</td></tr>
    </table>

    <h5>Items</h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ number_format($item->total_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('sales.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection
