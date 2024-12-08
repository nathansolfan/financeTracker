<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Budget') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('budgets.store') }}">
                        @csrf

                        <!-- Category -->
                        <div class="mb-4">
                            <x-input-label for="category" :value="__('Category')" />
                            <x-text-input id="category" class="block mt-1 w-full" type="text" name="category" />
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <!-- Amount -->
                        <div class="mb-4">
                            <x-input-label for="amount" :value="__('Amount')" />
                            <x-text-input id="amount" class="block mt-1 w-full" type="number" step="0.01" name="amount" required />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <!-- Month -->
                        <div class="mb-4">
                            <x-input-label for="month" :value="__('Month')" />
                            <x-text-input id="month" class="block mt-1 w-full" type="date" name="month" required />
                            <x-input-error :messages="$errors->get('month')" class="mt-2" />
                        </div>

                        <label for="template" class="block text-sm font-medium text-gray-600 dark:text-gray-300">
                            {{ __('Template') }}
                        </label>
                        <select name="template" id="template" onchange="loadTemplate(this.value)" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">{{ __('Select Template') }}</option>
                            <option value="monthly">{{ __('Monthly Budget') }}</option>
                            <option value="travel">{{ __('Travel Budget') }}</option>
                        </select>


                        <!-- Submit -->
                        <div class="flex items-center justify-end">
                            <x-primary-button class="ml-4">
                                {{ __('Add Budget') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
