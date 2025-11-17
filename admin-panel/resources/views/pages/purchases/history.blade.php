@extends('master')

@section('content')
<div class="container mt-5">
    <h2>Purchase History</h2>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Vendor</th>
                <th>Date</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchases as $purchase)
                <tr>
                    <td>{{ $purchase->id }}</td>
                    <td>{{ $purchase->vendor->name ?? '-' }}</td>
                    <td>{{ $purchase->created_at }}</td>
                    <td>{{ $purchase->total_amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $purchases->links() }} {{-- Pagination links --}}
</div>
@endsection

