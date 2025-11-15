// resources/views/pages/products/index.blade.php

@extends('master')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Products List</h2>
        <a href="{{ route('products.createMultiple') }}" class="btn btn-primary">+ Add New Product</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Unit</th>
                            <th>Barcode</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr class="table-primary">
                                <td colspan="7" class="fw-bold fs-5">
                                    {{ $category->name }}
                                </td>
                            </tr>
                            @forelse($category->subCategories as $subCategory)
                                <tr class="table-warning">
                                    <td colspan="7" class="fw-semibold ps-4">
                                        &lfloor; Sub-Category: {{ $subCategory->name }} ({{ $subCategory->products->count() }} Products)
                                    </td>
                                </tr>
                                @forelse($subCategory->products as $product)
                                <tr class="align-middle">
                                    {{-- The numbering shows the hierarchy: Category.SubCategory.Product --}}
                                    <td>{{ $loop->parent->parent->iteration }}.{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                    {{-- Increased padding (ps-5) for visual nesting --}}
                                    <td class="ps-5">{{ $product->name }}</td>
                                    <td>{{ $product->productUnit->unit_name ?? '-' }}</td>
                                    <td>{{ $product->barcode ?? '-' }}</td>
                                    <td>{{ Str::limit($product->description, 50, '...') }}</td>
                                    <td>{{ $product->created_at->format('d M, Y') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        {{-- NOTE: We replaced window.confirm() with a data-driven approach for a modal --}}
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline-block delete-product-form" data-product-name="{{ $product->name }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted ps-5">No products found in this sub-category.</td>
                                </tr>
                                @endforelse
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted ps-4">No sub-categories found for {{ $category->name }}.</td>
                            </tr>
                            @endforelse
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No categories and products found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Removed: Pagination is not supported with the current grouping structure. --}}
        </div>
    </div>
</div>

<script>
    // Since window.confirm() is forbidden by development guidelines, this script
    // provides a placeholder for handling deletion via a custom modal dialog.
    document.querySelectorAll('.delete-product-form').forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const productName = this.dataset.productName;

            // ----------------------------------------------------------------------
            // IMPORTANT: In a production app, you MUST implement a proper Bootstrap
            // modal dialog here to replace window.confirm() for confirmation.
            // Example structure for a modal placeholder:
            //
            // if (showConfirmationModal(productName)) {
            //     this.submit(); // Only submit if the user confirms in the modal
            // }
            // ----------------------------------------------------------------------

            // For development/debugging purposes, we prevent submission and log a message:
            console.warn(`[CONFIRMATION REQUIRED]: You attempted to delete product: ${productName}.
            Please implement a custom Bootstrap modal here to handle confirmation.`);

            // If you are confident you want to delete without a modal, uncomment the line below:
            // this.submit();
        });
    });
</script>
@endsection
