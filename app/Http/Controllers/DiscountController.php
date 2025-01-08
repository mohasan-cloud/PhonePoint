<?php
// app/Http/Controllers/DiscountController.php
namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('manage discounts')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
        $discounts = Discount::all();
        return view('discounts.index', compact('discounts'));
    }

    public function create()
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('add discounts')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
        return view('discounts.create');
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('add discounts')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'required|integer|between:0,100',
        ]);

        Discount::create($request->all());
        return redirect()->route('discounts.index')->with('success', 'Discount created successfully.');
    }

    public function edit(Discount $discount)
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('edit discounts')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
        return view('discounts.edit', compact('discount'));
    }

    public function update(Request $request, Discount $discount)
    {
        
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('edit discounts')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'percentage' => 'required|integer|between:0,100',
        ]);

        $discount->update($request->all());
        return redirect()->route('discounts.index')->with('success', 'Discount updated successfully.');
    }

    public function destroy(Discount $discount)
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('delete discounts')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
        $discount->delete();
        return redirect()->route('discounts.index')->with('success', 'Discount deleted successfully.');
    }
    public function toggleStatus(Discount $discount)
{
    if (!auth()->check()) {
        return redirect('/')->with('error', 'You need to log in to access this page.');
    }

    if (!auth()->user()->can('add discounts')) {
        return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
    }
    $discount->status = $discount->status === 'active' ? 'blocked' : 'active';
    $discount->save();

    return response()->json([
        'success' => true,
        'message' => 'Status updated successfully.',
        'status' => $discount->status,
    ]);
}

}
