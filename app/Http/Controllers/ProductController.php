<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Milon\Barcode\DNS1D;
use App\Models\Discount;
use App\Models\Category;

use Dompdf\Dompdf;
use Dompdf\Options;

class ProductController extends Controller
{
    // Product Listing with Search
    public function updateWholesalePrices()
    {
        // Fetch all products
        $products = Product::all();

        foreach ($products as $product) {
            // Set hole_sale_percentage to 20%
            $product->hole_sale_percentage = 20;

            // Calculate hole_sale_price as 80% of the sell_price
            if ($product->sell_price) {
                $product->hole_sale_price = $product->sell_price * 0.8; // 80% of sell_price
                $product->save();
            }
        }

        return response()->json([
            'message' => 'Wholesale prices updated successfully for all products.',
        ], 200);
    }


    public function updateProductProfit()
        {
            // Fetch all products
            $products = Product::all();

            // Update product_profit for each product
            foreach ($products as $product) {
                if ($product->buy_price && $product->sell_price) {
                    $product->product_profit = $product->sell_price - $product->buy_price;
                    $product->save();
                }
            }

            return response()->json([
                'message' => 'Product profit updated successfully for all products.',
            ], 200);
        }


    public function index(Request $request)
{
    // Check if the user is authenticated
    if (!auth()->check()) {
        return redirect('/')->with('error', 'You need to log in to access this page.');
    }

    // Check if the user has the required permission to view the products page
    if (!auth()->user()->can('Products')) {
        return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
    }

    // Capture the search query and other filters from the request
    $search = $request->input('search');
    $barcode = $request->input('barcode');
    $category = $request->input('category');
    $quantity = $request->input('quantity');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    // Build the query based on the search criteria
    $products = Product::query()
        ->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%$search%")
                ->orWhere('barcode', 'like', "%$search%");
        })
        ->when($barcode, function ($query, $barcode) {
            return $query->where('barcode', 'like', "%$barcode%");
        })
        ->when($category, function ($query, $category) {
            return $query->where('categories_id', $category);
        })
        ->when($quantity, function ($query, $quantity) {
            return $query->where('quantity', '>=', $quantity);  // Search by quantity
        })
        ->when($startDate, function ($query, $startDate) {
            return $query->whereDate('created_at', '>=', $startDate);
        })
        ->when($endDate, function ($query, $endDate) {
            return $query->whereDate('created_at', '<=', $endDate);
        })
        ->orderBy('updated_at', 'desc')
        ->paginate(10);

    // Fetch categories for dropdown filter (assuming you have a Category model)
    $categories = Category::all();

    return view('products.index', compact('products', 'search', 'barcode', 'category', 'quantity', 'startDate', 'endDate', 'categories'));
}


public function exportProducts(Request $request)
{
    // Decode JSON request to get the categories
    $categoryIds = $request->input('categories', []);

    if (empty($categoryIds)) {
        return response()->json(['error' => 'No categories selected'], 400);
    }

    // Fetch products based on selected categories
    $products = Product::whereIn('categories_id', $categoryIds)->get();
    
    $shopName = "Phone Point"; // Replace with actual shop name
    $currentDate = now()->format('Y-m-d');  // Current date only (e.g., 2025-01-01)
    $currentTime = now()->format('H-i-s');  // Current time only (e.g., 14-30-00)
    
    // Specify the path where the PDF will be stored (using date for the file name)
    $pdfPath = public_path("pdf/products-export-{$currentDate}.pdf");

    // Check if a file with the same date already exists, and delete it if it does
    if (file_exists($pdfPath)) {
        unlink($pdfPath); // Delete the existing file
    }

    // Create a new Dompdf instance and load the HTML view
    $pdf = new Dompdf();
    $pdf->loadHtml(view('products.export_pdf', compact('products', 'shopName', 'currentDate', 'currentTime'))->render());
    $pdf->setPaper('A4', 'landscape');
    $pdf->render();

    // Save the generated PDF to the specified path
    file_put_contents($pdfPath, $pdf->output());

    // Return the file path to allow the user to download the PDF
    return response()->download($pdfPath);
}



    
    // Show Create Form
    public function create()
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }
    
        if (!auth()->user()->can('add prodcut')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
    
        $categories = Category::all(); // Fetch all categories
        return view('products.create', compact('categories'));
    }
    

    // Store New Product
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'buy_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'categories_id' => 'required|exists:categories,id',

        ]);

        try {
            $discountPercentage = $request->discount_percentage ?? 0;
            $discountPrice = $request->sell_price - ($request->sell_price * ($discountPercentage / 100));

            $barcode = $request->barcode ?? substr(time(), -4) . rand(10, 99);

            // Check for duplicate product name or barcode
            $existingProduct = Product::where('name', $request->name)
                                      ->orWhere('barcode', $barcode)
                                      ->first();

            if ($existingProduct) {
                // If a product with the same name or barcode exists, throw an exception
                return redirect()->back()->with('error', 'A product with this name or barcode already exists.');
            }

            // Create the new product
            Product::create([
                'name' => $request->name,
                'buy_price' => $request->buy_price,
                'sell_price' => $request->sell_price,
                'quantity' => $request->quantity,
                'hole_sale_price' => $request->hole_sale_price,
                'categories_id' => $request->categories_id,
                'product_profit'=> $request->product_profit,
                'hole_sale_percentage'=>$request->hole_sale_percentage,
                'barcode' => $barcode,
                'discount_percentage' => $discountPercentage,
                'discount_price' => $discountPrice,
            ]);

            return redirect()->route('products.index')->with('success', 'Product added successfully!');

        } catch (\Exception $e) {
            // Handle any unexpected errors and display a generic error message
            return redirect()->back()->with('error', 'An error occurred while adding the product. Please try again.');
        }
    }


    // Show Edit Form
    public function edit(Product $product)
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('edit product')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
        $categories = Category::all(); // Fetch all categories

        return view('products.edit', compact('product','categories'));
    }

    // Update Product
    public function update(Request $request, Product $product)
    {

        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'buy_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'categories_id' => 'required|exists:categories,id',

        ]);

        // Calculate the discount price if a discount percentage is provided
        $discountPercentage = $request->discount_percentage ?? 0; // Default to 0 if not provided
        $discountPrice = $request->sell_price - ($request->sell_price * ($discountPercentage / 100));

        // Update the product attributes
        $product->update([
            'name' => $request->name,
            'buy_price' => $request->buy_price,
            'sell_price' => $request->sell_price,
            'hole_sale_price' => $request->hole_sale_price,
            'product_profit'=> $request->product_profit,
            'hole_sale_percentage'=>$request->hole_sale_percentage,
            'quantity' => $request->quantity,
            'discount_percentage' => $discountPercentage,
            'discount_price' => $discountPrice,
            'categories_id' => $request->categories_id,
            // Assuming you have a 'discount_price' column in the products table
        ]);

        // Redirect to the product index page with a success message
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }


    // Delete Product
    public function destroy(Product $product)
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('delete product')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    // Print Barcode

    public function printBarcode(Product $product)
    {
        $dns1d = new DNS1D(); // Create an instance of DNS1D
        $barcode = $dns1d->getBarcodePNG($product->barcode, "C128", 1.5, 25);
        return view('products.barcode', compact('product', 'barcode'));
    }
    public function scanMultiple()
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }
    
        // Check if the user has permission
        if (!auth()->user()->can('scan')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
    
        // Fetch active discounts
        $activeDiscounts = Discount::where('status', 'active')->get();
    
        // Pass active discounts to the view
        return view('products.scan-multiple', compact('activeDiscounts'));
    }
    
    public function getProductDetails($identifier)
    {
        // Search by barcode or name
        $product = Product::where('barcode', $identifier)
            ->orWhere('name', 'like', '%' . $identifier . '%')
            ->get(); // Use get() to retrieve multiple results
    
        if ($product->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No products match the entered barcode or name!',
            ]);
        }
    
        // If exactly one product is found, return its details
        if ($product->count() == 1) {
            $product = $product->first();  // Get the first (and only) product
            if ($product->quantity > 0) {
                $sellPrice = (float)$product->sell_price;
                $discountPercentage = (float)($product->discount_percentage ?? 0);
                $discountedPrice = $sellPrice - ($sellPrice * $discountPercentage / 100);
    
                return response()->json([
                    'success' => true,
                    'product' => [
                        'name' => $product->name,
                        'sell_price' => $sellPrice,
                        'discount_percentage' => $discountPercentage,
                        'discounted_price' => $discountedPrice,
                        'quantity' => $product->quantity,
                        'buy_price' => (float)$product->buy_price, // Include buy price
                        // available quantity
                    ],
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is out of stock!',
                ]);
            }
        }
    
        // If multiple products are found, return a list of products
        return response()->json([
            'success' => true,
            'products' => $product->map(function ($prod) {
                return [
                    'id' => $prod->id,
                    'name' => $prod->name,
                    'sell_price' => (float)$prod->sell_price,
                    'discount_percentage' => (float)($prod->discount_percentage ?? 0),
                    'discounted_price' => (float)($prod->sell_price - ($prod->sell_price * ($prod->discount_percentage ?? 0) / 100)),
                    'quantity' => $prod->quantity,
                    'buy_price' => (float)$prod->buy_price, // Include buy price

                ];
            }),
        ]);
    }
    







}
