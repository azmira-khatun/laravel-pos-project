{{-- resources/views/pages/sales/create.blade.php --}}
@extends('master')

@section('content')
<div class="container mt-4">
    <h2>New Sale</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('sales.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="customer_id" class="form-label">Customer</label>
            <select name="customer_id" id="customer_id" class="form-control">
                <option value="">-- Select Customer --</option>
                @foreach(\App\Models\Customer::all() as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="invoice_no" class="form-label">Invoice No</label>
            <input type="text" name="invoice_no" id="invoice_no" class="form-control" value="{{ old('invoice_no') }}" required>
        </div>

        <div class="mb-3">
            <label for="sale_date" class="form-label">Sale Date</label>
            <input type="date" name="sale_date" id="sale_date" class="form-control" value="{{ old('sale_date', date('Y‑m‑d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select name="type" id="type" class="form-control" required>
                <option value="sale">Sale</option>
                <option value="sale_return">Return</option>
            </select>
        </div>

        <hr>

        <h5>Items</h5>
        <div id="items_container">
            <div class="row mb‑3 item-row">
                <div class="col-md-4">
                    <label class="form-label">Product</label>
                    <select name="items[0][product_id]" class="form-control product-select" required>
                        <option value="">-- Select Product --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="items[0][quantity]" class="form-control quantity-input" value="1" min="1" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Unit Price</label>
                    <input type="number" name="items[0][unit_price]" class="form-control unit-price-input" step="0.01" value="0" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Total Price</label>
                    <input type="number" name="items[0][total_price]" class="form-control total-price-input" step="0.01" value="0" readonly>
                </div>
                <div class="col-md-1 d‑flex align‑items‑end">
                    <button type="button" class="btn btn‑danger remove-item" style="display:none;">X</button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-info mb‑3" id="add_item">Add Another Item</button>

        <div class="mb‑3">
            <label for="total_amount" class="form-label">Total Amount</label>
            <input type="number" name="total_amount" id="total_amount" class="form-control" step="0.01" value="{{ old('total_amount', 0) }}" required>
        </div>

        <div class="mb‑3">
            <label for="payment_status" class="form-label">Payment Status</label>
            <select name="payment_status" id="payment_status" class="form-control">
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
                <option value="partial">Partial</option>
            </select>
        </div>

        <div class="mb‑3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <input type="text" name="payment_method" id="payment_method" class="form-control" value="{{ old('payment_method') }}">
        </div>

        <div class="mb‑3">
            <label for="note" class="form-label">Note (Optional)</label>
            <textarea name="note" id="note" class="form-control">{{ old('note') }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const itemsContainer  = document.getElementById('items_container');
        const addItemBtn      = document.getElementById('add_item');
        const totalAmountInp   = document.getElementById('total_amount');

        function recalcRow(row) {
            const qty   = parseFloat(row.querySelector('.quantity-input').value) || 0;
            const up    = parseFloat(row.querySelector('.unit-price-input').value) || 0;
            const total = qty * up;
            row.querySelector('.total-price-input').value = total.toFixed(2);
            recalcGrand();
        }

        function recalcGrand(){
            let grand = 0;
            itemsContainer.querySelectorAll('.item-row').forEach(row=>{
                const val = parseFloat(row.querySelector('.total-price-input').value) || 0;
                grand += val;
            });
            totalAmountInp.value = grand.toFixed(2);
        }

        addItemBtn.addEventListener('click', function(){
            const index = itemsContainer.querySelectorAll('.item-row').length;
            const template = itemsContainer.querySelector('.item-row').cloneNode(true);
            template.querySelectorAll('input, select').forEach(elem=>{
                if(elem.name.includes('quantity')) elem.value = 1;
                else if(elem.name.includes('unit_price')) elem.value = 0;
                else if(elem.name.includes('total_price')) elem.value = 0;
                if(elem.classList.contains('remove-item')) elem.style.display = 'inline‑block';
            });
            itemsContainer.appendChild(template);
        });

        itemsContainer.addEventListener('input', function(e){
            if(e.target.matches('.quantity-input, .unit-price-input')) {
                recalcRow(e.target.closest('.item-row'));
            }
        });

        itemsContainer.addEventListener('click', function(e){
            if(e.target.matches('.remove-item')){
                const row = e.target.closest('.item-row');
                if(itemsContainer.querySelectorAll('.item-row').length > 1){
                    row.remove();
                    recalcGrand();
                }
            }
        });

        // রিফ্রেশ ফর্মের শুরুতেই
        recalcGrand();
    });
</script>
@endsection
