<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Budget') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('budgets.update', $budget->id) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Category -->
                        <div class="mb-4">
                            <x-input-label for="category" :value="__('Category')" />
                            <x-text-input id="category" class="block mt-1 w-full" type="text" name="category" value="{{ $budget->category }}" />
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <!-- Amount -->
                        <div class="mb-4">
                            <x-input-label for="amount" :value="__('Amount')" />
                            <x-text-input id="amount" class="block mt-1 w-full" type="number" step="0.01" name="amount" value="{{ $budget->amount }}" required />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <!-- Month -->
                        <div class="mb-4">
                            <x-input-label for="month" :value="__('Month')" />
                            <x-text-input id="month" class="block mt-1 w-full" type="date" name="month" value="{{ $budget->month }}" required />
                            <x-input-error :messages="$errors->get('month')" class="mt-2" />
                        </div>

                        <!-- Submit -->
                        <div class="flex items-center justify-end">
                            <x-primary-button class="ml-4">
                                {{ __('Update Budget') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
