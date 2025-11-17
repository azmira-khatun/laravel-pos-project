@extends('master')

@section('content')
<div class="container mt-5">
    <h2>Create Purchase</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    {{-- 💡 Note: Your controller must pass variables: $vendors, $users, $products, $units, $paymentMethods --}}
    <form action="{{ route('purchases.store') }}" method="POST">
        @csrf

        {{-- ------------------------------------------------ --}}
        {{-- Header Information --}}
        {{-- ------------------------------------------------ --}}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="vendor_id">Vendor</label>
                    <select name="vendor_id" id="vendor_id" class="form-control" required>
                        <option value="">Select Vendor</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="user_id">User (Optional)</label>
                    <select name="user_id" id="user_id" class="form-control">
                        <option value="">Select User</option>
                        {{-- Assuming $users is passed and contains the list of users --}}
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <hr>

        {{-- ------------------------------------------------ --}}
        {{-- Item Details (Single Item) --}}
        {{-- ------------------------------------------------ --}}
        <h4 class="mt-4 mb-3">Product Details</h4>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="product_id">Product</label>
                    <select name="product_id" id="product_id" class="form-control" required onchange="calculateTotals()">
                        <option value="">Select Product</option>
                        {{-- Assuming $products is passed --}}
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->cost_price ?? 0 }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group mb-3">
                    <label for="productunit_id">Product Unit</label>
                    <select name="productunit_id" id="productunit_id" class="form-control">
                        <option value="">Select Unit</option>
                        {{-- Assuming $units is passed --}}
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}" {{ old('productunit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->unit_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group mb-3">
                    <label for="quantity">Quantity</label>
                    {{-- 💡 Quantity Field Added --}}
                    <input type="number" step="1" name="quantity" id="quantity" class="form-control" value="{{ old('quantity', 1) }}" min="1" required oninput="calculateTotals()">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group mb-3">
                    <label for="unit_price">Unit Price (Cost)</label>
                    {{-- 💡 Unit Price Field Added --}}
                    <input type="number" step="0.01" name="unit_price" id="unit_price" class="form-control" value="{{ old('unit_price', 0.00) }}" min="0" required oninput="calculateTotals()">
                </div>
            </div>
        </div>

        {{-- ------------------------------------------------ --}}
        {{-- Adjustments and Totals --}}
        {{-- ------------------------------------------------ --}}
        <h4 class="mt-4 mb-3">Adjustments & Payments</h4>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="subtotal_amount">Subtotal Amount</label>
                    {{-- Hidden field for calculation output --}}
                    <input type="number" step="0.01" name="subtotal_amount" id="subtotal_amount" class="form-control" value="{{ old('subtotal_amount', 0.00) }}" required readonly>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="discount_amount">Header Discount</label>
                    <input type="number" step="0.01" name="discount_amount" id="discount_amount" class="form-control" value="{{ old('discount_amount', 0) }}" oninput="calculateTotals()">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="tax_amount">Header Tax</label>
                    <input type="number" step="0.01" name="tax_amount" id="tax_amount" class="form-control" value="{{ old('tax_amount', 0) }}" oninput="calculateTotals()">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="shipping_cost">Shipping Cost</label>
                    <input type="number" step="0.01" name="shipping_cost" id="shipping_cost" class="form-control" value="{{ old('shipping_cost', 0) }}" oninput="calculateTotals()">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="total_cost">Total Cost</label>
                    <input type="number" step="0.01" name="total_cost" id="total_cost" class="form-control" value="{{ old('total_cost', 0.00) }}" required readonly>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="paid_amount">Paid Amount</label>
                    <input type="number" step="0.01" name="paid_amount" id="paid_amount" class="form-control" value="{{ old('paid_amount', 0) }}" min="0" oninput="calculateTotals()">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="due_amount">Due Amount</label>
                    <input type="number" step="0.01" name="due_amount" id="due_amount" class="form-control" value="{{ old('due_amount', 0.00) }}" required readonly>
                </div>
            </div>
        </div>

        {{-- ------------------------------------------------ --}}
        {{-- Payment and Dates --}}
        {{-- ------------------------------------------------ --}}
        <h4 class="mt-4 mb-3">Payment & Date</h4>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="payment_method_id">Payment Method</label>
                    <select name="payment_method_id" id="payment_method_id" class="form-control" required>
                        <option value="">Select Method</option>
                        @foreach($paymentMethods as $method)
                            <option value="{{ $method->id }}" {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>{{ $method->method_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="payment_status">Payment Status</label>
                    <select name="payment_status" id="payment_status" class="form-control" required>
                        <option value="Due" {{ old('payment_status') == 'Due' ? 'selected' : '' }}>Due</option>
                        <option value="Paid" {{ old('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                        <option value="Partial" {{ old('payment_status') == 'Partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="purchase_date">Purchase Date</label>
                    <input type="datetime-local" name="purchase_date" id="purchase_date" class="form-control" value="{{ old('purchase_date', now()->format('Y-m-d\TH:i')) }}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="receive_date">Receive Date</label>
                    <input type="date" name="receive_date" id="receive_date" class="form-control" value="{{ old('receive_date') }}">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-3">Save Purchase</button>
        <a href="{{ route('purchases.history') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>

{{-- ------------------------------------------------ --}}
{{-- JavaScript for Calculation --}}
{{-- ------------------------------------------------ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initial calculation on load
    calculateTotals();
});

// Calculate Subtotal, Total Cost, and Due Amount
function calculateTotals() {
    // 1. Get Item Data
    let qty = parseFloat(document.getElementById('quantity').value) || 0;
    let price = parseFloat(document.getElementById('unit_price').value) || 0;

    // 💡 Subtotal (Base Cost for the single item)
    let subtotal = qty * price;
    document.getElementById('subtotal_amount').value = subtotal.toFixed(2);

    // 2. Get Header Adjustments
    let headerDiscount = parseFloat(document.getElementById('discount_amount').value) || 0;
    let tax = parseFloat(document.getElementById('tax_amount').value) || 0;
    let shipping = parseFloat(document.getElementById('shipping_cost').value) || 0;
    let paid = parseFloat(document.getElementById('paid_amount').value) || 0;

    // 3. Final Total Cost calculation
    // Total Cost = Subtotal - Discount + Tax + Shipping
    let totalCost = subtotal - headerDiscount + tax + shipping;
    document.getElementById('total_cost').value = totalCost.toFixed(2);

    // 4. Due Amount
    let dueAmount = totalCost - paid;
    document.getElementById('due_amount').value = dueAmount.toFixed(2);

    // 5. Update Payment Status based on paid amount
    if (paid >= totalCost) {
        document.getElementById('payment_status').value = 'Paid';
    } else if (paid > 0 && paid < totalCost) {
        document.getElementById('payment_status').value = 'Partial';
    } else {
        document.getElementById('payment_status').value = 'Due';
    }
}

// Attach event listener to set initial price when product changes
document.getElementById('product_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const price = selectedOption.getAttribute('data-price') || 0.00;
    document.getElementById('unit_price').value = parseFloat(price).toFixed(2);
    calculateTotals();
});

// Re-calculate totals whenever an input changes
document.querySelectorAll('#quantity, #unit_price, #discount_amount, #tax_amount, #shipping_cost, #paid_amount')
    .forEach(input => input.addEventListener('input', calculateTotals));

</script>
@endsection
