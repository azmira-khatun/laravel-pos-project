@extends('master')

@section('content')
<div class="container mt-4">

    <h2>Stock Movement Details</h2>

    <a href="{{ route('stockMovements.index') }}" class="btn btn-secondary mb-3">Back</a>

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $stockMovement->id }}</td>
                </tr>

                <tr>
                    <th>Product</th>
                    <td>{{ $stockMovement->product?->name }}</td>
                </tr>

                <tr>
                    <th>Movement Type</th>
                    <td>{{ $stockMovement->movement_type }}</td>
                </tr>

                <tr>
                    <th>Quantity</th>
                    <td>{{ $stockMovement->quantity }}</td>
                </tr>

                <tr>
                    <th>From</th>
                    <td>
                        @if($stockMovement->purchase_id) Purchase #{{ $stockMovement->purchase_id }}
                        @elseif($stockMovement->sale_id) Sale #{{ $stockMovement->sale_id }}
                        @elseif($stockMovement->sale_return_id) Sale Return #{{ $stockMovement->sale_return_id }}
                        @elseif($stockMovement->purchase_return_id) Purchase Return #{{ $stockMovement->purchase_return_id }}
                        @elseif($stockMovement->damage_id) Damage #{{ $stockMovement->damage_id }}
                        @else -
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>User</th>
                    <td>{{ $stockMovement->user?->name }}</td>
                </tr>

                <tr>
                    <th>Date</th>
                    <td>{{ $stockMovement->movement_date }}</td>
                </tr>
            </table>

        </div>
    </div>

</div>
@endsection
