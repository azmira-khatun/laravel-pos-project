@extends('master')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Purchase Item #{{ $purchaseItem->id }}</h4>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('purchaseItems.update', $purchaseItem->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="purchase_id" class="form-label">Purchase ID</label>
                    <input type="number" name="purchase_id" id="purchase_id" class="form-control"
                           value="{{ old('purchase_id', $purchaseItem->purchase_id) }}" required>
                </div>

                <div class="mb-3">
                    <label for="product_id" class="form-label">Product</label>
                    <select name="product_id" id="product_id" class="form-select" required>
                        <option value="">Select product</option>
                        {{-- @foreach($products as $product) --}}
                            {{-- <option value="{{ $product->id }}" {{ $purchaseItem->product_id == $product->id ? 'selected' : '' }}>{{ $product->name }}</option> --}}
                        {{-- @endforeach --}}
                    </select>
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control"
                           value="{{ old('quantity', $purchaseItem->quantity) }}" required>
                </div>

                <div class="mb-3">
                    <label for="unit_price" class="form-label">Unit Price</label>
                    <input type="number" step="0.01" name="unit_price" id="unit_price" class="form-control"
                           value="{{ old('unit_price', $purchaseItem->unit_price) }}" required>
                </div>

                <div class="mb-3">
                    <label for="line_discount" class="form-label">Line Discount</label>
                    <input type="number" step="0.01" name="line_discount" id="line_discount" class="form-control"
                           value="{{ old('line_discount', $purchaseItem->line_discount) }}">
                </div>

                <div class="mb-3">
                    <label for="line_total" class="form-label">Line Total</label>
                    <input type="number" step="0.01" name="line_total" id="line_total" class="form-control"
                           value="{{ old('line_total', $purchaseItem->line_total) }}" required>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2">Update Item</button>
                    <a href="{{ route('purchaseItems.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
