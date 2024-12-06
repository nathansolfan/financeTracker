<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Calculate Totals
        $totalIncome = $user->incomes()->sum('amount');
        $totalExpenses = $user->expenses()->sum('amount');
        $remainingBalance = $totalIncome - $totalExpenses;

        // Budget Utilization
        $budgetUtilization = $user->budgets()->get()->map(function ($budget) use ($user) {
            $totalExpenses = $user->expenses()
                ->where('category', $budget->category)
                ->whereMonth('date', date('m', strtotime($budget->month)))
                ->sum('amount');

            return (object) [
                'category' => $budget->category,
                'total_budget' => $budget->amount,
                'used' => $totalExpenses,
                'remaining' => $budget->amount - $totalExpenses,
            ];
        });

        // Categories nearing or exceeding budgets
        $overBudgetCategories = $user->budgets()
            ->get()
            ->filter(function ($budget) use ($user) {
                $totalExpenses = $user->expenses()
                    ->where('category', $budget->category)
                    ->whereMonth('date', date('m', strtotime($budget->month)))
                    ->sum('amount');
                return $totalExpenses > $budget->amount;
            })
            ->pluck('category');

        return view('dashboard.index', compact(
            'totalIncome',
            'totalExpenses',
            'remainingBalance',
            'budgetUtilization',
            'overBudgetCategories'
        ));
    }
}
