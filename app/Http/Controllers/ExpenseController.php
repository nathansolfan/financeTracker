<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        // retrieve all expenses
        /** @var User $user */
        $user = Auth::user();
        $query = $user->expenses();

        // Apply the search
        if ($request->filled('search')) {

            $search = $request->search;
            $query->where(function ($query) use ($search) {
                $query->where('description', 'like', '%' . $search . '%')
                      ->orWhere('category', 'like', '%' . $search . '%')
                      ->orWhere('amount', 'like', '%' . $search . '%');
            });
        }

    // $expenses = $user->expenses()->latest()->paginate(10);
        $expenses = $query->latest()->paginate(10);

        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
        ]);

        $user = Auth::user();
        $user->expenses()->create($validated);

        return redirect()->route('expenses.index')->with('success', 'Expensed added!');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $expense = $user->expenses()->findOrFail($id);

        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
        ]);

        $user = Auth::user();
        $expense = $user->expenses()->findOrFail($id);
        $expense->update($validated);

        return redirect()->route('expenses.index')->with('success', 'Expense has been updated');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $expense = $user->expenses()->findOrFail($id);
        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Expense hasbeen deleted');
    }
}
