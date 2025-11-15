@extends('master')

@section('content')
    <h1>Edit Purchase Return #{{ $ret->id }}</h1>

    <form action="{{ route('purchaseReturns.update', $ret->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="purchase_id" class="form-label">Purchase ID</label>
            <input type="number" name="purchase_id" id="purchase_id" class="form-control"
                value="{{ old('purchase_id', $ret->purchase_id) }}" required>
        </div>

        <div class="mb-3">
            <label for="product_id" class="form-label">Product ID</label>
            <input type="number" name="product_id" id="product_id" class="form-control"
                value="{{ old('product_id', $ret->product_id) }}" required>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control"
                value="{{ old('quantity', $ret->quantity) }}" required>
        </div>

        <div class="mb-3">
            <label for="return_date" class="form-label">Return Date</label>
            <input type="datetime-local" name="return_date" id="return_date" class="form-control"
                value="{{ old('return_date', \Carbon\Carbon::parse($ret->return_date)->format('Y-m-d\TH:i')) }}">
        </div>

        <div class="mb-3">
            <label for="vendor_id" class="form-label">Vendor ID</label>
            <input type="number" name="vendor_id" id="vendor_id" class="form-control"
                value="{{ old('vendor_id', $ret->vendor_id) }}" required>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">User ID</label>
            <input type="number" name="user_id" id="user_id" class="form-control"
                value="{{ old('user_id', $ret->user_id) }}" required>
        </div>

        <div class="mb-3">
            <label for="reason" class="form-label">Reason</label>
            <textarea name="reason" id="reason" class="form-control">{{ old('reason', $ret->reason) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('purchaseReturns.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
