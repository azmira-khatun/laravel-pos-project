@extends('master')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Damage Products</h2>
            <a href="{{ route('damageProduct.create') }}" class="btn btn-primary">Add Damage Product</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Description</th>
                    <th>User</th>
                    <th>Noted On</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($damageProducts as $dp)
                    <tr>
                        <td>{{ $dp->id }}</td>
                        <td>{{ $dp->product->name ?? '-' }}</td>
                        <td>{{ $dp->quantity }}</td>
                        <td>{{ $dp->unit_price }}</td>
                        <td>{{ $dp->description }}</td>
                        <td>{{ $dp->user->name ?? '-' }}</td>
                        <td>{{ $dp->noted_on }}</td>
                        <td>
                            <a href="{{ route('damageProduct.show', $dp->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('damageProduct.edit', $dp->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('damageProduct.destroy', $dp->id) }}" method="POST" class="d-inline-block"
                                onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No damage products found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection