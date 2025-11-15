@extends('master')

@section('content')
    <div class="container mt-4">
        <h2>Damage Product Details</h2>
        <a href="{{ route('damageProduct.index') }}" class="btn btn-secondary mb-3">Back</a>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Product: {{ $damageProduct->product->name ?? '-' }}</h5>
                <p><strong>Quantity:</strong> {{ $damageProduct->quantity }}</p>
                <p><strong>Unit Price:</strong> {{ $damageProduct->unit_price }}</p>
                <p><strong>Description:</strong> {{ $damageProduct->description }}</p>
                <p><strong>User:</strong> {{ $damageProduct->user->name ?? '-' }}</p>
                <p><strong>Noted On:</strong> {{ $damageProduct->noted_on }}</p>
            </div>
        </div>
    </div>
@endsection