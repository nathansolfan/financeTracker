<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = $user->incomes();

        // Search
        if ($request->filled('search')) {

            $search = $request->search;
            $query->where(function ($query) use ($search) {
                $query->where('amount', 'like', '%' . $search . '%')
                ->orWhere('source', 'like', '%' . $search . '%');
            });
        }
    // $incomes = $user->incomes()->latest()->paginate(10);
        $incomes = $query->latest()->paginate(10);

        return view('incomes.index', compact('incomes'));
    }

    public function create()
    {
        return view('incomes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'source' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $user = Auth::user();
        $user->incomes()->create($validated);

        return redirect()->route('incomes.index')->with('success', 'Income has been created');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $income = $user->incomes()->findOrFail($id);

        return view('incomes.edit', compact('income'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'source' => 'required|numeric|min:0.01',
            'amount' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $user = Auth::user();
        $incomes = $user->incomes()->findOrFail($id);
        $incomes->update($validated);

        return redirect()->route('incomes.index')->with('success', 'Income has been updated');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $incomes = $user->incomes()->findOrFail($id);
        $incomes->delete();

        return redirect()->route('incomes.index')->with('success', 'Income has been deleted');
    }
}
