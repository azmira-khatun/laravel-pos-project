@extends('master')

@section('content')
<div class="container">
    <h1>Sub Categories</h1>
    <a href="{{ route('subCategory.create') }}" class="btn btn-primary mb-3">Add New Sub Category</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subCategories as $subCategory)
                <tr>
                    <td>{{ $subCategory->id }}</td>
                    <td>{{ $subCategory->name }}</td>
                    <td>{{ optional($subCategory->category)->name }}</td>
                    <td>
                        <a href="{{ route('subCategory.edit', $subCategory) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('subCategory.destroy', $subCategory) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this item?');">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No sub-categories found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
