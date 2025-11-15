@extends('master')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Product Details</h4>
            <a href="{{ route('products.index') }}" class="btn btn-light btn-sm">← Back to List</a>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>ID</th>
                    <td>{{ $product->id }}</td>
                </tr>
                <tr>
                    <th>Product Name</th>
                    <td>{{ $product->name }}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Sub Category</th>
                    <td>{{ $product->subCategory->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td>{{ $product->price }}</td>
                </tr>
                <tr>
                    <th>Quantity</th>
                    <td>{{ $product->quantity }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $product->description }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $product->created_at->format('d M Y, h:i A') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
