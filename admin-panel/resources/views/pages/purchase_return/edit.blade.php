@extends('master')

@section('content')
    <div class="container mt-4">
        <h2>Edit Purchase Return</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('purchase_returns.update', $return->id) }}" method="POST" id="returnForm">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="purchase_id" class="form-label">Select Purchase</label>
                <select name="purchase_id" id="purchase_id" class="form-control" required>
                    <option value="">-- Select Purchase --</option>
                    @foreach($purchases as $p)
                        <option value="{{ $p->id }}"
                                {{ $p->id == old('purchase_id', $return->purchase_id) ? 'selected' : '' }}>
                            {{ $p->invoice_no }} (ID: {{ $p->id }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" name="product_name" id="product_name"
                       class="form-control" readonly
                       value="{{ old('product_name', $return->product_name) }}">
            </div>

            <div class="mb‑3">
                <label class="form-label">Total Purchased Quantity</label>
                <input type="text" id="total_quantity" name="total_quantity"
                       class="form-control" readonly
                       value="{{ old('total_quantity', $return->total_quantity) }}">
            </div>

            <div class="mb-3">
                <label for="return_quantity" class="form-label">Return Quantity</label>
                <input type="number" name="return_quantity" id="return_quantity"
                       class="form-control"
                       min="1"
                       value="{{ old('return_quantity', $return->return_quantity) }}"
                       required>
            </div>

            <div class="mb-3">
                <label for="subtotal_amount" class="form-label">Subtotal Amount</label>
                <input type="text" id="subtotal_amount" name="subtotal_amount"
                       class="form-control" readonly
                       value="{{ old('subtotal_amount', $return->subtotal_amount) }}">
            </div>

            <div class="mb-3">
                <label for="tax_amount" class="form-label">Tax Amount</label>
                <input type="text" id="tax_amount" name="tax_amount"
                       class="form-control" readonly
                       value="{{ old('tax_amount', $return->tax_amount) }}">
            </div>

            <div class="mb-3">
                <label for="shipping_cost_adjustment" class="form-label">Shipping Cost</label>
                <input type="text" id="shipping_cost_adjustment" name="shipping_cost_adjustment"
                       class="form-control" readonly
                       value="{{ old('shipping_cost_adjustment', $return->shipping_cost) }}">
            </div>

            <div class="mb-3">
                <label for="refund_amount" class="form-label">Refund Amount</label>
                <input type="text" id="refund_amount" name="refund_amount"
                       class="form-control" readonly
                       value="{{ old('refund_amount', $return->refund_amount) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Net Refund</label>
                <input type="text" id="net_refund" name="net_refund"
                       class="form-control" readonly
                       value="{{ old('net_refund', $return->net_refund) }}">
            </div>

            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-control" required>
                    <option value="">-- Select Payment Method --</option>
                    <option value="Cash"           {{ old('payment_method', $return->payment_method) == 'Cash'           ? 'selected' : '' }}>Cash</option>
                    <option value="Bank"           {{ old('payment_method', $return->payment_method) == 'Bank'           ? 'selected' : '' }}>Bank</option>
                    <option value="Card"           {{ old('payment_method', $return->payment_method) == 'Card'           ? 'selected' : '' }}>Card</option>
                    <option value="Mobile Payment" {{ old('payment_method', $return->payment_method) == 'Mobile Payment' ? 'selected' : '' }}>Mobile Payment</option>
                    <option value="Other"          {{ old('payment_method', $return->payment_method) == 'Other'          ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="pending"   {{ old('status', $return->status) == 'pending'   ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ old('status', $return->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ old('status', $return->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea name="note" id="note" class="form-control" rows="3">{{ old('note', $return->note) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Return</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const purchaseSelect   = document.getElementById('purchase_id');
            const productNameField = document.getElementById('product_name');
            const totalQtyField    = document.getElementById('total_quantity');
            const subtotalField    = document.getElementById('subtotal_amount');
            const taxField         = document.getElementById('tax_amount');
            const shippingField    = document.getElementById('shipping_cost_adjustment');
            const returnQtyInput   = document.getElementById('return_quantity');
            const refundField      = document.getElementById('refund_amount');
            const netRefundField   = document.getElementById('net_refund');

            let totalQty = parseFloat(totalQtyField.value) || 1;
            let subtotal = parseFloat(subtotalField.value) || 0;
            let tax      = parseFloat(taxField.value)      || 0;
            let shipping = parseFloat(shippingField.value) || 0;

            purchaseSelect.addEventListener('change', function () {
                const pid = this.value;
                if (!pid) {
                    productNameField.value = '';
                    totalQtyField.value   = '';
                    subtotalField.value   = '';
                    taxField.value        = '';
                    shippingField.value   = '';
                    refundField.value     = '';
                    netRefundField.value  = '';
                    return;
                }

                fetch("{{ route('purchase_returns.fetch_purchase_data') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ purchase_id: pid })
                })
                .then(res => res.json())
                .then(data => {
                    productNameField.value = data.product_name || '';
                    totalQty  = parseFloat(data.total_quantity)    || 1;
                    subtotal  = parseFloat(data.subtotal_amount)   || 0;
                    tax       = parseFloat(data.tax_amount)        || 0;
                    shipping  = parseFloat(data.shipping_cost)     || 0;

                    totalQtyField.value   = totalQty;
                    subtotalField.value   = subtotal.toFixed(2);
                    taxField.value        = tax.toFixed(2);
                    shippingField.value   = shipping.toFixed(2);

                    calculateRefund();
                })
                .catch(err => {
                    console.error('Fetch error:', err);
                });
            });

            function calculateRefund() {
                const returnQty = parseFloat(returnQtyInput.value) || 0;

                const refund           = (subtotal / (totalQty || 1)) * returnQty;
                const proportionalTax  = (tax      / (totalQty || 1)) * returnQty;
                const proportionalShip = (shipping / (totalQty || 1)) * returnQty;
                const netRefundCalc    = refund - (proportionalTax + proportionalShip);

                refundField.value     = refund.toFixed(2);
                netRefundField.value  = netRefundCalc.toFixed(2);
            }

            returnQtyInput.addEventListener('input', calculateRefund);
        });
    </script>
@endsection
