<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Expense') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Edit Expense Form -->
                    <form method="POST" action="{{ route('incomes.update', $income->id) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Amount -->
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Amount') }}</label>
                            <input type="number" name="amount" id="amount" value="{{ old('amount', $income->amount) }}"step="0.01"
                            class="w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('amount')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Source -->
                        <div class="mb-4">
                            <label for="source" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Source') }}</label>
                            <input type="text" name="source" id="source" value="{{ old('source', $income->source) }}"
                                   class="w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('source')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Date -->
                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Date') }}</label>
                            <input type="date" name="date" id="date" value="{{ old('date', $income->date) }}"
                                   class="w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Date -->
                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Date') }}</label>
                            <input type="date" name="date" id="date" value="{{ old('date', $income->date) }}"
                                   class="w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            @error('date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:bg-blue-600 focus:ring focus:ring-blue-300 focus:outline-none active:bg-blue-700 disabled:opacity-25 transition">
                                {{ __('Update Expense') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
