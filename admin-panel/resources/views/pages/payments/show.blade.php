@extends('master')

@section('content')
<div class="container mt-4">

    <h2>Payment Details</h2>

    <a href="{{ route('payments.index') }}" class="btn btn-secondary mb-3">Back</a>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th>ID</th><td>{{ $payment->id }}</td>
                </tr>
                <tr>
                    <th>Sale</th><td>{{ $payment->sale?->id }}</td>
                </tr>
                <tr>
                    <th>Purchase</th><td>{{ $payment->purchase?->id }}</td>
                </tr>
                <tr>
                    <th>Method</th><td>{{ $payment->paymentMethod?->method_name }}</td>
                </tr>
                <tr>
                    <th>Amount</th><td>{{ $payment->amount }}</td>
                </tr>
                <tr>
                    <th>Date</th><td>{{ $payment->payment_date }}</td>
                </tr>
                <tr>
                    <th>User</th><td>{{ $payment->user?->name }}</td>
                </tr>
            </table>

        </div>
    </div>

</div>
@endsection
