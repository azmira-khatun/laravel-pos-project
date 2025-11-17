@extends('master')

@section('content')
<div class="container mt-5">
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

    <form action="{{ route('salesitems.store') }}" method="POST">
        @csrf

        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Create New Sale (Multiple Products)</h4>
            </div>

            <div class="card-body">

                {{-- Customer & Payment Header --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Customer</label>
                        <select name="customer_id" class="form-select" required>
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method_id" class="form-select" required>
                            <option value="">Select Payment Method</option>
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method->id }}" {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>{{ $method->method_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-select">
                            <option value="Paid" {{ old('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                            <option value="Due" {{ old('payment_status') == 'Due' ? 'selected' : '' }}>Due</option>
                            <option value="Partial" {{ old('payment_status') == 'Partial' ? 'selected' : '' }}>Partial</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Paid Amount</label>
                        <input type="number" step="0.01" name="paid_amount" id="paid_amount" class="form-control" value="{{ old('paid_amount', 0) }}" min="0" oninput="calculateAll()">
                    </div>
                </div>

                {{-- Products Table --}}
                <h5 class="mt-4">Products</h5>
                <table class="table table-bordered" id="product_table">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th width="100">Unit</th>
                            <th width="80">Qty</th>
                            <th width="120">Unit Price</th>
                            <th width="120">Discount</th>
                            <th width="120">Line Total</th>
                            <th width="140">Batch & Expiry</th>
                            <th width="50">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="items[0][product_id]" class="form-select product-select" required onchange="updateProductDetails(this, 0)">
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="items[0][productunit_id]" class="form-select unit-select" required>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" name="items[0][quantity]" class="form-control qty" min="1" value="1" required oninput="calculateLineTotal(0)"></td>
                            <td><input type="number" name="items[0][unit_price]" step="0.01" class="form-control price" min="0" value="0.00" required oninput="calculateLineTotal(0)"></td>
                            <td>
                                <select name="items[0][discount_id]" class="form-select discount-select">
                                    <option value="">No Discount</option>
                                    @foreach($discounts as $discount)
                                        <option value="{{ $discount->id }}">{{ $discount->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" name="items[0][line_total]" step="0.01" class="form-control item-total" value="0.00" readonly></td>
                            <td>
                                <input type="text" name="items[0][batch_no]" class="form-control batch-no mb-1" placeholder="Batch No.">
                                <input type="date" name="items[0][expiry_date]" class="form-control expiry_date">
                            </td>
                            <td><button type="button" class="btn btn-danger btn-sm removeRow" onclick="removeRow(this)">X</button></td>
                        </tr>
                    </tbody>
                </table>

                <button type="button" class="btn btn-warning mb-3" id="addRow">+ Add Product</button>

                {{-- Totals Section (Header Discounts) --}}
                <div class="row g-3 mt-4">
                    <div class="col-md-4">
                        <label class="form-label">Subtotal</label>
                        <input type="number" step="0.01" name="subtotal_amount_header" id="subtotal" class="form-control" value="0.00" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Header Discount</label>
                        <input type="number" step="0.01" name="discount_amount_header" id="discount_amount" class="form-control" value="0" min="0" oninput="calculateAll()">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Header Tax</label>
                        <input type="number" step="0.01" name="tax_amount_header" id="tax_amount" class="form-control" value="0" min="0" oninput="calculateAll()">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Shipping Cost</label>
                        <input type="number" step="0.01" name="shipping_cost" id="shipping_cost" class="form-control" value="0" min="0" oninput="calculateAll()">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Total Cost</label>
                        <input type="number" step="0.01" name="total_cost" id="total_cost" class="form-control" value="0.00" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Due Amount</label>
                        <input type="number" step="0.01" name="due_amount" id="due_amount" class="form-control" value="0.00" readonly>
                    </div>
                </div>

                {{-- Sale Description (Header) --}}
                <div class="mt-3">
                    <label class="form-label">Description (for Sale Header)</label>
                    <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
                </div>

                <div class="mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Save Sale</button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- JS for Dynamic Row Management and Calculation --}}
<script>
let itemIndex = 0; // The index starts at 0 for the first row

document.addEventListener('DOMContentLoaded', () => {
    // Correct initial index to ensure first row starts at 0
    document.querySelector('#product_table tbody tr').setAttribute('data-index', itemIndex);
    itemIndex++;
    calculateAll();
});

// Calculate Line Total for a specific row
function calculateLineTotal(index) {
    const row = document.querySelector(`tr[data-index="${index}"]`);
    if (!row) return;

    let qty = parseFloat(row.querySelector('.qty').value) || 0;
    let price = parseFloat(row.querySelector('.price').value) || 0;

    // NOTE: Item-level discount/tax calculation is often complex and omitted here.
    // Assuming simple (Qty * Price) for Line Total for now.
    let total = qty * price;

    row.querySelector('.item-total').value = total.toFixed(2);

    // Trigger the grand total calculation
    calculateAll();
}

// Update Unit Price when a product is selected
function updateProductDetails(selectElement, index) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const row = selectElement.closest('tr');

    // Update Unit Price from product data attribute
    const priceInput = row.querySelector('.price');
    const price = selectedOption.getAttribute('data-price') || 0;
    priceInput.value = parseFloat(price).toFixed(2);

    // Recalculate line total for the changed row
    calculateLineTotal(index);
}

// Calculate Subtotal, Total Cost, and Due Amount
function calculateAll() {
    let subtotal = 0;
    document.querySelectorAll('.item-total').forEach(input => {
        subtotal += parseFloat(input.value) || 0;
    });

    document.getElementById('subtotal').value = subtotal.toFixed(2);

    let discount = parseFloat(document.getElementById('discount_amount').value) || 0;
    let tax = parseFloat(document.getElementById('tax_amount').value) || 0;
    let shipping = parseFloat(document.getElementById('shipping_cost').value) || 0;

    let totalCost = subtotal - discount + tax + shipping;
    document.getElementById('total_cost').value = totalCost.toFixed(2);

    let paid = parseFloat(document.getElementById('paid_amount').value) || 0;
    let dueAmount = totalCost - paid;
    document.getElementById('due_amount').value = dueAmount.toFixed(2);
}

// Add new row (using the correct index)
document.getElementById('addRow').addEventListener('click', () => {
    let table = document.querySelector('#product_table tbody');
    let newRow = table.rows[0].cloneNode(true);

    // Update row index and input names
    newRow.setAttribute('data-index', itemIndex);
    newRow.querySelectorAll('[name^="items[0]"]').forEach(input => {
        // Change name attribute: items[0][key] -> items[newIndex][key]
        input.name = input.name.replace(/items\[\d+\]/, `items[${itemIndex}]`);

        // Clear values (except select placeholders)
        if (input.type === 'number' || input.type === 'text' || input.type === 'date') {
            input.value = (input.classList.contains('qty') ? 1 : ''); // Default Qty to 1
        } else if (input.tagName === 'SELECT') {
             input.selectedIndex = 0;
        }
    });

    // Update event handlers with the new index
    newRow.querySelector('.product-select').setAttribute('onchange', `updateProductDetails(this, ${itemIndex})`);
    newRow.querySelector('.qty').setAttribute('oninput', `calculateLineTotal(${itemIndex})`);
    newRow.querySelector('.price').setAttribute('oninput', `calculateLineTotal(${itemIndex})`);
    newRow.querySelector('.removeRow').setAttribute('onclick', `removeRow(this)`);

    table.appendChild(newRow);
    itemIndex++;
    calculateAll();
});

// Remove row
function removeRow(button) {
    let rows = document.querySelectorAll('#product_table tbody tr');
    if (rows.length > 1) {
        button.closest('tr').remove();
        calculateAll();
    }
}
</script>
@endsection
