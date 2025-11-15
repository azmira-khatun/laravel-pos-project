@extends('master')

@section('content')
<div class="container">
    <h1>Edit Stock</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('stockUpdate', $stock->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="product_id" class="form-label">Product ID</label>
            <input type="number" name="product_id" id="product_id" class="form-control" value="{{ old('product_id', $stock->product_id) }}" required>
            @error('product_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', $stock->quantity) }}" required min="0">
            @error('quantity')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">User (optional)</label>
            <input type="number" name="user_id" id="user_id" class="form-control" value="{{ old('user_id', $stock->user_id) }}">
            @error('user_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Stock</button>
        <a href="{{ route('stockIndex') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
