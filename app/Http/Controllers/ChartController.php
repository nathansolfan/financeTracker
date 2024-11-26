<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
    public function expenseChart()
{
    $user = Auth::user();

    // Fetch grouped expenses
    $expenses = $user->expenses()
        ->selectRaw('category, SUM(amount) as total')
        ->groupBy('category')
        ->pluck('total', 'category');

    // Prepare data for Chart.js
    $chartData = [
        'labels' => $expenses->keys()->toArray(), // Categories (e.g., Rent, Insurance)
        'datasets' => [
            [
                'label' => 'Expenses by Category',
                'data' => $expenses->values()->toArray(), // Expense totals
                'backgroundColor' => ['#FF5733', '#33FF57', '#3357FF', '#FFC300', '#C70039'], // Colors for each category
            ],
        ],
    ];

    return response()->json($chartData);
}



    /**
     * Generate colors dynamically based on category.
     */
    private function getColor($category)
    {
        $colors = [
            'Rent' => '#FF5733', // Red
            'Insurance' => '#33FF57', // Green
            'Groceries' => '#3357FF', // Blue
            'Utilities' => '#FFC300', // Yellow
            'Other' => '#C70039', // Dark Red
        ];

        return $colors[$category] ?? '#999999'; // Default color (gray) for unknown categories
    }
}
