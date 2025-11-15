@extends('master')

@section('content')
<div class="container mt-4">
    <h2>Edit Sale Item</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sales.items.update', $saleItem->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="product_id" class="form-label">Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ $product->id == $saleItem->product_id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control"
                   value="{{ old('quantity', $saleItem->quantity) }}" min="1" required>
        </div>

        <div class="mb-3">
            <label for="unit_price" class="form-label">Unit Price</label>
            <input type="number" name="unit_price" id="unit_price" class="form-control"
                   step="0.01" value="{{ old('unit_price', $saleItem->unit_price) }}" required>
        </div>

        <div class="mb-3">
            <label for="total_price" class="form-label">Total Price</label>
            <input type="number" name="total_price" id="total_price" class="form-control"
                   step="0.01" value="{{ old('total_price', $saleItem->total_price) }}" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Update Item</button>
        <a href="{{ route('sales.items.index') }}" class="btn btn-secondary ms-2">Cancel</a>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const qtyInput      = document.getElementById('quantity');
            const unitPriceInp  = document.getElementById('unit_price');
            const totalPriceInp = document.getElementById('total_price');

            function recalc(){
                const qty  = parseFloat(qtyInput.value)      || 0;
                const up   = parseFloat(unitPriceInp.value)  || 0;
                totalPriceInp.value = (qty * up).toFixed(2);
            }

            qtyInput.addEventListener('input', recalc);
            unitPriceInp.addEventListener('input', recalc);
            recalc();
        });
    </script>
</div>
@endsection
