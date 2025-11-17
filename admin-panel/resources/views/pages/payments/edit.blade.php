@extends('master')

@section('content')
<div class="container mt-4">

    <h2>Edit Payment</h2>

    <a href="{{ route('payments.index') }}" class="btn btn-secondary mb-3">Back</a>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('payments.update', $payment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label>Sale</label>
                        <select name="sale_id" class="form-select">
                            <option value="">-- Select Sale --</option>
                            @foreach($sales as $sale)
                                <option value="{{ $sale->id }}" {{ $payment->sale_id == $sale->id ? 'selected' : '' }}>
                                    {{ $sale->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Purchase</label>
                        <select name="purchase_id" class="form-select">
                            <option value="">-- Select Purchase --</option>
                            @foreach($purchases as $purchase)
                                <option value="{{ $purchase->id }}" {{ $payment->purchase_id == $purchase->id ? 'selected' : '' }}>
                                    {{ $purchase->id }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Payment Method *</label>
                        <select name="payment_method_id" class="form-select" required>
                            <option value="">-- Select Method --</option>
                            @foreach($methods as $method)
                                <option value="{{ $method->id }}" {{ $payment->payment_method_id == $method->id ? 'selected' : '' }}>
                                    {{ $method->method_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label>Amount *</label>
                        <input type="number" step="0.01" name="amount" class="form-control" value="{{ $payment->amount }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Payment Date</label>
                        <input type="datetime-local" name="payment_date" class="form-control"
                               value="{{ date('Y-m-d\TH:i', strtotime($payment->payment_date)) }}">
                    </div>

                </div>

                <button class="btn btn-primary">Update Payment</button>
            </form>

        </div>
    </div>

</div>
@endsection
