@extends('master')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Edit Role</h2>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary mb-3">Back to List</a>

        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Role Name</label>
                <input type="text" name="role_name" class="form-control" value="{{ old('role_name', $role->role_name) }}"
                    required>
                @error('role_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update Role</button>
        </form>
    </div>
@endsection