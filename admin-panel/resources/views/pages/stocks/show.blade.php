@extends('master')

@section('content')
<div class="container">
    <h1>Stock Details</h1>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Stock #{{ $stock->id }}</h5>

            <p class="card-text"><strong>Product ID:</strong> {{ $stock->product_id }}</p>
            <p class="card-text"><strong>Quantity:</strong> {{ $stock->quantity }}</p>
            <p class="card-text"><strong>User:</strong> {{ optional($stock->user)->name ?? '-' }}</p>
            <p class="card-text"><strong>Created At:</strong> {{ $stock->created_at->format('Y-m-d H:i') }}</p>
            <p class="card-text"><strong>Updated At:</strong> {{ $stock->updated_at->format('Y-m-d H:i') }}</p>

            <a href="{{ route('stockEdit', $stock->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('stockIndex') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
