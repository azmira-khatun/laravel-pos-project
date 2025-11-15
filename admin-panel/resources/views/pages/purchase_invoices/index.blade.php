@extends('master')

@section('content')
<div class="container mt-4">
    <h2>Purchase Invoices</h2>

    <a href="{{ route('purchaseInvoices.create') }}" class="btn btn-success mb-3">+ New Invoice</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Invoice Number</th>
                <th>Purchase ID</th>
                <th>Invoice Date</th>
                <th>Total Amount</th>
                <th>Due Amount</th>
                <th>Payment Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($purchaseInvoices as $invoice)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->purchase_id }}</td>
                    <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') }}</td>
                    <td>{{ number_format($invoice->total_amount, 2) }}</td>
                    <td>{{ number_format($invoice->due_amount, 2) }}</td>
                    <td>{{ ucfirst($invoice->payment_status) }}</td>
                    <td>
                        <a href="{{ route('purchaseInvoices.show', $invoice->id) }}" class="btn btn-info btn-sm">View</a>
                        <form action="{{ route('purchaseInvoices.destroy', $invoice->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this invoice?');">
                                Delete
                            </button>
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

    {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $purchaseInvoices->links() }}
    </div>
</div>
@endsection
