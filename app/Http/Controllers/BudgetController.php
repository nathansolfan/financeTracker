<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class BudgetController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
    $query = $user->budgets();

    // Apply the search filters
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($query) use ($search) {
            $query->where('description', 'like', '%' . $search . '%')
                  ->orWhere('category', 'like', '%' . $search . '%')
                  ->orWhere('month', 'like', '%' . $search . '%');
        });
    }

    // Filter by category
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    // Filter by month
    if ($request->filled('month')) {
        $query->where('month', 'like', $request->month . '%');
    }

    // Retrieve filtered budgets
    $budgets = $query->latest()->paginate(10);

    // Calculate budget details
    $totalBudget = 0;
    $totalSpent = 0;
    foreach ($budgets as $budget) {
        $budget->total_expenses = $user->expenses()
            ->where('category', $budget->category)
            ->whereMonth('date', date('m', strtotime($budget->month)))
            ->sum('amount');
        $budget->remaining_budget = $budget->amount - $budget->total_expenses;
        $budget->over_budget = $budget->remaining_budget < 0;

        $totalBudget += $budget->amount;
        $totalSpent += $budget->total_expenses;
    }

    $remainingBudget = $totalBudget - $totalSpent;

    // **Fix for undefined $categories** - Fetch unique categories from budgets
    $categories = $user->budgets()->distinct('category')->pluck('category');

    // Fetch expenses by category (if needed for additional features)
    $expensesByCategory = $user->expenses()
        ->whereMonth('date', now()->month)
        ->selectRaw('category, SUM(amount) as total')
        ->groupBy('category')
        ->pluck('total', 'category');

    return view('budgets.index', compact(
        'budgets',
        'totalBudget',
        'totalSpent',
        'remainingBudget',
        'expensesByCategory',
        'categories'
    ));
}


    public function create()
    {
        return view('budgets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'month' => 'required|date',
        ]);

        $user = Auth::user();
        $user->budgets()->create($validated);

        return redirect()->route('budgets.index')->with('success', 'Budget has been added');
    }

    public function edit($id)
    {
        $budget = Auth::user()->budgets()->findOrFail($id);
        return view('budgets.edit', compact('budget'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category' => 'nullable|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'month' => 'required|date',
        ]);

        $budget = Auth::user()->budgets()->findOrFail($id);
        $budget->update($validated);

        return redirect()->route('budgets.index')->with('success', 'Budget has been updated');
    }

    public function destroy($id)
    {
        $budget = Auth::user()->budgets()->findOrfail($id);
        $budget->delete();

        return redirect()->route('budgets.index')->with('success', 'Budget has been deleted');
    }


    public function export()
    {
        $user = Auth::user();
        $budgets = $user->budgets()->get();

        $csvData = "Category,Budget,Spent,Remaining\n";

        foreach ($budgets as $budget) {
            $totalExpenses = $user->expenses()
            ->where('category', $budget->category)
            ->whereMonth('date', date('m', strtotime($budget->month)))
            ->sum('amount');

            $remainingBudget = $budget->amount - $totalExpenses;

            $csvData .= "{$budget->category},{$budget->amount},{$totalExpenses},{$remainingBudget}\n";
        }

        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="budgets.csv"',
        ]);
    }



}
