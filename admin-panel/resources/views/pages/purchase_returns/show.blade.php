@extends('master')

@section('content')
    <div class="container mt‑4">
        <h2>Purchase Return Details</h2>

        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td>{{ $return->id }}</td>
            </tr>
            <tr>
                <th>Purchase Invoice</th>
                <td>{{ $return->purchase->invoice_no ?? '-' }}</td>
            </tr>
            <tr>
                <th>Product Name</th>
                <td>{{ $return->product->name ?? $return->product_name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Total Quantity</th>
                <td>{{ $return->total_quantity }}</td>
            </tr>
            <tr>
                <th>Return Quantity</th>
                <td>{{ $return->return_quantity }}</td>
            </tr>
            <tr>
                <th>Subtotal Amount</th>
                <td>{{ number_format($return->subtotal_amount, 2) }}</td>
            </tr>
            <tr>
                <th>Tax Amount</th>
                <td>{{ number_format($return->tax_amount, 2) }}</td>
            </tr>
            <tr>
                <th>Shipping Cost</th>
                <td>{{ number_format($return->shipping_cost, 2) }}</td>
            </tr>
            <tr>
                <th>Refund Amount</th>
                <td>{{ number_format($return->refund_amount, 2) }}</td>
            </tr>
            <tr>
                <th>Net Refund</th>
                <td>{{ number_format($return->net_refund, 2) }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ ucfirst($return->status) }}</td>
            </tr>
            <tr>
                <th>Note</th>
                <td>{{ $return->note }}</td>
            </tr>
        </table>

        <a href="{{ route('purchase_returns.index') }}" class="btn btn-secondary mt‑2">Back</a>
    </div>
@endsection
