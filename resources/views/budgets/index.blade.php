<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your Budgets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Summary Section -->
            <div class="grid grid-cols-3 gap-4">
                <div class="p-4 bg-green-100 rounded-md shadow">
                    <h3 class="font-bold text-lg text-green-700">{{ __('Total Budget') }}</h3>
                    <p class="text-2xl">${{ number_format($totalBudget, 2) }}</p>
                </div>
                <div class="p-4 bg-yellow-100 rounded-md shadow">
                    <h3 class="font-bold text-lg text-yellow-700">{{ __('Total Spent') }}</h3>
                    <p class="text-2xl">${{ number_format($totalSpent, 2) }}</p>
                </div>
                <div class="p-4 bg-blue-100 rounded-md shadow">
                    <h3 class="font-bold text-lg text-blue-700">{{ __('Remaining Budget') }}</h3>
                    <p class="text-2xl">${{ number_format($remainingBudget, 2) }}</p>
                </div>
            </div>

            <!-- Warning for Over-Budget Categories -->
            @if($budgets->where('over_budget', true)->isNotEmpty())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded shadow">
                    {{ __('Warning: Some categories are over budget!') }}
                </div>
            @endif

            <!-- Budgets Table -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700">
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Category</th>
                            <th class="px-4 py-2">Budget</th>
                            <th class="px-4 py-2">Spent</th>
                            <th class="px-4 py-2">Remaining</th>
                            <th class="px-4 py-2">Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($budgets as $budget)
                            <tr class="{{ $budget->over_budget ? 'bg-red-100' : '' }}">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $budget->category }}</td>
                                <td class="px-4 py-2">${{ number_format($budget->amount, 2) }}</td>
                                <td class="px-4 py-2">${{ number_format($budget->total_expenses, 2) }}</td>
                                <td class="px-4 py-2">
                                    <span class="{{ $budget->remaining_budget < 0 ? 'text-red-500' : 'text-green-500' }}">
                                        ${{ number_format($budget->remaining_budget, 2) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    <div class="flex space-x-2">
                                        <!-- Edit Link -->
                                        <a href="{{ route('budgets.edit', $budget->id) }}" class="text-blue-600 hover:text-blue-800">
                                            Edit
                                        </a>

                                        <!-- Delete Form -->
                                        <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this budget?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">{{ __('No budgets found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>


            <!-- Chart Section -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200">{{ __('Expenses by Category') }}</h3>
                <canvas id="categoryChart" class="w-full h-64"></canvas>
            </div>

        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('categoryChart').getContext('2d');
const data = {
    labels: @json(array_keys($expensesByCategory->toArray())), // Categories
    datasets: [{
        label: 'Expenses by Category',
        data: @json(array_values($expensesByCategory->toArray())), // Amounts
        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
    }]
};

new Chart(ctx, {
    type: 'bar',
    data: data,
    options: {
        responsive: true,
        plugins: {
            legend: { display: true },
            title: { display: true, text: 'Expenses by Category' }
        },
        scales: { y: { beginAtZero: true } }
    }
});

    </script>
</x-app-layout>
