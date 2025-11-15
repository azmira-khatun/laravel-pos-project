@extends('master')

@section('content')
    <h1>Sales Invoices</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Invoice Number</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Total Amount</th>
                <th>Due Amount</th>
                <th>Payment Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($invoices as $invoice)
            <tr>
                <td>{{ $invoice->id }}</td>
                <td>{{ $invoice->invoice_number }}</td>
                <td>{{ $invoice->customer->name ?? $invoice->customer_id }}</td>
                <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') }}</td>
                <td>{{ $invoice->total_amount }}</td>
                <td>{{ $invoice->due_amount }}</td>
                <td>{{ $invoice->payment_status }}</td>
                <td>
                    <a href="{{ route('salesInvoiceShow', $invoice->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('salesInvoiceEdit', $invoice->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('salesInvoiceDelete', $invoice->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">No invoices found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
