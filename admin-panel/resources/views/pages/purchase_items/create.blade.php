@extends('master')

@section('content')
<div class="container mt-5">
<form action="{{ route('purchase_items.store') }}" method="POST">
        @csrf

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Create New Purchase (Multiple Products)</h4>
            </div>

            <div class="card-body">

                {{-- Vendor --}}
                <div class="mb-3">
                    <label class="form-label">Vendor</label>
                    <select name="vendor_id" class="form-select" required>
                        <option value="">Select Vendor</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </div>







                {{-- Dynamic Product Rows --}}
                <h5 class="mt-4">Products</h5>

                <table class="table table-bordered" id="product_table">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th width="120">Qty</th>
                            <th width="150">Unit Price</th>
                            <th width="150">Discount</th>
                            <th width="150">Line Total</th>
                            <th width="50">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="product_id[]" class="form-select" required>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td><input type="number" name="quantity[]" class="form-control qty" required></td>

                            <td><input type="number" name="unit_price[]" step="0.01" class="form-control price" required></td>

                            <td><input type="number" name="line_discount[]" step="0.01" class="form-control discount" value="0"></td>

                            <td><input type="number" name="line_total[]" step="0.01" class="form-control total" readonly></td>

                            <td>
                                <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <button type="button" class="btn btn-warning" id="addRow">+ Add Product</button>

                {{-- Payment Section --}}
                <div class="row mt-4">
                    <div class="col-md-4">
                        <label class="form-label">Subtotal</label>
                        <input type="number" step="0.01" name="subtotal_amount" id="subtotal" class="form-control" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Discount</label>
                        <input type="number" step="0.01" name="discount_amount" id="discount_amount" class="form-control" value="0">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tax</label>
                        <input type="number" step="0.01" name="tax_amount" id="tax_amount" class="form-control" value="0">
                    </div>

                    <div class="col-md-4 mt-3">
                        <label class="form-label">Shipping Cost</label>
                        <input type="number" step="0.01" name="shipping_cost" id="shipping_cost" class="form-control" value="0">
                    </div>

                    <div class="col-md-4 mt-3">
                        <label class="form-label">Total Cost</label>
                        <input type="number" step="0.01" name="total_cost" id="total_cost" class="form-control" readonly>
                    </div>

                    <div class="col-md-4 mt-3">
                        <label class="form-label">Paid Amount</label>
                        <input type="number" step="0.01" name="paid_amount" id="paid_amount" class="form-control" value="0">
                    </div>

                    <div class="col-md-4 mt-3">
                        <label class="form-label">Due Amount</label>
                        <input type="number" step="0.01" name="due_amount" id="due_amount" class="form-control" readonly>
                    </div>

                </div>

                {{-- Payment --}}
                <div class="mt-3">
                    <label class="form-label">Payment Method</label>
                <select name="payment_method_id" class="form-select" required>
    <option value="">Select Payment Method</option>
    @foreach($paymentMethods as $method)
        <option value="{{ $method->id }}">{{ $method->method_name }}</option>
    @endforeach
</select>


                </div>

                <div class="mt-3">
                    <label class="form-label">Payment Status</label>
                    <select name="payment_status" class="form-select">
                        <option value="Paid">Paid</option>
                        <option value="Due">Due</option>
                    </select>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button class="btn btn-success">Save Purchase</button>
                </div>

            </div>
        </div>
    </form>
</div>

{{-- JS --}}
<script>
document.addEventListener('input', function() {
    calculateAll();
});

function calculateAll() {
    let subtotal = 0;

    document.querySelectorAll('#product_table tbody tr').forEach(row => {
        let qty = parseFloat(row.querySelector('.qty').value) || 0;
        let price = parseFloat(row.querySelector('.price').value) || 0;
        let discount = parseFloat(row.querySelector('.discount').value) || 0;

        let total = (qty * price) - discount;
        row.querySelector('.total').value = total.toFixed(2);

        subtotal += total;
    });

    document.getElementById('subtotal').value = subtotal.toFixed(2);

    let discountAmount = parseFloat(document.getElementById('discount_amount').value) || 0;
    let tax = parseFloat(document.getElementById('tax_amount').value) || 0;
    let shipping = parseFloat(document.getElementById('shipping_cost').value) || 0;

    let totalCost = subtotal - discountAmount + tax + shipping;
    document.getElementById('total_cost').value = totalCost.toFixed(2);

    let paid = parseFloat(document.getElementById('paid_amount').value) || 0;
    document.getElementById('due_amount').value = (totalCost - paid).toFixed(2);
}

document.getElementById('addRow').addEventListener('click', function () {
    let table = document.querySelector('#product_table tbody');
    let newRow = table.rows[0].cloneNode(true);

    newRow.querySelectorAll('input').forEach(i => i.value = '');
    newRow.querySelector('.discount').value = 0;

    table.appendChild(newRow);
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('removeRow')) {
        let row = e.target.closest('tr');
        if (document.querySelectorAll('#product_table tbody tr').length > 1) {
            row.remove();
            calculateAll();
        }
    }
});
</script>

@endsection
