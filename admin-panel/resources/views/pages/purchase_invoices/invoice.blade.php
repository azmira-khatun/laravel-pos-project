@extends('master')

@section('content')
<div class="container mt-5">
    <div class="card p-4">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Invoice #{{ $purchaseInvoice->invoice_number }}</h2>
            <small>{{ \Carbon\Carbon::parse($purchaseInvoice->invoice_date)->format('d M Y, H:i') }}</small>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Purchase Info:</h5>
                <p><strong>Purchase ID:</strong> {{ $purchaseInvoice->purchase_id }}</p>
                <p><strong>Payment Status:</strong> {{ $purchaseInvoice->payment_status }}</p>
            </div>
            <div class="col-md-6 text-end">
                <h5>Company Info:</h5>
                <p>My Company Name</p>
                <p>Address Line 1</p>
                <p>City, Country</p>
            </div>
        </div>

        {{-- Purchase Items Table --}}
        @if($purchaseInvoice->purchase && $purchaseInvoice->purchase->items)
        <table class="table table-bordered mb-4">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Discount</th>
                    <th>Line Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $subtotal = 0;
                    $totalDiscount = 0;
                    $tax = $purchaseInvoice->purchase->tax_amount ?? 0;
                    $shipping = $purchaseInvoice->purchase->shipping_cost ?? 0;
                @endphp

                @foreach($purchaseInvoice->purchase->items as $item)
                    @php
                        $subtotal += $item->unit_price * $item->quantity;
                        $totalDiscount += $item->line_discount;
                    @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->product->name ?? '-' }}</td>
                    <td>{{ $item->productunit->name ?? '-' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ number_format($item->line_discount, 2) }}</td>
                    <td>{{ number_format($item->line_total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        {{-- Totals --}}
        @php
            $grandTotal = $subtotal - $totalDiscount + $tax + $shipping;
        @endphp

        <div class="d-flex justify-content-end">
            <table class="table table-borderless w-50">
                <tr>
                    <th>Subtotal:</th>
                    <td>{{ number_format($subtotal, 2) }}</td>
                </tr>
                <tr>
                    <th>Total Discount:</th>
                    <td>{{ number_format($totalDiscount, 2) }}</td>
                </tr>
                <tr>
                    <th>Tax:</th>
                    <td>{{ number_format($tax, 2) }}</td>
                </tr>
                <tr>
                    <th>Shipping:</th>
                    <td>{{ number_format($shipping, 2) }}</td>
                </tr>
                <tr>
                    <th>Grand Total:</th>
                    <td>{{ number_format($grandTotal, 2) }}</td>
                </tr>
                <tr>
                    <th>Due Amount:</th>
                    <td>{{ number_format($purchaseInvoice->due_amount, 2) }}</td>
                </tr>
            </table>
        </div>

        {{-- Buttons --}}
        <div class="text-center mt-4">
            <button class="btn btn-primary" onclick="window.print()">Print Invoice</button>
            <a href="{{ route('purchaseInvoices.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
