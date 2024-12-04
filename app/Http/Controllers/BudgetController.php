<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = $user->budgets();

        // Apply the search
        if ($request->filled('search')) {

            $search = $request->search;
            $query->where(function ($query) use ($search) {
                $query->where('description', 'like', '%' . $search . '%')
                      ->orWhere('category', 'like', '%' . $search . '%')
                      ->orWhere('month', 'like', '%' . $search . '%');
            });
        }
        // $budgets = $user->budgets()->latest()->paginate(10);
        $budgets = $query->latest()->paginate(10);

        // Calculate budget for each category
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

        // Fetch by category
        $expensesByCategory = $user->expenses()
        ->whereMonth('date', now()->month)
        ->selectRaw('category, SUM(amount) as total')
        ->groupBy('category')
        ->pluck('total', 'category');

        return view('budgets.index',compact('budgets', 'totalBudget', 'totalSpent', 'remainingBudget', 'expensesByCategory'));
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
}
