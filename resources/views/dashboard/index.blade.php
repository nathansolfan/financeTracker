<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Financial Overview Section -->
                <div class="col-span-1 lg:col-span-3 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <h3 class="font-semibold text-lg mb-4">{{ __('Financial Overview') }}</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <!-- Total Income -->
                        <a href="{{ route('incomes.index') }}"
                           class="bg-green-100 dark:bg-green-800 p-4 rounded-md shadow flex items-center space-x-4 hover:bg-green-200 dark:hover:bg-green-700 transition">
                            <div>
                                <div class="text-green-700 dark:text-green-300 text-3xl font-bold">
                                    ${{ $totalIncome }}
                                </div>
                                <div class="text-gray-600 dark:text-gray-400">{{ __('Total Income') }}</div>
                            </div>
                        </a>
                        <!-- Total Expenses -->
                        <a href="{{ route('expenses.index') }}"
                           class="bg-red-100 dark:bg-red-800 p-4 rounded-md shadow flex items-center space-x-4 hover:bg-red-200 dark:hover:bg-red-700 transition">
                            <div>
                                <div class="text-red-700 dark:text-red-300 text-3xl font-bold">
                                    ${{ $totalExpenses }}
                                </div>
                                <div class="text-gray-600 dark:text-gray-400">{{ __('Total Expenses') }}</div>
                            </div>
                        </a>
                        <!-- Remaining Balance -->
                        <a href="{{ route('budgets.index') }}"
                           class="bg-blue-100 dark:bg-blue-800 p-4 rounded-md shadow flex items-center space-x-4 hover:bg-blue-200 dark:hover:bg-blue-700 transition">
                            <div>
                                <div class="text-blue-700 dark:text-blue-300 text-3xl font-bold">
                                    ${{ $remainingBalance }}
                                </div>
                                <div class="text-gray-600 dark:text-gray-400">{{ __('Remaining Balance') }}</div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Budget Utilization Section -->
                <div class="col-span-1 lg:col-span-3 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <h3 class="font-semibold text-lg mb-4">{{ __('Budget Utilization') }}</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse border border-gray-200 dark:border-gray-700">
                            <thead>
                                <tr class="bg-gray-200 dark:bg-gray-700 text-left text-sm font-semibold text-gray-800 dark:text-gray-200">
                                    <th class="px-2 md:px-4 py-2">{{ __('Category') }}</th>
                                    <th class="px-2 md:px-4 py-2">{{ __('Total Budget') }}</th>
                                    <th class="px-2 md:px-4 py-2">{{ __('Spent') }}</th>
                                    <th class="px-2 md:px-4 py-2">{{ __('Remaining') }}</th>
                                    <th class="px-2 md:px-4 py-2">{{ __('Progress') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($budgetUtilization as $budget)
                                    <tr class="border-t border-gray-300 dark:border-gray-600">
                                        <td class="px-2 md:px-4 py-2 text-sm">{{ $budget->category }}</td>
                                        <td class="px-2 md:px-4 py-2 text-sm">${{ $budget->total_budget }}</td>
                                        <td class="px-2 md:px-4 py-2 text-sm">${{ $budget->used }}</td>
                                        <td class="px-2 md:px-4 py-2 text-sm">${{ $budget->remaining }}</td>
                                        <td class="px-2 md:px-4 py-2 text-sm">
                                            <div class="relative w-full bg-gray-200 dark:bg-gray-700 rounded-md h-4">
                                                <div
                                                    class="absolute top-0 left-0 h-4 bg-blue-500 rounded-md"
                                                    style="width: {{ min(100, ($budget->used / $budget->total_budget) * 100) }}%;"
                                                ></div>
                                            </div>
                                            <span class="text-xs">{{ min(100, round(($budget->used / $budget->total_budget) * 100)) }}%</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">{{ __('No budgets found.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-span-1 lg:col-span-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('expenses.index') }}" class="p-2 sm:p-4 rounded-md shadow text-center hover:bg-gray-300 dark:hover:bg-gray-600">
                        <div class="text-blue-500 mb-2">
                            <i class="fas fa-wallet text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold">{{ __('Expenses') }}</h4>
                    </a>
                    <a href="{{ route('incomes.index') }}" class="p-2 sm:p-4 rounded-md shadow text-center hover:bg-gray-300 dark:hover:bg-gray-600">
                        <div class="text-green-500 mb-2">
                            <i class="fas fa-money-bill-wave text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold">{{ __('Incomes') }}</h4>
                    </a>
                    <a href="{{ route('budgets.index') }}" class="p-2 sm:p-4 rounded-md shadow text-center hover:bg-gray-300 dark:hover:bg-gray-600">
                        <div class="text-purple-500 mb-2">
                            <i class="fas fa-chart-pie text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold">{{ __('Budgets') }}</h4>
                    </a>
                    <a href="{{ route('grocery.index') }}" class="p-2 sm:p-4 rounded-md shadow text-center hover:bg-gray-300 dark:hover:bg-gray-600">
                        <div class="text-yellow-500 mb-2">
                            <i class="fas fa-shopping-cart text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold">{{ __('Grocery List') }}</h4>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
