@extends('master')

@section('content')
<div class="container mt-4">
    <h2>Purchase Item Details #{{ $purchaseItem->id }}</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Purchase ID:</strong> {{ $purchaseItem->purchase_id }}</p>
            <p><strong>Product:</strong> {{ $purchaseItem->product->name ?? '-' }}</p>
            <p><strong>Quantity:</strong> {{ $purchaseItem->quantity }}</p>
            <p><strong>Unit Price:</strong> {{ number_format($purchaseItem->unit_price,2) }}</p>
            <p><strong>Line Discount:</strong> {{ number_format($purchaseItem->line_discount,2) }}</p>
            <p><strong>Line Total:</strong> {{ number_format($purchaseItem->line_total,2) }}</p>
            <p><strong>Created At:</strong> {{ $purchaseItem->created_at }}</p>
        </div>
    </div>

    <a href="{{ route('purchaseItems.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection
