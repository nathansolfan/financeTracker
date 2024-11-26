<?php

use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\GroceryListController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function ()  {
    // Expense Routes
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');

    // Income Route
    Route::get('/incomes', [IncomeController::class, 'index'])->name('incomes.index');
    Route::get('/incomes/create', [IncomeController::class, 'create'])->name('incomes.create');
    Route::post('/incomes', [IncomeController::class, 'store'])->name('incomes.store');

    // Budget Route
    Route::get('/budgets', [BudgetController::class, 'index'])->name('budgets.index');
    Route::get('/budgets/create', [BudgetController::class, 'create'])->name('budgets.create');
    Route::post('/budgets', [BudgetController::class, 'store'])->name('budgets.store');

    // Grocery Route
    Route::get('/grocery', [GroceryListController::class, 'index'])->name('grocery.index');
    Route::get('/grocery/create', [GroceryListController::class, 'create'])->name('grocery.create');
    Route::post('/grocery', [GroceryListController::class, 'store'])->name('grocery.store');
});

// CHART
Route::get('/chart/expenses', [ChartController::class, 'expenseChart'])->name('chart.expense');

require __DIR__.'/auth.php';
