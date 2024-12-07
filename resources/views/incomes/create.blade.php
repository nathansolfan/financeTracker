<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Income') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('incomes.store') }}">
                        @csrf

                        <!-- Amount -->
                        <div class="mb-4">
                            <x-input-label for="amount" :value="__('Amount')" />
                            <x-text-input id="amount" class="block mt-1 w-full" type="number" step="0.01" name="amount" required autofocus />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <!-- Source -->
                        <div class="mb-4">
                            <x-input-label for="source" :value="__('Source')" />
                            <x-text-input id="source" class="block mt-1 w-full" type="text" name="source" required />
                            <x-input-error :messages="$errors->get('source')" class="mt-2" />
                        </div>

                        <!-- Date -->
                        <div class="mb-4">
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" required />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>

                        <label for="recurring" class="block text-sm font-medium text-gray-600 dark:text-gray-300">
                            <input type="checkbox" name="recurring" id="recurring" value="1" {{ old('recurring') ? 'checked' : '' }}>
                            {{ __('Make Recurring') }}
                        </label>


                        <!-- Submit -->
                        <div class="flex items-center justify-end">
                            <x-primary-button class="ml-4">
                                {{ __('Add Income') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
