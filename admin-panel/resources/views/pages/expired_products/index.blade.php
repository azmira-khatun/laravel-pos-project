@extends('master')

@section('content')
<div class="container">
    <h1>Expired Products List</h1>
    <a href="{{ route('expiredProductsCreate') }}" class="btn btn-primary mb-3">Add New Expired Product</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Expiry Date</th>
                <th>User</th>
                <th>Noted On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($expiredProducts as $ep)
            <tr>
                <td>{{ $ep->id }}</td>
                <td>{{ optional($ep->product)->name ?? '-' }}</td>
                <td>{{ $ep->expiry_date }}</td>
                <td>{{ optional($ep->user)->name ?? '-' }}</td>
                <td>{{ $ep->noted_on->format('Y‑m‑d H:i') }}</td>
                <td>
                    <a href="{{ route('expiredProductsEdit', $ep->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('expiredProductsDelete', $ep->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $expiredProducts->links() }}
</div>
@endsection
