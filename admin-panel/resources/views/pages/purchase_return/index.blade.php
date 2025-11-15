@extends('master')

@section('content')
    <div class="container mt-4">
        <h2>Purchase Return List</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('purchase_returns.create') }}" class="btn btn-primary mb-3">+ New Return</a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Purchase Invoice</th>
                    <th>Total Qty</th>
                    <th>Return Qty</th>
                    <th>Refund</th>
                    <th>Net Refund</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($returns as $r)
                    <tr>
                        <td>{{ $r->id }}</td>
                        <td>{{ $r->purchase->invoice_no ?? '-' }}</td>
                        <td>{{ number_format($r->total_quantity) }}</td>
                        <td>{{ number_format($r->return_quantity) }}</td>
                        <td>{{ number_format($r->refund_amount, 2) }}</td>
                        <td>{{ number_format($r->net_refund, 2) }}</td>
                        <td>{{ ucfirst($r->status) }}</td>
                        <td>
                            <a href="{{ route('purchase_returns.show', $r->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('purchase_returns.edit', $r->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('purchase_returns.destroy', $r->id) }}" method="POST"
                                  style="display:inline-block;"
                                  onsubmit="return confirm('Are you sure you want to delete this return?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No purchase returns found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
