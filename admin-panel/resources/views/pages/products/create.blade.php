@extends('master')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Add New Product</h3>
        </div>
        <div class="card-body">
            <a class="btn btn-secondary mb-4" href="{{ route('products.index') }}">← Back to List</a>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="name" required maxlength="150" value="{{ old('name') }}">
                    </div>

                    <div class="col-md-6">
                        <label for="barcode" class="form-label">Barcode</label>
                        <input type="text" name="barcode" class="form-control" id="barcode" maxlength="100" value="{{ old('barcode') }}">
                    </div>

                    <div class="col-md-4">
                        <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="sub_category_id" class="form-label">Sub-Category <span class="text-danger">*</span></label>
                        <select name="sub_category_id" id="sub_category_id" class="form-select" required>
                            <option value="">-- Select Sub-Category --</option>
                            @foreach($subCategories as $subCat)
                                <option value="{{ $subCat->id }}" {{ old('sub_category_id')==$subCat->id ? 'selected' : '' }}>
                                    {{ $subCat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="productunit_id" class="form-label">Unit <span class="text-danger">*</span></label>
                        <select name="productunit_id" id="productunit_id" class="form-select" required>
                            <option value="">-- Select Unit --</option>
                            @foreach($productUnits as $unit)
                                <option value="{{ $unit->id }}" {{ old('productunit_id')==$unit->id ? 'selected' : '' }}>
                                    {{ $unit->unit_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="4">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">Save Product</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
