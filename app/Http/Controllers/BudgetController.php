<?php

namespace App\Http\Controllers;

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

        // Calculate budget utilizationj for each budget category
        foreach ($budgets as $budget) {
            $budget->total_expenses = $user->expenses()
            ->where('category', $budget->category)
            ->whereMonth('date', date('m', strtotime($budget->month)))
            ->sum('amount'); //Total expenses for the category in the budgets month
            $budget->remaining_budget = $budget->amount - $budget->total_expenses;  // Remaining budget
        }

        return view('budgets.index', compact('budgets'));
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
}
