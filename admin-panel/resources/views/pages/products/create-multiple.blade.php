@extends('master')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Add Multiple Products</h3>
            <a href="{{ route('products.index') }}" class="btn btn-light btn-sm">← Back</a>
        </div>

        <div class="card-body">
            <form action="{{ route('products.storeMultiple') }}" method="POST">
                @csrf
                <table class="table table-bordered" id="productTable">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Barcode</th>
                            <th>Category</th>
                            <th>Sub-Category</th>
                            <th>Unit</th>
                            <th>Description</th>
                            <th width="80">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" name="products[0][name]" class="form-control" required></td>
                            <td><input type="text" name="products[0][barcode]" class="form-control"></td>
                            <td>
                                <select name="products[0][category_id]" class="form-select" required>
                                    <option value="">Select</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="products[0][sub_category_id]" class="form-select" required>
                                    <option value="">Select</option>
                                    @foreach($subCategories as $sub)
                                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="products[0][productunit_id]" class="form-select" required>
                                    <option value="">Select</option>
                                    @foreach($productUnits as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><textarea name="products[0][description]" class="form-control" rows="1"></textarea></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <button type="button" class="btn btn-secondary mb-3" id="addRow">+ Add Another Product</button>
                <div>
                    <button type="submit" class="btn btn-success">Save All Products</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let rowIndex = 1;
document.getElementById('addRow').addEventListener('click', function() {
    const tableBody = document.querySelector('#productTable tbody');
    const newRow = tableBody.rows[0].cloneNode(true);
    newRow.querySelectorAll('input, select, textarea').forEach(el => {
        el.value = '';
        const name = el.getAttribute('name').replace('[0]', '[' + rowIndex + ']');
        el.setAttribute('name', name);
    });
    tableBody.appendChild(newRow);
    rowIndex++;
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('removeRow')) {
        const rows = document.querySelectorAll('#productTable tbody tr');
        if (rows.length > 1) {
            e.target.closest('tr').remove();
        } else {
            alert('You must have at least one product row.');
        }
    }
});
</script>
@endsection
