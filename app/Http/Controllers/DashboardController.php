<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        //Calculate Totals
        $totalIncome = $user->incomes()->sum('amount');
        $totalExpenses = $user->expenses()->sum('amount');
        $remainingBalance = $totalIncome - $totalExpenses;

        //Budget Utilization
        $budgets = $user->budgets()->get();
        foreach ($budgets as $budget) {
            $budget->total_expenses = $user->expenses()
            ->where('category', $budget->category)
            ->whereMonth('date', date('m', strtotime($budget->month)))
            ->sum('amount'); // Expenses in the budget category
            $budget->remaining_budget = $budget->amount - $budget->total_expenses; // Remaining budget
        }

        return view('dashboard.index', compact(
        'totalIncome',
        'totalExpenses',
        'remainingBalance',
        'budgets'
    ));
    }
}
