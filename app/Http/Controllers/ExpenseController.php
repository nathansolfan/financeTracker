<?php

namespace App\Http\Controllers;

use App\Services\ChartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{



    public function index()
    {
        // retrieve all expenses
        /** @var User $user */
        $user = Auth::user();
        $expenses = $user->expenses()->latest()->paginate(10);
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
}
