@extends('master')

@section('content')
    <div class="container mt-4">
        <h2>Edit Damage Product</h2>
        <a href="{{ route('damageProduct.index') }}" class="btn btn-secondary mb-3">Back</a>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('damageProduct.update', $damageProduct->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="product_id" class="form-label">Product</label>
                <select name="product_id" class="form-select" required>
                    @foreach(App\Models\Product::all() as $product)
                        <option value="{{ $product->id }}" @if($damageProduct->product_id == $product->id) selected @endif>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" name="quantity" class="form-control" min="1" value="{{ $damageProduct->quantity }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="unit_price" class="form-label">Unit Price</label>
                <input type="number" step="0.01" name="unit_price" class="form-control" min="0"
                    value="{{ $damageProduct->unit_price }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="2">{{ $damageProduct->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="user_id" class="form-label">User</label>
                <select name="user_id" class="form-select" required>
                    @foreach(App\Models\User::all() as $user)
                        <option value="{{ $user->id }}" @if($damageProduct->user_id == $user->id) selected @endif>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="noted_on" class="form-label">Noted On</label>
                <input type="datetime-local" name="noted_on" class="form-control"
                    value="{{ date('Y-m-d\TH:i', strtotime($damageProduct->noted_on)) }}">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection