<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mpdf\Mpdf;
use PDF;
    use Carbon\Carbon;
    
class BillController extends Controller
{
    public function show($id)
    {
        $bill = Bill::findOrFail($id);

        return response()->json([
            'customer_name' => $bill->customer_name,
            'total_price' => number_format($bill->total_price, 2),
            'paid_amount' => number_format($bill->paid_amount, 2),
            'remaining_balance' => number_format($bill->remaining_balance, 2),
            'payment_method' => ucfirst($bill->payment_method),
            'status' => ucfirst($bill->status),
            'products' => json_decode($bill->products),
            'unique_id' => $bill->unique_id, // Add unique ID to the response
        ]);
    }

    public function storeBill(Request $request)
{
    // Validate input
    $request->validate([
        'total_price' => 'required|numeric',
        'paid_amount' => 'required|numeric',
        'payment_method' => 'required|string',
        'products' => 'required|array',
        'customer_name' => 'required|string',
        'products.*.name' => 'required|string', // Ensure 'name' exists for each product
        'products.*.quantity' => 'required|numeric|min:0', // Ensure 'quantity' is numeric and non-negative
        'price_after_discount' => 'nullable|numeric', // Validate if price_after_discount is provided
        'discount' => 'nullable|numeric', // Validate discount amount
    ]);

    $products = $request->products;

    // Determine the price to use
    $totalPrice = $request->price_after_discount ?? $request->total_price;

    // Calculate the remaining balance
    $remainingBalance = $totalPrice - $request->paid_amount;

    // Determine the status
    $status = $remainingBalance <= 0 ? 'paid' : 'due';

    // Generate a unique 5-digit alphanumeric ID
    do {
        $uniqueId = mt_rand(10000, 99999); // Generate a 5-digit numeric string
    } while (Bill::where('unique_id', $uniqueId)->exists()); // Ensure it's unique

    // Prepare discount details
    $discountDetails = [
        'total_discount' => $request->discount ?? 0,
        'total_amount' => $request->total_price,
        'total_amount_after_discount' => $totalPrice,
    ];

    // Save the bill
    $bill = Bill::create([
        'user_id' => Auth::id(),
        'customer_name' => $request->customer_name,
        'total_price' => $totalPrice,
        'paid_amount' => $request->paid_amount,
        'remaining_balance' => $remainingBalance,
        'payment_method' => $request->payment_method,
        'products' => json_encode($products),
        'status' => $status,
        'unique_id' => $uniqueId,
        'discount' => $request->discount ?? 0,
        'discount_details' => json_encode($discountDetails),
    ]);

    // Update product stock
    foreach ($products as $product) {
        $productInStock = Product::where('name', $product['name'])->first();
        if ($productInStock) {
            $productInStock->quantity = max(0, $productInStock->quantity - $product['quantity']); // Ensure no negative stock
            $productInStock->save();
        }
    }

    // Prepare the receipt HTML
    $receiptHtml = view('partials.receipt', [
        'shop_name' => 'My Shop',
        'printed_by' => auth()->user()->name ?? 'System',
        'customer_name' => $request->customer_name,
        'products' => $products,
        'total_price' => $totalPrice,
        'paid_amount' => $request->paid_amount,
        'remaining_balance' => $remainingBalance,
        'status' => $status,
        'payment_method' => $request->payment_method,
        'unique_id' => $uniqueId, // Pass unique ID to the receipt
        'discount_details' => $discountDetails,
    ])->render();

    return response()->json([
        'success' => true,
        'message' => 'Bill paid successfully, and product quantities updated.',
        'receipt' => $receiptHtml,
    ]);
}



public function markAsPending(Request $request)
{
    // Validate input
    $request->validate([
        'total_price' => 'nullable|numeric',
        'paid_amount' => 'nullable|numeric',
        'payment_method' => 'nullable|string',
        'products' => 'nullable|array',
        'customer_name' => 'nullable|string',
        'products.*.name' => 'nullable|string', // Ensure 'name' exists for each product
        'products.*.quantity' => 'nullable|numeric|min:0', // Ensure 'quantity' is numeric and non-negative
        'price_after_discount' => 'nullable|numeric', // Validate if price_after_discount is provided
        'discount' => 'nullable|numeric', // Validate discount amount
    ]);

    $products = $request->products;

    // Determine the price to use
    $totalPrice = $request->price_after_discount ?? $request->total_price;

    // Calculate the remaining balance
    $remainingBalance = $totalPrice - $request->paid_amount;

    // Determine the status

    // Generate a unique 5-digit alphanumeric ID
    do {
        $uniqueId = mt_rand(10000, 99999); // Generate a 5-digit numeric string
    } while (Bill::where('unique_id', $uniqueId)->exists()); // Ensure it's unique

    // Prepare discount details
    $discountDetails = [
        'total_discount' => $request->discount ?? 0,
        'total_amount' => $request->total_price,
        'total_amount_after_discount' => $totalPrice,
    ];

    // Save the bill
    $bill = Bill::create([
        'user_id' => Auth::id(),
        'customer_name' => $request->customer_name,
        'total_price' => $totalPrice,
        'paid_amount' => $request->paid_amount,
        'remaining_balance' => $remainingBalance,
        'payment_method' => $request->payment_method,
        'products' => json_encode($products),
        'status' => 'pending',
        'unique_id' => $uniqueId,
        'discount' => $request->discount ?? 0,
        'discount_details' => json_encode($discountDetails),
    ]);

   

    return response()->json([
        'success' => true,
        'message' => 'Bill marked as pending successfully!',
        'data' => $bill,
    ]);
}


   

public function index(Request $request)
{
    // Filters
    $query = Bill::query();

    // Search by unique ID, customer name, status, payment method, or paid amount
    if ($request->has('search')) {
        $query->where(function ($query) use ($request) {
            $query->where('customer_name', 'like', '%' . $request->search . '%')
                ->orWhere('status', 'like', '%' . $request->search . '%')
                ->orWhere('payment_method', 'like', '%' . $request->search . '%')
                ->orWhere('unique_id', 'like', '%' . $request->search . '%')
                ->orWhere('paid_amount', 'like', '%' . $request->search . '%');
        });
    }

    // Search by start date and end date
    if ($request->has('start_date') && $request->has('end_date')) {
        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
    }

    // Get all bills with pagination
    $bills = $query->orderBy('created_at', 'desc')->paginate(10);

    // Earnings Calculations
    $todayEarnings = Bill::whereDate('created_at', today())->sum('total_price');
    $weeklyEarnings = Bill::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_price');
    $monthlyEarnings = Bill::whereMonth('created_at', now()->month)->sum('total_price');
    
    // Monthly earnings for paid bills only
    $paidMonthlyEarnings = Bill::whereMonth('created_at', now()->month)->where('status', 'paid')->sum('total_price');
    $totalPaidAmount = $query->where('status', 'paid')->sum('total_price');

    // Pending bills total
    $pendingBillsTotal = Bill::where('status', 'pending')->sum('total_price');

    return view('bills.index', compact('bills', 'todayEarnings', 'weeklyEarnings', 'monthlyEarnings', 'paidMonthlyEarnings', 'pendingBillsTotal','totalPaidAmount'));
}



  public function pendingbills(Request $request)
{
    // Filters
    $query = Bill::query();

    // Filter only pending bills
    $query->where('status', 'pending');

    // Search by customer name, status, payment method, or unique ID (bill id)
    if ($request->has('search')) {
        $query->where(function ($query) use ($request) {
            $query->where('customer_name', 'like', '%' . $request->search . '%')
                ->orWhere('payment_method', 'like', '%' . $request->search . '%')
                ->orWhere('unique_id', 'like', '%' . $request->search . '%'); // Use like for unique_id as well
        });
    }

    // Get all pending bills with pagination
    $bills = $query->orderBy('created_at', 'desc')->paginate(10);

    // Earnings Calculations
    $todayEarnings = Bill::whereDate('created_at', today())->sum('total_price');
    $weeklyEarnings = Bill::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_price');
    $monthlyEarnings = Bill::whereMonth('created_at', now()->month)->sum('total_price');

    // Pending bills total
    $pendingBillsTotal = Bill::where('status', 'pending')->sum('total_price');

    return view('bills.index', compact('bills', 'todayEarnings', 'weeklyEarnings', 'monthlyEarnings', 'pendingBillsTotal'));
}


public function showDetails($id)
{
    $bill = Bill::findOrFail($id); // Find the bill by ID
    $products = json_decode($bill->products, true); // Decode the products JSON data if necessary

    return view('bills.details', compact('bill', 'products'));
}



    public function getProducts(Bill $bill)
    {
        // Decode the product data stored as JSON
        $productData = json_decode($bill->products, true);

        if (is_array($productData)) {
            $products = collect($productData)->map(function ($product) {
                return [
                    'name' => $product['name'],
                    'quantity' => $product['quantity'],
                ];
            });

            return response()->json(['products' => $products]);
        }

        return response()->json(['error' => 'Invalid product data format'], 400);
    }

    public function showRefundPage(Bill $bill)
{
    // Decode the product data
    $productData = json_decode($bill->products, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        abort(400, 'Invalid product data format: ' . json_last_error_msg());
    }

    return view('bills.refund', [
        'bill' => $bill,
        'products' => $productData
    ]);
}

    // Process the refund


    public function processRefund(Request $request)
    {
        // Validate the request
        if (!$request->has('bill_id')) {
            return response()->json(['error' => 'Bill ID is required'], 400);
        }

        $billId = $request->input('bill_id');
        $refundQuantities = $request->input('refund_quantity', []);

        if (!is_array($refundQuantities)) {
            return response()->json(['error' => 'Refund quantity must be an array'], 400);
        }

        $bill = Bill::find($billId);

        if (!$bill) {
            return response()->json(['error' => 'Bill not found'], 404);
        }

        // Decode the product data from the bill
        $productData = json_decode($bill->products, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid product data format: ' . json_last_error_msg()], 400);
        }

        // Loop through each refund quantity
        foreach ($refundQuantities as $barcode => $refundQuantity) {
            $productFound = false;

            // Loop through the products in the bill to match the barcode
            foreach ($productData as &$product) {
                if ($product['barcode'] == $barcode) {
                    $productFound = true;

                    // Ensure refund quantity does not exceed available quantity
                    if ($refundQuantity > $product['quantity']) {
                        return response()->json([
                            'error' => "Refund quantity exceeds available quantity for product with barcode: $barcode"
                        ], 400);
                    }

                    // Deduct refund quantity from the bill's product data
                    $product['quantity'] -= $refundQuantity;

                    // Update the refund status
                    $product['refund_status'] = $product['quantity'] == 0 ? 'fully refunded' : 'partial';

                   // First, try to find the product using the barcode
                    $productModel = Product::where('barcode', $barcode)->first();

                    // If product not found by barcode, try finding by name
                    if (!$productModel) {
                        $productModel = Product::where('name', $barcode)->first(); // Here, 'name' is checked as fallback
                    }

                    if ($productModel) {
                        // Deduct the refund quantity from the Product's quantity in the database
                        $productModel->quantity += $refundQuantity;
                        $productModel->save(); // Save the updated product
                    } else {
                        // Handle the case where the product is not found by barcode or name
                        return response()->json(['error' => 'Product not found with barcode or name: ' . $barcode], 404);
                    }

                }
            }

            if (!$productFound) {
                return response()->json(['error' => 'Product not found with barcode: ' . $barcode], 404);
            }
        }

        // Save the updated product data back to the Bill
        $bill->products = json_encode($productData);
        $bill->status = 'refunded'; // Update the bill status
        $bill->save();

        // Prepare data for the receipt
        $data = [
            'bill' => $bill,
            'productData' => $productData,
            'refundQuantities' => $refundQuantities,
            'user' => auth()->user(), // The user who initiated the refund
        ];

        // Generate the receipt PDF using MPDF
        $mpdf = new Mpdf();

        // Render the view to HTML
        $html = view('pdf.refund_receipt', $data)->render();

        // Write the HTML content to the PDF
        $mpdf->WriteHTML($html);

        // Return the PDF to the user for download
        return response()->streamDownload(function () use ($mpdf) {
            echo $mpdf->Output('', 'S');
        }, 'refund_receipt_' . $billId . '.pdf');
    }


    public function markAsPaid(Request $request, $id)
    {
        $bill = Bill::findOrFail($id);
    
        if ($bill->status === 'paid') {
            return redirect()->back()->with('error', 'This bill is already paid.');
        }
    
        // Update status to paid
       
        
        // Adjust inventory$bill->products
        $getdata= $bill->products;
        $products = json_decode($getdata, true);
        
        // Decode JSON data
        foreach ($products as $product) {
            // Try to find the product by barcode first
            $productModel = Product::where('name', $product['name'])->first();

    
            // If product not found by barcode, try to find by name
            if (!$productModel) {
                $productModel = Product::where('barcode', $product['barcode'])->first();

            }
    
            if (!$productModel) {
                return redirect()->back()->with('error', 'Product not found: ' . $product['barcode'] . ' / ' . $product['name']);
            }
    
            // Check if there's enough stock for the product
            if ($productModel->quantity < $product['quantity']) {
                return redirect()->back()->with('error', 'Insufficient stock for product: ' . $product['barcode'] . ' / ' . $product['name']);
            }
    
            // Update stock based on the quantity sold
            $productModel->quantity -= $product['quantity'];
            $productModel->save();
        }
    
        $bill->status = 'paid';
        $bill->updated_at = now();  // Set the updated_at to the current date and time
        $bill->save();


        // Generate a PDF for printing using Mpdf
        $pdf = new Mpdf();
        $view = view('bills.print', compact('bill'))->render();  // Render the Blade view to HTML
    
        // Write HTML content to the PDF
        $pdf->WriteHTML($view);
    
        // Output the PDF (can be downloaded or viewed in the browser)
        return $pdf->Output('Bill-' . $bill->id . '.pdf', 'D');  // 'D' for download, 'I' for inline view
    }
    

    
    public function exportLastMonth()
    {
        $startOfMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfMonth = Carbon::now()->subMonth()->endOfMonth();
    
        $bills = Bill::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
    
        $pdf = PDF::loadView('pdf.last_month_bills', compact('bills'))->setPaper('a4', 'landscape');
    
        return $pdf->download('last_month_bills.pdf');
    }
     
}
