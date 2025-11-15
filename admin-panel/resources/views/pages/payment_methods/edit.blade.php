@extends('master')

@section('content')
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <h1 class="card-title mb-4">Edit Payment Method: {{ $paymentMethod->method_name }}</h1>

                <form action="{{ route('paymentMethodUpdate', $paymentMethod->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="method_name" class="form-label">Method Name <span class="text-danger">*</span></label>
                        <input type="text" name="method_name" id="method_name"
                            value="{{ old('method_name', $paymentMethod->method_name) }}"
                            class="form-control @error('method_name') is-invalid @enderror" required>
                        @error('method_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optional)</label>
                        <textarea name="description" id="description" rows="3"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description', $paymentMethod->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $paymentMethod->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Is Active
                        </label>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('paymentMethodIndex') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Method</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection