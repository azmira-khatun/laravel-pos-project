@extends('master')

@section('content')
    <h1>Invoice Details (Invoice #{{ $invoice->invoice_number }})</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h4>General Info</h4>
            <div class="mb-3">
                <label class="form-label"><strong>Customer:</strong></label>
                <input type="text" class="form-control"
                       value="{{ $invoice->customer->name ?? '–' }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Invoice Date:</strong></label>
                <input type="text" class="form-control"
                       value="{{ $invoice->invoice_date }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Total Amount:</strong></label>
                <input type="text" class="form-control"
                       value="{{ $invoice->total_amount }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Due Amount:</strong></label>
                <input type="text" class="form-control"
                       value="{{ $invoice->due_amount }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Payment Status:</strong></label>
                <input type="text" class="form-control"
                       value="{{ $invoice->payment_status }}" readonly>
            </div>
        </div>
    </div>

    {{-- Sale Items Section --}}
    @if($invoice->sale && $invoice->sale->items->count())
        <div class="card mb-4">
            <div class="card-body">
                <h4>Sale Items</h4>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->sale->items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->quantity * $item->price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <p>No sale items found for this invoice.</p>
    @endif

    {{-- Payments Section --}}
    @if($invoice->payments && $invoice->payments->count())
        <div class="card mb-4">
            <div class="card-body">
                <h4>Payments</h4>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Payment Date</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->payments as $i => $payment)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $payment->payment_date }}</td>
                                <td>{{ $payment->amount }}</td>
                                <td>{{ $payment->method }}</td>
                                <td>{{ $payment->note }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <p>No payments have been made yet.</p>
    @endif

    <a href="{{ route('salesInvoiceIndex') }}" class="btn btn-secondary">Back to Invoice List</a>
@endsection
