@extends('master')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h2>Stock Movements</h2>
        <a href="{{ route('stockMovements.create') }}" class="btn btn-primary">Add Movement</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Type</th>
                        <th>Qty</th>
                        <th>From</th>
                        <th>User</th>
                        <th>Date</th>
                        <th>View</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($movements as $m)
                        <tr>
                            <td>{{ $m->id }}</td>
                            <td>{{ $m->product?->name }}</td>
                            <td>
                                @if($m->movement_type == 'IN')
                                    <span class="badge bg-success">IN</span>
                                @else
                                    <span class="badge bg-danger">OUT</span>
                                @endif
                            </td>
                            <td>{{ $m->quantity }}</td>

                            <td>
                                @if($m->purchase_id) Purchase #{{ $m->purchase_id }}
                                @elseif($m->sale_id) Sale #{{ $m->sale_id }}
                                @elseif($m->sale_return_id) Sale Return #{{ $m->sale_return_id }}
                                @elseif($m->purchase_return_id) Purchase Return #{{ $m->purchase_return_id }}
                                @elseif($m->damage_id) Damage #{{ $m->damage_id }}
                                @else -
                                @endif
                            </td>

                            <td>{{ $m->user?->name }}</td>
                            <td>{{ $m->movement_date }}</td>

                            <td>
                                <a href="{{ route('stockMovements.show', $m->id) }}" class="btn btn-info btn-sm">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No Movement Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $movements->links() }}

        </div>
    </div>

</div>
@endsection
