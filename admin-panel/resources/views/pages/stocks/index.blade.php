@extends('master')

@section('content')
<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Stock List</h2>
        {{-- Add Stock button সরানো --}}
        {{-- <a href="{{ route('stocks.create') }}" class="btn btn-primary">+ Add Stock</a> --}}
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Added By</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($stocks as $stock)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $stock->product->name ?? 'N/A' }}</td>
                            <td>{{ $stock->quantity }}</td>
                            <td>{{ $stock->user->name ?? 'N/A' }}</td>
                            <td>{{ $stock->created_at ? $stock->created_at->format('Y-m-d') : '' }}</td>
                            <td>{{ $stock->updated_at ? $stock->updated_at->format('Y-m-d') : '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center">
                {{ $stocks->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
