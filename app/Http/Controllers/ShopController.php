<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('manage shop')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }

        $search = $request->input('search');

        $shops = Shop::when($search, function ($query, $search) {
            $query->where('shop_name', 'LIKE', "%{$search}%")
                  ->orWhere('owner_name', 'LIKE', "%{$search}%")
                  ->orWhere('shop_location', 'LIKE', "%{$search}%")
                  ->orWhere('near_shop', 'LIKE', "%{$search}%")
                  ->orWhere('reference_name', 'LIKE', "%{$search}%")
                  ->orWhere('reference_shop', 'LIKE', "%{$search}%")
                  ->orWhere('balance', 'LIKE', "%{$search}%");
        })->paginate(10);

        return view('shops.index', compact('shops'));
    }


    public function create()
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('add shop')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }

        return view('shops.create');
    }

    public function store(Request $request)
{
    if (!auth()->check()) {
        return redirect('/')->with('error', 'You need to log in to access this page.');
    }

    if (!auth()->user()->can('add shop')) {
        return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
    }

    $request->validate([
        'shop_name' => 'required|string|max:255',
        'owner_name' => 'required|string|max:255',
        'shop_location' => 'required|string|max:255',
        'cnic_image' => 'required|image',
        'balance' => 'required|numeric',
        'user_id' => 'required|exists:users,id',
    ]);

    $data = $request->all();

    // Generate a 5-digit unique ID
    do {
        $uniqueId = random_int(10000, 99999); // Generate a 5-digit number
    } while (Shop::where('shop_unique_id', "PP" . $uniqueId)->exists());

    $data['shop_unique_id'] = "PP" . $uniqueId;


    if ($request->hasFile('cnic_image')) {
        $file = $request->file('cnic_image');
        $uniqueName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $uniqueName);
        $data['cnic_image'] = 'images/' . $uniqueName;
    }

    Shop::create($data);

    return redirect()->route('shops.index')->with('success', 'Shop created successfully!');
}

public function update(Request $request, Shop $shop)
{
    if (!auth()->check()) {
        return redirect('/')->with('error', 'You need to log in to access this page.');
    }

    if (!auth()->user()->can('edit shop')) {
        return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
    }

    $request->validate([
        'shop_name' => 'required|string|max:255',
        'owner_name' => 'required|string|max:255',
        'shop_location' => 'required|string|max:255',
        'balance' => 'required|numeric',
    ]);

    $data = $request->all();

    // Generate a 5-digit unique ID if it's not already set
    if (empty($shop->shop_unique_id)) {
        do {
            $uniqueId = random_int(10000, 99999); // Generate a 5-digit number
        } while (Shop::where('shop_unique_id', "PP" . $uniqueId)->exists());

        $data['shop_unique_id'] = $uniqueId;
    }

    // Handle CNIC image upload
    if ($request->hasFile('cnic_image')) {
        $file = $request->file('cnic_image');
        $uniqueName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $uniqueName);
        $data['cnic_image'] = 'images/' . $uniqueName;

        // Optional: Delete old image if exists
        if ($shop->cnic_image && file_exists(public_path($shop->cnic_image))) {
            unlink(public_path($shop->cnic_image));
        }
    }

    $shop->update($data);

    return redirect()->route('shops.index')->with('success', 'Shop updated successfully!');
}


    public function edit(Shop $shop)
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('edit shop')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }

        return view('shops.edit', compact('shop'));
    }

    public function destroy(Shop $shop)
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('delete shop')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }

        $shop->delete();
        return redirect()->route('shops.index')->with('success', 'Shop deleted successfully!');
    }
    // web.php

// ShopController.php


  public function findShop(Request $request)
{
    $query = Shop::query();

    if ($request->filled('shop_unique_id')) {
        $query->where('shop_unique_id', $request->shop_unique_id);
    }

    if ($request->filled('shop_name')) {
        $query->where('shop_name', 'like', '%' . $request->shop_name . '%');
    }

    if ($request->filled('phone_number')) {
        $query->where('phone_number', $request->phone_number);
    }

    $shop = $query->first();

    if ($shop) {
        return response()->json([
            'success' => true,
            'shop_name' => $shop->shop_name,
            'shop_unique_id' => $shop->shop_unique_id
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Shop not found'
        ]);
    }
}



}
