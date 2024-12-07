<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your Budgets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Info Section -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <p class="text-gray-600 dark:text-gray-300">
                    Budgets help you plan and limit your spending for each category. Below, you can see how much you’ve
                    planned, how much you’ve spent, and the remaining budget. Red indicates overspending.
                </p>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('budgets.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-2"></i> {{ __('Add Budget') }}
                </a>
            </div>

            <!-- Filter Section -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <form method="GET" action="{{ route('budgets.index') }}">
                    <div class="flex flex-wrap items-end gap-4">
                        <!-- Category Filter -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-600 dark:text-gray-300">
                                {{ __('Filter by Category') }}
                            </label>
                            <select name="category" id="category"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">{{ __('All Categories') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Date Filter -->
                        <div>
                            <label for="month" class="block text-sm font-medium text-gray-600 dark:text-gray-300">
                                {{ __('Filter by Month') }}
                            </label>
                            <input type="month" name="month" id="month" value="{{ request('month') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <!-- Submit Button -->
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                            {{ __('Apply Filters') }}
                        </button>
                        <a href="{{ route('budgets.index') }}"
                           class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                            {{ __('Clear Filters') }}
                        </a>
                    </div>
                </form>
            </div>

            <!-- Budgets Table -->
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
    <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-200 mb-4">{{ __('Budget Details') }}</h3>
    <div class="hidden sm:block overflow-x-auto">
        <table class="w-full border-collapse rounded-lg overflow-hidden">
            <thead>
            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                <th class="px-4 py-2 text-left">{{ __('#') }}</th>
                <th class="px-4 py-2 text-left">{{ __('Category') }}</th>
                <th class="px-4 py-2 text-left">{{ __('Budget') }}</th>
                <th class="px-4 py-2 text-left">{{ __('Spent') }}</th>
                <th class="px-4 py-2 text-left">{{ __('Remaining') }}</th>
                <th class="px-4 py-2 text-left">{{ __('Progress') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($budgets as $index => $budget)
                <tr
                    class="hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer"
                    onclick="confirmAndNavigate('{{ route('budgets.edit', $budget->id) }}')"
                >
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $budget->category }}</td>
                    <td class="px-4 py-2">${{ number_format($budget->amount, 2) }}</td>
                    <td class="px-4 py-2">${{ number_format($budget->total_expenses, 2) }}</td>
                    <td class="px-4 py-2">
                        <span class="{{ $budget->remaining_budget < 0 ? 'text-red-500' : 'text-green-500' }}">
                            ${{ number_format($budget->remaining_budget, 2) }}
                        </span>
                    </td>
                    <td class="px-4 py-2">
                        <div class="relative w-full bg-gray-200 h-4 rounded">
                            <div
                                class="absolute top-0 left-0 h-4 {{ $budget->over_budget ? 'bg-red-500' : 'bg-blue-500' }} rounded"
                                style="width: {{ min(100, ($budget->total_expenses / $budget->amount) * 100) }}%;"
                            ></div>
                        </div>
                        <span class="text-xs">
                            {{ min(100, round(($budget->total_expenses / $budget->amount) * 100)) }}%
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">{{ __('No budgets found.') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="sm:hidden">
        @forelse ($budgets as $index => $budget)
            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg mb-4">
                <div><strong>{{ __('#') }}</strong>: {{ $index + 1 }}</div>
                <div><strong>{{ __('Category') }}</strong>: {{ $budget->category }}</div>
                <div><strong>{{ __('Budget') }}</strong>: ${{ number_format($budget->amount, 2) }}</div>
                <div><strong>{{ __('Spent') }}</strong>: ${{ number_format($budget->total_expenses, 2) }}</div>
                <div><strong>{{ __('Remaining') }}</strong>:
                    <span class="{{ $budget->remaining_budget < 0 ? 'text-red-500' : 'text-green-500' }}">
                        ${{ number_format($budget->remaining_budget, 2) }}
                    </span>
                </div>
                <div class="mt-2">
                    <button
                        onclick="confirmAndNavigate('{{ route('budgets.edit', $budget->id) }}')"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition"
                    >
                        {{ __('Edit') }}
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center py-4 text-gray-500">{{ __('No budgets found.') }}</div>
        @endforelse
    </div>
</div>

<!-- Add this JavaScript -->
<script>
    function confirmAndNavigate(url) {
        if (confirm('Are you sure you want to edit this budget?')) {
            window.location.href = url;
        }
    }
</script>


        </div>
    </div>
</x-app-layout>
