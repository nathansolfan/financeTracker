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

                    <!-- Budgets Table -->
                    <table class="min-w-full border-collapse border border-gray-200 dark:border-gray-700">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700">
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ __('#') }}</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ __('Category') }}</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ __('Amount') }}</th>
                                <th class="px-4 py-2 border border-gray-300 dark:border-gray-600">{{ __('Month') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($budgets as $budget)
                                <tr class="border-t border-gray-300 dark:border-gray-600">
                                    <td class="px-4 py-2">{{ $budget->id }}</td>
                                    <td class="px-4 py-2">{{ $budget->category }}</td>
                                    <td class="px-4 py-2">{{ $budget->amount }}</td>
                                    <td class="px-4 py-2">{{ $budget->month }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">{{ __('No budgets found.') }}</td>
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
