@extends('master')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Discount List</h2>
    <a class="btn btn-success" href="{{ route('discounts.create') }}">Add New Discount</a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Product</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @forelse($discounts as $discount)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $discount->name }}</td>
            <td>{{ $discount->product->name ?? '-' }}</td>
            <td>{{ ucfirst($discount->type) }}</td>
            <td>{{ $discount->amount }}</td>
            <td>{{ $discount->start_date }}</td>
            <td>{{ $discount->end_date }}</td>
            <td>{{ ucfirst($discount->status) }}</td>
            <td>
                <a class="btn btn-info btn-sm" href="{{ route('discounts.show', $discount) }}">Show</a>
                <a class="btn btn-primary btn-sm" href="{{ route('discounts.edit', $discount) }}">Edit</a>
                <form action="{{ route('discounts.destroy', $discount) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure to delete this discount?');">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="9" class="text-center">No discounts found.</td>
        </tr>
    @endforelse
    </tbody>
</table>
@endsection
