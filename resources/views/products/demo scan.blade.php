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
                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-header bg-primary text-white text-center">
                                <h4 class="mb-0">Scan Multiple Products</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <input type="text" id="barcode-input" class="form-control" placeholder="Scan a barcode..." autofocus>
                                </div>
                                <p class="text-muted mt-2 text-center">Scan a product barcode, and it will be processed automatically.</p>
                            </div>
                        </div>

                        <div class="card mt-4 shadow-sm">
                            <div class="card-header bg-secondary text-white text-center">
                                <h4 class="mb-0">Scanned Products</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody id="product-list">
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">No products scanned yet.</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="text-center mt-3">
                                    <h5>Total Price: <span id="total-price">0.00</span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const barcodeInput = document.getElementById('barcode-input');
        let scannedBarcode = null;
        let totalPrice = 0; // Initialize total price

        // Listen for barcode input
        barcodeInput.addEventListener('keypress', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Prevent default form submission
                scannedBarcode = barcodeInput.value.trim(); // Store the value
                processScan(); // Auto-process the scan
            }
        });

        // Process Scan
        function processScan() {
            if (scannedBarcode) {
                fetch(`/products/details/${scannedBarcode}`)
                    .then(response => response.json())
                    .then(data => {
                        const productList = document.getElementById('product-list');

                        if (data.success) {
                            // Remove "No products scanned" row
                            const noProductsRow = productList.querySelector('.text-muted');
                            if (noProductsRow) {
                                noProductsRow.remove();
                            }

                            // Add product to table
                            const newRow = document.createElement('tr');
                            newRow.innerHTML = `
                                <td>${data.product.name}</td>
                                <td>${data.product.sell_price}</td>
                            `;
                            productList.appendChild(newRow);

                            // Update total price
                            totalPrice += parseFloat(data.product.sell_price);
                            document.getElementById('total-price').textContent = totalPrice.toFixed(2);
                        } else {
                            // Show SweetAlert notification for product not found
                            Swal.fire({
                                icon: 'error',
                                title: 'Product Not Found',
                                text: 'The barcode does not match any product in our database.',
                            });
                        }

                        // Reset the barcode input after processing the scan
                        barcodeInput.value = '';
                        scannedBarcode = null; // Clear the scanned code
                        barcodeInput.focus(); // Focus back on the barcode input for the next scan
                    })
                    .catch(err => {
                        // Show SweetAlert notification for error fetching product details
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred while fetching product details.',
                        });
                    });
            }
        }
    });
</script>
