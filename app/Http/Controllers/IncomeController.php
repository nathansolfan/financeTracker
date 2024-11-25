<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $income = $user->incomes()->latest()->paginate(10);

        return view('incomes.index', compact('incomes'));
    }

    public function create()
    {
        return view('incomes.create', compact('incomes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'source' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        // income() is necessary to define the relationship - user_id in the incomes table t o the authenticated user
        $user = Auth::user();
        $user->incomes()->create($validated);
    }
}
