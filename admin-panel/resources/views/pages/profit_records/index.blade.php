@extends('master')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h2>Profit / Loss Summary</h2>
        <a href="{{ route('profit-records.create') }}" class="btn btn-primary">Add New Record</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Sale Item</th>
                        <th>Product</th>
                        <th>Cost Price</th>
                        <th>Selling Price</th>
                        <th>Profit / Loss</th>
                        <th>Margin %</th>
                        <th>Record Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $r)
                        @php
                            $isProfit = $r->profit_amount >= 0;
                            $margin = $r->cost_price > 0 ? ($r->profit_amount / $r->cost_price) * 100 : 0;
                        @endphp
                        <tr>
                            <td>{{ $r->id }}</td>
                            <td>#{{ $r->saleItem?->id ?? 'N/A' }}</td>
                            <td>{{ $r->product?->name ?? 'N/A' }}</td>
                            <td>{{ number_format($r->cost_price, 2) }}</td>
                            <td>{{ number_format($r->selling_price, 2) }}</td>
                            <td>
                                @if($isProfit)
                                    <span class="text-success">{{ number_format($r->profit_amount, 2) }} (Profit)</span>
                                @else
                                    <span class="text-danger">{{ number_format($r->profit_amount, 2) }} (Loss)</span>
                                @endif
                            </td>
                            <td>{{ number_format($margin, 2) }}%</td>
                            <td>{{ $r->record_date }}</td>
                            <td>
                                <a href="{{ route('profit-records.show', $r->id) }}" class="btn btn-info btn-sm">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No records found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $records->links() }}
        </div>
    </div>

</div>
@endsection
