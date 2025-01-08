<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use App\Models\ShopBill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mpdf\Mpdf;

class ShopBillController extends Controller
{
    public function listing()
{
    $shops = Shop::get(); // Variable name is $shop
    return view('shops.shopbill')->with('shops', $shops); // Pass the variable with the correct name
}
public function storeBill(Request $request)
{
    $request->validate([
        'total_price' => 'required|numeric',
        'paid_amount' => 'required|numeric',
        'payment_method' => 'required|string',
        'customer_shop_id' => 'required|string',
        'products' => 'required|array',
        'customer_name' => 'required|string',
        'products.*.name' => 'required|string',  // Ensure 'name' exists for each product
        'products.*.quantity' => 'required|numeric|min:0', // Ensure 'quantity' is numeric and non-negative
    ]);

    $products = $request->products;

    // Calculate the remaining balance
    $remainingBalance = $request->total_price - $request->paid_amount;

    // Determine the status
    $status = $remainingBalance <= 0 ? 'paid' : 'due';

    // Generate a unique 5-digit alphanumeric ID
    do {
        $uniqueId = mt_rand(10000, 99999); // Generate a 5-digit numeric string
    } while (ShopBill::where('unique_id', $uniqueId)->exists()); // Ensure it's unique


    // Save the bill
    $bill = ShopBill::create([
        'user_id' => Auth::id(),
        'customer_name' => $request->customer_name,
        'total_price' => $request->total_price,
        'paid_amount' => $request->paid_amount,
        'customer_shop_id' => $request->customer_shop_id,

        'remaining_balance' => $remainingBalance,
        'payment_method' => $request->payment_method,
        'products' => json_encode($products),
        'status' => $status,
        'unique_id' => $uniqueId, // Store the unique ID
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
        'total_price' => $request->total_price,
        'paid_amount' => $request->paid_amount,
        'remaining_balance' => $remainingBalance,
        'status' => $status,
        'payment_method' => $request->payment_method,
        'unique_id' => $uniqueId, // Pass unique ID to the receipt
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
        'total_price' => 'required|numeric',
        'paid_amount' => 'required|numeric',
        'customer_shop_id' => 'required|string',
        'payment_method' => 'required|string',
        'products' => 'required|array',
        'customer_name' => 'required|string', // Validate customer name
    ]);

    // Generate a unique 5-character alphanumeric string for unique_id
    do {
        $uniqueId = mt_rand(10000, 99999); // Generate a 5-digit numeric string
    } while (ShopBill::where('unique_id', $uniqueId)->exists()); // Ensure it's unique

    // Save the bill with status as pending
    $bill = ShopBill::create([
        'user_id' => Auth::id(),
        'customer_name' => $request->customer_name,
        'total_price' => $request->total_price,
        'customer_shop_id' => $request->customer_shop_id,
        'paid_amount' => $request->paid_amount,
        'remaining_balance' => $request->total_price - $request->paid_amount, // Corrected calculation
        'payment_method' => $request->payment_method,
        'products' => json_encode($request->products),
        'status' => 'pending',
        'unique_id' => $uniqueId, // Store the unique ID
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Bill marked as pending successfully!',
        'data' => $bill,
    ]);
}
    public function shopgetProductDetails($barcode)
{
    $product = Product::where('barcode', $barcode)->first();

    if ($product) {
        if ($product->quantity > 0) {
            return response()->json([
                'success' => true,
                'product' => [
                    'name' => $product->name,
                    'sale_price' => (float)$product->hole_sale_price, // Only sale price retained
                    'quantity' => $product->quantity, // Available quantity
                ],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product is out of stock!',
            ]);
        }
    }

    return response()->json([
        'success' => false,
        'message' => 'Barcode does not match any product!',
    ]);
}

public function index(Request $request)
{
    // Filters
    $query = ShopBill::query();

    // Search by customer name, status, payment method, or unique ID (bill id)
    if ($request->has('search')) {
        $query->where(function ($query) use ($request) {
            $query->where('customer_name', 'like', '%' . $request->search . '%')
                ->orWhere('status', 'like', '%' . $request->search . '%')
                ->orWhere('payment_method', 'like', '%' . $request->search . '%')
                ->orWhere('unique_id', 'like', '%' . $request->search . '%')// Use like for unique_id as well
                ->orWhere('customer_shop_id', 'like', '%' . $request->search . '%'); // Use like for unique_id as well

        });
    }

    // Get all bills with pagination
    $bills = $query->orderBy('created_at', 'desc')->paginate(10);

    // Earnings Calculations
    $todayEarnings = ShopBill::whereDate('created_at', today())->sum('total_price');
    $weeklyEarnings = ShopBill::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_price');
    $monthlyEarnings = ShopBill::whereMonth('created_at', now()->month)->sum('total_price');

    // Pending bills total
    $pendingBillsTotal = ShopBill::where('status', 'pending')->sum('total_price');

    return view('shops.billslisting', compact('bills', 'todayEarnings', 'weeklyEarnings', 'monthlyEarnings', 'pendingBillsTotal'));
}
public function show($id)
{
    $bill = ShopBill::findOrFail($id);

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



public function showRefundPage(ShopBill $bill)
{
    // Decode the product data
    $productData = json_decode($bill->products, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        abort(400, 'Invalid product data format: ' . json_last_error_msg());
    }

    return view('shops.refund', [
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

        $bill = ShopBill::find($billId);

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

                    // Now update the Product table
                    $productModel = Product::where('barcode', $barcode)->first();

                    if ($productModel) {
                        // Deduct the refund quantity from the Product's quantity in the database
                        $productModel->quantity += $refundQuantity;
                        $productModel->save(); // Save the updated product
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
        $html = view('pdf.shop_refund_receipt', $data)->render();

        // Write the HTML content to the PDF
        $mpdf->WriteHTML($html);

        // Return the PDF to the user for download
        return response()->streamDownload(function () use ($mpdf) {
            echo $mpdf->Output('', 'S');
        }, 'refund_receipt_' . $billId . '.pdf');
    }




    public function searchByShopName(Request $request)
    {
        $shopName = $request->input('shop_name');
        $shops = Shop::where('shop_name', 'LIKE', "%$shopName%")->get();
        return response()->json($shops);
    }

    public function searchByUniqueId(Request $request)
    {
        $uniqueId = $request->input('unique_id');
        $shop = Shop::where('shop_unique_id', $uniqueId)->first();
        return response()->json($shop);
    }


}
