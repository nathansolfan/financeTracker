<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your Expenses') }}
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
                        <a href="{{ route('expenses.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 focus:ring focus:ring-blue-300 focus:outline-none active:bg-blue-700 disabled:opacity-25 transition">
                            {{ __('Add Expense') }}
                        </a>
                    </div>


                    <!-- Chart -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-4">{{ __('Expenses Chart') }}</h3>
                        <canvas id="expensesChart" class="w-full h-64"></canvas>
                    </div>

                    <!-- Search Bar -->
                    <form method="GET" action="{{ route('expenses.index') }}" class="mb-6">
                        <div class="flex flex-wrap items-end gap-4">

                            <!-- Search Input -->
                            <div class="flex-1">
                                <label for="search" class="block text-sm font-medium">{{ __('Search Expenses') }}</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                placeholder="Search by description, category, or amount"
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


                    <!-- Expenses Table -->
                    <table class="min-w-full border-collapse border border-gray-200 dark:border-gray-700">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700">
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ __('#') }}</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ __('Amount') }}</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ __('Category') }}</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ __('Description') }}</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ __('Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($expenses as $index => $expense)
                                <tr class="border-t border-gray-300 dark:border-gray-600">
                                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2">{{ $expense->amount }}</td>
                                    <td class="px-4 py-2">{{ $expense->category }}</td>
                                    <td class="px-4 py-2">{{ $expense->description }}</td>
                                    <td class="px-4 py-2">{{ $expense->date }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">{{ __('No expenses found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $expenses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    fetch('{{ route('chart.expense') }}')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('expensesChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels, // X-axis labels (categories)
                    datasets: [
                        {
                            label: 'Expenses by Category', // Single dataset label
                            data: data.datasets[0].data, // Data for each category
                            backgroundColor: data.datasets[0].backgroundColor, // Colors for each category
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false, // Hide the legend if there's only one dataset
                        },
                        title: {
                            display: true,
                            text: 'Expenses by Category',
                        },
                    },
                    scales: {
                        x: {
                            stacked: false, // Disable stacking
                        },
                        y: {
                            stacked: false, // Disable stacking
                            beginAtZero: true,
                        },
                    },
                },
            });
        })
        .catch(error => console.error('Error fetching chart data:', error));
});



    </script>
</x-app-layout>
