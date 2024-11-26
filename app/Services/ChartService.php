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

        // Create Chart
        $chart = new Chart;
        $chart->labels($expenses->keys()); // Categories
        $chart->dataset('Expenses by Category', 'bar', $expenses->values())
            ->backgroundColor(['#FF5733', '#33FF57', '#3357FF', '#FFC300', '#C70039']);

        return $chart;
    }
}
