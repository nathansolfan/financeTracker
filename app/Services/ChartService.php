<?php

namespace App\Services;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class ChartService
{
    public function createExpenseChart($user)
{
    // Fetch grouped expenses
    $expenses = $user->expenses()
        ->selectRaw('category, sum(amount) as total')
        ->groupBy('category')
        ->pluck('total', 'category');

    // Return data in a format compatible with Chart.js
    return [
        'labels' => $expenses->keys()->toArray(), // Categories
        'datasets' => [
            [
                'label' => 'Expenses by Category', // Single label
                'data' => $expenses->values()->toArray(), // Expense totals
                'backgroundColor' => ['#FF5733', '#33FF57', '#3357FF', '#FFC300', '#C70039'], // Colors for each category
            ],
        ],
    ];

}
}
