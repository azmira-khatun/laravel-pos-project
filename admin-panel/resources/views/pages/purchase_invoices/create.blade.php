@extends('master')

@section('content')
<div class="container mt-4">
    <h2>Create Purchase Invoice</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('purchaseInvoices.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="purchase_id">Purchase</label>
            <select name="purchase_id" id="purchase_id" class="form-control" required>
                <option value="">Select Purchase</option>
                @foreach($purchases as $purchase)
                    <option value="{{ $purchase->id }}">ID: {{ $purchase->id }} | Total: {{ number_format($purchase->total_cost,2) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="invoice_number">Invoice Number</label>
            <input type="text" name="invoice_number" id="invoice_number" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="invoice_date">Invoice Date</label>
            <input type="datetime-local" name="invoice_date" id="invoice_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="total_amount">Total Amount</label>
            <input type="number" step="0.01" name="total_amount" id="total_amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="due_amount">Due Amount</label>
            <input type="number" step="0.01" name="due_amount" id="due_amount" class="form-control" value="0">
        </div>

        <div class="mb-3">
            <label for="payment_status">Payment Status</label>
            <input type="text" name="payment_status" id="payment_status" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Save Invoice</button>
        <a href="{{ route('purchaseInvoices.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
