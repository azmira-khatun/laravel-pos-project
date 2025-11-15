@extends('master')

@section('content')
<div class="container mt-4">
    <h2>Sale Item Details</h2>

    <table class="table table-bordered">
        <tr><th>ID</th><td>{{ $saleItem->id }}</td></tr>
        <tr><th>Sale Invoice</th><td>{{ $saleItem->sale->invoice_no ?? '-' }}</td></tr>
        <tr><th>Product</th><td>{{ $saleItem->product->name ?? $saleItem->product_id }}</td></tr>
        <tr><th>Quantity</th><td>{{ $saleItem->quantity }}</td></tr>
        <tr><th>Unit Price</th><td>{{ number_format($saleItem->unit_price, 2) }}</td></tr>
        <tr><th>Total Price</th><td>{{ number_format($saleItem->total_price, 2) }}</td></tr>
        <tr><th>Created At</th><td>{{ $saleItem->created_at }}</td></tr>
        <tr><th>Updated At</th><td>{{ $saleItem->updated_at }}</td></tr>
    </table>

    <a href="{{ route('sales.items.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
