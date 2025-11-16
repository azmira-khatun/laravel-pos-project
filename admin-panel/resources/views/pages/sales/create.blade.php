@extends('master')

@section('content')
<div class="container mt-5">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('sales.store') }}" method="POST">
        @csrf
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h4>Create New Sale</h4>
            </div>

            <div class="card-body">
                <div class="mb-3">
                    <label>Customer</label>
                    <select name="customer_id" class="form-select" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Product</label>
                    <select name="product_id" class="form-select" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Product Unit</label>
                    <select name="productunit_id" class="form-select" required>
                        <option value="">Select Unit</option>
                        @foreach($productUnits as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Payment Method</label>
                    <select name="payment_method_id" class="form-select" required>
                        <option value="">Select Payment Method</option>
                        @foreach($paymentMethods as $method)
                            <option value="{{ $method->id }}">{{ $method->method_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Payment Status</label>
                    <select name="payment_status" class="form-select">
                        <option value="Paid">Paid</option>
                        <option value="Due">Due</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Paid Amount</label>
                    <input type="number" step="0.01" name="paid_amount" class="form-control" value="0" required>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button class="btn btn-success">Save Sale</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
