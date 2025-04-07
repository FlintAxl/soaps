@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Products</h2>

    <!-- Add Product & Import Buttons -->
    <div class="mb-3">
        <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
        <button class="btn btn-success" onclick="document.getElementById('importFile').click();">Import Products</button>

        <!-- Hidden File Input -->
        <form id="importForm" action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data" style="display: none;">
            @csrf
            <input type="file" id="importFile" name="file" accept=".csv, .xlsx" onchange="document.getElementById('importForm').submit();">
        </form>
    </div>

    <table id="productTable" class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th> <!-- Added Category Column -->
                <th>Images</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ Str::limit($product->description, 50) }}</td>
                <td>
                    @if($product->category)
                        <span class="badge" style="background-color: #e6e6fa; color: #9370db;">
                            {{ $product->category->description }}
                        </span>
                    @else
                        <span class="badge bg-secondary">Uncategorized</span>
                    @endif
                </td>
                <td>
                    @if($product->images->isNotEmpty())
                        @foreach($product->images->take(3) as $image)
                            <img src="{{ asset('storage/' . $image->image_path) }}" width="50" class="img-thumbnail me-1">
                        @endforeach
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td>${{ number_format($product->price, 2) }}</td>
                <td>{{ $product->stock }}</td>
                <td>
                    @if($product->trashed())
                        <span class="badge bg-danger">Deleted</span>
                    @else
                        <span class="badge bg-success">Active</span>
                    @endif
                </td>
                <td>
                    @if($product->trashed())
                        <a href="{{ route('products.restore', $product->id) }}" class="btn btn-sm btn-success">Restore</a>
                    @else
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#productTable').DataTable({
            "columnDefs": [
                { "orderable": false, "targets": [2, 3, 6, 7] } // Make non-sortable columns
            ],
            "initComplete": function() {
                // Add category filter dropdown
                this.api().columns(2).every(function() {
                    var column = this;
                    var select = $('<select class="form-select form-select-sm"><option value="">All Categories</option></select>')
                        .appendTo($(column.header()))
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? '^'+val+'$' : '', true, false).draw();
                        });

                    column.data().unique().sort().each(function(d) {
                        var category = $(d).text().trim();
                        if (category) {
                            select.append('<option value="'+category+'">'+category+'</option>');
                        }
                    });
                });
            }
        });
    });
</script>


<style>
    /* products.css - For Admin Product Table */
.table-container {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(147, 112, 219, 0.1);
    padding: 2rem;
    margin-top: 2rem;
}

#productTable {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

#productTable thead th {
    background-color: #9370db;
    color: white;
    font-weight: 500;
    padding: 1rem;
    border: none;
}

#productTable tbody td {
    padding: 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #e6e6fa;
}

#productTable tbody tr:last-child td {
    border-bottom: none;
}

#productTable tbody tr:hover {
    background-color: #f9f5ff;
}

/* Category Badges */
.badge[style*="background-color: #e6e6fa"] {
    padding: 0.35rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    letter-spacing: 0.5px;
}

/* Status Badges */
.badge.bg-success {
    background-color: #d4edda !important;
    color: #155724;
}

.badge.bg-danger {
    background-color: #f8d7da !important;
    color: #721c24;
}

/* Buttons */
.btn-primary {
    background-color: #9370db;
    border-color: #9370db;
}

.btn-primary:hover {
    background-color: #7b5dc5;
    border-color: #7b5dc5;
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
}

.btn-warning {
    background-color: #ffc107;
    border-color: #ffc107;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

/* Images */
.img-thumbnail {
    border: 2px solid #e6e6fa;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.img-thumbnail:hover {
    transform: scale(1.05);
    border-color: #d8bfd8;
}

/* Filter Dropdown */
.dataTables_wrapper .form-select {
    border: 1px solid #d8bfd8;
    border-radius: 8px;
    color: #9370db;
    margin-bottom: 1rem;
}

.dataTables_wrapper .form-select:focus {
    border-color: #9370db;
    box-shadow: 0 0 0 0.25rem rgba(147, 112, 219, 0.25);
}

/* Pagination */
.dataTables_wrapper .paginate_button {
    border-radius: 8px !important;
    margin: 0 2px;
    border: 1px solid #e6e6fa !important;
}

.dataTables_wrapper .paginate_button.current {
    background: #9370db !important;
    color: white !important;
    border: none !important;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .table-container {
        padding: 1rem;
    }

    #productTable thead {
        display: none;
    }

    #productTable tbody td {
        display: block;
        text-align: right;
        padding-left: 50%;
        position: relative;
    }

    #productTable tbody td::before {
        content: attr(data-label);
        position: absolute;
        left: 1rem;
        width: calc(50% - 1rem);
        padding-right: 1rem;
        text-align: left;
        font-weight: bold;
        color: #9370db;
    }

    .img-thumbnail {
        max-width: 40px;
    }
}
</style>
@endsection
