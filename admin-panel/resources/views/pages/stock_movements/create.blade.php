@extends('master')

@section('content')
<div class="container mt-4">

    <h2>Add Stock Movement</h2>

    <a href="{{ route('stockMovements.index') }}" class="btn btn-secondary mb-3">Back</a>

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('stockMovements.store') }}" method="POST">
                @csrf

                {{-- Product, Movement Type, Quantity --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Product *</label>
                        <select name="product_id" class="form-select" required>
                            <option value="">-- Select Product --</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Movement Type *</label>
                        <select name="movement_type" class="form-select" required>
                            <option value="IN">IN</option>
                            <option value="OUT">OUT</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Quantity *</label>
                        <input type="number" name="quantity" class="form-control" required min="1">
                    </div>
                </div>

                {{-- Purchase, Sale --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Purchase (Optional)</label>
                        <select name="purchase_id" class="form-select">
                            <option value="">-- Select --</option>
                            @foreach($purchases as $purchase)
                                <option value="{{ $purchase->id }}">#{{ $purchase->id }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Sale (Optional)</label>
                        <select name="sale_id" class="form-select">
                            <option value="">-- Select --</option>
                            @foreach($sales as $sale)
                                <option value="{{ $sale->id }}">#{{ $sale->id }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Purchase Return, Damage --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Purchase Return (Optional)</label>
                        <select name="purchase_return_id" class="form-select">
                            <option value="">-- Select --</option>
                            @foreach($purchaseReturns as $ret)
                                <option value="{{ $ret->id }}">#{{ $ret->id }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Damage (Optional)</label>
                        <select name="damage_id" class="form-select">
                            <option value="">-- Select --</option>
                            @foreach($damages as $dmg)
                                <option value="{{ $dmg->id }}">#{{ $dmg->id }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button class="btn btn-primary">Save Movement</button>
            </form>

        </div>
    </div>

</div>
@endsection
