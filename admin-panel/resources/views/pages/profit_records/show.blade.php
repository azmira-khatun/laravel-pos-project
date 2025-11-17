@extends('master')

@section('content')
<div class="container mt-4">

    <h2>Profit / Loss Details</h2>
    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">Back</a>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th>Sale Item ID</th>
                    <td>#{{ $profitRecord->saleItem?->id ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Product</th>
                    <td>{{ $profitRecord->product?->name ?? 'N/A' }}</td>
                </tr>

                <tr>
                    <th>Cost Price</th>
                    <td>{{ number_format($profitRecord->cost_price, 2) }}</td>
                </tr>

                <tr>
                    <th>Selling Price</th>
                    <td>{{ number_format($profitRecord->selling_price, 2) }}</td>
                </tr>

                <tr>
                    <th>Profit Amount</th>
                    <td>
                        @if($profitRecord->profit_amount >= 0)
                            <span class="text-success">{{ number_format($profitRecord->profit_amount, 2) }} (Profit)</span>
                        @else
                            <span class="text-danger">{{ number_format($profitRecord->profit_amount, 2) }} (Loss)</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Profit Margin (%)</th>
                    <td>
                        @php
                            $margin = $profitRecord->cost_price > 0
                                ? ($profitRecord->profit_amount / $profitRecord->cost_price) * 100
                                : 0;
                        @endphp
                        {{ number_format($margin, 2) }} %
                    </td>
                </tr>

                <tr>
                    <th>Record Date</th>
                    <td>{{ $profitRecord->record_date }}</td>
                </tr>
            </table>

        </div>
    </div>

</div>
@endsection
