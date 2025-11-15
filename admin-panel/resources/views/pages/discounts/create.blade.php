
@extends('master')

@section('content')
<h2>Add New Discount</h2>
<a class="btn btn-secondary mb-3" href="{{ route('discounts.index') }}">Back to List</a>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('discounts.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="product_id" class="form-label">Product</label>
        <select name="product_id" id="product_id" class="form-select" required>
            <option value="">-- Select Product --</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control" id="name" maxlength="100"
               value="{{ old('name') }}" required>
    </div>

    <div class="mb-3">
        <label for="type" class="form-label">Type</label>
        <select name="type" id="type" class="form-select" required>
            <option value="percent" {{ old('type')=='percent' ? 'selected' : '' }}>Percent</option>
            <option value="fixed"   {{ old('type')=='fixed'   ? 'selected' : '' }}>Fixed</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="amount" class="form-label">Amount</label>
        <input type="number" step="0.01" name="amount" class="form-control" id="amount"
               value="{{ old('amount') }}" required>
    </div>

    <div class="mb-3">
        <label for="start_date" class="form-label">Start Date</label>
        <input type="date" name="start_date" class="form-control" id="start_date"
               value="{{ old('start_date') }}" required>
    </div>

    <div class="mb-3">
        <label for="end_date" class="form-label">End Date</label>
        <input type="date" name="end_date" class="form-control" id="end_date"
               value="{{ old('end_date') }}" required>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select">
            <option value="active"   {{ old('status')=='active'   ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Save Discount</button>
</form>
@endsection
