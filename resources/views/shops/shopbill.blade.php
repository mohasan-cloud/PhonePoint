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

        <!-- Page Content -->
        <div class="page-content">
            <div class="row justify-content-center">

                <!-- Left Side: Scanned Products Table -->
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Scan and Create Bills</h4>
                            <a href="{{ url('/products/scan') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-plus"></i> Customer Bill
                            </a>
                            
                        </div>

                        <div class="card-body text-center">
                            <h4 class="mb-3">Scan Multiple Products</h4>
                            <input type="text" id="barcode-input" class="form-control w-75 mx-auto" placeholder="Scan a barcode..." autofocus>
                            <p class="text-muted mt-2">Scan a product barcode, and it will be processed automatically.</p>
                        </div>
                    </div>

                    <!-- Scanned Products Table -->
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
                                        <th>Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="product-list">
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No products scanned yet.</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-center mt-3">
                                <h5>Total Price: <span id="total-price">00.00</span></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Payment Section -->
                <div class="col-lg-6 col-md-6 col-12 mt-4 mt-md-0">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white text-center">
                            <h4 class="mb-0">Payment</h4>
                            <a href="{{ route('pending.bills') }}" class="btn btn-primary w-100 mt-3">
                                Go To Shop Pending Bill
                            </a>
                            
                        </div>
                        <div class="card-body">
                            <form id="payment-form">
                            <div class="mb-3">
        <label for="customer-name" class="form-label">Customer Name</label>
        <input type="text" id="customer-name" class="form-control" placeholder="Customer name will appear here" readonly>
    </div>

    <!-- Buttons -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shopNameModal">
        Search by Shop Name
    </button>
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#uniqueIdModal">
        Search by Unique ID
    </button>

    <!-- Search by Shop Name Modal -->
    <!-- Search by Shop Name Modal -->
<div class="modal fade" id="shopNameModal" tabindex="-1" aria-labelledby="shopNameModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shopNameModalLabel">Search by Shop Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="shopNameInput" class="form-control mb-3" placeholder="Enter shop name">
                <button type="button" class="btn btn-primary" id="searchShopName">Search</button>
                <ul class="list-group mt-3" id="shopNameResults"></ul>
            </div>
        </div>
    </div>
</div>

<!-- Search by Unique ID Modal -->
<div class="modal fade" id="uniqueIdModal" tabindex="-1" aria-labelledby="uniqueIdModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uniqueIdModalLabel">Search by Unique ID</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="uniqueIdInput" class="form-control mb-3" placeholder="Enter unique ID">
                <button type="button" class="btn btn-primary" id="searchUniqueId">Search</button>
                <ul class="list-group mt-3" id="uniqueIdResults"></ul>
            </div>
        </div>
    </div>
</div>



                                <div class="mb-3">
                                    <label for="payment-method" class="form-label">Select Payment Method</label>
                                    <select id="payment-method" class="form-control">
                                        <option value="cash">Cash</option>
                                        <option value="easypaisa">Easypaisa</option>
                                        <option value="jazzcash">JazzCash</option>
                                    </select>
                                </div>
                               
                                
                                <div class="mb-3">
                                    <label for="paid-amount" class="form-label">Paid Amount</label>
                                    <input type="number" id="paid-amount" class="form-control" placeholder="Enter paid amount" oninput="updateRemaining()">
                                </div>
                                <div class="mb-3">
                                    <label for="remaining-amount" class="form-label">Remaining Balance / Refund</label>
                                    <input type="text" id="remaining-amount" class="form-control" readonly>
                                </div>
                                <button type="button" id="pay-bill" class="btn btn-primary w-100 mt-3">Pay Bill</button>
                            </form>
                            <button type="button" id="pending-bill" class="btn btn-warning w-100 mt-3">Mark as Pending</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS for responsive tweaks -->
    <style>
        .page-wrapper {
            padding: 20px;
        }

        .page-content {
            margin-top: 20px;
        }

        .card-header h4 {
            font-size: 1.25rem;
        }

        .card-body {
            font-size: 1rem;
        }

        .btn-light, .btn-primary, .btn-warning {
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .col-md-6, .col-lg-6 {
                margin-bottom: 20px;
            }

            .card-body {
                padding: 1rem;
            }

            .form-control {
                font-size: 1rem;
            }
        }
    </style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        
   document.addEventListener('DOMContentLoaded', function () {
    const barcodeInput = document.getElementById('barcode-input');
    const productList = document.getElementById('product-list');
        const discountInput = document.getElementById('discount');
        const priceAfterDiscount = document.getElementById('price-after-discount');

    const totalPriceElement = document.getElementById('total-price');
    const payBillButton = document.getElementById('pay-bill');
    const customerNameInput = document.getElementById('customer-name');
    const paymentMethodInput = document.getElementById('payment-method');
    const paidAmountInput = document.getElementById('paid-amount');
    const remainingAmountElement = document.getElementById('remaining-amount');
    const pendingBillButton = document.getElementById('pending-bill');

    let totalPrice = 0;
    const productMap = {}; // Store product details by barcode

    // Handle barcode scanning
    barcodeInput.addEventListener('keypress', function (event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        const scannedBarcode = barcodeInput.value.trim();
        if (scannedBarcode) {
            processScan(scannedBarcode);
        } else {
            Swal.fire({ icon: 'warning', title: 'Warning', text: 'Please enter a valid barcode.' });
        }
    }
});

// Process scanned barcode
function processScan(scannedBarcode) {
    fetch(`/products/details/${scannedBarcode}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.products && data.products.length > 1) {
                    // Multiple products found, show the modal to select one
                    showProductSelectionModal(data.products, scannedBarcode);
                } else {
                    // Single product found, update the product list
                    updateProductList(scannedBarcode, data.product);
                }
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Product not found.' });
            }
            barcodeInput.value = '';
            barcodeInput.focus();
        })
        .catch(err => {
            Swal.fire({ icon: 'error', title: 'Error', text: 'An error occurred while fetching product details.' });
            console.error('Fetch error:', err);
        });
}

// Show modal to select product from a list
function showProductSelectionModal(products, scannedBarcode) {
    let modalContent = `
        <h5>Select Product</h5>
        <ul class="list-group">
    `;
    products.forEach(product => {
        modalContent += `
            <li class="list-group-item" onclick="selectProduct(${product.id}, '${product.name}', '${scannedBarcode}', ${JSON.stringify(product)})">
                ${product.name} - $${product.discounted_price} (Qty: ${product.quantity})
            </li>
        `;
    });
    modalContent += `</ul>`;

    // Create a custom modal with product options
    const modalHtml = `
        <div class="modal fade" id="productSelectModal" tabindex="-1" aria-labelledby="productSelectModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productSelectModalLabel">Select a Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ${modalContent}
                    </div>
                </div>
            </div>
        </div>
    `;

    // Append modal to body and show it
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    new bootstrap.Modal(document.getElementById('productSelectModal')).show();
}

function selectProduct(productId, productName, scannedBarcode, product) {
    // Update the product list with the selected product
    updateProductList(scannedBarcode, product);

    // Display success message
    Swal.fire({ icon: 'success', title: 'Product Selected', text: `You selected: ${productName}` });

    // Close modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('productSelectModal'));
    modal.hide();

    // Remove the modal from DOM
    document.getElementById('productSelectModal').remove();
}

// Update product list with scanned product
function updateProductList(scannedBarcode, product) {
    const availableQuantity = product.quantity; // The stock from the API response

    if (productMap[scannedBarcode]) {
        const existingRow = productMap[scannedBarcode].row;
        const quantityCell = existingRow.querySelector('.quantity-cell');

        if (quantityCell) {
            const currentQuantity = productMap[scannedBarcode].quantity;
            const newQuantity = currentQuantity + 1;

            if (newQuantity <= availableQuantity) {
                quantityCell.textContent = newQuantity;
                productMap[scannedBarcode].quantity = newQuantity;
                totalPrice += parseFloat(product.discounted_price || product.sell_price);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Out of Stock',
                    text: 'You cannot add more of this product as it is out of stock.',
                });
            }
        }
    } else {
        const noProductsRow = productList.querySelector('.text-muted');
        if (noProductsRow) noProductsRow.remove();

        const discountText = product.discount_percentage > 0
            ? `<del>${product.sell_price.toFixed(2)}</del> <span class="text-success">${product.discounted_price.toFixed(2)}</span> (${product.discount_percentage}% off)`
            : `${product.sell_price.toFixed(2)}`;

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${product.name}</td>
            <td>${discountText}</td>
            <td class="quantity-cell">1</td>
            <td>
                <button class="btn btn-sm btn-primary increase-btn">+</button>
                <button class="btn btn-sm btn-danger decrease-btn">-</button>
            </td>
        `;

        productList.appendChild(newRow);

        productMap[scannedBarcode] = {
            row: newRow,
            price: parseFloat(product.discounted_price || product.sell_price),
            quantity: 1
        };

        totalPrice += parseFloat(product.discounted_price || product.sell_price);

        const increaseBtn = newRow.querySelector('.increase-btn');
        const decreaseBtn = newRow.querySelector('.decrease-btn');

        increaseBtn.addEventListener('click', () => updateQuantity(scannedBarcode, 1, availableQuantity));
        decreaseBtn.addEventListener('click', () => updateQuantity(scannedBarcode, -1, availableQuantity));
    }

    totalPriceElement.textContent = totalPrice.toFixed(2);
}


    // Update product quantity
    function updateQuantity(scannedBarcode, delta, availableQuantity) {
        const product = productMap[scannedBarcode];

        if (product) {
            const quantityCell = product.row.querySelector('.quantity-cell');
            let newQuantity = product.quantity + delta;

            if (newQuantity <= 0) {
                removeProduct(scannedBarcode);
            } else if (newQuantity <= availableQuantity) {
                product.quantity = newQuantity;
                quantityCell.textContent = newQuantity;
                totalPrice += delta * product.price;
                totalPriceElement.textContent = totalPrice.toFixed(2);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Out of Stock',
                    text: 'You cannot add more of this product as it is out of stock.',
                });
            }
        }
    }

    // Remove product from list
    function removeProduct(scannedBarcode) {
        const product = productMap[scannedBarcode];

        if (product) {
            product.row.remove();
            totalPrice -= product.quantity * product.price;
            totalPriceElement.textContent = totalPrice.toFixed(2);
            delete productMap[scannedBarcode];

            if (Object.keys(productMap).length === 0) {
                productList.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center text-muted">No products scanned yet.</td>
                    </tr>
                `;
            }
        }
    }

    // Get product details from the scanned list
    function getProductDetails() {
        return Object.keys(productMap).map(barcode => {
            const { row, quantity, price } = productMap[barcode];
            const name = row.querySelector('td:first-child').textContent.trim();
            return { barcode, name, price, quantity };
        });
    }

    // Update remaining balance or refund based on paid amount
    paidAmountInput.addEventListener('input', updateRemaining);

    function updateRemaining() {
        const paidAmount = parseFloat(paidAmountInput.value) || 0;
        const remainingAmount = paidAmount - totalPrice;
        remainingAmountElement.value = remainingAmount < 0
            ? remainingAmount.toFixed(2)
            : `Refund: ${remainingAmount.toFixed(2)}`;
    }

    // Pay Bill Event
   // Update remaining balance or refund based on paid amount
   paidAmountInput.addEventListener('input', updateRemaining);

function updateRemaining() {
    const paidAmount = parseFloat(paidAmountInput.value) || 0;
    const remainingAmount = paidAmount - totalPrice;
    remainingAmountElement.value = remainingAmount < 0
        ? remainingAmount.toFixed(2)
        : `Refund: ${remainingAmount.toFixed(2)}`;
}

// Pay Bill Event
payBillButton.addEventListener('click', function () {
const data = {
    total_price: totalPrice,
    paid_amount: parseFloat(paidAmountInput.value),
    payment_method: paymentMethodInput.value,
    customer_name: customerNameInput.value,
    discount: discountInput.value,
    price_after_discount: priceAfterDiscount.value,
    products: getProductDetails(),
};

// Show processing toast
const processingToast = Swal.fire({
    title: 'Processing...',
    text: 'Please wait while we process your request.',
    icon: 'info',
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 5000,  // Show for 5 seconds
    didOpen: () => {
        Swal.showLoading();
    }
});

fetch('/store/bill', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify(data)
})
.then(response => response.json())
.then(responseData => {
    processingToast.close(); // Close the processing toast

    Swal.fire({
        icon: responseData.success ? 'success' : 'error',
        title: responseData.success ? 'Success' : 'Error',
        text: responseData.message,
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3000,  // Show for 3 seconds
    });

    if (responseData.success) {
        const receiptWindow = window.open('', 'PRINT', 'height=1000,width=800'); // Larger dimensions for better view
        receiptWindow.document.write(`
            <html>
                <head>
                    <title>Receipt</title>
                    <style>
                        body {
                            margin: 0;
                            padding: 0;
                            width: 257mm; /* Set the receipt width to 257mm */
                            height: 80mm; /* Set the receipt height to 80mm */
                        }

                        .receipt-container {
                            padding: 10px;
                            width: 100%;
                            box-sizing: border-box;
                            font-family: Arial, sans-serif;
                            font-size: 12px; /* Adjust font size for better fit */
                        }

                        h3 {
                            font-size: 16px;
                            margin: 0 0 10px;
                            text-align: center;
                            text-transform: uppercase;
                        }

                        p, ul {
                            margin: 5px 0;
                            font-size: 12px;
                        }

                        h4 {
                            font-size: 14px;
                            margin-bottom: 5px;
                        }

                        table {
                            width: 100%;
                            border-collapse: collapse;
                            margin-top: 10px;
                        }

                        table th, table td {
                            font-size: 12px;
                            padding: 5px;
                            text-align: left;
                            border-bottom: 1px solid #000;
                        }

                        table th {
                            text-transform: uppercase;
                        }

                        table td {
                            border-bottom: 1px dashed #ccc;
                        }

                        hr {
                            border: 0;
                            border-top: 1px dashed #000;
                            margin: 10px 0;
                        }

                        @media print {
                            @page {
                                margin: 0;
                                size: 257mm 80mm;
                            }

                            body {
                                margin: 0;
                                padding: 0;
                                width: 257mm;
                                height: 80mm;
                            }

                            .receipt-container {
                                font-size: 10px;
                                padding: 5px;
                            }

                            h3 {
                                font-size: 14px;
                                margin: 0 0 5px;
                            }

                            h4 {
                                font-size: 12px;
                                margin-bottom: 3px;
                            }

                            table th, table td {
                                font-size: 10px;
                                padding: 4px;
                            }
                        }
                    </style>
                </head>
                <body onload="window.print()">
                    <div class="receipt-container">
                        ${responseData.receipt}
                    </div>
                </body>
            </html>
        `);
        receiptWindow.document.close();
        receiptWindow.focus();
    }
})
.catch(error => {
    processingToast.close(); // Close the processing toast
    console.error('Error:', error);
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Something went wrong!',
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3000,  // Show for 3 seconds
    });
});
});



// Mark bill as pending



// Event listener for the Mark Bill as Pending button
pendingBillButton.addEventListener('click', function () {
const data = {
    total_price: totalPrice,
    paid_amount: parseFloat(paidAmountInput.value),
    payment_method: paymentMethodInput.value,
    customer_name: customerNameInput.value,
    discount: discountInput.value,
    price_after_discount: priceAfterDiscount.value,
    products: getProductDetails(),
};

// Show processing toast
const processingToast = Swal.fire({
    title: 'Processing...',
    text: 'Please wait while we process your request.',
    icon: 'info',
    toast: true,
    position: 'top',
    showConfirmButton: false,
    timer: 5000,  // Show for 5 seconds
    didOpen: () => {
        Swal.showLoading();
    }
});

fetch('/mark/pending-bill', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify(data)
})
.then(response => response.json())
.then(responseData => {
    processingToast.close(); // Close the processing toast

    Swal.fire({
        icon: responseData.success ? 'success' : 'error',
        title: responseData.success ? 'Success' : 'Error',
        text: responseData.message,
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3000,  // Show for 3 seconds
    });

    if (responseData.success) {
        resetPaymentPage();
    }
})
.catch(error => {
    processingToast.close(); // Close the processing toast

    console.error('Error:', error);
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Something went wrong!',
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3000,  // Show for 3 seconds
    });
});
});


    // Reset the payment page
    function resetPaymentPage() {
        productList.innerHTML = `
            <tr>
                <td colspan="4" class="text-center text-muted">No products scanned yet.</td>
            </tr>
        `;
        barcodeInput.value = '';
        customerNameInput.value = '';
        paymentMethodInput.value = '';
        paidAmountInput.value = '';
        remainingAmountElement.value = '';
        totalPrice = 0;
        totalPriceElement.textContent = totalPrice.toFixed(2);
        Object.keys(productMap).forEach(key => delete productMap[key]);
    }
});

    </script>
<script>
    function updatePriceAfterDiscount() {
        const originalPrice = parseFloat(document.getElementById('total-price').textContent) || 0;
        const discountPercentage = parseFloat(document.getElementById('discount').value) || 0;
        
        const discountedPrice = originalPrice - (originalPrice * (discountPercentage / 100));
        document.getElementById('price-after-discount').value = discountedPrice.toFixed(2);

        updateRemaining(); // Update remaining balance after discount is applied
    }

    function updateRemaining() {
        const discountedPrice = parseFloat(document.getElementById('price-after-discount').value) || 0;
        const paidAmount = parseFloat(document.getElementById('paid-amount').value) || 0;

        let remainingAmount = paidAmount - discountedPrice;

        if (remainingAmount < 0) {
            // If the paid amount is less than the discounted price, show the remaining balance
            document.getElementById('remaining-amount').value = remainingAmount.toFixed(2);
        } else {
            // If the paid amount is greater than the discounted price, show the refund amount
            document.getElementById('remaining-amount').value = `Refund: ${remainingAmount.toFixed(2)}`;
        }
    }
</script>
<script>
   $(document).ready(function () {
    // Search by Shop Name Button
    $('#searchShopName').on('click', function () {
        let shopName = $('#shopNameInput').val();
        if (shopName.length > 2) {
            $.ajax({
                url: "{{ route('search.shop.name') }}",
                method: "POST",
                data: {
                    shop_name: shopName,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    $('#shopNameResults').empty();
                    if (data.length > 0) {
                        data.forEach(shop => {
                            $('#shopNameResults').append(
                                `<li class="list-group-item shop-result" data-name="${shop.shop_name}">
                                    ${shop.shop_name}
                                </li>`
                            );
                        });
                    } else {
                        $('#shopNameResults').append('<li class="list-group-item text-danger">No results found.</li>');
                    }
                }
            });
        }
    });

    // Search by Unique ID Button
    $('#searchUniqueId').on('click', function () {
        let uniqueId = $('#uniqueIdInput').val();
        if (uniqueId.length > 2) {
            $.ajax({
                url: "{{ route('search.unique.id') }}",
                method: "POST",
                data: {
                    unique_id: uniqueId,
                    _token: "{{ csrf_token() }}"
                },
                success: function (data) {
                    $('#uniqueIdResults').empty();
                    if (data) {
                        $('#uniqueIdResults').append(
                            `<li class="list-group-item unique-id-result" data-name="${data.shop_name}">
                                ${data.shop_name}
                            </li>`
                        );
                    } else {
                        $('#uniqueIdResults').append('<li class="list-group-item text-danger">No results found.</li>');
                    }
                }
            });
        }
    });
});

</script>



</x-admin-layout>
