<x-admin-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        <div class="page-content">
            <div class="col-md-12">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="col-md-12 px-4">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-warning text-white">
                                    <h4 class="mb-0">Edit Product</h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('products.update', $product) }}" id="productForm">
                                        @csrf
                                        @method('PUT')
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label for="name" class="form-label">Product Name</label>
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter product name" value="{{ old('name', $product->name) }}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="buy_price" class="form-label">Buy Price</label>
                                                <input type="number" name="buy_price" id="buy_price" class="form-control" placeholder="Enter buy price" value="{{ old('buy_price', $product->buy_price) }}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="sell_price" class="form-label">Sell Price</label>
                                                <input type="number" name="sell_price" id="sell_price" class="form-control" placeholder="Enter sell price" value="{{ old('sell_price', $product->sell_price) }}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="hole_sale_percentage" class="form-label">Hole Sale Percentage</label>
                                                <input type="number" name="hole_sale_percentage" id="hole_sale_percentage" class="form-control" placeholder="Enter hole sale percentage" value="{{ old('hole_sale_percentage', $product->hole_sale_percentage) }}" min="0" max="100">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="hole_sale_price" class="form-label">Hole Sale Price</label>
                                                <input type="number" name="hole_sale_price" id="hole_sale_price" class="form-control" placeholder="Enter hole sale price" value="{{ old('hole_sale_price', $product->hole_sale_price) }}" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="product_profit" class="form-label">Product Profit</label>
                                                <input type="text" id="product_profit" class="form-control" name="product_profit" placeholder="Calculated profit will appear here" value="{{ old('product_profit', $product->product_profit) }}" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="discount_percentage" class="form-label">Discount Percentage</label>
                                                <input type="number" name="discount_percentage" id="discount_percentage" class="form-control" placeholder="Enter discount percentage" value="{{ old('discount_percentage', $product->discount_percentage) }}" min="0" max="100">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="discount_price" class="form-label">Discount Price</label>
                                                <input type="number" name="discount_price" id="discount_price" class="form-control" placeholder="Discount price will be auto-calculated" value="{{ old('discount_price', $product->discount_price) }}" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="quantity" class="form-label">Quantity</label>
                                                <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter quantity" value="{{ old('quantity', $product->quantity) }}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="category_id" class="form-label">Category</label>
                                                <select name="categories_id" id="category_id" class="form-control" required>
                                                    <option value="" disabled>Select a Category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('categories_id', $product->categories_id) == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                             <div class="col-md-4">
                                                <label for="barcode" class="form-label">Barcode</label>
                                                <input type="text" name="barcode"  value="{{ old('barcode', $product->barcode) }}" class="form-control" placeholder="Enter barcode" >
                                            </div>
                                        </div>

                                        <div class="text-end mt-3">
                                            <button type="submit" class="btn btn-warning">Update Product</button>
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
        document.addEventListener('DOMContentLoaded', function () {
            const buyPriceInput = document.getElementById('buy_price');
            const sellPriceInput = document.getElementById('sell_price');
            const profitInput = document.getElementById('product_profit');
            const holeSalePriceInput = document.getElementById('hole_sale_price');
            const holeSalePercentageInput = document.getElementById('hole_sale_percentage');
            const discountPercentageInput = document.getElementById('discount_percentage');
            const discountPriceInput = document.getElementById('discount_price');
            const productForm = document.getElementById('productForm');

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

            function calculateDiscountPrice() {
                const sellPrice = parseFloat(sellPriceInput.value) || 0;
                const discountPercentage = parseFloat(discountPercentageInput.value) || 0;
                const discountPrice = sellPrice - (sellPrice * (discountPercentage / 100));
                discountPriceInput.value = discountPrice.toFixed(2);
            }

            function validateForm() {
                const profit = parseFloat(profitInput.value) || 0;
                const holeSalePrice = parseFloat(holeSalePriceInput.value) || 0;
                if (profit < 0 || holeSalePrice < 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Input',
                        text: 'Please check fields',
                        toast: true,
                        position: 'top',
                        timer: 3000,
                        showConfirmButton: false,
                    });
                    return false;  // Prevent form submission
                }
                return true;  // Allow form submission
            }

            // Add input listeners
            sellPriceInput.addEventListener('input', () => {
                calculateProfit();
                calculateHoleSalePrice();
                calculateDiscountPrice();
            });

            buyPriceInput.addEventListener('input', calculateProfit);
            holeSalePercentageInput.addEventListener('input', calculateHoleSalePrice);
            discountPercentageInput.addEventListener('input', calculateDiscountPrice);

            // Listen to form submission
            productForm.addEventListener('submit', function (event) {
                if (!validateForm()) {
                    event.preventDefault();  // Prevent form submission if validation fails
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#category_id').select2({
                placeholder: "Select a Category",
                allowClear: true
            });
        });
    </script>

    <style>
        .card-header {
            background: linear-gradient(45deg, #ff9800, #f57c00);
            color: #fff;
            text-align: center;
            font-size: 1.25rem;
        }

        .btn-warning {
            background-color: #ff9800;
            border-color: #ff9800;
        }

        .btn-warning:hover {
            background-color: #f57c00;
            border-color: #f57c00;
        }

        .form-control {
            border-radius: 0.375rem;
        }

        .form-label {
            font-weight: 500;
        }
    </style>
</x-admin-layout>
