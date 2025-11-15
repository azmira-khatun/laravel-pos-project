@extends('master')

@section('content')
<div class="container">
    <h1>Add New Expired Product</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('expiredProductsStore') }}" method="POST">
        @csrf

        <div class="mb‑3">
            <label for="product_id" class="form-label">Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
                <option value="">-- Select Product --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
            @error('product_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb‑3">
            <label for="expiry_date" class="form-label">Expiry Date</label>
            <input type="date" name="expiry_date" id="expiry_date" class="form-control" value="{{ old('expiry_date') }}" required>
            @error('expiry_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb‑3">
            <label for="user_id" class="form-label">User (optional)</label>
            <select name="user_id" id="user_id" class="form-control">
                <option value="">-- Select User or Leave Empty --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb‑3">
            <label for="noted_on" class="form-label">Noted On (optional)</label>
            <input type="datetime-local" name="noted_on" id="noted_on" class="form-control" value="{{ old('noted_on') }}">
            @error('noted_on')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('expiredProductsIndex') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
