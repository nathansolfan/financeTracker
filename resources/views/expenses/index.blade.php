<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your Expenses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-50 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Add Expense Button -->
            <div class="flex justify-end">
                <a href="{{ route('expenses.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-2"></i> {{ __('Add Expense') }}
                </a>
            </div>

            <!-- Chart Section -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-4">{{ __('Expenses Chart') }}</h3>
                <canvas id="expensesChart" class="w-full h-64"></canvas>
            </div>

            <!-- Search Bar -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <form method="GET" action="{{ route('expenses.index') }}">
                    <div class="flex flex-wrap items-end gap-4">
                        <!-- Search Input -->
                        <div class="flex-1">
                            <label for="search" class="block text-sm font-medium text-gray-600 dark:text-gray-300">
                                {{ __('Search Expenses') }}
                            </label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                   placeholder="Search by description, category, or amount"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Clear Search Button -->
                        <a href="{{ route('expenses.index') }}"
                           class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                            {{ __('Clear Search') }}
                        </a>

                        <!-- Submit Button -->
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                            {{ __('Search') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Expenses Table -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-4">{{ __('Expense Details') }}</h3>
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full border-collapse rounded-lg overflow-hidden">
                        <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                            <th class="px-4 py-2 text-left">{{ __('#') }}</th>
                            <th class="px-4 py-2 text-left">{{ __('Amount') }}</th>
                            <th class="px-4 py-2 text-left">{{ __('Category') }}</th>
                            <th class="px-4 py-2 text-left">{{ __('Description') }}</th>
                            <th class="px-4 py-2 text-left">{{ __('Date') }}</th>
                            <th class="px-4 py-2 text-left">{{ __('Actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($expenses as $index => $expense)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">${{ number_format($expense->amount, 2) }}</td>
                                <td class="px-4 py-2">{{ $expense->category }}</td>
                                <td class="px-4 py-2">{{ $expense->description }}</td>
                                <td class="px-4 py-2">{{ $expense->date }}</td>
                                <td class="px-4 py-2">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('expenses.edit', $expense->id) }}"
                                           class="text-blue-600 hover:text-blue-800 transition">
                                            <i class="fas fa-edit"></i> {{ __('Edit') }}
                                        </a>
                                        <form method="POST" action="{{ route('expenses.destroy', $expense->id) }}"
                                              onsubmit="return confirm('Are you sure you want to delete this expense?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 transition">
                                                <i class="fas fa-trash"></i> {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-gray-500">{{ __('No expenses found.') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="sm:hidden">
                    @forelse ($expenses as $index => $expense)
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg mb-4">
                            <div><strong>{{ __('#') }}</strong>: {{ $index + 1 }}</div>
                            <div><strong>{{ __('Amount') }}</strong>: ${{ number_format($expense->amount, 2) }}</div>
                            <div><strong>{{ __('Category') }}</strong>: {{ $expense->category }}</div>
                            <div><strong>{{ __('Description') }}</strong>: {{ $expense->description }}</div>
                            <div><strong>{{ __('Date') }}</strong>: {{ $expense->date }}</div>
                            <div class="mt-2 flex space-x-2">
                                <a href="{{ route('expenses.edit', $expense->id) }}"
                                   class="text-blue-600 hover:text-blue-800 transition">
                                    <i class="fas fa-edit"></i> {{ __('Edit') }}
                                </a>
                                <form method="POST" action="{{ route('expenses.destroy', $expense->id) }}"
                                      onsubmit="return confirm('Are you sure you want to delete this expense?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition">
                                        <i class="fas fa-trash"></i> {{ __('Delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-gray-500">{{ __('No expenses found.') }}</div>
                    @endforelse
                </div>
            </div>


            <!-- Pagination -->
            <div class="mt-6">
                {{ $expenses->links() }}
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
                            datasets: [{
                                label: 'Expenses by Category',
                                data: data.datasets[0].data,
                                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'],
                                borderWidth: 1
                            }],
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { display: false },
                                title: { display: true, text: 'Expenses by Category' }
                            },
                            scales: { y: { beginAtZero: true } }
                        }
                    });
                })
                .catch(console.error);
        });
    </script>
</x-app-layout>
