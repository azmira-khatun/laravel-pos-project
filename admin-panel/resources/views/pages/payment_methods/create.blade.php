@extends('master')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Add New Payment Method</h4>
                    </div>

                    <div class="card-body">
                        @if(session('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('paymentMethodStore') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="method_name" class="form-label">Method Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="method_name" id="method_name" value="{{ old('method_name') }}"
                                    class="form-control @error('method_name') is-invalid @enderror" required>
                                @error('method_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description (Optional)</label>
                                <textarea name="description" id="description" rows="3"
                                    class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                    checked>
                                <label class="form-check-label" for="is_active">Is Active</label>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('paymentMethodIndex') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save Method</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection