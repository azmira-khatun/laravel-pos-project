@extends('master')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Edit Sale</h2>
    <a href="{{ route('sales.index') }}" class="btn btn-secondary mb-3">Back to List</a>

    <form action="{{ route('sales.update', $sale->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Customer --}}
        <div class="mb-3">
            <label class="form-label">Customer</label>
            <select name="customer_id" class="form-select" required>
                <option value="">Select Customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}"
                        {{ old('customer_id', $sale->customer_id) == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
            @error('customer_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Product --}}
        <div class="mb-3">
            <label class="form-label">Product</label>
            <select name="product_id" class="form-select" required>
                <option value="">Select Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}"
                        {{ old('product_id', $sale->product_id) == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
            @error('product_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Product Unit --}}
        <div class="mb-3">
            <label class="form-label">Product Unit</label>
            <select name="productunit_id" class="form-select" required>
                <option value="">Select Unit</option>
                @foreach($productUnits as $unit)
                    <option value="{{ $unit->id }}"
                        {{ old('productunit_id', $sale->productunit_id) == $unit->id ? 'selected' : '' }}>
                        {{ $unit->unit_name }}
                    </option>
                @endforeach
            </select>
            @error('productunit_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Payment Method --}}
        <div class="mb-3">
            <label class="form-label">Payment Method</label>
            <select name="payment_method_id" class="form-select" required>
                <option value="">Select Payment Method</option>
                @foreach($paymentMethods as $method)
                    <option value="{{ $method->id }}"
                        {{ old('payment_method_id', $sale->payment_method_id) == $method->id ? 'selected' : '' }}>
                        {{ $method->method_name }}
                    </option>
                @endforeach
            </select>
            @error('payment_method_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Payment Status --}}
        <div class="mb-3">
            <label class="form-label">Payment Status</label>
            <select name="payment_status" class="form-select">
                <option value="Paid" {{ old('payment_status', $sale->payment_status) == 'Paid' ? 'selected' : '' }}>Paid</option>
                <option value="Due" {{ old('payment_status', $sale->payment_status) == 'Due' ? 'selected' : '' }}>Due</option>
            </select>
            @error('payment_status')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Paid Amount --}}
        <div class="mb-3">
            <label class="form-label">Paid Amount</label>
            <input type="number" step="0.01" name="paid_amount" class="form-control"
                   value="{{ old('paid_amount', $sale->paid_amount) }}" required>
            @error('paid_amount')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        {{-- Sell Date --}}
        <div class="mb-3">
            <label class="form-label">Sell Date</label>
            <input type="datetime-local" name="sell_date" class="form-control"
                   value="{{ old('sell_date', \Carbon\Carbon::parse($sale->sell_date)->format('Y-m-d\TH:i')) }}" required>
            @error('sell_date')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Sale</button>
    </form>
</div>
@endsection
