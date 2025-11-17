@extends('master')

@section('content')
<div class="container">
    <h2>Create New Sale</h2>

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

    <form action="{{ route('sales.store') }}" method="POST">
        @csrf

        {{-- Sale Details --}}
        <div class="card mb-4">
            <div class="card-header">Sale Information</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="customer_id" class="form-label">Customer</label>
                        <select name="customer_id" id="customer_id" class="form-select" required>
                            <option value="">Select Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="payment_method_id" class="form-label">Payment Method</label>
                        <select name="payment_method_id" id="payment_method_id" class="form-select" required>
                            <option value="">Select Method</option>
                            @foreach ($paymentMethods as $method)
<option value="{{ $method->id }}" {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>
    {{ $method->method_name }}
</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="payment_status" class="form-label">Payment Status</label>
                        <select name="payment_status" id="payment_status" class="form-select" required>
                            <option value="Paid" {{ old('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                            <option value="Due" {{ old('payment_status') == 'Due' ? 'selected' : '' }}>Due</option>
                            <option value="Partial" {{ old('payment_status') == 'Partial' ? 'selected' : '' }}>Partial</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="paid_amount" class="form-label">Paid Amount</label>
                        <input type="number" step="0.01" min="0" name="paid_amount" id="paid_amount" class="form-control" value="{{ old('paid_amount', 0) }}" required oninput="calculateTotals()">
                    </div>
                </div>
            </div>
        </div>

        {{-- Sale Items (Multi-product form) --}}
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                Products
                <button type="button" class="btn btn-sm btn-success" onclick="addItem()">+ Add Product</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th style="width: 15%;">Unit Price</th>
                            <th style="width: 10%;">Quantity</th>
                            <th style="width: 15%;">Line Total</th>
                            <th style="width: 5%;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Product rows will be inserted here by JavaScript --}}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                            <td colspan="2"><span id="subtotal-display">$0.00</span></td>
                            <input type="hidden" name="subtotal_amount" id="subtotal_amount_input" value="0">
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Calculation/Adjustment Fields --}}
        <div class="card mb-4">
            <div class="card-header">Adjustments & Final Total</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="discount_amount" class="form-label">Discount Amount</label>
                        <input type="number" step="0.01" min="0" name="discount_amount" id="discount_amount" class="form-control" value="{{ old('discount_amount', 0) }}" oninput="calculateTotals()">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tax_amount" class="form-label">Tax Amount</label>
                        <input type="number" step="0.01" min="0" name="tax_amount" id="tax_amount" class="form-control" value="{{ old('tax_amount', 0) }}" oninput="calculateTotals()">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="shipping_cost" class="form-label">Shipping Cost</label>
                        <input type="number" step="0.01" min="0" name="shipping_cost" id="shipping_cost" class="form-control" value="{{ old('shipping_cost', 0) }}" oninput="calculateTotals()">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <h4>Grand Total: <span id="total-cost-display">$0.00</span></h4>
                        <input type="hidden" name="total_cost" id="total_cost_input" value="0">
                    </div>
                    <div class="col-md-6">
                        <h4>Due Amount: <span id="due-amount-display">$0.00</span></h4>
                        <input type="hidden" name="due_amount" id="due_amount_input" value="0">
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg">Save Sale</button>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary btn-lg">Cancel</a>
    </form>
</div>

<script>
    const products = @json($products);
    let itemIndex = 0;

    /**
     * Adds a new product row to the sales items table.
     */
    function addItem() {
        const tableBody = document.querySelector('#items-table tbody');
        const newRow = tableBody.insertRow();
        newRow.setAttribute('data-index', itemIndex);

        // Product Select Cell
        let productCell = newRow.insertCell();
        let productSelectHtml = `
            <select name="items[${itemIndex}][product_id]" class="form-select product-select" required onchange="updateUnitPrice(this)">
                <option value="">Select Product</option>
                ${products.map(p => `<option value="${p.id}" data-price="${p.price}">${p.name} ($${p.price})</option>`).join('')}
            </select>
        `;
        productCell.innerHTML = productSelectHtml;

        // Unit Price Cell
        let priceCell = newRow.insertCell();
        priceCell.innerHTML = `<input type="number" step="0.01" min="0" name="items[${itemIndex}][unit_price]" class="form-control unit-price" value="0" required oninput="calculateLineTotal(${itemIndex})">`;

        // Quantity Cell
        let quantityCell = newRow.insertCell();
        quantityCell.innerHTML = `<input type="number" step="1" min="1" name="items[${itemIndex}][quantity]" class="form-control quantity" value="1" required oninput="calculateLineTotal(${itemIndex})">`;

        // Line Total Cell
        let lineTotalCell = newRow.insertCell();
        lineTotalCell.innerHTML = `<span class="line-total-display">$0.00</span><input type="hidden" class="line-total-input" value="0">`;

        // Action Cell
        let actionCell = newRow.insertCell();
        actionCell.innerHTML = `<button type="button" class="btn btn-sm btn-danger" onclick="removeItem(${itemIndex})">X</button>`;

        itemIndex++;
        calculateTotals();
    }

    /**
     * Removes a product row from the sales items table.
     * @param {number} index - The index of the row to remove.
     */
    function removeItem(index) {
        document.querySelector(`tr[data-index="${index}"]`).remove();
        calculateTotals();
    }

    /**
     * Updates the Unit Price input when a product is selected.
     * @param {HTMLElement} selectElement - The product select dropdown element.
     */
    function updateUnitPrice(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const row = selectElement.closest('tr');
        const priceInput = row.querySelector('.unit-price');
        const price = selectedOption.getAttribute('data-price') || 0;

        priceInput.value = parseFloat(price).toFixed(2);
        calculateLineTotal(row.getAttribute('data-index'));
    }

    /**
     * Calculates the line total for a single row and updates the total.
     * @param {number} index - The index of the row to calculate.
     */
    function calculateLineTotal(index) {
        const row = document.querySelector(`tr[data-index="${index}"]`);
        if (!row) return;

        const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
        const price = parseFloat(row.querySelector('.unit-price').value) || 0;
        const lineTotal = quantity * price;

        row.querySelector('.line-total-display').textContent = '$' + lineTotal.toFixed(2);
        row.querySelector('.line-total-input').value = lineTotal.toFixed(2);

        calculateTotals();
    }

    /**
     * Recalculates Subtotal, Grand Total, and Due Amount.
     */
    function calculateTotals() {
        let subtotal = 0;
        document.querySelectorAll('.line-total-input').forEach(input => {
            subtotal += parseFloat(input.value);
        });

        // Get adjustments
        const discount = parseFloat(document.getElementById('discount_amount').value) || 0;
        const tax = parseFloat(document.getElementById('tax_amount').value) || 0;
        const shipping = parseFloat(document.getElementById('shipping_cost').value) || 0;
        const paidAmount = parseFloat(document.getElementById('paid_amount').value) || 0;

        // Calculate final totals
        const totalCost = subtotal - discount + tax + shipping;
        const dueAmount = totalCost - paidAmount;

        // Update displays and hidden inputs
        document.getElementById('subtotal-display').textContent = '$' + subtotal.toFixed(2);
        document.getElementById('subtotal_amount_input').value = subtotal.toFixed(2);

        document.getElementById('total-cost-display').textContent = '$' + totalCost.toFixed(2);
        document.getElementById('total_cost_input').value = totalCost.toFixed(2);

        document.getElementById('due-amount-display').textContent = '$' + dueAmount.toFixed(2);
        document.getElementById('due_amount_input').value = dueAmount.toFixed(2);
    }

    // Initialize with one item on page load
    document.addEventListener('DOMContentLoaded', addItem);
</script>
@endsection
