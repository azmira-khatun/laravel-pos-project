@extends('master')

@section('content')
<div class="card mt-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Vendor List</h3>
        <a href="{{ route('vendorCreate') }}" class="btn btn-primary btn-sm">Add New Vendor</a>
    </div>
    <div class="card-body">
        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>TIN Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- $vendors ভ্যারিয়েবলটি Controller থেকে আসা আবশ্যক --}}
                @foreach($vendors as $vendor)
                <tr>
                    <td>{{ $vendor->id }}</td>
                    <td>{{ $vendor->name }}</td>
                    <td>{{ $vendor->email }}</td>
                    <td>{{ $vendor->phone }}</td>
                    <td>{{ $vendor->tin_number }}</td>
                    <td>

                        {{-- Edit --}}
                        <a href="{{ route('vendorEdit', $vendor->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        {{-- Delete --}}
                        <form action="{{ route('vendorDelete', $vendor->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete {{ $vendor->name }}?');">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination Links --}}
        <div class="d-flex justify-content-center">
            {{ $vendors->links() }}
        </div>
    </div>
</div>
@endsection
