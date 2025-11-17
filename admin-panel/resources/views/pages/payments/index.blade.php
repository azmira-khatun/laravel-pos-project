@extends('master')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h2>Payments List</h2>
        <a href="{{ route('payments.create') }}" class="btn btn-primary">Add Payment</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Sale</th>
                        <th>Purchase</th>
                        <th>Method</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>User</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->sale?->id }}</td>
                            <td>{{ $payment->purchase?->id }}</td>
                            <td>{{ $payment->paymentMethod?->method_name }}</td>
                            <td>{{ number_format($payment->amount,2) }}</td>
                            <td>{{ $payment->payment_date }}</td>
                            <td>{{ $payment->user?->name }}</td>
                            <td>
                                <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No Payments Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $payments->links() }}
        </div>
    </div>
</div>
@endsection
