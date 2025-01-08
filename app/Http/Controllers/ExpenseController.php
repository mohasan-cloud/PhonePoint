<?php
// app/Http/Controllers/ExpenseController.php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    // Show all expenses
  
    public function index(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }
    
        if (!auth()->user()->can('manage expenses')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
    
        $query = Expense::query();
    
        // Filter by Username
        if ($request->filled('username')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->username . '%');
            });
        }
    
        // Filter by Date Range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
    
        $expenses = $query->paginate(10);
    
        // Calculate Total Cost
        $totalCost = $query->sum('cost');
    
        return view('expenses.index', compact('expenses', 'totalCost'));
    }
    

    // Show form for creating new expense
    public function create()
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('add expenses')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
        return view('expenses.create');
    }

    // Store new expense
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('add expenses')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }

        $request->validate([
            'item_name' => 'required|string|max:255',
            'cost' => 'required|numeric',
            'expense_type' => 'required',
            'description' => 'nullable|string'
        ]);

        // Add the logged-in user's ID to the expense
        $expenseData = $request->all();
        $expenseData['user_id'] = auth()->id();  // Store the user ID

        Expense::create($expenseData);

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully!');
    }
    // Show form for editing an existing expense
    public function edit($id)
    { 
         if (!auth()->check()) {
        return redirect('/')->with('error', 'You need to log in to access this page.');
    }

    if (!auth()->user()->can('edit expenses')) {
        return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
    }
        $expense = Expense::findOrFail($id);
        return view('expenses.edit', compact('expense'));
    }

    // Update the expense
    public function update(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('edit expenses')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }

        $request->validate([
            'item_name' => 'required|string|max:255',
            'cost' => 'required|numeric',
            'expense_type' => 'required',
            'description' => 'nullable|string'
        ]);

        $expense = Expense::where('user_id', auth()->id())->findOrFail($id);  // Check if the expense belongs to the logged-in user
        $expense->update($request->all());

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully!');
    }

    // Delete an expense
    public function destroy($id)
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'You need to log in to access this page.');
        }

        if (!auth()->user()->can('delete expenses')) {
            return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to view this page.');
        }
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully!');
    }
}
