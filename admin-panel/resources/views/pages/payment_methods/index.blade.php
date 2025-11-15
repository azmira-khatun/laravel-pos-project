@extends('master')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Payment Methods</h1>
            <a href="{{ route('paymentMethodCreate') }}" class="btn btn-primary">+ Add New Method</a>
        </div>

        @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Method Name</th>
                                <th class="text-center">Active</th>
                                <th class="text-center">Created At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paymentMethods as $method)
                                <tr>
                                    <td>{{ $method->id }}</td>
                                    <td>{{ $method->method_name }}</td>
                                    <td class="text-center">
                                        @if($method->is_active)
                                            <span class="badge bg-success">Yes</span>
                                        @else
                                            <span class="badge bg-danger">No</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $method->created_at->format('Y-m-d') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('paymentMethodShow', $method->id) }}" class="btn btn-sm btn-info"
                                            title="View">View</a>
                                        <a href="{{ route('paymentMethodEdit', $method->id) }}" class="btn btn-sm btn-warning"
                                            title="Edit">Edit</a>
                                        <form action="{{ route('paymentMethodDelete', $method->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this payment method?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $paymentMethods->links() }}
            </div>
        </div>
    </div>
@endsection