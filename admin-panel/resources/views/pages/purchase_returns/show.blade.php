@extends('master')

@section('content')
    <h1>Return Details #{{ $ret->id }}</h1>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Purchase ID:</strong> {{ $ret->purchase_id }}</p>
            <p><strong>Product:</strong> {{ $ret->product->name ?? $ret->product_id }}</p>
            <p><strong>Quantity:</strong> {{ $ret->quantity }}</p>
            <p><strong>Return Date:</strong> {{ $ret->return_date }}</p>
            <p><strong>Vendor:</strong> {{ $ret->vendor->name ?? $ret->vendor_id }}</p>
            <p><strong>User:</strong> {{ $ret->user->name ?? $ret->user_id }}</p>
            <p><strong>Reason:</strong> {{ $ret->reason }}</p>
        </div>
    </div>

    <a href="{{ route('purchaseReturns.index') }}" class="btn btn-secondary">Back to list</a>
    <a href="{{ route('purchaseReturns.edit', $ret->id) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('purchaseReturns.destroy', $ret->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger"
                onclick="return confirm('Are you sure?')">Delete</button>
    </form>
@endsection
