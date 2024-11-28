<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Financial Overview Section -->
                    <h3 class="font-semibold text-lg mb-4">{{ __('Financial Overview') }}</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                        <!-- Total Income -->
                        <div class="bg-green-100 dark:bg-green-800 p-4 rounded-md shadow">
                            <h4 class="text-lg font-semibold">{{ __('Total Income') }}</h4>
                            <p class="text-2xl font-bold">${{ $totalIncome }}</p>
                        </div>

                        <!-- Total Expenses -->
                        <div class="bg-red-100 dark:bg-red-800 p-4 rounded-md shadow">
                            <h4 class="text-lg font-semibold">{{ __('Total Expenses') }}</h4>
                            <p class="text-2xl font-bold">${{ $totalExpenses }}</p>
                        </div>

                        <!-- Remaining Balance -->
                        <div class="bg-blue-100 dark:bg-blue-800 p-4 rounded-md shadow">
                            <h4 class="text-lg font-semibold">{{ __('Remaining Balance') }}</h4>
                            <p class="text-2xl font-bold">${{ $remainingBalance }}</p>
                        </div>
                    </div>

                    <!-- Budget Utilization Section -->
                    <h3 class="font-semibold text-lg mb-4">{{ __('Budget Utilization') }}</h3>
                    <table class="min-w-full border-collapse border border-gray-200 dark:border-gray-700">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700">
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ __('Category') }}</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ __('Total Budget') }}</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ __('Spent') }}</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ __('Remaining') }}</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ __('Progress') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($budgetUtilization as $budget)
                                <tr class="border-t border-gray-300 dark:border-gray-600">
                                    <td class="px-4 py-2">{{ $budget->category }}</td>
                                    <td class="px-4 py-2">${{ $budget->total_budget }}</td>
                                    <td class="px-4 py-2">${{ $budget->used }}</td>
                                    <td class="px-4 py-2">${{ $budget->remaining }}</td>
                                    <td class="px-4 py-2">
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
        </div>
    </div>
</x-app-layout>
