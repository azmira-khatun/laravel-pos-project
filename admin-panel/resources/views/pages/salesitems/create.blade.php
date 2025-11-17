@extends('master')

@section('content')
<div class="container mt-5">
    <form action="{{ route('salesitems.store') }}" method="POST">
        @csrf

        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Create New Sale (Multiple Products)</h4>
            </div>

            <div class="card-body">

                {{-- Customer --}}
                <div class="mb-3">
                    <label class="form-label">Customer</label>
                    <select name="customer_id" class="form-select" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Products Table --}}
                <h5 class="mt-4">Products</h5>
                <table class="table table-bordered" id="product_table">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th width="80">Qty</th>
                            <th width="120">Unit Price</th>
                            <th width="120">Line Total</th>
                            <th width="140">Expiry Date</th>
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
                            <td><input type="number" name="quantity[]" class="form-control qty" min="1" required></td>
                            <td><input type="number" name="unit_price[]" step="0.01" class="form-control price" min="0" required></td>
                            <td><input type="number" name="line_total[]" step="0.01" class="form-control total" readonly></td>
                            <td><input type="date" name="expiry_date[]" class="form-control expiry_date"></td>
                            <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
                        </tr>
                    </tbody>
                </table>

                <button type="button" class="btn btn-warning mb-3" id="addRow">+ Add Product</button>

                {{-- Payment Section --}}
                <div class="row g-3 mt-4">
                    <div class="col-md-4">
                        <label class="form-label">Subtotal</label>
                        <input type="number" step="0.01" name="subtotal_amount" id="subtotal" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Discount</label>
                        <input type="number" step="0.01" name="discount_amount" id="discount_amount" class="form-control" value="0" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tax</label>
                        <input type="number" step="0.01" name="tax_amount" id="tax_amount" class="form-control" value="0" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Shipping Cost</label>
                        <input type="number" step="0.01" name="shipping_cost" id="shipping_cost" class="form-control" value="0" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Total Cost</label>
                        <input type="number" step="0.01" name="total_cost" id="total_cost" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Paid Amount</label>
                        <input type="number" step="0.01" name="paid_amount" id="paid_amount" class="form-control" value="0" min="0">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Due Amount</label>
                        <input type="number" step="0.01" name="due_amount" id="due_amount" class="form-control" readonly>
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="mt-3">
                    <label class="form-label">Payment Method</label>
                    <select name="payment_method_id" class="form-select" required>
                        <option value="">Select Payment Method</option>
                        @foreach($paymentMethods as $method)
                            <option value="{{ $method->id }}">{{ $method->method_name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Payment Status --}}
                <div class="mt-3">
                    <label class="form-label">Payment Status</label>
                    <select name="payment_status" class="form-select">
                        <option value="Paid">Paid</option>
                        <option value="Due">Due</option>
                    </select>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button class="btn btn-success">Save Sale</button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- JS --}}
<script>
document.addEventListener('input', calculateAll);

function calculateAll() {
    let subtotal = 0;
    document.querySelectorAll('#product_table tbody tr').forEach(row => {
        let qty = parseFloat(row.querySelector('.qty').value) || 0;
        let price = parseFloat(row.querySelector('.price').value) || 0;
        let total = qty * price;
        row.querySelector('.total').value = total.toFixed(2);
        subtotal += total;
    });

    document.getElementById('subtotal').value = subtotal.toFixed(2);

    let discount = parseFloat(document.getElementById('discount_amount').value) || 0;
    let tax = parseFloat(document.getElementById('tax_amount').value) || 0;
    let shipping = parseFloat(document.getElementById('shipping_cost').value) || 0;

    let totalCost = subtotal - discount + tax + shipping;
    document.getElementById('total_cost').value = totalCost.toFixed(2);

    let paid = parseFloat(document.getElementById('paid_amount').value) || 0;
    document.getElementById('due_amount').value = (totalCost - paid).toFixed(2);
}

// Add new row
document.getElementById('addRow').addEventListener('click', () => {
    let table = document.querySelector('#product_table tbody');
    let newRow = table.rows[0].cloneNode(true);
    newRow.querySelectorAll('input').forEach(i => i.value = '');
    newRow.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
    table.appendChild(newRow);
});

// Remove row
document.addEventListener('click', e => {
    if (e.target.classList.contains('removeRow')) {
        let rows = document.querySelectorAll('#product_table tbody tr');
        if (rows.length > 1) {
            e.target.closest('tr').remove();
            calculateAll();
        }
    }
});
</script>
@endsection
