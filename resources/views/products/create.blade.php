<x-admin-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Include Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="page-content">
            <div class="col-md-12">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="px-4 col-md-12">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h4 class="mb-0">Add Product</h4>
                                </div>
                                <div class="card-body">
                                    <form id="productForm" method="POST" action="{{ route('products.store') }}">
                                        @csrf
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="name" class="form-label">Product Name</label>
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter product name" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="buy_price" class="form-label">Buy Price</label>
                                                <input type="number" name="buy_price" id="buy_price" class="form-control" placeholder="Enter buy price" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="sell_price" class="form-label">Sell Price</label>
                                                <input type="number" name="sell_price" id="sell_price" class="form-control" placeholder="Enter sell price" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="hole_sale_percentage" class="form-label">Hole Sale Percentage</label>
                                                <input type="number" name="hole_sale_percentage" id="hole_sale_percentage" class="form-control" placeholder="Enter hole sale percentage" min="0" max="100">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="hole_sale_price" class="form-label">Hole Sell Price</label>
                                                <input type="number" name="hole_sale_price" id="hole_sale_price" class="form-control" placeholder="Enter hole sale price">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="product_profit" class="form-label">Product Profit</label>
                                                <input type="text" id="product_profit" class="form-control" name="product_profit" placeholder="Calculated profit will appear here" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="discount_percentage" class="form-label">Discount Percentage</label>
                                                <input type="number" name="discount_percentage" id="discount_percentage" class="form-control" placeholder="Enter discount percentage" min="0" max="100">
                                            </div>

                                            <div class="col-md-4">
                                                <label for="discount_price" class="form-label">Discount Price</label>
                                                <input type="text" id="discount_price" class="form-control" placeholder="Discount price will be calculated" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="quantity" class="form-label">Quantity</label>
                                                <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter quantity" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="category_id" class="form-label">Category</label>
                                                <select name="categories_id" id="category_id" class="form-control" required>
                                                    <option value="" selected disabled>Select a Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                             <div class="col-md-4">
                                                <label for="barcode" class="form-label">Barcode</label>
                                                <input type="text" name="barcode"  class="form-control" placeholder="Enter barcode" >
                                            </div>
                                        </div>

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                const buyPriceInput = document.getElementById('buy_price');
                                                const sellPriceInput = document.getElementById('sell_price');
                                                const profitInput = document.getElementById('product_profit');
                                                const holeSalePriceInput = document.getElementById('hole_sale_price');
                                                const holeSalePercentageInput = document.getElementById('hole_sale_percentage');

                                                function calculateProfit() {
                                                    const buyPrice = parseFloat(buyPriceInput.value) || 0;
                                                    const sellPrice = parseFloat(sellPriceInput.value) || 0;
                                                    const profit = sellPrice - buyPrice;
                                                    profitInput.value = profit.toFixed(2);
                                                }

                                                function calculateHoleSalePrice() {
                                                    const sellPrice = parseFloat(sellPriceInput.value) || 0;
                                                    const holeSalePercentage = parseFloat(holeSalePercentageInput.value) || 0;
                                                    const holeSalePrice = sellPrice - (sellPrice * (holeSalePercentage / 100));
                                                    holeSalePriceInput.value = holeSalePrice.toFixed(2);
                                                }

                                                sellPriceInput.addEventListener('input', () => {
                                                    calculateProfit();
                                                    calculateHoleSalePrice();
                                                });

                                                buyPriceInput.addEventListener('input', calculateProfit);
                                                holeSalePercentageInput.addEventListener('input', calculateHoleSalePrice);
                                            });
                                        </script>

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                const sellPriceInput = document.getElementById('sell_price');
                                                const discountPercentageInput = document.getElementById('discount_percentage');
                                                const discountPriceInput = document.getElementById('discount_price');

                                                function calculateDiscountPrice() {
                                                    const sellPrice = parseFloat(sellPriceInput.value) || 0;
                                                    const discountPercentage = parseFloat(discountPercentageInput.value) || 0;
                                                    const discountPrice = sellPrice - (sellPrice * (discountPercentage / 100));
                                                    discountPriceInput.value = discountPrice.toFixed(2);
                                                }

                                                sellPriceInput.addEventListener('input', calculateDiscountPrice);
                                                discountPercentageInput.addEventListener('input', calculateDiscountPrice);
                                            });
                                        </script>

                                        <script>
                                            document.getElementById('productForm').addEventListener('submit', function (event) {
                                                const productProfit = parseFloat(document.getElementById('product_profit').value);
                                                const holeSalePrice = parseFloat(document.getElementById('hole_sale_price').value);

                                                if (productProfit < 0 || holeSalePrice < 0) {
                                                    event.preventDefault(); // Prevent form submission
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Please check the fields',
                                                        text: 'Product Profit or Hole Sale Price cannot be negative.',
                                                        toast: true,
                                                        position: 'top',
                                                        timer: 3000,
                                                        showConfirmButton: false,
                                                    });
                                                }
                                            });
                                        </script>

                                        <div class="text-end mt-3">
                                            <button type="submit" class="btn btn-primary">Add Product</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#category_id').select2({
                placeholder: "Select a Category", // Placeholder text
                allowClear: true // Optional: Adds a clear button to deselect
            });
        });
    </script>

    <style>
        .card-header {
            background: linear-gradient(45deg, #3f51b5, #1a237e);
            color: #fff;
            text-align: center;
            font-size: 1.25rem;
        }

        .btn-primary {
            background-color: #3f51b5;
            border-color: #3f51b5;
        }

        .btn-primary:hover {
            background-color: #303f9f;
            border-color: #303f9f;
        }

        .form-control {
            border-radius: 0.375rem;
        }

        .form-label {
            font-weight: 500;
        }
    </style>
</x-admin-layout>
