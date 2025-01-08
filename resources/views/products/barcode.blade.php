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
                    <div class="col-lg-6">
                        <div class="col-md-12 px-4">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h4 class="mb-0">Product Barcode</h4>
                                </div>

                                <style>
                                    body {
                                        text-align: center;
                                        font-family: Arial, sans-serif;
                                        margin: 0;
                                        padding: 0;
                                    }

                                    .barcode-container {
                                        page-break-after: always;
                                    }

                                    .barcode {
                                        margin: 10px auto;
                                        width: 5cm;
                                        height: 3cm;
                                        border: 1px solid #000;
                                        padding: 10px;
                                        font-size: 10px;
                                        border-radius: 8px;
                                        text-align: center;
                                    }

                                    .barcode img {
                                        width: 100%;
                                        height: auto;
                                    }

                                    .barcode-text {
                                        font-size: 8px;
                                        font-weight: bold;
                                        margin: 5px 0;
                                    }
                                </style>

                                <label>Product Quantity: <strong>{{ $product->quantity }}</strong></label>

                                <div id="barcodeContent" >
                                    <p class="barcode-text"><strong>{{ $product->name }}</strong></p>
                                    <p class="barcode-text"><strong>Sell Price: {{ number_format($product->sell_price, 2) }}</strong></p>
                                    <img src="data:image/png;base64,{{ $barcode }}" alt="Barcode">
                                    <p class="barcode-text"><strong>{{ $product->barcode }}</strong></p>
                                </div>
                                <button id="printButton" class="btn btn-primary mt-3">Print Barcode</button>

                                <script>
                                    document.getElementById('printButton').addEventListener('click', function () {
                                        // SweetAlert popup for number of pages input
                                        Swal.fire({
                                            title: 'Enter the number of pages to print',
                                            input: 'number',
                                            inputLabel: 'Number of Pages',
                                            inputPlaceholder: 'Enter the number of pages',
                                            inputAttributes: {
                                                min: 1
                                            },
                                            showCancelButton: true,
                                            confirmButtonText: 'Print',
                                            cancelButtonText: 'Cancel',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                const numberOfPages = result.value;

                                                if (numberOfPages > 0) {
                                                    // Generate the content for the specified number of pages
                                                    let printContent = '';
                                                    for (let i = 0; i < numberOfPages; i++) {
                                                        printContent += `
                                                            <div class="barcode-container">
                                                                ${document.getElementById('barcodeContent').outerHTML}
                                                            </div>
                                                        `;
                                                    }

                                                    // Create a new window for printing
                                                    const printWindow = window.open('', '', 'width=800,height=600');
                                                    printWindow.document.write(`
                                                        <html>
                                                        <head>
                                                            <title>Print Barcode</title>
                                                            <style>
                                                                body {
                                                                    font-family: Arial, sans-serif;
                                                                    margin: 0;
                                                                    padding: 0;
                                                                    text-align: center;
                                                                }
                                                                .barcode-container {
                                                                    page-break-after: always;
                                                                }
                                                                .barcode {
                                                                    margin: 10px auto;
                                                                    width: 5cm;
                                                                    height: 3cm;
                                                                    border: 1px solid #000;
                                                                    padding: 10px;
                                                                    font-size: 7px;
                                                                    border-radius: 8px;
                                                                    text-align: center;
                                                                }
                                                                .barcode img {
                                                                    width: 50%;
                                                                    height: auto;
                                                                }
                                                                .barcode-text {
                                                                    font-size: 7px;
                                                                    font-weight: bold;
                                                                    margin: 5px 0;
                                                                }
                                                            </style> 
                                                        </head>
                                                        <body>
                                                            ${printContent}
                                                        </body>
                                                        </html>
                                                    `);
                                                    printWindow.document.close();

                                                    // Wait for the document to fully load before triggering print
                                                    printWindow.onload = function () {
                                                        setTimeout(function () {
                                                            printWindow.print();
                                                            printWindow.close();
                                                        }, 500); // Wait 0.5 seconds before printing
                                                    };
                                                } else {
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Invalid Input',
                                                        text: 'Please enter a valid number greater than zero.',
                                                    });
                                                }
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
