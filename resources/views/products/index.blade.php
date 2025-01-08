<x-admin-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="page-content">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="px-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Product List</h4>
                                @can('add_product')
                                <a href="{{ route('products.create') }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-plus"></i> Add Product
                                </a>
                                @endcan
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <form method="GET" action="{{ route('products.index') }}">
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <label for="search">Search by name or barcode</label>
                                                <input type="text" id="search" name="search" class="form-control" value="{{ $search ?? '' }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="barcode">Search by barcode</label>
                                                <input type="text" id="barcode" name="barcode" class="form-control" value="{{ $barcode ?? '' }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="category">Category</label>
                                                <select name="category" id="category" class="form-select">
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $cat)
                                                        <option value="{{ $cat->id }}" {{ $cat->id == $category ? 'selected' : '' }}>{{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="quantity">Search by Quantity</label>
                                                <input type="number" id="quantity" name="quantity" class="form-control" value="{{ $quantity ?? '' }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="start_date">Start Date</label>
                                                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $startDate ?? '' }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="end_date">End Date</label>
                                                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $endDate ?? '' }}">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fas fa-search"></i> Search
                                                </button>
                                            </div>
                                            <div class="col-md-2">
                                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100">
                                                    <i class="fas fa-times"></i> Clear Search
                                                </a>
                                            </div>
                                            <div class="col-md-2">
                                            @can('export product')
                                            <a href="javascript:void(0);" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#exportModal">
                                                <i class="fas fa-download"></i> Export Audit
                                            </a>
                                            @endcan
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Buy Price</th>
                                                <th>Sell Price</th>
                                                <th>Wholesale Price</th>
                                                <th>Discount %</th>
                                                <th>Discount Price</th>
                                                <th>Quantity</th>
                                                <th>Barcode</th>
                                                <th>Product Profit</th>
                                                <th>Wholesale Percentage</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($products as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->category->name }}</td>
                                                <td>{{ $product->buy_price }}</td>
                                                <td>{{ $product->sell_price }}</td>
                                                <td>{{ $product->hole_sale_price }}</td>
                                                <td>{{ $product->discount_percentage ?? '0' }}%</td>
                                                <td>{{ $product->discount_price ?? '-' }}</td>
                                                <td style="color: {{ $product->quantity < 2 ? 'red' : 'green' }};">
                                                    {{ $product->quantity }}
                                                </td>
                                                <td>{{ $product->barcode }}</td>
                                                <td>{{ $product->product_profit }}</td>
                                                <td>{{ $product->hole_sale_percentage }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        @can('edit product')
                                                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit Product">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        @endcan
                                                        @can('view barcode')
                                                        <a href="{{ route('products.printBarcode', $product) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Print Barcode">
                                                            <i class="fas fa-print"></i>
                                                        </a>
                                                        @endcan
                                                        @can('delete product')
                                                        <form method="POST" action="{{ route('products.destroy', $product) }}" style="display:inline;">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip" title="Delete Product">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    {{ $products->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Export Modal -->
<!-- Modal for category selection -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Select Categories for Export</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="exportForm">
                    <div class="mb-3">
                        <label for="categories" class="form-label">Select Categories</label>
                        <select id="categories" name="categories[]" class="form-select" multiple>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include the Select2 CSS and JS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- Initialize Select2 for category selection -->
<script>
    $(document).ready(function() {
        // Initialize Select2 for the categories select element
        $('#categories').select2({
            placeholder: 'Select Categories', // Placeholder text when no option is selected
            width: '100%' // Makes the select box fill the available width
        });

        // Handle form submission (optional for AJAX form submission)
        $('#exportForm').on('submit', function(e) {
            e.preventDefault();
            // You can send the selected categories to the server via AJAX here
            const selectedCategories = $('#categories').val();  // Get selected category IDs
            console.log(selectedCategories);  // Debugging selected categories (you can replace with your logic)
        });
    });
</script>


    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                toast: true,
                position: 'top',
                timer: 3000,
                showConfirmButton: false,
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                toast: true,
                position: 'top',
                timer: 3000,
                showConfirmButton: false,
            });
        @endif
    </script>

    <script>

document.getElementById('exportForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const selectedCategories = Array.from(document.getElementById('categories').selectedOptions).map(option => option.value);

    if (selectedCategories.length === 0) {
        alert('Please select at least one category');
        return;
    }

    // Send the data to the server for processing
    fetch("{{ route('products.export') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ categories: selectedCategories })
    })
    .then(response => response.blob())
    .then(blob => {
        // Create a link element to trigger the download
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = 'products-export.pdf';
        link.click();
    })
    .catch(error => {
        alert('Error exporting data');
    });
});

        document.addEventListener('DOMContentLoaded', function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>

    <style>
        .card-header {
            background: linear-gradient(45deg, #3f51b5, #1a237e);
            color: #fff;
        }

        .btn-light {
            border: 1px solid #fff;
        }

        .table-bordered th, .table-bordered td {
            vertical-align: middle;
            text-align: center;
        }

        .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        .btn i {
            margin-right: 0.25rem;
        }

        .page-content {
            background-color: #f9f9f9;
            padding: 20px;
        }

        .table {
            font-size: 0.9rem;
        }

        .btn-outline-secondary {
            border-color: #ddd;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .btn-sm {
            font-size: 0.75rem;
        }

        .card-body {
            padding: 2rem;
        }

        .col-md-3, .col-md-2 {
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .col-md-3, .col-md-2 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .col-md-12 {
                padding: 0;
            }
        }
    </style>

</x-admin-layout>
