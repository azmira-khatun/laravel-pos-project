@extends('master')

@section('content')
    <h2>Edit Purchase #{{ $purchase->id }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('purchases.update', $purchase) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Similar fields as create view, but with values pre-filled --}}
        <div class="form-group">
            <label for="vendor_id">Vendor</label>
            <select name="vendor_id" id="vendor_id" class="form-control" required>
                {{-- loop vendors, mark selected $purchase->vendor_id --}}
            </select>
        </div>

        {{-- ... other fields ... --}}

        <button type="submit" class="btn btn-primary">Update Purchase</button>
        <a href="{{ route('purchases.history') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
