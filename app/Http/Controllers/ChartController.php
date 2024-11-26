<?php

namespace App\Http\Controllers;

use App\Services\ChartService;
use Illuminate\Support\Facades\Auth;

class ChartController extends Controller
{
    protected $chartService;

    public function __construct(ChartService $chartService)
    {
        $this->chartService = $chartService;
    }

    public function expenseChart()
    {
        $user = Auth::user();
        $chart = $this->chartService->createExpenseChart($user);

        return response()->json([
            'labels' => $chart->labels,
            'datasets' => $chart->datasets,
        ]);
    }
}
