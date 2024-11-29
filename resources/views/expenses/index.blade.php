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
                    <div class="flex justify-end mb-6">
                        <a href="{{ route('expenses.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 focus:ring focus:ring-blue-300 focus:outline-none active:bg-blue-700 disabled:opacity-25 transition">
                            <i class="fas fa-plus mr-2"></i> {{ __('Add Expense') }}
                        </a>
                    </div>

                    <!-- Chart Section -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-4">{{ __('Expenses Chart') }}</h3>
                        <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-md shadow">
                            <canvas id="expensesChart" class="w-full h-64"></canvas>
                        </div>
                    </div>

                    <!-- Search Bar -->
                    <form method="GET" action="{{ route('expenses.index') }}" class="mb-6">
                        <div class="flex flex-wrap items-end gap-4">
                            <!-- Search Input -->
                            <div class="flex-1">
                                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Search Expenses') }}</label>
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
                    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-4">{{ __('Expense Details') }}</h3>
                    <table class="min-w-full border-collapse border border-gray-200 dark:border-gray-700 rounded-lg shadow-md">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                <th class="px-4 py-2 border">{{ __('#') }}</th>
                                <th class="px-4 py-2 border">{{ __('Amount') }}</th>
                                <th class="px-4 py-2 border">{{ __('Category') }}</th>
                                <th class="px-4 py-2 border">{{ __('Description') }}</th>
                                <th class="px-4 py-2 border">{{ __('Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($expenses as $index => $expense)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border">${{ number_format($expense->amount, 2) }}</td>
                                    <td class="px-4 py-2 border">{{ $expense->category }}</td>
                                    <td class="px-4 py-2 border">{{ $expense->description }}</td>
                                    <td class="px-4 py-2 border">{{ $expense->date }}</td>
                                    <td class="px-4 py-2 border">
                                        <div class="flex space-x-2">
                                            <!-- Edit Button -->
                                            <a href="{{ route('expenses.edit', $expense->id) }}"
                                               class="text-blue-500 hover:text-blue-700 underline">{{ __('Edit') }}</a>

                                            <!-- Delete Button -->
                                            <form method="POST" action="{{ route('expenses.destroy', $expense->id) }}" onsubmit="return confirm('Are you sure you want to delete this expense?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 underline">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>

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
                            labels: data.labels,
                            datasets: [
                                {
                                    label: 'Expenses by Category',
                                    data: data.datasets[0].data,
                                    backgroundColor: [
                                        '#FF6384',
                                        '#36A2EB',
                                        '#FFCE56',
                                        '#4BC0C0',
                                        '#9966FF',
                                        '#FF9F40',
                                    ],
                                    borderColor: '#ffffff',
                                    borderWidth: 1,
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false,
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function (tooltipItem) {
                                            return `$${tooltipItem.raw}`;
                                        },
                                    },
                                },
                                title: {
                                    display: true,
                                    text: 'Expenses by Category',
                                    font: { size: 14 },
                                },
                            },
                            scales: {
                                x: {
                                    beginAtZero: true,
                                },
                                y: {
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
