<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your Budgets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="mb-4 text-green-500">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Add Expense Button -->
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('budgets.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 focus:ring focus:ring-blue-300 focus:outline-none active:bg-blue-700 disabled:opacity-25 transition">
                            {{ __('Add Budget') }}
                        </a>
                    </div>

                    <form method="GET" action="{{ route('expenses.index') }}" class="mb-6">
                        <div class="flex flex-wrap items-end gap-4">

                            <!-- Search Input -->
                            <div class="flex-1">
                                <label for="search" class="block text-sm font-medium">{{ __('Search Expenses') }}</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Search by Category, Amount or Date"
                                class="w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Clear Search Button -->
                            <a href="{{ route('expenses.index') }}"
                            class="inline-flex items-center px-2 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 focus:ring focus:ring-gray-300 focus:outline-none active:bg-gray-700 disabled:opacity-25 transition">
                            {{ __('Clear Search') }}
                            </a>

                            <!-- Submit Button -->
                            <button type="submit" class="inline-flex items-center px-2 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 focus:ring focus:ring-blue-300 focus:outline-none active:bg-blue-700 disabled:opacity-25 transition">
                                {{ __('Search') }}
                            </button>
                        </div>
                    </form>

                    <!-- Budgets Table -->
                    <table class="min-w-full border-collapse border border-gray-200 dark:border-gray-700">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700">
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">#</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">Category</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">Budget</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">Spent</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">Remaining</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($budgets as $budget)
                                <tr class="border-t border-gray-300 dark:border-gray-600">
                                    <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2">{{ $budget->category }}</td>
                                    <td class="px-4 py-2">{{ $budget->amount }}</td>
                                    <td class="px-4 py-2">{{ $budget->total_expenses }}</td>
                                    <td class="px-4 py-2">{{ $budget->remaining_budget }}</td>
                                    <td class="px-4 py-2">
                                        <div class="relative w-full bg-gray-200 rounded-md h-4">
                                            <div
                                                class="absolute top-0 left-0 h-4 bg-blue-500 rounded-md"
                                                style="width: {{ min(100, ($budget->total_expenses / $budget->amount) * 100) }}%;"
                                            ></div>
                                        </div>
                                        <span class="text-xs">{{ min(100, round(($budget->total_expenses / $budget->amount) * 100)) }}%</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">No budgets found.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $budgets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
