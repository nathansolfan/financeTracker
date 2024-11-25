<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $incomes = $user->incomes()->latest()->paginate(10);

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
}
