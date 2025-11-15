@extends('master')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New Product Unit</h3>
            </div>

            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('productUnitStore') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="unit_name" class="form-label">Unit Name</label>
                        <input type="text" name="unit_name" id="unit_name" class="form-control"
                            value="{{ old('unit_name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description (optional)</label>
                        <textarea name="description" id="description" class="form-control"
                            rows="3">{{ old('description') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Unit</button>
                    <a href="{{ route('productUnitIndex') }}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
@endsection