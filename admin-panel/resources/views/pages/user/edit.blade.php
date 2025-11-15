@extends('master')

@section('content')
  <div class="card bg-primary-subtle p-5 w-100">
    <div class="bg-info-subtle p-5 rounded w-100 mt-5">
      <div class="d-flex justify-content-center">
        <form method="POST" action="{{ route('editStoreU') }}" class="w-100" style="max-width: 500px;">
          @csrf
          <input type="hidden" name="user_id" value="{{ $user->id }}">
          <h1 class="text-center mb-4">Edit User</h1>

          {{-- ✅ Name --}}
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $user->name) }}">
            @error('name')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          {{-- ✅ Email --}}
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email', $user->email) }}">
            @error('email')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          {{-- ✅ Password --}}
          <div class="mb-3">
            <label class="form-label">Password <small>(Leave blank to keep current)</small></label>
            <input type="password" name="password" class="form-control">
            @error('password')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          {{-- ✅ Role Dropdown --}}
          <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role_id" class="form-select" required>
              <option value="">Select Role</option>
              @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ (old('role_id', $user->role_id) == $role->id) ? 'selected' : '' }}>
                  {{ ucfirst($role->role_name) }}
                </option>
              @endforeach
            </select>

            @error('role_id')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          {{-- ✅ Submit Button --}}
          <div class="text-center">
            <button type="submit" class="btn btn-primary form-control">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection