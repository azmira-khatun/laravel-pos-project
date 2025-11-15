@extends('master')

@section('content')
    <h2>Create Purchase</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('purchases.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="vendor_id">Vendor</label>
            <select name="vendor_id" id="vendor_id" class="form-control" required>
                {{-- loop vendors --}}
            </select>
        </div>

        <div class="form-group">
            <label for="user_id">User (Optional)</label>
            <select name="user_id" id="user_id" class="form-control">
                {{-- loop users --}}
            </select>
        </div>

        <div class="form-group">
            <label for="product_id">Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
                {{-- loop products --}}
            </select>
        </div>

        <div class="form-group">
            <label for="productunit_id">Product Unit</label>
            <select name="productunit_id" id="productunit_id" class="form-control" required>
                {{-- loop product units --}}
            </select>
        </div>

        <div class="form-group">
            <label for="subtotal_amount">Subtotal Amount</label>
            <input type="text" name="subtotal_amount" id="subtotal_amount" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="discount_amount">Discount Amount</label>
            <input type="text" name="discount_amount" id="discount_amount" class="form-control" value="0">
        </div>

        <div class="form-group">
            <label for="tax_amount">Tax Amount</label>
            <input type="text" name="tax_amount" id="tax_amount" class="form-control" value="0">
        </div>

        <div class="form-group">
            <label for="shipping_cost">Shipping Cost</label>
            <input type="text" name="shipping_cost" id="shipping_cost" class="form-control" value="0">
        </div>

        <div class="form-group">
            <label for="total_cost">Total Cost</label>
            <input type="text" name="total_cost" id="total_cost" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="paid_amount">Paid Amount</label>
            <input type="text" name="paid_amount" id="paid_amount" class="form-control" value="0">
        </div>

        <div class="form-group">
            <label for="due_amount">Due Amount</label>
            <input type="text" name="due_amount" id="due_amount" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="payment_method_id">Payment Method</label>
            <select name="payment_method_id" id="payment_method_id" class="form-control" required>
                {{-- loop payment methods --}}
            </select>
        </div>

        <div class="form-group">
            <label for="payment_status">Payment Status</label>
            <input type="text" name="payment_status" id="payment_status" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="purchase_date">Purchase Date</label>
            <input type="datetime-local" name="purchase_date" id="purchase_date" class="form-control">
        </div>

        <div class="form-group">
            <label for="receive_date">Receive Date</label>
            <input type="date" name="receive_date" id="receive_date" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Save Purchase</button>
        <a href="{{ route('purchases.history') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
