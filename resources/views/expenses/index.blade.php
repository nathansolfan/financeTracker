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
                                    {{-- <td class="px-4 py-2">{{ $expense->id }}</td> --}}
                                    <td class="px-4 py-2">{{ $index + 1 }}</td> <!-- Sequential numbering -->
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
</x-app-layout>
