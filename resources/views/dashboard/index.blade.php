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
                    <h3 class="text-lg font-semibold mb-4">{{ __('Manage Your Finances') }}</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('expenses.index') }}" class="text-blue-500 hover:underline">
                                {{ __('View Expenses') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('incomes.index') }}" class="text-blue-500 hover:underline">
                                {{ __('View Income') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('budgets.index') }}" class="text-blue-500 hover:underline">
                                {{ __('View Budgets') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('grocery.index') }}" class="text-blue-500 hover:underline">
                                {{ __('View Grocery List') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
