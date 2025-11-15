@extends('master')


@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Create New Sales Item</h4>
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

            <form action="{{ route('salesItems.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="sale_id" class="form-label">Sale ID</label>
                    <input type="number" name="sale_id" id="sale_id" class="form-control" required placeholder="Enter sale ID">
                </div>

                <div class="mb-3">
                    <label for="product_id" class="form-label">Product</label>
                    <select name="product_id" id="product_id" class="form-select" required>
                        <option value="">Select product</option>
                        {{-- @foreach($products as $product) --}}
                            {{-- <option value="{{ $product->id }}">{{ $product->name }}</option> --}}
                        {{-- @endforeach --}}
                    </select>
                </div>

                <div class="mb-3">
                    <label for="productunit_id" class="form-label">Product Unit</label>
                    <select name="productunit_id" id="productunit_id" class="form-select" required>
                        <option value="">Select unit</option>
                        {{-- @foreach($productUnits as $unit) --}}
                            {{-- <option value="{{ $unit->id }}">{{ $unit->name }}</option> --}}
                        {{-- @endforeach --}}
                    </select>
                </div>

                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" required placeholder="Enter quantity">
                </div>

                <div class="mb-3">
                    <label for="unit_price" class="form-label">Unit Price</label>
                    <input type="number" step="0.01" name="unit_price" id="unit_price" class="form-control" required placeholder="Enter unit price">
                </div>

                <div class="mb-3">
                    <label for="discount_id" class="form-label">Discount</label>
                    <select name="discount_id" id="discount_id" class="form-select">
                        <option value="">Select discount (optional)</option>
                        {{-- @foreach($discounts as $discount) --}}
                            {{-- <option value="{{ $discount->id }}">{{ $discount->name }}</option> --}}
                        {{-- @endforeach --}}
                    </select>
                </div>

                <div class="mb-3">
                    <label for="discount_amount" class="form-label">Discount Amount</label>
                    <input type="number" step="0.01" name="discount_amount" id="discount_amount" class="form-control" value="0">
                </div>

                <div class="mb-3">
                    <label for="line_total" class="form-label">Line Total</label>
                    <input type="number" step="0.01" name="line_total" id="line_total" class="form-control" required placeholder="Enter line total">
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success me-2">Save Item</button>
                    <a href="{{ route('salesItems.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
