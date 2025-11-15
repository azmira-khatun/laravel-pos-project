@extends('master')

@section('content')
    <h1>Purchase Returns</h1>

    <a href="{{ route('purchaseReturns.create') }}" class="btn btn-primary mb-3">New Return</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Purchase ID</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Return Date</th>
                <th>Vendor</th>
                <th>User</th>
                <th>Reason</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($returns as $ret)
                <tr>
                    <td>{{ $ret->id }}</td>
                    <td>{{ $ret->purchase_id }}</td>
                    <td>{{ $ret->product->name ?? $ret->product_id }}</td>
                    <td>{{ $ret->quantity }}</td>
                    <td>{{ $ret->return_date }}</td>
                    <td>{{ $ret->vendor->name ?? $ret->vendor_id }}</td>
                    <td>{{ $ret->user->name ?? $ret->user_id }}</td>
                    <td>{{ $ret->reason }}</td>
                    <td>
                        <a href="{{ route('purchaseReturns.show', $ret->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('purchaseReturns.edit', $ret->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('purchaseReturns.destroy', $ret->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No returns found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
