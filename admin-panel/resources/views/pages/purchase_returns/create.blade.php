@extends('master')

@section('content')
    <h1>Create Purchase Return</h1>

    <form action="{{ route('purchaseReturns.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="purchase_id" class="form-label">Purchase ID</label>
            <input type="number" name="purchase_id" id="purchase_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="product_id" class="form-label">Product ID</label>
            <input type="number" name="product_id" id="product_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="1" required>
        </div>

        <div class="mb-3">
            <label for="return_date" class="form-label">Return Date</label>
            <input type="datetime-local" name="return_date" id="return_date" class="form-control">
        </div>

        <div class="mb-3">
            <label for="vendor_id" class="form-label">Vendor ID</label>
            <input type="number" name="vendor_id" id="vendor_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="user_id" class="form-label">User ID</label>
            <input type="number" name="user_id" id="user_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="reason" class="form-label">Reason</label>
            <textarea name="reason" id="reason" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('purchaseReturns.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
