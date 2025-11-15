@extends('master')

@section('content')
<div class="card mt-4">
    <div class="card-header">
        <h3>Edit Vendor: {{ $vendor->name }}</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('vendorUpdate', $vendor->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="name">Vendor Name *</label>
                <input type="text" name="name" id="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $vendor->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" id="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $vendor->email) }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="phone">Phone Number</label>
                <input type="text" name="phone" id="phone"
                       class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone', $vendor->phone) }}">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="address">Address</label>
                <textarea name="address" id="address"
                          class="form-control @error('address') is-invalid @enderror"
                          rows="3">{{ old('address', $vendor->address) }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr>

            <div class="form-group mb-3">
                <label for="tin_number">TIN Number (Tax ID)</label>
                <input type="text" name="tin_number" id="tin_number"
                       class="form-control @error('tin_number') is-invalid @enderror"
                       value="{{ old('tin_number', $vendor->tin_number) }}">
                @error('tin_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="bank_details">Bank Details</label>
                <textarea name="bank_details" id="bank_details"
                          class="form-control @error('bank_details') is-invalid @enderror"
                          rows="3">{{ old('bank_details', $vendor->bank_details) }}</textarea>
                @error('bank_details')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Vendor</button>
        </form>
    </div>
</div>
@endsection
