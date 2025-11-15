@extends('master')

@section('content')
<div class="container mt-4">
    <h2>Edit Sale</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('sales.update', $sale->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="invoice_no" class="form-label">Invoice No</label>
            <input type="text" name="invoice_no" id="invoice_no" class="form-control"
                   value="{{ old('invoice_no', $sale->invoice_no) }}" required>
        </div>

        <div class="mb-3">
            <label for="sale_date" class="form-label">Sale Date</label>
            <input type="date" name="sale_date" id="sale_date" class="form-control"
                   value="{{ old('sale_date', \Carbon\Carbon::parse($sale->sale_date)->format('Y‑m‑d')) }}" required>
        </div>

        <div class="mb-3">
            <label for="total_amount" class="form-label">Total Amount</label>
            <input type="number" name="total_amount" id="total_amount" class="form-control"
                   step="0.01" value="{{ old('total_amount', $sale->total_amount) }}" required>
        </div>

        <div class="mb-3">
            <label for="payment_status" class="form-label">Payment Status</label>
            <select name="payment_status" id="payment_status" class="form-control">
                <option value="pending" {{ old('payment_status', $sale->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid"    {{ old('payment_status', $sale->payment_status) == 'paid'    ? 'selected' : '' }}>Paid</option>
                <option value="partial" {{ old('payment_status', $sale->payment_status) == 'partial' ? 'selected' : '' }}>Partial</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <input type="text" name="payment_method" id="payment_method" class="form-control"
                   value="{{ old('payment_method', $sale->payment_method) }}">
        </div>

        <div class="mb-3">
            <label for="note" class="form-label">Note (Optional)</label>
            <textarea name="note" id="note" class="form-control">{{ old('note', $sale->note) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Sale</button>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary ms‑2">Cancel</a>
    </form>
</div>
@endsection
