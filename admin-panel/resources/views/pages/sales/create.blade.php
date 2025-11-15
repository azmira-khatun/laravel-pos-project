@extends('master')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Create New Sale</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <h5 class="alert-heading">Oops!</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('sales.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="productunit_id" class="form-label">Product Unit</label>
                        <select name="productunit_id" id="productunit_id" class="form-select" required>
                            <option value="">Select unit</option>
                            {{-- @foreach($productUnits as $unit) --}}
                                {{-- <option value="{{ $unit->id }}">{{ $unit->name }}</option> --}}
                            {{-- @endforeach --}}
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="payment_method_id" class="form-label">Payment Method</label>
                        <select name="payment_method_id" id="payment_method_id" class="form-select" required>
                            <option value="">Select payment method</option>
                            {{-- @foreach($paymentMethods as $method) --}}
                                {{-- <option value="{{ $method->id }}">{{ $method->name }}</option> --}}
                            {{-- @endforeach --}}
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="customer_id" class="form-label">Customer</label>
                        <select name="customer_id" id="customer_id" class="form-select" required>
                            <option value="">Select customer</option>
                            {{-- @foreach($customers as $customer) --}}
                                {{-- <option value="{{ $customer->id }}">{{ $customer->name }}</option> --}}
                            {{-- @endforeach --}}
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="product_id" class="form-label">Product</label>
                        <select name="product_id" id="product_id" class="form-select" required>
                            <option value="">Select product</option>
                            {{-- @foreach($products as $product) --}}
                                {{-- <option value="{{ $product->id }}">{{ $product->name }}</option> --}}
                            {{-- @endforeach --}}
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="payment_status" class="form-label">Payment Status</label>
                    <input type="text" name="payment_status" id="payment_status" class="form-control" required placeholder="Paid / Pending / etc">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="paid_amount" class="form-label">Paid Amount</label>
                        <input type="number" step="0.01" name="paid_amount" id="paid_amount" class="form-control" value="0" required placeholder="0.00">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="sell_date" class="form-label">Sale Date & Time</label>
                        <input type="datetime-local" name="sell_date" id="sell_date" class="form-control" required>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success me-2">Save</button>
                    <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
